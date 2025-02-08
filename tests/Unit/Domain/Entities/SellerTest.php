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
        $seller = new Seller(1, 'Fulano Tal', 'fulano@example.com', 100.0);

        $this->assertEquals(1, $seller->getId());
        $this->assertEquals('Fulano Tal', $seller->getName());
        $this->assertEquals('fulano@example.com', $seller->getEmail());
        $this->assertEquals(100.0, $seller->getCommission());
    }
}

