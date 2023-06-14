@extends('layouts.vertical', ['title' => 'Leave'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    @can('view-leave')
        <?php $totalAccrued = number_format($leaveBalance, 2); ?>




        @if (session('mng_emp') || session('appr_leave'))
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
                            <th>Remaining</th>
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

                                    // $level2=$approve->level2;
                                    // $level3=$approve->level3;

                                @endphp

                                @if ($level1 != null || $level2 != null || $level3 != null)
                                    <tr>
                                        <td>{{ $item->empID }}</td>
                                        <td>{{ $item->employee->fname }} {{ $item->employee->mname }}
                                            {{ $item->employee->lname }}</td>
                                        <td>
                                            {{ $item->days }} Days
                                            <br>From <b>{{ $item->start }}</b><br>To <b>{{ $item->end }}</b>
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

                                                <?php if ($item->state==1){ ?>
                                                <div class="col-md-12">
                                                    <span class="label label-default badge bg-pending text-white">PENDING</span>
                                                </div><?php }
                elseif($item->state==0){?>
                                                <div class="col-md-12">
                                                    <span class="label badge bg-info text-whites label-info">APPROVED</span>
                                                </div><?php }
                elseif($item->state==3){?>
                                                <div class="col-md-12">
                                                    <span class="label badge bg-danger text-white">DENIED</span>
                                                </div><?php } ?>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $item->remaining }} Days
                                        </td>
                                        <td class="text-center">

                                            @php
                                                $approval = App\Models\LeaveApproval::where('empID', $item->empID)->first();
                                            @endphp
                                            @if ($item->attachment != null)
                                                <a href="{{ asset('storage/leaves/' . $item->attachment) }}"
                                                    download="{{ asset('storage/leaves/' . $item->attachment) }}"
                                                    class="btn bg-main btn-sm" title="Download Attachment">
                                                    <i class="ph ph-download"></i> &nbsp;
                                                    Attachment
                                                </a>
                                            @endif
                                            @if ($approval)
                                                @if ($item->status == 0 && $item->state == 1)
                                                    <?php if ( Auth()->user()->emp_id == $approval->level1  || Auth()->user()->emp_id == $approval->level2  || Auth()->user()->emp_id == $approval->level3){ ?>
                                                    {{-- @if (Auth()->user()->emp_id == $approval->level1) --}}
                                                    <div class="col-md-12 text-center mt-1">
                                                        <a href="{{ url('flex/attendance/approveLeave/' . $item->id) }}"
                                                            title="Approve">
                                                            <button class="btn btn-success btn-sm"><i
                                                                    class="ph-check"></i></button>
                                                        </a>

                                                        <a href="javascript:void(0)" onclick="cancelLeave(<?php echo $item->id; ?>)"
                                                            title="Reject">
                                                            <button class="btn btn-warning btn-sm"><i
                                                                    class="ph-x"></i></button></a>
                                                    </div>

                                                    {{-- @endif --}}


                                                    <?php }
                elseif ($item->status==4) {?>
                                                    <div class="col-md-12 mt-1">
                                                        <span class="label bg-danger text-white">Denied</span>
                                                    </div>
                                                    <?php } ?>
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
                            <th>Remaining</th>
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

                                    // $level2=$approve->level2;
                                    // $level3=$approve->level3;

                                @endphp

                                @if ($level1 != null || $level2 != null || $level3 != null)
                                    <tr>
                                        <td>{{ $item->empID }}</td>
                                        <td>{{ $item->employee->fname }} {{ $item->employee->mname }}
                                            {{ $item->employee->lname }}</td>
                                        <td>
                                            {{ $item->days }} Days
                                            <br>From <b>{{ $item->start }}</b><br>To <b>{{ $item->end }}</b>
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

                                                <?php if ($item->state==1){ ?>
                                                <div class="col-md-12">
                                                    <span class="label label-default badge bg-pending text-white">PENDING</span>
                                                </div><?php }
                elseif($item->state==0){?>
                                                <div class="col-md-12">
                                                    <span class="label badge bg-info text-whites label-info">APPROVED</span>
                                                </div><?php }
                elseif($item->state==3){?>
                                                <div class="col-md-12">
                                                    <span class="label badge bg-danger text-white">DENIED</span>
                                                </div><?php } ?>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $item->remaining }} Days
                                        </td>
                                        <td class="text-center">

                                            @php
                                                $approval = App\Models\LeaveApproval::where('empID', $item->empID)->first();
                                            @endphp
                                            @if ($item->attachment != null)
                                                <a href="{{ asset('storage/leaves/' . $item->attachment) }}"
                                                    download="{{ asset('storage/leaves/' . $item->attachment) }}"
                                                    class="btn bg-main btn-sm" title="Download Attachment">
                                                    <i class="ph ph-download"></i> &nbsp;
                                                    Attachment
                                                </a>
                                            @endif
                                            @if ($approval)
                                                @if ($item->status == 0 && $item->state == 1)
                                                    <?php if ( Auth()->user()->emp_id == $approval->level1  || Auth()->user()->emp_id == $approval->level2  || Auth()->user()->emp_id == $approval->level3){ ?>
                                                    {{-- @if (Auth()->user()->emp_id == $approval->level1) --}}
                                                    <div class="col-md-12 text-center mt-1">
                                                        <a href="{{ url('flex/attendance/approveLeave/' . $item->id) }}"
                                                            title="Approve">
                                                            <button class="btn btn-success btn-sm"><i
                                                                    class="ph-check"></i></button>
                                                        </a>

                                                        <a href="javascript:void(0)" onclick="cancelLeave(<?php echo $item->id; ?>)"
                                                            title="Reject">
                                                            <button class="btn btn-warning btn-sm"><i
                                                                    class="ph-x"></i></button></a>
                                                    </div>

                                                    {{-- @endif --}}


                                                    <?php }
                elseif ($item->status==4) {?>
                                                    <div class="col-md-12 mt-1">
                                                        <span class="label bg-danger text-white">Denied</span>
                                                    </div>
                                                    <?php } ?>
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
        @endif
    @endcan
    <div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete"
    tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                    <button type="button" class="btn btn-default btn-sm" onclick="hidemodel()"
                        data-dismiss="modal">No</button>
                    <button type="button" id="yes_delete" class="btn btn-main btn-sm">Yes</button>
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
        function cancelLeave(id) {

            const message = "Are You Sure That You Want to Reject This Leave Request?";
            $('#delete').modal('show');
            $('#delete').find('.modal-body #message').text(message);

            $("#yes_delete").click(function() {
                $('#hideList').hide();
                const message = document.getElementById('comment').value;
                const terminationid = id;

                 var data  =  terminationid+"|"+message;

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
        $('#docNo').change(function() {
            var id = $(this).val();
            var url = '{{ route('getSubs', ':id') }}';
            url = url.replace(':id', id);

            $('#subs_cat').find('option').not(':first').remove();

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    //  let subs=response.data;

                    console.log(response);
                    //  $("#first").remove();

                    for (var i = 0; i < response.length; i++) {

                        var id = subs[i].id;
                        var name = subs[i].name;
                        var option = "<option value='" + id + "'>" + name + "</option>";

                        $("#subs_cat").append(option);
                        $("#sub").show();


                    }

                }
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
@endpush
