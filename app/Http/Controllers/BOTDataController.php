<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class BOTDataController extends Controller
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
    //
    public function index(){

        $this->authenticateUser('view-endpoints');
        $employee =  Employee::all();
        $data['employee'] = $employee;
        return view('bot.index',$data);
    }
    public function postEmployeeData(Request $request)
    {
        $emp_id  =  $request->emp_id;
        $employee = Employee::where('emp_id',$emp_id)->first();


        $data = [
            "branchCode" => $employee->branch,
            "empName" =>  $employee->fname.' '. $employee->mname.' `'. $employee->lname,
            "empDob" =>  $employee->birthdate, // DDMMYYYYHHMM
            "empNin" =>  $employee->national_id,
            "empPosition" =>  $employee->positions->name,
            "empStatus" =>  $employee->state == 1?'Active':'Inactive',
            "empDepartment" =>  $employee->departments->name,
            "appointmentDate" => $employee->hire_date, // DDMMYYYYHHMM
            "lastPromotionDate" => $employee->hire_date, // DDMMYYYYHHMM
            "basicSalary" => $employee->salary,
            "snrMgtBenefits" => 0,
            "otherEmpBenefits" => 0,
            "gender" => $employee->gender,
            "directorsName" => 'none',
            "directorsAllowance" => 100000,
            "directorsCommittee" => 'none',
        ];

        $endpoint = '192.168.100.102:8000/api/individualInformation';
        $response = Http::post($endpoint, $data);
       // dd($response->response);
        if ($response->status() === 200) {
         $data = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response['error']['message'];

           // return $error = [$statusCode, $errorMessage];
        }

        //


        // $response = $this->postEndPointResponse('/individualInformation/', $data);

        return $response;
    }
}
