<div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-body">
        <h5 class="text-warning">New Leave Applications</h5>

        @if (Session::has('note'))
            {{ session('note') }}
        @endif
        <div id="resultfeed"></div>
    </div>

    <table class="table table-striped table-bordered datatable-basic">
        <thead>
            <tr>
                <th>Payroll No</th>
                <th>Name</th>
                <th>Duration</th>
                <th>Nature</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Accrued Days </th>
                <th>Action</th>
            </tr>
        </thead>


        <tbody>
            <?php
            foreach ($leaves as $item) {
                if ($item->position != 'Default Application') {
                    $line_manager = auth()->user()->emp_id;
                    $level1 = App\Models\LeaveApproval::where('empID', $item->empID)
                        ->where('level1', $line_manager)
                        ->first();
                    $level2 = App\Models\LeaveApproval::where('empID', $item->empID)
                        ->where('level2', $line_manager)
                        ->first();
                    $level3 = App\Models\LeaveApproval::where('empID', $item->empID)
                        ->where('level3', $line_manager)
                        ->first();
                    $approval = App\Models\LeaveApproval::where('empID', $item->empID)->first();

                    if (Auth()->user()->emp_id == $approval->level1 && $item->status == 1 ||
                        (Auth()->user()->emp_id == $approval->level2 && $item->status == 2) ||
                        (Auth()->user()->emp_id == $approval->level3 && $item->status == 3)) {
                        echo '<tr>';
                        echo '<td>' . $item->empID . '</td>';
                        echo '<td>' . $item->employee->fname . ' ' . $item->employee->mname . ' ' . $item->employee->lname . '</td>';
                        echo '<td>' . $item->days . ' Days<br>From <b>' . \Carbon\Carbon::parse($item->start)->format('d-m-Y') . '</b><br>To <b>' . \Carbon\Carbon::parse($item->end)->format('d-m-Y') . '</b>';

                        if (!empty($item->appliedBy)) {
                            echo '<br>Applied By <b>' . $item->appliedBy . '</b><br>with <b>' . number_format($item->forfeit_days, 2) . '</b> extra days';
                        }

                        echo '</td>';
                        echo '<td>Nature: <b>' . $item->type->type . '</b></td>';
                        echo '<td><p>' . $item->reason . '</p></td>';
                        echo '<td>';

                        if ($item->state == 1) {
                            echo '<div class="col-md-12">';
                            echo '<span class="label label-default badge bg-pending text-white">PENDING</span>';
                            echo '</div>';
                        } elseif ($item->state == 0) {
                            echo '<div class="col-md-12">';
                            echo '<span class="label badge bg-info text-whites label-info">APPROVED</span>';
                            echo '</div>';
                        } elseif ($item->state == 3) {
                            echo '<div class="col-md-12">';
                            echo '<span class="label badge bg-danger text-white">REVOKED</span>';
                            echo '</div>';
                        }

                        echo '</td>';
                        echo '<td>';

                        if ($item->type->type == 'Annual') {
                            echo number_format($item->remaining + $item->days - $item->forfeit_days, 2) . ' Days';
                        } else {
                            echo number_format($item->remaining + $item->days - $item->forfeit_days, 2) . ' Days';
                        }

                        echo '</td>';
                        echo '<td class="text-center">';

                        if ($item->attachment != null) {
                            echo '<a href="' . asset('storage/leaves/' . $item->attachment) . '" download="' . asset('storage/leaves/' . $item->attachment) . '" class="btn bg-main btn-sm" title="Download Attachment"><i class="ph ph-download"></i> &nbsp; Attachment</a>';
                        }

                        if (isset($approval) && $item->state == 1) {
                            if (Auth()->user()->emp_id == $approval->level1 ||
                                (Auth()->user()->emp_id == $approval->level2 && $item->status == 2) ||
                                (Auth()->user()->emp_id == $approval->level3 && $item->status == 3)) {
                                echo '<div class="col-md-12 text-center mt-1">';
                                echo '<a href="' . url('flex/attendance/approveLeave/' . $item->id) . '" title="Approve">';
                                echo '<button class="btn btn-success btn-sm">Approve Request<i class="ph-check"></i></button>';
                                echo '</a>';
                                echo '<a href="javascript:void(0)" onclick="cancelLeave(' . $item->id . ')" title="Reject">';
                                echo '<button class="btn btn-warning btn-sm">Cancel Request<i class="ph-x"></i></button></a>';
                                echo '</div>';
                            } elseif ($item->status == 4) {
                                echo '<div class="col-md-12 mt-1">';
                                echo '<span class="label bg-danger text-white">Denied</span>';
                                echo '</div>';
                            }
                        }

                        echo '</td>';
                        echo '</tr>';
                    }
                }
            }
            ?>

        </tbody>
    </table>
</div>
