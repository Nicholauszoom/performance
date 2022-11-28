<?php

namespace App\Http\Controllers\AccessControll;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\AccessControll\Role;
use App\Models\AccessControll\Permission;
use App\Models\AccessControll\SystemModule;

class RoleController extends Controller
{  

    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $modules = SystemModule::all();
        return view('access-controll.role.index', compact('roles', 'permissions', 'modules'));
    }

    public function create(Request $request)
    {

        $role = Role::find($request->role_id);
        if($role->added_by == auth()->user()->id){
        if (isset($request->permissions)) {
            $role->refreshPermissions($request->permissions);
        } else {
            $role->permissions()->detach();
        }
        $message = "permission updated successfully";
        $type = "success";
       }else{
           $message = "You dont have permission to perform this action";
           $type = "error";
       }

        return redirect()->back()->with([$type=>$message]);
    }

    public function store(Request $request)
    {
        $role = Role::create([
            'slug' => str_replace(' ', '-', $request->slug),
            'name' => $request->slug,
            'added_by'=>auth()->user()->id,
            
        ]);
        return redirect(route('roles.index'));
    }

    public function show($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        $modules = SystemModule::all();
        return view('access-controll.role.assign', compact('permissions', 'modules', 'role'));
    }


    public function edit(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($request->id);
        $role->slug = str_replace(' ', '-', $request->slug);
        $role->save();
        return redirect(route('roles.index'));
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect(route('roles.index'));
    }
}
