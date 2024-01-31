<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
         // Insert employee role data here
         $employeeRoles = [
            [
                'user_id' => 1, // User ID of the employee
                'role_id' => 1, // Role ID (e.g., role with ID 1)
            ],
            [
                'user_id' => 2, // User ID of the employee
                'role_id' => 2, // Role ID (e.g., role with ID 1)
            ], [
                'user_id' => 3, // User ID of the employee
                'role_id' => 3, // Role ID (e.g., role with ID 1)
            ], [
                'user_id' => 4, // User ID of the employee
                'role_id' => 4, // Role ID (e.g., role with ID 1)
            ],
            [
                'user_id' => 5, // User ID of the employee
                'role_id' => 5, // Role ID (e.g., role with ID 1)
            ],
        ];

        // Insert employee roles into the 'employee_role' pivot table
        DB::table('users_roles')->insert($employeeRoles);


         // Insert employee role data here
         $employeeRoles = [
            [
                'UserID' => "EMP001", // User ID of the employee
                'role' => 1, // Role ID (e.g., role with ID 1)
                'group_name'=>'0',            ],
        ];

        // Insert employee roles into the 'employee_role' pivot table
        DB::table('emp_role')->insert($employeeRoles);



    }
}
