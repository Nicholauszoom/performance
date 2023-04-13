<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //$this->call(LeaveSubCatSeeder::class);
        // $this->call(LeaveTypeSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(DepartmentSeeder::class);
         $this->call(ModuleSeeder::class);
         $this->call(PermisionSeeder::class);
        // $this->call(RolePermisionSeeder::class);
        // $this->call(UserRoleSeeder::class);

        //$this->call(ZoneSeeder::class);
        //$this->call(CountrySeeder::class);
        //$this->call(RegionSeeder::class);
        //$this->call(DistrictSeeder::class);
    }
}
