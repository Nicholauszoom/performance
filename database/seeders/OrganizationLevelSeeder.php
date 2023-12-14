<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationLevelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Ancillary', 'minsalary' => 7200000.00, 'maxsalary' => 23287386.00],
            ['name' => 'Officers & Assistants', 'minsalary' => 16339306.00, 'maxsalary' => 36811329.00],
            ['name' => 'Project Managers & Coordinators', 'minsalary' => 31213952.00, 'maxsalary' => 88558232.00],
            ['name' => 'Country Senior Managers / Global Managers', 'minsalary' => 57919786.00, 'maxsalary' => 118282496.00],
            ['name' => 'Regional / Global Senior Managers', 'minSalary' => 89952970.00, 'maxSalary' => 151527680.00],
            ['name' => 'Country Directors / Heads of Function (globally)', 'minsalary' => 119495544.00, 'maxsalary' => 218320944.00],
            ['name' => 'Executive Board / Operations Directors', 'minsalary' => 197725000.00, 'maxsalary' => 315000000.00],
            ['name' => 'Volunteers', 'minsalary' => 100.00, 'maxsalary' => 315000000.00],
            ['name' => 'IT and Operation', 'minsalary' => 1000000.00, 'maxsalary' => 100000000.00],
        ];



        DB::table("organization_level")->insert($data);

    }
}
