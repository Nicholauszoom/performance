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
                'day_percent' => 1.5,
                'night_percent' => 1.5,
                'state' => 1,
            ],
            [
                'name' => 'Holiday Overtime',
                'day_percent' => 2.0,
                'night_percent' => 2.0,
                'state' => 1,
            ],
            [
                'name' => 'Sunday Overtime',
                'day_percent' => 2.0,
                'night_percent' => 2.0,
                'state' => 1,
            ]
        ];


        DB::table("overtime_category")->insert($data);
    }
}
