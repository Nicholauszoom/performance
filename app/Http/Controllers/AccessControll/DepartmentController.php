<?php

namespace App\Http\Controllers\AccessControll;

use App\Helpers\SysHelpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AccessControll\Permission;
use App\Models\AccessControll\Departments;
use App\Models\AccessControll\SystemModule;

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Departments::all();
        $parent = 'Setting';
        $child = 'Departments';

        return view('organisation.department.index', compact('parent', 'child','departments'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Departments::create([
            'name' => $request->name,
            'code' => 1,
            'type' => 1,
            'reports_to' => 1,
            'State' => 1,
            'department_pattern' => 'UNKNOWN',
            'parent_pattern' => 'UNKNOWB',
            'level' => 1,
            'created_by' => Auth::user()->name,
        ]);

        // SysHelpers::AuditLog(3, 'Employee Created', $request);

        return redirect(route('departments.index'));
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
        $role = Departments::find($request->id);
        $role->name = $request->name;
        $role->update();
        return redirect(route('departments.index'));
    }

    public function destroy($id)
    {
        $role = Departments::find($id);
        $role->delete();
        return redirect(route('departments.index'));
    }
}
