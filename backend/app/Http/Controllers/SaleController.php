<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterSaleRequest;
use App\Http\Resources\SaleResource;
use App\Jobs\ProcessSaleJob;
use Application\UseCases\RegisterSaleUseCase;
use Carbon\Carbon;
use Domain\Repositories\SaleRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *      title="SalesFlow API",
 *      version="1.0.0",
 *      description="Documentação da API de gerenciamento de vendas"
 * )
 * @OA\PathItem(path="/api")
 *
 * @OA\Tag(
 *     name="Sales",
 *     description="Gerenciamento de vendas"
 * )
 */
class SaleController extends Controller
{
    public function __construct(
        private readonly RegisterSaleUseCase $registerSaleUseCase,
        private readonly SaleRepositoryInterface $saleRepository
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/sales/{sellerId}?date={YYYY-MM-DD}",
     *     summary="Lista as vendas de um vendedor filtradas por data",
     *     tags={"Sales"},
     *     @OA\Parameter(
     *         name="sellerId",
     *         in="path",
     *         required=true,
     *         description="ID do vendedor",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         required=false,
     *         description="Data para filtrar as vendas (YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de vendas filtrada por data retornada com sucesso"
     *     )
     * )
     * @param int $sellerId
     * @param Request
     * @return JsonResponse
     */
    public function listBySeller(int $sellerId, Request $request): JsonResponse
    {
        $date = $request->query('date');
        $carbonDate = $date ? Carbon::parse($date) : null;

        $sales = $this->saleRepository->findBySellerId($sellerId, $carbonDate);

        if (empty($sales)) {
            return response()->json(['message' => 'No sales found for this seller'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(SaleResource::collection($sales));
    }

    /**
     * @OA\Post(
     *     path="/api/sales",
     *     summary="Cadastra uma nova venda",
     *     tags={"Sales"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"seller_id", "amount"},
     *             @OA\Property(property="seller_id", type="integer", example=1),
     *             @OA\Property(property="amount", type="number", format="float", example=500.75)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Venda cadastrada com sucesso"
     *     )
     * )
     *
     * @param RegisterSaleRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(RegisterSaleRequest $request): JsonResponse
    {
        $sale = $this->registerSaleUseCase->execute(
            $request->validated()['sellerId'],
            $request->validated()['amount']
        );

        ProcessSaleJob::dispatch($sale);

        return response()->json(new SaleResource($sale), Response::HTTP_CREATED);
    }
}
