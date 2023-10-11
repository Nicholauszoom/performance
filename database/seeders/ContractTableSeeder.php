<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('contract')->insert([
            [
                'id' => 1,
                'name' => 'Fixed Term',
                'duration' => 0.5,
                'reminder' => 2,
                'state' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Permanent',
                'duration' => 60,
                'reminder' => 6,
                'state' => 1,
            ],
        ]);
    }
}
