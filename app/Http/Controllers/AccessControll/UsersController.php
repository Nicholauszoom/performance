<?php

namespace App\Http\Controllers\AccessControll;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AccessControll\Role;
use App\Models\AccessControll\Region;
use App\Models\AccessControll\Departments;
use App\Models\AccessControll\Designation;
use App\Models\Payroll\EmployeePayroll;
use App\Models\CompanyRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;


class UsersController extends Controller
{

    public function authenticateUser($permissions)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }



        if(!Auth::user()->can($permissions)){

          abort(Response::HTTP_UNAUTHORIZED,'500|Page Not Found');

         }

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $this->authenticateUser('edit-roles');
        return view('access-controll.users.index', [
            'users' => User::all(),
            'parent' => 'Organisation',
            'child' => 'User'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('access-controll.users.add', [
            'roles' => Role::all(),
            'department' =>  Departments::all(),
            'parent' => 'User',
            'child' => 'Create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'name' => 'required|max:255|min:3|string',
            'role' => 'required|string',
            'address' => 'required|max:255|min:3|string',
            'email' => 'required|string|min:3|unique:users',
            'phone' => 'required|not_in:0|min:9',
           // 'password' => 'required|string|min:6|confirmed',


        ]);
        //
        $user = User::create([
            'name' => $request['name'],

            'email' => $request['email'],
            'address' => $request['address'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone'],
            'added_by' => auth()->user()->id,
            'status' => 1,
       'department_id' => $request['department_id'],
       // 'designation_id' => $request['designation_id'],
           'joining_date' => $request['joining_date'],
        ]);

        $roles['user_id'] = $user->id;
        $roles['added_by'] = auth()->user()->id;
        $roles['role_id'] = $request['role'];


         foreach(auth()->user()->roles as $value)
         $roles['admin_role'] = $value->id;

        CompanyRoles::create($roles);

        if (!$user) {
          //  return redirect(route('users.index'));
        }

        $user->roles()->attach($request['role']);

        return redirect(route('users.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $users = User::all();

        return view('access-controll.users.index2',Compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role = Role::all();
        $region = Region::all();
        //$user = User::with('Role')->where('id',$id)->get();
        $user = User::all()->where('id',$id);
      $users = User::find($id);
        $department = Departments::all();
     $designation= Designation::where('department_id', $users->department_id)->get();
        return view('access-controll.users.edit',Compact('user','role','region','department','designation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::findOrFail($id);
        // $user->name = $request['name'];

        // $user->email = $request['email'];
        // $user->phone = $request['phone'];
        // $user->address = $request['address'];
        // $user->department_id = $request['department_id'];
        // //$user->designation_id = $request['designation_id'];
        //  //$user->joining_date = $request['joining_date'];
        // $user->save();

        if (!$user) {

        }
        $user->roles()->detach();
        $user->roles()->attach($request['role']);

        $roles['user_id'] = $user->id;
        $roles['added_by'] = auth()->user()->id;
        $roles['role_id'] = $request['role'];




        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        $user->delete();
        return redirect(route('users.index'));
    }

 public function save_disable($id)
    {
        //
        $user =  User::find($id);

        $data['disabled_date']=date('Y-m-d');
         $data['disabled']='1';

       $user->update($data);

      $payroll=   EmployeePayroll::where('user_id', $id)->first();

if(!empty($payroll)){
$item['disabled']='1';
  $payroll->update($item);
}
        return redirect(route('users.index'))->with(['success'=>'User Disabled Successfully']);
    }

public function findDepartment(Request $request)
    {

        $district= Designation::where('department_id',$request->id)->get();
               return response()->json($district);

}


}
