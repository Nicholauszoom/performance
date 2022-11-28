<?php

namespace App\Http\Controllers\AccessControll;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\AccessControll\Departments;
use App\Models\AccessControll\SystemModule;

class DepartmentController extends Controller
{  
    public function __construct()
    {
       
        
    }
    public function index()
    {  
        $permissions = Departments::all();
        return view('access-controll.department.index', compact('permissions'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $role = Departments::create([
            'name' => $request->name,
        ]);
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
