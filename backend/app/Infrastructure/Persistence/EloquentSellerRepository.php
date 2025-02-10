<?php

namespace Infrastructure\Persistence;

use Domain\Entities\Seller;
use App\Models\Seller as SellerModel;
use Domain\Repositories\SellerRepositoryInterface;

class EloquentSellerRepository implements SellerRepositoryInterface
{
    /**
     * @param Seller $seller
     * @return Seller
     */
    public function save(Seller $seller): Seller
    {
        $sellerModel = SellerModel::updateOrCreate(
            ['id' => $seller->getId()],
            ['name' => $seller->getName(), 'email' => $seller->getEmail()]
        );

        return new Seller(
            id: $sellerModel->id,
            name: $sellerModel->name,
            email: $sellerModel->email
        );
    }

    /**
     * @param string $id
     * @return Seller|null
     */
    public function findById(string $id): ?Seller
    {
        $sellerModel = SellerModel::where('id', $id)->first();

        if (!$sellerModel) {
            return null;
        }

        return new Seller(
            id: $sellerModel->id,
            name: $sellerModel->name,
            email: $sellerModel->email
        );
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return SellerModel::all()
            ->map(fn ($seller) => new Seller($seller->id, $seller->name, $seller->email))
            ->toArray();
    }
}
