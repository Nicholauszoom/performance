<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('branch')->insert([
            'id' => 1,
            'name' => 'Head Office',
            'code' => 1,
            'street' => null,
            'region' => null,
            'country' => null,
            'location_code' => null,
            'location_id' => null,
        ]);
    }
}