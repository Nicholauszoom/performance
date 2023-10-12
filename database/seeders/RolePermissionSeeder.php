<?php

namespace Database\Seeders;
use App\Models\AccessControll\Permission;
use App\Models\AccessControll\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


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
        $permissions = Permission::pluck('id');

        $rolePermissions = [];

        foreach ($permissions as $permissionId) {
            $rolePermissions[] = [
                'role_id' => $role->id, // The target role ID
                'permission_id' => $permissionId,
            ];
        }

        // Insert the role_permissions into the pivot table
        DB::table('roles_permissions')->insert($rolePermissions);
    }
}
