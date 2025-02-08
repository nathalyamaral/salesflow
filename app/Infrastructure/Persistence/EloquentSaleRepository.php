<?php

namespace Infrastructure\Persistence;

use Domain\Entities\Sale;
use Domain\Repositories\SaleRepositoryInterface;

/**
 * Implementação do repositório de vendas utilizando Eloquent.
 */
class EloquentSaleRepository implements SaleRepositoryInterface
{
    /**
     * @param Sale $sale
     * @return Sale
     */
    public function save(Sale $sale): Sale
    {
        return $sale;
    }

    /**
     * @param int $sellerId
     * @return array
     */
    public function findBySellerId(int $sellerId): array
    {
        return [];
    }
}
