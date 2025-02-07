<?php

namespace Domain\Entities;

/**
 * Represents a seller in the system.
 */
class Seller
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $email,
        private float $commission = 0.0
    ) {
    }

    /**
     * Gets the seller's ID.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the seller's name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets the seller's email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Gets the seller's commission.
     *
     * @return float
     */
    public function getCommission(): float
    {
        return $this->commission;
    }
}
