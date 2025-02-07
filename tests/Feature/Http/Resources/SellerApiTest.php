<?php

namespace Tests\Feature\Http\Resources;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


/**
 * Feature tests for Seller API.
 */
class SellerApiTest extends TestCase
{
    use RefreshDatabase;

    public function registerSeller(): void
    {
        $response = $this->postJson('/api/sellers', [
            'name' => 'Fulano Tal',
            'email' => 'fulano@example.com'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'email', 'commission']);
    }
}
