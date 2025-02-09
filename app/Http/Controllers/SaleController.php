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
 * Controller for managing sales.
 */
class SaleController extends Controller
{
    public function __construct(
        private readonly RegisterSaleUseCase $registerSaleUseCase,
        private readonly SaleRepositoryInterface $saleRepository
    ) {
    }

    /**
     * Get sales by seller id
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
     * Registers a new sale.
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
