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
        // Define employee roles data
        $employeeRoles = [
            [
                'userID' => "EMP001",
                'role' => 1,
                'group_name' => '0',
            ],
        ];

        // Upsert employee roles into the 'emp_role' table
        DB::table('emp_role')->upsert($employeeRoles, ['userID'], ['role', 'group_name']);

        // Define user roles data
        $userRoles = [
            [
                'user_id' => 1,
                'role_id' => 1,
            ],
        ];

        // Upsert user roles into the 'users_roles' table
        DB::table('users_roles')->upsert($userRoles, ['user_id'], ['role_id']);
    }
}
        