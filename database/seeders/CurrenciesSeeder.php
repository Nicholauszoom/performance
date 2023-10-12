<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
{
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'currency' => 'TZS',
                'rate' => 1.00,
            ],
            [
                'currency' => 'USD',
                'rate' => 2300.00,
            ],
        ]);
    }
}
