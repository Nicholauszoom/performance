<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function get_leave_days($emp_id)
    {

        $leave_days = Employee::where('emp_id', $emp_id)->pluck('leave_days_entitled');

        // Check if leave days were found for the employee
        if ($leave_days->isNotEmpty()) {
            $leaveDaysEntitled = $leave_days[0];

            return $leaveDaysEntitled;
        } else {
            echo "Leave days not found for employee with ID $emp_id";
        }


        return $leave_days;
    }

    public function update_leave_days(Request $request)
    {
        $emp_id = $request->employee_id;
        $leave_days_entitled = $request->leave_days_entitled;
        $new_accrual_rate = ($request->leave_days_entitled)/12;
        $effective_date = $request->effective_date;

        $employee = Employee::where('emp_id', $emp_id)->first();

        if ($employee) {
            $employee->old_leave_days_entitled =  $employee->leave_days_entitled;
            $employee->old_accrual_rate =  $employee->accrual_rate;
            $employee->accrual_rate =  $new_accrual_rate;
            $employee->leave_days_entitled = $leave_days_entitled;
            $employee->leave_effective_date = $effective_date;

            // Save the changes
            $employee->save();

            return back()->with('status', 'Leave days updated successfully!');
        } else {
            return back()->with('error', 'Employee not found!');
        }
    }




}
