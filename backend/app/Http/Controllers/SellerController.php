<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterSellerRequest;
use App\Http\Resources\SellerResource;
use Application\UseCases\RegisterSellerUseCase;
use Domain\Repositories\SellerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\PathItem(path="/api")
 */
class SellerController extends Controller
{
    /**
     * @param RegisterSellerUseCase $registerSellerUseCase
     */
    public function __construct(
        private readonly RegisterSellerUseCase $registerSellerUseCase,
        private readonly SellerRepositoryInterface $sellerRepository
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/sellers",
     *     summary="Lista todos os vendedores",
     *     tags={"Sellers"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de vendedores retornada com sucesso"
     *     )
     * )
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $sellers = $this->sellerRepository->findAll();
        return response()->json(SellerResource::collection($sellers));
    }

    /**
     * @OA\Post(
     *     path="/api/sellers",
     *     summary="Cadastra um novo vendedor",
     *     tags={"Sellers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email"},
     *             @OA\Property(property="name", type="string", example="Fulano de Tal"),
     *             @OA\Property(property="email", type="string", format="email", example="fulano@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Vendedor cadastrado com sucesso"
     *     )
     * )
     * @param RegisterSellerRequest $request
     * @return JsonResponse
     */

    public function store(RegisterSellerRequest $request): JsonResponse
    {
        $seller = $this->registerSellerUseCase->execute(
            $request->validated()['name'],
            $request->validated()['email']
        );

        return response()->json(new SellerResource($seller), Response::HTTP_CREATED);
    }
}
