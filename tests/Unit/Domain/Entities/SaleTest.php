<?php

namespace Tests\Unit\Domain\Entities;

use DateTime;
use Domain\Entities\Sale;
use Domain\Entities\Seller;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Sale entity.
 */
class SaleTest extends TestCase
{
    public function testCreateSale(): void
    {
        $seller = new Seller(
            id: 1,
            name: 'Fulano Tal',
            email: 'fulano@example.com'
        );
        $sale = new Sale(
            id: 1,
            seller: $seller,
            amount: 500.0,
            commission: $seller->getCommission(),
            date: new DateTime('2024-02-07')
        );

        $this->assertEquals(1, $sale->getId());
        $this->assertEquals($seller, $sale->getSeller());
        $this->assertEquals(500.0, $sale->getAmount());
        $this->assertEquals(8.5, $sale->getCommission());
        $this->assertInstanceOf(DateTime::class, $sale->getDate());
    }
}
