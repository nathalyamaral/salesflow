<?php

namespace Domain\Entities;

use DateTime;

/**
 * Represents a sale made by a seller.
 */
class Sale
{
    public function __construct(
        private readonly int $id,
        private readonly Seller $seller,
        private readonly float $amount,
        private readonly float $commission,
        private readonly DateTime $date
    ) {
    }

    /**
     * Gets the sale's ID.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the seller responsible for the sale.
     *
     * @return Seller
     */
    public function getSeller(): Seller
    {
        return $this->seller;
    }

    /**
     * Gets the sale amount.
     *
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Gets the sale commission.
     *
     * @return float
     */
    public function getCommission(): float
    {
        return $this->commission;
    }

    /**
     * Gets the sale date.
     *
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }
}
