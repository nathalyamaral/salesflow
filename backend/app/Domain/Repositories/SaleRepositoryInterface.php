<?php

namespace Domain\Repositories;

use Carbon\Carbon;
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
     * @param Carbon|null $date
     * @return array
     */
    public function findBySellerId(int $sellerId, ?Carbon $date = null): array;
}
