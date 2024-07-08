<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Termination;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Payroll\FlexPerformanceModel;
use Illuminate\Support\Facades\Session;
use App\Models\EmergencyContact;


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
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
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

            $terminationUser = null;
            $user = null;

            // Check if the user exists in the Termination table
            $terminationUser = Termination::where('employeeID', $request->emp_id)->first();

            if ($terminationUser) {
                // If the user exists in the Termination table, return a message
                return response()->json(['message' => 'User does not exist'], 404);
            } else {
                // If the user does not exist in the Termination table, fetch the user object from the User model
                $user = User::where('emp_id', $request->emp_id)->first();

                // Check if the user exists in the User model
                if (!$user) {
                    // If the user does not exist in the User model, return an appropriate response
                    return response()->json(['message' => 'User not found'], 404);
                }
            }

            // The rest of your login function logic...
            $flexPerformance= new FlexPerformanceModel();
            $authenticateCont= new AuthenticatedSessionController($flexPerformance);
            $result=$authenticateCont->dateDiffCalculate();
            session(['pass_age' => $result]);
            $pass_age = session()->get('pass_age');

            if ($user->tokens()->count() > 0) {
                $user->tokens()->delete();
            }

            $data['employee'] = $this->flexperformance_model->userprofile($request->emp_id);
            $annualleaveBalance = $this->attendance_model->getLeaveBalance(auth()->user()->emp_id, auth()->user()->hire_date, date('Y-m-d'));

            $myNewData = json_decode(json_encode($data['employee'][0]), true);
            $myNewData['accrued_days'] = $annualleaveBalance;
            $myNewData['pass_age'] = $pass_age;
            $myNewData['emegerncy'] = EmergencyContact::where('employeeID', $request->emp_id)->first();
            $referer = request()->header('referer');
            $myNewData['referer'] = $referer;

            $token = $user->createToken("API TOKEN");
            if($pass_age>=90){
                return response()->json([
                    'pass_age'=>$pass_age,
                    'emp_id'=>$request->emp_id,
                    'message' => 'Password Expired',
                ],200);
            }else {
                return response()->json([
                    'employee' => $myNewData,
                    'status' => true,
                    'message' => 'User Logged In Successfully',
                    'token' => $token->plainTextToken,
                    'tokenData' => $token
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'trace'=>$th->getTrace()
            ], 500);
        }
    }

    public function logout(){
      $id = auth()->user();
      if($id){
        if($id->tokens){
               $id->tokens()->delete();
               $msg ="Logout successful";
            return response( [ 'msg'=>$msg ],200 );


                     }} else{
                                                           $msg ="User not Found";
                                                            return response( [ 'msg'=>$msg ],404 );
                                                         }

    }


    // For user details

    public function user()
    {
        return response(
            [
                'user'=>auth()->user(),
                'emegency' =>  EmergencyContact::where('employeeID', auth()->user()->emp_id)->first()
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
