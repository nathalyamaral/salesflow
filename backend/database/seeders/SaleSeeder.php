<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Seeder for creating sales.
 */
class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [];

        for ($i = 1; $i <= 20; $i++) {
            $sales[] = [
                'seller_id' => rand(1, 3),
                'amount' => rand(100, 1000),
                'commission' => rand(10, 100),
                'date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('sales')->insert($sales);
        Cache::put('sales_all', json_encode($sales), 1200);
    }
}
