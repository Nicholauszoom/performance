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
                'userid' => "EMP001",
                'role' => 1,
                'group_name' => '0',
                'duedate' => '2023-11-28 20:19:04'
            ],
        ];

        DB::table('emp_role')->insert($employeeRoles);

        // Define user roles data
        $userRoles = [
            [
                'user_id' => 1,
                'role_id' => 1,
            ],
        ];

        DB::table('users_roles')->insert($userRoles);
    }
}

