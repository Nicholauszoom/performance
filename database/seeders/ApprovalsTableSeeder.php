<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('approvals')->insert([
            [
                'id' => 4,
                'process_name' => 'Termination Approval',
                'levels' => 1,
                'escallation' => 0,
                'escallation_time' => null,
                'created_at' =>now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'process_name' => 'Promotion Approval',
                'levels' => 1,
                'escallation' => 0,
                'escallation_time' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more records if needed
        ]);
    }
}
