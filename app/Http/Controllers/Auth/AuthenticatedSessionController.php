<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $this->setPermissions();

        return redirect()->intended(RouteServiceProvider::HOME);
    }



    public function setPermissions(Request $request)  {


        $data=$this->flexperformance_model->login_user($username, $password);
        $from="";
        $last_pass_date = $this->flexperformance_model->password_age($username);
        foreach($last_pass_date as $row){
          $from = $row->time;
        }

        $from = date_create($from);
        $today=date_create(date('Y-m-d'));
        $diff=date_diff($from, $today);
        $accrued = $diff->format("%a%")+1;


        $this->getPermissions();


        if($data) {       
            session(['pass_age' => $accrued]);
            session(['logo' =>$this->flexperformance_model->logo()]);
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
            
    }

    public function getPermissions(Request $request)  {
        $id =session('emp_id');
        $empID =session('emp_id');
    
        // NEW ROLES AND PERMISSION;
        session(['vw_emp_sum'=> $this->flexperformance_model->getpermission($empID, '0')]);
        session(['vw_payr_sum'=> $this->flexperformance_model->getpermission($empID, '1')]);
        session(['vw_dept_proj_sum'=> $this->flexperformance_model->getpermission($empID, '2')]);
        session(['vw_org_proj_sum'=> $this->flexperformance_model->getpermission($empID, '3')]);
        session(['vw_emp'=> $this->flexperformance_model->getpermission($empID, '4')]);
        session(['mng_emp'=> $this->flexperformance_model->getpermission($empID, '5')]);
        session(['appr_emp'=> $this->flexperformance_model->getpermission($empID, '6')]);
        session(['vw_proj'=> $this->flexperformance_model->getpermission($empID, '7')]);
        session(['mng_proj'=> $this->flexperformance_model->getpermission($empID, '8')]);
        session(['vw_leave'=> $this->flexperformance_model->getpermission($empID, '9')]);
        session(['mng_leave'=> $this->flexperformance_model->getpermission($empID, 'a')]);
        session(['appr_leave'=> $this->flexperformance_model->getpermission($empID, 'b')]);
        session(['mng_attend'=> $this->flexperformance_model->getpermission($empID, 'c')]);
        session(['mng_leave_rpt'=> $this->flexperformance_model->getpermission($empID, 'd')]);
        session(['vw_org'=> $this->flexperformance_model->getpermission($empID, 'e')]);
        session(['mng_org'=> $this->flexperformance_model->getpermission($empID, 'f')]);
        session(['recom_paym'=> $this->flexperformance_model->getpermission($empID, 'g')]);
        session(['mng_stat_rpt'=> $this->flexperformance_model->getpermission($empID, 'h')]);
        session(['mng_paym'=> $this->flexperformance_model->getpermission($empID, 'i')]);
        session(['gen_payslip'=> $this->flexperformance_model->getpermission($empID, 'j')]);
        session(['use_salary_calc'=> $this->flexperformance_model->getpermission($empID, 'k')]);
        session(['appr_paym'=> $this->flexperformance_model->getpermission($empID, 'l')]);
        session(['mng_roles_grp'=> $this->flexperformance_model->getpermission($empID, 'm')]);
        session(['mng_audit'=> $this->flexperformance_model->getpermission($empID, 'n')]);
        session(['mng_bank_info'=> $this->flexperformance_model->getpermission($empID, 'o')]);
        session(['recom_deduction'=> $this->flexperformance_model->getpermission($empID, 'p')]);
        session(['appr_deduction'=> $this->flexperformance_model->getpermission($empID, 'q')]);
        session(['mgn_deduction'=> $this->flexperformance_model->getpermission($empID, 'r')]);
        session(['vw_dept_allocation'=> $this->flexperformance_model->getpermission($empID, 's')]);
        session(['vw_settings'=> $this->flexperformance_model->getpermission($empID, 't')]);
        session(['vw_proj'=> $this->flexperformance_model->getpermission($empID, 'u')]);
        session(['vw_trans'=> $this->flexperformance_model->getpermission($empID, 'v')]);
        session(['vw_org'=> $this->flexperformance_model->getpermission($empID, 'w')]);
    
    
        //set default strategy as current strategy
        $defaultStrategy = $this->flexperformance_model->getCurrentStrategy();
        session(['current_strategy'=> $defaultStrategy]);
    
        $logData = array(
           'empID' =>session('emp_id'),
           'description' => "Logged In",
           'agent' =>$this->session->userdata('agent'),
           'platform' =>$this->agent->platform(),
           'ip_address' =>$this->input->ip_address()
        ); 
    
        $result = $this->flexperformance_model->insertAuditLog($logData);

            
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

        return  redirect('/flex/');
    }
}
