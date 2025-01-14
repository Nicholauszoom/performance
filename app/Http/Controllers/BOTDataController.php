<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use App\Models\CountryCode;
use App\Models\PositionCategory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use App\Models\EMPL;
use Illuminate\Support\Facades\Auth;
use App\Models\Payroll\ReportModel;
use App\Models\Payroll\FlexPerformanceModel;
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
        // $formattedDate = $date->format('dmYHis');

        return $date;
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
        $position_category= PositionCategory::where('item_code',$employee->positions->position_category)->first()??"1";
        $cleanedStringDepartment = str_replace('&', 'and', $employee->departments->name);

        $data = [
            "branchCode" => $employee->branch,
            "empName" =>  $employee->fname.' '. $employee->mname.' `'. $employee->lname,
            "empDob" =>  $employee->birthdate, // DDMMYYYYHHMM
            "empNin" =>  $employee->national_id,
            "empPosition" =>  $employee->positions->name,
            "empPositionCategory"=> $position_category,
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
						'Content-Type: application/json',
						'Authorization: Bearer 14ee8c99777e78e8c94d0925b2dc0de267d82add43274233f21eeefacce39ecb',
						'informationCode: 1074',  // Fixed the space before the colon
					];
              $response =  $this->performCurlPost($endpoint, $headers, (json_encode($data)) );

            return $response;
        }

       public function performCurlPost($endpoint, $headers, $json_string)
{
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);

        $resultCurlPost = curl_exec($ch);
        Log::error('Curl response: ' . $resultCurlPost);

        if ($resultCurlPost === false || $resultCurlPost == null) {
            $error = curl_error($ch);
            Log::error('cURL request failed: ' . $error);
            throw new Exception('cURL request failed: ' . $error);
        }

        // Get HTTP status code
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        switch ($httpStatus) {
            case 200:
                // Successful response
                return (object) [
                    'response' => 'Data sent successful',
                    'http_status' => $httpStatus,
                ];
            case 400:
                // Bad Request
                return (object) [
                    'response' => 'Bad Request',
                    'http_status' => $httpStatus,
                ];
            case 404:
                // Not Found
                return (object) [
                    'response' => 'Resource Not Found',
                    'http_status' => $httpStatus,
                ];
            case 500:
                // Internal Server Error
                return (object) [
                    'response' => 'Internal Server Error',
                    'http_status' => $httpStatus,
                ];
            // Add more cases as needed for other status codes

            default:
                // Handle other status codes
                return (object) [
                    'response' => 'Unexpected HTTP status: ' . $httpStatus,
                    'http_status' => $httpStatus,
                ];
        }
    } catch (\Exception $e) {
        Log::error('cURL Request Error: ' . $e->getTraceAsString());
        return (object) [
            'response' => 'Error during cURL request: ' . $e->getMessage(),
            'http_status' => 0, // You can set a default status code here or handle it as needed
        ];
    } finally {
        curl_close($ch);
    }
}



        public function contractNameExtraction($contractType){
            $contractName = Contract::where('item_code', $contractType)->pluck('name')->first();
            
            if($contractName=='Permanent'){
                return "Permanent and pensionable";
            }
            else if($contractName=='Fixed Term'){
                return "Contractual";
            }else{
                return "Temporary";
            }
        }


        // public function postEmployeeData(Request $request)
        // {
        //     if ($request->emp_id === 'all') {
        //        $employees= Employee::get();
        //        $position_category= PositionCategory::where('item_code',$employee->positions->position_category)->first();

        //         $responses = [];

        //         foreach ($employees as $employee) {

        //             $data = [
        //                 "branchCode" => $employee->branch,
        //                 "empIdentificationType"=>"NationalIdentityCard",
        //                 "empIdentificationNumber" => $this->removeSpecialCharacters($employee->national_id),
        //                 "empPositionCategory"=> $position_category!=null?$position_category:"1",
        //                 "empName" =>  $employee->fname.' '. $employee->mname.' `'. $employee->lname,
        //                 "empDob" =>  ($employee->birthdate), // DDMMYYYYHHMM
        //                 "empNin"=>"0",
        //                 "empPosition" =>  $this->removeSpecialCharacters($employee->positions->name),
        //                 "empStatus" => $this->contractNameExtraction($employee->contract_type),
        //                 "empDepartment" =>  $this->removeSpecialCharacters($employee->departments->name),
        //                 "appointmentDate" =>($employee->hire_date),
        //                 "empNationality"=>"Tanzanian",
        //                 "lastPromotionDate" =>($employee->hire_date), // DDMMYYYYHHMM
        //                 "basicSalary" => $employee->salary,
        //                 "snrMgtBenefits" => '0',
        //                 "otherEmpBenefits" => '0',
        //                 "gender" => $employee->gender,
        //                 // "reportingDate"=>($employee->hire_date),

        //                 // "directorsName" => 'none',
        //                 // "directorsAllowance" => '0',
        //                 // "directorsCommittee" => 'none',
        //             ];

        //             $response = $this->sendEmployeeData($data);

        //             // if ($response->status() === 200) {
        //             //     $responseData = $response->json();
        //             //     $responses[] = $responseData; // Collect response data for all employees
        //             // } else {
        //             //     $statusCode = $response->status();
        //             //     $errorMessage = $response['error']['message'];
        //             //     // Handle error if needed for each employee
        //             // }

        //             $newres = json_encode($response);

        //             session()->flash('status', $newres);


        //             $employee =  Employee::all();
        //             $data['employee'] = $employee;



        //         }
        //         return view('bot.index', compact('newres','employee'));

        //         // return $responses; // Return array of responses for all employees
        //     } else {
        //         $emp_id = $request->emp_id;
        //         $employee = Employee::where('emp_id', $emp_id)->first();
        //         $position_category= PositionCategory::where('item_code',$employee->positions->position_category)->first()??"1";
               

        //         $data = [
        //             "branchCode" => $employee->branch,
        //                 "empIdentificationType"=>"NationalIdentityCard",
        //                 "empIdentificationNumber" => $this->removeSpecialCharacters($employee->national_id),
        //                 "empPositionCategory"=> $position_category!=null?$position_category:"1",
        //                 "empName" =>  $employee->fname.' '. $employee->mname.' `'. $employee->lname,
        //                 "empDob" =>  ($employee->birthdate), // DDMMYYYYHHMM
        //                 "empNin"=>"0",
        //                 "empPosition" =>  $this->removeSpecialCharacters($employee->positions->name),
        //                 "empStatus" => $this->contractNameExtraction($employee->contract_type),
        //                 "empDepartment" =>  $this->removeSpecialCharacters($employee->departments->name),
        //                 "appointmentDate" =>($employee->hire_date),
        //                 "empNationality"=>"Tanzanian",
        //                 "lastPromotionDate" =>($employee->hire_date), // DDMMYYYYHHMM
        //                 "basicSalary" => $employee->salary,
        //                 "snrMgtBenefits" => '0',
        //                 "otherEmpBenefits" => '0',
        //                 "gender" => $employee->gender,
        //         ];

        //         $response = $this->sendEmployeeData($data);

        //         // if ($response->status() === 200) {
        //         //     $responseData = $response->json();
        //         // } else {
        //         //     $statusCode = $response->status();
        //         //     $errorMessage = $response['error']['message'];
        //         //     // Handle error for the single employee request
        //         // }

        //         $response = $this->sendEmployeeData($data);


        //         $newres = json_encode($response);
        //         session()->flash('status', $newres);
        //         // dd($newres);
        //             $employee =  Employee::all();
        //             $data['employee'] = $employee;

        //             return view('bot.index', compact('newres','employee'));
        //     }
        // }


        public function postEmployeeData(Request $request)
{
    if ($request->emp_id === 'all') {
        return $this->postAllEmployeesData();
    } else {
        return $this->postSingleEmployeeData($request->emp_id);
    }
}
private function postAllEmployeesData()
{
    $employees = Employee::get();
    $responses = [];

    $commonResponse = null;

    foreach ($employees as $employee) {
        $data = $this->prepareEmployeeData($employee);
        $response = $this->sendEmployeeData($data);
        
        // Always encode response as JSON before storing in $responses
        $encodedResponse = json_encode($response);
        $responses[] = $encodedResponse;

        if ($commonResponse === null) {
            $commonResponse = $encodedResponse; // Initialize common response with the first response
        } elseif ($commonResponse !== $encodedResponse) {
            $commonResponse = null; // Reset common response if current response differs
        }
    }

    // Store either all responses or the single common response in the session
    session()->flash('status', $commonResponse !== null ? $commonResponse : json_encode($responses));

    $employee =  Employee::all();
    return view('bot.index', compact('responses', 'employee'));
}


private function postSingleEmployeeData($emp_id)
{
    $employee = Employee::where('emp_id', $emp_id)->first();
    $data = $this->prepareEmployeeData($employee);
    $response = $this->sendEmployeeData($data);

    // Always encode response as JSON before storing in session
    session()->flash('status', json_encode($response));
    
    $employee =  Employee::all();
    return view('bot.index', compact('response', 'employee'));
}

private function prepareEmployeeData($employee)
{
     $flexPerformanceModel= new FlexPerformanceModel();
     $reportModel= new ReportModel();
    
//      $data = [];
//      $payrollMonths = $flexPerformanceModel->payroll_month_list2($employee->emp_id);
     
//      foreach ($payrollMonths as $month) {
//          $allowances = $reportModel->allowances($employee->emp_id, $month->payroll_date);
//          foreach ($allowances as $allowance) {
//              $data[] = $allowance->description; // Accessing description property directly
//          }
//      }
     

     


//  $datasd =[
//     "Fuel Allowance",
//     "Car maintanance",
//     "Motor vehicle",
//     "Security allowance",
//     "Child and Education allowance",
//     "House keeping allowance",
//     "House rent allowance",
//     "Communication Device",
//     "Entertainment allowance",
//     "Responsibilities Allowance",
//     "Utilities Allowance",
//     "Furniture & Fittings",
//     "Spouse allowance",
//     "Meal Allowance ",
//     "Transport Allowance",
//     "Airtime ",
    
//  ];
    $position_category = PositionCategory::where('item_code', $employee->positions->position_category)->first();
    $nationality= CountryCode::where('item_code',$employee->nationality)->first();

    return [
        "branchCode" => $employee->branch,
        "empIdentificationType" => "NationalIdentityCard",
        "empIdentificationNumber" => $this->removeSpecialCharacters($employee->national_id),
        "empPositionCategory" => $position_category!=null?$position_category->item_value:"Non-Senior management",
        "empName" => $employee->fname . ' ' . $employee->mname . ' ' . $employee->lname,
        "empDob" => ($employee->birthdate),
        "empNin" => $this->removeSpecialCharacters($employee->national_id),
        "empPosition" => $this->removeSpecialCharacters($employee->positions->name),
        "empStatus" => $this->contractNameExtraction($employee->contract_type),
        "empDepartment" => $this->removeSpecialCharacters($employee->departments->name),
        "appointmentDate" => ($employee->hire_date),
        "empNationality" => $nationality->item_value,
        "lastPromotionDate" => ($employee->hire_date),
        "basicSalary" => $employee->salary,
        // "empBenefits"=>  [],
        "gender" => $employee->gender,
        "snrMgtBenefits" => "Transport Allowance",
        "otherEmpBenefits" => "Transport Allowance",
    ];
}



}
