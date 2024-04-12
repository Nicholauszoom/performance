<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use DateTime;

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

           $earlier_days_accrued = $this->getAccrualDays($employee);
           $employee->earlier_accrual_days = $earlier_days_accrued;

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

    public function getAccrualDays($employee){


        $today = date('Y-m-d');
        $arryear = explode('-', $today);
        $year = $arryear[0];

        $employeeHiredate = explode('-', $employee->hire_date);
        $employeeHireYear = $employeeHiredate[0];
        $employeeDate = '';

        if ($employeeHireYear == $year) {
            $employeeDate = $employee->hire_date;

        } else {
            $employeeDate = $year . ('-01-01');
        }


        $d1 = new DateTime($employeeDate);

        $d2 = new DateTime($today);

        $diff = $d1->diff($d2);

        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;

        if ($employee->leave_effective_date) {
            if (date('Y-m-d') <= $employee->leave_effective_date) {
                // If the current date is before or equal to the leave effective date
                $employee->accrual_rate = $employee->old_accrual_rate;
                $accrual_days = (($days * $employee->accrual_rate) / 30) + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;

            } else {
                $accrual_days = (($days * $employee->accrual_rate) / 30) + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;
            }
        } else {
            // If leave_effective_date is null
            $accrual_days = (($days * $employee->accrual_rate) / 30) + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;
        }

        return $accrual_days;
    }



}
