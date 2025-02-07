<?php

namespace App\Http\Controllers;

use Application\UseCases\RegisterSellerUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for managing sellers.
 */
class SellerController extends Controller
{
    /**
     * @param RegisterSellerUseCase $registerSellerUseCase
     */
    public function __construct(private readonly RegisterSellerUseCase $registerSellerUseCase)
    {
    }

    /**
     * Registers a new seller.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sellers,email',
        ]);

        $seller = $this->registerSellerUseCase->execute($validated['name'], $validated['email']);

        return response()->json($seller, Response::HTTP_CREATED);
    }
}
