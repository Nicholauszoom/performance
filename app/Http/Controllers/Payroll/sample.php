<?php
public function annualLeaveData2(Request $request)
    {
        # code...

        $empID = $request->emp_id;
        $today = $request->duration;
        $nature = $request->nature;
        $department = $request->department;
        $position = $request->position;
        $print_type = $request->print_type;

        $date = explode('-', $request->duration);
        // $dur = $date[0].'-'.$date[1];
        $year = $date[0];
        $month = $date[1];
        // $dur = date('Y-m', strtotime($month));
        // dd($dur);
        if($nature != 'All'){

            $data['leave_data'] = $this->attendance_model->getMonthlyLeave2($empID,$today,$nature,$department,$position);
            $data['nature'] = $this->attendance_model->leave_name($nature);
            $leave_name = $this->attendance_model->leave_name($nature);
        }else {
            $natures = $this->attendance_model->getAllNatureValues($nature);
            $data['nature'] = 'All';
            $leave_name = 'All Approved';
            $allLeaveData = [];
            foreach($natures as $_nature){
                $allLeaveData = array_merge($allLeaveData, $this->attendance_model->getpendingLeaves1($empID,$today,$_nature->id,$department,$position)->toArray());

            }
            $data['leave_data'] = $allLeaveData;
            $data['is_all'] = true;
        }

        $data['date'] = $today;
        // dd($leave_data);
        //return view('reports.leave_application_datatable',$data);

        if($department != 'All'){
            $data['department_name'] = $this->attendance_model->get_dept_name($department);
        }
        if($position != 'All'){
            $data['position_name'] = $this->attendance_model->get_position_name($department);
        }
        // $leave_name = $this->attendance_model->leave_name($nature);


           $data['nature'] =  $nature;
           $data['leave_name'] = $leave_name;
           $data['date'] = $request->duration;
        // dd($employees);
        // $leave_name = $this->attendance_model->leave_name($nature);


        $other = ' ';
        if(!empty($data['department_name']))
          $other = 'Department : '.$data['department_name'];
        elseif(!empty($data['position_name']))
         $other =  'Position : '. $data['position_name'];
       // $january = $calender[0].'-01-01';

        $data['excelTitle'] = $leave_name.' Leave Report | '.$other.' | Date :'.date('d-M-Y',strtotime($data['date']));
        if($request->type == 1){

            $pdf = Pdf::loadView('reports.leave_application',$data)->setPaper('a4', 'landscape');
            return $pdf->download('Leave_apprication_report'.$request->duration.'.pdf');


        }else{

            return view('reports.leave_application_datatable',$data);

        }

    }
