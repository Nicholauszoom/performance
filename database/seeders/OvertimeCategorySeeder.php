<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OvertimeCategory;
use Illuminate\Support\Facades\DB;


class OvertimeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Normal Overtime',
                'rate_multiplier' => 1.5,
                'rate_addition' => 1.5,
                'status' => 1,
            ],
            [
                'name' => 'Holiday Overtime',
                'rate_multiplier' => 2.0,
                'rate_addition' => 2.0,
                'status' => 1,
            ],
            [
                'name' => 'Sunday Overtime',
                'rate_multiplier' => 2.0,
                'rate_addition' => 2.0,
                'status' => 1,
            ],
        ];

        DB::table("overtime_category")->insert($data);
    }
}
