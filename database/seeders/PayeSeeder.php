<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayeSeeder extends Seeder
{
    public function run()
    {
        DB::table('paye')->insert([
            [
                'minimum' => 1.00,
                'maximum' => 270000.00,
                'rate' => 0.0000,
                'excess_added' => 0.00,
            ],
            [
                'minimum' => 270000.00,
                'maximum' => 520000.00,
                'rate' => 0.0800,
                'excess_added' => 0.00,
            ],
            [
                'minimum' => 520000.00,
                'maximum' => 760000.00,
                'rate' => 0.2000,
                'excess_added' => 20000.00,
            ],
            [
                'minimum' => 760000.00,
                'maximum' => 1000000.00,
                'rate' => 0.2500,
                'excess_added' => 68000.00,
            ],
            [
                'minimum' => 1000000.00,
                'maximum' => 100000000.00,
                'rate' => 0.3000,
                'excess_added' => 128000.00,
            ],
            // Add more records if needed
        ]);
    }
}
