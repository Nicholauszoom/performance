<?php

namespace App\Console\Commands;
use App\Models\Employee;
use App\Models\AttendanceModel;
use App\Models\LeaveForfeiting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth; // Create this import


class BroughtFowardAnnualRemainingDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaves:annual_remaining_brought_foward';

    protected $attendance_model;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    // public function __construct(){
    //     $this->attendance_model = new AttendanceModel();
    // }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->brought_remaing_days();
        $this->info('Your scheduled task has been executed.');


        return Command::SUCCESS;
    }

    public function brought_remaing_days(){
        $this->attendance_model = new AttendanceModel();

        $employees = Employee::get();

        $today = date('Y-m-d');
        $year = date('Y');
        $employeeDate = '';
        foreach ($employees as $value) {
            $employeeHiredate = explode('-', $value->hire_date);
            $employeeHireYear = $employeeHiredate[0];

            if ($employeeHireYear == $year) {
                $employeeDate = $value->hire_date;
            } else {
                $employeeDate = $year . '-01-01';
            }



            $opening_balance = $this->attendance_model->getLeaveBalance($value->emp_id, $employeeDate, $year . '-12-31');

            // Find the LeaveForfeiting model for the employee or create a new one if it doesn't exist
            $leave_forfeit = LeaveForfeiting::firstOrNew(['empID' => $value->emp_id]);
            $leave_forfeit->opening_balance = $opening_balance;
            $leave_forfeit->nature = 1; // Replace attribute1 with your actual attribute names
            $leave_forfeit->opening_balance_year =  $year;
            $leave_forfeit->save();
        }
    }
}
