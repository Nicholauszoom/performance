<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeductionSeeder extends Seeder
{
    public function run()
    {
        DB::table('deduction')->insert([
            [
                'id' => 2,
                'name' => 'WCF',
                'code' => 4216,
                'rate_employee' => 0,
                'rate_employer' => 0.005,
                'remarks' => 'From Gross Salary',
                'is_active' => 1,
            ],
            [
                'id' => 3,
                'name' => 'HESLB',
                'code' => 4584,
                'rate_employee' => 0.15,
                'rate_employer' => 0,
                'remarks' => 'From Basic Salary',
                'is_active' => 1,
            ],
            [
                'id' => 4,
                'name' => 'SDL',
                'code' => 4176,
                'rate_employee' => 0,
                'rate_employer' => 0.035,
                'remarks' => 'From Gross Salary',
                'is_active' => 1,
            ],
            // Add more records if needed
        ]);
    }
}
