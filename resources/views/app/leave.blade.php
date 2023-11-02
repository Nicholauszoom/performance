@extends('layouts.vertical', ['title' => 'Leave'])

@push('head-script')
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
<script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    @php
        $totalAccrued = number_format($leaveBalance, 2);
    @endphp

    @if (session('mng_emp') || session('appr_leave') || 1)
        @if (session('msg'))
            <div class="alert alert-success col-md-8 mx-auto mt-4" role="alert">
                    {{ session('msg') }}
            </div>
        @endif

        <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 col-lg-12 ">
            <div class="card-body">
                <div class="col-6 tex-mdt-sucess text-secondary" id="remaining" style="display:none">
                    <code class="text-success">
                        <span id="remain" class="text-success"></span>
                    </code>
                </div>

                <form  autocomplete="off" action="{{ url('flex/attendance/saveLeaveOnBehalf') }}"  method="post"  enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label ">Employee Name: </label>
                                <select name="empID" id="empID" class="form-control select">
                                    <option value=""> -- Choose Employee Here -- </option>
                                    @foreach($employees as $item)
                                    <option required value="{{ $item->emp_id }}" class="text-center"> {{ $item->fname }} {{ $item->mname }} {{ $item->lname }} </option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="start-date">Start Date <span  class="text-danger">*</span></label>
                            <input type="date" name="start" id="start-date" class="form-control" required>
                        </div>

                        <input type="text" name="limit" hidden value="<?php echo $totalAccrued; ?>">
                        {{-- <input type="text" name="empId" id="empID" hidden value="{{ Auth::User()->emp_id }}"> --}}

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="end-date"> End Date <span  class="text-danger">*</span></label>
                            <input type="date" required id="end-date" name="end" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label"  for="nature">Nature of Leave <span  class="text-danger">*</span></label>
                            <select class="form-control form-select select @error('emp_ID') is-invalid @enderror"  id="docNo" name="nature" required>
                                <option value="" class="text-center"> -- select Leave Type Here -- </option>
                                @foreach($leave_type as $key)
                                <option value="{{ $key->id }}" class="text-center"> {{ $key->type }} </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- @if($days<336) --}}
                        <div class="col-md-6 mb-3" id="sub" style="display:none">
                            <label class="control-label ">Sub Category <span  class="text-danger">*</span></label>
                            <select name="sub_cat" class="form-control select custom-select" id="subs_cat">
                            </select>
                        </div>
                        {{-- @endif --}}

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="last-name">Leave Address <span  class="text-danger">*</span></label>
                            <input required="required" type="text" id="address" name="address" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="middle-name" class="form-label">Mobile <span  class="text-danger">*</span></label>
                            <input required="required" class="form-control" type="tel" maxlength="10" name="mobile">
                        </div>

                        {{-- start of attachment --}}

                        <div class="col-md-6 mb-3" style="display:none" id="attachment">
                            <label for="leave-attachment" class="form-label">Attachment<span  class="text-danger">*</span></label></label>
                            <input class="form-control"  type="file" name="image" id="leave-attachment">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="control-label" for="reason">Reason For Leave <span  class="text-danger">*</span></label>
                            <textarea maxlength="256" id="reason" class="form-control" name="reason" placeholder="Reason" required="required" rows="3"></textarea>
                        </div>

                        @if($deligate > 0)
                        <div class="col-md-6">
                            <label for="deligate" class="form-label">Deligate Position To <span class="text-danger">*</span></label>
                            <select name="deligate" @if($deligate > 0) required @endif class="form-control" id="deligate">
                                <option value="">Select Deligate</option>
                                @foreach($employees as $item)
                                <option value="{{ $item->emp_id }}">{{ $item->fname }} {{ $item->mname }} {{ $item->lname }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 col-md-offset-3 mb-3">
                            <button class="float-end btn btn-main" type="button" data-bs-toggle="modal" data-bs-target="#approval"> Submit </button>
                        </div>
                    </div>

                    <div id="approval" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close " data-bs-dismiss="modal"></button>
                                </div>

                                <modal-body class="p-4">
                                    <h6 class="text-center">Are you Sure ?</h6>
                                    <div class="row ">
                                    <div class="col-4 mx-auto">
                                        <button  type="submit" class="btn bg-main btn-sm px-4 " >Yes</button>

                                        <button type="button" class="btn bg-danger btn-sm  px-4 text-light" data-bs-dismiss="modal">
                                        No
                                    </button>
                                    </div>


                                    </div>
                                </modal-body>

                                <modal-footer></modal-footer>
                            </div>
                        </div>
                    </div>
                </form>

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
            @foreach ($leaves as $item)
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

            @if ( (Auth()->user()->emp_id == $approval->level1 && $item->status == 1) ||(Auth()->user()->emp_id == $approval->level2 && $item->status == 2) || (Auth()->user()->emp_id == $approval->level3 && $item->status == 3))
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
                        <br>with <b> {{number_format($item->forfeit_days,2)}} <br> extra days
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
                                <span class="label label-default badge bg-pending text-white">PENDING</span>
                            </div><?php } elseif ($item->state == 0) { ?>
                            <div class="col-md-12">
                                <span class="label badge bg-info text-whites label-info">APPROVED</span>
                            </div><?php } elseif ($item->state == 3) { ?>
                            <div class="col-md-12">
                                <span class="label badge bg-danger text-white">REVOKED</span>
                            </div><?php } ?>
                    </div>
                </td>
                <td>
                    @if ($item->type->type == 'Annual')
                    {{number_format(($item->remaining + $item->days -$item->forfeit_days ), 2)}} Days
                    @else
                    {{number_format(($item->remaining + $item->days -$item->forfeit_days ), 2)}} Days
                    @endif



                </td>
                <td class="text-center">

                   
                    @if ($item->attachment != null)
                    <a href="{{ asset('storage/leaves/' . $item->attachment) }}" download="{{ asset('storage/leaves/' . $item->attachment) }}" class="btn bg-main btn-sm" title="Download Attachment">
                        <i class="ph ph-download"></i> &nbsp;
                        Attachment
                    </a>
                    @endif
                    @if (isset($approval))
                    @if ( $item->state == 1)
                    @if ( (Auth()->user()->emp_id == $approval->level1 && $item->status == 1) ||(Auth()->user()->emp_id == $approval->level2 && $item->status == 2) || (Auth()->user()->emp_id == $approval->level3 && $item->status == 3))
                    
                        <div class="col-md-12 text-center mt-1">
                            <a href="{{ url('flex/attendance/approveLeave/' . $item->id) }}" title="Approve">
                                <button class="btn btn-success btn-sm">Approve Request<i class="ph-check"></i></button>
                            </a>

                            <a href="javascript:void(0)" onclick="cancelLeave(<?php echo $item->id; ?>)" title="Reject">
                                <button class="btn btn-warning btn-sm">Cancel Request<i class="ph-x"></i></button></a>
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
  <div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-body">
        <h5 class="text-warning">Approved Leave Applications</h5>

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
                         <br>with <b> {{number_format($item->forfeit_days,2)}} <br> extra days
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
                                <span class="label label-default badge bg-pending text-white">PENDING LEAVE REQUEST</span>
                            </div><?php } elseif ($item->state == 0) { ?>
                            <div class="col-md-12">
                                <span class="label badge bg-info text-whites label-info">APPROVED LEAVE REQUEST </span>
                            </div>
                            <?php } elseif ($item->state == 2) { ?>
                            <div class="col-md-12">
                                <span class="label badge bg-pending text-white">PENDING APPROVAL OF LEAVE REVOKE</span>
                            </div>
                            <?php } elseif ($item->state == 3) { ?>
                            <div class="col-md-12">
                                <span class="label badge bg-info text-white">APPROVED LEAVE REVOKE</span>
                            </div><?php } ?>
                    </div>
                </td>
                <td>
                    @if ($item->type->type == 'Annual')
                    {{ number_format($item->remaining, 2) }} Days
                @else
                        @if($item->remaining < 0)
                            0 Days
                        @else
                            {{ $item->remaining  }} Days
                            @endif
                @endif
                </td>
                <td class="text-center">

                    @if(Auth()->user()->emp_id == $approval->level3  & ($item->state == 2 || $item->state == 0))
                    <div class="col-md-12 text-center mt-1">
                        <a href="{{ url('flex/attendance/revokeLeave/' . $item->id) }}" title="Revoke Approved Leave" class="icon-2 info-tooltip disabled">
                            <button class="btn btn-secondary btn-sm">Revoke Approved Leave<i class="ph-prohibit"></i></button>
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
  <div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-body">
        <h5 class="text-warning">Revoked Leave Applications</h5>

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
                <th>Accrued Days</th>
                <th>Action</th>
            </tr>
        </thead>


        <tbody>
            @foreach ($revoked_leaves as $item)
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
                         <br>with <b> {{number_format($item->forfeit_days,2)}} <br> extra days
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
                                <span class="label label-default badge bg-pending text-white">PENDING LEAVE REQUEST</span>
                            </div><?php } elseif ($item->state == 0) { ?>
                            <div class="col-md-12">
                                <span class="label badge bg-info text-whites label-info">APPROVED LEAVE REQUEST </span>
                            </div>
                            <?php } elseif ($item->state == 2) { ?>
                            <div class="col-md-12">
                                <span class="label badge bg-pending text-white">PENDING APPROVAL OF LEAVE REVOKE</span>
                            </div>
                            <?php } elseif ($item->state == 3) { ?>
                            <div class="col-md-12">
                                <span class="label badge bg-info text-white">APPROVED LEAVE REVOKE</span>
                            </div><?php } ?>
                    </div>
                </td>
                <td>
                    @if ($item->type->type == 'Annual')
                    {{ number_format($item->remaining, 2) }} Days
                @else
                        @if($item->remaining < 0)
                            0 Days
                        @else
                            {{ $item->remaining  }} Days
                            @endif
                @endif
                </td>
                <td class="text-center">

                    @if(Auth()->user()->emp_id == $approval->level3  & $item->state == 2 || $item->state == 0)
                    <div class="col-md-12 text-center mt-1">
                        <a href="{{ url('flex/attendance/revokeLeave/' . $item->id) }}" title="Revoke Approved Leave" class="icon-2 info-tooltip disabled">
                            <button class="btn btn-secondary btn-sm">Revoke requested approved Leave<i class="ph-prohibit"></i></button>
                        </a>
                        <a href="{{ url('flex/attendance/cancelRevokeLeave/' . $item->id) }}" title="Cance Revoke Request" class="icon-2 info-tooltip disabled">
                            <button class="btn btn-warning btn-sm">Cancel Leave Revoke<i class="ph-x"></i></button>
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
@endif

    <div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content py-3">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row py-2">
                        <div class="col-sm-12 col-lg-12 px-5">
                            <label>Enter Your Comment Here!</label>
                            <textarea id="comment" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default btn-sm" onclick="hidemodel()" data-dismiss="modal">No</button>
                        <button type="button" id="yes_delete" class="btn btn-main btn-sm" onclick="hidemodel()"  data-dismiss="modal">Yes</button>
                    </div>
                    <div class="col-sm-2">

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection





@push('footer-script')
{{-- @include("app.includes.overtime_operations") --}}

<script>
     function hidemodel() {

$('#delete').hide();
location.reload();
}
    function cancelLeave(id) {

        const message = "Are You Sure That You Want to Reject This Leave Request?";
        $('#delete').modal('show');
        $('#delete').find('.modal-body #message').text(message);

        $("#yes_delete").click(function() {
            $('#hideList').hide();
            const message = document.getElementById('comment').value;
            const terminationid = id;

            var data = terminationid + "|" + message;

            var url = "{{ route('attendance.cancelLeave', ':data') }}";
            url = url.replace(':data', data);

            if (message != "") {
                $.ajax({
                    // url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    // body:['']
                    async: true,
                    // beforeSend: function() {
                    //     $('.request__spinner').show()
                    // },
                    // complete: function() {

                    // },
                    success: function(data) {
                        alert(data);
                        var data = JSON.parse(data);
                        if (data.status == 'OK') {
                            $('#delete').modal('hide');
                            new Noty({
                                text: 'Leave Approved  successfully!',
                                type: 'success'
                            }).show();
                            location.reload();
                        } else {
                            $('#delete').modal('hide');
                            new Noty({
                                text: 'Leave Approve failed!',
                                type: 'error'
                            }).show();


                        }

                    }

                });
            } else {
                $('#delete').modal('hide');

                new Noty({
                    text: 'Failed, Comment should not be empty',
                    type: 'error'
                }).show();
            }

        });

    }

    function approveRequest(id) {

        Swal.fire({
            title: 'Are You Sure That You Want to Approve This Leave Request ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var terminationid = id;

                $.ajax({
                        url: "{{ url('flex/attendance/approveLeave') }}/" + terminationid
                    })
                    .done(function(data) {
                        $('#resultfeedOvertime').fadeOut('fast', function() {
                            $('#resultfeedOvertime').fadeIn('fast').html(data);
                        });

                        $('#status' + id).fadeOut('fast', function() {
                            $('#status' + id).fadeIn('fast').html(
                                '<div class="col-md-12"><span class="label label-warning">Approved</span></div>'
                            );
                        });

                        // alert('Request Cancelled Successifully!! ...');

                        Swal.fire(
                            'Cancelled!',
                            'Leave Request Approved Successifully!!.',
                            'success'
                        )

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Leave Request Cancellation Failed!! ....',
                            'success'
                        )

                        alert('Leave Request Cancellation Failed!! ...');
                    });
            }
        });

        // if (confirm("Are You Sure You Want to Cancel This Overtime Request") == true) {

        //     var overtimeid = id;

        //     $.ajax({
        //             url: "{{ url('flex/cancelOvertime') }}/" + overtimeid
        //         })
        //         .done(function(data) {
        //             $('#resultfeedOvertime').fadeOut('fast', function() {
        //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
        //             });

        //             $('#status' + id).fadeOut('fast', function() {
        //                 $('#status' + id).fadeIn('fast').html(
        //                     '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
        //                     );
        //             });

        //             alert('Request Cancelled Successifully!! ...');

        //             setTimeout(function() {
        //                 location.reload();
        //             }, 1000);
        //         })
        //         .fail(function() {
        //             alert('Overtime Cancellation Failed!! ...');
        //         });
        // }
    }


    function cancelRequest(id) {

        Swal.fire({
            title: 'Are You Sure You Want to Cancel This Leave Request ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var terminationid = id;

                $.ajax({
                        url: "{{ url('flex/attendance/cancelLeave') }}/" + terminationid
                    })
                    .done(function(data) {
                        $('#resultfeedOvertime').fadeOut('fast', function() {
                            $('#resultfeedOvertime').fadeIn('fast').html(data);
                        });

                        $('#status' + id).fadeOut('fast', function() {
                            $('#status' + id).fadeIn('fast').html(
                                '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
                            );
                        });

                        // alert('Request Cancelled Successifully!! ...');

                        Swal.fire(
                            'Cancelled!',
                            'Leave Request Cancelled Successifully!!.',
                            'success'
                        )

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Leave Request Cancellation Failed!! ....',
                            'success'
                        )

                        alert('Leave Request Cancellation Failed!! ...');
                    });
            }
        });

        // if (confirm("Are You Sure You Want to Cancel This Overtime Request") == true) {

        //     var overtimeid = id;

        //     $.ajax({
        //             url: "{{ url('flex/cancelOvertime') }}/" + overtimeid
        //         })
        //         .done(function(data) {
        //             $('#resultfeedOvertime').fadeOut('fast', function() {
        //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
        //             });

        //             $('#status' + id).fadeOut('fast', function() {
        //                 $('#status' + id).fadeIn('fast').html(
        //                     '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
        //                     );
        //             });

        //             alert('Request Cancelled Successifully!! ...');

        //             setTimeout(function() {
        //                 location.reload();
        //             }, 1000);
        //         })
        //         .fail(function() {
        //             alert('Overtime Cancellation Failed!! ...');
        //         });
        // }
    }
</script>






@include('app.includes.leave_operations')

<script>
    $(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var dateToday = dd + '/' + mm + '/' + yyyy;
        $('#leave_startDate').daterangepicker({
            drops: 'down',
            singleDatePicker: true,
            autoUpdateInput: false,
            startDate: dateToday,
            minDate: dateToday,
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_1"
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            // alert("The Employee is " + years+ " Years Old!");

        });
        $('#leave_startDate').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#leave_startDate').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
<script>
    $(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var dateToday = dd + '/' + mm + '/' + yyyy;
        $('#leave_endDate').daterangepicker({
            drops: 'down',
            singleDatePicker: true,
            autoUpdateInput: false,
            startDate: dateToday,
            minDate: dateToday,
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_1"
        }, function(start, end, label) {
            // var years = moment().diff(start, 'years');
            // alert("The Employee is " + years+ " Years Old!");

        });
        $('#leave_endDate').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#leave_endDate').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>

<script>

    $('#docNo').change(function(){
        var id = $(this).val();
        const start = document.getElementById("start-date").value;
        const end = document.getElementById("end-date").value;
        const empID = document.getElementById("empID").value;
      var par= id+'|'+start+'|'+end+'|'+empID;
        var url = '{{ route("getLeaveSubs", ":id") }}';
        url = url.replace(':id', par);

        if (id==1) {
          $("#attachment").hide();
        } else {
          $("#attachment").show();
        }

        $('#subs_cat').find('option').not(':first').remove();

        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',

            success: function(response){

              let days=response.days;
               let subs=response.data;
              var status ="<span>"+response.days+" Days</span>"
              $("#remaining").empty(status);
               $("#remaining").append(status);
               $("#remaining").show()
               $("#sub").hide();


              for (var i = 0; i < response.data.length; i++) {

                var id=subs[i].id;
                var name=subs[i].name;
                var option = "<option value='"+id+"'>"+name+"</option>";


                $("#subs_cat").append(option);

                $("#sub").show();

              }


            }
        });
    });


    </script>

    {{-- <script>
        var date = new Date();
        var tdate = date.getDate();
        var month = date.getMonth() + 1;
        if(tdate<10){
            month =  '0' + month;
        }
        if(month < 10){
            month = '0' + month;
        }
        var year  = date.getFullYear();
        var minDate = year + "-" + month + "-" + tdate;
        document.getElementById("start-date").setAttribute('min', minDate)
        document.getElementById("end-date").setAttribute('min', minDate)
        console.log(date);
    </script> --}}
@endpush
