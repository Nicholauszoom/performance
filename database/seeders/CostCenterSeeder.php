<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostCenterSeeder extends Seeder
{
    public function run()
    {
        DB::table('cost_center')->insert([
            [
                'name' => 'Management',
                'description' => 'Management',
                'country' => 'Tanzania',
                'region' => 1,
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'name' => 'Non Management',
                'description' => 'Non Management',
                'country' => 'Tanzania',
                'region' => 1,
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
