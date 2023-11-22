<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;

use App\Charts\EmployeeLineChart;
use App\Exports\LeaveApprovalsExport;
use App\Helpers\SysHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Imports\HolidayDataImport;
use App\Imports\ImportSalaryIncrement;
use App\Models\AccessControll\Departments;
use App\Models\AdhocTask;
use App\Models\ApprovalLevel;
use App\Models\Approvals;
use App\Models\AttendanceModel;
use App\Models\BankBranch;
use App\Models\BehaviourRatio;
use App\Models\Disciplinary;
use App\Models\EducationQualification;
use App\Models\EmailNotification;
use App\Models\EmergencyContact;
use App\Models\EMPL;
use App\Models\Employee;
use App\Models\EmployeeComplain;
use App\Models\EmployeeDependant;
use App\Models\EmployeeDetail;
use App\Models\EmployeeParent;
use App\Models\EmployeePerformance;
use App\Models\EmployeeSkills;
use App\Models\EmployeeSpouse;
use App\Models\EmploymentHistory;
use App\Models\FinancialLogs;
use App\Models\Grievance;
use App\Models\Holiday;
use App\Models\InputSubmission;
use App\Models\LeaveApproval;
use App\Models\LeaveForfeiting;
use App\Models\EmployeeTemporaryAllowance;

//use PHPClamAV\Scanner;
use App\Models\Leaves;
use App\Models\LoanType;
use App\Models\Payroll\FlexPerformanceModel;
use App\Models\Payroll\ImprestModel;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\ReportModel;
use App\Models\PerformanceModel;
use App\Models\PerformanceRatio;
use App\Models\Position;
use App\Models\PositionSkills;
use App\Models\ProfessionalCertification;
use App\Models\Project;
use App\Models\ProjectModel;
use App\Models\ProjectTask;
use App\Models\Promotion;
use App\Models\Role;
use App\Models\TargetRatio;
use App\Models\Termination;
use App\Models\TimeRatio;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\EmailRequests;
use App\Notifications\RegisteredUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\Importable;
// use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class GeneralController extends Controller
{
    protected $flexperformance_model;
    protected $imprest_model;
    protected $reports_model;
    protected $attendance_model;
    protected $project_model;
    protected $performanceModel;
    protected $payroll_model;

    public function __construct(Payroll $payroll_model, FlexPerformanceModel $flexperformance_model, ReportModel $reports_model, ImprestModel $imprest_model, PerformanceModel $performanceModel)
    {
        $this->flexperformance_model = $flexperformance_model;
        $this->imprest_model = new ImprestModel();
        $this->reports_model = new ReportModel();
        $this->attendance_model = new AttendanceModel();
        $this->project_model = new ProjectModel();
        $this->performanceModel = new PerformanceModel();
        $this->payroll_model = new Payroll;
    }

    public function authenticateUser($permissions)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->can($permissions)) {

            abort(Response::HTTP_UNAUTHORIZED);
        }
    }

    public function update_login_info(Request $request)
    {

        if ($request->method() == "POST") {
            $empID = auth()->user()->emp_id;

            $username = $request->input('username');
            $password = $request->input('password');
            $password_conf = $request->input('conf_password');

            if ($username != '' && $password != '' && $password == $password_conf) {
                if ($this->checkPassword($password)) {
                    $password_hash = password_hash(trim($password), PASSWORD_BCRYPT);
                    $data = array(
                        'username' => $username,
                        'password' => $password_hash,
                        'password_set' => "0",
                        'last_updated' => date('Y-m-d'),

                    );
                    $result = $this->flexperformance_model->updateEmployee($data, $empID);

                    if ($result) {
                        $data = array(
                            'empID' => auth()->user()->emp_id,
                            'password' => $password_hash,
                            'time' => date('Y-m-d'),
                        );

                        $this->flexperformance_model->insert_user_password($data);
                        $response_array['status'] = 'OK';
                        echo json_encode($response_array);
                        // $this->logout();

                    } else {
                        $response_array['status'] = 'ERR';
                        echo json_encode($response_array);
                    }
                } else {
                    $response_array['status'] = 'ERR_P';
                    echo json_encode($response_array);
                }
            } else {
                $response_array['status'] = 'ERR';
                echo json_encode($response_array);
            }
        } else {
            $response_array['status'] = 'ERR';
            echo json_encode($response_array);
        }
    }

    public function logout(Request $request)
    {
        // $this->session->sess_destroy();
        return redirect('/flex/Base_controller/');
    }

    public function userprofile(Request $request, $id)
    {

        $id = base64_decode($id);

        if (auth()->user()->emp_id != $id) {
            $this->authenticateUser('edit-employee');
        }

        $extra = $request->input('extra');
        $data['employee'] = $this->flexperformance_model->userprofile($id);

        // dd($data['employee'] );
        $data['kin'] = $this->flexperformance_model->getkin($id);
        $data['property'] = $this->flexperformance_model->getproperty($id);
        $data['propertyexit'] = $this->flexperformance_model->getpropertyexit($id);
        $data['active_properties'] = $this->flexperformance_model->getactive_properties($id);
        $data['allrole'] = $this->flexperformance_model->role($id);
        $data['role'] = $this->flexperformance_model->getuserrole($id);
        $data['rolecount'] = $this->flexperformance_model->rolecount($id);
        $data['task_duration'] = $this->performanceModel->total_task_duration($id);
        $data['task_actual_duration'] = $this->performanceModel->total_task_actual_duration($id);
        $data['task_monetary_value'] = $this->performanceModel->all_task_monetary_value($id);
        $data['allTaskcompleted'] = $this->performanceModel->allTaskcompleted($id);

        $data['skills_missing'] = $this->flexperformance_model->skills_missing($id);

        $data['requested_skills'] = $this->flexperformance_model->requested_skills($id);
        $data['skills_have'] = $this->flexperformance_model->skills_have($id);
        $data['month_list'] = $this->flexperformance_model->payroll_month_list();
        $data['title'] = "Profile";

        $data['employee_pension'] = $this->reports_model->employee_pension($id);

        //dd($data['employee_pension']);
        $data['qualifications'] = EducationQualification::where('employeeID', $id)->get();

        $data['photo'] = "";

        $data['parent'] = "Employee Profile";

        return view('employee.userprofile', $data);

        // return view('employee.employee-biodata', $data);

    }

    public function contract_expire(Request $request)
    {

        $data['contract_expire'] = $this->flexperformance_model->contract_expiration_list();
        $data['title'] = "Contract";
        return view('app.contract_expire', $data);
    }

    public function retire(Request $request)
    {

        $data['retire'] = $this->flexperformance_model->retire_list();
        $data['title'] = "Contract";
        return view('app.retire', $data);
    }

    public function contract(Request $request)
    {

        $data['contract'] = $this->flexperformance_model->contract();
        $data['title'] = "Contract";
        return view('app.contract', $data);
    }

    public function addContract(Request $request)
    {
        if ($request->method() == "POST") {
            $data = array(
                'name' => $request->input('name'),
                'duration' => $request->input('duration'),
                'reminder' => $request->input('alert'),
            );

            $result = $this->flexperformance_model->contractAdd($data);
            if ($result == true) {
                $response_array['status'] = "OK";
                $response_array['title'] = "SUCCESS";
                $response_array['message'] = "<p class='alert alert-success text-center'>Contract Registered Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['title'] = "FAILED";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Contract Not Registered, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        } else {
            $response_array['status'] = "ERR";
            $response_array['title'] = "FAILED";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Incorrect Values</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function updatecontract(Request $request)
    {
        $id = $request->input('id');

        $data['contract'] = $this->flexperformance_model->getcontractbyid($id);
        $data['title'] = "Contract";
        return view('app.update_contract', $data);

        if (isset($_POST['update']) && $id != '') {
            $updates = array(
                'name' => $request->input('name'),
                'duration' => $request->input('duration'),
                'reminder' => $request->input('alert'),
            );
            $result = $this->flexperformance_model->updatecontract($updates, $id);
            if ($result == true) {
                session('note', "<p class='alert alert-warning text-center'>Contract Deleted Successifully</p>");
                return redirect('/flex/contract/');
            }
        }
    }

    public function deletecontract(Request $request, $id)
    {
        // $id = $this->uri->segment(3);
        $updates = array(
            'state' => 0,
        );
        $result = $this->flexperformance_model->updatecontract($updates, $id);
        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Department Deleted!</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function bank(Request $request)
    {
        if (session('mng_bank_info')) {
            $id = auth()->user()->emp_id;
            $data['banks'] = $this->flexperformance_model->bank();
            $data['branch'] = $this->flexperformance_model->bank_branch();
            $data['title'] = "Bank";
            return view('app.bank', $data);
        } else {
            echo "Unauthorized Access";
        }
    }

    public function department()
    {

        $this->authenticateUser('view-organization');
        $id = auth()->user()->emp_id;
        $data['employee'] = $this->flexperformance_model->customemployee();
        $data['cost_center'] = $this->flexperformance_model->costCenter();
        $data['parent_department'] = $this->flexperformance_model->departmentdropdown();
        $data['department'] = $this->flexperformance_model->alldepartment();
        $data['inactive_department'] = $this->flexperformance_model->inactive_department();
        $data['departments'] = Departments::all();
        $data['title'] = "Department";
        $data['parent'] = "Organisation";
        $data['child'] = "Departments";

        // dd($data['department']);

        return view('app.department', $data);
    }

    public function departmentCost()
    {
        $data['projects'] = $this->flexperformance_model->costProjects();
        $data['departments'] = $this->flexperformance_model->costDepartments();
        $data['parent'] = "Department";
        $data['child'] = "Costs";

        return view('department-cost.index', $data);
    }

    public function storeDepartmentCost(Request $request)
    {

        $type = $request->type;

        if ($type == 1) {
            $data = [
                // 'type' => $request->type,
                'project_id' => $request->project,
                'from_department' => $request->from_department,
                'to_department' => $request->to_department,
                'amount' => $request->amount,
                'description' => $request->description,
            ];

            DB::table('department_cost_transfer')->insert($data);
        } else {
            $data = [
                'department_id' => $request->department,
                'project_id' => $request->project,
                'type' => $request->type,
                'amount' => $request->amount,
                'description' => $request->description,
            ];

            DB::table('department_cost')->insert($data);
        }
    }

    public function organization_level(Request $request)
    {
        $data['level'] = $this->flexperformance_model->getAllOrganizationLevel();
        $data['title'] = "Department";
        return view('app.organization_level', $data);
    }

    public function organization_level_info(Request $request, $id)
    {
        // $id = base64_decode($this->input->get('id'));
        $data['title'] = 'Organization Level';
        $data['category'] = $this->flexperformance_model->organization_level_info($id);

        return view('app.organization_level_info', $data);
    }

    public function alldepartment(Request $request)
    {
        $id = auth()->user()->emp_id;
        $data['department'] = $this->flexperformance_model->alldepartment();
        $data['title'] = "Department";
        return view('app.department', $data);
    }

    public function updateOrganizationLevelName(Request $request)
    {
        $ID = $request->input('levelID');
        $method = $request->method();
        if ($method == 'POST' && $ID != '') {
            $updates = array(
                'name' => $request->input('name'),
            );
            $result = $this->flexperformance_model->updateOrganizationLevel($updates, $ID);
            if ($result == true) {
                return back()->with('success', 'Organization Level Updated Successifully!');
                // echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }
    public function updateMinSalary(Request $request)
    {
        $ID = $request->input('levelID');
        $method = $request->method();
        if ($method == 'POST' && $ID != '') {
            $updates = array(
                'minSalary' => $request->input('minSalary'),
            );
            $result = $this->flexperformance_model->updateOrganizationLevel($updates, $ID);
            if ($result == true) {
                return back()->with('success', 'Organization Level Updated Successifully!');
                // echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }
    public function updateMaxSalary(Request $request)
    {
        $ID = $request->input('levelID');
        $method = $request->method();
        if ($method == 'POST' && $ID != '') {
            $updates = array(
                'maxSalary' => $request->input('maxSalary'),
            );
            $result = $this->flexperformance_model->updateOrganizationLevel($updates, $ID);
            if ($result == true) {
                return back()->with('success', 'Organization Level Updated Successifully!');
                // echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function departmentAdd(Request $request)
    {

        if ($request->method() == "POST") {
            $values = explode('|', $request->input('parent'));
            $parent_id = $values[0];
            $parent_code = $values[1];
            $parent_level = $values[2];
            $departmentData = array(
                'name' => $request->input('name'),
                'hod' => $request->input('hod'),
                'cost_center_id' => $request->input('cost_center_id'),
                'department_pattern' => $this->code_generator(6),
                'parent_pattern' => $parent_code,
                'reports_to' => $parent_id,
                'level' => $parent_level + 1,
                'created_by' => auth()->user()->emp_id,
            );

            $identifiers = $this->flexperformance_model->departmentAdd($departmentData);
            if (!empty($identifiers)) {
                foreach ($identifiers as $key) {
                    $departmentID = $key->depID;
                    // $positionID = $key->posID;
                }
                $code = sprintf("%03d", $departmentID);

                $result = $this->flexperformance_model->updateDepartmentPosition($code, $departmentID);
                if ($result == true) {
                    echo "<p class='alert alert-success text-center'>Department Registered Successifully</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>Department Registration has FAILED, Contact Your Admin</p>";
                }
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED! Department Registration was Unsuccessifull, Please Try Again</p>";
            }
        }
    }

    public function branch(Request $request)
    {
        $this->authenticateUser('view-organization');
        $id = auth()->user()->emp_id;
        $data['branch'] = $this->flexperformance_model->branch();
        // $data['department'] = $this->flexperformance_model->alldepartment();
        $data['countrydrop'] = $this->flexperformance_model->countrydropdown();
        $data['title'] = "Company Branch";
        return view('app.branch', $data);
    }

    public function costCenter()
    {
        $this->authenticateUser('view-organization');
        $id = auth()->user()->emp_id;
        $data['cost_center'] = $this->flexperformance_model->costCenter();
        $data['countrydrop'] = $this->flexperformance_model->countrydropdown();
        $data['title'] = "Cost Center";
        return view('app.cost_center', $data);
    }

    public function nationality(Request $request)
    {
        $id = auth()->user()->emp_id;
        $data['nationality'] = $this->flexperformance_model->nationality();
        $data['title'] = "Employee Nationality";
        return view('app.nationality', $data);
    }

    public function addEmployeeNationality(Request $request)
    {
        if ($request->method() == "POST") {

            $data = array(
                'name' => $request->input('name'),
                'code' => $request->input('code'),
            );
            $result = $this->flexperformance_model->addEmployeeNationality($data);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Country Added Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED, Country Not Added. Please Try Again</p>";
            }
        }
    }

    public function deleteCountry(Request $request, $code)
    {
        // if ($this->uri->segment(3) != '') {
        // $code = $this->uri->segment(3);
        $checkEmployee = $this->flexperformance_model->checkEmployeeNationality($code);
        if ($checkEmployee > 0) {
            echo "<p class='alert alert-warning text-center'>WARNING, Country Can Not Be Deleted, Some Employee Have Nationality From This Country.</p>";
        } else {
            $result = $this->flexperformance_model->deleteCountry($code);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Country Deleted Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED, Country Not Deleted. Please Try Again</p>";
            }
        }
        // }

    }

    public function CompanyInfo(Request $request)
    {

        $this->authenticateUser('view-setting');

        if ($request->method() == "POST") {

            $data = array(
                'name' => $request->input('name'),
                //'department_id' => $request->input('department_id'),
                'street' => $request->input('street'),
                'region' => $request->input('region'),
                'code' => "0",
                'country' => $request->input('country'),
            );

            $result = $this->flexperformance_model->addCompanyInfo($data);

            if ($result == true) {
                return redirect()->route('flex.companyInfo');
                echo "<p class='alert alert-success text-center'>Branch Added Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED, Compay Info Not Added. Please Try Again</p>";
            }
        } else {

            $data['data'] = $this->flexperformance_model->getCompanyInfo();

            return view('app.company_info', $data);
        }
    }

    public function UpdateCompanyInfo(Request $request)
    {
        //if ($request->method() == "PUT") {
        $id = $request->id;
        $data = $request->except('_token', '_method');
        $result = $this->flexperformance_model->updateCompanyInfo($data, $id);
        if ($result == true) {
            return redirect()->back();
            // echo "<p class='alert alert-success text-center'>Branch Updated Successifully!</p>";
        } else {
            return redirect()->back();
            // echo "<p class='alert alert-danger text-center'>FAILED, Compay Info Not Updated. Please Try Again</p>";
        }
        // }else{
        //     $data['data'] = $this->flexperformance_model->getCompanyInfoById($id);
        //     $data['id'] = $id;

        //     return view('app.compay_info',$data);

        // }

    }

    public function addCompanyBranch(Request $request)
    {
        if ($request->method() == "POST") {

            $data = array(
                'name' => $request->input('name'),
                //'department_id' => $request->input('department_id'),
                'street' => $request->input('street'),
                'region' => $request->input('region'),
                'code' => "0",
                'country' => $request->input('country'),
            );
            $branchID = $this->flexperformance_model->addCompanyBranch($data);
            if ($branchID > 0) {
                $code = sprintf("%03d", $branchID);
                $updates = array(
                    'code' => $code,
                );
                $result = $this->flexperformance_model->updateCompanyBranch($updates, $branchID);
                if ($result == true) {
                    return redirect()->back();
                    //  echo "<p class='alert alert-success text-center'>Branch Added Successifully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>FAILED, Branch Not Added. Please Try Again</p>";
                }
            } else {
                echo "<p class='alert alert-danger text-center'>Branch Code: FAILED, Branch Not Added. Please Try Again</p>";
            }
        }
    }

    public function addCostCenter(Request $request)
    {
        if ($request->method() == "POST") {

            $data = array(
                'name' => $request->input('name'),

                'region' => '-',

                'country' => '-',
            );
            $branchID = $this->flexperformance_model->addCostCenter($data);
            if ($branchID > 0) {

                echo "<p class='alert alert-success text-center'>Cost Center Added Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Branch Code: FAILED, Branch Not Added. Please Try Again</p>";
            }
        }
    }

    public function updateCompanyBranch(Request $request)
    {

        if (isset($_POST['update']) && $request->input('branchID') != '') {
            $branchID = $request->input('branchID');
            $updates = array(
                'name' => $request->input('name'),
                'department_id' => $request->input('department_id'),
                'region' => $request->input('region'),
                'street' => $request->input('street'),
            );

            $result = $this->flexperformance_model->updateCompanyBranch($updates, $branchID);
            if ($result) {
                session('note', "<p class='alert alert-success text-center'>Updated Successifully</p>");
                return redirect('/flex/branch/');
            } else {
                session('note', "<p class='alert alert-success text-danger'>FAILED to Update</p>");
                return redirect('/flex/branch/');
            }
        }
    }

    public function updateCostCenter(Request $request)
    {

        $branchID = $request->input('costCenterID');
        $updates = array(
            'name' => $request->input('name'),
        );

        $result = $this->flexperformance_model->updateCostCenter($updates, $branchID);
        if ($result) {
            session('note', "<p class='alert alert-success text-center'>Updated Successifully</p>");
            return redirect('/flex/costCenter/');
        } else {
            session('note', "<p class='alert alert-success text-danger'>FAILED to Update</p>");
            return redirect()->back();
        }
    }

    //   public function addBank(Request $request) {
    //      if(isset($_POST['add'])) {
    //         $data = array(
    //              'name' => $request->input('name'),
    //              'abbr' => $request->input('abbrv'),
    //              'bank_code' => $request->input('bank_code')
    //         );
    //         if(session('mng_bank_info')){
    //           $result = $this->flexperformance_model->addBank($data);
    //           if($result){
    //               session('note', "<p class='alert alert-success text-center'>Bank Successifully</p>");
    //               return  redirect('/flex/bank');
    //           } else {  return  redirect('/flex/bank'); }
    //         }else{
    //           echo "Unauthorized Access";
    //         }
    //     }
    //   }

    //addBank

    public function addBank(Request $request)
    {

        $name = $request->input('name');
        $abbr = $request->input('abbr');
        $bank_code = $request->input('bank_code');

        $data = array(

            "name" => $name,
            "abbr" => $abbr,
            "bank_code" => $bank_code,
        );
        DB::table('bank')->insert($data);
        echo "Record inserted successfully.<br/>";
        return redirect('flex/bank');
    }
    // end add bank

    // add branch
    // public function addBankBranch(Request $request){

    //   dd($request->name);

    //     $name = $request->input('name');
    //     $bank = $request->input('bank');
    //     $street = $request->input('street');
    //     $region = $request->input('region');
    //     $country = $request->input('country');
    //     $branch_code = $request->input('branch_code');
    //     $swiftcode = $request->input('swiftcode');

    //   $data=array(
    //    'name'=>$name,
    //    'bank'=>$bank,
    //    'street'=>$street,
    //    'region'=>$region,
    //    'country'=>$country,
    //    'branch_code'=>$branch_code,
    //    'swiftcode'=>$swiftcode

    // );
    //   DB::table('bank_branch')->insert($data);
    //   echo "Record inserted successfully.<br/>";
    //   return redirect('flex/bank');

    //   }
    //   end add branch

    public function addBankBranch(Request $request)
    {
        $method = $request->method();
        if ($method == "POST") {
            $data = array(
                'name' => $request->name,
                'bank' => $request->bank,
                'street' => $request->street,
                'region' => $request->region,
                'branch_code' => $request->code,
                'country' => $request->country,
                'swiftcode' => $request->swiftcode,
            );
            $result = $this->flexperformance_model->addBankBranch($data);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Branch Added Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Branch not Added, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function updateBank(Request $request)
    {
        $id = base64_decode($request->input("id"));
        $category = $$request->input("category");

        if ($category == 1) { //Update Bank
            $data['bank_info'] = $this->flexperformance_model->getbank($id);
            $data['category'] = 1;
            $data['title'] = "Bank Info";
            return view('app.update_bank', $data);
        } else { //Update Branch
            $data['branch_info'] = $this->flexperformance_model->getbankbranch($id);
            $data['category'] = 2;
            $data['title'] = "Bank Info";
            return view('app.update_bank', $data);
        }
    }

    public function updateBankBranchName(Request $request)
    {
        if ($request->method() == "POST") {
            $data = array(
                'name' => $request->input('name'),
                'bank' => $request->input('bank'),
                'street' => $request->input('street'),
                'region' => $request->input('region'),
                'branch_code' => $request->input('code'),
                'country' => $request->input('country'),
                'swiftcode' => $request->input('swiftcode'),
            );
            $result = $this->flexperformance_model->addBankBranch($data);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Branch Added Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Branch not Added, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function updateBankName(Request $request)
    {
        if ($request->method() == "POST" && $request->input('bankID') != '') {
            $bankID = $request->input('bankID');
            $data = array(
                'name' => $request->input('name'),
            );
            $result = $this->flexperformance_model->updateBank($data, $bankID);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Bank Name Updated Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Bank name notUpdated, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function updateAbbrev(Request $request)
    {
        if ($request->method() == "POST" && $request->input('bankID') != '') {
            $bankID = $request->input('bankID');
            $data = array(
                'abbr' => $request->input('abbrev'),
            );
            $result = $this->flexperformance_model->updateBank($data, $bankID);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'> Updated Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Not Updated, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function updateBankCode(Request $request)
    {
        if ($request->method() == "POST" && $request->input('bankID') != '') {
            $bankID = $request->input('bankID');
            $data = array(
                'bank_code' => $request->input('bank_code'),
            );
            $result = $this->flexperformance_model->updateBank($data, $bankID);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function updateBranchName(Request $request)
    {
        if ($request->method() == "POST" && $request->input('branchID') != '') {
            $branchID = $request->input('branchID');
            $data = array(
                'name' => $request->input('name'),
            );
            $result = $this->flexperformance_model->updateBankBranch($data, $branchID);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function updateBranchCode(Request $request)
    {
        if ($request->method() == "POST" && $request->input('branchID') != '') {
            $branchID = $request->input('branchID');
            $data = array(
                'branch_code' => $request->input('branch_code'),
            );
            $result = $this->flexperformance_model->updateBankBranch($data, $branchID);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function updateBranchSwiftcode(Request $request)
    {
        if ($request->method() == "POST" && $request->input('branchID') != '') {
            $branchID = $request->input('branchID');
            $data = array(
                'swiftcode' => $request->input('swiftcode'),
            );
            $result = $this->flexperformance_model->updateBankBranch($data, $branchID);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }
    public function updateBranchStreet(Request $request)
    {
        if ($request->method() == "POST" && $request->input('branchID') != '') {
            $branchID = $request->input('branchID');
            $data = array(
                'street' => $request->input('street'),
            );
            $result = $this->flexperformance_model->updateBankBranch($data, $branchID);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function updateBranchRegion(Request $request)
    {
        if ($request->method() == "POST" && $request->input('branchID') != '') {
            $branchID = $request->input('branchID');
            $data = array(
                'region' => $request->input('region'),
            );
            $result = $this->flexperformance_model->updateBankBranch($data, $branchID);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function updateBranchCountry(Request $request)
    {
        if ($request->method() == "POST" && $request->input('branchID') != '') {
            $branchID = $request->input('branchID');
            $data = array(
                'country' => $request->input('country'),
            );
            $result = $this->flexperformance_model->updateBankBranch($data, $branchID);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: NOT Updated, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }


    public function deleteDepartment($id)
    {

        $data = array(
            'state' => 0,
        );
        $result = $this->flexperformance_model->updatedepartment($data, $id);
        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Department Deleted!</p>";
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Department NOT Deleted!</p>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);
    }

    public function activateDepartment($id)
    {

        $data = array(
            'state' => 1,
        );
        $result = $this->flexperformance_model->updatedepartment($data, $id);
        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Department Activated Successifully!</p>";
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Department Activation FAILED, Please Try again!</p>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);
    }

    public function position_info($id)
    {

        $data['all_position'] = $this->flexperformance_model->allposition();
        $data['organization_levels'] = $this->flexperformance_model->getAllOrganizationLevel();
        $data['skills'] = $this->flexperformance_model->getskills($id);
        $data['accountability'] = $this->flexperformance_model->getaccountability($id);
        $data['position'] = $this->flexperformance_model->getpositionbyid($id);
        $data['title'] = "Positions";
        return view('app.position_info', $data);
    }

    public function department_info($id)
    {

        $data['employee'] = $this->flexperformance_model->customemployee();
        $data['cost_center'] = $this->flexperformance_model->costCenter();
        $data['parent_department'] = $this->flexperformance_model->departmentdropdown();
        $data['data'] = $this->flexperformance_model->getdepartmentbyid($id);
        $data['title'] = "Department";
        return view('app.department_info', $data);
    }

    ############################## LEARNING AND DEVELOPMENT(TRAINING)#############################

    public function addBudget(Request $request)
    {
        if (isset($_POST['request'])) {

            $start = $request->input('start');
            $end = $request->input('end');

            $start_calendar = str_replace('/', '-', $start);
            $finish_calendar = str_replace('/', '-', $end);

            $start_final = date('Y-m-d', strtotime($start_calendar));
            $end_final = date('Y-m-d ', strtotime($finish_calendar));
            if ($end_final <= $start_final) {
                session('note', "<p class='alert alert-warning text-center'>INVALID DATE Selection, Budget Not Added, Try Again</p>");
                return redirect('/flex/training_application');
            } else {

                $data = array(
                    'description' => $request->input('name'),
                    'start' => $start_final,
                    'end' => $end_final,
                    'amount' => $request->input('amount'),
                    'recommended_by' => auth()->user()->emp_id,
                    'date_recommended' => date('Y-m-d'),
                    'date_approved' => date('Y-m-d'),
                );
                $result = $this->flexperformance_model->addBudget($data);

                if ($result == true) {
                    session('note', "<p class='alert alert-success text-center'>Budget Added Successifully</p>");
                    return redirect('/flex/training_application');
                } else {
                    session('note', "<p class='alert alert-danger text-center'>Budget Request Has FAILED, Please Try again</p>");
                    return redirect('/flex/training_application');
                }
            }
        }
    }

    public function updateBudgetDescription(Request $request)
    {
        if ($request->method() == "POST" && $request->input('budgetID') != '') {
            $budgetID = $request->input('budgetID');
            $data = array(
                'description' => $request->input('description'),
            );
            $result = $this->flexperformance_model->updateBudget($data, $budgetID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Update, Please Try Again!</p>";
            }
        }
    }

    public function updateBudgetAmount(Request $request)
    {
        if ($request->method() == "POST" && $request->input('budgetID') != '') {
            $budgetID = $request->input('budgetID');
            $data = array(
                'amount' => $request->input('amount'),
            );
            $result = $this->flexperformance_model->updateBudget($data, $budgetID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Update, Please Try Again!</p>";
            }
        }
    }

    public function updateBudgetDateRange(Request $request)
    {
        if ($request->method() == "POST" && $request->input('budgetID') != '') {
            $budgetID = $request->input('budgetID');
            $start = $request->input('start');
            $end = $request->input('end');

            $start_calendar = str_replace('/', '-', $start);
            $finish_calendar = str_replace('/', '-', $end);

            $start_final = date('Y-m-d', strtotime($start_calendar));
            $end_final = date('Y-m-d ', strtotime($finish_calendar));
            if ($end_final <= $start_final) {
                echo "<p class='alert alert-warning text-center'>INVALID DATE Selection, Budget Not Added, Try Again</p>";
            } else {

                $data = array(
                    'start' => $start_final,
                    'end' => $end_final,
                );
                $result = $this->flexperformance_model->updateBudget($data, $budgetID);
                if ($result == true) {
                    echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>FAILED to Update, Please Try Again!</p>";
                }
            }
        }
    }

    public function approveBudget(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $budgetID = $this->uri->segment(3);
            $data = array(
                'status' => 1,
                'approved_by' => auth()->user()->emp_id,
                'date_approved' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateBudget($data, $budgetID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Budget Approved Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Approve, Please Try Again!</p>";
            }
        }
    }

    public function disapproveBudget(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $budgetID = $this->uri->segment(3);
            $data = array(
                'status' => 2,
                'approved_by' => auth()->user()->emp_id,
                'date_approved' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateBudget($data, $budgetID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Budget Disapproved Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Disapprove, Please Try Again!</p>";
            }
        }
    }

    public function deleteBudget(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $budgetID = $this->uri->segment(3);
            $result = $this->flexperformance_model->deleteBudget($budgetID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Budget Deleted Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Delete, Please Try Again!</p>";
            }
        }
    }

    public function training_application()
    {
        $empID = auth()->user()->emp_id;

        $data['budget'] = $this->flexperformance_model->budget();
        $data['my_applications'] = $this->flexperformance_model->my_training_applications($empID);
        $data['skill_gap'] = $this->flexperformance_model->skill_gap();
        $data['trainees_accepted'] = $this->flexperformance_model->accepted_applications();
        $totalCost = $this->flexperformance_model->total_training_cost();

        if (session('appr_training') != 0 && session('conf_training') != 0 && session('line') != 0) {
            $data['other_applications'] = $this->flexperformance_model->all_training_applications($empID);
        } elseif (session('appr_training') != 0 && session('conf_training') != 0) {
            $data['other_applications'] = $this->flexperformance_model->appr_conf_training_applications();
        } elseif (session('appr_training') != 0 && session('line') != 0) {
            $data['other_applications'] = $this->flexperformance_model->appr_line_training_applications($empID);
        } elseif (session('conf_training') != 0 && session('line') != 0) {
            $data['other_applications'] = $this->flexperformance_model->conf_line_training_applications($empID);
        } elseif (session('line') != 0) {
            $data['other_applications'] = $this->flexperformance_model->line_training_applications($empID);
        } elseif (session('appr_training') != 0) {
            $data['other_applications'] = $this->flexperformance_model->appr_training_applications();
        } elseif (session('conf_training') != 0) {
            $data['other_applications'] = $this->flexperformance_model->conf_training_applications();
        }

        // $data['isBudgetPresent'] =  $this->flexperformance_model->checkCurrentYearBudget(date('Y'));
        $data['course'] = $this->flexperformance_model->all_skills($empID);
        $data['title'] = "Training Application";
        $data['total_training_cost'] = $totalCost;
        return view('app.training', $data);
    }

    public function budget_info(Request $request)
    {
        $budgetID = base64_decode($this->input->get('id'));
        $data['info'] = $this->flexperformance_model->getBudget($budgetID);
        $data['title'] = "Training Budget";
        return view('app.budget_info', $data);
    }

    public function requestTraining(Request $request)
    {
        $pattern = $request->input('pattern');

        $value = explode('|', $pattern);
        $empID = $value[0];
        $course = $value[1];
        $data = array(
            'empID' => $empID,
            'skills_ID' => $course,
            'nominated_by' => auth()->user()->emp_id,
        );
        $result = $this->flexperformance_model->requesttraining($data);
        if ($result) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Request Sent</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Request sending Failed, Please try again</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function requestTraining2(Request $request)
    {
        if ($request->method() == "POST") {
            $empID = auth()->user()->emp_id;
            $course = $request->input('course');
            $data = array(
                'empID' => $empID,
                'skillsID' => $course,
                'date_recommended' => date('Y-m-d'),
                'date_approved' => date('Y-m-d'),
                'application_date' => date('Y-m-d'),
                'date_confirmed' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->requestTraining($data);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Training Request Sent</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>Request sending Failed, Please try again</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function recommendTrainingRequest(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $requestID = $this->uri->segment(3);
            $data = array(
                'status' => 1,
                'recommended_by' => auth()->user()->emp_id,
                'date_recommended' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateTrainingRequest($data, $requestID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Request Recommended Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Recommend, Please Try Again!</p>";
            }
        }
    }

    public function suspendTrainingRequest(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $requestID = $this->uri->segment(3);
            $data = array(
                'status' => 4, //Held or Suspended
                'recommended_by' => auth()->user()->emp_id,
                'date_recommended' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateTrainingRequest($data, $requestID);
            if ($result == true) {
                echo "<p class='alert alert-warning text-center'>Request Suspended Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Suspend, Please Try Again!</p>";
            }
        }
    }

    public function approveTrainingRequest(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $requestID = $this->uri->segment(3);
            $data = array(
                'status' => 3, //Held or Suspended
                'approved_by' => auth()->user()->emp_id,
                'date_approved' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateTrainingRequest($data, $requestID);
            if ($result == true) {
                echo "<p class='alert alert-warning text-center'>Request Suspended Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Suspend, Please Try Again!</p>";
            }
        }
    }

    public function disapproveTrainingRequest(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $requestID = $this->uri->segment(3);
            $data = array(
                'status' => 5, //DisApproved
                'approved_by' => auth()->user()->emp_id,
                'date_approved' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateTrainingRequest($data, $requestID);
            if ($result == true) {
                echo "<p class='alert alert-warning text-center'>Request Suspended Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Disapproved, Please Try Again!</p>";
            }
        }
    }

    public function confirmTrainingRequest(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $requestID = $this->uri->segment(3);
            $data = array(
                'status' => 3, //Confirmed
                'confirmed_by' => auth()->user()->emp_id,
                'date_confirmed' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->confirmTrainingRequest($data, $requestID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Request Confirmed Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Confirm, Please Try Again!</p>";
            }
        }
    }

    public function unconfirmTrainingRequest(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $requestID = $this->uri->segment(3);
            $data = array(
                'status' => 6, //DisApproved
                'confirmed_by' => auth()->user()->emp_id,
                'date_confirmed' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->unconfirmTrainingRequest($data, $requestID);
            if ($result == true) {
                echo "<p class='alert alert-warning text-center'>Request Unfonfirmed Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED, Please Try Again!</p>";
            }
        }
    }

    public function deleteTrainingRequest(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $requestID = $this->uri->segment(3);
            $result = $this->flexperformance_model->deleteTrainingRequest($requestID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Request Deleted Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED, Please Try Again!</p>";
            }
        }
    }

    public function response_training_linemanager(Request $request)
    {

        if (isset($_POST['recommend']) && !empty($request->input('option'))) {
            $arr = $request->input('option');

            foreach ($arr as $check) {
                $applicationID = $check;

                $dataUpdates = array(
                    'isAccepted' => 2,
                );

                $this->flexperformance_model->updateTrainingApplications($dataUpdates, $applicationID);

                $check = '';
            }
            session('note_approved', "<p class='alert alert-success text-center'>Training Applications Recommended Successifully</p>");
            $this->training_application();
        } else {
            session('note_approved', "<p class='alert alert-warning text-center'>Sorry No item Selected</p>");
            $this->training_application();
        }

        if (isset($_POST['reject']) && !empty($request->input('option'))) {
            $arr = $request->input('option');

            foreach ($arr as $check) {
                $applicationID = $check;

                $dataUpdates = array(
                    'isAccepted' => 3,
                );

                $this->flexperformance_model->updateTrainingApplications($dataUpdates, $applicationID);

                $check = '';
            }
            session('note_approved', "<p class='alert alert-warning text-center'>Training Applications Rejected</p>");
            $this->training_application();
        } else {
            session('note_approved', "<p class='alert alert-warning text-center'>Sorry No item Selected</p>");
            $this->training_application();
        }
    }

    public function confirm_graduation(Request $request)
    {

        $key = $request->input('key');

        $values = explode('|', $key);
        $empID = $values[0];
        $skillsID = $values[1];
        $graduationID = $values[2];

        $data['mode'] = 2; // 1 For Initial Skills, and  2 for Graduation after Training
        $data['traineeID'] = $empID;
        $data['trainingID'] = $graduationID;
        $data['skillsID'] = $skillsID;
        $data['title'] = "Training";
        $data['courseTitle'] = $this->flexperformance_model->getSkillsName($skillsID);
        return view('app.confirm_graduation', $data);
    }

    public function employeeCertification(Request $request)
    {

        $key = $request->input('val');

        $values = explode('|', $key);
        $empID = $values[0];
        $skillsID = $values[1];
        // $graduationID = $values[2];

        $data['mode'] = 1; // 1 For Initial Skills, and  2 for Graduation after Training
        $data['traineeID'] = $empID;
        // $data['trainingID'] = $graduationID;
        $data['skillsID'] = $skillsID;
        $data['title'] = "Qualification";
        $data['courseTitle'] = $this->flexperformance_model->getSkillsName($skillsID);
        return view('app.confirm_graduation', $data);
    }

    public function confirmGraduation(Request $request)
    {
        $ID = $request->input('trainingID');
        $traineeID = $request->input('traineeID');
        $skillsID = $request->input('skillsID');
        $remarks = trim($request->input('remarks'));
        if ($request->method() == "POST" && $ID != '') {
            $namefile = "certificate_" . $traineeID . "_" . $skillsID;

            $config['upload_path'] = './uploads/graduation/';
            $config['file_name'] = $namefile;
            $config['allowed_types'] = 'pdf|jpeg|jpg|gif|jpg|png';
            $config['overwrite'] = true;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload("userfile")) {
                $data = $this->upload->data();
                $database = array(
                    'certificate' => $data["file_name"],
                    'status' => 1,
                    'remarks' => $remarks,
                    'accepted_by' => auth()->user()->emp_id,
                    'date_accepted' => date('Y-m-d'),
                );
                $data_skills = array(
                    'empID' => $traineeID,
                    'remarks' => $remarks,
                    'certificate' => $data["file_name"],
                    'skill_ID' => $skillsID,

                );
                $result = $this->flexperformance_model->confirm_graduation($database, $ID);
                $this->flexperformance_model->assignskills($data_skills);
                if ($result == true) {
                    echo "<p class='alert alert-success text-center'>Graduation Confirmed Successifully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>Confirmation Failed</p>";
                }
            } else {
                echo "<p class='alert alert-danger text-center'>Failed! Attachment Not Uploaded!</p>";
            }
        } else {
            echo "<p class='alert alert-info text-center'>Nothing to Uploaded, Invalid Training/Course Reference!</p>";
        }
    }

    public function confirmEmployeeCertification(Request $request)
    {
        $traineeID = $request->input('traineeID');
        $skillsID = $request->input('skillsID');
        $remarks = trim($request->input('remarks'));
        // if ($request->method() == "POST"&& $ID!='') {

        if ($request->method() == "POST") {

            $namefile = "certificate_" . $traineeID . "_" . $skillsID;

            $config['upload_path'] = './uploads/graduation/';
            $config['file_name'] = $namefile;
            $config['allowed_types'] = 'pdf|jpeg|jpg|gif|png';
            $config['overwrite'] = true;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload("userfile")) {
                $data = $this->upload->data();
                $data_skills = array(
                    'empID' => $traineeID,
                    'remarks' => $remarks,
                    'certificate' => $data["file_name"],
                    'skill_ID' => $skillsID,

                );
                $result = $this->flexperformance_model->assignskills($data_skills);
                if ($result == true) {
                    echo "<p class='alert alert-success text-center'>Certification Confirmed Successifully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>Confirmation Failed</p>";
                }
            } else {
                echo "<p class='alert alert-danger text-center'>Failed! Attachment Not Uploaded!</p>";
            }
        } else {
            echo "<p class='alert alert-info text-center'>Nothing to Uploaded, Invalid Skills Reference!</p>";
        }
    }

    ############################## END LEARNING AND DEVELOPMENT(TRAINING)#############################

    public function addAccountability(Request $request)
    {
        $positionID = $request->input('positionID');
        $data = array(
            'name' => $request->input('title'),
            'position_ref' => $positionID,
            'weighting' => $request->input('weighting'),
        );
        $this->flexperformance_model->addAccountability($data);

        session('note', "<p class='alert alert-success text-center'>Accountability Added Successifully</p>");
        $reload = '/flex/position_info/?id=' . $positionID;
        return redirect($reload);
    }

    public function addskills(Request $request)
    {

        if (isset($_POST['add'])) {
            $id = $request->input('positionID');
            if ($request->input('mandatory') == '1') {

                $data = array(
                    'name' => $request->input('name'),
                    'position_ref' => $id,
                    'amount' => $request->input('amount'),
                    'type' => $request->input('type'),
                    'description' => $request->input('description'),
                    'created_by' => auth()->user()->emp_id,
                );
            } else {
                $data = array(
                    'name' => $request->input('name'),
                    'position_ref' => $id,
                    'amount' => $request->input('amount'),
                    'type' => $request->input('type'),
                    'description' => $request->input('description'),
                    'mandatory' => 0,
                    'created_by' => auth()->user()->emp_id,
                );
            }

            $this->flexperformance_model->addskills($data);
            //echo "Record Added";
            session('note', "<p class='alert alert-success text-center'>Skills Added Successifully</p>");
            $reload = '/flex/position_info/?id=' . $id;
            return redirect($reload);
        }
    }

    public function updatePositionName(Request $request)
    {
        if ($request->method() == "POST") {

            if ($request->input('positionID') != '') {
                $positionID = $request->input('positionID');
                $data = array(
                    'name' => $request->input('name'),
                );
                $result = $this->flexperformance_model->updateposition($data, $positionID);
                if ($result == true) {
                    $response_array['status'] = "OK";
                    $response_array['message'] = "<p class='alert alert-success text-center'>Position Updated Successifully!</p>";
                } else {
                    $response_array['status'] = "ERR";
                    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
                }
            } else {

                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
            }
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function updatePositionReportsTo(Request $request)
    {
        if ($request->method() == "POST") {

            if ($request->input('positionID') != '') {
                $positionID = $request->input('positionID');
                $values = explode('|', $request->input('parent'));
                $parent_code = $values[0];
                $level = $values[1];
                $data = array(
                    'parent_code' => $parent_code,
                    'level' => $level + 1,
                );
                $result = $this->flexperformance_model->updateposition($data, $positionID);
                if ($result == true) {
                    $response_array['status'] = "OK";
                    $response_array['message'] = "<p class='alert alert-success text-center'>Position Updated Successifully!</p>";
                } else {
                    $response_array['status'] = "ERR";
                    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
                }
            } else {

                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
            }
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function updatePositionCode(Request $request)
    {
        if ($request->method() == "POST") {

            if ($request->input('positionID') != '') {
                $positionID = $request->input('positionID');
                $data = array(
                    'code' => strtoupper($request->input('code')),
                );
                $result = $this->flexperformance_model->updateposition($data, $positionID);
                if ($result == true) {
                    $response_array['status'] = "OK";
                    $response_array['message'] = "<p class='alert alert-success text-center'>Position Updated Successifully!</p>";
                } else {
                    $response_array['status'] = "ERR";
                    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
                }
            } else {

                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
            }
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function updatePositionOrganizationLevel(Request $request)
    {
        if ($request->method() == "POST") {

            if ($request->input('positionID') != '') {
                $positionID = $request->input('positionID');
                $data = array(
                    'organization_level' => strtoupper($request->input('organization_level')),
                );
                $result = $this->flexperformance_model->updateposition($data, $positionID);
                if ($result == true) {
                    $response_array['status'] = "OK";
                    $response_array['message'] = "<p class='alert alert-success text-center'>Position Updated Successifully!</p>";
                } else {
                    $response_array['status'] = "ERR";
                    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
                }
            } else {

                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Updated, Please try Again!</p>";
            }
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function position(Request $request)
    {
        $this->authenticateUser('view-organization');
        $data['ddrop'] = $this->flexperformance_model->departmentdropdown();
        $data['all_position'] = $this->flexperformance_model->allposition();
        $data['levels'] = $this->flexperformance_model->getAllOrganizationLevel();
        $data['position'] = $this->flexperformance_model->position();
        $data['inactive_position'] = $this->flexperformance_model->inactive_position();
        $data['title'] = "Position";
        return view('app.position', $data);
    }
    public function addPosition(Request $request)
    {
        if ($request->method() == "POST") {

            if ($request->input('driving_licence') == "") {
                $licence = 0;
            } else {
                $licence = 1;
            }

            $values = explode('|', $request->input('parent'));
            $parent_code = $values[0];
            $level = $values[1];

            $data = array(
                'name' => $request->input('name'),
                'purpose' => $request->input('purpose'),
                'dept_id' => $request->input('department'),
                'organization_level' => $request->input('organization_level'),
                'code' => strtoupper($request->input('code')),
                'driving_licence' => $licence,
                'minimum_qualification' => $request->input('qualification'),
                'created_by' => auth()->user()->emp_id,
                'position_code' => $this->code_generator(6),
                'parent_code' => $parent_code,
                'level' => $level + 1,

            );

            $result = $this->flexperformance_model->addposition($data);
            if ($result == true) {
                return redirect()->back();
                //$response_array['status'] = "OK";
                // $response_array['message'] = "<p class='alert alert-success text-center'>Position Added Successifully!</p>";
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Deleted!</p>";
            }
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function addOrganizationLevel(Request $request)
    {
        $method = $request->method();
        if ($method == "POST") {

            $data = array(
                'name' => $request->input('name'),
                'minSalary' => $request->input('minSalary'),
                'maxSalary' => $request->input('maxSalary'),

            );
            $result = $this->flexperformance_model->addOrganizationLevel($data);
            if ($result == true) {
                return redirect()->back();
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Organization Level Added Successifully!</p>";
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Organization Level NOT Deleted!</p>";
            }
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function deleteOrganizationLevel($id)
    {
        $result = $this->flexperformance_model->deleteOrganizationLevel($id);
        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Organization Level Deleted!</p>";
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Organization Level NOT Deleted!</p>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);
    }

    public function deletePosition(Request $request)
    {

        $id = $this->uri->segment(3);
        $data = array(
            'state' => 0,
        );
        $result = $this->flexperformance_model->updateposition($data, $id);
        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Position Deleted!</p>";
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Position NOT Deleted!</p>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);
    }

    public function activatePosition(Request $request)
    {

        $id = $this->uri->segment(3);
        $data = array(
            'state' => 1,
        );
        $result = $this->flexperformance_model->updateposition($data, $id);
        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Position Activated Successifully!</p>";
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Position Activation FAILED, Please Try again!</p>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);
    }

    public function updateskills(Request $request)
    {

        if (isset($_POST['update'])) {
            $positionref = $request->input('positionref');
            $skillsref = $request->input('skillsID');
            if ($request->input('mandatory') == '1') {

                $data = array(
                    'name' => $request->input('name'),
                    'position_ref' => $positionref,
                    'amount' => $request->input('amount'),
                    'type' => $request->input('type'),
                    'description' => $request->input('description'),
                );
            } else {

                $data = array(
                    'name' => $request->input('name'),
                    'position_ref' => $positionref,
                    'amount' => $request->input('amount'),
                    'type' => $request->input('type'),
                    'description' => $request->input('description'),
                    'mandatory' => 0,
                );
            }

            $this->flexperformance_model->updateskills($data, $skillsref);
            //echo "Record Added";
            session('note', "<p class='alert alert-success text-center'>Skills Added Successifully</p>");
            $reload = '/flex/position_info/?id=' . $positionref;
            return redirect($reload);
        }
    }

    public function applyOvertime(Request $request)
    {

        request()->validate(
            [
                'reason' => 'required',
            ]
        );

        $start = $request->input('time_start');
        $finish = $request->input('time_finish');
        $reason = $request->input('reason');
        $category = $request->input('category');
        $linemanager = $request->input('linemanager');

        $empID = auth()->user()->emp_id;

        $split_start = Carbon::createFromFormat('Y-m-d\TH:i', $start);
        $split_finish = Carbon::createFromFormat('Y-m-d\TH:i', $finish);

        // Extract date and time components
        $start_date = $split_start->toDateString();
        $start_time = $split_start->toTimeString();

        $finish_date = $split_finish->toDateString();
        $finish_time = $split_finish->toTimeString();

        $maxRange = $split_start->diffInHours($split_finish);

        if ($maxRange > 24) {

            echo "<p class='alert alert-warning text-center'>Overtime Should Range between 0 to 24 Hours</p>";
        } else {

            $end_night_shift = "6:00";
            $start_night_shift = "20:00";

            if ($start_date == $finish_date) {

                if (strtotime($start_time) >= strtotime($finish_time)) {

                    echo "<p class='alert alert-danger text-center'>Invalid Time Selection, Please Choose the correct time and Try Again!</p>";
                } else {

                    if (strtotime($start_time) >= strtotime($start_night_shift) || $start_time <= 5 && strtotime($finish_time) <= strtotime($end_night_shift)) {

                        $type = 1; // echo " CORRECT:  NIGHT OVERTIME";

                        $data = array(
                            'time_start' => $start_date . " " . $start_time,
                            'time_end' => $finish_date . " " . $finish_time,
                            'overtime_type' => $type,
                            'overtime_category' => $category,
                            'reason' => $reason,
                            'empID' => $empID,
                            'linemanager' => $linemanager,
                            'time_recommended_line' => date('Y-m-d h:i:s'),
                            'time_approved_hr' => date('Y-m-d'),
                            'time_confirmed_line' => date('Y-m-d h:i:s'),
                            'application_time' => new DateTime(),

                        );

                        $result = $this->flexperformance_model->apply_overtime($data);

                        if ($result == true) {
                            echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
                        } else {
                            echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
                        }
                    } elseif (strtotime($start_time) >= strtotime($end_night_shift) && strtotime($start_time) < strtotime($start_night_shift) && strtotime($finish_time) <= strtotime($start_night_shift)) {

                        $type = 0; // echo "DAY OVERTIME";

                        $data = array(
                            'time_start' => $start_date . " " . $start_time,
                            'time_end' => $finish_date . " " . $finish_time,
                            'overtime_type' => $type,
                            'overtime_category' => $category,
                            'reason' => $reason,
                            'empID' => $empID,
                            'linemanager' => $linemanager,
                            'time_recommended_line' => date('Y-m-d h:i:s'),
                            'time_approved_hr' => date('Y-m-d'),
                            'time_confirmed_line' => date('Y-m-d h:i:s'),
                            'application_time' => new DateTime(),
                        );

                        $result = $this->flexperformance_model->apply_overtime($data);

                        if ($result == true) {
                            echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
                        } else {
                            echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
                        }
                    } else {

                        $type = 0; // echo "DAY OVERTIME";

                        $data = array(
                            'time_start' => $start_date . " " . $start_time,
                            'time_end' => $finish_date . " " . $finish_time,
                            'overtime_type' => $type,
                            'overtime_category' => $category,
                            'reason' => $reason,
                            'empID' => $empID,
                            'linemanager' => $linemanager,
                            'time_recommended_line' => date('Y-m-d h:i:s'),
                            'time_approved_hr' => date('Y-m-d'),
                            'time_confirmed_line' => date('Y-m-d h:i:s'),
                            'application_time' => new DateTime(),

                        );

                        $result = $this->flexperformance_model->apply_overtime($data);

                        if ($result == true) {
                            echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
                        } else {
                            echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
                        }

                        // echo "<p class='alert alert-warning text-center'>Sorry Cross-Shift Overtime is NOT ALLOWED, Please Choose the correct time and Try Again!</p>";
                    }
                }
            } else if ($start_date > $finish_date) {
                echo "<p class='alert alert-warning text-center'>Invalid Date, Please Choose the correct Date and Try Again!</p>";
            } else {
                // echo "CORRECT DATE - <BR>";
                if (strtotime($start_time) >= strtotime($start_night_shift) && strtotime($finish_time) <= strtotime($end_night_shift)) {
                    $type = 1; // echo "NIGHT OVERTIME CROSS DATE ";
                    $data = array(
                        'time_start' => $start_date . " " . $start_time,
                        'time_end' => $finish_date . " " . $finish_time,
                        'overtime_type' => $type,
                        'overtime_category' => $category,
                        'reason' => $reason,
                        'empID' => $empID,
                        'linemanager' => $linemanager,
                        'time_recommended_line' => date('Y-m-d h:i:s'),
                        'time_approved_hr' => date('Y-m-d'),
                        'time_confirmed_line' => date('Y-m-d h:i:s'),
                        'application_time' => new DateTime(),

                    );
                    $result = $this->flexperformance_model->apply_overtime($data);
                    if ($result == true) {
                        echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
                    } else {
                        echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
                    }
                } else {
                    $type = 0; // echo "DAY OVERTIME";
                    $data = array(
                        'time_start' => $start_date . " " . $start_time,
                        'time_end' => $finish_date . " " . $finish_time,
                        'overtime_type' => $type,
                        'overtime_category' => $category,
                        'reason' => $reason,
                        'empID' => $empID,
                        'linemanager' => $linemanager,
                        'time_recommended_line' => date('Y-m-d h:i:s'),
                        'time_approved_hr' => date('Y-m-d'),
                        'time_confirmed_line' => date('Y-m-d h:i:s'),
                        'application_time' => new DateTime(),

                    );
                    $result = $this->flexperformance_model->apply_overtime($data);
                    if ($result == true) {
                        //fetch Line manager data from employee table and send email
                        $linemanager_data = SysHelpers::employeeData($linemanager);
                        $fullname = $linemanager_data['full_name'];
                        $email_data = array(
                            'subject' => 'Employee Overtime Approval',
                            'view' => 'emails.linemanager.overtime-approval',
                            'email' => $linemanager_data['email'],
                            'full_name' => $fullname,
                        );
                        try {

                            Notification::route('mail', $linemanager_data['email'])->notify(new EmailRequests($email_data));
                        } catch (Exception $exception) {
                            echo "<p class='alert alert-danger text-center'>Overtime Request  Sent, But Email not sent due to connectivity problem!</p>";
                        }
                        echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
                    } else {
                        echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
                    }
                }
            }
        }
    }

    public function applyOvertimeOnbehalf(Request $request)
    {

        $days = $request->input('days');

        $overtime_category = $request->input('category');
        $empID = $request->empID;
        $signatory = auth()->user()->emp_id;
        $date = date('Y-m-d');
        $employee_data = Employee::where('emp_id', $empID)->first();
        $line_maager = $employee_data->line_manager;
        $percent = $this->flexperformance_model->get_percent($overtime_category);

        $overtime_name = $this->flexperformance_model->get_overtime_name($overtime_category);

        $result = $this->flexperformance_model->direct_insert_overtime($empID, $signatory, $overtime_category, $date, $days, $percent, $line_maager);
        if ($result == true) {
            $amount = $days * ($employee_data->salary / 176) * $percent;

            SysHelpers::FinancialLogs($empID, $overtime_name, '0.00', number_format($amount, 2), 'Payroll Input');

            echo "<p class='alert alert-success text-center'>Overtime Request saved Successifully</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>Overtime Request not saved Successifully</p>";
        }

        // $split_start = explode("  at  ", $start);
        // $split_finish = explode("  at  ", $finish);

        // $start_date = $split_start[0];
        // $start_time = $split_start[1];

        // $finish_date = $split_finish[0];
        // $finish_time = $split_finish[1];

        // $start_calendar = str_replace('/', '-', $start_date);
        // $finish_calendar = str_replace('/', '-', $finish_date);

        // $start_final = date('Y-m-d', strtotime($start_calendar));
        // $finish_final = date('Y-m-d ', strtotime($finish_calendar));

        // $maxRange = ((strtotime($finish_final) - strtotime($start_final)) / 3600);

        //fetch Line manager data from employee table and send email
        // $linemanager_data = SysHelpers::employeeData($linemanager);
        // $fullname = $linemanager_data['full_name'];
        // $email_data = array(
        //     'subject' => 'Employee Overtime Approval',
        //     'view' => 'emails.linemanager.overtime-approval',
        //     'email' => $linemanager_data['email'],
        //     'full_name' => $fullname,
        // );
        // Notification::route('mail', $email_data['email'])->notify(new EmailRequests($email_data));
        // dd('Email Sent Successfully');
        //$linemanager = $this->flexperformance_model->get_linemanagerID($empID);

        // foreach ($line as $row) {
        //     $linemanager = $row->line_manager;
        // }
        //Overtime Should range between 24 Hrs;

        // if ($maxRange > 24) {

        //     echo "<p class='alert alert-warning text-center'>Overtime Should Range between 0 to 24 Hours</p>";
        // } else {

        //     $end_night_shift = "6:00";
        //     $start_night_shift = "20:00";

        //     if ($start_date == $finish_date) {

        //         if (strtotime($start_time) >= strtotime($finish_time)) {

        //             echo "<p class='alert alert-danger text-center'>Invalid Time Selection, Please Choose the correct time and Try Again!</p>";
        //         } else {

        //             if (strtotime($start_time) >= strtotime($start_night_shift) || $start_time <= 5 && strtotime($finish_time) <= strtotime($end_night_shift)) {

        //                 $type = 1; // echo " CORRECT:  NIGHT OVERTIME";

        //                 $data = array(
        //                     'time_start' => $start_final . " " . $start_time,
        //                     'time_end' => $finish_final . " " . $finish_time,
        //                     'overtime_type' => $type,
        //                     'overtime_category' => $category,
        //                     'reason' => $reason,
        //                     'empID' => $empID,
        //                     'linemanager' => $linemanager,
        //                     'time_recommended_line' => date('Y-m-d h:i:s'),
        //                     'time_approved_hr' => date('Y-m-d'),
        //                     'time_confirmed_line' => date('Y-m-d h:i:s'),
        //                 );

        //                 $result = $this->flexperformance_model->apply_overtime($data);

        //                 if ($result == true) {
        //                     echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
        //                 } else {
        //                     echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
        //                 }
        //             } elseif (strtotime($start_time) >= strtotime($end_night_shift) && strtotime($start_time) < strtotime($start_night_shift) && strtotime($finish_time) <= strtotime($start_night_shift)) {

        //                 $type = 0; // echo "DAY OVERTIME";

        //                 $data = array(
        //                     'time_start' => $start_final . " " . $start_time,
        //                     'time_end' => $finish_final . " " . $finish_time,
        //                     'overtime_type' => $type,
        //                     'overtime_category' => $category,
        //                     'reason' => $reason,
        //                     'empID' => $empID,
        //                     'linemanager' => $linemanager,
        //                     'time_recommended_line' => date('Y-m-d h:i:s'),
        //                     'time_approved_hr' => date('Y-m-d'),
        //                     'time_confirmed_line' => date('Y-m-d h:i:s'),
        //                 );

        //                 $result = $this->flexperformance_model->apply_overtime($data);

        //                 if ($result == true) {
        //                     echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
        //                 } else {
        //                     echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
        //                 }
        //             } else {
        //                 echo "<p class='alert alert-warning text-center'>Sorry Cross-Shift Overtime is NOT ALLOWED, Please Choose the correct time and Try Again!</p>";
        //             }
        //         }
        //     } else if ($start_date > $finish_date) {
        //         echo "<p class='alert alert-warning text-center'>Invalid Date, Please Choose the correct Date and Try Again!</p>";
        //     } else {
        //         // echo "CORRECT DATE - <BR>";
        //         if (strtotime($start_time) >= strtotime($start_night_shift) && strtotime($finish_time) <= strtotime($end_night_shift)) {
        //             $type = 1; // echo "NIGHT OVERTIME CROSS DATE ";
        //             $data = array(
        //                 'time_start' => $start_final . " " . $start_time,
        //                 'time_end' => $finish_final . " " . $finish_time,
        //                 'overtime_type' => $type,
        //                 'overtime_category' => $category,
        //                 'reason' => $reason,
        //                 'empID' => $empID,
        //                 'linemanager' => $linemanager,
        //                 'time_recommended_line' => date('Y-m-d h:i:s'),
        //                 'time_approved_hr' => date('Y-m-d'),
        //                 'time_confirmed_line' => date('Y-m-d h:i:s'),
        //             );
        //             $result = $this->flexperformance_model->apply_overtime($data);
        //             if ($result == true) {
        //                 echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
        //             } else {
        //                 echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
        //             }
        //         } else {
        //             $type = 0; // echo "DAY OVERTIME";
        //             $data = array(
        //                 'time_start' => $start_final . " " . $start_time,
        //                 'time_end' => $finish_final . " " . $finish_time,
        //                 'overtime_type' => $type,
        //                 'overtime_category' => $category,
        //                 'reason' => $reason,
        //                 'empID' => $empID,
        //                 'linemanager' => $linemanager,
        //                 'time_recommended_line' => date('Y-m-d h:i:s'),
        //                 'time_approved_hr' => date('Y-m-d'),
        //                 'time_confirmed_line' => date('Y-m-d h:i:s'),
        //             );
        //             $result = $this->flexperformance_model->apply_overtime($data);
        //             if ($result == true) {
        //                 echo "<p class='alert alert-success text-center'>Overtime Request Sent Successifully</p>";
        //             } else {
        //                 echo "<p class='alert alert-danger text-center'>Overtime Request Not Sent, Please Try Again!</p>";
        //             }
        //         }
        //     }
        // }
    }

    /*IMPREST FUNCTIONS MOVED TO IMPREST CONTROLLER*/

    public function overtime()
    {

        $data['title'] = "Overtime";
        $data['my_overtimes'] = $this->flexperformance_model->my_overtimes(auth()->user()->emp_id);
        $data['overtimeCategory'] = $this->flexperformance_model->overtimeCategory();
        $data['employees'] = $this->flexperformance_model->Employee();

        $data['line_overtime'] = $this->flexperformance_model->lineOvertimes(auth()->user()->emp_id);

        // elseif (session('line')!=0) {
        //   $data['adv_overtime'] = $this->flexperformance_model->overtimesLinemanager(auth()->user()->emp_id);
        // }
        // elseif (session('conf_overtime')!=0) {
        //   $data['adv_overtime'] = $this->flexperformance_model->overtimesHR();
        // }
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['parent'] = 'Workforce';
        $data['child'] = 'Overtime';

        return view('overtime.overtime', $data);
    }

    public function overtime_info(Request $request)
    {

        $initialOvertimeID = $this->uri->segment(3);

        if (isset($_POST['update_overtime'])) {

            $timeframe = $request->input('time_range');
            $overtimeID = $request->input('overtimeID');

            // Separate between Start Time-Date and End Time-Date
            $datetime = explode(" - ", $timeframe);
            $stime = $datetime[0];
            $etime = $datetime[1];

            // Separate Time and Date
            $starttime = explode(" ", $stime);
            $endtime = explode(" ", $etime);

            $startDate = explode("/", $starttime[0]);
            $endDate = explode("/", $endtime[0]);

            $finalStartDate = $startDate[2] . "-" . $startDate[1] . "-" . $startDate[0];
            $finalEndDate = $endDate[2] . "-" . $endDate[1] . "-" . $endDate[0];

            $start = $finalStartDate . " " . $starttime[1];
            $end = $finalEndDate . " " . $endtime[1];

            // $this->flexperformance_model->apply_overtime($data);

            $data = array(
                'time_start' => $start,
                'time_end' => $end,
                'reason' => $request->input('reason'),
                'empID' => auth()->user()->emp_id,
            );

            $this->flexperformance_model->update_overtime($data, $overtimeID);

            session('note', "<p class='alert alert-success text-center'>Your Overtime was Updated Successifully</p>");

            return redirect('/flex/overtime');
        }

        $data['title'] = "Overtime";
        $data['mode'] = 2; // Mode 1 for Comment Purpose and Mode 2 for Update Purpose
        $data['overtime'] = $this->flexperformance_model->fetch_my_overtime($initialOvertimeID);
        return view('app.overtime_info', $data);
    }

    public function confirmOvertime($id)
    {

        $overtimeID = $id;
        $data = array(
            'status' => 5,
            'time_confirmed_line' => date('Y-m-d h:i:s'),
            'linemanager' => auth()->user()->emp_id,
        );
        $this->flexperformance_model->update_overtime($data, $overtimeID);
        echo "<p class='alert alert-success text-center'>Overtime Confirmed Successifully</p>";
    }

    public function recommendOvertime($id)
    {
        $overtimeID = $id;
        $data = array(
            'status' => 1,
            'time_recommended_line' => date('Y-m-d h:i:s'),
        );
        $this->flexperformance_model->update_overtime($data, $overtimeID);
        echo "<p class='alert alert-success text-center'>Overtime Recommended Successifully</p>";
    }

    public function approved_financial_payments(Request $request)
    {

        $this->authenticateUser('edit-payroll');
        // if(session('mng_paym')||session('recom_paym')||session('appr_paym')){
        $data['overtime'] = $this->flexperformance_model->approvedOvertimes();
        $data['imprests'] = $this->imprest_model->confirmedImprests();
        //$data['arrears'] = $this->payroll_model->all_arrears();
        $data['pending_arrears'] = $this->payroll_model->pending_arrears_payment();
        $data['monthly_arrears'] = $this->payroll_model->all_arrears_payroll_month();
        $data['month_list'] = $this->flexperformance_model->payroll_month_list();

        $data['bonus'] = $this->payroll_model->selectBonus();
        $data['incentives'] = $this->payroll_model->employee_bonuses();
        $data['employee'] = $this->payroll_model->customemployee();

        $data['otherloan'] = $this->flexperformance_model->salary_advance();

        $data['pendingPayroll_month'] = $this->payroll_model->pendingPayroll_month();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['payroll'] = $this->payroll_model->pendingPayroll();
        $data['payrollList'] = $this->payroll_model->payrollMonthList();

        $data['other_imprests'] = $this->imprest_model->othersImprests(auth()->user()->emp_id);

        $data['adv_overtime'] = $this->flexperformance_model->allOvertimes(auth()->user()->emp_id);

        $data['title'] = "Pending Payments";
        $data['parent'] = 'Payroll';
        $data['child'] = "pending-payments";

        return view('app.financial_payment', $data);

        // }else{
        //     echo 'Unauthorised Access';
        // }

    }

    public function arrears_info(Request $request)
    {
        $payrollMonth = base64_decode($this->input->get('pdate'));
        if ($payrollMonth == '') {
            exit("Payroll Month Not Found");
        } else {
            $data['payroll_month'] = $payrollMonth;
            $data['arrears'] = $this->payroll_model->monthly_arrears($payrollMonth);
            $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
            $data['title'] = "Arrears";
            return view('app.arrears_info', $data);
        }
    }

    public function individual_arrears_info(Request $request)
    {
        $array_input = explode('@', base64_decode($this->input->get('id')));
        $empID = $array_input[0];
        $payroll_date = $array_input[1];

        if ($empID == '' || ($this->reports_model->employeeInfo($empID)) == false) {
            exit("Employee ID Not Found");
        } else {
            $data['info'] = $this->reports_model->company_info();
            $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
            $data['arrears'] = $this->payroll_model->employee_arrears1($empID, $payroll_date);
            $data['employee'] = $this->reports_model->employeeInfo($empID);
            $data['title'] = "Arrears";
            return view('app.individual_arrears_info', $data);
        }
    }

    public function holdOvertime($id)
    {

        $overtimeID = $id;
        $data = array(
            'status' => 3,
        );
        $this->flexperformance_model->update_overtime($data, $overtimeID);
        echo "<p class='alert alert-warning text-center'>Overtime Held</p>";
    }

    public function approveOvertime($id)
    {

        $overtimeID = $id;

        // $status = $this->flexperformance_model->checkApprovedOvertime($overtimeID);
        // // $overtime_type = $this->flexperformance_model->get_overtime_type($overtimeID);
        // // $rate = $this->flexperformance_model->get_overtime_rate();

        // if($status==4){
        $signatory = auth()->user()->emp_id;
        $time_approved = date('Y-m-d');
        $amount = 0;

        $overtime = $this->flexperformance_model->get_employee_overtime($overtimeID);
        //dd($overtime);

        $emp_id = $this->flexperformance_model->get_employee_overtimeID($overtimeID);
        $overtime_category = $emp_id = $this->flexperformance_model->get_employee_overtime_category($overtimeID);
        $overtime_name = $this->flexperformance_model->get_overtime_name($overtime_category);

        $result = $this->flexperformance_model->approveOvertime($overtimeID, $signatory, $time_approved);
        if ($result == true) {

            SysHelpers::FinancialLogs($emp_id, $overtime_name, '0.00', number_format($overtime, 2), 'Payroll Input');

            echo "<p class='alert alert-success text-center'>Overtime Approved Successifully</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>Overtime Not Approved, Some Errors Occured Please Try Again!</p>";
        }
        // }else{
        //   echo "<p class='alert alert-danger text-center'>Overtime is not yet Approved</p>";
        // }

    }

    public function lineapproveOvertime($id)
    {

        $overtimeID = $id;

        $status = $this->flexperformance_model->checkApprovedOvertime($overtimeID);
        // $overtime_type = $this->flexperformance_model->get_overtime_type($overtimeID);
        // $rate = $this->flexperformance_model->get_overtime_rate();

        if ($status == 0) {
            $signatory = auth()->user()->emp_id;
            $time_approved = date('Y-m-d');
            $result = $this->flexperformance_model->lineapproveOvertime($overtimeID, $time_approved);

            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Overtime Approved Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Overtime Not Approved, Some Errors Occured Please Try Again!</p>";
            }
        } else {
            echo "<p class='alert alert-danger text-center'>Overtime is Already Approved</p>";
        }
    }

    public function hrapproveOvertime($id)
    {

        $overtimeID = $id;

        $status = $this->flexperformance_model->checkApprovedOvertime($overtimeID);
        // $overtime_type = $this->flexperformance_model->get_overtime_type($overtimeID);
        // $rate = $this->flexperformance_model->get_overtime_rate();

        // if($status==0){
        $signatory = auth()->user()->emp_id;
        $time_approved = date('Y-m-d');
        $result = $this->flexperformance_model->hrapproveOvertime($overtimeID, $signatory, $time_approved);
        if ($result == true) {
            echo "<p class='alert alert-success text-center'>Overtime Approved Successifully</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>Overtime Not Approved, Some Errors Occured Please Try Again!</p>";
        }
        // }else{
        //   echo "<p class='alert alert-danger text-center'>Overtime is Already Approved</p>";
        // }

    }

    public function fin_approveOvertime($id)
    {

        $overtimeID = $id;

        // $status = $this->flexperformance_model->checkApprovedOvertime($overtimeID);
        // // $overtime_type = $this->flexperformance_model->get_overtime_type($overtimeID);
        // // $rate = $this->flexperformance_model->get_overtime_rate();

        // if($status==0){
        $signatory = auth()->user()->emp_id;
        $time_approved = date('Y-m-d');
        $result = $this->flexperformance_model->fin_approveOvertime($overtimeID, $signatory, $time_approved);
        if ($result == true) {
            echo "<p class='alert alert-success text-center'>Overtime Approved Successifully</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>Overtime Not Approved, Some Errors Occured Please Try Again!</p>";
        }
        // }else{
        //   echo "<p class='alert alert-danger text-center'>Overtime is Already Approved</p>";
        // }

    }

    public function denyOvertime($id)
    { //or disapprove

        $overtimeID = $id;
        $result = $this->flexperformance_model->deny_overtime($overtimeID);
        if ($result == true) {
            echo "<p class='alert alert-warning text-center'>Overtime DISSAPPROVED Successifully</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED to Disapprove, Some Errors Occured Please Try Again!</p>";
        }
    }

    public function cancelOvertime($id)
    {
        $result = $this->flexperformance_model->deleteOvertime($id);

        if ($result == true) {
            echo "<p class='alert alert-warning text-center'>Overtime DELETED Successifully</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED to DELETE, Please Try Again!</p>";
        }
    }

    public function cancelApprovedOvertimes($id)
    {
        $data = $this->flexperformance_model->getDeletedOvertime($id);
        $result = $this->flexperformance_model->deleteApprovedOvertime($id);

        if ($result == true) {

            echo "<p class='alert alert-warning text-center'>Overtime DELETED Successifully</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED to DELETE, Please Try Again!</p>";
        }
    }

    public function confirmOvertimePayment(Request $request)
    {

        if ($this->uri->segment(3) != '') {

            $overtimeID = $this->uri->segment(3);
            $result = $this->flexperformance_model->confirmOvertimePayment($overtimeID, 1);
            if ($result == true) {
                echo "<p class='alert alert-warning text-center'>Overtime Payment Confirmed Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Confirm, Please Try Again!</p>";
            }
        }
    }

    public function unconfirmOvertimePayment(Request $request)
    {

        if ($this->uri->segment(3) != '') {

            $overtimeID = $this->uri->segment(3);
            $result = $this->flexperformance_model->confirmOvertimePayment($overtimeID, 0);
            if ($result == true) {
                echo "<p class='alert alert-warning text-center'>Overtime Payment Unconfirmed Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED to Unconfirm, Please Try Again!</p>";
            }
        }
    }

    public function fetchOvertimeComment(Request $request, $id)
    {

        $data['comment'] = $this->flexperformance_model->fetchOvertimeComment($id);
        $data['mode'] = 1; // Mode 1 fo Comment Purpose and Mode 2 for Update Purpose
        $data['parent'] = 'Overtime Remarks';

        return view('overtime.overtime_info', $data);
    }

    public function commentOvertime(Request $request)
    {
        $overtimeID = $request->input('overtimeID');

        $data = array(
            'final_line_manager_comment' => $request->input('comment'),
            'commit' => 1,
        );

        $this->flexperformance_model->update_overtime($data, $overtimeID);

        session('note', "<p class='alert alert-success text-center'>Commented Successifully</p>");

        return redirect(route('flex.overtime'));
    }

    /* public function deleteposition(Request $request)
    {

    $id = $this->uri->segment(3);
    $data = array(
    'state' => 0
    );
    $this->flexperformance_model->updateposition($data, $id);

    $response_array['status'] = "OK";
    $response_array['message'] = "<p class='alert alert-danger text-center'>Department Deleted!</p>";
    header('Content-type: application/json');
    echo json_encode($response_array);

    }*/
    /*{
    $id = $request->input("id");
    $data = array(
    'state' => 0
    );
    $this->flexperformance_model->updateposition($data, $id);
    session('note', "<p class='alert alert-warning text-center'>Position Removed Successifully</p>");
    return  redirect('/flex/position');

    }*/

    public function editdepartment(Request $request)
    {
        $id = $request->input('id');

        if ($request->type == 'updatename') {

            $data = array(
                'name' => $request->input("name"),

            );

            $this->flexperformance_model->updatedepartment($data, $id);
            session('note', "<p class='alert alert-success text-center'>Department Updated Successifully</p>");
            return redirect('/flex/department');
        } elseif ($request->type == 'updatecenter') {
            $data = array(
                'cost_center_id' => $request->input("cost_center_id"),

            );

            $this->flexperformance_model->updatedepartment($data, $id);
            session('note', "<p class='alert alert-success text-center'>Cost Center Updated Successifully</p>");
            return redirect('/flex/department');
        } elseif ($request->type == 'updatehod') {

            $data = array(
                'hod' => $request->input("hod"),

            );

            $this->flexperformance_model->updatedepartment($data, $id);
            session('note', "<p class='alert alert-success text-center'>Department Updated Successifully</p>");
            return redirect('/flex/department');
        } elseif ($request->type == 'updateparent') {

            $data = array(
                'reports_to' => $request->input("parent"),
            );

            $this->flexperformance_model->updatedepartment($data, $id);
            session('note', "<p class='alert alert-success text-center'>Department Updated Successifully</p>");
            return redirect('/flex/department');
        }
    }

    public function employee(Request $request)
    {

        $this->authenticateUser('view-employee');

        // if(session('mng_emp')){
        //     $data['employee'] = $this->flexperformance_model->employee();
        //   } elseif(session('mng_emp') ){
        $data['employee'] = $this->flexperformance_model->employee();
        /*}elseif(session('mng_emp')){
        $data['employee'] = $this->flexperformance_model->employeelinemanager(auth()->user()->emp_id);
        }*/

        $data['title'] = "Employee";
        $data['parent'] = "Employee";
        $data['child'] = "Active Employee";
        return view('employee.employee', $data);
    }

    public function payroll(Request $request)
    {
        $data['title'] = "Payrolls And Associated";
        return view('app.payroll', $data);
    }

    ################## UPDATE EMPLOYEE INFO #############################

    public function updateEmployee(Request $request, $id)
    {

        $data = explode('|', $id);

        $empID = $data[0];
        $departmentID = $data[1];

        $data['employee'] = $this->flexperformance_model->userprofile($empID);
        $data['title'] = "Employee";
        $data['pdrop'] = $this->flexperformance_model->positiondropdown2($departmentID);
        $data['contract'] = $this->flexperformance_model->contractdrop();
        $data['ldrop'] = $this->flexperformance_model->linemanagerdropdown();
        $data['ddrop'] = $this->flexperformance_model->departmentdropdown();
        $data['countrydrop'] = $this->flexperformance_model->nationality();
        $data['branchdrop'] = $this->flexperformance_model->branchdropdown();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['pension'] = $this->flexperformance_model->pension_fund();

        $data['salaryTransfer'] = $this->flexperformance_model->pendingSalaryTranferCheck($empID);

        $data['positionTransfer'] = $this->flexperformance_model->pendingPositionTranferCheck($empID);
        $data['departmentTransfer'] = $this->flexperformance_model->pendingDepartmentTranferCheck($empID);

        $data['branchTransfer'] = $this->flexperformance_model->pendingBranchTranferCheck($empID);

        $data['bankdrop'] = $this->flexperformance_model->bank();
        $data['parent'] = 'Employee';
        $data['child'] = 'Update employee';

        // dd($data);

        return view('employee.updateEmployee', $data);
    }

    public function updateFirstName(Request $request)
    {
        $empID = $request->input('empID');

        $updates = array(
            'fname' => $request->input('fname'),
            'last_updated' => date('Y-m-d'),
        );

        $result = $this->flexperformance_model->updateEmployee($updates, $empID);

        if ($result == true) {
            echo "<p class='alert alert-success text-center'>First Name Updated Successifully!</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>Update Failed</p>";
        }
    }

    public function updateCode(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'emp_code' => $request->input('emp_code'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Code Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateLevel(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'emp_level' => $request->input('emp_level'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Level Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateMiddleName(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'mname' => $request->input('mname'),
                'last_updated' => date('Y-m-d'),
            );

            $result = $this->flexperformance_model->updateEmployee($updates, $empID);

            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Middle Name Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateLastName(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'lname' => $request->input('lname'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Last Name Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateGender(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'gender' => $request->input('gender'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Gender Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateDob(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'birthdate' => $request->input('dob'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Birth date Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateExpatriate(Request $request)
    {
        // dd('ok');
        $empID = $request->input('empID');

        $updates = array(
            'is_expatriate' => $request->input('expatriate'),
            'last_updated' => date('Y-m-d'),
        );

        $result = $this->flexperformance_model->updateEmployee($updates, $empID);
        if ($result == true) {
            echo "<p class='alert alert-success text-center'> Updated Successifully!</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>Update Failed</p>";
        }
    }

    public function updateEmployeePensionFund(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'pension_fund' => $request->input('pension_fund'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Pension Fund Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateEmployeePosition(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {

            $data = array(
                'empID' => $empID,
                'parameter' => 'Position',
                'parameterID' => 2,
                'recommended_by' => auth()->user()->emp_id,
                'date_recommended' => date('Y-m-d'),
                'date_approved' => date('Y-m-d'),
                'old' => $request->input('old'),
                'new' => $request->input('position'),
            );
            $result = $this->flexperformance_model->employeeTransfer($data);
            $old = $this->flexperformance_model->getAttributeName("name", "position", "id", $request->input('old'));
            $new = $this->flexperformance_model->getAttributeName("name", "position", "id", $request->input('position'));
            if ($result == true) {
                $this->flexperformance_model->audit_log("Requested Position Change For Employee with ID = " . $empID . " From " . $old . " To " . $new . "");
                echo "<p class='alert alert-success text-center'>Request For Position Transfer Has Been Sent Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED, Request For Position Transfe Has Failed. Please Try Again</p>";
            }
        }
    }

    /* public function updateEmployeeBranch(Request $request) {
    $empID = $request->input('empID');
    if ($request->method() == "POST"&& $empID!='') {
    $data = array(
    'empID' =>$empID,
    'parameter' =>'Branch',
    'parameterID' =>4,
    'recommended_by' =>auth()->user()->emp_id,
    'date_recommended' =>date('Y-m-d'),
    'date_approved' =>date('Y-m-d'),
    'old' =>$request->input('old'),
    'new' =>$request->input('branch')
    );
    $result = $this->flexperformance_model->employeeTransfer($data);
    if($result==true) {
    echo "<p class='alert alert-success text-center'>Request For Branch Transfer Has Been Sent Successifully!</p>";
    } else { echo "<p class='alert alert-danger text-center'>FAILED, Request For Branch Transfe Has Failed. Please Try Again</p>";
    }

    }
    }*/

    public function updateEmployeeBranch(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'branch' => $request->input('branch'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Branch Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateEmployeeNationality(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'nationality' => $request->input('nationality'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Nationality Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateDeptPos(Request $request)
    {
        // dd($request->all());
        $empID = $request->empID;

        $data = array(
            "empID" => $request->empID,
            "parameter" => "Department",
            "parameterID" => 3,
            "recommended_by" => session("emp_id"),
            "date_recommended" => date("Y-m-d"),
            "date_approved" => date("Y-m-d"),
            "old" => $request->input("oldDepartment"),
            "new" => $request->input("department"),
            "old_position" => $request->input("oldPosition"),
            "new_position" => $request->input("position"),
        );

        $result = $this->flexperformance_model->employeeTransfer($data);

        $oldp = $this->flexperformance_model->getAttributeName("name", "position", "id", $request->input('oldPosition'));
        $newp = $this->flexperformance_model->getAttributeName("name", "position", "id", $request->input('position'));
        $oldd = $this->flexperformance_model->getAttributeName("name", "department", "id", $request->input('oldDepartment'));
        $newd = $this->flexperformance_model->getAttributeName("name", "department", "id", $request->input('department'));

        if ($result == true) {
            SysHelpers::AuditLog(2, "Requested Department Change For Employee with ID = " . $empID . " From " . $oldd . " To " . $newd . " and Position From " . $oldp . " To " . $newp . "", $request);
            echo "<p class='alert alert-success text-center'>Request For Department and Position Transfer Has Been Sent Successifully!</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED, Request For Department and Position Transfe Has Failed. Please Try Again</p>";
        }
    }

    public function approveDeptPosTransfer($id)
    {
        if ($id) {
            $transferID = $id;
            $transfer = $this->flexperformance_model->getTransferInfo($transferID);
            foreach ($transfer as $key) {
                $empID = $key->empID;
                $department = $key->new;
                $position = $key->new_position;
            }
            $empUpdates = array(
                'department' => $department,
                'position' => $position,
                'last_updated' => date('Y-m-d'),
            );
            $transferUpdates = array(
                'approved_by' => auth()->user()->emp_id,
                'status' => 1,
                'date_approved' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->confirmTransfer($empUpdates, $transferUpdates, $empID, $transferID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Transfer Completed Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>";
            }
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>";
        }
    }

    public function approveSalaryTransfer(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $transferID = $this->uri->segment(3);
            $transfer = $this->flexperformance_model->getTransferInfo($transferID);
            foreach ($transfer as $key) {
                $empID = $key->empID;
                $salary = $key->new;
            }
            $empUpdates = array(
                'salary' => $salary,
                'last_updated' => date('Y-m-d'),
            );
            $transferUpdates = array(
                'approved_by' => auth()->user()->emp_id,
                'status' => 1,
                'date_approved' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->confirmTransfer($empUpdates, $transferUpdates, $empID, $transferID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Transfer Completed Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>";
            }
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>";
        }
    }

    public function approvePositionTransfer(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $transferID = $this->uri->segment(3);
            $transfer = $this->flexperformance_model->getTransferInfo($transferID);
            foreach ($transfer as $key) {
                $empID = $key->empID;
                $position = $key->new;
            }
            $empUpdates = array(
                'position' => $position,
                'last_updated' => date('Y-m-d'),
            );
            $transferUpdates = array(
                'approved_by' => auth()->user()->emp_id,
                'status' => 1,
                'date_approved' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->confirmTransfer($empUpdates, $transferUpdates, $empID, $transferID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Transfer Completed Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>";
            }
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED: Transfer has Failed, Please Try Again</p>";
        }
    }

    public function cancelTransfer(Request $request)
    {
        if ($this->uri->segment(3) != '') {
            $transferID = $this->uri->segment(3);

            $result = $this->flexperformance_model->cancelTransfer($transferID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Transfer Cancelled Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED: Failed To Cancel The Transfer, Please Try Again</p>";
            }
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED: Transfer Operation has Failed, Please Try Again</p>";
        }
    }

    public function updateSalary(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'salary' => $request->input('salary'),
            );
            $data = array(
                'empID' => $empID,
                'parameter' => 'Salary',
                'parameterID' => 1,
                'recommended_by' => auth()->user()->emp_id,
                'date_recommended' => date('Y-m-d'),
                'date_approved' => date('Y-m-d'),
                'old' => $request->input('old'),
                'new' => $request->input('salary'),
            );
            // $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            $result = $this->flexperformance_model->employeeTransfer($data);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Request For Salary Updation Has Been Sent Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>FAILED, Request For Salary Updation Has Failed. Please Try Again</p>";
            }
        }
    }

    public function updateEmail(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'email' => $request->input('email'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Email Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updatePostAddress(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $address_no = $request->input('address');
            $full_address = "P.O Box " . $address_no;
            $updates = array(
                'postal_address' => $full_address,
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Posta Address Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updatePostCity(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'postal_city' => $request->input('city'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Postal City Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updatePhysicalAddress(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'physical_address' => $request->input('phys_address'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Physical Address Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateMobile(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'mobile' => $request->input('mobile'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Mobile Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateHomeAddress(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'home' => $request->input('home_address'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Physical Address Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateNationalID(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'national_id' => $request->input('nationalid'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>National ID Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateTin(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'tin' => $request->input('tin'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Tin Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateBankAccountNo(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'account_no' => $request->input('acc_no'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Physical Address Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateBank_Bankbranch(Request $request)
    {
        $empID = $request->input('empID');
        $bank = $request->input('bank');
        $bank_branch = $request->input('bank_branch');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'bank' => $bank,
                'bank_branch' => $bank_branch,
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);

            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Bank and Bank Branch Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateLineManager(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'line_manager' => $request->input('line_manager'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Line Manager Status Address Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateEmployeeContract(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'contract_type' => $request->input('contract'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Contract Status Address Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateMeritalStatus(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'merital_status' => $request->input('merital_status'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Merital Status Address Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updatePensionFundNo(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'pf_membership_no' => $request->input('pension_no'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Physical Address Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateOldID(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $updates = array(
                'old_emp_id' => $request->input('old_id'),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateEmployee($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    private function storeImage($request)
    {
        $newImageName = $request->userfile->hashName();
        $request->userfile->move(public_path('storage/profile'), $newImageName);

        return $newImageName;
    }

    public function updateEmployeePhoto(Request $request)
    {

        $empID = $request->input('empID');

        if ($request->method() == "POST" && $empID != '') {
            $namefile = "user_" . $empID;

            $updates = array(
                'photo' => $this->storeImage($request),
                'last_updated' => date('Y-m-d'),
            );

            $result = $this->flexperformance_model->updateEmployee($updates, $empID);

            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Employee Picture Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Failed to Update, Try again</p>";
            }
        }
    }

    public function transfers(Request $request)
    {
        $this->authenticateUser('view-transfer');

        // // $data['leave'] =  $this->attendance_model->leavereport();
        // if (session('mng_emp') || session('vw_emp') || session('appr_emp') || session('mng_roles_grp')) {
        $data['transfers'] = $this->flexperformance_model->employeeTransfers();
        $data['title'] = "Transfers";
        return view('app.transfer', $data);
        // } else {
        //     echo 'Unauthorized Access';
        // }
    }

    // ###################LEAVE######################################

    public function salary_advance(Request $request)
    {

        $this->authenticateUser('view-loan');

        // if(session('mng_paym') ||session('recom_paym') ||session('appr_paym')){
        $data['myloan'] = $this->flexperformance_model->mysalary_advance(auth()->user()->emp_id);
        // dd($data);

        // if(session('recom_loan')!='' &&session('appr_loan')){

        $data['otherloan'] = $this->flexperformance_model->salary_advance();

        // } elseif (session('recom_loan')!=''){
        //     $data['otherloan'] = $this->flexperformance_model->hr_fin_salary_advance();
        // }
        // elseif (session('appr_loan')!=''){
        //     $data['otherloan'] = $this->flexperformance_model->fin_salary_advance();
        // }

        $data['employee'] = $this->flexperformance_model->customemployee();
        $data['max_amount'] = $this->flexperformance_model->get_max_salary_advance(auth()->user()->emp_id);
        $data['title'] = "Loans and Salaries";
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        return view('app.salary_advance', $data);
        // }else{
        //    echo 'Unauthorized Access';
        //}

    }

    public function current_loan_progress(Request $request)
    {
        $data['max_amount'] = $this->flexperformance_model->get_max_salary_advance(auth()->user()->emp_id);
        $data['myloan'] = $this->flexperformance_model->mysalary_advance_current(auth()->user()->emp_id);

        $this->flexperformance_model->update_salary_advance_notification_staff(auth()->user()->emp_id);

        if (session('recom_loan') != '' && session('appr_loan') != '') {
            $data['otherloan'] = $this->flexperformance_model->hr_fin_salary_advance_current();
            $this->flexperformance_model->update_salary_advance_notification_hr_fin(auth()->user()->emp_id);
        } elseif (session('recom_loan') != '') {
            $data['otherloan'] = $this->flexperformance_model->hr_salary_advance_current();
            $this->flexperformance_model->update_salary_advance_notification_hr();
        } elseif (session('appr_loan') != '') {
            $data['otherloan'] = $this->flexperformance_model->fin_salary_advance_current();
            $this->flexperformance_model->update_salary_advance_notification_fin();
        }

        $data['employee'] = $this->flexperformance_model->customemployee();
        $data['title'] = "Loans and Salaries";
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        return view('app.salary_advance', $data);
    }

    public function apply_salary_advance(Request $request)
    {

        if ($request->method() == "POST") {
            $amount_normal = $request->input("amount");
            $amount_mid = $request->input("amount_mid");
            $advance_type = $request->input("advance_type");
            $deduction = $request->input("deduction");

            if ($advance_type == 1) {
                $amount = $amount_normal;
                $deduction_amount = $amount_normal;
            } else {
                $amount = $amount_normal;
                $deduction_amount = $deduction;
            }

            $data = array(
                'empID' => auth()->user()->emp_id,
                'amount' => $amount,
                'deduction_amount' => $deduction_amount,
                'type' => 1,
                'notification' => 2,
                'status' => 0,
                'reason' => $request->input("reason"),
                'application_date' => date('Y-m-d'),
            );

            $result = $this->flexperformance_model->applyloan($data);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Request Submitted Successifully</p>";
            } else {
                echo "<p class='alert alert-warning text-center'>Request FAILED, Please Try Again</p>";
            }
        }
        //      else echo "string";

    }

    public function insert_directLoan(Request $request)
    {

        if ($request->method() == "POST") {
            $category = $request->input("type");

            if ($category == 2) {
                $type = 3;
                $form_four_index_no = $request->input("index_no");
                $deduction = 0;
            } elseif ($category == 1) {
                $form_four_index_no = "0";
                $type = 2;
                $deduction = $request->input("deduction");
            }

            $data = array(
                'empID' => $request->input("employee"),
                'amount' => $request->input("amount"),
                'deduction_amount' => $deduction,
                'approved_hr' => auth()->user()->emp_id,
                'status' => 1,
                'notification' => 3,
                'approved_date_hr' => date('Y-m-d'),
                'type' => $type,
                'form_four_index_no' => $form_four_index_no,
                'reason' => $request->input("reason"),
                'application_date' => date('Y-m-d'),
            );

            $result = $this->flexperformance_model->applyloan($data);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Request Submitted Successifully</p>";
            } else {
                echo "<p class='alert alert-warning text-center'>Request FAILED, Please Try Again</p>";
            }
        }
    }

    public function confirmed_loans(Request $request)
    {
        $empID = auth()->user()->emp_id;

        $this->authenticateUser('view-loan');

        $data['my_loans'] = $this->flexperformance_model->my_confirmedloan($empID);

        $data['other_loans'] = $this->flexperformance_model->all_confirmedloan();

        $data['title'] = "Loan";
        return view('app.loan', $data);
    }

    public function loan_advanced_payments(Request $request)
    {
        $loanID = base64_decode($request->key);

        $data['loan_info'] = $this->flexperformance_model->getloan($loanID);
        $data['title'] = "Advanced Loan Payments";
        return view('app.loan_adv_payment', $data);
    }

    public function adv_loan_pay(Request $request)
    {
        if ($request->method() == "POST") {
            $state = 1;
            $loanID = $request->input('loanID');
            $accrued = $request->input('accrued');
            $paid = $request->input('paid');
            $amount = $request->input('amount');
            $remained = $request->input('remained');
            if ($amount === $remained) {
                $state = 0;
            }
            $data = array(
                'amount_last_paid' => $paid,
                'paid' => $paid + $accrued,
                'state' => $state,
                'last_paid_date' => date('Y-m-d'),

            );
            $result = $this->flexperformance_model->updateLoan($data, $loanID);
            if ($result) {
                $response_array['status'] = "OK";
                $response_array['message'] = "<p class='alert alert-success text-center'>Updated Updated Successifully</p>";
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Loan Not Updated, Please try again</p>";
            }

            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    ################## START LOAN OPERATIONS ###########################
    public function cancelLoan(Request $request)
    {

        if ($this->uri->segment(3) != '') {
            $loanID = $this->uri->segment(3);
            $result = $this->flexperformance_model->deleteLoan($loanID);
            if ($result == true) {
                echo "<p class='alert alert-warning text-center'>Loan DELETED Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>DELETION FAILED, Please Try Again</p>";
            }
        }
    }

    public function recommendLoan($id)
    {

        if ($id != '') {

            $loanID = $id;
            $data = array(

                'approved_date_finance' => date('Y-m-d'),
                'approved_finance' => auth()->user()->emp_id,
                'status' => 1,
                'notification' => 3,
            );
            $this->flexperformance_model->update_loan($data, $loanID);
            echo "<p class='alert alert-info text-center'>Loan Recommended Successifully</p>";
        }
    }

    public function hrrecommendLoan($id)
    {

        if ($id != '') {

            $loanID = $id;
            $data = array(

                'approved_date_hr' => date('Y-m-d'),
                'approved_hr' => auth()->user()->emp_id,
                'status' => 6,
                'notification' => 3,
            );
            $this->flexperformance_model->update_loan($data, $loanID);
            echo "<p class='alert alert-info text-center'>Loan Recommended Successifully</p>";
        }
    }

    public function holdLoan($id)
    {

        if ($id != '') {

            $loanID = $id;
            $data = array(
                'status' => 3,
                'notification' => 1,
            );
            $this->flexperformance_model->update_loan($data, $loanID);
            echo "<p class='alert alert-warning text-center'>Loan Held Successifully</p>";
        }
    }

    public function approveLoan($id)
    {

        if ($id != '') {

            $loanID = $id;

            $hrdata = array(
                'approved_date_hr' => date('Y-m-d'),
                'approved_hr' => auth()->user()->emp_id,
                // 'status' => 6,
                'notification' => 3,
            );

            $this->flexperformance_model->update_loan($hrdata, $loanID);

            $data = array(
                'approved_date_finance' => date('Y-m-d'),
                'approved_finance' => auth()->user()->emp_id,
                // 'status' => 1,
                // 'notification' => 3,
            );

            $this->flexperformance_model->update_loan($data, $loanID);

            $todate = date('Y-m-d');

            $result = $this->flexperformance_model->approve_loan($loanID, auth()->user()->emp_id, $todate);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Loan Approved Successifully</p>";
            } else {
                echo "<p class='alert alert-warning text-center'>Loan NOT Approved, Please Try Again</p>";
            }
        }
    }

    public function pauseLoan($id)
    {
        if ($id != '') {
            $loanID = $id;
            $data = array(
                'state' => 2,
            );

            $result = $this->flexperformance_model->updateLoan($data, $loanID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Loan PAUSED Successifully</p>";
            } else {
                echo "<p class='alert alert-warning text-center'>Loan NOT PAUSED, Please Try Again</p>";
            }
        }
    }

    public function resumeLoan($id)
    {
        if ($id != '') {
            $loanID = $id;
            $data = array(
                'state' => 1,
            );

            $result = $this->flexperformance_model->updateLoan($data, $loanID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Loan RESUMED Successifully</p>";
            } else {
                echo "<p class='alert alert-warning text-center'>Loan NOT RESUMED, Please Try Again</p>";
            }
        }
    }

    public function rejectLoan($id)
    {

        if ($id != '') {

            $loanID = $id;
            $data = array(
                'status' => 5,
                'notification' => 1,
            );
            $this->flexperformance_model->update_loan($data, $loanID);
            echo "<p class='alert alert-danger text-center'>Loan Disapproved!</p>";
        }
    }

    ######################## END LOAN OPERATIONS##############################

    public function loan_application_info(Request $request)
    {
        $id = $request->input('id');

        $data['data'] = $this->flexperformance_model->getloanbyid($id);
        $data['title'] = "Loans and Salary Advance";
        return view('app.loan_application_remarks', $data);

        if (isset($_POST['add'])) {
            if (session('recomloan') != 0 || 1) {
                $data2 = array(
                    'reason_hr' => $request->input("remarks"),
                );
            } elseif (session('appr_loan') != 0 || 1) {
                $data2 = array(
                    'reason_finance' => $request->input("remarks"),
                );
            }

            $this->flexperformance_model->confirmloan($data2, $id);
            $reload = '/flex/loan_application';
            return redirect($reload);
        }
    }

    public function updateloan(Request $request)
    {

        $loanID = $request->input('id');

        $data['loan'] = $this->flexperformance_model->getloanbyid($loanID);
        $data['title'] = "Loan";
        return view('app.updateloan', $data);
    }

    public function updateloan_info(Request $request)
    {
        if ($request->method() == "POST" && $request->input('loanID')) {
            $loanID = $request->input('loanID');
            $updates = array(
                'amount' => $request->input('amount'),
                'deduction_amount' => $request->input('deduction'),
                'reason' => $request->input('reason'),
                'notification' => 1,
            );

            $result = $this->flexperformance_model->update_loan($updates, $loanID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Application Updated Successifully</p>";
            } else {
                echo "<p class='alert alert-warning text-center'>Application Update FAILED, Please Try Again</p>";
            }
        }
    }

    public function financial_reports(Request $request)
    {
        //

        $this->authenticateUser('view-report');
        // if(session('mng_paym')||session('recom_paym')||session('appr_paym')){
        $data['month_list'] = $this->flexperformance_model->payroll_month_list();
        $data['year_list'] = $this->flexperformance_model->payroll_year_list();
        $title = "Financial Reports";
        $parent = "Payroll";
        $child = "Financial Reports";

        return view('payroll.financial_reports', compact('title', 'parent', 'child', 'data'));
        //   }else{
        //       echo 'Unauthorised Access';
        //   }

    }

    public function organisation_reports()
    {
        $this->authenticateUser('view-report');
        // if (session('mng_paym') || session('recom_paym') || session('appr_paym')) {
        $data['month_list'] = $this->flexperformance_model->payroll_month_list();
        $data['year_list'] = $this->flexperformance_model->payroll_year_list();
        $data['projects'] = $this->project_model->allProjects();
        $data['employee'] = Employee::where('state', '=', 1)->get();

        $data['departments'] = Departments::all();

        $data['title'] = "Organisation Reports";
        $data['leave_type'] = $this->attendance_model->leave_type();
        $data['employee'] = Employee::all();
        return view('app.organisation_reports', $data);
        // } else {
        //     echo 'Unauthorized Access';
        // }
    }

    public function not_logged_in()
    {
        session('error', 'Sorry! You Have to Login Before any Attempt');
        return redirect('/flex/');
    }

    public function viewrecords(Request $request)
    {
        $data['viewrecords'] = $this->flexperformance_model->viewrecords();
        return view('app.viewrecords', $data);
    }

    public function employeeChart(Request $request)
    {

        $year = $request->has('year') ? $request->year : date('Y');

        $employee = Employee::select(DB::raw("COUNT(*) as count"))

            ->whereYear('hire_date', $year)

            ->groupBy(DB::raw("Month(hire_date)"))

            ->pluck('count');

        $chart = new EmployeeLineChart;

        $chart->dataset('New Employee Registered Chart', 'bar', $employee)->options([

            'fill' => 'true',

            // 'borderColor' => '#0A1330'

        ]);

        return $chart->api();
    }

    public function home(Request $request)
    {

        // $api = url('/flex/chart-line-ajax');
        // $chart = new EmployeeLineChart;
        // $chart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->load($api);
        // $data['chart'] = $chart;

        // $strategyStatistics = $this->performanceModel->strategy_info(1);

        // $payrollMonth = $this->payroll_model->recent_payroll_month(date('Y-m-d'));

        // $payrollMonth = $this->payroll_model->recent_payroll_month(date('Y-m-d'));

        // $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($payrollMonth . "-1 month"))));

        // $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

        // foreach ($strategyStatistics as $key) {
        //     $strategyID = $key->id;
        //     $strategyTitle = $key->title;
        //     $start = date_create($key->start);
        // }

        // $strategyProgress = $this->performanceModel->strategyProgress($strategyID);

        // $current = date_create(date('Y-m-d'));
        // $diff = date_diff($start, $current);
        // $required = $diff->format("%a");
        // $months = number_format(($required / 30.5), 4);
        // $rate_per_month = number_format(($strategyProgress / $months), 1);

        $data['appreciated'] = $this->flexperformance_model->appreciated_employee();
        $data['deligate'] = $this->flexperformance_model->get_deligates(auth()->user()->emp_id);
        // // $data['employee_count'] =  $this->flexperformance_model->count_employees();
        $data['overview'] = $this->flexperformance_model->employees_info();
        // $data["strategyProgress"] = $strategyProgress;
        // $data["monthly"] = $rate_per_month;

        // $data['taskline'] = $this->performanceModel->total_taskline(auth()->user()->emp_id);
        // $data['taskstaff'] = $this->performanceModel->total_taskstaff(auth()->user()->emp_id);

        // $data['payroll_totals'] = $this->payroll_model->payrollTotals("payroll_logs", $payrollMonth);
        // $data['total_allowances'] = $this->payroll_model->total_allowances("allowance_logs", $payrollMonth);
        // $data['total_bonuses'] = $this->payroll_model->total_bonuses($payrollMonth);
        // $data['total_loans'] = $this->payroll_model->total_loans("loan_logs", $payrollMonth);
        // $data['total_heslb'] = $this->payroll_model->total_heslb("loan_logs", $payrollMonth);
        // $data['take_home'] = $this->reports_model->sum_take_home($payrollMonth);
        // $data['total_deductions'] = $this->payroll_model->total_deductions("deduction_logs", $payrollMonth);
        // $data['total_overtimes'] = $this->payroll_model->total_overtimes($payrollMonth);
        // $data['payroll_date'] = $payrollMonth;
        // $data['arrears'] = $this->payroll_model->arrearsMonth($payrollMonth);
        // $data['s_gross_c'] = $this->reports_model->s_grossMonthly($payrollMonth);
        // $data['v_gross_c'] = $this->reports_model->v_grossMonthly($payrollMonth);
        // $data['s_gross_p'] = $this->reports_model->s_grossMonthly($previous_payroll_month);
        // $data['v_gross_p'] = $this->reports_model->v_grossMonthly($previous_payroll_month);
        // $data['s_net_c'] = $this->reports_model->staff_sum_take_home($payrollMonth);
        // $data['v_net_c'] = $this->reports_model->temporary_sum_take_home($payrollMonth);
        // $data['s_net_p'] = $this->reports_model->staff_sum_take_home($previous_payroll_month);
        // $data['v_net_p'] = $this->reports_model->temporary_sum_take_home($previous_payroll_month);
        // $data['v_staff'] = $this->reports_model->v_payrollEmployee($payrollMonth, '');
        // $data['s_staff'] = $this->reports_model->s_payrollEmployee($payrollMonth, '');
        // $data['v_staff_p'] = $this->reports_model->v_payrollEmployee($previous_payroll_month, '');
        // $data['s_staff_p'] = $this->reports_model->s_payrollEmployee($previous_payroll_month, '');
        // $data['net_total'] = $this->netTotalSummation($payrollMonth);

        // // start of overtime
        // $data['my_overtimes'] = $this->flexperformance_model->my_overtimes(auth()->user()->emp_id);
        // $data['overtimeCategory'] = $this->flexperformance_model->overtimeCategory();
        $data['employees'] = EMPL::all();

        $data['line_overtime'] = $this->flexperformance_model->lineOvertimes(auth()->user()->emp_id);
        // end of overtime

        if (session('password_set') == "1") {
            return view('auth.password-change');
        } else {
            $employee = EMPL::where('emp_id', auth()->user()->emp_id)->first();

            if (empty($employee->photo)) {
                return redirect()->route('flex.userdata', base64_encode(auth()->user()->emp_id));
            }

            $data['parent'] = 'Dashboard';

            return view('dashboard', $data);
        }
    }

    public function arrayRecursiveDiff($aArray1, $aArray2)
    {
        $aReturn = array();
        //bool in_array( $val, $array_name, $mode );
        for ($i = 0; $i < count($aArray1); $i++) {
            if (in_array($aArray1[$i]['description'], $aArray2)) {
                unset($aArray1[$i]);
                // dd($row['description']);
            } else {
                // array_push($aRetur)
            }
        }

        return $aArray1;
    }

    public function subdropFetcher()
    {

        if (!empty($this->uri_segment(3))) {

            $querypos = $this->flexperformance_model->positionfetcher($this->uri_segment(3));

            foreach ($querypos as $row) {
                echo "<option value='" . $row->id . "'>" . $row->name . "</option>";
            }
        } else {

            echo '<option value="">Position not available</option>';
        }
    }

    public function positionFetcher(Request $request)
    {
        $depID = $request->input("dept_id");

        if (!empty($depID)) {
            $query = $this->flexperformance_model->positionfetcher($depID);

            $querypos = $query[0];
            $querylinemanager = $query[1];
            //   $querydirector = $query[2];
            $data = [];
            $data['position'] = $querypos;
            $data['linemanager'] = $querylinemanager;
            //   $data['director'] = $querydirector;

            echo json_encode($data);
        } else {

            echo '<option value="">Position not available</option>';
        }
    }

    public function bankBranchFetcher(Request $request)
    {

        if (!empty($request->input("bank"))) {
            $queryBranch = $this->flexperformance_model->bankBranchFetcher($request->input("bank"));
            foreach ($queryBranch as $rows) {
                echo "<option value='" . $rows->id . "'>" . $rows->name . "</option>";
            }
        } else {
            echo '<option value="">Branch Not Available</option>';
        }
    }

    public function addkin(Request $request, $id)
    {
        if ($id != auth()->user()->emp_id) {
            $this->authenticateUser('edit-employee');
        }
        date_default_timezone_set('Africa/Dar_es_Salaam');

        $data = array(
            'fname' => $request->input("fname"),
            'mname' => $request->input("mname"),
            'lname' => $request->input("lname"),
            'mobile' => $request->input("mobile"),
            'relationship' => $request->input("relationship"),
            'employee_fk' => $id,
            'postal_address' => $request->input("postal_address"),
            'physical_address' => $request->input("physical_address"),
            'office_no' => $request->input("office_no"),
            'added_on' => date('Y-m-d'),
        );

        $this->flexperformance_model->addkin($data);
        //echo "Record Added";
        session('note', "<p class='alert alert-success text-center'>Record Added Successifully</p>");

        $reload = '/flex/userprofile/' . base64_encode($id);

        return redirect($reload);
    }

    public function deletekin($empID, $id)
    {
        // $id = $request->input("id");
        DB::table('next_of_kin')->where('id', $id)->delete();
        // $this->db->where('id', $id);
        // $this->db->delete('next_of_kin');

        session('note', "<p class='alert alert-warning text-center'>Position Removed Successifully</p>");

        $reload = '/flex/userprofile/' . base64_encode($empID);

        return redirect($reload);
    }

    public function addproperty(Request $request)
    {

        if ($request->input("type") != 'Others') {
            // $id = $request->input('id');
            $type = $request->input("type");
        } else {
            $type = $request->input("type2");
        }

        $data = array(
            'prop_type' => $type,
            'prop_name' => $request->input("name"),
            'serial_no' => $request->input("serial"),
            'given_by' => auth()->user()->emp_id,
            'given_to' => $request->input("employee"),
        );

        $this->flexperformance_model->addproperty($data);
        session('note', "<p class='alert alert-success text-center'>Property Assigned Successifully</p>");

        $reload = '/flex/userprofile/' . base64_encode($request->input("employee"));
        return redirect($reload);
    }

    public function employee_exit($id)
    {

        $empID = $id;

        $datalog = array(
            'state' => 0,
            'empID' => $empID,
            'author' => auth()->user()->emp_id,
        );

        $this->flexperformance_model->employeestatelog($datalog);

        //  if($result ==true){
        //      $this->flexperformance_model->audit_log("Requested Deactivation of an Employee with ID =".$empID."");

        $response_array['status'] = "OK";
        $response_array['title'] = "SUCCESS";
        $response_array['message'] = "<p class='alert alert-success text-center'>Deactivation Request For This Employee Has Been Sent Successifully</p>";

        header('Content-type: application/json');
        echo json_encode($response_array);

        //  } else {
        //    $response_array['status'] = "ERR";
        //    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Deactivation Request Not Sent</p>";
        //    header('Content-type: application/json');
        //    echo json_encode($response_array);
        //  }
    }

    public function deleteproperty($id, Request $request)
    {
        $employee = $request->input("employee");

        $data = array(
            'isActive' => 0,
        );
        $this->flexperformance_model->updateproperty($data, $id);

        $response_array['status'] = "OK";
        header('Content-type: application/json');
        echo json_encode($response_array);
    }

    public function employeeDeactivationRequest(Request $request)
    {
        $exit_date = str_replace('/', '-', $request->input('exit_date'));

        $data = array(
            'empID' => $request->input("empID"),
            'initiator' => $request->input("initiator"),
            'confirmed_by' => auth()->user()->emp_id,
            'date_confirmed' => date('Y-m-d'),
            'reason' => $request->input("reason"),
            'exit_date' => date('Y-m-d', strtotime($exit_date)),
        );

        $datalog = array(
            'state' => 3,
            'empID' => $request->input("empID"),
            'author' => auth()->user()->emp_id,
        );
        //          echo json_encode($data);

        $this->flexperformance_model->employee_exit($data);
        $this->flexperformance_model->employeestatelog($datalog);
        // $this->flexperformance_model->audit_log("Requested Deactivation of an Employee with ID =" . $request->input("empID") . "");
        session('note', "<p class='alert alert-success text-center'>Employee Done Successifully</p>");

        $reload = '/flex/userprofile/' . base64_encode($request->input("empID"));
        return redirect($reload);
    }

    public function employeeActivationRequest($id, Request $request)
    {
        $empID = $id;

        $datalog = array(
            'state' => 1,
            'empID' => $empID,
            'author' => auth()->user()->emp_id,
        );

        $result = $this->flexperformance_model->updateemployeestatelog($datalog, $empID);

        if ($result == true) {
            // $this->flexperformance_model->audit_log("Activation of Employee with ID =".$empID."");

            $response_array['status'] = "OK";
            $response_array['title'] = "SUCCESS";
            $response_array['message'] = "<p class='alert alert-success text-center'>Activation Request For This Employee Has Been Sent Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Activation Request Not Sent</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function cancelRequest($id, $empID, Request $request)
    {
        $updates = array(
            'state' => 0,
            'current_state' => 0,
            'empID' => $empID,
        );

        $result = $this->flexperformance_model->updateemployeestatelog($updates, $id);

        $this->flexperformance_model->audit_log("Exit Cancelled of an Employee with ID =" . $empID . "");

        SysHelpers::AuditLog(1, "Exit Cancelled of an Employee with ID =" . $empID, $request);

        $response_array['status'] = "OK";
        $response_array['title'] = "SUCCESS";
        $response_array['message'] = "<p class='alert alert-success text-center'>Activation Request For This Employee Has Been CANCELLED Successifully</p>";

        header('Content-type: application/json');

        $result = $this->flexperformance_model->updateemployeestatelog($updates, $logID);
        $this->flexperformance_model->audit_log("Exit Cancelled of an Employee with ID =" . $empID . "");
        $response_array['status'] = "OK";
        $response_array['title'] = "SUCCESS";
        $response_array['message'] = "<p class='alert alert-success text-center'>Activation Request For This Employee Has Been CANCELLED Successifully</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);

        //      if($result ==true){
        //            $response_array['status'] = "OK";
        //            $response_array['title'] = "SUCCESS";
        //            $response_array['message'] = "<p class='alert alert-success text-center'>Activation Request For This Employee Has Been CANCELLED Successifully</p>";
        //            header('Content-type: application/json');
        //            echo json_encode($response_array);
        //        } else {
        //            $response_array['status'] = "ERR";
        //            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED:Failed to Cancel this Request</p>";
        //            header('Content-type: application/json');
        //            echo json_encode($response_array);
        //        }
    }

    public function activateEmployee($logID, $empID, Request $request)
    {

        $todate = date('Y-m-d');

        $property = array(
            'prop_type' => "Employee Package",
            'prop_name' => "Employee ID, Health Insuarance Card Email and System Access",
            'serial_no' => $empID,
            'given_by' => auth()->user()->emp_id,
            'given_to' => $empID,
        );

        $datagroup = array(
            'empID' => $empID,
            'group_name' => 1,
        );

        $datalog = array(
            'state' => 1,
            'current_state' => 1,
            'empID' => $empID,
            'author' => auth()->user()->emp_id,
        );

        $result = $this->flexperformance_model->activateEmployee($property, $datagroup, $datalog, $empID, $logID, $todate);

        if ($result == true) {
            //   $this->flexperformance_model->audit_log("Activated an Employee of ID =".$empID."");
            $response_array['status'] = "OK";
            $response_array['title'] = "SUCCESS";
            $response_array['message'] = "<p class='alert alert-success text-center'>Employee Has Activated Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED:Failed to Activate Employee</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function deactivateEmployee(Request $request)
    {
        //confirm exit status is 4
        $logID = $this->uri->segment(3);
        $empID = $this->uri->segment(4);
        $todate = date('Y-m-d');

        $final_state = array(
            'current_state' => 1,
        );

        $datalog = array(
            'state' => 4,
            'current_state' => 4,
            'empID' => $empID,
            'author' => auth()->user()->emp_id,
        );
        //        echo json_encode($datalog);

        $this->flexperformance_model->deactivateEmployee($empID, $datalog, $logID, $todate);
        $this->flexperformance_model->employeestatelog($datalog);
        $this->flexperformance_model->audit_log("Exit Confirm Employee of ID =" . $empID . "");
        $response_array['status'] = "OK";
        $response_array['title'] = "SUCCESS";
        $response_array['message'] = "<p class='alert alert-success text-center'>Employee Has Deactivated Successifully</p>";
        header('Content-type: application/json');
        echo json_encode($response_array);
        //        $result = $this->flexperformance_model->deactivateEmployee($empID, $datalog, $logID, $todate);
        //        if($result ==true){
        //            $this->flexperformance_model->audit_log("Deactivated Employee of ID =".$empID."");
        //            $response_array['status'] = "OK";
        //            $response_array['title'] = "SUCCESS";
        //            $response_array['message'] = "<p class='alert alert-success text-center'>Employee Has Deactivated Successifully</p>";
        //            header('Content-type: application/json');
        //            echo json_encode($response_array);
        //        } else {
        //            $response_array['status'] = "ERR";
        //            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED:Failed to Deactivate Employee</p>";
        //            header('Content-type: application/json');
        //            echo json_encode($response_array);
        //        }
    }

    public function inactive_employee(Request $request)
    {
        $this->authenticateUser('view-employee');

        // if (session('mng_emp') || session('vw_emp') || session('appr_emp') || session('mng_roles_grp')) {
        $data['employee1'] = $this->flexperformance_model->inactive_employee1();
        $data['employee2'] = $this->flexperformance_model->inactive_employee2();
        $data['employee3'] = $this->flexperformance_model->inactive_employee3();

        $data['title'] = "Employee";
        $data['parent'] = "Inactive employee";

        // dd($data['employee2']);
        return view('app.inactive_employee', $data);
        // } else {
        //     echo 'Unauthorized Access';
        // }
    }

    ###########################UNPAID LESVE #################################

    public function unpaid_leave()
    {

        $this->authenticateUser('view-unpaid-leaves');

        $data['employee'] = $this->flexperformance_model->unpaid_leave_employee();
        return view("unpaidleave.index", $data);
    }

    public function add_unpaid_leave()
    {

        $data['employees'] = $this->flexperformance_model->Employee();

        return view("unpaidleave.add-unpaid-leave", $data);
    }

    public function end_unpaid_leave($id)
    {
        $result = $this->flexperformance_model->end_upaid_leave($id);
        if ($result) {
            session('note', "<p class='alert alert-warning text-center'>Unpaid Leave Ended Successifully</p>");
        } else {
            session('note', "<p class='alert alert-warning text-center'>End Unpaid Leave Failed </p>");
        }

        return redirect(route('flex.unpaid_leave'));
    }

    public function confirm_unpaid_leave($id)
    {
        $result = $this->flexperformance_model->confirm_upaid_leave($id);
        if ($result) {
            session('note', "<p class='alert alert-warning text-center'>Unpaid Leave Confirmed Successifully</p>");
        } else {
            session('note', "<p class='alert alert-warning text-center'>Confirm Unpaid Leave Failed </p>");
        }

        return redirect(route('flex.unpaid_leave'));
    }
    public function save_unpaid_leave(Request $request)
    {
        request()->validate(
            [
                'empID' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'reason' => 'required',
            ]
        );

        $data = ['empID' => $request->empID, 'start_date' => $request->start_date, 'end_date' => $request->end_date, 'reason' => $request->reason];

        SysHelpers::FinancialLogs($request->empID, 'Unpaid Leave', $request->start_date, $request->end_date, 'Payroll Input');

        $result = $this->flexperformance_model->save_unpaid_leave($data);

        session('note', "<p class='alert alert-warning text-center'>Unpaid Leave Added Successifully</p>");

        return redirect(route('flex.unpaid_leave'));
    }

    #####################DEDUCTIONS############################################

    public function delete_deduction($id, Request $request)
    {

        // $is_active = 0;

        $data = array(
            'is_active' => 0,
            'rate_employer' => 0,
            'rate_employee' => 0,
        );

        if ($this->flexperformance_model->updatededuction($data, $id)) {
            return redirect('/flex/deduction');
        }
    }

    public function delete_non_statutory_deduction($id, Request $request)
    {

        // $is_active = 0;

        $data = array(
            'state' => 0,
        );

        $result = $this->flexperformance_model->updatededuction_non_statutory_deduction($data, $id);
        if ($result == true) {
            $json_array['status'] = "OK";
            $json_array['message'] = "<p class='alert alert-success text-center'>Deduction Deactivated!</p>";

            echo "";
        } else {

            $json_array['status'] = "ERR";
            $json_array['message'] = "<p class='alert alert-danger text-center'>Deactivation Failed</p>";
        }
        header("Content-type: application/json");
        echo json_encode($json_array);
    }

    public function deduction_info($pattern)
    {
        $values = explode('|', $pattern);
        $deductionID = $values[0];
        $deductionType = $values[1];

        /*
        PARAMETERS:
        1 For Pension,
        2 For Deductions,
        3 For Meals deduction
         */

        if ($deductionType == 1) {
            $data['pension'] = $this->flexperformance_model->getPensionById($deductionID);
            $data['deduction_type'] = 1;
        }

        if ($deductionType == 2) {
            $data['deduction'] = $this->flexperformance_model->getDeductionById($deductionID);
            $data['deduction_type'] = 2;
            $data['group'] = $this->flexperformance_model->deduction_customgroup($deductionID);
            $data['employeein'] = $this->flexperformance_model->deduction_individual_employee($deductionID);
            $data['membersCount'] = $this->flexperformance_model->deduction_membersCount($deductionID);
            $data['groupin'] = $this->flexperformance_model->get_deduction_group_in($deductionID);
            $data['employee'] = $this->flexperformance_model->employee_deduction($deductionID);
        }

        if ($deductionType == 3) {
            $data['meals'] = $this->flexperformance_model->getMeaslById($deductionID);
            $data['deduction_type'] = 3;
        }

        $data['parameter'] = $deductionType;
        $data['title'] = "Deductions";
        $data['parent'] = "Statutory Deduction";

        return view('app.deduction_info', $data);
    }

    public function assign_deduction_individual(Request $request)
    {

        if ($request->method() == "POST") {

            $data = array(
                'empID' => $request->input('empID'),
                'deduction' => $request->input('deduction'),
            );

            $result = $this->flexperformance_model->assign_deduction($data);

            $deductionName = DB::table('deductions')->select('name')->where('id', $request->input('deduction'))->first();

            //  SysHelpers::FinancialLogs($request->input('empID'), 'Assigned ' . $deductionName->name, '0', $deductionName->amount / $deductionName->rate . ' ' . $deductionName->currency, 'Payroll Input');

            if ($result == true) {
                SysHelpers::AuditLog(1, "Assigned a Deduction to an Employee of ID =" . $request->input('empID') . "", $request);
                echo "<p class='alert alert-success text-center'>Added Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>";
            }
        }
    }

    public function assign_deduction_group(Request $request)
    {

        if ($request->method() == "POST") {

            $members = $this->flexperformance_model->get_deduction_members($request->input('deduction'), $request->input('group'));

            foreach ($members as $row) {
                $data = array(
                    'empID' => $row->empID,
                    'deduction' => $request->input('deduction'),
                    'group_name' => $request->input('group'),
                );

                $result = $this->flexperformance_model->assign_deduction($data);

                $deductionName = DB::table('deduction')->select('name')->where('id', $request->input('deduction'))->limit(1)->first();
                //SysHelpers::FinancialLogs($request->input('empID'), 'Assigned ' . $deductionName->name, '0', $deductionName->amount / $deductionName->rate . ' ' . $deductionName->currency, 'Payroll Input');

                // SysHelpers::FinancialLogs($row->empID, 'Assigned deduction', '0', $deductionName->name, 'Payroll Input');
            }
            if ($result == true) {
                // $this->flexperformance_model->audit_log("Assigned a Deduction to a Group of ID =" . $request->input('group') . "");
                echo "<p class='alert alert-success text-center'>Added Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>";
            }
        }
    }

    public function remove_individual_deduction(Request $request)
    {

        if ($request->method() == "POST" && !empty($request->input('option'))) {

            $arr = $request->input('option');

            $arrayString = implode(",", $arr);

            $deductionID = $request->input('deductionID');

            if (sizeof($arr) < 1) {

                echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select Atlest One Employee</p>";
            } else {

                foreach ($arr as $employee) {

                    $empID = $employee;

                    $result = $this->flexperformance_model->remove_individual_deduction($empID, $deductionID);

                    $deductionName = DB::table('deduction')->select('name')->where('id', $request->input('deductionID'))->limit(1)->first();

                    SysHelpers::FinancialLogs($request->input('empID'), $deductionName->name, number_format($deductionName->amount / $deductionName->rate, 2) . ' ' . $deductionName->currency, '0.00', 'Payroll Input');

                    //SysHelpers::FinancialLogs($empID, 'Removed from deduction', $deductionName->name, '0', 'Payroll Input');
                }

                if ($result == true) {
                    // $this->flexperformance_model->audit_log("Removed From Deduction an Employees of IDs =" . $arrayString . "");
                    echo "<p class='alert alert-success text-center'>Removed Successifully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>Not Removed, Try Again</p>";
                }
            }
        } else {
            echo "<p class='alert alert-warning text-center'>No Item Selected</p>";
        }
    }

    public function remove_group_deduction(Request $request)
    {

        if ($request->method() == "POST") {

            $arr = $request->input('option');

            $arrayString = implode(",", $arr);
            $deductionID = $request->input('deductionID');

            if (sizeof($arr) < 1) {
                echo "<p class='alert alert-warning text-center'>No Group Selected! Please Select Atlest One Employee</p>";
            } else {

                foreach ($arr as $group) {
                    $groupID = $group;

                    $result = $this->flexperformance_model->remove_group_deduction($groupID, $deductionID);

                    $deductionName = DB::table('deduction')->select('name')->where('id', $deductionID)->limit(1)->first();

                    SysHelpers::FinancialLogs($request->input('empID'), $deductionName->name, number_format($deductionName->amount / $deductionName->rate, 2) . ' ' . $deductionName->currency, '0.00', 'Payroll Input');

                    // SysHelpers::FinancialLogs($groupID, 'Removed Group from deduction', $deductionName->name, '0', 'Payroll Input');
                }

                if ($result == true) {
                    // $this->flexperformance_model->audit_log("Removed From Deduction Groups of IDs =" . $arrayString . "");
                    echo "<p class='alert alert-warning text-center'>Group Removed Successifully</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'Group NOT Removed, Try Again</p>";
                }
            }
        }
    }

    #####################DEDUCTIONS############################################

    #####################PAYE############################################

    public function addpaye(Request $request)
    {
        if ($request->method() == "POST") {
            $minimum = $request->input('minimum');
            $maximum = $request->input('maximum');
            $excess = $request->input('excess');
            if ($maximum > $minimum && $excess < $minimum) {
                $data = array(
                    'minimum' => $request->input('minimum'),
                    'maximum' => $request->input("maximum"),
                    'excess_added' => $request->input("excess"),
                    'rate' => 0.01 * ($request->input("rate")),
                );
                $result = $this->flexperformance_model->addpaye($data);
                if ($result) {
                    $response_array['status'] = "OK";
                    $response_array['title'] = "SUCCESS";
                    $response_array['message'] = "<p class='alert alert-success text-center'>Branch Added Successifully</p>";
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                } else {
                    $response_array['status'] = "ERR";
                    $response_array['title'] = "FAILED";
                    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Branch not Added, Please try again</p>";
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }
            } else {
                $response_array['status'] = "ERR";
                $response_array['title'] = "FAILED";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Incorrect Values</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    public function deletepaye(Request $request)
    {
        $id = $request->input('id');
        $this->db->where('id', $id);
        $this->db->delete('PAYE');
        // die;
        session('note', "<p class='alert alert-warning text-center'>Record Deleted Successifully</p>");
        return redirect('/flex/paye');
    }

    public function paye_info($id)
    {
        //$id = $request->input('id');

        $data['paye'] = $this->flexperformance_model->getpayebyid($id);
        $data['title'] = "PAYE";
        return view('app.updatepaye', $data);
    }

    public function updatepaye(Request $request)
    {
        if ($request->method() == "POST") {
            $payeID = $request->input('payeID');
            $minimum = $request->input('minimum');
            $maximum = $request->input('maximum');
            $excess = $request->input('excess');
            if ($maximum > $minimum && $excess < $minimum && $payeID != '') {
                $updates = array(
                    'minimum' => $request->input('minimum'),
                    'maximum' => $request->input("maximum"),
                    'excess_added' => $request->input("excess"),
                    'rate' => 0.01 * ($request->input("rate")),
                );
                $result = $this->flexperformance_model->updatepaye($updates, $payeID);
                if ($result) {
                    // $this->flexperformance_model->audit_log("Updated PAYE Brackets");
                    $response_array['status'] = "OK";
                    $response_array['title'] = "SUCCESS";
                    $response_array['message'] = "<p class='alert alert-success text-center'>Updated Successifully</p>";
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                } else {
                    $response_array['status'] = "ERR";
                    $response_array['title'] = "FAILED";
                    $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Not Updated Please try again</p>";
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }
            } else {
                $response_array['status'] = "ERR";
                $response_array['title'] = "FAILED";
                $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Incorrect Values</p>";
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }
    public function updateOvertimeAllowance(Request $request)
    {
        if ($request->method() == "POST" && $request->input('allowanceID') != '') {
            $allowanceID = $request->input('allowanceID');
            $updates = array(
                'name' => $request->input('name'),
                'rate_employee' => $request->input('rate_employee') / 100,
                'rate_employer' => $request->input('rate_employer') / 100,
            );
            $result = $this->flexperformance_model->updateCommonDeductions($updates, $allowanceID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Updation Failed, Please Try Again</p>";
            }
        }
    }

    public function updateCommonDeductions(Request $request)
    {
        // dd('update');

        if (isset($request->deductionID)) {
            $deductionID = $request->input('deductionID');
            $updates = array(
                'name' => $request->input('name'),
                'rate_employee' => $request->input('rate_employee') / 100,
                'rate_employer' => $request->input('rate_employer') / 100,
            );
            $result = $this->flexperformance_model->updateCommonDeductions($updates, $deductionID);
            if ($result == true) {
                // $this->flexperformance_model->audit_log("Updated Deductions with ID = " . $deductionID . "");
                echo "<p class='alert alert-success text-center'>Updated Successifully</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Updation Failed, Please Try Again</p>";
            }
        }
    }

    public function common_deductions_info($id)
    {
        // dd("what");

        // $id = $request->input('id');
        $data['deductions'] = $this->flexperformance_model->getcommon_deduction($id);
        $data['title'] = "Deductions";
        $data['parent'] = "Statutory Deduction";
        $data['child'] = "Update";
        return view('app.updatededuction', $data);
    }

    public function updatePensionName(Request $request)
    {
        $fundID = $request->input('fundID');
        if ($request->method() == "POST" && $fundID != '') {
            $updates = array(
                'name' => $request->input('name'),
            );
            $result = $this->flexperformance_model->updatePension($updates, $fundID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updatePercentEmployee(Request $request)
    {
        $fundID = $request->input('fundID');
        if ($request->method() == "POST" && $fundID != '') {
            $updates = array(
                'amount_employee' => $request->input('employee_amount') / 100,
            );
            $result = $this->flexperformance_model->updatePension($updates, $fundID);
            if ($result == true) {
                // $this->flexperformance_model->audit_log("Updated Pension with ID =" . $fundID . " To Employee Value of " . $request->input('employee_amount') . " ");
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updatePercentEmployer(Request $request)
    {
        $fundID = $request->input('fundID');
        if ($request->method() == "POST" && $fundID != '') {
            $updates = array(
                'amount_employer' => $request->input('employer_amount') / 100,
            );
            $result = $this->flexperformance_model->updatePension($updates, $fundID);
            if ($result == true) {
                // $this->flexperformance_model->audit_log("Updated Pension with ID =" . $fundID . " To Employer Value of " . $request->input('employee_amount') . " ");
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updatePensionPolicy(Request $request)
    {
        $fundID = $request->input('fundID');
        if ($request->method() == "POST" && $fundID != '') {
            $updates = array(
                'deduction_from' => $request->input('policy'),
            );
            $result = $this->flexperformance_model->updatePension($updates, $fundID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateDeductionName(Request $request)
    {
        $deductionID = $request->input('deductionID');
        if ($request->method() == "POST" && $deductionID != '') {
            $updates = array(
                'name' => $request->input('name'),
            );
            $result = $this->flexperformance_model->updateDeductions($updates, $deductionID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateDeductionAmount(Request $request)
    {
        $deductionID = $request->input('deductionID');
        if ($request->method() == "POST" && $deductionID != '') {
            $updates = array(
                'amount' => $request->input('amount'),
            );
            $result = $this->flexperformance_model->updateDeductions($updates, $deductionID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateDeductionPercent(Request $request)
    {
        $deductionID = $request->input('deductionID');
        if ($request->method() == "POST" && $deductionID != '') {
            $updates = array(
                'percent' => $request->input('percent') / 100,
            );
            $result = $this->flexperformance_model->updateDeductions($updates, $deductionID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateDeductionPolicy(Request $request)
    {
        $deductionID = $request->input('deductionID');
        if ($request->method() == "POST" && $deductionID != '') {
            $updates = array(
                'mode' => $request->input('policy'),
            );
            $result = $this->flexperformance_model->updateDeductions($updates, $deductionID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    //UPDATE MEALS DEDUCTION

    public function updateMealsName(Request $request)
    {
        $deductionID = $request->input('deductionID');
        if ($request->method() == "POST" && $deductionID != '') {
            $updates = array(
                'name' => $request->input('name'),
            );
            $result = $this->flexperformance_model->updateMeals($updates, $deductionID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateMealsMargin(Request $request)
    {
        $deductionID = $request->input('deductionID');
        if ($request->method() == "POST" && $deductionID != '') {
            $updates = array(
                'minimum_gross' => $request->input('margin'),
            );
            $result = $this->flexperformance_model->updateMeals($updates, $deductionID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateMealsLowerAmount(Request $request)
    {
        $deductionID = $request->input('deductionID');
        if ($request->method() == "POST" && $deductionID != '') {
            $updates = array(
                'minimum_payment' => $request->input('amount_lower'),
            );
            $result = $this->flexperformance_model->updateMeals($updates, $deductionID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateMealsUpperAmount(Request $request)
    {
        $deductionID = $request->input('deductionID');
        if ($request->method() == "POST" && $deductionID != '') {
            $updates = array(
                'maximum_payment' => $request->input('amount_upper'),
            );
            $result = $this->flexperformance_model->updateMeals($updates, $deductionID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    #####################PAYE############################################

    ##################################ALLOWANCE##########################

    public function allowance(Request $request)
    {

        $this->authenticateUser('add-payroll');

        $data['allowance'] = $this->flexperformance_model->allowance();
        $data['allowanceCategories'] = $this->flexperformance_model->allowance_category();
        $data['meals'] = $this->flexperformance_model->meals_deduction();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['parent'] = "Settings";
        $data['child'] = "Allowance";
        $data['title'] = "Allowance";

        return view('allowance.allowance', $data);
    }

    public function allowance_overtime(Request $request)
    {

        // if (session('mng_paym') || session('recom_paym') || session('appr_paym')) {

        $this->authenticateUser('add-payroll');

        $data['overtimess'] = $this->flexperformance_model->overtime_allowances();
        $data['meals'] = $this->flexperformance_model->meals_deduction();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['parent'] = "Settings";
        $data['child'] = "Overtime";
        $data['title'] = "Overtime";

        return view('overtime.allowance_overtime', $data);
        // } else {
        //     echo "Unauthorized Access";
        // }
    }

    public function statutory_deductions(Request $request)
    {

        $this->authenticateUser('add-payroll');

        // if (session('mng_paym') || session('recom_paym') || session('appr_paym')) {
        $data['allowance'] = $this->flexperformance_model->allowance();
        $data['overtimes'] = $this->flexperformance_model->overtime_allowances();
        $data['deduction'] = $this->flexperformance_model->deductions();
        $data['pension'] = $this->flexperformance_model->pension_fund();
        $data['meals'] = $this->flexperformance_model->meals_deduction();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['deduction'] = $this->flexperformance_model->deduction();

        $data['paye'] = $this->flexperformance_model->paye();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();

        $data['parent'] = "Settings";
        $data['child'] = "Statutory Deductions";

        return view('app.statutory_deduction', $data);
        // } else {
        //     echo "Unauthorized Access";
        // }
    }
    public function allowance_category(Request $request)
    {

        $this->authenticateUser('add-payroll');
        $data['allowanceCategory'] = $this->flexperformance_model->allowance_category();
        $data['meals'] = $this->flexperformance_model->meals_deduction();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['parent'] = "Settings";
        $data['title'] = "Allowance Category";

        return view('allowance.allowance_category', $data);
    }

    public function non_statutory_deductions(Request $request)
    {

        $this->authenticateUser('add-payroll');

        $data['allowance'] = $this->flexperformance_model->allowance();
        $data['currencies'] = $this->flexperformance_model->get_currencies();
        $data['overtimes'] = $this->flexperformance_model->overtime_allowances();
        $data['deduction'] = $this->flexperformance_model->deductions();
        $data['pension'] = $this->flexperformance_model->pension_fund();
        $data['meals'] = $this->flexperformance_model->meals_deduction();
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();

        $data['title'] = "Non-Statutory Deductions";

        return view('app.non_statutory_deductions', $data);
    }

    public function addAllowance(Request $request)
    {
        $policy = $request->policy;

        if ($policy == 1) {
            $amount = $request->amount;
            $percent = 0;
        } else {
            $amount = 0;
            $percent = 0.01 * ($request->rate);
        }

        $data = array(
            'name' => $request->name,
            'amount' => $amount,
            'mode' => $request->policy,
            'taxable' => $request->taxable,
            'pensionable' => $request->pensionable,
            'Isrecursive' => $request->Isrecursive,
            'Isbik' => $request->Isbik,
            'allowance_category_id' => $request->allowanceCategory,
            'state' => 1,
            'percent' => $percent,
        );

        $result = $this->flexperformance_model->addAllowance($data);

        if ($result == true) {
            // $this->flexperformance_model->audit_log("Created New Allowance ");
            return back()->with('success', 'Saved');
            // echo "<p class='alert alert-success text-center'>Allowance Registered Successifully</p>";
        } else {
            echo "<p class='alert alert-warning text-center'>Allowance Registration FAILED, Please Try Again</p>";
        }
        return back()->with('success', 'Saved');
    }
    public function addAllowanceCategory(Request $request)
    {
        $data = array(
            'name' => $request->name,
        );

        $result = $this->flexperformance_model->addAllowanceCategory($data);

        if ($result == true) {
            // $this->flexperformance_model->audit_log("Created New Allowance ");
            return back()->with('success', 'Saved');
            // echo "<p class='alert alert-success text-center'>Allowance Registered Successifully</p>";
        } else {
            echo "<p class='alert alert-warning text-center'>Allowance Category Registration FAILED, Please Try Again</p>";
        }
        return back()->with('success', 'Saved');
    }

    public function addOvertimeCategory(Request $request)
    {

        if ($request->method() == "POST") {
            $data = array(
                'name' => $request->input('name'),
                'day_percent' => ($request->input('day_percent')),
                'night_percent' => ($request->input('night_percent')),
            );
            $result = $this->flexperformance_model->addOvertimeCategory($data);
            if ($result == true) {
                // $this->flexperformance_model->audit_log("Created New Overtime ");
                echo "<p class='alert alert-success text-center'>Overtime Registered Successifully</p>";
            } else {
                echo "<p class='alert alert-warning text-center'>Overtime Registration FAILED, Please Try Again</p>";
            }
        }
    }

    public function addDeduction(Request $request)
    {
        //dd($request->all());
        $name = $request->input('name');
        $code = $request->input('code');
        $amount = $request->input('amount');
        $percent = $request->input('rate') / 100;
        $apply_to = $request->input('apply_to');
        $mode = $request->input('policy');
        //$state = $request->input('state');
        $state = 1;
        $rate = $this->flexperformance_model->get_rate($request->currency);

        // FIXME I have commented column currency and rate but it need confirmation if it should available
        // FIXME data from code is missing for it to be able to save in the database

        $data = array(
            'name' => $name,
            'code' => $code,
            'amount' => $amount * $rate,
            'percent' => $percent,
            'apply_to' => $apply_to,
            'mode' => $mode,
            'state' => $state,
            // 'currency' => $request->currency,
            // 'rate' => $rate,
        );

        DB::table('deductions')->insert($data);

        echo "Record inserted successfully.<br/>";

        return redirect('flex/non_statutory_deductions');
    }
    //     public function addDeduction(Request $request)   {

    //       if ($request->method() == "POST") {
    //         $policy = $request->input('policy');
    //         if($policy==1){
    //           $amount = $request->input('amount');
    //           $percent = 0;
    //         } else{
    //           $amount = 0;
    //           $percent = 0.01*($request->input('rate'));
    //         }
    //         $data = array(
    //             'name' =>trim($request->input('name')),
    //             'amount' =>$amount,
    //             'mode' =>$request->input('policy'),
    //             'state' =>1,
    //             'apply_to' =>2,
    //             'percent' =>$percent
    //             );

    //           $result = $this->flexperformance_model->addDeduction($data);
    //           if($result==true){
    //              $this->flexperformance_model->audit_log("Created New Deduction ");
    //               echo "<p class='alert alert-success text-center'>Deduction Registered Successifully</p>";
    //           } else {
    //                echo "<p class='alert alert-warning text-center'>Deduction Registration FAILED, Please Try Again</p>";
    //           }
    //       }

    //    }

    public function assign_allowance_individual(Request $request)
    {
        $method = $request->method();

        if ($method == "POST") {

            $rate = $this->flexperformance_model->get_rate($request->currency);

            $data = array(
                'empID' => $request->input('empID'),
                'allowance' => $request->input('allowance'),
                'amount' => $request->input('amount') * $rate,
                'mode' => $request->input('mode'),
                'percent' => $request->input('percent') / 100,
                'currency' => $request->currency,
                'rate' => $rate,
            );

            $result = $this->flexperformance_model->assign_allowance($data);

            $allowanceName = DB::table('allowances')->select('name')->where('id', $request->input('allowance'))->limit(1)->first();

            SysHelpers::FinancialLogs($data['empID'], 'Assign ' . $allowanceName->name, '0.00', ($data['amount'] != 0) ? $data['amount'] . ' ' . $data['currency'] : $data['percent'] . '%',  'Payroll Input');

            if ($result == true) {
                // $this->flexperformance_model->audit_log("Assigned an allowance to Employee with Id = " . $request->input('empID') . " ");
                echo "<p class='alert alert-success text-center'>Added Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>";
            }
        }
    }

    public function addPrevMonthSalaryArrears($date)
    {

        // dd($date);
        // $date="20-11-2023";

        $previous_payroll_month_raw = date('Y-m', strtotime(date('d-m-Y', strtotime($date . "-1 month"))));

        // dd($previous_payroll_month_raw);

        $previous_payroll_month = $this->reports_model->prevPayrollMonth($previous_payroll_month_raw);

        $previous_payroll_month = date('Y-m-d', strtotime($previous_payroll_month));

        $last_day_of_month = date('Y-m-t', strtotime($previous_payroll_month));

        $days = intval(date('t', strtotime($previous_payroll_month)));

        $startDate = $previous_payroll_month;
        $endDate = $last_day_of_month;
        $daysInMonth = Carbon::parse($endDate)->daysInMonth; // Get the number of days in the month

        $employees = Employee::select([
            'emp_id',
            DB::raw("({$daysInMonth} - DAY(hire_date) + 1) * salary / 30 as partialpayment"),

        ])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where('hire_date', '>', $startDate,)
                    ->where('hire_date', '<=', $endDate);
            })
            ->get();

        foreach ($employees as $employee) {

            // dd($employee->partialpayment);
            $data = array(
                "name" => "arrears",
                "amount" => $employee->partialpayment, //The amount
                "mode" => "1", //1 fixed value
                "type" => "0",
                "taxable" => "YES",
                "pensionable" => "YES",
                "Isrecursive" => "NO",
                "Isbik" => "NO",
                "state" => 1, //1 active state
                "percent" => 0,
            );

            $result = DB::table('allowances')->insertGetId($data);

            // $result = $this->flexperformance_model->addAllowance($data);

            $data = array(
                'empID' => $employee->emp_id,
                'allowance' => $result,
                'amount' => $employee->partialpayment,
                'mode' => "1", //fixed
                'percent' => "0", //percent
                'currency' => "TZS",
                'rate' => 1,
            );

            $result = $this->flexperformance_model->assign_allowance($data);
        }
    }

    public function submitInputs(Request $request)
    {
        $this->authenticateUser('edit-payroll');

        $date = date_create_from_format('Y-m-d', $request->date);

        $data['pending_payroll'] = 0;

        if ($date) {

            $date = $date->format('m/d/Y');

            $date = date("Y-m-d", strtotime($date));

            $this->addPrevMonthSalaryArrears($date);

            if ($request->method() == 'POST') {
                $month = $this->payroll_model->checkPayrollMonth($date);
                $submission = $this->payroll_model->checkInputMonth($date);

                if ($month < 1) {
                    if ($submission < 1) {
                        $allowances = $this->payroll_model->getAssignedAllowance();
                        foreach ($allowances as $row) {
                            if ($row->state == 1) {
                                SysHelpers::FinancialLogs($row->empID, $row->name, '0', ($row->amount != 0) ? number_format($row->amount, 2) . ' ' . $row->currency : $row->percent . '%', 'Payroll Input', $date);
                            }
                        }
                        $deductions = $this->payroll_model->getAssignedDeduction();
                        foreach ($deductions as $row) {
                            SysHelpers::FinancialLogs($row->empID, $row->name, '0', ($row->amount != 0) ? number_format($row->amount, 2) . ' ' . $row->currency : $row->percent . '%', 'Payroll Input', $date);
                        }
                        InputSubmission::create(['empID' => auth()->user()->emp_id, 'date' => $date]);
                        echo "<p class='alert alert-success text-center'>Inputs  submitted Successfuly</p>";
                    } else {
                        echo "<p class='alert alert-danger text-center'>Inputs for this payroll month already submitted</p>";
                    }
                } else {
                    echo "<p class='alert alert-danger text-center'>You cant submit inputs to previous payroll Month</p>";
                }
            }
        } else {

            return view('payroll.submit_inputs', $data);
        }
    }

    public function assign_allowance_group(Request $request)
    {
        $method = $request->method();

        $rate = $this->flexperformance_model->get_rate($request->currency);

        if ($method == "POST") {

            $members = $this->flexperformance_model->get_allowance_members($request->input('allowance'), $request->input('group'));

            foreach ($members as $row) {
                $data = array(
                    'empID' => $row->empID,
                    'allowance' => $request->input('allowance'),
                    'group_name' => $request->input('group'),
                    'amount' => $request->input('amount') * $rate,
                    'mode' => $request->input('mode'),
                    'percent' => $request->input('percent') / 100,
                    'currency' => $request->currency,
                    'rate' => $rate,
                );

                $result = $this->flexperformance_model->assign_allowance($data);

                $allowanceName = DB::table('allowances')->select('name')->where('id', $request->input('allowance'))->limit(1)->first();

                //SysHelpers::FinancialLogs($row->empID, 'Assign ' . $allowanceName->name, '0', ($data['amount'] != 0) ? $data['amount'] . ' ' . $data['currency'] : $data['percent'] . '%',  'Payroll Input');
            }

            if ($result == true) {
                // $this->flexperformance_model->audit_log("Assigned an allowance to Group with Id = " . $request->input('group') . " ");
                echo "<p class='alert alert-success text-center'>Added Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>";
            }
        }
    }

    public function remove_individual_from_allowance(Request $request)
    {

        $method = $request->method();

        if ($method == "POST") {

            $arr = $request->input('option');
            $allowanceID = $request->input('allowanceID');

            if (sizeof($arr) < 1) {
                echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select Atlest One Employee</p>";
            } else {

                foreach ($arr as $employee) {
                    $empID = $employee;

                    $allowanceName = DB::table('allowances')->select('name')->where('id', $allowanceID)->limit(1)->first();

                    $amount = $this->flexperformance_model->get_individual_from_allowance($empID, $allowanceID);

                    // SysHelpers::FinancialLogs($row->empID, 'Removed from '.$allowanceName->name, '0', ($data['amount'] != 0)? $data['amount'].' '.$data['currency'] : $data['percent'].'%',  'Payroll Input');

                    SysHelpers::FinancialLogs($empID, $allowanceName->name, $amount->percent != 0 ? ($amount->percent * 100) . '%' : number_format($amount->amount, 2) . ' ' . $amount->currency, '0.00', 'Payroll Input');

                    $result = $this->flexperformance_model->remove_individual_from_allowance($empID, $allowanceID);
                }
                if ($result == true) {
                    //  $this->flexperformance_model->audit_log("Removed Employees of IDs = " . implode(',', $arr) . " From an allowance  with Id = " . $allowanceID . " ");
                    echo "<p class='alert alert-success text-center'>Added Successifully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>";
                }
            }
        }
    }

    public function remove_group_from_allowance(Request $request)
    {

        $method = $request->method();

        if ($method == "POST") {

            $arr = $request->input('option');
            $allowanceID = $request->input('allowanceID');
            if (sizeof($arr) < 1) {
                echo "<p class='alert alert-warning text-center'>No Group Selected! Please Select Atlest One Employee</p>";
            } else {

                foreach ($arr as $group) {
                    $groupID = $group;
                    $result = $this->flexperformance_model->remove_group_from_allowance($groupID, $allowanceID);
                }
                if ($result == true) {
                    // $this->flexperformance_model->audit_log("Removed Group of ID = " . implode(',', $arr) . " From Alowance with Id = " . $allowanceID . " ");
                    echo "<p class='alert alert-warning text-center'>Group Removed </p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>";
                }
            }
        }
    }

    public function allowance_info($id)
    {
        $id = base64_decode($id);

        $data['title'] = 'Package';
        $data['currencies'] = $this->flexperformance_model->get_currencies();
        $data['allowance'] = $this->flexperformance_model->getallowancebyid($id);
        $data['group'] = $this->flexperformance_model->customgroup($id);
        $data['employeein'] = $this->flexperformance_model->get_individual_employee($id);
        $data['membersCount'] = $this->flexperformance_model->allowance_membersCount($id);
        $data['groupin'] = $this->flexperformance_model->get_allowance_group_in($id);
        $data['employee'] = $this->flexperformance_model->employee_allowance($id);
        $data['allowanceCategories'] = $this->flexperformance_model->allowance_category();
        $data['allowanceID'] = $id;
        $data['title'] = "Allowances";
        $data['parent'] = "Allowance";

        // dd($data['allowance']);

        return view('allowance.allowance_info', $data);
    }

    public function overtime_category_info($id)
    {
        $id = base64_decode($id);
        $data['title'] = 'Overtime Category';
        $data['category'] = $this->flexperformance_model->OvertimeCategoryInfo($id);
        return view('app.overtime_category_info', $data);
    }
    public function allowance_category_info($id)
    {
        $id = base64_decode($id);
        $data['title'] = 'Allowance Category';
        $data['category'] = $this->flexperformance_model->AllowanceCategoryInfo($id);
        return view('allowance.allowance_category_info', $data);
    }

    public function deleteAllowance($id, Request $request)
    {
        $ID = $id;
        if ($ID != '') {
            $updates = array(
                'state' => 0,
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                $json_array['status'] = "OK";
                $json_array['message'] = "<p class='alert alert-success text-center'>Allowance Deleted!</p>";

                echo "";
            } else {

                $json_array['status'] = "ERR";
                $json_array['message'] = "<p class='alert alert-danger text-center'>Deletion Failed</p>";
            }
            header("Content-type: application/json");
            echo json_encode($json_array);
        }
    }

    public function deleteAllowanceCategory($id, Request $request)
    {
        $result = $this->flexperformance_model->deleteAllowanceCategory($id);

        if ($result == true) {
            echo "<p class='alert alert-warning text-center'>Allowance Category DELETED Successifully</p>";
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED to DELETE, Please Try Again!</p>";
        }
    }

    public function activateAllowance($id, Request $request)
    {
        $ID = $id;
        if ($ID != '') {
            $updates = array(
                'state' => 1,
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                $json_array['status'] = "OK";
                $json_array['message'] = "<p class='alert alert-success text-center'>Allowance Activated</p>";

                echo "";
            } else {

                $json_array['status'] = "ERR";
                $json_array['message'] = "<p class='alert alert-danger text-center'>Activation Failed</p>";
            }
            header("Content-type: application/json");
            echo json_encode($json_array);
        }
    }

    public function updateAllowanceName(Request $request)
    {
        $ID = $request->input('allowanceID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'name' => $request->input('name'),
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateAllowanceTaxable(Request $request)
    {
        $ID = $request->input('allowanceID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'taxable' => $request->input('taxable'),
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateAllowancepensionable(Request $request)
    {
        $ID = $request->input('allowanceID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'pensionable' => $request->input('pensionable'),
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateRecursive(Request $request)
    {
        $ID = $request->input('allowanceID');
        if ($request->method() == "POST" && $ID != '') {

            $updates = array(
                'Isrecursive' => $request->input('Isrecursive'),
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateBik(Request $request)
    {
        $ID = $request->input('allowanceID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'Isbik' => $request->input('Isbik'),
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }
    public function updatecategory(Request $request)
    {
        $ID = $request->input('allowanceID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'allowance_category_id' => $request->input('allowance_category_id'),
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateOvertimeName(Request $request)
    {
        $ID = $request->input('categoryID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'name' => $request->input('name'),
            );
            $result = $this->flexperformance_model->updateOvertimeCategory($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }
    public function updateAllowanceCategory(Request $request)
    {
        $ID = $request->input('categoryID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'name' => $request->input('name'),
            );
            $result = $this->flexperformance_model->updateAllowaceCategory($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }
    public function updateOvertimeRateDay(Request $request)
    {
        $ID = $request->input('categoryID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'day_percent' => ($request->input('day_percent') / 100),
            );
            $result = $this->flexperformance_model->updateOvertimeCategory($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }
    public function updateOvertimeRateNight(Request $request)
    {
        $ID = $request->input('categoryID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'night_percent' => ($request->input('night_percent') / 100),
            );
            $result = $this->flexperformance_model->updateOvertimeCategory($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateAllowanceAmount(Request $request)
    {
        $ID = $request->input('allowanceID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'amount' => $request->input('amount'),
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Updation Failed</p>";
            }
        }
    }

    public function updateAllowancePercent(Request $request)
    {
        $ID = $request->input('allowanceID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'percent' => $request->input('percent') / 100,
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Updation Failed</p>";
            }
        }
    }

    public function updateAllowanceApplyTo(Request $request)
    {
        $ID = $request->input('allowanceID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'apply_to' => $request->input('apply_to'),
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Updation Failed</p>";
            }
        }
    }

    public function updateAllowancePolicy(Request $request)
    {
        $ID = $request->input('allowanceID');
        if ($request->method() == "POST" && $ID != '') {
            $updates = array(
                'mode' => $request->input('policy'),
            );
            $result = $this->flexperformance_model->updateAllowance($updates, $ID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Updated Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Updation Failed</p>";
            }
        }
    }

    //###########BONUS################# updateAllowanceName
    public function addToBonusByEmpGroup(Request $request)
    {
    }

    public function addToBonus(Request $request)
    {
        $empID = $request->input('employee');
        $init_author = auth()->user()->emp_id;
        $amount = $request->input('amount');
        $days = $request->input('days');
        $percent = $request->input('percent');
        $methode = $request->method();
        if ($methode == "POST" && $empID != '' && $amount != '' && $days == '' && $percent != '') {

            $data = array(
                'empID' => $request->input('employee'),
                'amount' => $amount * $percent / 100,
                'name' => $request->input('bonus'),
                'init_author' => $init_author,
                'appr_author' => "",
                'state' => 0,
            );
            $result = $this->flexperformance_model->addToBonus($data);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Added To Bonus Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Not Added, Some Erors Occured, Retry</p>";
            }
        }
        if ($methode == "POST" && $empID != '' && $amount != '' && $days != '' && $percent == '') {
            $data = array(
                'empID' => $request->input('employee'),
                'amount' => $amount * $days / 30,
                'name' => $request->input('bonus'),
                'init_author' => $init_author,
                'appr_author' => "",
                'state' => 0,
            );
            $result = $this->flexperformance_model->addToBonus($data);
            if ($result == true) {

                echo "<p class='alert alert-success text-center'>Added To Bonus Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Not Added, Some Erors Occured, Retry</p>";
            }
        }
        if ($methode == "POST" && $empID != '' && $amount != '' && $days == '' && $percent == '') {
            $data = array(
                'empID' => $request->input('employee'),
                'amount' => $amount,
                'name' => $request->input('bonus'),
                'init_author' => $init_author,
                'appr_author' => "",
                'state' => 0,
            );
            $result = $this->flexperformance_model->addToBonus($data);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Added To Bonus Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Not Added, Some Erors Occured, Retry</p>";
            }
        }
    }
    public function addBonusTag(Request $request)
    {
        $name = $request->input('name');
        $methode = $request->method();
        if ($methode = "POST" && $name != '') {
            $data = array(
                'name' => $request->input('name'),
            );
            $result = $this->flexperformance_model->addBonusTag($data);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Added To Bonus Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Not Added, Some Erors Occured, Retry</p>";
            }
        }
    }

    public function cancelBonus(Request $request)
    {
        $bonusID = $this->uri->segment(3);
        $data = array(
            'state' => 0,
            'appr_author' => null,
        );
        $result = $this->flexperformance_model->updateBonus($data, $bonusID);
        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-warning text-center'>Bonus Cancelled!</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "SUCCESS";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Failed: Bonus Not Cancelled</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function confirmBonus($id)
    {
        $bonusID = $id;
        $appr_author = auth()->user()->emp_id;
        $data = array(
            'state' => 1,
            'appr_author' => $appr_author,
        );
        $result = $this->flexperformance_model->updateBonus($data, $bonusID);
        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Bonus Confirmed Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Failed: Bonus Not Confirmed</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function recommendBonus($id)
    {
        $bonusID = $id;
        $appr_author = auth()->user()->emp_id;
        $data = array(
            'state' => 2,
            'recom_author' => $appr_author,
        );
        $result = $this->flexperformance_model->updateBonus($data, $bonusID);
        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Bonus Confirmed Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Failed: Bonus Not Confirmed</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function deleteBonus($id)
    {
        $bonusID = $id;
        $result = $this->flexperformance_model->deleteBonus($bonusID);

        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Bonus Deleted Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-danger text-center'>Failed: Bonus Not Deleted</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }
    ###################################END ALLOWANCE#######################

    #####################PRIVELEGES######################################

    public function financial_group(Request $request)
    {

        $this->authenticateUser('add-payroll');
        // if (session('mng_roles_grp')) {
        $request_type = $request->method();

        if ($request_type == "POST") {

            $data = array(
                'name' => $request->input('name'),
                'grouped_by' => $request->input('grouped_by'),
                'type' => 1,
                'created_by' => auth()->user()->emp_id,
            );

            $this->flexperformance_model->addgroup($data);

            session('notegroup', "<p class='alert alert-success text-center'>Group Added Successifully</p>");

            return redirect('/flex/financial_group');
        } else {
            // $id =auth()->user()->emp_id;
            $data['role'] = $this->flexperformance_model->allrole();
            $data['financialgroups'] = $this->flexperformance_model->finencialgroups();
            $data['rolesgroups'] = $this->flexperformance_model->rolesgroups();
            $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
            $data['title'] = "Financial Groups";
            $data['parent'] = "Settings";
            $data['child'] = "Financial Settings";
            return view('app.financial_group', $data);
        }
    }

    public function role(Request $request)
    {
        $this->authenticateUser('add-payroll');

        if ($request->type == "addrole") {
            $data = array(
                'name' => $request->input('name'),
                'created_by' => auth()->user()->emp_id,
            );

            $result = $this->flexperformance_model->addrole($data);
            if ($result == true) {
                // $this->flexperformance_model->audit_log("Created New Role with empty permission set");
                session('note', "<p class='alert alert-success text-center'>Role Added Successifully</p>");
                return redirect('/flex/role');
            } else {
                echo "<p class='alert alert-danger text-center'>Department Registration has FAILED, Contact Your Admin</p>";
            }
        } elseif ($request->type == "addgroup") {

            $data = array(
                'name' => $request->input('name'),
                //'type' => $request->input('type'),
                'type' => 2,
                'created_by' => auth()->user()->emp_id,
            );

            $this->flexperformance_model->addgroup($data);

            session('notegroup', "<p class='alert alert-success text-center'>Group Added Successifully</p>");
            //$this->department();
            return redirect('/flex/role');
        } else {
            // $id =auth()->user()->emp_id;
            $data['role'] = $this->flexperformance_model->allrole();
            $data['financialgroups'] = $this->flexperformance_model->finencialgroups();
            $data['rolesgroups'] = $this->flexperformance_model->rolesgroups();
            $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
            $data['title'] = "Roles and Groups";
            return view('app.role', $data);
        }
    }

    public function financial_groups_byRole_details($id)
    {
        $id = base64_decode($id);

        $data['members'] = $this->flexperformance_model->roles_byid($id);
        $data['nonmembers'] = $this->flexperformance_model->nonmembers_roles_byid($id);
        $data['headcounts'] = $this->flexperformance_model->memberscount($id);
        $data['groupInfo'] = $this->flexperformance_model->group_byid($id);
        $data['title'] = "Groups";
        return view('app.groups_by_role', $data);
    }

    public function financial_groups_details($id)
    {
        $id = base64_decode($id);

        $data['members'] = $this->flexperformance_model->members_byid($id);
        $data['nonmembers'] = $this->flexperformance_model->nonmembers_byid($id);
        $data['headcounts'] = $this->flexperformance_model->memberscount($id);
        $data['groupInfo'] = $this->flexperformance_model->group_byid($id);
        $data['title'] = "Groups";
        $data['parent'] = "Financial Setting";
        $data['child'] = "Groups";

        return view('app.financial_groups_details', $data);
    }

    public function groups(Request $request)
    {
        $this->authenticateUser('add-payroll');
        $id = base64_decode($request->id);

        $data['members'] = $this->flexperformance_model->members_byid($id);
        $data['nonmembers'] = $this->flexperformance_model->nonmembers_byid($id);
        $data['headcounts'] = $this->flexperformance_model->memberscount($id);
        $data['groupInfo'] = $this->flexperformance_model->group_byid($id);
        $data['title'] = "Groups";
        return view('app.groups', $data);
    }

    //
    public function removeEmployeeByRoleFromGroup(Request $request)
    {

        $this->authenticateUser('add-payroll');

        $method = $request->method();

        if ($method == "POST") {

            $arr = $request->input('option');
            $groupID = $request->input('groupID');
            if (sizeof($arr) < 1) {
                echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select At Least One Employee</p>";
            } else {

                foreach ($arr as $composite) {
                    $values = explode('|', $composite);
                    $refID = $values[0];
                    $RoleID = $values[1];

                    $emp_ids = $this->flexperformance_model->getEmpByGroupID($groupID, $RoleID);

                    if (!empty($emp_ids)) {
                        //  dd($emp_ids);
                        foreach ($emp_ids as $ids) {
                            $empID = $ids->empID;

                            $result = $this->flexperformance_model->removeEmployeeByROleFromGroup($empID, $groupID);
                        }
                    }

                    $result = $this->flexperformance_model->delete_role_group($RoleID, $groupID);
                }
                if ($result == true) {
                    echo "<p class='alert alert-success text-center'>Removed Successifully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>Not Removed, Try Again</p>";
                }
            }
        }
    }
    public function removeEmployeeFromGroup(Request $request)
    {

        $this->authenticateUser('add-payroll');

        $method = $request->method();

        if ($method == "POST") {

            $arr = explode(',', $request->input('option'));

            $groupID = $request->input('groupID');

            $groupName = $request->input('groupName');

            if (sizeof($arr) < 1) {
                echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select At Least One Employee</p>";
            } else {

                foreach ($arr as $composite) {
                    $values = explode('|', $composite);
                    $refID = $values[0];
                    $empID = $values[1];

                    SysHelpers::FinancialLogs($empID, 'Financial group', $groupName, '-', 'Payroll Input');

                    $result = $this->flexperformance_model->removeEmployeeFromGroup($refID, $empID, $groupID);
                }
                if ($result == true) {
                    echo "<p class='alert alert-success text-center'>Removed Successifully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>Not Removed, Try Again</p>";
                }
            }
        }
    }

    public function removeEmployeeFromRole(Request $request)
    {

        $this->authenticateUser('add-payroll');

        $method = $request->method();

        if ($method == "POST") {

            $arr = $request->input('option');
            if ($arr == "" || $arr == "[]") {
                echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select At Least One Employee</p>";
            } else {

                foreach ($arr as $composite) {
                    $values = explode('|', $composite);
                    $refID = $values[0];
                    $empID = $values[1];

                    //get the group if exists
                    $group_id = $this->flexperformance_model->employeeFromGroup($refID);
                    if ($group_id) {
                        $this->flexperformance_model->deleteEmployeeFromGroup($group_id, $empID);
                    }

                    $result = $this->flexperformance_model->removeEmployeeFromRole($refID, $empID);
                }
                if ($result == true) {
                    echo "<p class='alert alert-success text-center'>Removed Successifully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>Not Removed, Try Again</p>";
                }
            }
        }
    }

    public function addEmployeeToGroupByRoles(Request $request)
    {

        $this->authenticateUser('add-payroll');

        $method = $request->method();

        if ($method == "POST") {

            $arr = $request->input('option');

            $groupID = $request->input('groupID');
            $group_roles = $this->flexperformance_model->get_group_roles($groupID);

            $group_allowances = $this->flexperformance_model->get_group_allowances($groupID);
            $group_deductions = $this->flexperformance_model->get_group_deductions($groupID);
            if (sizeof($arr) < 1) {
                echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select At Least One Employee</p>";
            } else {

                foreach ($arr as $value) {
                    $roleID = $value;
                    $emp_ids = $this->flexperformance_model->get_employee_by_position($roleID);

                    foreach ($emp_ids as $value) {
                        $empID = $value->emp_id;
                        if (!empty($group_allowances)) {
                            foreach ($group_allowances as $key) {
                                $allowance = $key->allowance;
                                $data = array(
                                    'empID' => $empID,
                                    'allowance' => $allowance,
                                    'group_name' => $groupID,
                                );

                                $this->flexperformance_model->assign_allowance($data);
                            }
                        }
                        if (!empty($group_roles)) {
                            foreach ($group_roles as $key) {
                                $role = $key->role;
                                $data = array(
                                    'userID' => $empID,
                                    'role' => $role,
                                    'group_name' => $groupID,
                                );

                                $this->flexperformance_model->assignrole($data);
                            }
                        }
                        if (!empty($group_deductions)) {
                            foreach ($group_deductions as $key) {
                                $deduction = $key->deduction;
                                $data = array(
                                    'empID' => $empID,
                                    'deduction' => $deduction,
                                    'group_name' => $groupID,
                                );

                                $this->flexperformance_model->assign_deduction($data);
                            }
                        }
                        $result = $this->flexperformance_model->addEmployeeToGroup($empID, $groupID);
                    }

                    $result = $this->flexperformance_model->addRoleToGroup($roleID, $groupID);
                }

                if ($result == true) {
                    echo "<p class='alert alert-success text-center'>Employee Added Successifully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>";
                }
            }
        }
    }

    public function addEmployeeToGroup(Request $request)
    {

        $this->authenticateUser('add-payroll');

        $method = $request->method();

        if ($method == "POST") {
            // $arr = explode(',', $request->input('option'));
            $arr = $request->option1;
            $groupID = $request->input('groupID');
            $group_roles = $this->flexperformance_model->get_group_roles($groupID);
            $group_allowances = $this->flexperformance_model->get_group_allowances($groupID);
            $group_deductions = $this->flexperformance_model->get_group_deductions($groupID);

            if (sizeof($arr) < 1) {
                echo "<p class='alert alert-warning text-center'>No Employee Selected! Please Select At Least One Employee</p>";
            } else {

                foreach ($arr as $value) {
                    $empID = $value;
                    if (!empty($group_allowances)) {
                        foreach ($group_allowances as $key) {
                            $allowance = $key->allowance;
                            $data = array(
                                'empID' => $empID,
                                'allowance' => $allowance,
                                'group_name' => $groupID,
                            );

                            $allowanceName = DB::table('allowances')->select('name')->where('id', $allowance)->limit(1)->first();

                            $this->flexperformance_model->assign_allowance($data);

                            if (empty($allowanceName)) {
                                //   SysHelpers::FinancialLogs($empID, 'Assigned allowance', '-', 'Allowance Not Found', 'Payroll Input');
                            } else {
                                //  SysHelpers::FinancialLogs($empID, 'Assigned allowance', '-', $allowanceName->name, 'Payroll Input');
                            }
                        }
                    }
                    if (!empty($group_roles)) {
                        foreach ($group_roles as $key) {
                            $role = $key->role;
                            $data = array(
                                'userID' => $empID,
                                'role' => $role,
                                'group_name' => $groupID,
                            );

                            $this->flexperformance_model->assignrole($data);
                        }
                    }
                    if (!empty($group_deductions)) {
                        foreach ($group_deductions as $key) {
                            $deduction = $key->deduction;
                            $data = array(
                                'empID' => $empID,
                                'deduction' => $deduction,
                                'group_name' => $groupID,
                            );

                            $deductionName = DB::table('deduction')->select('name')->where('id', $deduction)->limit(1)->first();

                            $this->flexperformance_model->assign_deduction($data);

                            if (empty($deductionName)) {
                                // SysHelpers::FinancialLogs($empID, 'Assigned Deduction', '-', 'Deduction Not Found', 'Payroll Input');
                            } else {
                                //SysHelpers::FinancialLogs($empID, 'Assigned Deduction', '-', $deductionName->name, 'Payroll Input');
                            }
                        }
                    }

                    $result = $this->flexperformance_model->addEmployeeToGroup($empID, $groupID);
                }
                if ($result == true) {
                    echo "<p class='alert alert-success text-center'>Employee Added Successifully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>Not Added, Try Again</p>";
                }
            }
        }
    }

    public function updategroup(Request $request)
    {
        if (isset($_POST['addselected'])) {

            $arr = $request->input('option');
            $groupID = $request->input('id');
            if (sizeof($arr) < 1) {
                session('note', "<p class='alert alert-warning text-center'>No Employee Selected! Please Select Atlest One Employee</p>");
                return redirect('/flex/groups/?id=' . base64_encode($groupID));
            }
            foreach ($arr as $value) {
                $datagroup = array(
                    'empID' => $value,
                    'group_name' => $groupID,
                );

                $rolesingroup = $this->flexperformance_model->roleswithingroup($groupID);
                $allowanceswithingroup = $this->flexperformance_model->allowanceswithingroup($groupID);

                foreach ($allowanceswithingroup as $allowances) {
                    $allowanceswithin = $allowances->allowanceswithin;
                    $data = array(
                        'empID' => $value,
                        'allowance' => $allowanceswithin,
                        'group_name' => $groupID,
                    );

                    $this->flexperformance_model->assign_allowance($data);
                }

                foreach ($rolesingroup as $roles) {

                    $roleswithin = $roles->roleswithin;
                    $data = array(
                        'userID' => $value,
                        'role' => $roleswithin,
                        'group_name' => $groupID,
                    );

                    $this->flexperformance_model->assignrole($data);
                }
                $this->flexperformance_model->add_to_group($datagroup);
            }
            session('note', "<p class='alert alert-success text-center'>Employee(s) Added Successifully!</p>");
            return redirect('/flex/groups/?id=' . base64_encode($groupID));
        } elseif (isset($_POST['removeselected'])) {

            $arr = $request->input('option');
            $groupID = $request->input('id');
            if (sizeof($arr) < 1) {
                session('note', "<p class='alert alert-warning text-center'>No Employee Selected! Please Select Atlest One Employee</p>");
                return redirect('/flex/groups/?id=' . base64_encode($groupID));
            }

            foreach ($arr as $composite) {
                $values = explode('|', $composite);
                $db_id = $values[0];
                $EMPID = $values[1];

                $this->flexperformance_model->remove_from_group($db_id);
                $this->flexperformance_model->remove_from_grouprole($EMPID, $groupID);
                $this->flexperformance_model->remove_from_grouppackage($EMPID, $groupID);
            }
            session('note', "<p class='alert alert-danger text-center'>Employees Removed Successifully!</p>");
            return redirect('/flex/groups/?id=' . base64_encode($groupID));
        }
    }

    public function deleteRole($id)
    {
        $roleID = $id;
        $result = $this->flexperformance_model->deleteRole($roleID);
        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Role Deleted Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Role Not Deleted</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function deleteGroup(Request $request)
    {
        $groupID = $this->uri->segment(3);
        $result = $this->flexperformance_model->deleteGroup($groupID);
        if ($result == true) {
            $response_array['status'] = "OK";
            $response_array['message'] = "<p class='alert alert-success text-center'>Group Deleted Successifully</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "ERR";
            $response_array['message'] = "<p class='alert alert-danger text-center'>FAILED: Group Not Deleted</p>";
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }

    public function permission(Request $request)
    {

        $data['permission'] = $this->flexperformance_model->permission();
        $data['title'] = "Roles and Activities";
        return view('app.permission', $data);
    }

    public function assignrole2(Request $request)
    {

        if (isset($_POST['assign'])) {
            $roleref = base64_encode($request->input('roleID'));

            $data = array(
                'userID' => $request->input('empID'),
                'role' => $request->input('roleID'),
            );

            $this->flexperformance_model->assignrole($data);

            session('note', "<p class='alert alert-success text-center'>Role Assigned Successifully</p>");
            $reload = '/flex/role_info/?id=' . $roleref;
            return redirect($reload);
        }
        if (isset($_POST['addgroup'])) {
            $groupID = $request->input("groupID");
            $roleID = $request->input("roleID");

            $members = $this->flexperformance_model->get_rolegroupmembers($groupID);
            foreach ($members as $row) {
                $data = array(
                    'userID' => $row->empID,
                    'role' => $roleID,
                    'group_name' => $groupID,
                );
                $this->flexperformance_model->assignrole($data);
            }

            session('note', "<p class='alert alert-success text-center'>Role Assigned Successifully</p>");
            $reload = '/flex/role_info/?id=' . base64_encode($roleID);
            return redirect($reload);
        }
    }

    public function role_info(Request $request)
    {

        // dd(Gate::allows('View Employee Summaryy'));

        $id = base64_decode($request->id);

        $permissions = DB::table('permission')->get();
        $permissions_raw = array();

        foreach ($permissions as $row) {
            array_push($permissions_raw, array(
                'id' => $row->id,
                'name' => $row->name,
                'type' => $row->permission_type,
            ));
        }

        // dd($permissions_raw);

        /*permission grouped*/
        $permissions_grouped = array();
        foreach ($permissions_raw as $item) {
            if (array_key_exists('type', $item)) {
                $permissions_grouped[$item['type']][] = $item;
            }
        }

        // dd($permissions_grouped);
        // $permisions=DB::table('permissions')->get();
        // $permisions=DB::table('permissions')->get();
        $role = DB::table('role')->where('id', $id)->first();

        // dd($role);

        $employeesnot = $this->flexperformance_model->employeesrole($id);

        $groupsnot = $this->flexperformance_model->rolesgroupsnot();
        $members = $this->flexperformance_model->role_members_byid($id);

        return view('app.updaterole', compact('role', 'permissions', 'permissions_grouped', 'employeesnot', 'groupsnot', 'members'));

        // $data['groupsnot'] = $this->flexperformance_model->rolesgroupsnot();

        // if (session('mng_roles_grp')) {
        //     $id = base64_decode($request->id);

        // $data['employeesnot'] = $this->flexperformance_model->employeesrole($id);
        //     $data['role'] = $this->flexperformance_model->getrolebyid($id);
        //     $data['roleID'] = $id;
        // $data['groupsnot'] = $this->flexperformance_model->rolesgroupsnot();
        //     $data['groupsin'] = $this->flexperformance_model->rolesgroupsin();
        //     $data['members'] = $this->flexperformance_model->role_members_byid($id);
        //     $data['permissions'] = $this->flexperformance_model->permission();
        //     $data['hr_permissions'] = $this->flexperformance_model->hr_permissions();
        //     $data['general_permissions'] = $this->flexperformance_model->general_permissions();
        //     $data['cdir_permissions'] = $this->flexperformance_model->cdir_permissions();
        //     $data['fin_permissions'] = $this->flexperformance_model->fin_permissions();
        //     $data['line_permissions'] = $this->flexperformance_model->line_permissions();
        //     $data['perf_permissions'] = $this->flexperformance_model->perf_permissions();
        //     $data['title'] = "Roles and Activities";
        //     //get members with their group
        //     $all_member_in_role = $this->flexperformance_model->role_members_byid($id);
        //     foreach ($all_member_in_role as $item) {
        //         $data['group'][$item->userID] = $this->flexperformance_model->memberWithGroup($id, $item->userID);
        //     }
        // return view('app.updaterole', $data);
        // }
    }

    public function code_generator($size)
    {
        $char = 'abcdefghijklmnopqrstuvwxyz';
        $init = strlen($char);
        $init--;

        $result = null;
        for ($x = 1; $x <= $size; $x++) {
            $index = rand(0, $init);
            $result .= substr($char, $index, 1);
        }
        return $result;
    }

    public function updaterole(Request $request)
    {

        // dd($request->id);
        if (isset($_POST['assign'])) {

            $result = DB::table('role')->where('id', $request->roleID)->update([
                // 'id' => $req->input('name'),
                'permissions' => json_encode($request->permissions),
            ]);

            // dd($result);

            if ($result == 1) {
                SysHelpers::AuditLog(1, "Added Permissions to a Role  permission tag as " . json_encode($request->permissions) . " ", $request);
                session('note', "<p class='alert alert-success text-center'>Permissions Assigned Successifully!</p>");
                return redirect('/flex/role/');
            } else {
                session('note', "<p class='alert alert-danger text-center'>FAILED: Permissions NOT Assigned, Please try Again!</p>");
                return redirect('/flex/role/');
            }
        }
        if (isset($_POST['updatename'])) {
            $idpost = $request->input('id');

            $data = array(
                'name' => $request->input('name'),
            );

            $result = $this->flexperformance_model->updaterole($data, $idpost);
            if ($result == true) {
                SysHelpers::AuditLog(1, "Updated Role Name to   " . $request->input('name') . " ", $request);
                session('note', "<p class='alert alert-success text-center'>Role Updated Successifully!</p>");
                return redirect('/flex/role');
            } else {
                session('note', "<p class='alert alert-danger text-center'>FAILED: Role Name NOT Updated, Please Try Again!</p>");
                return redirect('/flex/role');
            }
        }
    }

    public function assignrole(Request $request)
    {

        $arr = $request->input('option');

        $userID = $request->input('empID');

        if (sizeof($arr) <= 0) {
            session('note', "<p class='alert alert-danger text-center'>Sorry, No Role Selected!</p>");
            return redirect('/flex/userprofile/?id=' . $userID);
        } else {
            for ($i = 0; $i < sizeof($arr); $i++) {
                $rolevalue = $arr[$i];
                $data = array(
                    'userID' => $userID,
                    'role' => $rolevalue,
                );

                $result = $this->flexperformance_model->assignrole($data);
            }
            if ($result == true) {
                // $this->flexperformance_model->audit_log("Assigned a Role with IDs  " . implode(",", $arr) . "  to User with ID " . $userID . " ");

                session('note', "<p class='alert alert-success text-center'>Role(s) Granted Successifully!</p>");
                return redirect('/flex/userprofile/' . base64_encode($userID) . '#tab_role');
            } else {
                session('note', "<p class='alert alert-danger text-center'>FAILED: Role(s) NOT Granted, Please Try Again!</p>");
                return redirect('/flex/userprofile/?id=' . base64_encode($userID) . '#tab_role');
            }
        }
    }

    public function revokerole(Request $request)
    {

        $arr = $request->input('option');
        $userID = $request->input('empID');
        $roleid = $request->input('roleid');

        if (sizeof($arr) <= 0) {

            session('note', "<p class='alert alert-danger text-center'>Sorry, No Role Selected!</p>");
            return redirect('/flex/userprofile/' . base64_encode($userID));
        } else {
            for ($i = 0; $i < sizeof($arr); $i++) {
                $rolename = $arr[$i];
                // echo $rolename;

                $result = $this->flexperformance_model->revokerole($userID, $rolename, 0);
            }

            if ($result == true) {
                // $this->flexperformance_model->audit_log("Revoked a Role with IDs  " . implode(",", $arr) . "  to User with ID " . $userID . " ");
                session('note', "<p class='alert alert-warning text-center'>Role Revoked Successifully!</p>");
                return redirect('/flex/userprofile/' . base64_encode($userID));
            } else {

                session('note', "<p class='alert alert-danger text-center'>FAILED: Role NOT Revoked, Please Try Again!</p>");
                return redirect('/flex/userprofile/' . base64_encode($userID));
            }
        }
    }
    ######################PRIVELEGES######################################

    public function appreciation(Request $request)
    {

        $data['title'] = 'Appreciation';
        $data['appreciated'] = $this->flexperformance_model->appreciated_employee();
        $data['employee'] = $this->flexperformance_model->customemployee();
        return view('app.appreciation', $data);
    }

    public function add_apprec(Request $request)
    {
        date_default_timezone_set('Africa/Dar_es_Salaam');

        if (isset($_POST['update'])) {

            $data = array(
                'empID' => $request->input("empID"),
                'description' => $request->input("description"),
                'date_apprd' => date('Y-m-d'),
            );

            $this->flexperformance_model->add_apprec($data);
            session('note', "<p class='alert alert-success text-center'>Employee of the month Updated Successifully</p>");
            return redirect('/flex/appreciation');
        }
    }

    public function employee_payslip(Request $request)
    {
        $this->authenticateUser('view-payslip');

        $data['title'] = 'Employee Payslip';
        $data['payrollList'] = $this->payroll_model->payrollMonthList();
        $data['title'] = "Employee Payslip";
        $data['month_list'] = $this->payroll_model->payroll_month_list();
        $data['employee'] = $this->payroll_model->customemployee();
        return view('app.employee_payslip', $data);
    }

    ######################LEAVE NOTIFICATION######################################

    ######################NOTIFICATION BADGES ######################################

    public function contract_expiration(Request $request)
    {

        $contract = $this->flexperformance_model->contract_expiration();
        foreach ($contract as $key) {
            $retire = $key->RETIRE;
            $tempo = $key->TEMPO;
            $permanent = $key->PERMANENT;
            $intern = $key->INTERN;
        }
    }

    ################### ADD EMPLOYEE    ################################

    public function updateCompanyName(Request $request)
    {
        $id = 1;
        if ($request->method() == "POST" && $id != '') {
            $data = array(
                'cname' => $request->input('name'),
            );
            $result = $this->flexperformance_model->updateemployer($data, $id);
            if ($result == true) {
                echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
        </button>Company Name Updated Successifully
      </div>';
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span>
        </buttonUpdation Failed
      </div>';
            }
        }
    }

    public function addEmployee(Request $request)
    {
        $this->authenticateUser('add-employee');
        $data['pdrop'] = $this->flexperformance_model->positiondropdown();
        $data['contract'] = $this->flexperformance_model->contractdrop();
        $data['ldrop'] = $this->flexperformance_model->linemanagerdropdown();
        $data['ddrop'] = $this->flexperformance_model->departmentdropdown();
        $data['currencies'] = $this->flexperformance_model->get_currencies();

        $data['pensiondrop'] = $this->flexperformance_model->pensiondropdown();
        $data['branch'] = $this->flexperformance_model->branchdropdown();
        $data['bankdrop'] = $this->flexperformance_model->bank();
        $data['countrydrop'] = $this->flexperformance_model->countrydropdown();

        $data['title'] = "Add Employee";
        $data['parent'] = "Employee";
        $data["child"] = "Register Employee";
        // return $data['ldrop'];
        return view('app.employeeAdd', $data);
    }

    public function getPositionSalaryRange(Request $request)
    {
        $positionID = $request->positionID;

        $data = array(
            'state' => 0,
        );

        $minSalary = $maxSalary = 0;
        $result = $this->flexperformance_model->getPositionSalaryRange($positionID);

        foreach ($result as $value) {
            $minSalary = $value->minSalary;
            $maxSalary = $value->maxSalary;
        }
        if ($result) {
            // $response_array['salary'] = "<div><input required='required'  class='form-control @error('salary') is-invalid @enderror' type='number' min='" . $minSalary . "' step='0.01' max='" . $maxSalary . "'  name='salary'><div class='form-text text-muted'>Minimum salary is " . $minSalary . " and Maximam salary is " . $maxSalary . "</div></div>";
            $response_array['salary'] = "<div><input required='required'  class='form-control @error('salary') is-invalid @enderror' type='number'  step='0.01'  name='salary'></div>";
        } else {
            $response_array['salary'] = "<input required='required'  class='form-control col-md-7 col-xs-12' type='text' readonly value = 'Salary was Set to 10000'><input hidden required='required' type='number' readonly value = '10000' name='salary'>";
        }
        header('Content-type: application/json');
        echo json_encode($response_array);
    }

    //upload Employee

    public function import(Request $request)
    {
        // dd($request->all());

        if (isset($_FILES["file"]["name"])) {

            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $data[] = array(
                        'emp_id' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
                        'fname' => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                        'mname' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                        'lname' => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                        'gender' => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
                        'mobile' => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
                        'email' => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
                        'salary' => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                        'account_no' => $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
                        'bank' => 1,
                        'bank_branch' => 1,
                        'pension_fund' => 2,
                    );
                }
            }
            $this->flexperformance_model->uploadEmployees($data);
        }
    }

    public function password_generator($size)
    {
        $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$';
        $init = strlen($char);
        $init--;

        $result = null;
        for ($x = 1; $x <= $size; $x++) {
            $index = rand(0, $init);
            $result .= substr($char, $index, 1);
        }
        return $result;
    }

    public function passwordAutogenerate(Request $request)
    {
        $this->authenticateUser('view-password-reset');

        // $email_data = array(
        //     'email' => $request->email,
        //     'fname' => $request->fname,
        //     'lname' => $request->lname,
        //     'username' => $emp_id,
        //     'password' => $password
        // );

        if ($request->method() == 'POST') {
            if ($request->emp_id == 'all') {
                $employee = Employee::all();
                if ($request->type == 'All') {
                    $employee = Employee::all();
                } elseif ($request->type == 1) {
                    $employee = Employee::all()->where('branch', 1)->where('emp_id', '!=', 102927)->where('emp_id', '!=', 102928)->where('emp_id', '!=', 100281);
                } elseif ($request->type == 1) {
                    $employee = Employee::all()->whereNot('branch', 1);
                } else {
                    $employee = Employee::all();
                }
            } else {
                $employee = Employee::all()->where('emp_id', $request->emp_id);
            }

            foreach ($employee as $row) {
                $pass = $this->password_generator(8);
                $password = Hash::make($pass);
                Employee::where('emp_id', $row->emp_id)->update(['password' => $password]);
                $email_data = array(
                    'email' => $row->email,
                    'fname' => $row->fname,
                    'lname' => $row->lname,
                    'username' => $row->emp_id,
                    'password' => $pass,
                );

                try {

                    Notification::route('mail', $row->email)->notify(new RegisteredUser($email_data));
                } catch (Exception $exception) {
                    return redirect()->back()->with(['error' => 'Password change Failed to to Email SMTP problems']);
                }
            }

            return redirect()->back()->with(['success' => 'Password changed successfully']);
        } else {
            $data['employee'] = Employee::where('state', '=', 1)->get();

            return view('password-seting', $data);
        }
    }

    public function download_payslip()
    {

        $data['month_list'] = $this->flexperformance_model->payroll_month_list();

        return view('my-services.payslip', $data);
    }

    /**
     * Register emmployee
     *
     */
    public function registerEmployee(EmployeeRequest $request)
    {
        // $validatedFields = $request->validate([
        //     'tin' => [
        //         'required',
        //         'regex:/^[0-9]{9}$/',
        //     ],
        //     'nationalid' => [
        //         'required',
        //         'regex:/^[A-Za-z0-9]{8}$/',
        //     ],
        // ]);

        $validator = $request->validated($request->all());



        $calendar = str_replace('/', '-', $request->input('birthdate'));
        $contract_end = str_replace('/', '-', $request->input('contract_end'));
        $contract_start = str_replace('/', '-', $request->input('contract_start'));

        $birthdate = date('Y-m-d', strtotime($calendar));

        $date1 = date_create($birthdate);
        $date2 = date_create(date('Y-m-d'));

        $diff = date_diff($date1, $date2);
        $required = $diff->format("%R%a");

        $currency = $request->currency;
        $rate = $this->flexperformance_model->get_rate($currency);

        if (($required / 365) > 16) {

            $countryCode = $request->nationality;

            // $randomPassword = $this->password_generator(8);

            $password = "ABC1234";

            $emp_id = $request->emp_id;

            if (!empty($request->mname)) {
                $empName = $request->input("fname") . ' ' . $request->input("mname") . ' ' . $request->input("lname");
            } else {
                $empName = $request->input("fname") . ' ' . $request->input("lname");
            }

            $employee = array(
                'fname' => $request->input("fname"),
                'mname' => $request->input("mname"),
                'full_name' => $empName,
                'rate' => $rate,
                'currency' => $currency,
                //'emp_code' => $request->input("emp_code"),
                'emp_level' => $request->input("emp_level"),
                'cost_center' => $request->input("cost_center"),
                'leave_days_entitled' => $request->input("leave_day"),

                'accrual_rate' => $request->input("leave_day") / 12,
                'lname' => $request->input("lname"),
                // 'lname' => $randomPassword,
                'salary' => $request->input("salary"),
                'company' => 1,
                'gender' => $request->input("gender"),
                'email' => $request->input("email"),
                'nationality' => $request->input("nationality"),
                'merital_status' => $request->input("status"),
                'birthdate' => $birthdate,
                'position' => $request->input("position"),
                'contract_type' => $request->input("ctype"),
                'postal_address' => $request->input("postaddress"),
                'physical_address' => $request->input('haddress'),
                'mobile' => $request->input('mobile'),
                'account_no' => $request->input("accno"),
                'bank' => $request->input("bank"),
                'bank_branch' => 1,
                'pension_fund' => $request->input("pension_fund"),
                'pf_membership_no' => $request->input("pf_membership_no"),
                'home' => $request->input("haddress"),
                'postal_city' => $request->input("postalcity"),
                'photo' => "user.png",
                'password_set' => "1",
                'line_manager' => $request->input("linemanager"),
                'department' => $request->input("department"),
                'branch' => $request->input("branch"),
                'hire_date' => date('Y-m-d', strtotime($contract_start)),
                'contract_renewal_date' => date('Y-m-d'),
                'emp_id' => $emp_id,
                'username' => $request->input("emp_id"),
                // 'password' => password_hash($randomPassword, PASSWORD_BCRYPT),
                'password' => Hash::make($password),
                'contract_end' => date('Y-m-d', strtotime($contract_end)),
                'state' => 5,
                'national_id' => $request->input("nationalid"),
                'tin' => $request->input("tin"),

            );

            $newEmp = array(
                'emp_id' => $emp_id,
                'account' => 1,
            );

            $recordID = $this->flexperformance_model->employeeAdd($employee, $newEmp);

            $id = $emp_id;

            if ($recordID > 0) {

                $emp_data = Employee::where('emp_id', $emp_id)->first();

                $user = User::find($emp_data->id);

                $user->roles()->attach(6);

                $user->roles()->attach($request['role']);

                SysHelpers::FinancialLogs($id, 'Add Employee', '', '', 'Employee Registration');

                SysHelpers::FinancialLogs($id, 'Salary', '0.00', number_format($request->input("salary"), 2), 'Employee Registration');

                //register employee to leave approve maping

                $approval = new LeaveApproval();
                $approval->empID = $emp_id;
                $approval->level1 = $request->input("linemanager");
                //$approval->level2 = $request->level_2;
                // $approval->level3 = $request->level_3;
                $approval->escallation_time = 2;
                $approval->save();

                //end leave approve mapping

                /*give 100 allocation*/
                $data = array(
                    'empID' => $emp_id,
                    'activity_code' => 'AC0018',
                    'grant_code' => 'VSO',
                    'percent' => 100.00,
                );

                $this->project_model->allocateActivity($data);

                // $empID = sprintf("%03d", $countryCode).sprintf("%04d", $recordID);

                $empID = $emp_id;

                $property = array(
                    'prop_type' => "Employee Package",
                    'prop_name' => "Employee ID, Health Insuarance Card, Email Address and System Access",
                    'serial_no' => $empID,
                    'given_by' => auth()->user()->emp_id,
                    'given_to' => $empID,
                );
                $datagroup = array(
                    'empID' => $empID,
                    'group_name' => 1,
                );

                $result = $this->flexperformance_model->updateEmployeeID($recordID, $empID, $property, $datagroup);

                if ($result == true) {

                    $email_data = array(
                        'email' => $request->email,
                        'fname' => $request->fname,
                        'lname' => $request->lname,
                        'username' => $emp_id,
                        'password' => $password,
                    );

                    $user = User::first();
                    //$user->notify(new RegisteredUser($email_data));
                    // Notification::route('mail', $email_data['email'])->notify(new RegisteredUser($email_data));
                    //});
                    //$senderInfo = $this->payroll_model->senderInfo();

                    //         /* EMAIL*/
                    //     foreach ($senderInfo as $keyInfo) {
                    //       $host = $keyInfo->host;
                    //       $username = $keyInfo->username;
                    //       $password = $keyInfo->password;
                    //       $smtpsecure = $keyInfo->secure;
                    //       $port = $keyInfo->port;
                    //       $senderEmail = $keyInfo->email;
                    //       $senderName = $keyInfo->name;
                    //     }
                    //   // PHPMailer object
                    //     $mail = $this->phpmailer_lib->load();// PHPMailer object
                    //     // SMTP configuration
                    //     $mail->isSMTP();
                    //     $mail->Host     = $host;
                    //     $mail->SMTPAuth = true;
                    //     $mail->Username = $username;
                    //     $mail->Password = $password;

                    //     $mail->SMTPSecure = $smtpsecure;
                    //     $mail->Port     = $port;

                    //     $mail->setFrom($senderEmail, $senderName);

                    //     // Add a recipient
                    //     $mail->addAddress($request->input("email"));

                    //     // Email subject
                    //     $mail->Subject = "VSO User Credentials";

                    //9     // Set email format to HTML
                    //     $mail->isHTML(true);

                    //     // Email body content
                    //     $mailContent = "<p>Dear <b>".$empName."</b>,</p>
                    //                 <p>Your Flex Performance Account login credential are  password: <b>".$randomPassword."</b>.
                    //                 Please use your employee ID as your username.</p>
                    //                 <p>You are advised not to share your password with anyone. If you dont know this activity or you received this email by accident, please report
                    //                     this incident to the system administrator.<br><br>
                    //                     Thank you,<br>
                    //                     Flex Performance Software Self Service.</p>";
                    //     $mail->Body = $mailContent;

                    //     if(!$mail->send()){

                    //         session("note", "<p><font color='green'>Email was not sent</font></p>");
                    //         }else{
                    //         session("note","<p><font color='green'>Email sent!</font></p>");
                    //       }

                    /*add in transfer with status = 5 (registered, waiting for approval)*/

                    $data_transfer = array(
                        'empID' => $emp_id,
                        'parameter' => 'New Employee',
                        'parameterID' => 5,
                        'old' => 0,
                        'new' => $request->input("salary"),
                        'old_department' => 0,
                        'new_department' => $request->input("department"),
                        'old_position' => 0,
                        'new_position' => $request->input("position"),
                        'status' => 5, //new employee
                        'recommended_by' => auth()->user()->emp_id,
                        'approved_by' => '',
                        'date_recommended' => date('Y-m-d'),
                        'date_approved' => '',
                    );

                    $this->flexperformance_model->employeeTransfer($data_transfer);

                    // dd("I am here");

                    $response_array['empID'] = $empID;
                    $response_array['status'] = "OK";
                    $response_array['title'] = "Registered Successfully";
                    $response_array['message'] = "<div class='alert alert-success alert-dismissible fade in' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span> </button>Employee Added Successifully
                        </div>";
                    header('Content-type: application/json');
                    $response_array['credentials'] = "username ni " . $emp_id . "password:" . $password;
                    echo json_encode($response_array);
                } else {
                    $response_array['status'] = "ERR";
                    $response_array['title'] = "FAILED";
                    $response_array['message'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span> </button>FAILED: Employee Not Added Please try again
                        </div>';
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }
            } else {
                $response_array['status'] = "ERR";
                $response_array['title'] = "FAILED";
                $response_array['message'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span> </button>Registration Failed, Employee`s Age is Less Than 16
                    </div>';
                header('Content-type: application/json');
                echo json_encode($response_array);
            }
        }
    }

    ##################  END ADD EMPLOYEE  ############################

    public function organization_structure(Request $request)
    {
        $id = 1;

        $data['details'] = $this->flexperformance_model->employerdetails($id);

        $data['allpositioncodes'] = $this->flexperformance_model->allpositioncodes();
        $data['topposition'] = $this->flexperformance_model->topposition();
        $data['otherpositions'] = $this->flexperformance_model->otherpositions();

        $data['allDepartments'] = $this->flexperformance_model->alldepartmentcodes();
        $data['topDepartment'] = $this->flexperformance_model->topDepartment();
        $data['childDepartments'] = $this->flexperformance_model->childDepartments();

        $data['title'] = "Employer Info";
        return view('app.company_info', $data);
    }

    public function accounting_coding()
    {

        $data['accounting_coding'] = $this->flexperformance_model->accounting_coding();
        return view('app.accounting_coding', $data);
    }

    public function department_structure(Request $request)
    {
        $id = 1;

        $data['details'] = $this->flexperformance_model->employerdetails($id);

        $data['allpositioncodes'] = $this->flexperformance_model->allpositioncodes();
        $data['topposition'] = $this->flexperformance_model->topposition();
        $data['otherpositions'] = $this->flexperformance_model->otherpositions();

        $data['allDepartments'] = $this->flexperformance_model->alldepartmentcodes();
        $data['topDepartment'] = $this->flexperformance_model->topDepartment();
        $data['childDepartments'] = $this->flexperformance_model->childDepartments();

        $data['title'] = "Employer Info";
        return view('app.company_info', $data);
    }

    public function Oldorganization_structure(Request $request)
    {
        $id = 1;

        $data['details'] = $this->flexperformance_model->employerdetails($id);

        $data['allpositioncodes'] = $this->flexperformance_model->allpositioncodes();
        $data['topposition'] = $this->flexperformance_model->topposition();
        $data['otherpositions'] = $this->flexperformance_model->otherpositions();

        $data['title'] = "Employer Info";
        return view('app.company_info', $data);

        if (isset($_POST['update'])) {

            $config = array(
                'upload_path' => "./uploads/logo/",
                'file_name' => "organization_logo",
                'allowed_types' => "img|jpg|jpeg|png",
                'overwrite' => true,
            );
            $path = "/uploads/logo/";

            $this->load->library('upload', $config);
            if ($this->upload->do_upload()) {
                $data = $this->upload->data();
                // $completepath =  $path.$data["file_name"];

                $data = array(
                    // 'tin' => $request->input('tin'),
                    // 'cname' => $request->input('cname'),
                    // 'postal_address' => $request->input('postal_address'),
                    'postal_city' => $request->input('postal_city'),
                    'phone_no1' => $request->input('phone_no1'),
                    'phone_no2' => $request->input('phone_no2'),
                    'phone_no3' => $request->input('phone_no3'),
                    'fax_no' => $request->input('fax_no'),
                    'email' => $request->input('email'),
                    'plot_no' => $request->input('plot_no'),
                    'block_no' => $request->input('block_no'),
                    'street' => $request->input('street'),
                    'branch' => $request->input('branch'),
                    'wcf_reg_no' => $request->input('wcf_reg_no'),
                    'heslb_code_no' => $request->input('heslb_code_no'),
                    'business_nature' => $request->input('business_nature'),
                    'logo' => $path . $data["file_name"],
                    'company_type' => $request->input('company_type'),

                );

                $this->flexperformance_model->updateemployer($data, $id); // ) {
                session('note', "<p class='alert alert-success text-center'>Company Information Updated Successifully</p>");

                return redirect('/flex/employer');
            } else {
                // $error = $this->upload->display_errors();
                session('note', "<p class='alert alert-warning text-center'>The filetype you are attempting to upload is not allowed!.</p>");
                return redirect('/flex/employer');
            }
        }
    }

    ################## GRIEVANCES AND DISCPLINARY#############################

    public function grievances(Request $request)
    {
        $empID = auth()->user()->emp_id;
        $data['title'] = 'Grievances and Disciplinary';
        $data['my_grievances'] = $this->flexperformance_model->my_grievances($empID);
        //if(session('griev_hr')!=''){
        $data['other_grievances'] = $this->flexperformance_model->all_grievances();
        //}
        return view('app.grievances', $data);

        if (isset($_POST["submit"])) {

            $config = array(
                'upload_path' => "./uploads/grievances/",
                'file_name' => "FILE" . date("Ymd-His"),
                'allowed_types' => "img|jpg|jpeg|png|pdf|xlsx|xls|doc|ppt|docx",
                'overwrite' => true,
            );
            $path = "/uploads/grievances/";

            $this->load->library('upload', $config);
            if ($this->upload->do_upload()) {

                $data = $this->upload->data();
                if ($request->input('anonymous') == '1') {

                    $data = array(
                        'title' => $request->input("title"),
                        'description' => $request->input("description"),
                        'empID' => auth()->user()->emp_id,
                        'anonymous' => 1,
                        'attachment' => $path . $data["file_name"],
                        'forwarded' => 1,
                    );
                } else {

                    $data = array(
                        'title' => $request->input("title"),
                        'description' => $request->input("description"),
                        'empID' => auth()->user()->emp_id,
                        'attachment' => $path . $data["file_name"],
                    );
                }

                $this->flexperformance_model->add_grievance($data);
                session('note', "<p class='alert alert-success text-center'>Your Grievance has been Submitted Successifully</p>");
                return redirect('/flex/grievances');
            } else {

                if ($request->input('anonymous') == '1') {

                    $data = array(
                        'title' => $request->input("title"),
                        'description' => $request->input("description"),
                        'empID' => auth()->user()->emp_id,
                        'attachment' => "N/A",
                        'anonymous' => 1,
                        'forwarded' => 1,
                    );
                } else {

                    $data = array(
                        'title' => $request->input("title"),
                        'description' => $request->input("description"),
                        'empID' => auth()->user()->emp_id,
                        'attachment' => "N/A",
                    );
                }

                $this->flexperformance_model->add_grievance($data);
                session('note', "<p class='alert alert-success text-center'>Your Grievance has been Submitted Successifully</p>");
                return redirect('/flex/grievances');
            }
        }
    }

    public function audit_logs(Request $request)
    {
        if (session('mng_audit')) {

            // getting all audit trail logs
            $data['logs'] = $this->flexperformance_model->audit_logs();

            // selecting audit trail for someone who deleted all tha audit logs
            $data['purge_logs'] = $this->flexperformance_model->audit_purge_logs();

            $data['parent'] = "Settings";
            $data['child'] = "Audit Log";

            return view('audit-trail.audit_logs', $data);
        } else {

            abort(403, 'Unauthorized action.');
        }
    }

    public function payrollReportLogs()
    {
        $data['logs'] = $this->flexperformance_model->financialLogs();

        $data['title'] = 'Payroll Input Changes Approval Report';
        $data['parent'] = 'Payroll Log Report';

        return view('audit-trail.financial_logs', $data);
    }

    public function auditLogsDestry(Request $request)
    {
        $logData = array(
            'empID' => auth()->user()->emp_id,
            'description' => "Cleared Audit logs",
            'agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
            'due_date' => date('Y_m_d_H_i_s'),
        );

        $result = DB::transaction(function () use ($logData) {
            DB::table('audit_trails')->delete();

            $this->flexperformance_model->insertAuditPurgeLog($logData);

            return 1;
        });

        if ($result == 1) {
            return redirect()->route('flex.audit_logs');
        } else {
            abort(400, 'Bad Request');
        }

        //    retrun redirectback();
    }

    public function export_audit_logs(Request $request)
    {
        $this->load->library("excel");
        $object = new Spreadsheet();
        $filename = "audit_logs_" . date('Y_m_d_H_i_s') . ".xls";

        $object->setActiveSheetIndex(0);

        $table_columns = array("S/N", "ID", "Name", "Department", "Position", "Description", "Platform", "Agent", "IP Address", "Time");

        $column = 0;

        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $records = $this->flexperformance_model->audit_logs();

        $data_row = 2;

        $SNO = 1;
        foreach ($records as $row) {
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $data_row, $SNO);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $data_row, $row->empID);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $data_row, $row->empName);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $data_row, $row->department);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $data_row, $row->position);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $data_row, $row->description);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $data_row, $row->platform);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $data_row, $row->agent);
            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $data_row, $row->ip_address);
            $object->getActiveSheet()->setCellValueByColumnAndRow(9, $data_row, $row->dated . " at " . $row->timed);
            $data_row++;
            $SNO++;
        }

        $writer = new Xls($object); // instantiate Xlsx
        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        ob_start();
        $writer->save('php://output'); // download file

        $result = $this->flexperformance_model->clear_audit_logs();

        if ($result == true) {
            $logData = array(
                'empID' => auth()->user()->emp_id,
                'description' => "Cleared Audit logs",
                'agent' => session('agent'),
                //        'platform' =>$this->agent->platform(),
                'ip_address' => $this->input->ip_address(),
                'due_date' => date('Y_m_d_H_i_s'),
            );
        }

        $this->flexperformance_model->insertAuditPurgeLog($logData);
    }
    ############################ END GRIEVANCES AND DISCPLINARY#############################

    #################################### TEST FUNCTIONS #######################################

    public function userArray(Request $request)
    {
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        $recipients = $this->flexperformance_model->employeeMails();

        // SEND EMAIL
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mirajissa1@gmail.com';
        $mail->Password = 'Mirajissa1@1994';

        //For server uses
        /*$mail->SMTPSecure = 'tls';
        $mail->Port     = 587;*/

        //For localhost uses
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('mirajissa1@gmail.com', 'Miraj Issa');
        // $mail->addReplyTo('mirajissa1@gmail.com', 'CodexWorld');

        // Add a recipient
        // $mail->addAddress($email);

        foreach ($recipients as $row) {
            $mail->addAddress($row->email, $row->name);
        }
        // Add cc or bcc
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Email subject
        $mail->Subject = 'Test Multiple Mail';

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<h1>Hello! &nbsp; YOUR NAME HERE</h1>
            <p>Please Find The Attached Payslip For the <b>THIS MONTH</b> Payroll Month</p>";
        $mail->Body = $mailContent;
        // $mail->AddStringAttachment($payslip, 'payslip.pdf');

        $mail->send(); // Send email

        // Send email
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Emails  has been sent SUCCESSIFULLY';
        }
        // SEND EMAIL

    }
    public function userAgent(Request $request)
    {
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        echo $agent . "<br>";

        echo $this->agent->platform() . "<br>"; // Platform info (Windows, Linux, Mac, etc.)
        echo $this->input->ip_address();
    }

    public function sendMailuser()
    {
        /*$settings = $this->flexperformance_model->get_email_conf();
        foreach ($settings as $data) {
        $host = $data->host;
        $port = $data->port;
        }*/
        //exit($host.$port);
        $d =
            $config = array(
                'protocol' => 'TLS',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => 587,
                'smtp_user' => 'mirajissa1@gmail.com', // change it to yours
                'smtp_pass' => 'Mirajissa1@1994', // change it to yours
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
                'wordwrap' => true,
            );

        $message = "This is my email";
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('mirajissa1@gmail.com'); // change it to yours
        $this->email->to('mirajissa1@gmail.com'); // change it to yours
        $this->email->subject('Boardroom invitation');
        $this->email->message($message);
        if ($this->email->send()) {
            echo 'User Registered Successfuly';
            // return redirect('../setting/user/');
            echo $this->email->print_debugger();
        } else {
            show_error($this->email->print_debugger());
        }
    }

    public function patterntest(Request $request)
    {
        $string = "6|0|2|0.165*3|300000|1|0.000";
        $split = explode("*", $string);
        foreach ($split as $values) {
            $allowances = explode("|", $values);

            echo $this->flexperformance_model->get_allowance_name($allowances[0]) . " The Rate is " . $allowances[3] . "<br>";
        }
    }

    public function sendMailuserFinal()
    {
        /*$settings = $this->flexperformance_model->get_email_conf();
        foreach ($settings as $data) {
        $host = $data->host;
        $port = $data->port;
        }*/
        //exit($host.$port);
        $d =
            $config = array(
                'protocol' => 'TLS',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => 587,
                'smtp_user' => 'mirajissa1@gmail.com', // change it to yours
                'smtp_pass' => 'Mirajissa1@1994', // change it to yours
                'mailtype' => 'text',
                'charset' => 'iso-8859-1',
                'wordwrap' => true,
            );

        $message = "This is my email";
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('mirajissa1@gmail.com'); // change it to yours
        $this->email->to('mirajissa1@gmail.com'); // change it to yours
        $this->email->subject('Fl&#233;x Boardroom invitation');
        $this->email->message($message);
        if ($this->email->send()) {
            echo 'User Registered Successfuly';
            // return redirect('../setting/user/');
            echo $this->email->print_debugger();
        } else {
            show_error($this->email->print_debugger());
        }
    }

    public function send_email(Request $request)
    {
        $config = array(
            'protocol' => 'TLS',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587, //465,
            'smtp_user' => 'mirajissa1@gmail.com',
            'smtp_pass' => 'Mirajissa1@1994',
            'smtp_crypto' => 'tls',
            'smtp_timeout' => '20',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );
        $config['newline'] = "\r\n";
        $config['crlf'] = "\r\n";
        $this->load->library('email', $config);
        $this->email->from('mirajissa1@gmail.com', 'Admin');
        $this->email->to('mirajissa1@gmail.com');
        $this->email->subject('Grretings');
        $this->email->message('Hello Miraji How Are You Doing with Coding?');

        /*$this->email->attach('C:\Users\xyz\Desktop\images\abc.png');
        $pdfString = $pdf->Output('dummy.pdf', 'S');
        $mailer->AddStringAttachment($pdfString, 'some_filename.pdf');*/

        //$this->email->send();
        if (!$this->email->send()) {
            echo "FAILED TO SEND EMAIL";
        }
        echo "EMAIL SENT SUCCESSIFULLY";
    }

    //using PHPMiler

    public function send(Request $request)
    {
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mirajissa1@gmail.com';
        $mail->Password = 'Mirajissa1@1994';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('mirajissa1@gmail.com', 'CodexWorld');
        $mail->addReplyTo('mirajissa1@gmail.com', 'CodexWorld');

        // Add a recipient
        $mail->addAddress('mirajissa1@gmail.com');

        // Add cc or bcc
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Email subject
        $mail->Subject = 'SUCCESS:Send Email via SMTP using PHPMailer in CodeIgniter';

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
            <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
        $mail->Body = $mailContent;

        // Send email
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

    public function retired(Request $request)
    {
        $empID = $request->input('id');
        $this->flexperformance_model->employeeRetired($empID);
        session('retired', "<p class='alert alert-warning text-center'>Contract Deleted Successifully</p>");
        $reload = '/flex/userprofile/?id=' . $empID;
        return redirect($reload);
    }

    public function loginuser(Request $request)
    {
        $empID = $request->input('id');
        $this->flexperformance_model->employeeLogin($empID);
        session('loginuser', "<p class='alert alert-warning text-center'>Contract Deleted Successifully</p>");
        $reload = '/flex/userprofile/?id=' . $empID;
        return redirect($reload);
    }

    public function employeeReport(Request $request)
    {
        // $data['leave'] =  $this->attendance_model->leavereport();
        $data['employees'] = $this->flexperformance_model->employeeReport();
        $data['month_list'] = $this->payroll_model->payroll_month_list();
        $data['title'] = "Employee Report";
        return view('app.employee_report', $data);
    }

    public function partial(Request $request)
    {
        if ($request->method() == "POST") {
            if ($request->input('to') == '' || $request->input('from') == '') {
                $response_array['status'] = "no_date";
                echo json_encode($response_array);
            } else {

                $fx = explode('/', $request->input('from'));
                $tx = explode('/', $request->input('to'));
                $from = $fx[2] . '-' . $fx[1] . '-' . $fx[0];
                $to = $tx[2] . '-' . $tx[1] . '-' . $tx[0];
                $start = strtotime($from);
                $end = strtotime($to);
                $days = ceil(abs($end - $start) / 86400) + 1;

                if ($start > $end) {
                    // Start date is in front of end date!
                    $response_array['status'] = "date_mismatch";
                    echo json_encode($response_array);
                } else {
                    $data = array(
                        'empID' => $request->input('employee'),
                        'start_date' => $from,
                        'end_date' => $to,
                        'days' => $days,
                        'date' => date('Y-m-d'),
                        'init' => auth()->user()->emp_id,
                    );

                    $this->flexperformance_model->addPartialPayment($data);
                    $response_array['status'] = "OK";
                    echo json_encode($response_array);
                }
            }
        }
    }

    public function deletePayment()
    {
        $payment_id = $this->uri->segment(3);
        $result = $this->flexperformance_model->deletePayment($payment_id);
        if ($result == true) {
            $response_array['status'] = "OK";
            echo json_encode($response_array);
        } else {
            $response_array['status'] = "ERR";
            echo json_encode($response_array);
        }
    }

    public function updateGroupEdit(Request $request)
    {
        if ($request->method() == "POST") {

            $group_id = $request->input('group_id');
            $group_name = $request->input('group_name');
            $result = $this->flexperformance_model->updateGroupEdit($group_id, $group_name);
            if ($result == true) {
                $response_array['status'] = "OK";
                echo json_encode($response_array);
            } else {
                $response_array['status'] = "ERR";
                echo json_encode($response_array);
            }
        }
    }

    public function netTotalSummation($payroll_date)
    {
        //FROM DATABASE
        $temporary_mwp_total = $this->reports_model->temporaryAllowanceMWPExport($payroll_date);
        $staff_bank_totals = $this->reports_model->staffPayrollBankExport($payroll_date);
        $temporary_bank_totals = $this->reports_model->temporaryPayrollBankExport($payroll_date);

        /*amount bank staff*/
        $amount_staff_bank = 0;
        foreach ($staff_bank_totals as $row) {
            $amount_staff_bank += $row->salary +
                $row->allowances - $row->pension - $row->loans - $row->deductions - $row->meals - $row->taxdue;
        }

        /*amount bank temporary*/
        $amount_temporary_bank = 0;
        foreach ($temporary_bank_totals as $row) {
            $amount_temporary_bank += $row->salary +
                $row->allowances - $row->pension - $row->loans - $row->deductions - $row->meals - $row->taxdue;
        }

        /*mwp total*/
        $amount_mwp = 0;
        foreach ($temporary_mwp_total as $row) {
            $amount_mwp += $row->salary +
                $row->allowances - $row->pension - $row->loans - $row->deductions - $row->meals - $row->taxdue;
        }

        $total = $amount_mwp + $amount_staff_bank + $amount_temporary_bank;

        return $total;
    }

    public function updateContractStart(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $contract_start = str_replace('/', '-', $request->input('contract_start'));
            $updates = array(
                'hire_date' => date('Y-m-d', strtotime($contract_start)),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateContractStart($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Contract Start Date Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function updateContractEnd(Request $request)
    {
        $empID = $request->input('empID');
        if ($request->method() == "POST" && $empID != '') {
            $contract_end = str_replace('/', '-', $request->input('contract_end'));
            $updates = array(
                'contract_end' => date('Y-m-d', strtotime($contract_end)),
                'last_updated' => date('Y-m-d'),
            );
            $result = $this->flexperformance_model->updateContractEnd($updates, $empID);
            if ($result == true) {
                echo "<p class='alert alert-success text-center'>Contract End Date Successifully!</p>";
            } else {
                echo "<p class='alert alert-danger text-center'>Update Failed</p>";
            }
        }
    }

    public function approveRegistration($id)
    {
        /*
         * status 7 = cancelled
         * status 6 = accepted
         */
        if ($id) {
            $transferID = $id;
            $transfers = $this->flexperformance_model->transfers($transferID);

            // dd($transfers);

            if ($transfers) {
                $emp_id = $transfers->empID;
                $approver = auth()->user()->emp_id;
                $date = date('Y-m-d');
                $result = $this->flexperformance_model->approveRegistration($emp_id, $transferID, $approver, $date);
                if ($result == true) {
                    echo "<p class='alert alert-success text-center'>Registration Successfully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>FAILED: Failed To Approve Registration, Please Try Again</p>";
                }
            }
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED: Failed To Approve Registration, Please Try Again</p>";
        }
    }

    public function disapproveRegistration($id)
    {
        /*
         * status 7 = cancelled
         * status 6 = accepted
         */
        if ($id) {
            $transferID = $id;
            $transfers = $this->flexperformance_model->transfers($transferID);

            // dd($transfers);

            if ($transfers) {
                $emp_id = $transfers->empID;
                $result = $this->flexperformance_model->disapproveRegistration($emp_id, $transferID);
                if ($result == true) {
                    echo "<p class='alert alert-success text-center'>Registration Cancelled Successfully!</p>";
                } else {
                    echo "<p class='alert alert-danger text-center'>FAILED: Failed To Cancel Registration, Please Try Again</p>";
                }
            }
        } else {
            echo "<p class='alert alert-danger text-center'>FAILED: Failed To Cancel Registration, Please Try Again</p>";
        }
    }

    // start of terminations functions

    // For all Terminations Page
    public function termination()
    {

        $this->authenticateUser('view-termination');

        $data['title'] = "Termination";
        $data['my_overtimes'] = $this->flexperformance_model->my_overtimes(auth()->user()->emp_id);
        $data['employees'] = $this->flexperformance_model->Employee();
        $terminations = Termination::orderBy('created_at', 'desc')->get();
        $data['line_overtime'] = $this->flexperformance_model->lineOvertimes(auth()->user()->emp_id);

        $i = 1;
        $employee = Auth::User()->id;

        $role = UserRole::where('user_id', $employee)->first();
        $role_id = $role->role_id;
        $terminate = Approvals::where('process_name', 'Termination Approval')->first();
        $roles = Role::where('id', $role_id)->first();
        $data['level'] = ApprovalLevel::where('role_id', $role_id)->where('approval_id', $terminate->id)->first();

        $data['check'] = 'Approved By ' . $roles->name;

        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['parent'] = 'Workforce';
        $data['child'] = 'Termination';

        return view('workforce-management.termination', $data, compact('terminations', 'i'));
    }

    // For Add Termination Page
    public function addTermination()
    {
        $this->authenticateUser('add-termination');

        $data['title'] = "Terminate Employee";
        $data['my_overtimes'] = $this->flexperformance_model->my_overtimes(auth()->user()->emp_id);
        $data['employees'] = $this->flexperformance_model->Employee();
        $data['line_overtime'] = $this->flexperformance_model->lineOvertimes(auth()->user()->emp_id);
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['parent'] = 'Workforce';
        $data['child'] = 'AddTermination';

        return view('workforce-management.add-termination', $data);
    }

    // For Saving Termination
    public function saveTermination(Request $request)
    {
        if ($request->employeeID == $request->deligated) {
            return redirect()->back()->with(['error' => 'Terminated and deligated should not be the same person']);
        }
        $this->authenticateUser('add-termination');
        $employeeID = $request->employeeID;
        $terminationDate = $request->terminationDate;
        $reason = $request->reason;
        $salaryEnrollment = $request->salaryEnrollment;
        $normalDays = $request->normalDays;
        $publicDays = $request->publicDays;
        $noticePay = $request->noticePay;
        $leavePay = $request->leavePay;
        $livingCost = $request->livingCost;
        $houseAllowance = $request->houseAllowance;
        $utilityAllowance = $request->utilityAllowance;
        $leaveAllowance = $request->leaveAllowance;
        $tellerAllowance = $request->tellerAllowance;
        $serevancePay = $request->serevancePay;
        $leaveStand = $request->leaveStand;
        $arrears = $request->arrears;
        $exgracia = $request->exgracia;
        $bonus = $request->bonus;
        $longServing = $request->longServing;
        $salaryAdvance = $request->salaryAdvance;
        $otherDeductions = $request->otherDeductions;
        $otherPayments = $request->otherPayments;
        $employee_actual_salary = $request->employee_actual_salary;
        $loan_balance = $request->loan_balance;
        $nightshift_allowance = $request->nightshift_allowance;
        $transport_allowance = $request->transport_allowance;



        $termination = new Termination();
        $termination->employeeID = $request->employeeID;
        $termination->terminationDate = $request->terminationDate;
        $termination->reason = $request->reason;
        $termination->salaryEnrollment = $request->salaryEnrollment;
        $termination->normalDays = $request->normalDays;
        $termination->publicDays = $request->publicDays;
        $termination->noticePay = $request->noticePay;
        $termination->leavePay = $request->leavePay;
        $termination->livingCost = $request->livingCost;
        $termination->houseAllowance = $request->houseAllowance;
        $termination->utilityAllowance = $request->utilityAllowance;
        $termination->leaveAllowance = $request->leaveAllowance;
        $termination->tellerAllowance = $request->tellerAllowance;
        $termination->serevancePay = $request->serevancePay;
        $termination->leaveStand = $request->leaveStand;
        $termination->arrears = $request->arrears;
        $termination->exgracia = $request->exgracia;
        $termination->transport_allowance = $request->transport_allowance;
        $termination->nightshift_allowance = $request->nightshift_allowance;
        $termination->bonus = $request->bonus;
        $termination->actual_salary = $employee_actual_salary;
        $termination->longServing = $request->longServing;
        $termination->salaryAdvance = $request->salaryAdvance;
        $termination->otherDeductions = $request->otherDeductions;
        $termination->otherPayments = $request->otherPayments;

        $msg = "Employee Termination Benefits have been saved successfully";

        $calendar = $request->terminationDate;
        $datewell = explode("-", $calendar);
        $mm = $datewell[1];
        $dd = $datewell[0];
        $yyyy = $datewell[2];
        $payroll_date = $yyyy . "-" . $mm . "-" . $dd;
        $payroll_month = $yyyy . "-" . $mm;
        $empID = auth()->user()->emp_id;
        $today = date('Y-m-d');

        $normal_days_overtime_amount = ($employee_actual_salary / 176) * 1.5 * $normalDays;
        $public_overtime_amount = ($employee_actual_salary / 176) * 2.0 * $publicDays;

        $total_gross = $salaryEnrollment +
            $normal_days_overtime_amount +
            $public_overtime_amount +
            $noticePay +
            $leavePay +
            $livingCost +
            $houseAllowance +
            $utilityAllowance +
            $leaveAllowance +
            $tellerAllowance +
            $serevancePay +
            $arrears +
            $exgracia +
            $bonus +
            $longServing +
            $transport_allowance +
            $nightshift_allowance +
            $otherPayments;

        //overtime calculation

        //check whether if is after payroll or before payroll
        $check_termination_date = $this->flexperformance_model->check_termination_payroll_date($payroll_month);
        //get employee basic salary
        //$overtime_amount = $this->flexperformance_model->get_overtime($normalDays,$publicDays,$employeeID);
        $overtime_amount = $normal_days_overtime_amount + $public_overtime_amount;

        // if ($check_termination_date == false) {
        $net_pay = 0;
        $take_home = 0;
        // $total_gross = 0;
        $taxable = 0;

        $pension_employer = $this->flexperformance_model->get_pension_employer($salaryEnrollment, $leavePay, $arrears, $overtime_amount, $employeeID);

        $pension_employee = $this->flexperformance_model->get_pension_employee($salaryEnrollment, $leavePay, $arrears, $overtime_amount, $employeeID);

        $total_deductions = $salaryAdvance;
        //+ $otherDeductions

        $net_pay = $total_gross - $total_deductions;

        //$net_pay = $total_gross - $total_deductions;

        // $taxable = ($net_pay - $pension_employee);
        $taxable = ($total_gross - $pension_employee);
        //$taxable = ($taxable < 0) ? -1*$taxable:$taxable;

        $paye1 = DB::table('paye')->where('maximum', '>', $taxable)->where('minimum', '<=', $taxable)->first();

        $deduction_rate = $this->flexperformance_model->get_deduction_rate();

        $paye = $paye1->excess_added + $paye1->rate * ($taxable - $paye1->minimum);
        $take_home = $taxable - $paye;

        $termination->total_gross = $total_gross;
        //wcf and sdl
        $termination->wcf = $total_gross * $deduction_rate['wcf'];
        $termination->sdl = $total_gross * $deduction_rate['sdl'];

        $termination->loan_balance = $loan_balance;

        $termination->taxable = $taxable;
        $termination->normal_days_overtime_amount = $normal_days_overtime_amount;
        $termination->public_overtime_amount = $public_overtime_amount;
        $termination->paye = $paye;
        $termination->pension_employee = $pension_employee;
        $termination->net_pay = $net_pay;
        $termination->take_home = $take_home;
        $termination->total_deductions = $total_deductions;
        $termination->save();

        // $employeeAllowanceLogs = new EmployeeTemporaryAllowance();
        // $employeeAllowanceLogs->terminnationId = $terminationYenyewe->id;


        // $pentionable_amount =$salaryEnrollment + $leavePay + $arrears + overtime_amount;
        // } else {

        //     dd('YES');
        // }
        return redirect('flex/termination')->with('status', $msg);
    }

    // For Aprroving termination
    public function approveTermination($id)
    {
        $this->authenticateUser('confirm-termination');

        $employee = Auth::User()->id;

        $role = UserRole::where('user_id', $employee)->first();
        $role_id = $role->role_id;
        $terminate = Approvals::where('process_name', 'Termination Approval')->first();
        $roles = Role::where('id', $role_id)->first();
        $level = ApprovalLevel::where('role_id', $role_id)->where('approval_id', $terminate->id)->first();
        if ($level) {
            $approval_id = $level->approval_id;
            $approval = Approvals::where('id', $approval_id)->first();

            if ($approval->levels == $level->level_name) {

                $termination = Termination::where('id', $id)->first();
                $employeeID = $termination->employeeID;
                $termination->status = 1;
                $termination->update();

                $this->flexperformance_model->update_employee_termination($id);

                $approval = LeaveApproval::where('empID', $employeeID)->first();
                $approver = Auth()->user()->emp_id;
                $employee = Auth()->user()->position;

                $position = Position::where('id', $employee)->first();

                // chacking level 1
                if ($approval->level1 == $employeeID) {
                    $empID = $request->deligated;
                    // For Deligation
                    if ($request->deligated != null) {
                        $id = Auth::user()->emp_id;

                        $this->attendance_model->save_deligated($leave->empID);

                        $level1 = DB::table('leave_approvals')->Where('level1', $empID)->update(['level1' => $leave->deligated]);
                        $level2 = DB::table('leave_approvals')->Where('level2', $empID)->update(['level2' => $leave->deligated]);
                        $level3 = DB::table('leave_approvals')->Where('level3', $empID)->update(['level3' => $leave->deligated]);
                        // dd($request->deligate);

                    }

                    $leave->status = 3;
                    $leave->state = 0;
                    $leave->level1 = Auth()->user()->emp_id;
                    $leave->position = 'Approved by ' . $position->name;
                    $leave->updated_at = new DateTime();
                    $leave->update();
                } elseif ($approval->level2 == $approver) {

                    // For Deligation
                    if ($leave->deligated != null) {
                        $id = Auth::user()->emp_id;
                        $this->attendance_model->save_deligated($leave->empID);

                        $level1 = DB::table('leave_approvals')->Where('level1', $id)->update(['level1' => $leave->deligated]);
                        $level2 = DB::table('leave_approvals')->Where('level2', $id)->update(['level2' => $leave->deligated]);
                        $level3 = DB::table('leave_approvals')->Where('level3', $id)->update(['level3' => $leave->deligated]);
                        // dd($request->deligate);

                    }
                    $leave->status = 3;
                    $leave->state = 0;
                    $leave->level2 = Auth()->user()->emp_id;
                    $leave->position = 'Approved by ' . $position->name;
                    $leave->updated_at = new DateTime();
                    $leave->update();
                } elseif ($approval->level3 == $approver) {

                    // For Deligation
                    if ($leave->deligated != null) {
                        $id = Auth::user()->emp_id;
                        $this->attendance_model->save_deligated($leave->empID);

                        $level1 = DB::table('leave_approvals')->Where('level1', $id)->update(['level1' => $leave->deligated]);
                        $level2 = DB::table('leave_approvals')->Where('level2', $id)->update(['level2' => $leave->deligated]);
                        $level3 = DB::table('leave_approvals')->Where('level3', $id)->update(['level3' => $leave->deligated]);
                        // dd($request->deligate);

                    }
                    $leave->status = 3;
                    $leave->state = 0;
                    $leave->level3 = Auth()->user()->emp_id;
                    $leave->position = $position->name;
                    $leave->updated_at = new DateTime();
                    $leave->update();
                }

                $msg = 'Employee is Terminated Successfully !';
                return redirect('flex/termination')->with(['success' => $msg]);
            } else {
                // To be upgraded
                $termination = Termination::where('id', $id)->first();
                $termination->status = 'Approved By ' . $roles->name;
                $termination->update();

                $msg = 'Approved By ' . $roles->name;
                return redirect('flex/termination')->with(['success' => $msg]);
            }
        } else {
            $msg = "Failed To Terminate !";
            return redirect('flex/termination')->with(['error' => $msg]);
        }
    }

    // For Cancelling Termination
    public function cancelTermination($id)
    {

        $this->authenticateUser('confirm-termination');
        $promotion = Termination::find($id);

        $promotion->delete();

        return redirect('flex/termination')->with('msg', 'Termination was Cancelled successfully !');
    }

    public function cancelTermination1($id)
    {

        $this->authenticateUser('confirm-termination');
        $promotion = Termination::find($id);

        $delete = $this->flexperformance_model->delete_logs($promotion->employeeID);

        $promotion->delete();

        return redirect('flex/termination')->with('msg', 'Termination was removed successfully !');
    }

    //For Viewing Termination
    public function viewTermination($id)
    {
        $this->authenticateUser('print-termination');
        $termination = Termination::where('id', $id)->first();

        $employee_info = $this->flexperformance_model->userprofile($termination->employeeID);

        $name = $termination->employee->fname . ' ' . $termination->employee->mname . ' ' . $termination->employee->lname;

        $pdf = Pdf::loadView('reports.terminalbenefit2', compact('termination', 'employee_info'));
        // $pdf->setPaper([0, 0, 885.98, 396.85], 'landscape');
        $pdf->setPaper('landscape');
        return $pdf->download('terminal-benefit-slip-for-' . $name . '.pdf');
        //return view('reports.terminalbenefit',compact('termination', 'employee_info'));
        //return view('workforce-management.terminal-balance', compact('termination','employee_info'));
    }

    // For getting employee informations
    public function get_employee_available_info(Request $request)
    {
        $terminationDate = $request->terminationDate;
        $employeeID = $request->employeeID;

        $level1 = DB::table('leave_approvals')->Where('level1', $employeeID)->count();
        $level2 = DB::table('leave_approvals')->Where('level2', $employeeID)->count();
        $level3 = DB::table('leave_approvals')->Where('level3', $employeeID)->count();

        $data['deligate'] = $level1 + $level2 + $level3;

        $leave_entitled = Employee::where('emp_id', $employeeID)->first();

        $calendar = $request->terminationDate;
        $datewell = explode("-", $calendar);
        $mm = $datewell[1];
        $dd = $datewell[2];
        $yyyy = $datewell[0];

        $termination_date = $yyyy . "-" . $mm . "-" . $dd;
        $j_mm = "01";
        $j_dd = "01";
        $january_date = $yyyy . "-" . $j_mm . "-" . $j_dd;
        $termination_month = $yyyy . "-" . $mm;
        $empID = auth()->user()->emp_id;
        $today = date('Y-m-d');

        $employee_allowance = $this->flexperformance_model->get_allowance_names_for_employee($employeeID);


        $check_termination_date = $this->flexperformance_model->check_termination_payroll_date($termination_month);
        if ($check_termination_date == true) {

            $leave_allowance = $this->flexperformance_model->get_leave_allowance($employeeID, $termination_date, $january_date);
            $employee_salary = $this->flexperformance_model->get_employee_salary($employeeID, $termination_date, $dd);
        } else {

            $leave_allowance = $this->flexperformance_model->get_leave_allowance($employeeID, $termination_date, $january_date);
            $employee_salary = $this->flexperformance_model->get_employee_salary($employeeID, $termination_date, $dd);
        }
        $employee_actual_salary = $this->flexperformance_model->get_actual_basic_salary($employeeID);

        $data['leave_entitled'] = $leave_entitled->leave_days_entitled;
        $data['employee_allowance'] = $employee_allowance;
        $data['employee_actual_salary'] = $employee_actual_salary;
        $data['leave_allowance'] = $leave_allowance;
        $data['employee_salary'] = ($employee_actual_salary == $employee_salary) ? ($employee_salary * $dd / 30) : $employee_salary;
        return json_encode($data);
    }
    // end of terminations functions

    // For view promotion/increment
    public function promotion()
    {

        $this->authenticateUser('view-promotions');

        $data['title'] = "Promtion|Increment";
        $data['employees'] = $this->flexperformance_model->Employee();
        $promotions = Promotion::orderBy('created_at', 'desc')->get();
        $i = 1;
        $employee = Auth::User()->id;

        $role = UserRole::where('user_id', $employee)->first();
        $role_id = $role->role_id;
        $terminate = Approvals::where('process_name', 'Promotion Approval')->first();
        $roles = Role::where('id', $role_id)->first();
        $data['level'] = ApprovalLevel::where('role_id', $role_id)->where('approval_id', $terminate->id)->first();

        $data['check'] = 'Approved By ' . $roles->name;
        $data['parent'] = 'Workforce';
        $data['child'] = 'Promotion|Increment';

        return view('workforce-management.promotion-increment', $data, compact('promotions', 'i'));
    }

    // For Viewing Add Promotion page
    public function addPromotion()
    {

        $this->authenticateUser('add-promotion');

        $data['title'] = "Promote Employee";
        $data['my_overtimes'] = $this->flexperformance_model->my_overtimes(auth()->user()->emp_id);
        $data['employees'] = $this->flexperformance_model->employee();
        $data['pdrop'] = Position::all();
        $data['contract'] = $this->flexperformance_model->contractdrop();
        $data['ldrop'] = $this->flexperformance_model->linemanagerdropdown();
        $data['ddrop'] = $this->flexperformance_model->departmentdropdown();

        $data['parent'] = 'Workforce';
        $data['child'] = 'Promote Employee';

        return view('workforce-management.add-promotion', $data);
    }

    // For Save Promotion
    public function savePromotion(Request $request)
    {

        $this->authenticateUser('add-promotion');

        request()->validate(
            [
                'emp_ID' => 'required',
                'newPosition' => 'required',
                'newLevel' => 'required',
                'newSalary' => 'required',
            ]
        );

        $id = $request->emp_ID;
        $empl = Employee::where('emp_id', $id)->first();

        // saving old employee data
        $old = new Promotion();
        $old->employeeID = $id;
        $old->oldSalary = $empl->salary;
        $old->newSalary = $request->newSalary;
        $old->oldPosition = $empl->position;
        $old->newPosition = $request->newPosition;
        $old->oldLevel = $empl->emp_level;
        $old->newLevel = $request->newLevel;
        $old->effective_date = $request->effective_date;
        $old->created_by = Auth::user()->id;
        $old->action = "promoted";
        $old->save();
        // saving new employee data

        SysHelpers::FinancialLogs($id, 'Salary', number_format($empl->salary * $empl->rate, 2), number_format($request->newSalary * $empl->rate, 2), 'Salary Increment');

        // $promotion =Employee::where('emp_id',$id)->first();
        // $promotion->position=$request->newPosition;
        // $promotion->salary=$request->newSalary;
        // $promotion->emp_level=$request->newLevel;
        // $promotion->update();

        $msg = "Employee Promotion has been saved successfully";
        return redirect('flex/promotion')->with('msg', $msg);
    }

    // For Approve Promotion
    public function approvePromotion($id)
    {

        $this->authenticateUser('add-promotion');

        $employee = Auth::User()->id;
        $role = UserRole::where('user_id', $employee)->first();
        $role_id = $role->role_id;
        $terminate = Approvals::where('process_name', 'Promotion Approval')->first();
        $roles = Role::where('id', $role_id)->first();
        $level = ApprovalLevel::where('role_id', $role_id)->where('approval_id', $terminate->id)->first();
        if ($level) {
            $approval_id = $level->approval_id;
            $approval = Approvals::where('id', $approval_id)->first();

            if ($approval->levels == $level->level_name) {

                $promotion = Promotion::where('id', $id)->first();

                // dd($promotion);
                $promotion->status = "Successful";
                $promotion->update();

                $increment = Employee::where('emp_id', $promotion->employeeID)->first();
                $increment->salary = $promotion->newSalary;
                $increment->position = $promotion->newPosition;
                $increment->emp_level = $promotion->newLevel;
                $increment->update();
                $msg = 'Employee Promotion is Confirmed Successfully !';
                return redirect('flex/promotion')->with('msg', $msg);
            } else {
                $promotion = Promotion::where('id', $id)->first();
                $promotion->status = 'Approved By ' . $roles->name;
                $promotion->update();

                $msg = 'Approved By ' . $roles->name;
                return redirect('flex/promotion')->with('msg', $msg);
            }
        } else {
            $msg = "Failed To Promote !";
            return redirect('flex/promotion')->with('msg', $msg);
        }
    }

    // For Cancel Promotion
    public function cancelPromotion($id)
    {

        $this->authenticateUser('edit-promotion');
        $promotion = Promotion::find($id);

        $promotion->delete();

        return redirect('flex/promotion')->with('msg', 'Promotion was Canceled successfully !');
    }

    use Importable;
    public function addBulkIncrement(Request $request)
    {

        $data1 = Excel::import(new ImportSalaryIncrement, $request->file('file')->store('files'));

        $msg = "Employee Salary  Incremention and Arrears has been requested successfully !";
        return redirect('flex/promotion')->with('success', $msg);
    }

    // For Add Increment Page
    public function addIncrement()
    {

        $this->authenticateUser('add-increment');

        $data['title'] = "Increment Salary";
        $data['my_overtimes'] = $this->flexperformance_model->my_overtimes(auth()->user()->emp_id);
        $data['employees'] = $this->flexperformance_model->employee();
        $data['pdrop'] = $this->flexperformance_model->positiondropdown();
        $data['contract'] = $this->flexperformance_model->contractdrop();
        $data['ldrop'] = $this->flexperformance_model->linemanagerdropdown();
        $data['ddrop'] = $this->flexperformance_model->departmentdropdown();

        $data['parent'] = 'Workforce';
        $data['child'] = 'Increment Salary';

        return view('workforce-management.add-increment', $data);
    }

    // For Save Increment Function
    public function saveIncrement(Request $request)
    {

        $this->authenticateUser('add-increment');

        request()->validate(
            [
                'emp_ID' => 'required',
                'newSalary' => 'required',
                'oldSalary' => 'required',
                'oldRate' => 'required',
            ]
        );

        $oldSalary = $request->oldSalary;
        $oldRate = $request->oldRate;

        $id = $request->emp_ID;
        //dd($id);
        $empl = Employee::where('emp_id', $id)->first();

        // saving old employee data
        $old = new Promotion();
        $old->employeeID = $id;
        $old->oldSalary = $empl->salary;
        $old->newSalary = $request->newSalary;
        $old->oldPosition = $empl->position;
        $old->newPosition = $empl->position;
        $old->oldLevel = $empl->emp_level;
        $old->newLevel = $empl->emp_level;
        $old->effective_date = $empl->effective_date;
        $old->created_by = Auth::user()->id;
        $old->action = "incremented";

        $old->save();

        SysHelpers::FinancialLogs($id, 'Salary', number_format($oldSalary * $oldRate, 2), number_format($request->newSalary * $oldRate, 2), 'Salary Increment');

        $msg = "Employee Salary  Incremention has been requested successfully !";
        return redirect('flex/promotion')->with('msg', $msg);
    }

    // fetching employee department's positions
    public function getDetails($id = 0)
    {
        $data = EMPL::where('emp_id', $id)->with('position')->first();
        return response()->json($data);
    }

    // start of reconcilliation summary
    public function reconcilliationSummary()
    {
        return view('reports.temp_reconciliation');
    }
    // end of reconcilliation summary

    //start of education qualifications
    public function addQualification(Request $request)
    {

        request()->validate(
            [
                // 'employeeID' => 'required',
                'level' => 'required',
                'course' => 'required',
                'institute' => 'required',
                'start_year' => 'required',
                'finish_year' => 'required',
            ]
        );

        $id = $request->employeeID;

        $qualification = new EducationQualification();
        $qualification->employeeID = $id;
        $qualification->institute = $request->institute;
        $qualification->level = $request->level;
        $qualification->course = $request->course;
        $qualification->start_year = $request->start_year;
        $qualification->end_year = $request->finish_year;

        if ($request->hasfile('image')) {
            $request->validate([
                'image' => 'required|clamav',
            ]);
            $request->validate([
                'image' => 'required|image|mimes:pdf|max:5048',
            ]);

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/certificates/', $filename);
            $qualification->certificate = $filename;
        }
        $qualification->save();

        $msg = "Education Qualification has been added successfully";
        return redirect('flex/userprofile/' . base64_encode($id))->with('msg', $msg);
    }
    // end of education qualifications

    // start of grievances
    public function grievancesComplains()
    {

        $this->authenticateUser('view-grivance');

        $data['title'] = "Grievances|Disciplinary";
        $data['employees'] = $this->flexperformance_model->Employee();
        $promotions = Promotion::orderBy('created_at', 'desc')->get();
        $i = 1;
        $data['parent'] = 'Workforce';
        $data['child'] = 'Disciplinary Actions';
        $data['actions'] = Disciplinary::orderBy('created_at', 'desc')->get();

        return view('workforce-management.grievances-complains', $data, compact('promotions', 'i'));
    }

    // For add complain page
    public function addComplain(Request $request)
    {

        return view('workforce-management.add-complain');
    }

    // start of add disciplinary function
    public function addDisciplinary(Request $request)
    {

        $this->authenticateUser('view-grivance');
        // $id=Auth::user()->emp_id;
        $data['employees'] = EMPL::all();

        return view('workforce-management.add-disciplinary', $data);
    }
    // end of add discipllinary function

    // start of save disciplinary action
    public function saveDisciplinary(Request $request)
    {

        $this->authenticateUser('add-grivance');
        request()->validate(
            [
                'employeeID' => 'required',
            ]
        );

        $id = $request->employeeID;

        $emp = EMPL::where('emp_id', $id)->first();
        $department = $emp->department;

        // dd($emp);

        $disciplinary = new Disciplinary();
        $disciplinary->employeeID = $id;
        $disciplinary->department = $department;
        $disciplinary->suspension = $request->suspension;
        $disciplinary->date_of_charge = $request->date_of_charge;
        $disciplinary->detail_of_charge = $request->charge_description;
        $disciplinary->date_of_hearing = $request->date_of_hearing;
        $disciplinary->detail_of_hearing = $request->hearing_description;
        $disciplinary->findings = $request->findings;
        $disciplinary->recommended_sanctum = $request->recommended_sanctum;
        $disciplinary->final_decission = $request->final_decission;

        //new fields
        $disciplinary->appeal_received_by = $request->appeal_received_by;
        $disciplinary->date_of_receiving_appeal = $request->date_of_receiving_appeal;
        $disciplinary->appeal_reasons = $request->appeal_reasons;
        $disciplinary->appeal_findings = $request->appeal_findings;
        $disciplinary->appeal_outcomes = $request->appeal_outcomes;

        $disciplinary->save();

        $msg = "Disciplinary Action Has been save Successfully !";
        return redirect('flex/grievancesCompain')->with('msg', $msg);
    }
    // end of save disciplinary action

    // start of view single displinary action
    public function viewDisciplinary(Request $request, $id)
    {

        $this->authenticateUser('view-grivance');
        $did = base64_decode($id);

        $data['title'] = "Employee";

        $data['actions'] = Disciplinary::where('id', $did)->with('employee')->with('departments')->get();

        return view('workforce-management.view-action', $data);
    }
    // end of view single displinary action

    // start of edit disciplinary action
    public function editDisciplinary(Request $request, $id)
    {

        $this->authenticateUser('edit-grivance');
        $did = base64_decode($id);

        $data['title'] = "Employee";

        $data['actions'] = Disciplinary::where('id', $did)->with('employee')->with('departments')->get();

        return view('workforce-management.edit-action', $data);
    }
    // end of edit disciplinary action

    // start of update disciplinary action
    public function updateDisciplinary(Request $request)
    {

        $this->authenticateUser('edit-grivance');
        // request()->validate(
        //     [
        //     'employeeID' => 'required',
        //      ]
        //     );

        $id = $request->id;
        $disciplinary = Disciplinary::where('id', $id)->first();
        $disciplinary->suspension = $request->suspension;
        $disciplinary->date_of_charge = $request->date_of_charge;
        $disciplinary->detail_of_charge = $request->charge_description;
        $disciplinary->date_of_hearing = $request->date_of_hearing;
        $disciplinary->detail_of_hearing = $request->hearing_description;
        $disciplinary->findings = $request->findings;
        $disciplinary->recommended_sanctum = $request->recommended_sanctum;
        $disciplinary->final_decission = $request->final_decission;
        $disciplinary->update();
        $emp = base64_encode($id);
        $data['title'] = "Employee";

        $data['actions'] = Disciplinary::where('id', $id)->with('employee')->with('departments')->get();

        $msg = "Disciplinary Action Has been Updated Successfully !";
        // return redirect('flex/view-action/'.$emp,$data)->with('msg', $msg);
        return view('workforce-management.view-action', $data)->with('msg', $msg);
    }
    // end of update disciplinary action

    public function saveComplain(Request $request)
    {

        request()->validate(
            [
                'employeeID' => 'required',
                'description' => 'required',
            ]
        );

        $id = $request->employeeID;

        $complain = new EmployeeComplain();
        $complain->employeeID = $id;
        $complain->description = $request->description;
        $complain->save();

        $msg = "Your Disciplinary Action Has been save Successfully !";
        return redirect('flex/grievancesCompain')->with('msg', $msg);
    }

    // end of grievances

    // start of profile (employee biodata)
    public function viewProfile(Request $request, $id)
    {

        $empID = base64_decode($id);

        if (auth()->user()->emp_id != $empID) {
            $this->authenticateUser('edit-employee');
        }

        $data['employee'] = $this->flexperformance_model->userprofile($empID);
        $data['title'] = "Employee";
        $data['pdrop'] = Position::all();
        $data['bdrop'] = BankBranch::all();
        $data['contract'] = $this->flexperformance_model->contractdrop();
        $data['ldrop'] = $this->flexperformance_model->linemanagerdropdown();
        $data['ddrop'] = $this->flexperformance_model->departmentdropdown();
        $data['countrydrop'] = $this->flexperformance_model->nationality();
        $data['branchdrop'] = $this->flexperformance_model->branchdropdown();

        $data['pension'] = $this->flexperformance_model->pension_fund();

        $details = EmployeeDetail::where('employeeID', $empID)->first();

        $emergency = EmergencyContact::where('employeeID', $empID)->first();

        $children = EmployeeDependant::where('employeeID', $empID)->get();

        $spouse = EmployeeSpouse::where('employeeID', $empID)->first();

        $parents = EmployeeParent::where('employeeID', $empID)->get();

        $data['qualifications'] = EducationQualification::where('employeeID', $empID)->orderBy('end_year', 'desc')->get();

        $data['certifications'] = ProfessionalCertification::where('employeeID', $empID)->orderBy('cert_end', 'desc')->get();

        $data['histories'] = EmploymentHistory::where('employeeID', $empID)->orderBy('hist_end', 'desc')->get();

        $data['salaryTransfer'] = $this->flexperformance_model->pendingSalaryTranferCheck($empID);

        $data['positionTransfer'] = $this->flexperformance_model->pendingPositionTranferCheck($empID);
        $data['departmentTransfer'] = $this->flexperformance_model->pendingDepartmentTranferCheck($empID);

        $data['branchTransfer'] = $this->flexperformance_model->pendingBranchTranferCheck($empID);
        $data['employees'] = $this->flexperformance_model->Employee();
        $data['parent'] = 'Employee';
        $data['child'] = 'Update employee';
        $data['employees'] = $this->flexperformance_model->Employee();

        // return view('employee.updateEmployee', $data);
        return view('employee.employee-profile', $data, compact('details', 'emergency', 'spouse', 'children', 'parents'));
    }
    // end of profile

    //start of update employee biodata detail

    public function updateEmployeeDetails(Request $request)
    {

        request()->validate(
            [

                // start of name information validation
                'employeeID' => 'required',
                'fname' => 'required',
                'mname' => 'nullable',
                'lname' => 'required',
                'maide_name' => 'nullable',

                // start of biographical informations
                'bithdate' => 'nullable',
                'country_of_birth' => 'nullable',
                'gender' => 'nullable',
                // 'martial' => 'nullable',
                'religion' => 'nullable',

                // Address Information
                'physical_address' => 'nullable',
                'landmark' => 'nullable',

                // Start of Personal Identification details
                'TIN' => 'nullable',
                'NIDA' => 'nullable',
                'passport' => 'nullable|regex:/^[A-Za-z0-9 ]+$/',
                'pension' => 'nullable',
                'HELSB' => 'nullable',

                // Start of Emmegence Contact

                'em_fname' => 'nullable',
                'em_mname' => 'nullable',
                'spouse_birthplace' => 'nullable',
                'em_relationship' => 'nullable',
                'em_ocupation' => 'nullable',
                'em_phone' => 'nullable:numeric',

                // Start of Employment Details
                'employment_date' => 'nullable',
                'former_title' => 'nullable',
                'current_title' => 'nullable',
                'department' => 'nullable',
                'line_manager' => 'nullable|regex:/^[A-Za-z0-9 ]+$/',
                'hod' => 'nullable|regex:/^[A-Za-z0-9 ]+$/',
                'employee_status' => 'nullable|regex:/^[A-Za-z0-9 ]+$/',

                // start of spouse details
                'spouse_name' => 'nullable',
                'spouse_birthdate' => 'nullable',
                'spouse_birthplace' => 'nullable',
                'spouse_nationality' => 'nullable',
                'spouse_employer' => 'nullable',
                'spouse_job_title' => 'nullable',
                'spouse_medical_status' => 'nullable|regex:/^[A-Za-z0-9 ]+$/',

                // start of children details
                'dep_name' => 'nullable',
                'dep_surname' => 'nullable',

                //start of parent details
                'parent_names' => 'nullable',
                'parent_relation' => 'nullable',
                'parent_living_status' => 'nullable|regex:/^[A-Za-z0-9 ]+$/',
                'parent_residence' => 'nullable|regex:/^[A-Za-z0-9 ]+$/',

                //start of academic details
                'institute' => 'nullable',
                'level' => 'nullable',
                'parent_living_status' => 'nullable',

                //profesional qualification
                'cert_start' => 'nullable|numeric',
                'cert_end' => 'nullable|numeric',
                'cert_name' => 'nullable',

                'cert_qualification' => 'nullable',
                'cert_name' => 'nullable',
                'cert_number' => 'nullable|regex:/^[A-Za-z0-9 ]+$/',
                'cert_status' => 'nullable',

                //employment history
                'hist_start' => 'nullable|numeric',
                'hist_end' => 'nullable|numeric',
                'hist_employer' => 'nullable',

                'hist_industry' => 'nullable',
                'hist_position' => 'nullable',
                'hist_reason' => 'nullable',
                'cert_status' => 'nullable',

                // start of former works
            ]
        );

        $id = $request->employeeID;

        if (auth()->user()->emp_id != $id) {
            $this->authenticateUser('edit-employee');
        }

        // dd($request->landmark);
        $empl = Employee::where('emp_id', $id)->first();

        if ($empl) {
            // updating employee data
            $employee = Employee::where('emp_id', $id)->first();
            $employee->fname = $request->fname;
            $employee->mname = $request->mname;
            $employee->lname = $request->lname;
            $employee->mobile = $request->mobile;
            $employee->line_manager = $request->line_manager;
            $employee->job_title = $request->current_job;
            $employee->gender = $request->gender;
            $employee->birthdate = $request->birthdate;
            $employee->merital_status = $request->merital;

            // dd($request->current_job);
            $employee->national_id = $request->NIDA;
            $employee->form_4_index = $request->HELSB;
            // $employee->pension_fund = $request->pension_fund;
            $employee->physical_address = $request->physical_address;
            $employee->update();

            // Start of Employee Details
            $profile = EmployeeDetail::where('employeeID', $id)->first();

            if ($profile) {

                $profile->marriage_date = $request->marriage_date;
                $profile->maide_name = $request->maide_name;
                $profile->birthplace = $request->birthplace;
                $profile->birthcountry = $request->birthcountry;
                $profile->religion = $request->religion;
                $profile->employeeID = $request->employeeID;
                $profile->passport_number = $request->passport_number;
                $profile->landmark = $request->landmark;
                $profile->prefix = $request->prefix;
                $profile->former_title = $request->former_title;
                $profile->divorced_date = $request->divorced_date;

                $profile->update();
            } else {
                $profile = new EmployeeDetail();
                $profile->prefix = $request->prefix;
                $profile->maide_name = $request->maide_name;
                $profile->birthplace = $request->birthplace;
                $profile->birthcountry = $request->birthcountry;
                $profile->religion = $request->religion;
                $profile->employeeID = $request->employeeID;
                $profile->passport_number = $request->passport_number;
                $profile->former_title = $request->former_title;
                $profile->divorced_date = $request->divorced_date;
                $profile->marriage_date = $request->marriage_date;
                $profile->save();
            }

            if ($request->image != null) {
                $user = $request->empID;

                $employee = Employee::where('emp_id', $user)->first();
                if ($request->hasfile('image')) {
                    $request->validate([
                        'image' => 'required|image|mimes:jpg,png,jpeg,pdf|max:5048',
                    ]);
                    $newImageName = $request->image->hashName();

                    Storage::disk('public')->put('profile/' . $newImageName, file_get_contents($request->image));
                    $employee->photo = $newImageName;
                }
                // saving data
                $employee->update();
            }
        }

        $msg = "Employee Details Have Been Updated successfully";
        return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
    }

    public function updateSpecificEmployeeDetails(Request $request)
    {

        request()->validate(
            [
                // Start of Employment Details
                'employment_date' => 'nullable',
                'former_title' => 'nullable',
                'current_title' => 'nullable',
                'line_manager' => 'nullable|regex:/^[A-Za-z0-9 ]+$/',
            ]
        );

        $id = $request->employeeID;

        if (auth()->user()->emp_id != $id) {
            $this->authenticateUser('edit-employee');
        }

        // dd($request->landmark);
        $empl = Employee::where('emp_id', $id)->first();

        if ($empl) {
            // updating employee data
            $employee = Employee::where('emp_id', $id)->first();
            $employee->line_manager = $request->line_manager;
            $employee->update();

            // Start of Employee Details
            $profile = EmployeeDetail::where('employeeID', $id)->first();

            if ($profile) {
                $profile->former_title = $request->former_title;
                $profile->update();
            } else {
                $profile = new EmployeeDetail();
                $profile->former_title = $request->former_title;

                $profile->save();
            }
        }

        $msg = "Employee Details Have Been Updated successfully";
        return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
    }

    public function employeeBasicDetails(Request $request)
    {
        request()->validate(
            [

                // start of name information validation
                'employeeID' => 'required',
                'fname' => 'required',
                'mname' => 'nullable',
                'lname' => 'required',
                'maide_name' => 'nullable',
                'prefix' => 'nullable',
            ]
        );

        $id = $request->employeeID;

        if (auth()->user()->emp_id != $id) {
            $this->authenticateUser('edit-employee');
        }

        // dd($request->landmark);
        $empl = Employee::where('emp_id', $id)->first();

        if ($empl) {
            // updating employee data
            $employee = Employee::where('emp_id', $id)->first();
            $employee->fname = $request->fname;
            $employee->mname = $request->mname;
            $employee->lname = $request->lname;
            //$employee->mobile = $request->mobile;
            // $employee->line_manager = $request->line_manager;
            // $employee->job_title = $request->current_job;
            // $employee->gender = $request->gender;
            // $employee->birthdate = $request->birthdate;
            // $employee->merital_status = $request->merital;

            // dd($request->current_job);
            // $employee->national_id = $request->NIDA;
            // $employee->form_4_index = $request->HELSB;
            // $employee->pension_fund = $request->pension_fund;
            // $employee->physical_address = $request->physical_address;
            $employee->update();
            $autheniticateduser = auth()->user()->emp_id;

            $auditLog = SysHelpers::AuditLog(1, "Employee Details with Employee Id .$employee->emp_id. are Updated by Employee Id " . $autheniticateduser, $request);

            // Start of Employee Details
            $profile = EmployeeDetail::where('employeeID', $id)->first();

            if ($profile) {

                // $profile->marriage_date = $request->marriage_date;
                $profile->maide_name = $request->maide_name;
                // $profile->birthplace = $request->birthplace;
                // $profile->birthcountry = $request->birthcountry;
                // $profile->religion = $request->religion;
                $profile->employeeID = $request->employeeID;
                // $profile->passport_number = $request->passport_number;
                // $profile->landmark = $request->landmark;
                $profile->prefix = $request->prefix;
                // $profile->former_title = $request->former_title;
                // $profile->divorced_date = $request->divorced_date;

                $profile->update();
            } else {
                $profile = new EmployeeDetail();
                $profile->prefix = $request->prefix;
                // $profile->maide_name = $request->maide_name;
                // $profile->birthplace = $request->birthplace;
                // $profile->birthcountry = $request->birthcountry;
                // $profile->religion = $request->religion;
                $profile->employeeID = $request->employeeID;
                // $profile->passport_number = $request->passport_number;
                // $profile->former_title = $request->former_title;
                // $profile->divorced_date = $request->divorced_date;
                // $profile->marriage_date = $request->marriage_date;
                $profile->save();
            }

            $msg = "Employee Details Have Been Updated successfully";
            return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
        }
    }

    public function employeeAddressDetails(Request $request)
    {
        // request()->validate(
        //     [

        //         // start of name information validation
        //         'mname' => 'nullable',
        //         'maide_name' => 'nullable',
        //         'prefix' => 'nullable',
        //         'bithdate' => 'nullable',
        //     ]);

        $id = $request->employeeID;

        if (auth()->user()->emp_id != $id) {
            $this->authenticateUser('edit-employee');
        }

        // dd($request->landmark);
        $empl = Employee::where('emp_id', $id)->first();

        if ($empl) {
            // updating employee data
            $employee = Employee::where('emp_id', $id)->first();
            // $employee->fname = $request->fname;
            // $employee->mname = $request->mname;
            // $employee->lname = $request->lname;
            $employee->mobile = $request->mobile;
            // $employee->line_manager = $request->line_manager;
            // $employee->job_title = $request->current_job;
            //   $employee->gender = $request->gender;
            //   $employee->birthdate = $request->birthdate;
            //   $employee->merital_status = $request->merital;

            // $employee->national_id = $request->NIDA;
            // $employee->form_4_index = $request->HELSB;
            // $employee->pension_fund = $request->pension_fund;
            $employee->physical_address = $request->physical_address;
            $employee->update();

            // Start of Employee Details
            $profile = EmployeeDetail::where('employeeID', $id)->first();

            if ($profile) {

                //$profile->marriage_date = $request->marriage_date;
                //$profile->maide_name = $request->maide_name;
                //   $profile->birthplace = $request->birthplace;
                //   $profile->birthcountry = $request->birthcountry;
                //   $profile->religion = $request->religion;
                // $profile->employeeID = $request->employeeID;
                // $profile->passport_number = $request->passport_number;
                $profile->landmark = $request->landmark;
                // $profile->prefix = $request->prefix;
                // $profile->former_title = $request->former_title;
                //  $profile->divorced_date = $request->divorced_date;

                $profile->update();
            } else {
                $profile = new EmployeeDetail();
                //$profile->prefix = $request->prefix;
                // $profile->maide_name = $request->maide_name;
                //   $profile->birthplace = $request->birthplace;
                //   $profile->birthcountry = $request->birthcountry;
                //   $profile->religion = $request->religion;
                $profile->employeeID = $request->employeeID;
                // $profile->passport_number = $request->passport_number;
                // $profile->former_title = $request->former_title;
                //  $profile->divorced_date = $request->divorced_date;
                //  $profile->marriage_date = $request->marriage_date;
                $profile->save();
            }
            $msg = "Employee Details Have Been Updated successfully";
            return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
        }
    }

    public function employeePersonDetails(Request $request)
    {
        // request()->validate(
        //     [

        //         // start of name information validation
        //         'mname' => 'nullable',
        //         'maide_name' => 'nullable',
        //         'prefix' => 'nullable',
        //         'bithdate' => 'nullable',
        //     ]);

        $id = $request->employeeID;

        if (auth()->user()->emp_id != $id) {
            $this->authenticateUser('edit-employee');
        }

        // dd($request->landmark);
        $empl = Employee::where('emp_id', $id)->first();

        if ($empl) {
            // updating employee data
            $employee = Employee::where('emp_id', $id)->first();
            // $employee->fname = $request->fname;
            // $employee->mname = $request->mname;
            // $employee->lname = $request->lname;
            // $employee->mobile = $request->mobile;
            // $employee->line_manager = $request->line_manager;
            // $employee->job_title = $request->current_job;
            //   $employee->gender = $request->gender;
            //   $employee->birthdate = $request->birthdate;
            //   $employee->merital_status = $request->merital;

            $employee->national_id = $request->NIDA;
            $employee->tin = $request->TIN;
            $employee->pf_membership_no = $request->pension;
            $employee->form_4_index = $request->HESLB;
            //  $employee->physical_address = $request->physical_address;
            $employee->update();

            // Start of Employee Details
            $profile = EmployeeDetail::where('employeeID', $id)->first();

            if ($profile) {

                //$profile->marriage_date = $request->marriage_date;
                //$profile->maide_name = $request->maide_name;
                //   $profile->birthplace = $request->birthplace;
                //   $profile->birthcountry = $request->birthcountry;
                //   $profile->religion = $request->religion;
                $profile->employeeID = $request->employeeID;
                $profile->passport_number = $request->passport_number;
                // $profile->landmark = $request->landmark;
                // $profile->prefix = $request->prefix;
                // $profile->former_title = $request->former_title;
                //  $profile->divorced_date = $request->divorced_date;

                $profile->update();
            } else {
                $profile = new EmployeeDetail();
                //$profile->prefix = $request->prefix;
                // $profile->maide_name = $request->maide_name;
                //   $profile->birthplace = $request->birthplace;
                //   $profile->birthcountry = $request->birthcountry;
                //   $profile->religion = $request->religion;
                $profile->employeeID = $request->employeeID;
                $profile->passport_number = $request->passport_number;
                // $profile->former_title = $request->former_title;
                //  $profile->divorced_date = $request->divorced_date;
                //  $profile->marriage_date = $request->marriage_date;
                $profile->save();
            }
            $msg = "Employee Details Have Been Updated successfully";
            return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
        }
    }

    public function employeeBioDetails(Request $request)
    {
        // dd($request);
        // request()->validate(
        //     [

        //         // start of name information validation
        //         'mname' => 'nullable',
        //         'maide_name' => 'nullable',
        //         'prefix' => 'nullable',
        //         'bithdate' => 'nullable',
        //     ]);

        $id = $request->employeeID;

        if (auth()->user()->emp_id != $id) {
            $this->authenticateUser('edit-employee');
        }

        // dd($request->landmark);
        $empl = Employee::where('emp_id', $id)->first();

        if ($empl) {
            // updating employee data
            $employee = Employee::where('emp_id', $id)->first();
            // $employee->fname = $request->fname;
            // $employee->mname = $request->mname;
            // $employee->lname = $request->lname;
            //$employee->mobile = $request->mobile;
            // $employee->line_manager = $request->line_manager;
            // $employee->job_title = $request->current_job;
            $employee->gender = $request->gender;
            $employee->birthdate = $request->birthdate;
            $employee->merital_status = $request->merital;

            // $employee->national_id = $request->NIDA;
            // $employee->form_4_index = $request->HELSB;
            // $employee->pension_fund = $request->pension_fund;
            // $employee->physical_address = $request->physical_address;
            $employee->update();

            // Start of Employee Details
            $profile = EmployeeDetail::where('employeeID', $id)->first();

            if ($profile) {

                $profile->marriage_date = $request->marriage_date;
                //$profile->maide_name = $request->maide_name;
                $profile->birthplace = $request->birthplace;
                $profile->birthcountry = $request->birthcountry;
                $profile->religion = $request->religion;
                // $profile->employeeID = $request->employeeID;
                // $profile->passport_number = $request->passport_number;
                // $profile->landmark = $request->landmark;
                // $profile->prefix = $request->prefix;
                // $profile->former_title = $request->former_title;
                $profile->divorced_date = $request->divorced_date;

                $profile->update();
            } else {
                $profile = new EmployeeDetail();
                //$profile->prefix = $request->prefix;
                // $profile->maide_name = $request->maide_name;
                $profile->birthplace = $request->birthplace;
                $profile->birthcountry = $request->birthcountry;
                $profile->religion = $request->religion;
                //  $profile->employeeID = $request->employeeID;
                // $profile->passport_number = $request->passport_number;
                // $profile->former_title = $request->former_title;
                $profile->divorced_date = $request->divorced_date;
                $profile->marriage_date = $request->marriage_date;
                $profile->save();
            }
            $msg = "Employee Details Have Been Updated successfully";
            return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
        }
    }

    public function employeeDetails(Request $request)
    {
        $id = $request->employeeID;

        // Start of Employee Details
        $profile = EmployeeDetail::where('employeeID', $id)->first();

        if ($profile) {

            $profile->marriage_date = $request->marriage_date;
            $profile->maide_name = $request->maide_name;
            $profile->birthplace = $request->birthplace;
            $profile->birthcountry = $request->birthcountry;
            $profile->religion = $request->religion;
            $profile->employeeID = $request->employeeID;
            $profile->passport_number = $request->passport_number;
            $profile->landmark = $request->landmark;
            $profile->prefix = $request->prefix;
            $profile->former_title = $request->former_title;
            $profile->divorced_date = $request->divorced_date;

            $profile->update();
        } else {
            $profile = new EmployeeDetail();
            $profile->prefix = $request->prefix;
            $profile->maide_name = $request->maide_name;
            $profile->birthplace = $request->birthplace;
            $profile->birthcountry = $request->birthcountry;
            $profile->religion = $request->religion;
            $profile->employeeID = $request->employeeID;
            $profile->passport_number = $request->passport_number;
            $profile->former_title = $request->former_title;
            $profile->divorced_date = $request->divorced_date;
            $profile->marriage_date = $request->marriage_date;
            $profile->save();
        }

        $msg = "Employee Details Have Been Updated successfully";
        return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
    }

    public function employeeEmergency(Request $request)
    {
        $id = $request->employeeID;

        $emergency = EmergencyContact::where('employeeID', $id)->first();

        if ($emergency) {

            $emergency->employeeID = $request->employeeID;
            $emergency->em_fname = $request->em_fname;
            $emergency->em_mname = $request->em_mname;
            $emergency->em_sname = $request->em_lname;
            $emergency->em_relationship = $request->em_relationship;
            $emergency->em_occupation = $request->em_occupation;
            $emergency->em_phone = $request->em_phone;
            $emergency->update();
        } else {
            $emergency = new EmergencyContact();
            $emergency->employeeID = $request->employeeID;
            $emergency->em_fname = $request->em_fname;
            $emergency->em_mname = $request->em_mname;
            $emergency->em_sname = $request->em_lname;
            $emergency->em_relationship = $request->em_relationship;
            $emergency->em_occupation = $request->em_occupation;
            $emergency->em_phone = $request->em_phone;
            $emergency->save();
        }

        $msg = "Employee Details Have Been Updated successfully";
        return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
    }

    public function employeeParent(Request $request)
    {
        $empID = $request->employeeID;
        $parent = EmployeeParent::where('employeeID', $empID)
            ->Where('parent_relation', 'LIKE', $request->parent_relation)
            ->where('parent_birthdate', 'LIKE', $request->parent_birthdate)
            ->first();

        if ($parent) {
            $parent->employeeID = $request->employeeID;
            $parent->parent_names = $request->parent_names;
            $parent->parent_relation = $request->parent_relation;
            $parent->parent_birthdate = $request->parent_birthdate;
            $parent->parent_residence = $request->parent_residence;
            $parent->parent_living_status = $request->parent_living_status;

            $parent->update();
        } else {
            if ($request->parent_names != null && $request->parent_relation != null) {
                $parent = new EmployeeParent();

                $parent->employeeID = $request->employeeID;
                $parent->parent_names = $request->parent_names;
                $parent->parent_relation = $request->parent_relation;
                $parent->parent_birthdate = $request->parent_birthdate;
                $parent->parent_residence = $request->parent_residence;
                $parent->parent_living_status = $request->parent_living_status;

                $parent->save();
            }
        }
        $msg = "Employee Details Have Been Updated successfully";
        return redirect('flex/employee-profile/' . base64_encode($empID))->with('msg', $msg);
    }

    public function employeeDependant(Request $request)
    {
        // Start of dependants details
        $emp_id = $request->employeeID;

        // Check if the dependant already exists with the same details
        $existingDependant = EmployeeDependant::where('employeeID', $emp_id)
            ->where('dep_name', $request->dep_name)
            ->where('dep_surname', $request->dep_surname)
            ->where('dep_birthdate', $request->dep_birthdate)
            ->where('dep_gender', $request->dep_gender)
            ->where('dep_certificate', $request->dep_certificate)
            ->first();

        if ($existingDependant) {
            $msg = "Dependant with the same details already exists.";
            return redirect('flex/employee-profile/' . base64_encode($emp_id))->with('msg', $msg);
        } else {
            // Create a new dependant if it doesn't exist
            $dependant = new EmployeeDependant();
            $dependant->employeeID = $emp_id; // Set the employee ID
            $dependant->dep_name = $request->dep_name;
            $dependant->dep_surname = $request->dep_surname;
            $dependant->dep_birthdate = $request->dep_birthdate;
            $dependant->dep_gender = $request->dep_gender;
            $dependant->dep_certificate = $request->dep_certificate;

            $dependant->save();

            $msg = "Dependant added successfully.";
            return redirect('flex/employee-profile/' . base64_encode($emp_id))->with('msg', $msg);
        }
    }
    public function employeeSpouse(Request $request)
    {

        $id = $request->employeeID;

        // start of spouse details
        $spouse = EmployeeSpouse::where('employeeID', $id)->first();

        if ($spouse) {

            $spouse->employeeID = $request->employeeID;
            $spouse->spouse_fname = $request->spouse_name;
            $spouse->spouse_birthdate = $request->spouse_birthdate;
            $spouse->spouse_birthplace = $request->spouse_birthplace;
            $spouse->spouse_birthcountry = $request->spouse_birthcountry;
            $spouse->spouse_nationality = $request->spouse_nationality;
            $spouse->spouse_passport = $request->spouse_passport;
            $spouse->spouse_employer = $request->spouse_employer;
            $spouse->spouse_job_title = $request->spouse_job_title;
            $spouse->spouse_nida = $request->spouse_nida;
            $spouse->update();
        } else {
            $spouse = new EmployeeSpouse();

            $spouse->employeeID = $request->employeeID;
            $spouse->spouse_fname = $request->spouse_name;
            $spouse->spouse_birthdate = $request->spouse_birthdate;
            $spouse->spouse_birthplace = $request->spouse_birthplace;
            $spouse->spouse_birthcountry = $request->spouse_birthcountry;
            $spouse->spouse_nationality = $request->spouse_nationality;
            $spouse->spouse_passport = $request->spouse_passport;
            $spouse->spouse_employer = $request->spouse_employer;
            $spouse->spouse_job_title = $request->spouse_job_title;
            $spouse->spouse_nida = $request->spouse_nida;

            $spouse->save();
        }
        $msg = "Employee Details Have Been Updated successfully";
        return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
    }

    public function employeeHistory(Request $request)
    {
        $id = $request->employeeID;
        if ($request->hist_employer != null && $request->hist_position != null) {
            $history = new EmploymentHistory();

            $history->employeeID = $request->employeeID;
            $history->hist_start = $request->hist_start;
            $history->hist_end = $request->hist_end;
            $history->hist_employer = $request->hist_employer;
            $history->hist_industry = $request->hist_industry;
            $history->hist_position = $request->hist_position;
            $history->hist_status = $request->hist_status;
            $history->hist_reason = $request->hist_reason;

            $history->save();
        }

        $msg = "Employee Details Have Been Updated successfully";
        return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
    }

    public function educationQualification(Request $request)
    {
        // For Educational Qualifiation
        $id = $request->employeeID;
        if ($request->institute != null && $request->course != null) {
            $qualification = new EducationQualification();

            $qualification->employeeID = $request->employeeID;
            $qualification->institute = $request->institute;
            $qualification->level = $request->level;
            $qualification->course = $request->course;
            $qualification->start_year = $request->start_year;
            $qualification->end_year = $request->finish_year;
            $qualification->final_score = $request->final_score ?? 'null';
            $qualification->study_location = $request->study_location;
            // $qualification->certificate = $request->certificate;

            if ($request->hasfile('certificate')) {
                // $request->validate([
                //     'certificate' => 'required|clamav',
                // ]);
                $request->validate([
                    'certificate' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                ]);
                $newImageName = $request->certificate->hashName();
                $request->certificate->move(public_path('storage\certificates'), $newImageName);
                $qualification->certificate = $newImageName;
            }

            $qualification->save();
        }

        $msg = "Employee Details Have Been Updated successfully";
        return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
    }

    public function professionalCertificate(Request $request)
    {
        $id = $request->employeeID;

        if ($request->cert_qualification != null && $request->cert_number != null) {
            $certification = new ProfessionalCertification();

            $certification->employeeID = $request->employeeID;
            $certification->cert_start = $request->cert_start;
            // dd($request->cert_start);
            $certification->cert_end = $request->cert_end;
            $certification->cert_name = $request->cert_name;
            $certification->cert_qualification = $request->cert_qualification;
            $certification->cert_number = $request->cert_number;
            $certification->cert_status = $request->cert_status;

            if ($request->hasfile('certificate2')) {
                $request->validate([
                    'certificate2' => 'mimes:jpg,png,jpeg,pdf|max:2048',
                ]);
                $newImageName = $request->certificate2->hashName();
                $request->certificate2->move(public_path('storage\certifications'), $newImageName);
                $certification->certificate = $newImageName;
            }
            $certification->save();
        }

        $msg = "Employee Details Have Been Updated successfully";
        return redirect('flex/employee-profile/' . base64_encode($id))->with('msg', $msg);
    }

    // end of update employee details

    // delete child/dependant  function
    public function deleteChild($id)
    {

        $child = EmployeeDependant::find($id);

        $empID = $child->employeeID;

        if (auth()->user()->emp_id != $empID) {
            $this->authenticateUser('edit-employee');
        }

        $child->delete();

        return redirect('flex/employee-profile/' . base64_encode($empID))->with('msg', 'Employee Dependant is Deleted successfully !');
    }

    public function deleteParent($id)
    {
        $parent = EmployeeParent::find($id);

        $empID = $parent->employeeID;

        if (auth()->user()->emp_id != $empID) {
            $this->authenticateUser('edit-employee');
        }

        $parent->delete();

        return redirect('flex/employee-profile/' . base64_encode($empID))->with('msg', 'Employee Parent is Deleted successfully !');
    }

    public function deleteQualification($id)
    {
        $qualification = EducationQualification::find($id);

        $empID = $qualification->employeeID;

        if (auth()->user()->emp_id != $empID) {
            $this->authenticateUser('edit-employee');
        }

        $qualification->delete();

        return redirect('flex/employee-profile/' . base64_encode($empID))->with('msg', 'Employee Education Qualification was Deleted successfully !');
    }

    public function deleteCertification($id)
    {
        $certification = ProfessionalCertification::find($id);

        $empID = $certification->employeeID;

        if (auth()->user()->emp_id != $empID) {
            $this->authenticateUser('edit-employee');
        }

        $certification->delete();

        return redirect('flex/employee-profile/' . base64_encode($empID))->with('msg', 'Employee Professional Certification was Deleted successfully !');
    }

    // For deleting employment history
    public function deleteHistory($id)
    {
        $history = EmploymentHistory::find($id);

        $empID = $history->employeeID;

        if (auth()->user()->emp_id != $empID) {
            $this->authenticateUser('edit-employee');
        }

        $history->delete();

        return redirect('flex/employee-profile/' . base64_encode($empID))->with('msg', 'Employee Employment History was Deleted successfully !');
    }

    // For deleting disciplinary action
    public function deleteAction($id)
    {
        $disciplinary = Disciplinary::find($id);

        $empID = $disciplinary->id;

        $disciplinary->delete();

        return redirect('flex/grievancesCompain/')->with('msg', 'Disciplinary Action was Deleted successfully !');
    }

    // For viewing userbiodata
    public function userdata(Request $request, $id)
    {
        $id = base64_decode($id);

        if (auth()->user()->emp_id != $id) {
            $this->authenticateUser('view-employee');
        }

        $extra = $request->input('extra');
        $data['employee'] = $this->flexperformance_model->userprofile($id);

        // dd($data['employee'] );
        $data['kin'] = $this->flexperformance_model->getkin($id);
        $data['property'] = $this->flexperformance_model->getproperty($id);
        $data['propertyexit'] = $this->flexperformance_model->getpropertyexit($id);
        $data['active_properties'] = $this->flexperformance_model->getactive_properties($id);
        $data['allrole'] = $this->flexperformance_model->role($id);
        $data['role'] = $this->flexperformance_model->getuserrole($id);
        $data['rolecount'] = $this->flexperformance_model->rolecount($id);
        $data['task_duration'] = $this->performanceModel->total_task_duration($id);
        $data['task_actual_duration'] = $this->performanceModel->total_task_actual_duration($id);
        $data['task_monetary_value'] = $this->performanceModel->all_task_monetary_value($id);
        $data['allTaskcompleted'] = $this->performanceModel->allTaskcompleted($id);

        $data['skills_missing'] = $this->flexperformance_model->skills_missing($id);

        $data['requested_skills'] = $this->flexperformance_model->requested_skills($id);
        $data['skills_have'] = $this->flexperformance_model->skills_have($id);
        $data['month_list'] = $this->flexperformance_model->payroll_month_list();
        $data['title'] = "Profile";
        $empID = $id;
        $details = EmployeeDetail::where('employeeID', $empID)->first();

        $emergency = EmergencyContact::where('employeeID', $empID)->first();

        $children = EmployeeDependant::where('employeeID', $empID)->get();

        $spouse = EmployeeSpouse::where('employeeID', $empID)->first();

        $parents = EmployeeParent::where('employeeID', $empID)->get();

        $data['qualifications'] = EducationQualification::where('employeeID', $empID)->orderBy('end_year', 'desc')->get();

        $data['certifications'] = ProfessionalCertification::where('employeeID', $empID)->orderBy('cert_end', 'desc')->get();

        $data['histories'] = EmploymentHistory::where('employeeID', $empID)->orderBy('hist_end', 'desc')->get();
        $data['profile'] = EMPL::where('emp_id', $empID)->first();

        $childs = EmployeeDependant::where('employeeID', $empID)->count();
        $data['qualifications'] = EducationQualification::where('employeeID', $id)->get();

        $data['photo'] = "";

        $data['parent'] = "Employee Profile";

        // return view('employee.userprofile', $data);

        return view('employee.employee-biodata', $data, compact('details', 'emergency', 'spouse', 'children', 'parents', 'childs'));
    }

    // For updating profile image
    public function updateImg(Request $request)
    {

        // request()->validate([
        //     'image' => 'required'
        // ]);
        $user = $request->empID;

        if (auth()->user()->emp_id != $user) {
            $this->authenticateUser('edit-employee');
        }

        $employee = EMPL::where('emp_id', $user)->first();
        if ($request->hasfile('image')) {

            $request->validate([
                'image' => 'required|mimes:jpg,png,jpeg,pdf',
            ]);

            $newImageName = $request->image->hashName();
            Storage::disk('public')->put('profile/' . $newImageName, file_get_contents($request->image));

            // $path = $filePath->path();
            //$scanner = new Scanner();
            // $result = Clamav::scanFile($filePath);

            //    $filename=time().'.'.$file->getClientOriginalExtension();
            //    $file->move('uploads/userprofile/', $filename);
            $employee->photo = $newImageName;
        }

        // saving data
        $employee->update();

        //    return redirect('flex/employee')->with('status', 'Image Has been uploaded');
        // return redirect('flex/employee-profile/' . base64_encode($user))->with('msg', 'Employee Image has been updated successfully !');
        return redirect()->back();
    }

    // start view all holidays function

    public function holidays()
    {

        $data['holidays'] = Holiday::orderBy('date', 'asc')->get();
        $i = 1;
        $data['parent'] = 'Settings';
        $data['child'] = 'Holidays';

        return view('setting.holidays', $data, compact('i'));
    }

    // end of view all holidays functions

    // saving new holiday function
    public function addHoliday(Request $request)
    {
        request()->validate(
            [
                'name' => 'required',
                'date' => 'required',
            ]
        );

        $holiday = new Holiday();
        $holiday->name = $request->name;
        $holiday->date = $request->date;
        $holiday->recurring = $request->recurring == true ? '1' : '0';
        $holiday->save();

        $msg = "Holiday has been save Successfully !";
        return redirect('flex/holidays')->with('msg', $msg);
    }
    // end of saving new holiday function

    // add holidays from excel
    public function addHolidayFromExcel(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        // Handle the file upload and data extraction
        $file = $request->file('file');
        $import = new HolidayDataImport;
        Excel::import($import, $file);

        return redirect()->back()->with('success', 'File uploaded and data extracted successfully.');
    }

    // start of edit disciplinary action
    public function editHoliday(Request $request, $id)
    {

        $i = 1;
        $did = base64_decode($id);
        $data['holidays'] = Holiday::all();
        $data['holiday'] = Holiday::where('id', $did)->first();
        $data['parent'] = 'Settings';
        $data['child'] = 'Edit Holiday';
        return view('setting.edit-holiday', $data, compact('i'));
    }
    // end of edit disciplinary action

    // start of update holiday function
    public function updateHoliday(Request $request)
    {
        request()->validate(
            [
                'name' => 'required',
                'date' => 'required',
            ]
        );

        $id = $request->id;
        $holiday = Holiday::find($id);
        $holiday->name = $request->name;
        $holiday->date = $request->date;
        $holiday->recurring = $request->recurring == true ? '1' : '0';
        $holiday->update();

        $msg = "Holiday has been save Successfully !";
        return redirect('flex/holidays')->with('msg', $msg);
    }
    public function updateLeaveForfeitings(Request $request)
    {
        request()->validate(
            [
                'emp_id' => 'required'
            ]
        );

        $emp_id = $request->emp_id;
        $leaveForfeiting = LeaveForfeiting::where('empID', $emp_id)->first();
        $leaveForfeiting->opening_balance = $request->opening_balance;
        $leaveForfeiting->days = $request->days;
        $leaveForfeiting->update();

        $msg = "Employee Leave Forfeiting has been save Successfully !";
        return back()->with('msg', $msg);
    }
    // end of update holiday function

    // For Updating Holiday Year
    public function updateHolidayYear()
    {
        $holiday = Holiday::where('recurring', '1')->get();

        foreach ($holiday as $value) {
            $new_date = Carbon::parse($value->date)->setYear(date('Y'));

            $holid = Holiday::find($value->id);
            $holid->date = $new_date;
            $holid->update();
        }
        return redirect('flex/holidays/')->with('msg', 'Holiday was Updated successfully !');
    }

    public function updateOpeningBalance()
    {
        $employees = Employee::get();

        $today = date('Y-m-d');
        $year = date('Y');
        $employeeHiredate = explode('-', Auth::user()->hire_date);
        $employeeHireYear = $employeeHiredate[0];
        $employeeDate = '';

        if ($employeeHireYear == $year) {
            $employeeDate = Auth::user()->hire_date;
        } else {
            $employeeDate = $year . '-01-01';
        }

        foreach ($employees as $value) {
            $opening_balance = $this->attendance_model->getLeaveBalance($value->emp_id, $employeeDate, $year . '-12-31');

            // Find the LeaveForfeiting model for the employee or create a new one if it doesn't exist
            $leave_forfeit = LeaveForfeiting::firstOrNew(['empID' => $value->emp_id]);
            $leave_forfeit->opening_balance = $opening_balance;
            $leave_forfeit->nature = 1; // Replace attribute1 with your actual attribute names
            $leave_forfeit->opening_balance_year = $year;
            $leave_forfeit->save();
        }

        return redirect('flex/attendance/leaveforfeiting/')->with('msg', 'Opening Balance was Updated successfully!');
    }

    // start of delete holiday function
    public function deleteHoliday($id)
    {
        $holiday = Holiday::find($id);

        $holiday->delete();

        return redirect('flex/holidays/')->with('msg', 'Holiday was Deleted successfully !');
    }
    // end of delete holiday function

    // start of view email notification settings
    public function emailNotification()
    {

        $data['title'] = "Email Notifications";
        $data['notifications'] = EmailNotification::orderBy('id', 'asc')->get();
        $i = 1;
        $data['parent'] = 'Settings';
        $data['child'] = 'Email Notifications';

        return view('setting.email-notifications', $data, compact('i'));
    }
    // end of view email notification settings

    // start of edit email notification settings function
    public function editNotification(Request $request, $id)
    {

        $i = 1;
        $did = base64_decode($id);

        $data['notifications'] = EmailNotification::all();

        $data['notification'] = EmailNotification::where('id', $did)->first();

        $data['parent'] = 'Settings';
        $data['child'] = 'Edit Notification';
        return view('setting.edit-email-notification', $data, compact('i'));
    }
    // end of edit email notification settings function

    // start of update holiday function
    public function updateNotification(Request $request)
    {

        $id = $request->id;
        $email = EmailNotification::find($id);
        $email->status = $request->status == true ? '1' : '0';
        $email->update();

        $msg = "Email Permission has been Updated Successfully !";
        return redirect('flex/email-notifications')->with('msg', $msg);
    }

    // end of update holiday function

    // start of view all approvals settings
    public function viewApprovals()
    {

        $data['title'] = "Approval Settings";
        $data['approvals'] = Approvals::orderBy('id', 'asc')->get();
        $i = 1;
        $data['parent'] = 'Settings';
        $data['child'] = 'Approvals';

        return view('setting.approvals', $data, compact('i'));
    }
    // end of view email notification settings

    // start of add approval function

    public function saveApprovals(Request $request)
    {
        request()->validate(
            [
                'process_name' => 'required',
                'escallation' => 'nullable',
                'escallation_time' => 'nullable',
            ]
        );

        $approval = new Approvals();
        $approval->process_name = $request->process_name;
        $approval->escallation = $request->escallation == true ? '1' : '0';
        $approval->escallation_time = $request->escallation_time;
        $approval->save();

        $msg = "Approval has been added Successfully !";
        return redirect('flex/approvals')->with('msg', $msg);
    }
    // end of add approval function

    // start of view approval levels function
    public function viewApprovalLevels(Request $request, $id)
    {

        $i = 1;
        $did = base64_decode($id);

        $data['roles'] = Role::all();
        $data['approval'] = Approvals::where('id', $did)->first();
        $approval = Approvals::where('id', $did)->first();
        $data['levels'] = ApprovalLevel::where('approval_id', $did)->get();

        $data['parent'] = 'Settings';

        $data['child'] = $approval->process_name . '/Approval Levels';
        return view('setting.view-approval', $data, compact('i'));
    }
    // end of view approval levels function

    // start of add approval level function

    public function saveApprovalLevel(Request $request)
    {
        request()->validate(
            [
                'label_name' => 'required',
                'level_name' => 'required',
                'rank' => 'required',
            ]
        );

        $Level = new ApprovalLevel();
        $Level->approval_id = $request->approval_id;
        $Level->level_name = $request->level_name;
        $Level->label_name = $request->label_name;
        $Level->role_id = $request->role_id;
        $Level->rank = $request->rank;
        $Level->status = $request->status == true ? '1' : '0';

        // for changing approval levels

        $appID = $request->approval_id;
        $approval = Approvals::where('id', $appID)->first();
        $approval->levels = $approval->levels + 1;
        $approval->update();

        $Level->save();

        $msg = "Approval has been added Successfully !";
        return redirect('flex/approval_levels/' . base64_encode($appID))->with('msg', $msg);
    }
    // end of add approval level function

    // start of delete approval
    public function deleteApproval($id)
    {
        $approval = Approvals::where('id', $id)->first();
        $approval->delete();

        return redirect('flex/approvals')->with('msg', "Approval role was deleted successfully!");
    }
    // end of delete approval

    // start of delete approval
    public function deleteApprovalLevel($id)
    {
        $level = ApprovalLevel::where('id', $id)->first();

        // for changing approval level

        $appID = $level->approval_id;
        $approval = Approvals::where('id', $appID)->first();
        $approval->levels = $approval->levels - 1;
        $approval->update();

        $level->delete();

        return redirect('flex/approval_levels/' . base64_encode($appID))->with('msg', "Approval Level was deleted successfully!");
    }
    // end of delete approval

    //  For Employee Biodata download
    public function viewBiodata(Request $request)
    {
        $id = $request->emp_id;

        $extra = $request->input('extra');
        $data['employee'] = $this->flexperformance_model->userprofile($id);

        // dd($data['employee'] );
        $data['kin'] = $this->flexperformance_model->getkin($id);
        $data['property'] = $this->flexperformance_model->getproperty($id);
        $data['propertyexit'] = $this->flexperformance_model->getpropertyexit($id);
        $data['active_properties'] = $this->flexperformance_model->getactive_properties($id);
        $data['allrole'] = $this->flexperformance_model->role($id);
        $data['role'] = $this->flexperformance_model->getuserrole($id);
        $data['rolecount'] = $this->flexperformance_model->rolecount($id);
        $data['task_duration'] = $this->performanceModel->total_task_duration($id);
        $data['task_actual_duration'] = $this->performanceModel->total_task_actual_duration($id);
        $data['task_monetary_value'] = $this->performanceModel->all_task_monetary_value($id);
        $data['allTaskcompleted'] = $this->performanceModel->allTaskcompleted($id);

        $data['skills_missing'] = $this->flexperformance_model->skills_missing($id);

        $data['requested_skills'] = $this->flexperformance_model->requested_skills($id);
        $data['skills_have'] = $this->flexperformance_model->skills_have($id);
        $data['month_list'] = $this->flexperformance_model->payroll_month_list();
        $data['title'] = "Profile";
        $empID = $id;
        $details = EmployeeDetail::where('employeeID', $empID)->first();

        $emergency = EmergencyContact::where('employeeID', $empID)->first();

        $children = EmployeeDependant::where('employeeID', $empID)->get();

        $spouse = EmployeeSpouse::where('employeeID', $empID)->first();

        $parents = EmployeeParent::where('employeeID', $empID)->get();

        $data['qualifications'] = EducationQualification::where('employeeID', $empID)->orderBy('end_year', 'desc')->get();

        $data['certifications'] = ProfessionalCertification::where('employeeID', $empID)->orderBy('cert_end', 'desc')->get();

        $data['histories'] = EmploymentHistory::where('employeeID', $empID)->orderBy('hist_end', 'desc')->get();
        $data['profile'] = EMPL::where('emp_id', $empID)->first();

        $childs = EmployeeDependant::where('employeeID', $empID)->count();
        $data['qualifications'] = EducationQualification::where('employeeID', $id)->get();

        $data['photo'] = "";

        $data['parent'] = "Employee Profile";

        if ($id == 'All') {
            $data2['employee'] = Employee::all()->where('state', 1);
            return view('reports.employee_data_datatable', $data2);
        }

        // return view('employee.userprofile', $data);
        $pdf = Pdf::loadView('reports.employee-data', $data, compact('details', 'emergency', 'spouse', 'children', 'parents', 'childs'));
        $pdf->setPaper([0, 0, 885.98, 396.85], 'landscape');
        return $pdf->download('employee_biodata.pdf');
        // return view('reports.employee-data', $data, compact('details', 'emergency', 'spouse', 'children', 'parents', 'childs'));
    }

    // Start of leave approvals



    // public function LeaveApprovals(Request $request)
    // {

    //     $empID = Auth()->user()->emp_id;
    //     $data['employees'] = EMPL::get();

    //     $data['approvals'] = LeaveApproval::orderBy('created_at', 'desc')->get();

    //     $data['parent'] = 'Settings';
    //     $data['child'] = 'Leave Approval';

    //     if ($request->isMethod('post')) {

    //         // dd("uuuuuuuuuuuuuuuuuuuuuu");
    //         return Excel::download(new LeaveApprovalsExport($data['approvals']), 'leave_approvals.xlsx');
    //     }


    //     return view('setting.leave-approval', $data);
    // }

    public function LeaveApprovals(Request $request)
    {
        $empID = Auth()->user()->emp_id;
        $data['employees'] = EMPL::get();
        $data['approvals'] = LeaveApproval::orderBy('created_at', 'desc')->get();
        $data['parent'] = 'Settings';
        $data['child'] = 'Leave Approval';

        if ($request->isMethod('post')) {
            $export = new LeaveApprovalsExport(LeaveApproval::orderBy('created_at', 'asc')->get());
            $fileName = 'leave_approvals.xlsx';
            return Excel::download($export, $fileName);
        }

        return view('setting.leave-approval', $data);
    }


    // For Saving Leave Approvals
    public function saveLeaveApproval(Request $request)
    {

        request()->validate(
            [
                'empID' => 'required',
                'level_1' => 'required',
                'level_2' => 'nullable',
                'level_3' => 'nullable',
                'escallation_time' => 'nullable',
            ]
        );

        $approval = new LeaveApproval();
        $approval->empID = $request->empID;
        $approval->level1 = $request->level_1;
        $approval->level2 = $request->level_2;
        $approval->level3 = $request->level_3;
        $approval->escallation_time = $request->escallation_time;
        $approval->save();

        $msg = "Leave Approval has been added Successfully !";
        return redirect('flex/leave-approvals')->with('msg', $msg);
    }

    // For Edit Leave Approval page

    public function editLeaveApproval(Request $request, $id)
    {

        // dd($id);
        $data['approval'] = LeaveApproval::where('id', $id)->first();
        $data['employees'] = EMPL::get();
        $data['parent'] = 'Settings';

        // dd( $data['approval']);
        $data['child'] = 'Edit Leave Approval';
        return view('setting.edit-leave-approval', $data);
    }
    public function editLeaveForfeitings(Request $request, $id)
    {
        // dd($id);
        $data['leaveForfeitings'] = LeaveForfeiting::with('employee')->where('empID', $id)->first();
        $data['employees'] = Employee::get();
        $data['parent'] = 'Settings';
        $data['child'] = 'Edit Leave Forfeiting';
        $today = date('Y-m-d');
        $arryear = explode('-', $today);
        $year = $arryear[0];
        $employeeDate = $year . ('-01-01');

        $data['leaveBalance'] = $this->attendance_model->getLeaveBalance($id, $employeeDate, date('Y-m-d'));

        $natureId = 1;
        $currentYear = date('Y');
        $startDate = $currentYear . '-01-01';
        $endDate = $currentYear . '-12-31'; // Current date
        $daysSpent = Leaves::where('empId', $id)
            ->where('nature', $natureId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('state', 0)
            ->sum('days');

        $data['daysSpent'] = $daysSpent;
        return view('app.edit-leave-forfeitings', $data);
    }

    // For Deleting Leave Approval
    public function deleteLeaveApproval($id)
    {
        $approval = LeaveApproval::find($id);

        $approval->delete();

        return redirect('flex/leave-approvals');
    }

    // start of update holiday function
    public function updateLeaveApproval(Request $request)
    {

        $id = $request->id;
        $approval = LeaveApproval::find($id);
        $approval->level1 = $request->level_1;
        $approval->level2 = $request->level_2;
        $approval->level3 = $request->level_3;
        $approval->escallation_time = $request->escallation_time;
        $approval->update();

        $msg = "Leave Approval has been Updated Successfully !";
        return redirect('flex/leave-approvals')->with('msg', $msg);
    }
    // End of Leave Approvals

    // For All Grievances

    public function all_grievances()
    {
        $data['my_grievances'] = Grievance::where('empID', Auth::user()->emp_id)->get();
        $data['other_grievances'] = Grievance::all();
        return view('app/grievances', $data);
    }

    // For Single Grievance
    public function grievance_details($id)
    {
        //    $id = ;

        $data['title'] = 'Grievances Details';
        $data['details'] = $this->flexperformance_model->grievance_details($id);
        $grievance = Grievance::where('id', $id)->first();
        if ($grievance->empID != Auth::user()->emp_id) {
            $this->authenticateUser('edit-employee');
        }

        return view('app.grievance_details', $data);

        //    if (isset($_POST["submit"])) {

        //        $id = $request->input('id');

        //        $config = array(
        //            'upload_path' => "./uploads/grievances/",
        //            'file_name' => "FILE" . date("Ymd-His"),
        //            'allowed_types' => "img|jpg|jpeg|png|pdf|xlsx|xls|doc|ppt|docx",
        //            'overwrite' => true,
        //        );
        //        $path = "/uploads/grievances/";

        //        $this->load->library('upload', $config);
        //        if ($this->upload->do_upload()) {
        //            // echo "skip"; exit();

        //            $uploadData = $this->upload->data();

        //            $updates = array(
        //                'remarks' => $request->input("remarks"),
        //                'support_document' => $path . $uploadData["file_name"],
        //                'forwarded_by' => auth()->user()->emp_id,
        //                'forwarded' => 1,
        //            );

        //            $this->flexperformance_model->forward_grievance($updates, $id);
        //            session('note', "<p class='alert alert-success text-center'>Your Grievance has been Submitted Successifully</p>");
        //            return redirect('/flex/grievances');
        //        } else {

        //            $data = array(
        //                'remarks' => $request->input("remarks"),
        //                'forwarded_by' => auth()->user()->emp_id,
        //                'forwarded' => 1,
        //            );
        //        }

        //        $this->flexperformance_model->forward_grievance($data, $id);
        //        session('note', "<p class='alert alert-success text-center'>Your Grievance has been Submitted Successifully</p>");
        //        return redirect('/flex/grievances');
        //    }

        //    //   SOLVE

        //    if (isset($_POST["solve"])) {

        //        $id = $request->input('id');

        //        $config = array(
        //            'upload_path' => "./uploads/grievances/",
        //            'file_name' => "FILE" . date("Ymd-His"),
        //            'allowed_types' => "img|jpg|jpeg|png|pdf|xlsx|xls|doc|ppt|docx",
        //            'overwrite' => true,
        //        );
        //        $path = "/uploads/grievances/";

        //        $this->load->library('upload', $config);
        //        if ($this->upload->do_upload()) {
        //            // echo "skip"; exit();

        //            $uploadData = $this->upload->data();

        //            $updates = array(
        //                'remarks' => $request->input("remarks"),
        //                'support_document' => $path . $uploadData["file_name"],
        //                'forwarded_by' => auth()->user()->emp_id,
        //                'forwarded' => 1,
        //                'status' => 1,
        //            );

        //            $this->flexperformance_model->forward_grievance($updates, $id);
        //            session('note', "<p class='alert alert-success text-center'>Grievance has Solved Successifully</p>");
        //            return redirect('/flex/grievances');
        //        } else {

        //            $data = array(
        //                'remarks' => $request->input("remarks"),
        //                'forwarded_by' => auth()->user()->emp_id,
        //                'forwarded' => 1,
        //                'status' => 1,
        //            );
        //        }

        //        $this->flexperformance_model->forward_grievance($data, $id);
        //        session('note', "<p class='alert alert-success text-center'>Grievance has Solved Successifully</p>");
        //        return redirect('/flex/grievances');
        //    }
    }

    //    For Cancel  Grievances
    public function cancel_grievance($id)
    {
        $project = Grievance::where('id', $id)->first();
        if ($project->empID != Auth::user()->emp_id) {
            $this->authenticateUser('edit-employee');
        }
        $project->delete();

        return redirect('flex/my-grievences');
    }
    // For Resolve Grievances
    public function resolve_grievance($id)
    {

        $grievance = Grievance::find($id);
        if ($grievance->empID != Auth::user()->emp_id) {
            $this->authenticateUser('edit-employee');
        }

        $grievance->status = 1;
        $grievance->update();

        $msg = "Grievance is resolved successfully!";

        return back()->with('msg', $msg);
    }
    // For unresolve Grievance
    public function unresolve_grievance($id)
    {

        $grievance = Grievance::find($id);
        if ($grievance->empID != Auth::user()->emp_id) {
            $this->authenticateUser('edit-employee');
        }

        $grievance->status = 0;
        $grievance->update();

        $msg = "Grievance is un-resolved successfully!";

        return back()->with('msg', $msg);
    }

    // For Grievance Feedback

    public function update_grievance(Request $request)
    {

        $grievance = Grievance::find($request->id);
        if ($grievance->empID != Auth::user()->emp_id) {
            $this->authenticateUser('edit-employee');
        }

        $grievance->remarks = $request->remarks;
        $grievance->forwarded_by = Auth::user()->emp_id;
        if ($request->hasfile('attachment')) {
            $request->validate([
                'attachment' => 'required|clamav',
            ]);
            $request->validate([
                'attachment' => 'mimes:jpg,png,jpeg,pdf|max:2048',
            ]);
            $newAttachmentName = $request->attachment->hashName();
            $request->attachment->move(public_path('storage\grieavences-supports'), $newAttachmentName);
            $grievance->support_document = $newAttachmentName;
        }
        $grievance->status = 1;
        $grievance->update();

        $msg = "Grievance Feedback was Added successfully!";

        return back()->with('msg', $msg);
    }

    // Start of self services

    // For MyOvertime

    public function myOvertimes()
    {
        $data['title'] = "Overtime";
        $data['my_overtimes'] = $this->flexperformance_model->my_overtimes(auth()->user()->emp_id);
        $data['overtimeCategory'] = $this->flexperformance_model->overtimeCategory();
        $data['employees'] = $this->flexperformance_model->Employee();

        $data['line_overtime'] = $this->flexperformance_model->lineOvertimes(auth()->user()->emp_id);

        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['parent'] = 'My Services';
        $data['child'] = 'Overtimes';
        return view('my-services.overtimes', $data);
    }

    public function overtime_on_behalf()
    {
        $data['title'] = "Overtime";
        $data['my_overtimes'] = $this->flexperformance_model->my_overtimes(auth()->user()->emp_id);
        $data['overtimeCategory'] = $this->flexperformance_model->overtimeCategory();
        $data['employees'] = $this->flexperformance_model->Employee();

        $data['line_overtime'] = $this->flexperformance_model->approvedOvertimes();

        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();
        $data['parent'] = 'My Services';
        $data['child'] = 'Overtimes';
        return view('overtime.overtime_onbehalf', $data);
    }

    // For My Loans
    public function myLoans(Request $request)
    {

        $empID = auth()->user()->emp_id;
        $data['myloan'] = $this->flexperformance_model->mysalary_advance($empID);
        // dd($data);

        $data['my_loans'] = $this->flexperformance_model->my_confirmedloan($empID);

        $data['employee'] = $this->flexperformance_model->customemployee();
        $data['max_amount'] = $this->flexperformance_model->get_max_salary_advance(auth()->user()->emp_id);
        $data['title'] = "Loans and Salaries";
        $data['pendingPayroll'] = $this->payroll_model->pendingPayrollCheck();

        $data['parent'] = 'My Services';
        $data['child'] = 'Loans';
        return view('my-services/loans', $data);
    }

    // For My Pensions
    public function myPensions()
    {
        $id = auth()->user()->emp_id;

        $data['employee_pension'] = $this->reports_model->employee_pension($id);

        $data['child'] = "Employee Profile";
        $data['parent'] = "My Services";

        return view('my-services/pensions', $data);
    }

    // For My Grievances

    public function my_grievances()
    {
        $data['my_grievances'] = Grievance::latest()->where('empID', Auth::user()->emp_id)->get();
        return view('my-services.grievances', $data);
    }

    // For Saving New Grievances
    public function save_grievance(Request $request)
    {

        request()->validate(
            [

                // start of name information validation

                'title' => 'required',
                'description' => 'required',

            ]
        );
        $grievance = new Grievance();
        $grievance->title = $request->title;
        $grievance->description = $request->description;
        $grievance->empID = Auth::user()->emp_id;
        if ($request->hasfile('attachment')) {
            // $request->validate([
            //     'attachment' => 'required|clamav',
            // ]);
            $request->validate([
                'attachment' => 'mimes:jpg,png,jpeg,pdf|max:2048',
            ]);
            $newAttachmentName = $request->attachment->hashName();
            $request->attachment->move(public_path('storage\grieavences-attachments'), $newAttachmentName);
            $grievance->attachment = $newAttachmentName;
        }
        $grievance->anonymous = $request->anonymous == true ? '1' : '0';
        $grievance->save();

        return redirect('flex/my-grievences');
    }
    // For My Biodata
    public function my_biodata(Request $request)
    {

        $id = auth()->user()->emp_id;

        $extra = $request->input('extra');
        $data['employee'] = $this->flexperformance_model->userprofile($id);

        // dd($this->flexperformance_model->userprofile($id));
        $data['kin'] = $this->flexperformance_model->getkin($id);
        $data['property'] = $this->flexperformance_model->getproperty($id);
        $data['propertyexit'] = $this->flexperformance_model->getpropertyexit($id);
        $data['active_properties'] = $this->flexperformance_model->getactive_properties($id);
        $data['allrole'] = $this->flexperformance_model->role($id);
        $data['role'] = $this->flexperformance_model->getuserrole($id);
        $data['rolecount'] = $this->flexperformance_model->rolecount($id);
        $data['task_duration'] = $this->performanceModel->total_task_duration($id);
        $data['task_actual_duration'] = $this->performanceModel->total_task_actual_duration($id);
        $data['task_monetary_value'] = $this->performanceModel->all_task_monetary_value($id);
        $data['allTaskcompleted'] = $this->performanceModel->allTaskcompleted($id);

        $data['skills_missing'] = $this->flexperformance_model->skills_missing($id);

        $data['requested_skills'] = $this->flexperformance_model->requested_skills($id);
        $data['skills_have'] = $this->flexperformance_model->skills_have($id);
        $data['month_list'] = $this->flexperformance_model->payroll_month_list();
        $data['title'] = "Profile";
        $data['empID'] = $id;
        $empID = $id;
        $data['details'] = EmployeeDetail::where('employeeID', $empID)->first();

        $data['emergency'] = EmergencyContact::where('employeeID', $empID)->first();

        $data['children'] = EmployeeDependant::where('employeeID', $empID)->get();

        $data['spouse'] = EmployeeSpouse::where('employeeID', $empID)->first();

        $data['parents'] = EmployeeParent::where('employeeID', $empID)->get();

        $data['qualifications'] = EducationQualification::where('employeeID', $empID)->orderBy('end_year', 'desc')->get();

        $data['certifications'] = ProfessionalCertification::where('employeeID', $empID)->orderBy('cert_end', 'desc')->get();

        $data['histories'] = EmploymentHistory::where('employeeID', $empID)->orderBy('hist_end', 'desc')->get();
        $data['profile'] = EMPL::where('emp_id', $empID)->first();

        $data['childs'] = EmployeeDependant::where('employeeID', $empID)->count();
        $data['qualifications'] = EducationQualification::where('employeeID', $id)->get();

        $data['photo'] = "";

        $data['child'] = "Biodata";
        $data['parent'] = "My-Services";

        return view('my-services/biodata', $data);
    }
    // end of self services

    // For All Projects
    public function projects()
    {
        $data['project'] = Project::latest()->get();
        return view('performance.projects', $data);
    }

    // For Add New Project Page
    public function add_project()
    {
        return view('performance.add-project');
    }
    // For Saving New Project
    public function save_project(Request $request)
    {
        $project = new Project();
        $project->name = $request->name;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->save();

        return redirect('flex/projects');
    }

    // For Saving New Project
    public function edit_project($id)
    {
        $project = Project::where('id', $id)->first();
        return view('performance.edit_project', compact('project'));
    }

    // For Saving New Project
    public function update_project(Request $request)
    {
        $project = Project::where('id', $request->id)->first();
        $project->name = $request->name;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->update();
        return redirect('flex/projects')->with('msg', 'Project was updated Successfully !');
    }

    // For Completed Projects

    public function completed_project($id)
    {
        $project = Project::where('id', $id)->first();
        $project->status = 1;
        $project->update();
        return back()->with('msg', 'Project was Completed Successfully !');
    }
    // View single project
    public function view_project($id)
    {
        $project = Project::where('id', $id)->first();
        $tasks = ProjectTask::where('project_id', $id)->latest()->get();
        return view('performance.single_project', compact('project', 'tasks'));
    }

    // For Deleting  Project
    public function delete_project($id)
    {
        $project = Project::find($id);

        $tasks = ProjectTask::where('project_id', $project->id)->get();
        foreach ($tasks as $item) {
            $performance = EmployeePerformance::where('task_id', $item->id)->first();
            //For Employee Performance Deletion
            if ($performance) {
                $performance->delete();
            }
            $item->delete();
        }

        $project->delete();

        return redirect('flex/projects');
    }

    // For Adding Task
    public function add_task($id)
    {
        $project = $id;
        $employees = EMPL::where('state', 1)->get();

        return view('performance.add-task', compact('project', 'employees'));
    }

    // For Updating completed Task Status
    public function completed_task($id)
    {
        $task = ProjectTask::where('id', $id)->first();

        $task->status = 1;
        $task->complete_date = Carbon::now();

        $task->update();

        $performance = new EmployeePerformance();
        $performance->empID = $task->assigned;
        $performance->performance = $task->performance;
        $performance->behaviour = $task->behaviour;
        $performance->task_id = $task->id;
        $performance->target = $task->target;
        $performance->achieved = $task->achieved;
        $performance->type = 'project';
        $performance->save();

        $tasks = ProjectTask::where('project_id', $task->project_id)->get();

        $project = Project::where('id', $task->project_id)->first();
        return view('performance.single_project', compact('project', 'tasks',));
    }

    public function edit_project_task($id)
    {

        $task = ProjectTask::where('id', $id)->first();
        $project = Project::where('id', $task->project_id)->first();
        $employees = EMPL::where('state', 1)->get();
        return view('performance.edit_project_task', compact('task', 'project', 'employees'));
    }

    // For single task Assessment Page
    public function assess_task($id)
    {
        $task = ProjectTask::where('id', $id)->first();
        return view('performance.asses_task', compact('task'));
    }

    // For single Adhoctask Assessment Page
    public function assess_adhoctask($id)
    {
        $task = AdhocTask::where('id', $id)->first();
        return view('performance.asses_adhoctask', compact('task'));
    }

    // For saving task Assessment
    public function save_task_assessment(Request $request)
    {
        $task = ProjectTask::where('id', $request->id)->first();

        $task->remark = $request->remark;
        $task->achieved = $request->achievement;
        $task->behaviour = $request->behaviour;
        $task->remark = $request->remark;
        $task->time = $request->time;
        //For Task Performance'
        //For Ratio Variables
        $ratios = PerformanceRatio::first();
        $target_ratio = $ratios->target;
        $time_ratio = $ratios->time;
        $behaviour_ratio = $ratios->behaviour;
        // For Targets
        $target_reached = $task->achieved;
        $target_required = $task->target;
        // For Behaviour
        $behaviour = $task->behaviour;
        // For Time
        $d1 = new Carbon($task->start_date);
        $d2 = new Carbon($task->complete_date);
        $time_taken = $d2->diffInMinutes($d1);
        $d3 = new Carbon($task->end_date);
        $time_required = $d2->diffInMinutes($d1);

        $performance = (($target_reached / $target_required) * $target_ratio) + (($time_taken / $time_required) * $time_ratio) + (($behaviour / 100) * $behaviour_ratio);
        $task->performance = number_format($performance, 2);
        $task->update();

        $perf = EmployeePerformance::where('task_id', $task->id)->first();
        if ($perf) {
            $perf->performance = $task->performance;
            $perf->behaviour = $task->behaviour;
            $perf->target = $task->target;
            $perf->achieved = $task->achieved;
            $perf->update();
        } else {
            $perf = new EmployeePerformance();
            $perf->empID = $task->assigned;
            $perf->performance = $task->performance;
            $perf->behaviour = $task->behaviour;
            $perf->achieved = $task->achieved;
            $perf->target = $task->target;
            $perf->task_id = $task->id;
            $perf->type = 'project';
            $perf->save();
        }

        return view('performance.asses_task', compact('task'));
    }

    // For saving task Assessment
    public function save_adhoctask_assessment(Request $request)
    {
        $task = AdhocTask::where('id', $request->id)->first();

        $task->remark = $request->remark;
        $task->achieved = $request->achievement;
        $task->behaviour = $request->behaviour;
        $task->remark = $request->remark;
        $task->time = $request->time;
        //For Task Performance'
        //For Ratio Variables
        $ratios = PerformanceRatio::first();
        $target_ratio = $ratios->target;
        $time_ratio = $ratios->time;
        $behaviour_ratio = $ratios->behaviour;
        // For Targets
        $target_reached = $task->achieved;
        $target_required = $task->target;
        // For Behaviour
        $behaviour = $task->behaviour;
        // For Time
        $d1 = new Carbon($task->start_date);
        $d2 = new Carbon($task->complete_date);
        $time_taken = $d2->diffInMinutes($d1);
        $d3 = new Carbon($task->end_date);
        $time_required = $d2->diffInMinutes($d1);

        $performance = (($target_reached / $target_required) * $target_ratio) + (($time_taken / $time_required) * $time_ratio) + (($behaviour / 100) * $behaviour_ratio);
        $task->performance = number_format($performance, 2);
        $task->update();

        $perf = EmployeePerformance::where('task_id', $task->id)->first();
        if ($perf) {
            $perf->performance = $task->performance;
            $perf->behaviour = $task->behaviour;
            $perf->target = $task->target;
            $perf->achieved = $task->achieved;

            $perf->update();
        } else {
            $perf = new EmployeePerformance();
            $perf->empID = $task->assigned;
            $perf->performance = $task->performance;
            $perf->behaviour = $task->behaviour;
            $perf->task_id = $task->id;
            $perf->target = $task->target;
            $perf->achieved = $task->achieved;
            $perf->type = 'Adhoc';
            $perf->save();
        }

        return view('performance.asses_adhoctask', compact('task'));
    }
    //For Saving Project Ratio
    public function save_project_task(Request $request)
    {
        $task = new ProjectTask();
        $task->name = $request->name;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->project_id = $request->project;
        $task->assigned = $request->assigned;
        $task->target = $request->target;
        $task->created_by = Auth::user()->emp_id;
        $task->save();

        return redirect('flex/view-project/' . $request->project);
    }

    // For Deleting  Project Tasks
    public function delete_project_task($id)
    {
        $task = ProjectTask::find($id);
        $performance = EmployeePerformance::where('task_id', $task->id)->first();
        //For Employee Performance Deletion
        if ($performance) {
            $performance->delete();
        }
        $id = $task->project_id;
        $task->delete();

        return redirect('flex/view-project/' . $id)->with('msg', 'Project Task Was Deleted Successfully!');
    }

    // For Deleting  Adhoc Tasks
    public function delete_task($id)
    {
        $task = AdhocTask::find($id);
        $performance = EmployeePerformance::where('task_id', $task->id)->first();
        //For Employee Performance Deletion
        if ($performance) {
            $performance->delete();
        }
        $task->delete();

        return redirect('flex/tasks');
    }
    // For Viewing all Adhoc Tasks
    public function tasks()
    {
        $data['project'] = AdhocTask::all();
        return view('performance.tasks', $data);
    }
    // For Add Adhoc Task Page
    public function add_adhoctask()
    {
        $employees = EMPL::where('state', 1)->get();

        return view('performance.add_adhoc', compact('employees'));
    }
    // For Saving Adhoc Task
    public function save_adhoc_task(Request $request)
    {
        $task = new AdhocTask();
        $task->name = $request->name;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->assigned = $request->assigned;
        $task->target = $request->target;
        $task->save();

        return redirect('flex/tasks');
    }

    // For Updating completed Task Status
    public function completed_adhoctask($id)
    {
        $task = AdhocTask::where('id', $id)->first();

        $task->status = 1;
        $task->complete_date = Carbon::now();

        $task->update();

        $perf = EmployeePerformance::where('task_id', $task->id)->first();
        if ($perf) {
            $perf->performance = $task->performance;
            $perf->behaviour = $task->behaviour;
            $perf->target = $task->target;
            $perf->achieved = $task->achieved;
            $perf->update();
        } else {
            $perf = new EmployeePerformance();
            $perf->empID = $task->assigned;
            $perf->performance = $task->performance;
            $perf->behaviour = $task->behaviour;
            $perf->task_id = $task->id;
            $perf->target = $task->target;
            $perf->achieved = $task->achieved;
            $perf->type = 'Adhoc';
            $perf->save();
        }

        $project = AdhocTask::all();
        return view('performance.tasks', compact('project',));
    }

    //   For Viewing All Performance ratios
    public function performance_ratios()
    {

        $data['target_ratio'] = TargetRatio::all();
        $data['time_ratio'] = TimeRatio::all();
        $data['behaviour_ratio'] = BehaviourRatio::all();
        return view('performance.target_ratios', $data);
    }

    // For Saving Target Ratios
    public function save_target_ratio(Request $request)
    {
        $ratio = new TargetRatio();
        $ratio->name = $request->name;
        $ratio->min = $request->min_value;
        $ratio->max = $request->max_value;
        $ratio->save();

        return redirect('flex/talent-ranges');
    }
    // For Saving Time Ratios
    public function save_time_ratio(Request $request)
    {
        $ratio = new TimeRatio();
        $ratio->name = $request->name;
        $ratio->min = $request->min_value;
        $ratio->max = $request->max_value;
        $ratio->save();

        return redirect('flex/talent-ranges');
    }
    // For Saving Behaviour Ratios
    public function save_behaviour_ratio(Request $request)
    {
        $ratio = new BehaviourRatio();
        $ratio->name = $request->name;
        $ratio->min = $request->min_value;
        $ratio->max = $request->max_value;
        $ratio->save();

        return redirect('flex/talent-ranges');
    }

    // For Deleting  Target Ratios
    public function delete_target_ratio($id)
    {
        $target = TargetRatio::find($id);

        $target->delete();

        return redirect('flex/talent-ranges');
    }
    // For Deleting  Time Ratios
    public function delete_time_ratio($id)
    {
        $time = TimeRatio::find($id);

        $time->delete();

        return redirect('flex/talent-ranges');
    }
    // For Deleting  Behaviour Ratios
    public function delete_behaviour_ratio($id)
    {
        $behaviour = BehaviourRatio::find($id);

        $behaviour->delete();

        return redirect('flex/talent-ranges');
    }

    public function performance()
    {
        //$employee = EMPL::all();
        $employee = $this->flexperformance_model->employee();

        $item1 = 0;
        $item1_count = 0;
        $data['item1_data'] = array();

        $item2 = 0;
        $item2_count = 0;
        $data['item2_data'] = array();

        $item3 = 0;
        $item3_count = 0;
        $data['item3_data'] = array();

        $item4 = 0;
        $item4_count = 0;
        $data['item4_data'] = array();

        $item5 = 0;
        $item5_count = 0;
        $data['item5_data'] = array();

        $item6 = 0;
        $item6_count = 0;
        $data['item6_data'] = array();

        $item7 = 0;
        $item7_count = 0;
        $data['item7_data'] = array();

        $item8 = 0;
        $item8_count = 0;
        $data['item8_data'] = array();

        $item9 = 0;
        $item9_count = 0;
        $data['item9_data'] = array();

        $item10 = 0;
        $item10_count = 0;
        $data['item10_data'] = array();

        $item11 = 0;
        $item11_count = 0;
        $data['item11_data'] = array();

        $item12 = 0;
        $item12_count = 0;
        $data['item12_data'] = array();

        $item13 = 0;
        $item13_count = 0;
        $data['item13_data'] = array();

        $item14 = 0;
        $item14_count = 0;
        $data['item14_data'] = array();

        $item15 = 0;
        $item15_count = 0;
        $data['item15_data'] = array();

        $item16 = 0;
        $item16_count = 0;
        $data['item16_data'] = array();

        $item17 = 0;
        $item17_count = 0;
        $data['item17_data'] = array();

        $item18 = 0;
        $item18_count = 0;
        $data['item18_data'] = array();

        $item19 = 0;
        $item19_count = 0;
        $data['item19_data'] = array();

        $item20 = 0;
        $item20_count = 0;
        $data['item20_data'] = array();

        $item21 = 0;
        $item21_count = 0;
        $data['item21_data'] = array();

        $item22 = 0;
        $item22_count = 0;
        $data['item22_data'] = array();

        $item23 = 0;
        $item23_count = 0;
        $item23_data['item23_data'] = array();

        $item24 = 0;
        $item24_count = 0;
        $data['item24_data'] = array();

        $item25 = 0;
        $item25_count = 0;
        $data['item25_data'] = array();

        foreach ($employee as $item) {
            $performance = DB::table('employee')
                ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
                ->where('employee.emp_id', $item->emp_id)
                ->whereNotNull('employee_performances.performance')
                ->where('employee_performances.type', '!=', 'pip')

                // ->join('adhoc_tasks', 'employee.emp_id', '=', 'adhoc_tasks.assigned')
                ->avg('employee_performances.performance')
                // ->get()
            ;

            $behaviour = DB::table('employee')
                ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
                ->where('employee.emp_id', $item->emp_id)
                ->whereNotNull('employee_performances.behaviour')
                ->where('employee_performances.type', '!=', 'pip')

                // ->join('adhoc_tasks', 'employee.emp_id', '=', 'adhoc_tasks.assigned')
                ->avg('employee_performances.behaviour');

            // For Behaviour Needs Improvement
            if ($behaviour > 0 && $behaviour < 20) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item1 = $item1 + $performance;
                    $item1_count++;
                    array_push($data['item1_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item2 = $item2 + $performance;
                    $item2_count++;
                    array_push($data['item2_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item3 = $item3 + $performance;
                    $item3_count++;
                    array_push($data['item3_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item4 = $item4 + $performance;
                    $item4_count++;
                    array_push($data['item4_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item5 = $item5 + $performance;
                    $item5_count++;
                    array_push($data['item5_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
            }

            // For Behaviour Good
            if ($behaviour >= 20 && $behaviour < 40) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item6 = $item6 + $performance;
                    $item6_count++;
                    array_push($data['item6_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item7 = $item7 + $performance;
                    $item7_count++;
                    array_push($data['item7_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item8 = $item8 + $performance;
                    $item8_count++;
                    array_push($data['item8_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item9 = $item9 + $performance;
                    $item9_count++;
                    array_push($data['item9_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item10 = $item10 + $performance;
                    $item10_count++;
                    array_push($data['item10_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
            }

            // For Behaviour Strong
            if ($behaviour >= 40 && $behaviour < 60) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item11 = $item11 + $performance;
                    $item11_count++;
                    array_push($data['item11_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item12 = $item12 + $performance;
                    $item12_count++;
                    array_push($data['item12_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item13 = $item13 + $performance;
                    $item13_count++;
                    array_push($data['item13_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item14 = $item14 + $performance;
                    $item14_count++;
                    array_push($data['item14_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item15 = $item15 + $performance;
                    $item15_count++;
                    array_push($data['item15_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
            }

            // For Behaviour Very Strong
            if ($behaviour >= 60 && $behaviour < 80) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item16 = $item16 + $performance;
                    $item16_count++;
                    array_push($data['item16_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item17 = $item17 + $performance;
                    $item17_count++;
                    array_push($data['item17_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item18 = $item18 + $performance;
                    $item18_count++;
                    array_push($data['item18_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item19 = $item19 + $performance;
                    $item19_count++;
                    array_push($data['item19_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item20 = $item20 + $performance;
                    $item20_count++;
                    array_push($data['item20_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
            }

            // For Behaviour Outstanding
            if ($behaviour >= 80 && $behaviour < 100) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item21 = $item21 + $performance;
                    array_push($data['item21_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);

                    $item21_count++;
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item22 = $item22 + $performance;
                    array_push($data['item22_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);

                    $item22_count++;
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item23 = $item23 + $performance;
                    array_push($data['item23_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);

                    $item23_count++;
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item24 = $item24 + $performance;
                    array_push($data['item24_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);

                    $item24_count++;
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item25 = $item25 + $performance;
                    array_push($data['item25_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);

                    $item25_count++;
                }
            }

            // var_dump($performance);
        }

        // For Colum 1
        $data['improvement'] = ($item1 > 0) ? $item1_count : 0;
        $data['improvement_good'] = ($item2 > 0) ? $item2_count : 0;
        $data['improvement_strong'] = ($item3 > 0) ? $item3_count : 0;
        $data['improvement_very_strong'] = ($item4 > 0) ? $item4_count : 0;
        $data['improvement_outstanding'] = ($item5 > 0) ? $item5_count : 0;

        // For Column 2
        $data['good_improvement'] = ($item6 > 0) ? $item6_count : 0;
        $data['good'] = ($item7 > 0) ? $item7_count : 0;
        $data['good_strong'] = ($item8 > 0) ? $item8_count : 0;
        $data['good_very_strong'] = ($item9 > 0) ? $item9_count : 0;
        $data['good_outstanding'] = ($item10 > 0) ? $item10_count : 0;

        // For Column 3
        $data['strong_improvement'] = ($item11 > 0) ? $item11_count : 0;
        $data['strong_good'] = ($item12 > 0) ? $item12_count : 0;
        $data['strong'] = ($item13 > 0) ? $item13_count : 0;
        $data['strong_very_strong'] = ($item14 > 0) ? $item14_count : 0;
        $data['strong_outstanding'] = ($item15 > 0) ? $item15_count : 0;

        // For Column 4
        $data['very_strong_improvement'] = ($item16 > 0) ? $item16_count : 0;
        $data['very_strong_good'] = ($item17 > 0) ? $item17_count : 0;
        $data['very_strong_strong'] = ($item18 > 0) ? $item18_count : 0;
        $data['very_strong'] = ($item19 > 0) ? $item19_count : 0;
        $data['very_strong_outstanding'] = ($item20 > 0) ? $item20_count : 0;

        // For Column 5
        $data['outstanding_improvement'] = ($item21 > 0) ? $item21_count : 0;
        $data['outstanding_good'] = ($item22 > 0) ? $item22_count : 0;
        $data['outstanding_strong'] = ($item23 > 0) ? $item23_count : 0;
        $data['outstanding_very_strong'] = ($item24 > 0) ? $item24_count : 0;
        $data['outstanding'] = ($item25 > 0) ? $item25_count : 0;

        // return  $data;

        return view('performance.report', $data);
    }

    public function performanceDetails($id)
    {

        //$employee = EMPL::all();
        $employee = $this->flexperformance_model->employee();

        $item1 = 0;
        $item1_count = 0;
        $data['item1_data'] = array();

        $item2 = 0;
        $item2_count = 0;
        $data['item2_data'] = array();

        $item3 = 0;
        $item3_count = 0;
        $data['item3_data'] = array();

        $item4 = 0;
        $item4_count = 0;
        $data['item4_data'] = array();

        $item5 = 0;
        $item5_count = 0;
        $data['item5_data'] = array();

        $item6 = 0;
        $item6_count = 0;
        $data['item6_data'] = array();

        $item7 = 0;
        $item7_count = 0;
        $data['item7_data'] = array();

        $item8 = 0;
        $item8_count = 0;
        $data['item8_data'] = array();

        $item9 = 0;
        $item9_count = 0;
        $data['item9_data'] = array();

        $item10 = 0;
        $item10_count = 0;
        $data['item10_data'] = array();

        $item11 = 0;
        $item11_count = 0;
        $data['item11_data'] = array();

        $item12 = 0;
        $item12_count = 0;
        $data['item12_data'] = array();

        $item13 = 0;
        $item13_count = 0;
        $data['item13_data'] = array();

        $item14 = 0;
        $item14_count = 0;
        $data['item14_data'] = array();

        $item15 = 0;
        $item15_count = 0;
        $data['item15_data'] = array();

        $item16 = 0;
        $item16_count = 0;
        $data['item16_data'] = array();

        $item17 = 0;
        $item17_count = 0;
        $data['item17_data'] = array();

        $item18 = 0;
        $item18_count = 0;
        $data['item18_data'] = array();

        $item19 = 0;
        $item19_count = 0;
        $data['item19_data'] = array();

        $item20 = 0;
        $item20_count = 0;
        $data['item20_data'] = array();

        $item21 = 0;
        $item21_count = 0;
        $data['item21_data'] = array();

        $item22 = 0;
        $item22_count = 0;
        $data['item22_data'] = array();

        $item23 = 0;
        $item23_count = 0;
        $item23_data = array();

        $item24 = 0;
        $item24_count = 0;
        $data['item24_data'] = array();

        $item25 = 0;
        $item25_count = 0;
        $data['item25_data'] = array();

        foreach ($employee as $item) {
            $performance = DB::table('employee')
                ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
                ->where('employee.emp_id', $item->emp_id)
                ->whereNotNull('employee_performances.performance')
                ->where('employee_performances.type', '!=', 'pip')

                // ->join('adhoc_tasks', 'employee.emp_id', '=', 'adhoc_tasks.assigned')
                ->avg('employee_performances.performance')
                // ->get()
            ;

            $behaviour = DB::table('employee')
                ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
                ->where('employee.emp_id', $item->emp_id)
                ->whereNotNull('employee_performances.behaviour')
                ->where('employee_performances.type', '!=', 'pip')

                // ->join('adhoc_tasks', 'employee.emp_id', '=', 'adhoc_tasks.assigned')
                ->avg('employee_performances.behaviour');

            // For Behaviour Needs Improvement
            if ($behaviour > 0 && $behaviour < 20) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item1 = $item1 + $performance;
                    $item1_count++;
                    array_push($data['item1_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item2 = $item2 + $performance;
                    $item2_count++;
                    array_push($data['item2_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item3 = $item3 + $performance;
                    $item3_count++;
                    array_push($data['item3_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item4 = $item4 + $performance;
                    $item4_count++;
                    array_push($data['item4_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item5 = $item5 + $performance;
                    $item5_count++;
                    array_push($data['item5_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
            }

            // For Behaviour Good
            if ($behaviour >= 20 && $behaviour < 40) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item6 = $item6 + $performance;
                    $item6_count++;
                    array_push($data['item6_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item7 = $item7 + $performance;
                    $item7_count++;
                    array_push($data['item7_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item8 = $item8 + $performance;
                    $item8_count++;
                    array_push($data['item8_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item9 = $item9 + $performance;
                    $item9_count++;
                    array_push($data['item9_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item10 = $item10 + $performance;
                    $item10_count++;
                    array_push($data['item10_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
            }

            // For Behaviour Strong
            if ($behaviour >= 40 && $behaviour < 60) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item11 = $item11 + $performance;
                    $item11_count++;
                    array_push($data['item11_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item12 = $item12 + $performance;
                    $item12_count++;
                    array_push($data['item12_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item13 = $item13 + $performance;
                    $item13_count++;
                    array_push($data['item13_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item14 = $item14 + $performance;
                    $item14_count++;
                    array_push($data['item14_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item15 = $item15 + $performance;
                    $item15_count++;
                    array_push($data['item15_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
            }

            // For Behaviour Very Strong
            if ($behaviour >= 60 && $behaviour < 80) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item16 = $item16 + $performance;
                    $item16_count++;
                    array_push($data['item16_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item17 = $item17 + $performance;
                    $item17_count++;
                    array_push($data['item17_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item18 = $item18 + $performance;
                    $item18_count++;
                    array_push($data['item18_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item19 = $item19 + $performance;
                    $item19_count++;
                    array_push($data['item19_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item20 = $item20 + $performance;
                    $item20_count++;
                    array_push($data['item20_data'], ['full_name' => $item->NAME, 'emp_id' => $item->emp_id, 'department' => $item->DEPARTMENT, 'performance' => $performance, 'behavior' => $behaviour]);
                }
            }

            // For Behaviour Outstanding
            if ($behaviour >= 80 && $behaviour < 100) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item21 = $item21 + $performance;
                    $item21_count++;
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item22 = $item22 + $performance;
                    $item22_count++;
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item23 = $item23 + $performance;
                    $item23_count++;
                }
                // For Improvement very Strong
                if ($performance >= 60 && $performance < 80) {
                    $item24 = $item24 + $performance;
                    $item24_count++;
                }
                // For Improvement Outstanding
                if ($performance >= 80 && $performance < 100) {
                    $item25 = $item25 + $performance;
                    $item25_count++;
                }
            }

            //  var_dump($performance);
        }

        // For Colum 1
        $data['improvement'] = ($item1 > 0) ? $item1_count : 0;
        $data['improvement_good'] = ($item2 > 0) ? $item2_count : 0;
        $data['improvement_strong'] = ($item3 > 0) ? $item3_count : 0;
        $data['improvement_very_strong'] = ($item4 > 0) ? $item4_count : 0;
        $data['improvement_outstanding'] = ($item5 > 0) ? $item5_count : 0;

        // For Column 2
        $data['good_improvement'] = ($item6 > 0) ? $item6_count : 0;
        $data['good'] = ($item7 > 0) ? $item7_count : 0;
        $data['good_strong'] = ($item8 > 0) ? $item8_count : 0;
        $data['good_very_strong'] = ($item9 > 0) ? $item9_count : 0;
        $data['good_outstanding'] = ($item10 > 0) ? $item10_count : 0;

        // For Column 3
        $data['strong_improvement'] = ($item11 > 0) ? $item11_count : 0;
        $data['strong_good'] = ($item12 > 0) ? $item12_count : 0;
        $data['strong'] = ($item13 > 0) ? $item13_count : 0;
        $data['strong_very_strong'] = ($item14 > 0) ? $item14_count : 0;
        $data['strong_outstanding'] = ($item15 > 0) ? $item15_count : 0;

        // For Column 4
        //  $data['very_strong_improvement'] = ($item16 > 0) ? $item16_count : 0;
        //  $data['very_strong_good'] = ($item17 > 0) ? $item17_count : 0;
        //  $data['very_strong_strong'] = ($item18 > 0) ? $item18_count : 0;
        //  $data['very_strong'] = ($item19 > 0) ? $item19_count : 0;
        //  $data['very_strong_outstanding'] = ($item20 > 0) ? $item20_count : 0;

        // For Column 5
        $data['outstanding_improvement'] = ($item21 > 0) ? $item21_count : 0;
        $data['outstanding_good'] = ($item22 > 0) ? $item22_count : 0;
        $data['outstanding_strong'] = ($item23 > 0) ? $item23_count : 0;
        $data['outstanding_very_strong'] = ($item24 > 0) ? $item24_count : 0;
        $data['outstanding'] = ($item25 > 0) ? $item25_count : 0;

        $par = 'item' . $id . '_data';
        $data2['result'] = $data[$par];
        // $data2['result'] = $data['item22_data'] ;

        // dd($data['item23_data'] );
        // return $data2;
        return view('performance.performance_details', $data2);
    }

    public function performance_ratio()
    {
        $ratio = PerformanceRatio::first();
        return view('performance.performance-ratios', compact('ratio'));
    }

    // For Saving Performance Ratios
    public function save_performance_ratio(Request $request)
    {

        $ratio = PerformanceRatio::first();

        if (($request->behaviour + $request->achievement + $request->time) != 100) {
            return redirect('flex/performance')->with('msg', 'Total of Performance should be equal to 100');
        }
        if ($ratio) {

            $ratio->behaviour = $request->behaviour;
            $ratio->target = $request->achievement;
            $ratio->time = $request->time;
            $ratio->update();
        } else {
            $ratio = new PerformanceRatio();
            $ratio->behaviour = $request->behaviour;
            $ratio->target = $request->achievement;
            $ratio->time = $request->time;
            $ratio->save();
        }

        return redirect('flex/performance');
    }

    public function employee_profiles()
    {

        $data['employees'] = EMPL::where('state', '1')->get();
        return view('talent.profiling', $data);
    }

    //   For Viewing All Talent ranges
    public function talent_ranges()
    {

        $data['target_ratio'] = TargetRatio::all();
        $data['time_ratio'] = TimeRatio::all();
        $data['behaviour_ratio'] = BehaviourRatio::all();
        return view('talent.talent_range', $data);
    }

    public function talent_ratios()
    {
        $ratio = PerformanceRatio::first();
        return view('talent.talent-ratios', compact('ratio'));
    }

    // For Saving Talent Ratio
    public function save_talent_ratio(Request $request)
    {

        $ratio = PerformanceRatio::first();

        if (($request->behaviour + $request->achievement + $request->time) != 100) {
            return redirect('flex/talent-ratio')->with('msg', 'Total of Talent Ratio should be equal to 100');
        }
        if ($ratio) {

            $ratio->behaviour = $request->behaviour;
            $ratio->target = $request->achievement;
            $ratio->time = $request->time;
            $ratio->update();
        } else {
            $ratio = new PerformanceRatio();
            $ratio->behaviour = $request->behaviour;
            $ratio->target = $request->achievement;
            $ratio->time = $request->time;
            $ratio->save();
        }

        return redirect('flex/performance');
    }

    public function talent_matrix()
    {
        $employee = EMPL::all();

        $item1 = 0;
        $item1_count = 0;

        $item2 = 0;
        $item2_count = 0;

        $item3 = 0;
        $item3_count = 0;

        $item4 = 0;
        $item4_count = 0;

        $item5 = 0;
        $item5_count = 0;

        $item6 = 0;
        $item6_count = 0;

        $item7 = 0;
        $item7_count = 0;

        $item8 = 0;
        $item8_count = 0;

        $item9 = 0;
        $item9_count = 0;

        foreach ($employee as $item) {
            $performance = DB::table('employee')
                ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
                ->where('employee.emp_id', $item->emp_id)
                ->whereNotNull('employee_performances.performance')
                // ->join('adhoc_tasks', 'employee.emp_id', '=', 'adhoc_tasks.assigned')
                ->avg('employee_performances.performance')
                // ->get()
            ;

            $behaviour = DB::table('employee')
                ->join('employee_performances', 'employee.emp_id', '=', 'employee_performances.empID')
                ->where('employee.emp_id', $item->emp_id)
                ->whereNotNull('employee_performances.behaviour')
                // ->join('adhoc_tasks', 'employee.emp_id', '=', 'adhoc_tasks.assigned')
                ->avg('employee_performances.behaviour');

            $position = PositionSkills::where('position_ref', $item->position)->count();
            $skills = EmployeeSkills::where('empID', $item->emp_id)->count();

            if ($skills > 0 && $position) {
                $potential = number_format($skills / $position, 2) * 100;
            } else {
                $potential = 0;
            }

            // $achieved= EmployeePerformance::where('empID',$item->emp_id)->avg('achieved');
            // $target= EmployeePerformance::where('empID',$item->emp_id)->avg('target');

            // if ($achieved>0)
            // { $potential=  number_format( $achieved/$target, 2);  }
            // else{ $potential= 0;}

            // For Low Potential
            if ($potential > 0 && $potential < 20) {
                //For Low performer
                if ($performance > 0 && $performance < 20) {
                    $item1 = $item1 + $performance;
                    $item1_count++;
                }
                // For Medium Performer
                if ($performance >= 20 && $performance < 40) {
                    $item2 = $item2 + $performance;
                    $item2_count++;
                }
                // For High Performer
                if ($performance >= 40 && $performance < 60) {
                    $item3 = $item3 + $performance;
                    $item3_count++;
                }
            }

            // For Medium Potential
            if ($potential >= 20 && $potential < 40) {
                //For Low Performer
                if ($performance > 0 && $performance < 20) {
                    $item4 = $item4 + $performance;
                    $item4_count++;
                }
                // For Medium Performer
                if ($performance >= 20 && $performance < 40) {
                    $item5 = $item5 + $performance;
                    $item5_count++;
                }
                // For High Performer
                if ($performance >= 40 && $performance < 60) {
                    $item6 = $item6 + $performance;
                    $item6_count++;
                }
            }

            // For High Potential
            if ($potential >= 40 && $potential < 60) {
                //For Improvement
                if ($performance > 0 && $performance < 20) {
                    $item7 = $item7 + $performance;
                    $item8_count++;
                }
                // For Improvement Good
                if ($performance >= 20 && $performance < 40) {
                    $item8 = $item8 + $performance;
                    $item8_count++;
                }
                // For Improvement Strong
                if ($performance >= 40 && $performance < 60) {
                    $item9 = $item9 + $performance;
                    $item9_count++;
                }
            }
        }

        // For Colum 1
        $data['high_performer_potential'] = ($item1 > 0) ? $item1_count : 0;
        $data['high_performer_medium_potential'] = ($item2 > 0) ? $item2_count : 0;
        $data['high_performer_low_potential'] = ($item3 > 0) ? $item3_count : 0;

        // For Column 2
        $data['medium_performer_high_potential'] = ($item4 > 0) ? $item6_count : 0;
        $data['medium_performer_potential'] = ($item5 > 0) ? $item5_count : 0;
        $data['medium_performer_low_potential'] = ($item6 > 0) ? $item6_count : 0;

        // For Column 3
        $data['low_performer_high_potential'] = ($item7 > 0) ? $item7_count : 0;
        $data['low_performer_medium_potential'] = ($item8 > 0) ? $item8_count : 0;
        $data['low_performer_potential'] = ($item9 > 0) ? $item9_count : 0;

        return view('talent.talent_matrix', $data);
    }


    public function loan_types()
    {
        $data['loan_types'] = LoanType::all();
        // dd($data);
        return view('loans.loan_types', $data);
    }

    public function saveLoanType(Request $request)
    {
        request()->validate(
            [
                'name' => 'required',
                'code' => 'nullable',
            ]
        );

        $loan_types = new LoanType();
        $loan_types->name = $request->name;
        $loan_types->code = $request->code;
        $loan_types->save();

        $msg = "Loan Type has been added Successfully !";
        return redirect('flex/loan_types')->with('msg', $msg);
    }
}
