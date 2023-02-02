<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Admin\Permission;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [



            #1 workforce management permissions
            ['slug' => 'view-workforce','sys_module_id'=>1],

            // start of active employees seeders
            ['slug' => 'view-employee','sys_module_id'=>1],
            ['slug' => 'edit-employee','sys_module_id'=>1],
            ['slug' => 'delete-employee','sys_module_id'=>1],
            ['slug' => 'add-employee','sys_module_id'=>1],
            // end of active employees seeders


            ['slug' => 'activate-employee','sys_module_id'=>1],
            ['slug' => 'suspend-employee','sys_module_id'=>1],
            ['slug' => 'transfer-employee','sys_module_id'=>1],

            // start of employee termination seeders
            ['slug' => 'view-termination','sys_module_id'=>1],
            ['slug' => 'add-termination','sys_module_id'=>1],
            ['slug' => 'edit-termination','sys_module_id'=>1],
            ['slug' => 'delete-termination','sys_module_id'=>1],
            ['slug' => 'print-termination','sys_module_id'=>1],
            // end of employee termination seeders

            ['slug' => 'view-overtime','sys_module_id'=>1],
            ['slug' => 'add-overtime','sys_module_id'=>1],
            ['slug' => 'edit-overtime','sys_module_id'=>1],
            ['slug' => 'delete-overtime','sys_module_id'=>1],

            ['slug' => 'view-imprest','sys_module_id'=>1],
            ['slug' => 'add-imprest','sys_module_id'=>1],
            ['slug' => 'edit-imprest','sys_module_id'=>1],
            ['slug' => 'delete-imprest','sys_module_id'=>1],

            ['slug' => 'view-grivance','sys_module_id'=>1],
            ['slug' => 'add-grivance','sys_module_id'=>1],
            ['slug' => 'edit-grivance','sys_module_id'=>1],
            ['slug' => 'delete-grivance','sys_module_id'=>1],


            //payroll management
            ['slug' => 'view-payroll-management','sys_module_id'=>2],
            ['slug' => 'view-payroll','sys_module_id'=>2],
            ['slug' => 'add-payroll','sys_module_id'=>2],
            ['slug' => 'edit-payroll','sys_module_id'=>2],
            ['slug' => 'hr-recommend-payroll','sys_module_id'=>2],
            ['slug' => 'finance-recommend-payroll','sys_module_id'=>2],
            ['slug' => 'approve-payroll','sys_module_id'=>2],

            ['slug' => 'view-payslip','sys_module_id'=>2],
            ['slug' => 'view-incentives','sys_module_id'=>2],
            ['slug' => 'add-incentives','sys_module_id'=>2],
            ['slug' => 'view-pending-payments','sys_module_id'=>2],

            //leave management

            ['slug' => 'view-leave','sys_module_id'=>3],
            ['slug' => 'approve-leave','sys_module_id'=>3],


            //loan management
            ['slug' => 'view-loan','sys_module_id'=>4],
            ['slug' => 'edit-loan','sys_module_id'=>4],
            ['slug' => 'add-loan','sys_module_id'=>4],
            ['slug' => 'delete-loan','sys_module_id'=>4],
            ['slug' => 'approve-loan','sys_module_id'=>4],

             //Organization
             ['slug' => 'view-organization','sys_module_id'=>5],
             ['slug' => 'edit-organization','sys_module_id'=>5],
             ['slug' => 'add-organization','sys_module_id'=>5],
             ['slug' => 'delete-organization','sys_module_id'=>5],

              //Reports
              ['slug' => 'view-report','sys_module_id'=>6],
              ['slug' => 'view-statutory-report','sys_module_id'=>6],
              ['slug' => 'edit-organization-report','sys_module_id'=>6],


               //Settings
               ['slug' => 'view-setting','sys_module_id'=>7],
               ['slug' => 'view-financial-setting','sys_module_id'=>7],
               ['slug' => 'view-Banking-information','sys_module_id'=>7],
               ['slug' => 'view-Roles','sys_module_id'=>7],
               ['slug' => 'view-Permission','sys_module_id'=>7],
               ['slug' => 'view-audit-trail','sys_module_id'=>7],
               ['slug' => 'view-mail-configuration','sys_module_id'=>7],


               //dashboard
            ['slug' => 'view-dashboard','sys_module_id'=>8],

             // end manage-AccessControl permissions
        ];

        foreach ($data as $row) {
            Permission::firstOrCreate($row);
        }
    }
}
