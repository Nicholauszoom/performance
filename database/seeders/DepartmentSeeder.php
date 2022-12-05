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
                'name' => 'Risk Managment Department',
                'code' => 1,
                'type' => 1,
                'department_head_id' => 1,
                'reports_to' => 1,
                'State' => 1,
                'department_pattern' => 'UNKNOWN',
                'parent_pattern' => 'UNKNOWB',
                'level' => 1,
                'created_by' => 'ADMIN',
            ],

            [
                'name' => 'Central Operation Department',
                'code' => 1,
                'type' => 1,
                'department_head_id' => 1,
                'reports_to' => 1,
                'State' => 1,
                'department_pattern' => 'UNKNOWN',
                'parent_pattern' => 'UNKNOWB',
                'level' => 1,
                'created_by' => 'ADMIN',
            ],

            [
                'name' => 'Legal Department',
                'code' => 1,
                'type' => 1,
                'department_head_id' => 1,
                'reports_to' => 1,
                'State' => 1,
                'department_pattern' => 'UNKNOWN',
                'parent_pattern' => 'UNKNOWB',
                'level' => 1,
                'created_by' => 'ADMIN',
            ],

            [
                'name' => 'Money Laundering and Terrorist Financing Reporting Section',
                'code' => 1,
                'type' => 1,
                'department_head_id' => 1,
                'reports_to' => 1,
                'State' => 1,
                'department_pattern' => 'UNKNOWN',
                'parent_pattern' => 'UNKNOWB',
                'level' => 1,
                'created_by' => 'ADMIN',
            ],

            [
                'name' => 'Internal Legal Control and Audit Department',
                'code' => 1,
                'type' => 1,
                'department_head_id' => 1,
                'reports_to' => 1,
                'State' => 1,
                'department_pattern' => 'UNKNOWN',
                'parent_pattern' => 'UNKNOWB',
                'level' => 1,
                'created_by' => 'ADMIN',
            ],

            [
                'name' => 'Information Security Department',
                'code' => 1,
                'type' => 1,
                'department_head_id' => 1,
                'reports_to' => 1,
                'State' => 1,
                'department_pattern' => 'UNKNOWN',
                'parent_pattern' => 'UNKNOWN',
                'level' => 1,
                'created_by' => 'ADMIN',
            ],
        ];

        foreach($departments as $key => $value){
            Departments::create($value);
        }

    }
}
