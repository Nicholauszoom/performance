<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationLevelSeeder extends Seeder
{
    public function run()
    {
        DB::table('organization_level')->insert([
            [
                'name' => 'Management',
                'minSalary' => 1000000,
                'maxSalary' => 10000000,
            ],
           
            // Add more data as needed
        ]);
    }
}
