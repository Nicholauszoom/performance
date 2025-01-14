<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Approvals;

class ApprovalsTableSeeder extends Seeder
{
    public function run()
    {
        $data =[
            [
                'id' => 4,
                'process_name' => 'Termination Approval',
                'levels' => 0,
                'escallation' => 0,
                'escallation_time' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'process_name' => 'Promotion Approval',
                'levels' => 0,
                'escallation' => 0,
                'escallation_time' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'process_name' => 'Employee Approval',
                'levels' => 0,
                'escallation' => 0,
                'escallation_time' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'process_name' => 'Payroll Approval',
                'levels' => 0,
                'escallation' => 0,
                'escallation_time' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'process_name' => 'Loan Approval',
                'levels' => 0,
                'escallation' => 0,
                'escallation_time' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ];
            foreach($data as $row){
                Approvals::updateOrCreate($row);
            }
    }

}
