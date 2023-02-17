<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll\FlexPerformanceModel;

class NSSFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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


    public function userprofile(Request $request, $id)
    {
        $id = base64_decode($id);

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

}
