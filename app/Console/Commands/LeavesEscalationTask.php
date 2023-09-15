<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\GeneralController;
use App\Models\LeaveApproval;
use App\Models\Leaves;
use App\Models\Employee;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailRequests;

use DateTime;




class LeavesEscalationTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaves:escalation-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {



        $this->leave_escalation();
        $this->info('Your scheduled task has been executed.');
        return Command::SUCCESS;
    }


    public function leave_escalation()
    {

        // Start of Escallation
        $leaves = Leaves::where('state', 1)->get();

        if ($leaves) {

            foreach ($leaves as $item) {
                $today = new DateTime();
                $applied = $item->updated_at;
                $diff = $today->diff($applied);
                $range = $diff->days;
                $approval = LeaveApproval::where('empID', $item->empID)->first();

                if ($approval) {
                    if ($range > $approval->escallation_time || 1) {
                        $leave = Leaves::where('id', $item->id)->first();
                        $status = $leave->status;
                        // dd($leave->status);
                        switch ($status) {
                            case 1:
                                if ($approval->level2 !== null) {
                                    $leave->status = 2;
                                    $approval_person = $approval->level2;
                                } else {
                                    $leave->status = 1;
                                    $approval_person = $approval->level1;
                                }
                                break;

                            case 2:
                                if ($approval->level3 !== null) {
                                    $leave->status = 3;
                                    $approval_person = $approval->level3;
                                } else {
                                    $leave->status = 2;
                                    $approval_person = $approval->level2;
                                }
                                break;

                            case 3:
                                if ($approval->level1 !== null) {
                                    $leave->status = 3;
                                    $approval_person = $approval->level3;
                                } else {
                                    $leave->status = 2;
                                    $approval_person = $approval->level1;
                                }
                                break;

                            default:
                                // Handle any other cases or errors here
                                break;
                        }

                        $leave->updated_at = $today;
                        $leave->update();



                        $employee = Employee::where("Emp_id", $item->empID)->first();
                        $approval_person = Employee::where("Emp_id", $approval_person)->first();

                        // dd($employee,$approval_person);
                        $email_data = array(
                            'subject' => 'Employee Leave Approval(Escalated)',
                            'view' => 'emails.linemanager.leave-approval',
                            'email' => $approval_person->email,
                            'full_name' => $approval_person->full_name,
                            'employee_name' => $employee->full_name,
                            'next' => parse_url(route('attendance.leave'), PHP_URL_PATH)
                        );

                        try {

                            Notification::route('mail',  $approval_person->email)->notify(new EmailRequests($email_data));
                        } catch (Exception $exception) {
                            return "failed to escalate leave";
                        }
                    }
                }
            }
        }
        //   End of Escallation

    }
}
