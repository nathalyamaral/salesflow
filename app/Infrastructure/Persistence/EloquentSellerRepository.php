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
            $sellerModel->id,
            $sellerModel->name,
            $sellerModel->email
        );
    }

    /**
     * @param string $email
     * @return Seller|null
     */
    public function findByEmail(string $email): ?Seller
    {
        $sellerModel = SellerModel::where('email', $email)->first();

        if (!$sellerModel) {
            return null;
        }

        return new Seller(
            $sellerModel->id,
            $sellerModel->name,
            $sellerModel->email
        );
    }
}
