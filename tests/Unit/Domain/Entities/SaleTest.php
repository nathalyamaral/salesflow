<?php

namespace Tests\Unit\Domain\Entities;

use Tests\Unit\Sale;
use Tests\Unit\Seller;
use Tests\Unit\TestCase;

/**
 * Unit tests for Sale entity.
 */
class SaleTest extends TestCase
{
    public function createSale(): void
    {
        $seller = new Seller(1, 'Fulano Tal', 'fulano@example.com', 100.0);
        $sale = new Sale(1, $seller, 500.0, 42.5, new \DateTime('2024-02-07'));

        $this->assertEquals(1, $sale->getId());
        $this->assertEquals($seller, $sale->getSeller());
        $this->assertEquals(500.0, $sale->getAmount());
        $this->assertEquals(42.5, $sale->getCommission());
        $this->assertInstanceOf(\DateTime::class, $sale->getDate());
    }
}
