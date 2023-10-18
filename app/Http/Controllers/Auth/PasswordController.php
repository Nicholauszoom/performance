<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SysHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordValidationRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing;
use App\Providers\RouteServiceProvider;

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

    public function updatePassword(PasswordValidationRequest $request)
    {

        $validated = $request->validated();

        $employee = array(
            'password' => Hash::make($validated['password']),
        );

        $userPass = array(
            'empID' => $request->user()->emp_id,
            'password' => Hash::make($validated['password']),
            'time' => date('Y-m-d'),
        );

        $result = $this->passSave($request->user()->emp_id, $employee, $userPass, $request);

        // dd($result);

        return back()->with('status', 'updated');

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
