<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\AccessControll\Role;
use Error;
use App\Models\User;
use Illuminate\Http\Request;
use mysqli;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('recruitment.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        //
        return view('recruitment.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUser(Request $request)
    {   
        
        $request->validate([
            'username' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'cpassword'=>['required']
        ]);
         $password = $request->input('password');
         $cpassword = $request->input('cpassword');
         if ($password != $cpassword){
                return back()->with('notMatch','Passwords does not match');
         }
         else{
            $password=bcrypt($password);
                 $user=User::create([
                'name'=>$request->username,
                'email'=>$request->email,
                'password'=>$password
            ]);
           
             $role=Role::find(1);
              $user->roles()->attach($role);
              return redirect()->route('recruitment.login')->with('success','You have been registered successfully');
         }

         return 'You have been registered successfully';
        // $myfile = fopen('LoanCategory.txt','r') or die('Cannot open file');
        // echo fgets($myfile);
        // fclose($myfile);
        // // dd($name);
        // $details = $request->all();
        // return response()->json($details);
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
    }
}
