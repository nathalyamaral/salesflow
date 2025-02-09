<?php

namespace Tests\Unit\Domain\Entities;

use Domain\Entities\Seller;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Seller entity.
 */
class SellerTest extends TestCase
{
    public function testCreateSeller(): void
    {
        $seller = new Seller(
            id: 1,
            name: 'Fulano Tal',
            email: 'fulano@example.com',
            commission: 100.0
        );

        $this->assertEquals(1, $seller->getId());
        $this->assertEquals('Fulano Tal', $seller->getName());
        $this->assertEquals('fulano@example.com', $seller->getEmail());
        $this->assertEquals(100.0, $seller->getCommission());
    }
}

