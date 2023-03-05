<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\EMPL;
use App\Models\Position;
use App\Models\AuditTrail;
use Illuminate\Http\Request;
use App\Models\FinancialLogs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SysHelpers
{

    /**
     * Funtion for creating audit logs for every action that has to be perfromed
     * inside the performance system
     *
     * risk [1-High, 2-mdeium, 3-low]
     * action [Actions to be performed inside the system]
     * ip of the machine that is being used
     *
     * @param int $risk
     * @param string $action
     * @param string $ip
     * @return void
     */
    public static function AuditLog($risk, $action, Request $request)
    {
        $employee = Auth::user()->fname . ' ' . Auth::user()->mname . ' ' . Auth::user()->lname;
       // $row = DB::table('payroll_months')->select('payroll_date')->last();
       // $previous_payroll_month_raw = date('Y-m', strtotime(date('Y-m-d', strtotime($current_payroll_month . "-1 month"))));

        AuditTrail::create([
            'emp_id' => Auth::user()->emp_id,
            'emp_name' => $employee,
            'action_performed' => $action,
            'ip_address' =>  $request->ip(),
            'user_agent' => $request->userAgent(),
            'risk' => $risk,
        ]);
    }

    /**
     * Undocumented function
     *
     *
     * [ emmp_id, auth_edit, Field name[action performed], from, to, input screen]
     *
     * @param Request $request
     * @return void
     */
    public static function FinancialLogs($empID, $fieldName, $from, $to, $inputScreen)
    {
        FinancialLogs::create([
            'payrollno' => $empID,
            'changed_by' => Auth::user()->emp_id,
            'field_name' => $fieldName,
            'action_from' => $from,
            'action_to' => $to,
            'input_screen' => $inputScreen
        ]);
    }
    public static function employeeData($empID)
    {
        $details = EMPL::where('emp_id', $empID)->first();
        return $details;
    }
    public static function position($pos)
    {
        $details = EMPL::where('job_title', $pos)->first();
        return $details;
    }
    public static function approvalEmp($position1, $position2)
    {
        // $first = DB::table('employees')
        //     ->where('job_title', $position1);
        $pos = Position::with('employees')->where('name',$position1)
            ->orWhere('name','LIKE', '%'.$position2.'%')
            ->get();

        // $pos = Position::where('name', $name)->get();
        // return $users;

        return $pos;
        // dd($users->toArray());
    }

    // For Working Days

   public static function countWorkingDays($start, $end) {

        // Convert start and end dates to Carbon instances
        $startDate = \Carbon\Carbon::parse($start );
        $endDate = Carbon::parse($end);
        
        // Count the number of days between start and end date
        $days = $endDate->diffInDays($startDate);
        
        // Initialize a counter for working days
        $workingDays = 0;
      
        // Loop through each day between start and end date
        for ($i = 0; $i <= $days; $i++) {
            
            // Get the current date
            $currentDate = $startDate->copy()->addDays($i);
            
            // Check if the current day is a weekend (Saturday or Sunday)
            if ($currentDate->isWeekend()) {
                continue;
            }
            
            // Check if the current day is a holiday (you can customize this to your needs)
            if ($currentDate->isSameDay(\Carbon\Carbon::parse('2023-04-02'))) {
                continue;
            }
      
            // If it's a working day, increment the counter
            $workingDays++;
        }
      
        // Return the number of working days
        return $workingDays;
      }
}
