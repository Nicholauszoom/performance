<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use App\Models\AccessControll\Departments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $departments = [
            [
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
            ],
        ];

        foreach($departments as $key => $value){
            Departments::create($value);
        }

    }
}
