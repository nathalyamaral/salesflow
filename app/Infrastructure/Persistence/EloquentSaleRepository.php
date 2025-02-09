<?php

namespace Infrastructure\Persistence;

use Domain\Entities\Sale;
use Domain\Entities\Seller;
use Domain\Repositories\SaleRepositoryInterface;
use App\Models\Sale as SaleModel;

class EloquentSaleRepository implements SaleRepositoryInterface
{
    /**
     * @param Sale $sale
     * @return Sale
     */
    public function save(Sale $sale): Sale
    {

        $saleModel = SaleModel::create([
            'seller_id' => $sale->getSeller()->getId(),
            'amount' => $sale->getAmount(),
            'commission' => $sale->getCommission(),
            'date' => $sale->getDate(),
        ]);

        return new Sale(
            id: $saleModel->id,
            seller: $sale->getSeller(),
            amount: $sale->getAmount(),
            commission: $sale->getCommission(),
            date: $sale->getDate()
        );
    }

    /**
     * Return all sale by seller id.
     *
     * @param int $sellerId
     * @return Sale[]
     */
    public function findBySellerId(int $sellerId): array
    {
        return SaleModel::where('seller_id', $sellerId)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($sale) {
                return new Sale(
                    id: $sale->id,
                    seller: new Seller(
                        id: $sale->seller_id,
                        name: $sale->seller->name,
                        email: $sale->seller->email
                    ),
                    amount: $sale->amount,
                    commission: $sale->commission,
                    date: $sale->date
                );
            })
            ->toArray();
    }
}
