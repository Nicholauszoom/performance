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

        $this->call(LeaveSubCatSeeder::class);
        $this->call(LeaveTypeSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(DepartmentSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(PermisionSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(StrategySeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(BankBranchTableSeeder::class);
        $this->call(BankTableSeeder::class);
        $this->call(BranchTableSeeder::class);
        $this->call(PayeSeeder::class);
        $this->call(ContractTableSeeder::class);
        $this->call(CostCenterSeeder::class);
        // $this->call(CountryTableSeeder::class);
        $this->call(CurrenciesSeeder::class);
        $this->call(DeductionSeeder::class);
        $this->call(ApprovalsTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(UserPasswordSeeder::class);
        $this->call(OrganizationLevelSeeder::class);
        $this->call(PensionFundTableSeeder::class);
        $this->call(PositionTableSeeder::class);
        $this->call(OvertimeCategorySeeder::class);
        $this->call(LoanTypeSeeder::class);
        $this->call(CountryCodeSeeder::class);
        $this->call(RoleSeeder::class);


        // $this->call(RegionSeeder::class);
        // $this->call(DistrictSeeder::class);
    }
}
