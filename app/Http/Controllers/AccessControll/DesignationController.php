<?php

namespace App\Http\Controllers\AccessControll;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\AccessControll\Permission;
use App\Models\AccessControll\Departments;
use App\Models\AccessControll\Designation;
use App\Models\AccessControll\SystemModule;

class DesignationController extends Controller
{
    
    public function index()
    {
        $permissions = Designation::all();
        $department = Departments::all();
        return view('access-controll.designation.index', [
            'permissions' => $permissions,
            'department' => $department,
            'parent' => 'Organisation',
            'child' => 'Position'
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $role = Designation::create([
            'name' => $request->name,
           'department_id' => $request->department_id,
        ]);
        return redirect(route('designations.index'));
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
        $role = Designation::find($request->id);
        $role->name = $request->name;
        $role->department_id = $request->department_id;
        $role->update();
        return redirect(route('designations.index'));
    }

    public function destroy($id)
    {
        $role = Designation::find($id);
        $role->delete();
        return redirect(route('designations.index'));
    }
}
