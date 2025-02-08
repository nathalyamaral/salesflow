<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterSaleRequest;
use App\Http\Resources\SaleResource;
use App\Jobs\ProcessSaleJob;
use Application\UseCases\RegisterSaleUseCase;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


/**
 * Controller for managing sales.
 */
class SaleController extends Controller
{
    public function __construct(private readonly RegisterSaleUseCase $registerSaleUseCase)
    {
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
            $request->validated()['seller_email'],
            $request->validated()['amount']
        );

        ProcessSaleJob::dispatch($sale);

        return response()->json(new SaleResource($sale), Response::HTTP_CREATED);
    }
}
