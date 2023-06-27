<?php

namespace App\Http\Controllers\AccessControll;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\AccessControll\Permission;
use App\Models\AccessControll\SystemModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
    public function __construct()
    {


    }

    public function authenticateUser($permissions)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }



        if(!Auth::user()->can($permissions)){

          abort(Response::HTTP_UNAUTHORIZED);

         }

    }
    public function index()
    {  // , compact('permissions', 'modules')

        $this->authenticateUser('view-Permission');

        $permissions = Permission::all();
        $modules = SystemModule::all();
        return view('access-controll.permission.index', [
            'permissions' => $permissions,
            'modules' => $modules,
            'parent' => 'Setting',
            'child' => 'Permissions',
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $role = Permission::create([
            'slug' => str_replace(' ', '-', $request->slug),
            'sys_module_id' => $request->module_id,
        ]);
        return redirect(route('permissions.index'));
    }

    public function show(Permission $permission)
    {
        //
    }

    public function edit(Request $request)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $role = Permission::find($request->id);
        $role->slug = str_replace(' ', '-', $request->slug);
        $role->sys_module_id = $request->module_id;
        $role->save();
        return redirect(route('permissions.index'));
    }

    public function destroy($id)
    {
        $role = Permission::find($id);
        $role->delete();
        return redirect(route('permissions.index'));
    }
}
