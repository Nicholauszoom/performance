<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SysHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AccountCheck;
use App\Models\Payroll\FlexPerformanceModel;


class AuthenticatedSessionController extends Controller
{

    protected $flexperformance_model;

    public function __construct(FlexPerformanceModel $flexperformance_model){
        $this->flexperformance_model = $flexperformance_model;
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $data['next'] = $request->query('next');
        return view('auth.login',$data);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {

        dd('Here we are');
        $request->authenticate();

        if($this->password_set(Auth::user()->emp_id) == 1){

            return redirect('/change-password');

        }else{
            $this->setPermissions(Auth::user()->emp_id);
            $result=$this->dateDiffCalculate();
            if($result >= 90){
                return redirect('/change-password')->with('status', 'You password has expired');
            }
            $request->session()->regenerate();
            // dd(session()->all());
            if (session('pass_age') >= 90) {

                return redirect('/change-password')->with('status', 'You password has expired');

            }else{
                $employeeName = Auth::user()->fname.' '.Auth::user()->mname;

                SysHelpers::AuditLog(1, 'Logged in with '.$employeeName , $request);

                // redirect to specific page if $request->next is set
                if($request->next){
                    return redirect($request->next);
                }
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }

    }

    public function password_set($empID)
    {
        $query = DB::table('employee')
                ->select('password_set')
                ->where('emp_id', $empID)
                ->limit(1)
                ->first();

        if($query){
            return $query->password_set;
        }else{
            return 'UNKNOWN';
        }
    }

    /**
     * Checking if the employee account has been activated
     *
     * @param [type] $emp_id
     * @return status
     */
    public function checkActiveAccount($emp_id)
    {
        $status = DB::table('sys_account')
            ->select('account')
            ->where('emp_id', $emp_id)
            ->first();

        if(empty($status)){
            return "404";
        } else {
            return $status->account;
        }
    }



    public function setPermissions($emp_id)  {

        $query = "SELECT e.*, d.name as dname, c.name as CONTRACT, d.id as departmentID, p.id as positionID, p.name as pName, (SELECT CONCAT(fname,' ', mname,' ', lname) from employee where  emp_id = e.line_manager) as lineManager from employee e, contract c, department d, position p WHERE d.id=e.department and e.contract_type = c.id and p.id=e.position and (e.state = '1' or e.state = '3')  and e.emp_id ='".$emp_id."'";

		$data = DB::select(DB::raw($query));

        // dd($data);

		// if(count($row)>0) {
		// 	return $row;
		// }
    //    $res= $this->dateDiffCalculate($data);
    //    return $res;

        $data = $data[0];
        $data = json_encode($data);
        $data = json_decode($data, true);
        $res = $this->dateDiffCalculate();


        if($data) {
            session(['pass_age' => $res]);
            // session(['logo' =>$this->flexperformance_model->logo()]);
            session(['id' =>$data['id']]);
            session(['emp_id' =>$data['emp_id']]);

            session(['password_set' =>$data['password_set']]);
            session(['username' =>$data['username']]);
            session(['password' =>$data['password']]);
            session(['email' =>$data['email']]);
            session(['fname' =>$data['fname']]);
            session(['mname' =>$data['mname']]);
            session(['lname' =>$data['lname']]);
            session(['position' =>$data['pName']]);
            session(['departmentID' =>$data['departmentID']]);
            session(['positionID' =>$data['positionID']]);
            session(['photo' =>$data['photo']]);
            session(['birthdate' =>$data['birthdate']]);
            session(['nationality' =>$data['nationality']]);
            session(['gender' =>$data['gender']]);
            session(['merital_status' =>$data['merital_status']]);
            session(['department' =>$data['dname']]);
            session(['postal_city' =>$data['postal_city']]);
            session(['mobile' =>$data['mobile']]);
            session(['linemanager' =>$data['lineManager']]);
            session(['ctype' =>$data['CONTRACT']]);
            session(['postal_address' =>$data['postal_address']]);
            session(['physical_address' =>$data['physical_address']]);
            session(['salary' =>$data['salary']]);
            session(['account_no' =>$data['account_no']]);
            session(['last_updated' =>$data['last_updated']]);
            session(['pf_membership_no' =>$data['pf_membership_no']]);
            session(['hire_date' =>$data['hire_date']]);

        }

        $this->getPermissions();

    }

    public function getPermissions()  {
        $id =session('emp_id');
        $empID =session('emp_id');

        // dd( $this->getpermission($empID, '0'),$empID);

        // NEW ROLES AND PERMISSION;
        session(['vw_emp_sum'=> $this->getpermission($empID, '0')]);
        session(['vw_payr_sum'=> $this->getpermission($empID, '1')]);
        session(['vw_dept_proj_sum'=> $this->getpermission($empID, '2')]);
        session(['vw_org_proj_sum'=> $this->getpermission($empID, '3')]);
        session(['vw_emp'=> $this->getpermission($empID, '4')]);
        session(['mng_emp'=> $this->getpermission($empID, '5')]);
        session(['appr_emp'=> $this->getpermission($empID, '6')]);
        session(['vw_proj'=> $this->getpermission($empID, '7')]);
        session(['mng_proj'=> $this->getpermission($empID, '8')]);
        session(['vw_leave'=> $this->getpermission($empID, '9')]);
        session(['mng_leave'=> $this->getpermission($empID, 'a')]);
        session(['appr_leave'=> $this->getpermission($empID, 'b')]);
        session(['mng_attend'=> $this->getpermission($empID, 'c')]);
        session(['mng_leave_rpt'=> $this->getpermission($empID, 'd')]);
        session(['vw_org'=> $this->getpermission($empID, 'e')]);
        session(['mng_org'=> $this->getpermission($empID, 'f')]);
        session(['recom_paym'=> $this->getpermission($empID, 'g')]);
        session(['mng_stat_rpt'=> $this->getpermission($empID, 'h')]);
        session(['mng_paym'=> $this->getpermission($empID, 'i')]);
        session(['gen_payslip'=> $this->getpermission($empID, 'j')]);
        session(['use_salary_calc'=> $this->getpermission($empID, 'k')]);
        session(['appr_paym'=> $this->getpermission($empID, 'l')]);
        session(['mng_roles_grp'=> $this->getpermission($empID, 'm')]);
        session(['mng_audit'=> $this->getpermission($empID, 'n')]);
        session(['mng_bank_info'=> $this->getpermission($empID, 'o')]);
        session(['recom_deduction'=> $this->getpermission($empID, 'p')]);
        session(['appr_deduction'=> $this->getpermission($empID, 'q')]);
        session(['mgn_deduction'=> $this->getpermission($empID, 'r')]);
        session(['vw_dept_allocation'=> $this->getpermission($empID, 's')]);
        session(['vw_settings'=> $this->getpermission($empID, 't')]);
        session(['vw_proj'=> $this->getpermission($empID, 'u')]);
        session(['vw_trans'=> $this->getpermission($empID, 'v')]);
        session(['vw_org'=> $this->getpermission($empID, 'w')]);
        session(['appr_loan'=> $this->getpermission($empID, 'q')]);


        //set default strategy as current strategy
        $defaultStrategy = $this->getCurrentStrategy();
        session(['current_strategy'=> $defaultStrategy]);

        // $logData = array(
        //    'empID' =>session('emp_id'),
        //    'description' => "Logged In",
        //    'agent' =>session('agent'),
        //    'platform' =>$this->agent->platform(),
        //    'ip_address' =>$this->input->ip_address()
        // );

        // $result = $this->insertAuditLog($logData);


    }

    public function getpermission($empID, $permissionID)
	{
		// $query = "SELECT r.permissions as permission FROM emp_role er, role r WHERE er.role=r.id and er.userID='".$empID."'  and r.permissions like '%".$permissionID."%'";
		// $results = DB::select(DB::raw($query));
		// // ->count();
		// if ($results > 0) {
		// 	return true;
		// }else{
		// 	return false;
		// }

        return true;
	}

    public function insertAuditLog($logData)
	{
		DB::table('audit_logs')->insert($logData);
		return true;

	}

    public function password_age($empID)
	{

        $query = DB::table('user_passwords')->select('time')->where('empID', Auth::user()->emp_id)
            ->limit(1)
            ->orderBy('id', 'desc')
            ->first();

            return $query->time;
	}

    function getCurrentStrategy()
	{
		// $query = "id as strategyID  ORDER BY id DESC limit 1";

        $row =  DB::table('strategy')
            ->select('id as strategyID')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->first();

        // $row = DB::
    	return $row;
	}

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return  redirect('/');
    }

    public function dateDiffCalculate(){
        $from = $this->password_age(Auth::user()->emp_id);

        $from = date_create($from);

        $today=date_create(date('Y-m-d'));

        $diff=date_diff($from, $today);

        $accrued = $diff->format("%a%") + 1;
        return $accrued;
    }
}
