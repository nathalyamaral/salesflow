<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterSellerRequest;
use App\Http\Resources\SellerResource;
use Application\UseCases\RegisterSellerUseCase;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

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
