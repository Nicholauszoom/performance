<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Admin\Permission;

class ImailNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            #3.start workforce permissions
            ['slug' => 'view-workforce','sys_module_id'=>1],
            ['slug' => 'view-employee','sys_module_id'=>1],
            ['slug' => 'edit-employee','sys_module_id'=>1],
            ['slug' => 'delete-employee','sys_module_id'=>1],
            ['slug' => 'add-employee','sys_module_id'=>1],




              


               //dashboard
            ['slug' => 'view-dashboard','sys_module_id'=>8],

             // end manage-AccessControl permissions
        ];

        foreach ($data as $row) {
            Permission::firstOrCreate($row);
        }
    }
}
