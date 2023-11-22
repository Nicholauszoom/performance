<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PensionFundTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pension_fund')->insert([
            [
                'id' => 1,
                'name' => 'National Social Security Fund',
                'amount_employee' => 0.1,
                'amount_employer' => 0.1,
                'deduction_from' => '2',
                'code' => '0001',
                'abbrv' => null,
            ],
            [
                'id' => 2,
                'name' => 'PSSF',
                'amount_employee' => 0.1,
                'amount_employer' => 0.1,
                'deduction_from' => '2',
                'code' => '0002',
                'abbrv' => null,
            ],
        ]);
    }
}
