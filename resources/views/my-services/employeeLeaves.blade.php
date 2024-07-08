<div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-header">
        <h6 class="text-warning">My Leaves</h6>
    </div>

    <table class="table table-striped table-bordered datatable-basic">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Duration</th>
                <th>Nature</th>
                <th>Reason</th>
                <th>Approval State</th>
                <th>Status</th>
                <th>Option</th>
            </tr>
        </thead>


        <tbody>
            <?php
      // if ($leave->num_rows() > 0){
        $counter = 1;
        foreach ($myleave as $row) {
            if($row->position != "Default Apllication"){
        //   if($row->status==2){ continue; }
          $date1=date_create($row->start);
          $date2=date_create($row->end);
          $diff=date_diff($date1,$date2);
          $final = $diff->format("%a Days");
          $final2 = $diff->format("%a");
         ?>
            <tr id="record<?php echo $row->id; ?>">
                <td width="1px"> {{ $counter }}</td>



                <td><?php
                // // DATE MANIPULATION
                $start = $row->start;
                $end = $row->end;
                $datewells = explode('-', $start);
                $datewelle = explode('-', $end);
                $mms = $datewells[1];
                $dds = $datewells[2];
                $yyyys = $datewells[0];
                $dates = $dds . '-' . $mms . '-' . $yyyys;

                $mme = $datewelle[1];
                $dde = $datewelle[2];
                $yyyye = $datewelle[0];
                $datee = $dde . '-' . $mme . '-' . $yyyye;

                $days_taken = $row->days;

                if ($days_taken > 1) {
                    $days_word = 'Days';
                } else {
                    $days_word = 'Day';
                }
                echo $days_taken . ' ' . $days_word . '<br>From <b>' . $dates . '</b><br>To <b>' . $datee . '</b>'; ?></td>
                <td>
                    <p>Nature :<b> <?php echo $row->type->type; ?> Leave</b><br>
                        @if ($row->sub_category > 0)
                            Sub Category :<b> <?php echo $row->sub_type->name; ?></b>
                        @endif
                    </p>
                </td>
                <td><?php echo $row->reason; ?></td>
                <td>
                    <div>
                        <?php

                        if ($row->status == 1) {
                            $levelID = App\Models\LeaveApproval::where('empid', Auth::user()->emp_id)->value('level1');
                            // dd( $levelID );

                            if ($row->position == null) {
                                $employeePosition = App\Models\Employee::where('emp_id', $levelID)->value('position');

                                // Make sure $employeePosition is not null or empty before querying for $position
                                if ($employeePosition) {
                                    $position = App\Models\Position::where('id', $employeePosition)->value('name');
                                    echo '<span class="label label-default badge bg-info text-white">Pending by ' . $position . '</span>';
                                } else {
                                    // Handle the case where $employeePosition is null or empty
                                    echo $levelID;
                                }
                            } else {
                                echo '<span class="label label-default badge bg-info text-white">' . $row->position . '</span>';
                            }
                        } elseif ($row->status == 2) {
                            $levelID = App\Models\LeaveApproval::where('empID', Auth::user()->emp_id)->value('level2');

                            if ($row->position == null) {
                                $employeePosition = App\Models\Employee::where('emp_id', $levelID)->value('position');

                                // Make sure $employeePosition is not null or empty before querying for $position
                                if ($employeePosition) {
                                    $position = App\Models\Position::where('id', $employeePosition)->value('name');
                                    echo '<span class="label label-default badge bg-info text-white">Escalated</span>';
                                    echo '<br>';
                                    echo '<span class="label label-default badge bg-info text-white">' . 'Pending to ' . $position . '</span>';
                                } else {
                                    // Handle the case where $employeePosition is null or empty
                                    echo '';
                                }
                            } else {
                                echo '<span class="label label-default badge bg-info text-white">' . $row->position . '</span>';
                            }
                        }
                        elseif ($row->status == 4) {
                            $levelID = App\Models\LeaveApproval::where('empID', Auth::user()->emp_id)->value('level2');
                            $levelID3 = App\Models\LeaveApproval::where('empID', Auth::user()->emp_id)->value('level2');

                            if ($row->position == null) {
                                $employeePosition = App\Models\Employee::where('emp_id', $levelID)->value('position');
                                $employeePosition3 = App\Models\Employee::where('emp_id', $levelID3)->value('position');

                                // Make sure $employeePosition is not null or empty before querying for $position
                                if ($employeePosition) {
                                    $position = App\Models\Position::where('id', $employeePosition)->value('name');
                                    $position3 = App\Models\Position::where('id', $employeePosition)->value('name');
                                    $theposition = $position || $position3;
                                    echo '<span class="label label-default badge bg-info text-white">Escalated</span>';
                                    echo '<br>';
                                    echo '<span class="label label-default badge bg-info text-white">' . 'Pending to ' . $theposition . '</span>';
                                } else {
                                    // Handle the case where $employeePosition is null or empty
                                    echo '';
                                }
                            } else {
                                echo '<span class="label label-default badge bg-info text-white">' . $row->position . '</span>';
                            }
                        }
                        elseif ($row->status == 5) {
                            $levelID = App\Models\LeaveApproval::where('empID', Auth::user()->emp_id)->value('level2');
                            $levelID3 = App\Models\LeaveApproval::where('empID', Auth::user()->emp_id)->value('level2');

                            if ($row->position == null) {
                                $employeePosition = App\Models\Employee::where('emp_id', $levelID)->value('position');
                                $employeePosition3 = App\Models\Employee::where('emp_id', $levelID3)->value('position');

                                // Make sure $employeePosition is not null or empty before querying for $position
                                if ($employeePosition) {
                                    $position = App\Models\Position::where('id', $employeePosition)->value('name');
                                    $position3 = App\Models\Position::where('id', $employeePosition)->value('name');
                                    $theposition = $position || $position3;
                                    echo '<span class="label label-default badge bg-info text-white">Escalated</span>';
                                    echo '<br>';
                                    echo '<span class="label label-default badge bg-info text-white">' . 'Approved by ' . $theposition . '</span>';
                                } else {
                                    // Handle the case where $employeePosition is null or empty
                                    echo '';
                                }
                            } else {
                                echo '<span class="label label-default badge bg-info text-white">' . $row->position . '</span>';
                            }
                        }
                         else {
                            $levelID = App\Models\LeaveApproval::where('empID', Auth::user()->emp_id)->value('level3');

                            if ($row->position == null) {
                                $employeePosition = App\Models\Employee::where('emp_id', $levelID)->value('position');

                                // Make sure $employeePosition is not null or empty before querying for $position
                                if ($employeePosition) {
                                    $position = App\Models\Position::where('id', $employeePosition)->value('name');
                                    echo '<span class="label label-default badge bg-info text-white">Escalated</span>';
                                    echo '<br>';

                                    echo '<span class="label label-default badge bg-info text-white">' . 'Pending by ' . $position . '</span>';
                                } else {
                                    // Handle the case where $employeePosition is null or empty
                                    echo '';
                                }
                            } else {
                                echo '<span class="label label-default badge bg-info text-white">' . $row->position . '</span>';
                            }
                        }
                        ?>



                        @if ($row->status == 0)
                            <span class="label label-default badge bg-pending text-white">NOT
                                APROVED</span>
                        @endif
                        {{-- <span class="label label-default badge bg-info text-white">{{ $row->position }}</span> --}}
                    </div>
                </td>
                <td>
                    <div>

                        <?php if ($row->state==1){ ?>
                            <span class="label label-default badge bg-pending text-white">PENDING REQUEST</span>
                        <?php }
                  elseif($row->state==0){?>
                            <span class="label badge bg-info text-whites label-info">APPROVED</span>
                        <?php }
                  elseif($row->state==2){?>
                            <span class="label badge bg-warning text-whites label-info">PENDING APPROVAL OF LEAVE REVOKE</span>
                        <?php }
                  elseif($row->state==3){?>
                            <span class="label badge bg-success text-whites label-info">APPROVED LEAVE REVOKED </span>
                        <?php }
                  elseif($row->state==4){?>
                            <span class="label badge bg-secondary text-white">CANCELED</span>
                        <?php }
                  elseif($row->state==6){?>
                            <span class="label badge bg-danger text-white">CANCELED APPROVED LEAVE</span>
                        <?php }
                  elseif($row->state==5){?>
                            <span class="label badge bg-danger text-white">DENIED</span>
                        <?php } ?>
                    </div>

                </td>
                <td class="text-center">
                    @if ($row->attachment)
                    <a href="{{ asset('storage/leaves/' . $row->attachment) }}"
                        download="{{ asset('storage/leaves/' . $row->attachment) }}"
                        class="btn bg-main btn-sm" title="Download Attachment">
                        <i class="ph ph-download"></i> &nbsp;
                        Attachment
                    </a>
                @endif
                    <?php if ($row->state == 1) { ?>
                <div class="col-md-12 text-center mt-1">
                    <a href="javascript:void(0)" title="Cancel Leave" class="icon-2 info-tooltip disabled"
                        onclick="cancelRequest(<?php echo $row->id; ?>)">
                        <button class="btn btn-danger btn-sm">Cancel Leave Request <i class="ph-x"></i></button>
                    </a>
                    <?php } else if ($row->state == 0) { ?>
                        @if($row->end <=  date('Y-m-d'))
                        <span class="label badge bg-success text-white">Used Leave</span>
                        @else
                        <a href="{{ url('flex/attendance/revokeLeave/' . $row->id) }}" title="Revoke Approved Leave" class="icon-2 info-tooltip disabled">
                            <button class="btn btn-main btn-sm">Initiate Revoke Request<i class="ph-prohibit"></i>
                        </button>
                    </a>
                    @endif
                </div>
                    <?php } ?>

                </td>

            </tr>

            <?php
                $counter++; // Increment the counter for the next row

     }} //} ?>
        </tbody>
    </table>
</div>
