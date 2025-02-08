<?php

namespace Domain\Repositories;

use Domain\Entities\Seller;

/**
 * Interface for the seller repository.
 */
interface SellerRepositoryInterface
{
    /**
     * @param Seller $seller
     * @return Seller
     */
    public function save(Seller $seller): Seller;

    /**
     * @param string $email
     * @return Seller|null
     */
    public function findByEmail(string $email): ?Seller;
}
