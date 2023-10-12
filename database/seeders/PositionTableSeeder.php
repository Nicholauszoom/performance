<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('position')->insert([
            [
                'id' => 1,
                'name' => 'Manager: Operations',
                'code' => 'TZ1',
                'dept_id' => 1,
                'dept_code' => '001',
                'organization_level' => 1,
                'purpose' => 'N/A',
                'minimum_qualification' => 'N/A',
                'driving_licence' => 0,
                'created_by' => null,
                'created_on' => '2023-01-15 09:23:40',
                'state' => 1,
                'isLinked' => 0,
                'position_code' => 0,
                'parent_code' => 0,
                'level' => 0,
            ],
        ]);
    }
}

