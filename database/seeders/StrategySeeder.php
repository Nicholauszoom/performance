<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrategySeeder extends Seeder
{
    public function run()
    {
        // Insert strategy data here
        $strategies = [
            [
                'id' => '1',
                'title' => 'Strategy 1',
                'description' => 'Description of Strategy 1',
                'start' => '2023-01-01',
                'end' => '2023-12-31',
                'type' => 1, // 1 for strategy
                'funder' => 'EMP001',
                'author' => 'EMP001',
                'status' => '1',
                'progress' => 50, // Progress percentage
                'dated' => '2023-06-30',
            ]
            // Add more strategy data as needed...
        ];

        // Insert strategies into the 'strategy' table
        DB::table('strategy')->insert($strategies);
    }
}
