<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests integration sale.
 */
class SaleApiTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterSaleNotInvalid(): void
    {
        $response = $this->postJson('/api/sales', [
            'seller_email' => 'not-exists@example.com',
            'amount' => -10
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['seller_email', 'amount']);
    }
}
