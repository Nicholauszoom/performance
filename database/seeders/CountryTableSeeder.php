<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('country')->insert([
            [
                'id' => 1,
                'name' => 'Tanzania (United Republic)',
                'code' => 255,
            ],
            [
                'id' => 2,
                'name' => 'Kenya',
                'code' => 254,
            ],
            [
                'id' => 3,
                'name' => 'China',
                'code' => 256,
            ],
            [
                'id' => 6,
                'name' => 'USA',
                'code' => 1,
            ],
            [
                'id' => 7,
                'name' => 'India',
                'code' => 97,
            ],
            [
                'id' => 8,
                'name' => 'UK',
                'code' => 44,
            ],
        ]);
    }
}
