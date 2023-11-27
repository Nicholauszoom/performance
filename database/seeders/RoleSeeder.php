<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'slug' => 'Human Capital Officer',
                'name' => 'Human Capital Officer',
                'added_by'=>1
            ],
            [
                'slug' => 'Finance Officer',
                'name' => 'Finance Officer',
                'added_by'=>1
            ],
            [
                'slug' => 'Head Of Finance',
                'name' => 'Head Of Finance',
                'added_by'=>1
            ],
            [
                'slug' => 'Head Of Human Capital',
                'name' => 'Head Of Human Capital',
                'added_by'=>1
            ],
            [
                'slug' => 'Managing Director',
                'name' => 'Managing Director',
                'added_by'=>1
            ],
            [
                'slug' => 'Staff',
                'name' => 'Other Staff',
                'added_by'=>1
            ]



        ];

        // insert roles into the 'roles' table
        DB::table('roles')->insert($roles);
    }
}
