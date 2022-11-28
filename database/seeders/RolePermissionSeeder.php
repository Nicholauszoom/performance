<?php

namespace Database\Seeders;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // or may be done by chaining

        $role = Role::create(['slug' => 'super-admin', 'name' => 'Super Admin']);
        $role->givePermissionTo(Permission::all()->toArray());
    }
}
