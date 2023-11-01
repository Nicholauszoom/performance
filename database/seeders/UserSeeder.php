<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Generate user data here
        $users = [
            [
                'emp_id' => 'EMP001',
                'old_emp_id' => 'OLD001',
                'password_set' => true, // 1 for true, 0 for false
                'fname' => 'CITS',
                'mname' => 'CITS',
                'lname' => 'Admin',
                'birthdate' => '1990-01-15',
                'gender' => 'Male',
                'nationality' => '255',
                'merital_status' => 'Single',
                'hire_date' => '2021-05-10',
                'department' => 1,
                'position' => 1,
                'branch' => '1',
                'shift' => '1',
                'organization' => 'CITS',
                'line_manager' => 'EMP001',
                'contract_type' => 'Permanent',
                'contract_renewal_date' => '2024-05-10',
                'salary' => 60000.00,
                'postal_address' => '123 Main St',
                'postal_city' => 'New York',
                'physical_address' => '456 Elm St',
                'mobile' => '+1 (123) 456-7890',
                'email' => 'john@example.com',
                'photo' => 'user.jpg',
                'is_expatriate' => true, // 1 for true, 0 for false
                'home' => 'Home Address',
                'bank' => 1,
                'bank_branch' => '1',
                'account_no' => '123456789',
                'pension_fund' => 'Pension Fund Name',
                'pf_membership_no' => 'PF12345',
                'username' => 'johnsmith',
                'password' => Hash::make('password'),
                'state' => '1',
                'login_user' => 1, // 1 for user who can log in, 0 for normal users
                'last_updated' => now(),
                'last_login' => now(),
                'retired' => false, // 1 for retired, 0 for active
                'contract_end' => '2025-05-10',
                'tin' => '123456789',
                'national_id' => 'ID1234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more user data as needed...
        ];

        // Insert users into the 'users' table
        DB::table('employee')->insert($users);
    }
}
