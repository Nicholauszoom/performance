<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Exception;
use DateTime;

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

    public function convertDate($date){
        $date = new DateTime($date);
        $formattedDate = $date->format('dmYHis');

        return $formattedDate;
    }

    public function convertGenderOutput($gender){
        if($gender == 'Female'){
            return '2';
        }else{
            return '1';
        }

    }
    public function postEmployeeData1(Request $request)
    {
        $emp_id  =  $request->emp_id;
        $employee = Employee::where('emp_id',$emp_id)->first();
        $cleanedStringDepartment = str_replace('&', 'and', $employee->departments->name);

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
        return $response;
    }

    public function removeSpecialCharacters($statement) {
        $cleanedString = str_replace(['&', '-'], ['and', ''], $statement);
        return $cleanedString;
    }

     public function sendEmployeeData($data)
        {
            $endpoint = 'http://compliance.bancabc.co.tz/api/employeerecord';

            $headers = [
                'Content-Type : application/json',
                'informationCode : 1074',
                'Authorization : Bearer 14ee8c99777e78e8c94d0925b2dc0de267d82add43274233f21eeefacce39ecb',
            ];
            // $headers = [
            //     'Authorization: key=' . $fcmServerKey,
            //     'Content-Type: application/json',
            // ];
           

            // $response = Http::withHeaders($headers)->post($endpoint, $data);
           
            // $postDataJson = json_encode($data);
        
              $response =  $this->performCurlPost($endpoint, $headers, (json_encode($data)) );

            return $response;
        }

        public function performCurlPost($endpoint, $headers, $json_string)
    {
        try {
           
    
            $ch = curl_init($endpoint);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_TIMEOUT, 50);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);

            $resultCurlPost = curl_exec($ch);

            if ($resultCurlPost === false || $resultCurlPost == null) {
                $error = curl_error($ch);
                Log::error('cURL request failed: ' . $error);
                throw new Exception('cURL request failed: ' . $error);
            }

            // Get HTTP status code
            $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            Log::info('<<<<<< Before decode curl >>>>>>');

            Log::info($resultCurlPost);

            // $resultCurlPost = json_decode($resultCurlPost);

            // Log::info('<<<<<< After decode curl >>>>>>');

            // Log::info($resultCurlPost);

            if ($resultCurlPost === null && json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Error decoding JSON response: ' . json_last_error_msg());
                throw new Exception('Error decoding JSON response');
            }

            return $resultCurlPost;
        } catch (\Exception $e) {

            Log::error('cURL Request Error: ' . $e->getMessage());

            return (object) [
                'response' => 'Error during cURL request: ' . $e->getMessage(),
                'http_status' => 0, // You can set a default status code here or handle it as needed
            ];
        }
    }

        public function postEmployeeData(Request $request)
        {
            if ($request->emp_id === 'all') {
                $employees = Employee::all();
                $responses = [];

                foreach ($employees as $employee) {

                    $data = [
                        "reportingDate"=>$this->convertDate($employee->hire_date),
                        "branchCode" => $employee->branch,
                        "empName" =>  $employee->fname.' '. $employee->mname.' `'. $employee->lname,
                        "empDob" =>  $this->convertDate($employee->birthdate), // DDMMYYYYHHMM
                        "empNin" => $this->removeSpecialCharacters($employee->national_id),
                        "empPosition" =>  $this->removeSpecialCharacters($employee->positions->name),
                        "empStatus" =>  $employee->contract_type,
                        "empDepartment" =>  $this->removeSpecialCharacters($employee->departments->name),
                        "appointmentDate" =>$this->convertDate($employee->hire_date), // DDMMYYYYHHMM
                        "lastPromotionDate" =>$this->convertDate($employee->hire_date), // DDMMYYYYHHMM
                        "basicSalary" => $employee->salary,
                        "snrMgtBenefits" => 0,
                        "otherEmpBenefits" => 0,
                        "gender" => $this->convertGenderOutput($employee->gender),
                        "directorsName" => 'none',
                        "directorsAllowance" => 100000,
                        "directorsCommittee" => 'none',
                    ];

                    $response = $this->sendEmployeeData($data);

                    // if ($response->status() === 200) {
                    //     $responseData = $response->json();
                    //     $responses[] = $responseData; // Collect response data for all employees
                    // } else {
                    //     $statusCode = $response->status();
                    //     $errorMessage = $response['error']['message'];
                    //     // Handle error if needed for each employee
                    // }

                    $newres = json_encode($response);
                    session()->flash('status', $newres);

                    $employee =  Employee::all();
                    $data['employee'] = $employee;
                  

                    return view('bot.index', compact('newres','employee'));
                }

                return $responses; // Return array of responses for all employees
            } else {
                $emp_id = $request->emp_id;
                $employee = Employee::where('emp_id', $emp_id)->first();

                $data = [
                    "reportingDate"=>$this->convertDate($employee->hire_date),
                    "branchCode" => $employee->branch,
                    "empName" =>  $employee->fname.' '. $employee->mname.' `'. $employee->lname,
                    "empDob" =>  $this->convertDate($employee->birthdate), // DDMMYYYYHHMM
                    "empNin" => $this->removeSpecialCharacters($employee->national_id),
                    "empPosition" =>  $this->removeSpecialCharacters($employee->positions->name),
                    "empStatus" =>  $employee->contract_type,
                    "empDepartment" =>  $this->removeSpecialCharacters($employee->departments->name),
                    "appointmentDate" =>$this->convertDate($employee->hire_date), // DDMMYYYYHHMM
                    "lastPromotionDate" =>$this->convertDate($employee->hire_date), // DDMMYYYYHHMM
                    "basicSalary" => $employee->salary,
                    "snrMgtBenefits" => 0,
                    "otherEmpBenefits" => 0,
                    "gender" => $this->convertGenderOutput($employee->gender),
                    "directorsName" => 'none',
                    "directorsAllowance" => 100000,
                    "directorsCommittee" => 'none',
                ];

                $response = $this->sendEmployeeData($data);

                // if ($response->status() === 200) {
                //     $responseData = $response->json();
                // } else {
                //     $statusCode = $response->status();
                //     $errorMessage = $response['error']['message'];
                //     // Handle error for the single employee request
                // }

                $response = $this->sendEmployeeData($data);

            
                $newres = json_encode($response);
                session()->flash('status', $newres);
                // dd($newres);
                    $employee =  Employee::all();
                    $data['employee'] = $employee;
                    
                    return view('bot.index', compact('newres','employee'));
            }
        }
}
