<?php

namespace App\Http\Controllers\API;

use App\Helpers\SysHelpers;
use App\Rules\CurrentPasswordCheck;
use App\Rules\OldPasswordCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordChange;
use App\Http\Requests\PasswordValidationRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing;
use App\Providers\RouteServiceProvider;
use App\Rules\API\CheckOldPassword;
use App\Rules\API\CurrentPassword;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function firstPassword()
    {
        return view('auth.password-change');
    }

    public function passwordEmployee()
    {
        // dd(session()->all());

        return view('employee.change-password', [
            'parent' => "Password Update",
        ]);
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PasswordValidationRequest $request)
    {
        $validated = $request->validated();

        $employee = array(
            'password_set' => '0',
            'password' => Hash::make($validated['password']),
        );

        $userPass = array(
            'empID' => $request->user()->emp_id,
            'password' => Hash::make($validated['password']),
            'time' => date('Y-m-d'),
        );

        $result = $this->passSave($request->user()->emp_id, $employee, $userPass, $request);

        if($result == 1){
            $request->session()->flush();

            return redirect('/');
        }else{
            return back()->with('status', 'password not updated');
        }
    }

    public function updatePassword(Request $request)
    {
        $emp_id=$request->emp_id;
        $inputs = $request->all();
        $passCheck=  new CurrentPasswordCheck($emp_id);
        $validator = Validator::make($inputs, [
            'current_password' => ['required', $passCheck],
            'new_password' => ['required', 'string', 'min:8', new OldPasswordCheck($emp_id)],
            // 'string', 'min:8', 'confirmed'
            'password_confirmation' => ['required', 'string', 'min:8', 'same:new_password'],
        ]);
        if ($validator->fails()) {
            return response()->json([
               'message'=>'validations fails',
               'errors' =>$validator->errors()
            ],422);
         }
         else
         {
            // $user = Auth::user()->emp_id;
            // return response()->json('success', 200);

            $employee = array(
                    'password' => Hash::make($request->new_password),
                );
            $userPass = array(
                        'empID' =>$emp_id,
                        'password' => Hash::make($request->new_password),
                        'time' => date('Y-m-d'),
                    );

            $result = $this->passSave($emp_id, $employee, $userPass, $request);
            if ($result == 1) {
                return response()->json([
                    'message' => 'Password Updated',
                    'username' => $emp_id,
                ], 200);
            } else {
                return response()->json('password not updated', 500);
            }
        }
        // if (Hash::check($request->old_password,$user->password)) {

        // $curr = $request->input('current_password');
        // $new_password = $request->input('new_password');

        // if($curr == $new_password){
        //     return response()->json([
        //         'message' => 'Password Updated',
        //         'data' => $curr,
        //         'userPass' => $new_password,
        //     ], 200);
        // }
        // else{
        //     return response()->json('Not Equal', 500);
        // }


        // $input ='Hello';
        // return response()->json($input, 200);
        // $validated = $request->validated();

        // $employee = array(
        //     'password' => Hash::make($input),
        // );

        // $userPass = array(
        //     'empID' => $request->user()->emp_id,
        //     'password' => Hash::make($new_password),
        //     'time' => date('Y-m-d'),
        // );

        // $result = $this->passSave($request->user()->emp_id, $employee, $userPass, $request);

        // return response()->json($inputs, 200);
        // return back()->with('status', 'updated');

    }


    public function passSave($empID, $employee, $userPass, Request $request)
    {
        $query = DB::transaction(function () use($empID, $employee, $userPass, $request) {
            DB::table('employee')->where('emp_id', $empID)->update($employee);

            DB::table('user_passwords')->insert($userPass);

            SysHelpers::AuditLog(1, 'Password Updated by ' .$request->user()->fname. ' ' .$request->user()->lname, $request);

            return 1;
        });

        return $query;
    }

}
