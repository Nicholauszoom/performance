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

{{-- {{ dd($leaves) }} --}}
        <tbody>

            @foreach ($leaves as $item)
            {{-- {{ dd(Auth()->user()->emp_id, $item->deligated, $item->status )}} --}}

                @if ($item->position != 'Default Apllication')
                    @php

                        $line_manager = auth()->user()->emp_id;
                        // $approve=App\Models\LeaveApproval::where('empID',$item->empID)->first();
                        $level1 = App\Models\LeaveApproval::where('empid', $item->empID)
                            ->where('level1', $line_manager)
                            ->first();
                        $level2 = App\Models\LeaveApproval::where('empid', $item->empID)
                            ->where('level2', $line_manager)
                            ->first();
                        $level3 = App\Models\LeaveApproval::where('empid', $item->empID)
                            ->where('level3', $line_manager)
                            ->first();

                        $approval = App\Models\LeaveApproval::where('empid', $item->empID)->first();

                        // $level2=$approve->level2;
                        // $level3=$approve->level3;

                    @endphp

                    @if (Auth()->user()->emp_id == $approval->level1 ||
                            (Auth()->user()->emp_id == $approval->level2 && $item->status == 2) ||
                            (Auth()->user()->emp_id == $approval->level3 && $item->status == 3) ||
                            (Auth()->user()->emp_id == $item->deligated && $item->status == 3)
                            )
                        <tr>
                            <td>{{ $item->empID }}</td>
                            <td>{{ $item->employee->fname }} {{ $item->employee->mname }}
                                {{ $item->employee->lname }}
                            </td>
                            <td>
                                {{ $item->days }} Days
                                <br>From <b>{{ \Carbon\Carbon::parse($item->start)->format('d-m-Y') }}</b>
                                <br>To <b>{{ \Carbon\Carbon::parse($item->end)->format('d-m-Y') }}</b>

                                @if (!empty($item->appliedBy))
                                    <br>Applied By <b>{{ $item->appliedBy }}</b>
                                    <br>with <b> {{ number_format($item->forfeit_days, 2) }} <br> extra days
                                @endif
                            </td>

                            <td>
                                Nature: <b>{{ $item->type->type }}</b>
                            </td>
                            <td>
                                <p>
                                    {{ $item->reason }}
                                </p>
                            </td>
                            <td>
                                <div>

                                    <?php if ($item->state == 1) { ?>
                                    <div class="col-md-12">
                                        <span
                                            class="label label-default badge bg-pending text-white">PENDING</span>
                                    </div><?php } elseif ($item->state == 0) { ?>
                                    <div class="col-md-12">
                                        <span
                                            class="label badge bg-info text-whites label-info">APPROVED</span>
                                    </div><?php } elseif ($item->state == 3) { ?>
                                    <div class="col-md-12">
                                        <span class="label badge bg-danger text-white">REVOKED</span>
                                    </div><?php } ?>
                                </div>
                            </td>
                            <td>
                                @if ($item->type->type == 'Annual')
                                    {{ number_format($item->remaining + $item->days - $item->forfeit_days, 2) }}
                                    Days
                                @else
                                    {{ number_format($item->remaining + $item->days - $item->forfeit_days, 2) }}
                                    Days
                                @endif



                            </td>
                            <td class="text-center">

                                @if ($item->attachment != null)
                                    <a href="{{ asset('storage/leaves/' . $item->attachment) }}"
                                        download="{{ asset('storage/leaves/' . $item->attachment) }}"
                                        class="btn bg-main btn-sm" title="Download Attachment">
                                        <i class="ph ph-download"></i> &nbsp;
                                        Attachment
                                    </a>
                                @endif
                                @if (isset($approval))
                                    @if ($item->state == 1)
                                        @if (Auth()->user()->emp_id == $approval->level1 ||
                                                (Auth()->user()->emp_id == $approval->level2 && $item->status == 2) ||
                                                (Auth()->user()->emp_id == $approval->level3 && $item->status == 3) || (Auth()->user()->emp_id == $item->deligated && $item->status == 3))
                                            <div class="col-md-12 text-center mt-1">
                                                <a href="{{ url('flex/attendance/approveLeave/' . $item->id) }}"
                                                    title="Approve">
                                                    <button class="btn btn-success btn-sm">Approve
                                                        Request<i class="ph-check"></i></button>
                                                </a>

                                                <a href="javascript:void(0)"
                                                    onclick="cancelLeave(<?php echo $item->id; ?>)"
                                                    title="Reject">
                                                    <button class="btn btn-warning btn-sm">Cancel Request<i
                                                            class="ph-x"></i></button></a>
                                            </div>
                                        @elseif ($item->status == 4)
                                            <div class="col-md-12 mt-1">
                                                <span class="label bg-danger text-white">Denied</span>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            </td>

                        </tr>
                    @endif
                @endif
            @endforeach

        </tbody>
    </table>
</div>
