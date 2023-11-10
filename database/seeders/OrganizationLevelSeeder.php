<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationLevelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Ancillary', 'minSalary' => 7200000.00, 'maxSalary' => 23287386.00],
            ['name' => 'Officers & Assistants', 'minSalary' => 16339306.00, 'maxSalary' => 36811329.00],
            ['name' => 'Project Managers & Coordinators', 'minSalary' => 31213952.00, 'maxSalary' => 88558232.00],
            ['name' => 'Country Senior Managers / Global Managers', 'minSalary' => 57919786.00, 'maxSalary' => 118282496.00],
            ['name' => 'Regional / Global Senior Managers', 'minSalary' => 89952970.00, 'maxSalary' => 151527680.00],
            ['name' => 'Country Directors / Heads of Function (globally)', 'minSalary' => 119495544.00, 'maxSalary' => 218320944.00],
            ['name' => 'Executive Board / Operations Directors', 'minSalary' => 197725000.00, 'maxSalary' => 315000000.00],
            ['name' => 'Volunteers', 'minSalary' => 100.00, 'maxSalary' => 315000000.00],
            ['name' => 'IT and Operation', 'minSalary' => 1000000.00, 'maxSalary' => 100000000.00],
        ];



        DB::table("organization_level")->insert($data);

    }
}
