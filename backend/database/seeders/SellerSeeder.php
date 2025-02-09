<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Seeder for creating sellers.
 */
class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = [
            [
                'id' => 1,
                'name' => 'Carlos Silva',
                'email' => 'carlos@example.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Mariana Souza',
                'email' => 'mariana@example.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Roberto Oliveira',
                'email' => 'roberto@example.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('sellers')->insert($sellers);

        Cache::put('sellers_all', json_encode($sellers), 1200);
    }
}
