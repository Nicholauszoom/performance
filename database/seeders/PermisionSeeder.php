<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\AccessControll\Permission;

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
            #3.start manage-AccessControl permissions  
            ['slug' => 'view-roles','sys_module_id'=>1],
            ['slug' => 'add-roles','sys_module_id'=>1],
            ['slug' => 'edit-roles','sys_module_id'=>1],
            ['slug' => 'delete-roles','sys_module_id'=>1],

            ['slug' => 'view-permission','sys_module_id'=>1],
            ['slug' => 'add-permission','sys_module_id'=>1],
            ['slug' => 'edit-permission','sys_module_id'=>1],
            ['slug' => 'delete-permission','sys_module_id'=>1],

            ['slug' => 'view-user','sys_module_id'=>1],
            ['slug' => 'add-user','sys_module_id'=>1],
            ['slug' => 'edit-user','sys_module_id'=>1],
            ['slug' => 'delete-user','sys_module_id'=>1],

            ['slug' => 'view-dashboard','sys_module_id'=>1],
             // end manage-AccessControl permissions 


                            #5.start manage-Payroll permissions  
            ['slug' => 'view-salary_template','sys_module_id'=>2],
            ['slug' => 'add-salary_template','sys_module_id'=>2],
            ['slug' => 'edit-salary_template','sys_module_id'=>2],
            ['slug' => 'delete-salary_template','sys_module_id'=>2],

            ['slug' => 'view-manage_salary','sys_module_id'=>2],
            ['slug' => 'add-manage_salary','sys_module_id'=>2],
            ['slug' => 'edit-manage_salary','sys_module_id'=>2],
            ['slug' => 'delete-manage_salary','sys_module_id'=>2],

            ['slug' => 'view-employee_salary_list','sys_module_id'=>2],
            ['slug' => 'add-employee_salary_list','sys_module_id'=>2],
            ['slug' => 'edit-employee_salary_list','sys_module_id'=>2],
            ['slug' => 'delete-employee_salary_list','sys_module_id'=>2],


            ['slug' => 'view-make_payment','sys_module_id'=>2],
            ['slug' => 'add-make_payment','sys_module_id'=>2],
            ['slug' => 'edit-make_payment','sys_module_id'=>2],
            ['slug' => 'delete-make_payment','sys_module_id'=>2],

            ['slug' => 'view-generate_payslip','sys_module_id'=>2],
            ['slug' => 'add-generate_payslip','sys_module_id'=>2],
            ['slug' => 'edit-generate_payslip','sys_module_id'=>2],
            ['slug' => 'delete-generate_payslip','sys_module_id'=>2],

            ['slug' => 'view-payroll_summary','sys_module_id'=>2],
            ['slug' => 'add-payroll_summary','sys_module_id'=>2],
            ['slug' => 'edit-payroll_summary','sys_module_id'=>2],
            ['slug' => 'delete-payroll_summary','sys_module_id'=>2],

            ['slug' => 'view-advance_salary','sys_module_id'=>2],
            ['slug' => 'add-advance_salary','sys_module_id'=>2],
            ['slug' => 'edit-advance_salary','sys_module_id'=>2],
            ['slug' => 'delete-advance_salary','sys_module_id'=>2],

            ['slug' => 'view-employee_loan','sys_module_id'=>2],
            ['slug' => 'add-employee_loan','sys_module_id'=>2],
            ['slug' => 'edit-employee_loan','sys_module_id'=>2],
            ['slug' => 'delete-employee_loan','sys_module_id'=>2],

            ['slug' => 'view-overtime','sys_module_id'=>2],
            ['slug' => 'add-overtime','sys_module_id'=>2],
            ['slug' => 'edit-overtime','sys_module_id'=>2],
            ['slug' => 'delete-overtime','sys_module_id'=>2],


            ['slug' => 'view-nssf','sys_module_id'=>2],
            ['slug' => 'add-nssf','sys_module_id'=>2],
            ['slug' => 'edit-nssf','sys_module_id'=>2],
            ['slug' => 'delete-nssf','sys_module_id'=>2],

            ['slug' => 'view-tax','sys_module_id'=>2],
            ['slug' => 'add-tax','sys_module_id'=>2],
            ['slug' => 'edit-tax','sys_module_id'=>2],
            ['slug' => 'delete-tax','sys_module_id'=>2],

            ['slug' => 'view-nhif','sys_module_id'=>2],
            ['slug' => 'add-nhif','sys_module_id'=>2],
            ['slug' => 'edit-nhif','sys_module_id'=>2],
            ['slug' => 'delete-nhif','sys_module_id'=>2],

            ['slug' => 'view-wcf','sys_module_id'=>2],
            ['slug' => 'add-wcf','sys_module_id'=>2],
            ['slug' => 'edit-wcf','sys_module_id'=>2],
            ['slug' => 'delete-wcf','sys_module_id'=>2],

            // end manage-payroll permissions 
            

            
       ];

         foreach ($data as $row) {
            Permission::firstOrCreate($row);
         }
    }
}
