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
        ];

        foreach ($data as $row) {
            Permission::firstOrCreate($row);
        }
    }
}
