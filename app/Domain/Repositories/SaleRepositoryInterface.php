<?php

namespace Domain\Repositories;

use Domain\Entities\Sale;

/**
 * Interface for the sale repository.
 */
interface SaleRepositoryInterface
{
    /**
     * @param Sale $sale
     * @return Sale
     */
    public function save(Sale $sale): Sale;

    /**
     * @param int $sellerId
     * @return array
     */
    public function findBySellerId(int $sellerId): array;
}
