<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Payroll\FlexPerformanceModel;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    protected $flexperformance_model;
    protected $imprest_model;
    protected $reports_model;
    protected $attendance_model;
    protected $project_model;
    protected $performanceModel;
    protected $payroll_model;

    public function __construct( FlexPerformanceModel $flexperformance_model)
    {
        $this->flexperformance_model = $flexperformance_model;
        $this->attendance_model= new AttendanceModel();
       // $this->middleware('web');

    }
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function login(Request $request)
    {

        try {
            $validateUser = Validator::make($request->all(),
            [
                'emp_id' => 'required',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['emp_id', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('emp_id', $request->emp_id)->first();
            if ($user->tokens()->count() > 0) {
                $user->tokens()->delete();
            }




            $result=$this->dateDiffCalculate();
            session(['pass_age' => $result]);

            $pass_age = session()->get('pass_age');
            // $pass_age = session()->all();
             //  dd(session()->all());

            $data['employee'] = $this->flexperformance_model->userprofile($request->emp_id);
            //$annualleaveBalance = $this->attendance_model->getLeaveBalance($user->hire_date, date('Y-m-d'));
            $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id,auth()->user()->hire_date, date('Y-m-d'));
            //$annualleaveBalance = 12;
            $myNewData = json_decode(json_encode($data['employee'][0]), true);
            $myNewData['accrued_days'] = $annualleaveBalance;
            $myNewData['pass_age'] = $pass_age;
            $myNewDataJson = json_encode($myNewData);

            $token = $user->createToken("API TOKEN");
            return response()->json([
                'employee'=>$myNewData,
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $token->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    // For user details

    public function user()
    {
        return response(
            [
                'user'=>auth()->user()
            ],200);
    }
    public function dateDiffCalculate(){
        $from = $this->password_age(Auth::user()->emp_id);
        if($from == '0'){
            return '0';
        }
        $from = date_create($from);

        $today=date_create(date('Y-m-d'));

        $diff=date_diff($from, $today);

        $accrued = $diff->format("%a%") + 1;
        return $accrued;
    }
    public function password_age($empID)
	{

        $query = DB::table('user_passwords')->select('time')->where('empID', Auth::user()->emp_id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->first();
       if($query != null){
           //dd($query->time);
            return $query->time;

       }
         else{
              return '0';
         }

	}
}
