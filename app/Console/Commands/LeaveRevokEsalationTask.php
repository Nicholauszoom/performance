<?php

namespace App\Console\Commands;

use App\Models\LeaveApproval;
use App\Models\EMPL;
use App\Models\Leaves;
use App\Notifications\EmailRequests;
use DateTime;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class LeaveRevokEsalationTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaves:leave_revok_escalation';

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

        $this->leave_revok_escalation();
        return Command::SUCCESS;
    }



    public function leave_revok_escalation()
    {

        Log::info('hapa imefika');
        $leaves = Leaves::where('state', 2)->get();


        foreach ($leaves as $item) {

            $today = new DateTime();
            $applied = Carbon::parse($item->revoke_created_at);
            $diff = $today->diff($applied);
            $range = $diff->days;
            $approval = LeaveApproval::where('empID', $item->empID)->first();
            $revok_person = null;


            if ($approval) {
                if ($range >= $approval->escallation_time) {
                    $leave = Leaves::where('id', $item->id)->first();
                    $revok_status = $leave->revok_escalation_status;
                    // dd($leave->status);
                    switch ($revok_status) {
                        case 1:
                            if ($approval->level2 !== null) {
                                $leave->revok_escalation_status = 2;
                                $revok_person = $approval->level2;
                            } else {
                                $leave->revok_escalation_status = 1;
                                $revok_person = $approval->level1;
                            }
                            break;

                        case 2:
                            if ($approval->level3 !== null) {
                                $leave->revok_escalation_status = 3;
                                $revok_person = $approval->level3;
                            } else {
                                $leave->revok_escalation_status = 2;
                                $revok_person = $approval->level2;
                            }
                            break;

                        case 3:
                            if ($approval->level1 !== null) {
                                $leave->revok_escalation_status = 3;
                                $revok_person = $approval->level3;
                            } else {
                                $leave->revok_escalation_status = 2;
                                $revok_person = $approval->level1;
                            }
                            break;

                        default:
                            // Handle any other cases or errors here
                            break;
                    }

                    $leave->updated_at = $today;
                    $leave->update();



                    $employee = EMPL::where("emp_id", $item->empID)->first();

                    $approval_person = EMPL::where("emp_id", $revok_person)->first();

                    if ($approval_person) {
                        $email_data = array(
                            'subject' => 'Employee Leave Revok(Escalated)',
                            'view' => 'emails.linemanager.leave-revoke',
                            'email' => $approval_person->email,
                            'full_name' => $approval_person->fname,
                            'employee_name' => $employee->fname,
                            'next' => parse_url(route('attendance.leave'), PHP_URL_PATH)
                        );

                        try {
                            Notification::route('mail',  $approval_person->email)->notify(new EmailRequests($email_data));
                        } catch (Exception $exception) {
                            return "failed to escalate leave";
                        }
                    } else {
                        // Handle the case where $approval_person is null
                    }
                }
            }
        }
    }
}
