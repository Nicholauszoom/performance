<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\EMPL;
use App\Models\Holiday;
use App\Models\Position;
use App\Models\AuditTrail;
use App\Models\ApprovalLevel;
use App\Models\Approvals;
use App\Models\UserRole;

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
    public static function FinancialLogs($empID, $fieldName, $from, $to, $inputScreen, $created_at = null)
    {
        if (empty($created_at)) {
            FinancialLogs::create([
                'payrollno' => $empID,
                'changed_by' => Auth::user()->emp_id,
                'field_name' => $fieldName,
                'action_from' => $from,
                'action_to' => $to,
                'input_screen' => $inputScreen
            ]);
        } else {
            FinancialLogs::create([
                'payrollno' => $empID,
                'changed_by' => Auth::user()->emp_id,
                'field_name' => $fieldName,
                'action_from' => $from,
                'action_to' => $to,
                'input_screen' => $inputScreen,
                'created_at' => $created_at
            ]);
        }
    }
    public static function employeeData($empID)
    {
        $details = EMPL::where('emp_id', $empID)->first();
        return $details;
    }
    public static function position($pos)
    {
        $position=DB::table('position')->where('name',$pos)->first();
        $details = EMPL::where('position', $position->id)->first();
        return $details;
    }

    public static function getUserPosition($id){
        // Takes in position ID returns name
        return Position::where('id',$id)->get()->pluck('name')[0];
    }
    public static function approvalEmp($position1, $position2)
    {
        // $first = DB::table('employees')
        //     ->where('job_title', $position1);
        $pos = Position::with('employees')->where('name', $position1)
            ->orWhere('name', 'LIKE', '%' . $position2 . '%')
            ->get();

        // $pos = Position::where('name', $name)->get();
        // return $users;

        return $pos;
        // dd($users->toArray());
    }

    // For Working Days

    public static function countWorkingDays($start, $end)
    {

        // Convert start and end dates to Carbon instances
        $startDate = Carbon::parse($start);
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
            if ($currentDate->isSameDay(Carbon::parse('2023-04-02'))) {
                continue;
            }

            // If it's a working day, increment the counter
            $workingDays++;
        }

        // Return the number of working days
        return $workingDays;
    }

    public static function countWorkingDaysForOtherLeaves($start, $end)
    {

        // Convert start and end dates to Carbon instances
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);

        // Count the number of days between start and end date
        $days = $endDate->diffInDays($startDate);

        // Initialize a counter for working days
        $workingDays = $days;



        // Return the number of working days
        return $workingDays+1;
    }


    //   For Holidays in Weekdays Counting

    public static function countHolidays($start, $end)
    {

        // Convert start and end dates to Carbon instances
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);


        $year1 = $startDate->format('Y');
        $year2 = $endDate->format('Y');
        $workingDays = 0;
        if ($year1 == $year2) {
            // Create an array of holidays
            $holidays = Holiday::whereBetween('date', [$startDate, $endDate])->count();

            $week_day = Holiday::whereBetween('date', [$startDate, $endDate])->get();
            $days = $endDate->diffInDays($startDate);

            // Loop through each day between start and end date
            for ($i = 0; $i <= $days; $i++) {

                // Get the current date
                $currentDate = $startDate->copy()->addDays($i);
                foreach ($week_day as $item) {
                    // Check if the current day is a holiday (you can customize this to your needs)
                    if ($currentDate->isSameDay(\Carbon\Carbon::parse($item->date))) {
                        if (Carbon::parse($item->date)->isWeekend()) {
                            continue;
                        }
                        $workingDays++;
                    }
                }
            }
        } else {
            // For Current Year
            $date1 = Carbon::parse('2022-12-31');
            $new_date = Carbon::parse($date1)->setYear(date('Y'));
            $this_year = Holiday::whereBetween('date', [$startDate, $new_date])->count();
            $week_day = Holiday::whereBetween('date', [$startDate, $new_date])->get();
            $days = $new_date->diffInDays($startDate);

            // Loop through each day between start and end date
            for ($i = 0; $i <= $days; $i++) {

                // Get the current date
                $currentDate = $startDate->copy()->addDays($i);
                foreach ($week_day as $item) {
                    // Check if the current day is a holiday (you can customize this to your needs)
                    if ($currentDate->isSameDay(\Carbon\Carbon::parse($item->date))) {
                        if (Carbon::parse($item->date)->isWeekend()) {
                            continue;
                        }
                        $workingDays++;
                    }
                }
            }


            // For The Following Year
            $date2 = Carbon::parse('2022-01-01');
            $new_date1 = Carbon::parse($date2)->setYear($year2);
            $holiday = Holiday::where('recurring', '1')->get();

            foreach ($holiday as $value) {
                $new_dat = Carbon::parse($value->date)->setYear($year2);

                $holid = Holiday::find($value->id);
                $holid->date = $new_dat;
                $holid->update();
            }
            // $next_year=Holiday::whereBetween('date', [$new_date1, $endDate])->where('recurring','1')->count();
            $week_day = Holiday::whereBetween('date', [$new_date1, $endDate])->where('recurring', '1')->get();
            $days = $new_date->diffInDays($startDate);

            // Loop through each day between start and end date
            for ($i = 0; $i <= $days; $i++) {

                // Get the current date
                $currentDate = $new_date1->copy()->addDays($i);
                foreach ($week_day as $item) {
                    // Check if the current day is a holiday (you can customize this to your needs)
                    if ($currentDate->isSameDay(\Carbon\Carbon::parse($item->date))) {
                        if (Carbon::parse($item->date)->isWeekend()) {
                            continue;
                        }
                        $workingDays++;
                    }
                }
            }
            $holiday = Holiday::where('recurring', '1')->get();

            foreach ($holiday as $value) {
                $new_dat = Carbon::parse($value->date)->setYear(date('Y'));

                $holid = Holiday::find($value->id);
                $holid->date = $new_dat;
                $holid->update();
            }
        }




        return $workingDays;
    }

    public static function isDateNextToWeekendOrHoliday($dateString) {
        $parsedDate = Carbon::parse($dateString);

        // Check if the date is next to weekends (Friday or Monday)
        if ($parsedDate->isFriday() || $parsedDate->isMonday()) {
            return true; // It's next to a weekend
        }

        // Check if the date is a holiday or the day before/after a holiday
        $holidays = Holiday::pluck('date')->toArray();
        if (in_array($parsedDate->toDateString(), $holidays) ||
            in_array($parsedDate->copy()->addDay()->toDateString(), $holidays) ||
            in_array($parsedDate->copy()->subDay()->toDateString(), $holidays)) {
            return true; // It's next to a holiday
        }

        return false; // It's not next to a weekend or holiday
    }



    public static function approvalCheck($process_name, $approval_status)
    {


        
        $employee = auth()->user()->id;
        $role_id = Auth::user()->position;
        $position = Position::where('id', $role_id)->first();

 
        $process = Approvals::where('process_name', $process_name)->first();
        if (!$process) {
            return false;
        }
    
        $level = ApprovalLevel::where('role_id', $role_id)
            ->where('approval_id', $process->id)
            ->first();


        return $level && $level->level_name == $approval_status;
    }
    


}