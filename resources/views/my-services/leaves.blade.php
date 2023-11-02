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
        $totalOutstanding = number_format($outstandingLeaveBalance, 2);
    @endphp

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto mt-4" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0">
        <div class="card-header">
            <h5 class="text-warning">Apply Leave</h5>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="card-title">Annual Leave Summary per Year</h5>
                    </div>
                    <div class="mb-3">
                        <select id="employee_exited_list" class="form-select" tabindex="-1">
                            <option value="">-- Select Year --</option>
                            <option value="2008">2008</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                        </select>
                    </div>
                    <div id="balance-table-placeholder">
                        <table class="table table-striped table-bordered datatable-basic">
                            <thead>
                                <tr>
                                    <th>Details</th>
                                    <th>Days</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>Days Entitled</td>
                                <td>Loading...</td> <!-- Display a loading message -->
                            </tr>
                            <tr>
                                <td>Opening Balance</td>
                                <td>Loading...</td> <!-- Display a loading message -->
                            </tr>
                            <tr>
                                <td>Days Forfeit Balance</td>
                                <td>Loading...</td> <!-- Display a loading message -->
                            </tr>
                            <tr>
                                <td>Annual Leave Days Accrued</td>
                                <td>Loading...</td> <!-- Display a loading message -->
                            </tr>
                            <tr>
                                <td>Days Spent</td>
                                <td>Loading...</td> <!-- Display a loading message -->
                            </tr>
                            <tr>
                                <td>Outstanding Leave Balance</td>
                                <td>Loading...</td> <!-- Display a loading message -->
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class=" col-md-8 border-left" style="border-left: 2px solid #000 !important;">
                <div class="card-body">
                    <form autocomplete="off" action="{{ url('flex/attendance/save_leave') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="start-date">Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start" id="start-date" class="form-control" required>
                            </div>
                            <input type="text" name="limit" hidden value="{{ $totalAccrued }}">
                            <input type="text" name="empId" id="empID" hidden value="{{ Auth::User()->emp_id }}">
                            <div class="form-group col-md-6">
                                <label for="end-date">End Date <span class="text-danger">*</span></label>
                                <input type="date" required id="end-date" name="end" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="docNo">Nature of Leave <span class="text-danger">*</span></label>
                                <select class="form-control" required id="docNo" name="nature">
                                    <option value="">Select Nature</option>
                                    @php
                                        $gender = Auth::user()->gender == 'Male' ? 1 : 2;
                                    @endphp
                                    @foreach ($leave_type as $key)
                                        @if ($key->gender <= 0 || $key->gender == $gender)
                                            <option value="{{ $key->id }}">{{ $key->type }} Leave
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="sub" style="display:none">
                                <label for="subs_cat">Sub Category <span class="text-danger">*</span></label>
                                <select name="sub_cat" class="form-control select custom-select" id="subs_cat"></select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="address">Leave Address <span class="text-danger">*</span></label>
                                <input required="required" type="text" id="address" name="address"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                <input required="required" class="form-control" type="tel" maxlength="10"
                                    name="mobile">
                            </div>

                            <div class="form-group col-md-6" style="display:none" id="attachment">
                                <label for="image">Attachment <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="image" id="attach">
                            </div>

                            <div class="form-group col-12 mb-2">
                                <label for="reason">Reason For Leave <span class="text-danger">*</span></label>
                                <textarea maxlength="256" class="form-control" name="reason" placeholder="Reason" required="required"
                                    rows="3"></textarea>
                            </div>

                            @if ($deligate > 0)
                                <div class="form-group col-md-6">
                                    <label for="deligate">Deligate Position To <span class="text-danger">*</span></label>
                                    <select name="deligate" @if ($deligate > 0) required @endif
                                        class="form-control" id="deligate">
                                        <option value="">Select Deligate</option>
                                        @foreach ($employees as $item)
                                            <option value="{{ $item->emp_id }}">{{ $item->fname }}
                                                {{ $item->mname }} {{ $item->lname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                        </div>

                        <div class="form-group py-2">
                            <button class="float-end btn btn-main" type="button" data-bs-toggle="modal"
                                data-bs-target="#approval">Apply</button>
                        </div>

                        <div id="approval" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="btn-close " data-bs-dismiss="modal">

                                        </button>
                                    </div>
                                    <modal-body class="p-4">
                                        <h6 class="text-center">Are you Sure ?</h6>
                                        <div class="row ">
                                            <div class="col-4 mx-auto">
                                                <button type="submit" class="btn bg-main btn-sm px-4 ">Yes</button>

                                                <button type="button" class="btn bg-danger btn-sm  px-4 text-light"
                                                    data-bs-dismiss="modal">
                                                    No
                                                </button>
                                            </div>
                                        </div>
                                    </modal-body>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>


    <!-- Add approval modal -->
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
                                $levelID = App\Models\LeaveApproval::where('empID', Auth::user()->emp_id)->value('level1');
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
                                <span class="label badge bg-success text-whites label-info">APPROVED LEAVE REVOKE </span>
                            <?php }
                      elseif($row->state==4){?>
                                <span class="label badge bg-danger text-white">DENIED</span>
                            <?php } ?>
                        </div>

                    </td>
                    <td>
                        {{-- start of cancel leave button --}}
                        <?php if ($row->state == 1) { ?>
                        <a href="javascript:void(0)" title="Cancel Leave" class="icon-2 info-tooltip disabled"
                            onclick="cancelRequest(<?php echo $row->id; ?>)">
                            <button class="btn btn-danger btn-sm">Cancel Leave Request <i class="ph-x"></i></button>
                        </a>
                        <?php } else if ($row->state == 0) { ?>
                            <a href="{{ url('flex/attendance/revokeLeave/' . $row->id) }}" title="Revoke Approved Leave" class="icon-2 info-tooltip disabled">
                                <button class="btn btn-primary btn-sm">Revoke Approved Leave<i class="ph-prohibit"></i>
                            </button>
                        </a>
                        <?php } ?>
                    </td>

                </tr>

                <?php
                    $counter++; // Increment the counter for the next row

         }} //} ?>
            </tbody>
        </table>
    </div>



@endsection





@push('footer-script')
    {{-- @include("app.includes.overtime_operations") --}}

    <script>
        function confirmSubmit() {

            Swal.fire({
                title: 'Are You Sure That You Want to Submit This Leave Request ?',
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
        }

        function revokeRequest(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Revoke This approved Leave Request ?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Revoke it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var terminationid = id;

                    $.ajax({
                            url: "{{ url('flex/attendance/revokeLeave') }}/" + terminationid
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

                            Swal.fire(
                                'Cancelled!',
                                'Approved Leave Request Revoked Successifully!!.',
                                'success'
                            )

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Approved Leave Request Revoked Failed!! ....',
                                'success'
                            )

                            alert('Approved Leave Request Revoked Failed!! ...');
                        });
                }
            });
        }
    </script>






    @include('app.includes.leave_operations')

    <script>
        $('#docNo').change(function() {
            var id = $(this).val();
            const start = document.getElementById("start-date").value;
            const end = document.getElementById("end-date").value;
            var par = id + '|' + start + '|' + end;
            var url = '{{ route('getSubs', ':id') }}';
            url = url.replace(':id', par);

            if (id == 1) {
                $("#attachment").hide();
                $("#attach").prop('required', false);
            } else {
                $("#attachment").show();
                $("#attach").prop('required', true);
            }

            $('#subs_cat').find('option').not(':first').remove();

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',

                success: function(response) {

                    let days = response.days;
                    let subs = response.data;
                    var status = "<span>" + response.days + " Days</span>"
                    $("#remaining").empty(status);
                    $("#remaining").append(status);
                    $("#remaining").show()
                    $("#sub").hide();


                    for (var i = 0; i < response.data.length; i++) {

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
                // var years = moment().diff(start, 'years');
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

    @php
        // Assuming $userLeaves contains the array of leave dates
        $leaveDates = json_encode($leaveDates);
        // dd($leaveDates);
    @endphp

    <script>
        var leaveDates = @json($leaveDates);

        // Get the start date input element
        var startDateInput = document.getElementById("start-date").value;
        console.log(startDateInput);

        // Add an event listener to the start date input
        startDateInput.addEventListener('input', function() {
            var selectedDate = new Date(startDateInput.value);

            // Convert the selected date to a string in 'yyyy-mm-dd' format
            var selectedDateString = selectedDate.toISOString().split('T')[0];

            // Iterate through the leaveDates array and check if the selected date falls within any leave period
            var disableDate = false;
            for (var i = 0; i < leaveDates.length; i++) {
                if (selectedDateString >= leaveDates[i].start && selectedDateString <= leaveDates[i].end) {
                    disableDate = true;
                    break;
                }
            }

            if (disableDate) {
                alert('Leave date selected. Please choose another date.');
                startDateInput.value = ''; // Clear the input if it matches a leave date
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->

    {{-- <script>
    $(document).ready(function() {
    const customDateInput = $("#start-date");

    // Initialize the date input with today's date in ISO format
    const today = new Date();
    customDateInput.val(today.toISOString().slice(0, 10));

    // Add a custom date picker using jQuery UI Datepicker
    customDateInput.datepicker({
        dateFormat: "d-m-y",
        altFormat: "yy-mm-dd",
        altField: "#start-date"
    });

    // Add an event listener to update the value as the user selects a date
    customDateInput.change(function() {
        const selectedDate = customDateInput.val();
        console.log(selectedDate); // ISO format
        // You can format and display the selected date in the "d-m-y" format as needed
    });
});
</script> --}}



    <script>
        $(document).ready(function() {
            // Bind an event handler to the select element
            $("#employee_exited_list").change(function() {
                var selectedYear = $(this).val();

                // Construct the URL with the selected year parameter
                var url = '/flex/attendance/annualleavebalance/' + selectedYear;

                // Make an AJAX request to fetch the data
                $.ajax({
                    url: url,
                    method: "GET",
                    dataType: "json", // Ensure that the response is parsed as JSON
                    success: function(data) {
                        console.log(data); // Log the data only for success
                        updateTable(
                            data); // Pass the retrieved data to the updateTable function
                    },
                    error: function(err) {
                        console.log(err.responseText());
                        console.log('error in fetching');
                    }
                });
            });

            function updateTable(data) {
                var table = $("#balance-table-placeholder table tbody"); // Select the table body

                // Clear existing rows
                table.empty();

                // Populate the table with the new data
                $.each(data, function(key, value) {
                    var row = $("<tr>");
                    row.append($("<td>").text(key));
                    row.append($("<td>").text(value));
                    table.append(row);
                });
            }
        });
    </script>
@endpush
