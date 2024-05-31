<div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-header">
        <h5 class="text-warning">Approved Leave Applications</h5>

        @if (Session::has('note'))
            {{ session('note') }}
        @endif
        <div id="resultfeed"></div>
    </div>

    <div class="card-body">

    <table class="table table-striped table-bordered datatable-basic">
        <thead>
            <tr>
                <th>Payroll No</th>
                <th>Name</th>
                <th>Duration</th>
                <th>Nature</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Accrued Days</th>
                <th>Action</th>
            </tr>
        </thead>


        <tbody>
            @foreach ($approved_leaves as $item)
                @if ($item->position != 'Default Apllication')
                    @php

                        $line_manager = auth()->user()->emp_id;
                        // $approve=App\Models\LeaveApproval::where('empID',$item->empID)->first();
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

                        // $level2=$approve->level2;
                        // $level3=$approve->level3;

                    @endphp

                    @if ($level1 != null || $level2 != null || $level3 != null)
                        <tr>
                            <td>{{ $item->empID }}</td>
                            <td>{{ $item->employee->fname }} {{ $item->employee->mname }}
                                {{ $item->employee->lname }}
                            </td>
                            {{-- <td>
                                {{ $item->days }} Days
                                <br>From <b>{{ $item->start }}</b><br>To <b>{{ $item->end }}</b>
                            </td> --}}
                            <td>
                                {{ $item->days }} Days
                                <br>From <b>{{ \Carbon\Carbon::parse($item->start)->format('d-m-Y') }}</b>
                                <br>To <b>{{ \Carbon\Carbon::parse($item->end)->format('d-m-Y') }}</b>

                                @if (!empty($item->appliedBy))
                                    <br>Applied By <b>{{ $item->appliedBy }}</b>
                                    <br>with <b> {{ number_format($item->forfeit_days, 2) }} <br> extra
                                        days
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
                                            class="label label-default badge bg-pending text-white">PENDING
                                            LEAVE REQUEST</span>
                                    </div><?php } elseif ($item->state == 0) { ?>
                                    <div class="col-md-12">
                                        <span class="label badge bg-info text-whites label-info">APPROVED
                                            LEAVE</span>
                                    </div>
                                    <?php } elseif ($item->state == 2) { ?>
                                    <div class="col-md-12">
                                        <span class="label badge bg-pending text-white">PENDING APPROVAL OF
                                            LEAVE REVOKE</span>
                                    </div>
                                    <?php } elseif ($item->state == 3) { ?>
                                    <div class="col-md-12">
                                        <span class="label badge bg-info text-white">APPROVED LEAVE
                                            REVOKE</span>
                                    </div><?php } ?>
                                </div>
                            </td>
                            <td>
                                @if ($item->type->type == 'Annual')
                                    {{ number_format($item->remaining, 2) }} Days
                                @else
                                    @if ($item->remaining < 0)
                                        0 Days
                                    @else
                                        {{ $item->remaining }} Days
                                    @endif
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

                                @if ((Auth()->user()->emp_id == $approval->level1) & ($item->state == 2 || $item->state == 0))
                                    <div class="col-md-12 text-center mt-1">
                                        <a href="{{ url('flex/attendance/revokeLeave/' . $item->id) }}"
                                            title="Revoke Approved Leave"
                                            class="icon-2 info-tooltip disabled">
                                            <button class="btn btn-secondary btn-sm">Revoke Approved
                                                Leave<i class="ph-prohibit"></i></button>
                                        </a>
                                    </div>
                                @endif
                            </td>

                        </tr>
                    @endif
                @endif
            @endforeach

        </tbody>
    </table>
    </div>
</div>
