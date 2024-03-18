<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserPasswordSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'empID' => 'EMP001',
                'password' => Hash::make('password'),
                'time' => now(),
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ],
            [
                'empID' => 'EMP002',
                'password' => Hash::make('password'),
                'time' => now(),
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ],
            [
                'empID' => 'EMP003',
                'password' => Hash::make('password'),
                'time' => now(),
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ],
            [
                'empID' => 'EMP004',
                'password' => Hash::make('password'),
                'time' => now(),
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ],
            [
                'empID' => 'EMP005',
                'password' => Hash::make('password'),
                'time' => now(),
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ],
        ];

        // Insert data into the user_password table
        DB::table('user_passwords')->insert($users);
    }
}
