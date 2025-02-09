<?php

namespace Infrastructure\Persistence;

use App\Models\Sale as SaleModel;
use App\Models\Seller as SellerModel;
use Domain\Entities\Sale;
use Domain\Entities\Seller;
use Carbon\Carbon;
use Domain\Repositories\SaleRepositoryInterface;

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
     * @param Carbon|null $date
     * @return Sale[]
     */
    public function findBySellerId(int $sellerId, ?Carbon $date = null): array
    {
        return SaleModel::where('seller_id', $sellerId)
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('date', $date->toDateString());
            })
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
