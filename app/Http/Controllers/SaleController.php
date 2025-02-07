<?php

namespace App\Http\Controllers;

use Application\UseCases\RegisterSaleUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'seller_email' => 'required|email|exists:sellers,email',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $sale = $this->registerSaleUseCase->execute($validated['seller_email'], $validated['amount']);

        return response()->json($sale, Response::HTTP_CREATED);
    }
}
