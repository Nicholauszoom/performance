<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // return 'Hello';
        $request->validate([
            'token' => ['required'],
            'email' => ['required'],
            'password' => ['required', 
                            'confirmed', 
                            Password::min(8)->letters()->numbers()->mixedCase()->symbols()->uncompromised()],
        ]);

        // dd($request->all());
        
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $password = Hash::make($request->password);

        $employee = array(
            // 'emp' => $request->username,
            'password_set' => 0,
            'password' => $password,
        );

        $userPass = array(
            // 'empID' => $request->username,
            'password' => $password,
            'time' => date('Y-m-d'),
        );

        $email = $request->email;
        // dd($employee);
        // $result = $this->passSave($request->username, $employee, $userPass, $request);

        $query = DB::transaction(function () use($email, $employee, $userPass) {
            $update =DB::table('employee')->where('email', $email)
            ->update($employee);
            $empID =DB::table('employee')->where('email', $email)->first();
            // $empID->emp_id;
            $new_arr= array_merge(['empID'=>$empID->emp_id],$userPass);
            // return ;
            DB::table('user_passwords')->insert($new_arr);
            // DB::table('user_passwords')->where('empID',$empID->emp_id)->update($new_arr);
            
            return 1;
            // RECORD AUDIT TRAIL

            // SysHelpers::AuditLog(1, 'Password Resetted by ' .$request->. ' ' .$request->user()->lname, $request);

        });
        // dd($query);
        if($query == 1){
            // return 'Inserted';
            
            // dd('ok');
            // $request->session()->flush();
            return redirect()->route('login')->with('password_set', 'Your Password resetted successfully');
        }
        else{
            return back()->with('status', 'password not resetted');
        }

        // $status = Password::reset(
        //     $request->only('username', 'password', 'password_confirmation', 'token'),
        //     function ($user) use ($request) {
        //         $user->forceFill([
        //             'password' => Hash::make($request->password),
        //             'remember_token' => Str::random(60),
        //         ])->save();

        //         event(new PasswordReset($user));
        //     }
        // );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        // return $status == Password::PASSWORD_RESET
        //             ? redirect()->route('login')->with('status', __($status))
        //             : back()->withInput($request->only('email'))
        //                     ->withErrors(['email' => __($status)]);
    }

    public function passSave($empID, $employee, $userPass, Request $request)
    {
        $query = DB::transaction(function () use($empID, $employee, $userPass, $request) {
            DB::table('employee')->where('emp_id', $empID)->update($employee);

            DB::table('user_passwords')->insert($userPass);

            // RECORD AUDIT TRAIL

            // SysHelpers::AuditLog(1, 'Password Resetted by ' .$request->. ' ' .$request->user()->lname, $request);

            return 1;
        });

        return $query;
    }
}
