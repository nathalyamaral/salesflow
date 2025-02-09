<?php

namespace Application\UseCases;

use Domain\Repositories\SaleRepositoryInterface;
use Domain\Repositories\SellerRepositoryInterface;
use Domain\Entities\Sale;
use Domain\Entities\Seller;

/**
 * Use case to register a sale.
 */
class RegisterSaleUseCase
{
    public function __construct(
        private readonly SaleRepositoryInterface $saleRepository,
        private readonly SellerRepositoryInterface $sellerRepository
    ) {
    }

    /**
     * Registers a sale made by a seller.
     *
     * @param integer $sellerId
     * @param float $amount
     *
     * @throws \Exception If the seller is not found.
     * @return Sale
     */
    public function execute(string $sellerId, float $amount): Sale
    {
        $seller = $this->sellerRepository->findById($sellerId);

        if (!$seller) {
            throw new \Exception("Seller not found");
        }

        $sale = new Sale(0, $seller, $amount, $amount * 0.085, new \DateTime());
        return $this->saleRepository->save($sale);
    }
}
