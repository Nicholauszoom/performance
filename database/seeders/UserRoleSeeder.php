<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessControll\Role;
use App\Models\AccessControll\Permission;
use App\Models\AccessControll\User;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        //
        $user = User::where('email','admin@gmail.com')->first();

        

        $permission = Permission::all();

        $permission = $permission->toArray();
        //dd($permission);
       
        $role = new Role;
        $role2 = new Role;
        $role->slug  = 'superAdmin';
        $role->name  = 'superAdmin';
        $role->save();
        
        
        $role2->slug  = 'jobSeeker';
        $role2->name  = 'jobSeeker';
        $role2->save();
         $role->refreshPermissions($permission);

       
        $user->roles()->attach($role->id);



    }
}
