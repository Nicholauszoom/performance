<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LoanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 2, 'name' => 'Personal Forced Deduction', 'code' => 4910],
            ['id' => 3, 'name' => 'HESLB', 'code' => 4584],
        ];

        DB::table("loan_type")->insert($data);

    }
}