<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('department')->insert([
            // 'id' => 1,
            'dept_no' => 1,
            'code' => 0,
            'cost_center_id' => 1,
            'company' => 1,
            'name' => 'Management',
            'type' => 1, // 1-Department, 2-Subdepartment
            'hod' => 102927,
            'reports_to' => 3,
            'state' => 1,
            'department_pattern' => 1,
            'parent_pattern' => 1,
            'level' => 1,
        ]);
    }
}