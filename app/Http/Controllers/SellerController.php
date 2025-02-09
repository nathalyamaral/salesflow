<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterSellerRequest;
use App\Http\Resources\SellerResource;
use Application\UseCases\RegisterSellerUseCase;
use Domain\Repositories\SellerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for managing sellers.
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
     * Get all sellers
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $sellers = $this->sellerRepository->findAll();
        return response()->json(SellerResource::collection($sellers));
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
