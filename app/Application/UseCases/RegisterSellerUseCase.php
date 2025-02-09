<?php

namespace Application\UseCases;

use Domain\Repositories\SellerRepositoryInterface;
use Domain\Entities\Seller;

/**
 * Use case to register a new seller.
 */
class RegisterSellerUseCase
{
    public function __construct(
        private readonly SellerRepositoryInterface $repository
    ) {
    }

    /**
     * Registers a new seller in the system.
     *
     * @param string $name
     * @param string $email
     * @return Seller
     */
    public function execute(string $name, string $email): Seller
    {
        return $this->repository->save(new Seller(0, $name, $email));
    }
}
