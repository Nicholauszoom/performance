@extends('layouts.vertical', ['title' => 'Overtime'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script> --}}
    <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    {{-- start of apply overtime div --}}
    {{-- @can('add-overtime') --}}
    <div id="apply_overtime">
        <div class="row">
            <div class="col-md-12 ">
                <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                    <div class="card-header border-0 shadow-none">
                        <h5 class="text-warning">Apply Overtime</h5>
                    </div>

                    <div class="card-body">
                        <div class="col-6 form-group text-sucess text-secondary" id="remaining" style="display:none">
                            <code class="text-success"> <span id="remain" class="text-success"></span> </code>

                        </div>
                        @can('apply-overtime')
                            <form id="applyOvertime" enctype="multipart/form-data" method="post" data-parsley-validate
                                autocomplete="off">
                                @csrf

                                <div class="row">
                                    <div class="col-6 col-md-3 mb-2">
                                        <label class="col-form-label ">Overtime Category <span class="text-danger">*</span>
                                            :</label>
                                        <div class="col-sm-12">

                                            <select class="form-control select_category select" name="category" required>
                                                <option selected disabled> Select </option>
                                                @foreach ($overtimeCategory as $overtimeCategorie)
                                                    <option value="{{ $overtimeCategorie->id }}"> {{ $overtimeCategorie->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-3 mb-2">
                                        <label class="col-form-label ">Select Aprover <span class="text-danger">*</span>
                                            :</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select" name="linemanager" id="linemanager">
                                                <option selected disabled> Select Approver</option>
                                                @foreach ($employees as $employee)
                                                    @if ($employee->emp_id != auth()->user()->emp_id)
                                                        <option value="{{ $employee->emp_id }}">{{ $employee->fname }}
                                                            {{ $employee->mname }} {{ $employee->lname }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-3 mb-2">
                                        <label class="col-form-label ">Time Start <span class="text-danger">*</span>
                                            :</label>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ph-calendar"></i></span>
                                                <input type="datetime-local" required placeholder="Start Time" name="time_start"
                                                    id="time_start" class="form-control daterange-single">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-3 mb-2">
                                        <label class="col-form-label ">Time End <span class="text-danger">*</span>:</label>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ph-calendar"></i></span>
                                                <input type="datetime-local" required placeholder="Finish Time"
                                                    name="time_finish" id="time_end" class="form-control daterange-single">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12  mb-3">
                                        <label class="col-form-label ">Reason for overtime <span class="text-danger">*</span>
                                            :</label>
                                        <div class="col-sm-12">
                                            <textarea rows="3" cols="3" required class="form-control" name="reason" placeholder='Reason'></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-perfrom float-end">Send</button>
                                    </div>
                                </div>

                            </form>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @endcan --}}
    {{-- / --}}

    {{-- start of view my overtime card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0 --}}
    {{-- @can('view-my-overtime') --}}
    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header mb-0">
            @can('view-my-overtime')
                <div class="d-flex justify-content-between">
                    <h4 class="text-warning">My Overtimes</h4>
                    @can('apply-overtme')
                        <a href="#apply_overtime" class="btn btn-perfrom"><i class="ph-plus me-2"></i> Apply Overtime</a>
                    @endcan
                </div>
            </div>

            <div class="card-body border-0 shadow-none">
                <?php session('note'); ?>
                <div id="myResultfeedOvertime"></div>


                <table id="datatable" class="table table-striped table-bordered datatable-basic">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Date</th>
                            <th>Line Manager</th>
                            <th>Total Overtime(in Hrs.)</th>
                            <th>Reason(Description)</th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($my_overtimes as $row)
                            <tr id="domain{{ $row->SNo }}">
                                <td width="1px">{{ $row->SNo }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->applicationDATE)) }}</td>
                                <td>
                                    @foreach ($employees as $mng)
                                        @if ($row->line_manager == $mng->emp_id)
                                            {{ $mng->fname }} {{ $mng->mname }} {{ $mng->lname }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <b>Duration:</b> {{$row->total_hours}} Hrs.<br>
                                    <b>From:</b> {{ $row->time_in }} <b> To </b> {{ $row->time_out }}
                                </td>
                                <td>{{ $row->reason }}</td>
                                <td>
                                    <div id="status{{ $row->eoid }}">
                                        @if ($row->status == 0)
                                            <span class="badge bg-secondary">REQUESTED</span>
                                        @elseif($row->status == 1)
                                            <span class="badge bg-info">RECOMMENDED</span>
                                        @elseif($row->status == 2)
                                            <span class="badge bg-success">APPROVED</span>
                                        @elseif($row->status == 3)
                                            <i style="color:red" class="ph-paper-plane-tilt"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="options-width">
                                    @if ($row->status == 0 || $row->status == 3)
                                        <a href="javascript:void(0)" onclick="cancelOvertime({{ $row->eoid }})"
                                            title="Cancel overtime">
                                            <button type="button" class="btn btn-danger btn-xs"><i class="ph-x"></i></button>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endcan
@endsection

@push('footer-script')
    {{-- @include("app.includes.overtime_operations") --}}

    <script>
        function holdOvertime(id) {
                   if (confirm("Are You Sure You Want to Hold This Overtime Request") == true) {
                var overtimeid = id;

                $.ajax({
                        url: "{{ url('flex/holdOvertime') }}/" + overtimeid
                    })
                    .done(function(data) {
                        $('#resultfeedOvertime').fadeOut('fast', function() {
                            $('#resultfeedOvertime').fadeIn('fast').html(data);
                        });

                        $('#status' + id).fadeOut('fast', function() {
                            $('#status' + id).fadeIn('fast').html(
                                '<div class="col-md-12"><span class="label label-success">HELD</span></div>'
                            );
                        });

                        alert('Request Canceled!');

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    })
                    .fail(function() {
                        alert('Overtime Hold Failed!! ...');
                    });
            }
        }

        function approveOvertime(id) {


            Swal.fire({
                title: 'Are You Sure You Want to Approve This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/approveOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            /*$('#status'+id).fadeOut('fast', function(){
                                 $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });
                            $('#record'+id).fadeOut('fast', function(){
                                 $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });*/
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            alert('Overtime Approval Failed!! ...');
                        });
                }
            });
        }




        function lineapproveOvertime(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Approve This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/lineapproveOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {

                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });

                            /*$('#status'+id).fadeOut('fast', function(){
                                $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                                });
                            $('#record'+id).fadeOut('fast', function(){
                                $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                                });*/

                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            // Basic initialization

                            alert('Overtime Approval Failed!! ...');
                        });
                }
            });

        }

        function hrapproveOvertime(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Approve This Overtime Request?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/hrapproveOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            /*$('#status'+id).fadeOut('fast', function(){
                                 $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });
                            $('#record'+id).fadeOut('fast', function(){
                                 $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });*/
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            alert('Overtime Approval Failed!! ...');
                        });
                }
            });

        }

        function fin_approveOvertime(id) {


            Swal.fire({
                title: 'Are You Sure You Want to Approve This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: "{{ url('flex/fin_approveOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            /*$('#status'+id).fadeOut('fast', function(){
                                 $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });
                            $('#record'+id).fadeOut('fast', function(){
                                 $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });*/
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            alert('Overtime Approval Failed!! ...');
                        });
                }
            });

        }


        function denyOvertime(id) {
            Swal.fire({
                title: 'Are You Sure You Want to Dissaprove This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Dissaprove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/denyOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            $('#status' + id).fadeOut('fast', function() {
                                $('#status' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>'
                                );
                            });
                            $('#record' + id).fadeOut('fast', function() {
                                $('#record' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>'
                                );
                            });
                            alert('Request Dissaproved! ...');
                        })
                        .fail(function() {
                            alert('Overtime Dissaproval Failed!! ...');
                        });
                }
            });
        }


        function recommendOvertime(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Recommend This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Recommend it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/recommendOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            $('#status' + id).fadeOut('fast', function() {
                                $('#status' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-info">RECOMENDED</span></div>'
                                );
                            });
                            alert('Request Recommended Successifully!! ...');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            alert('Overtime Recommendation Failed!! ...');
                        });
                }
            });

        }



        function confirmOvertime(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Confirm This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, confirm it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/confirmOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            $('#status' + id).fadeOut('fast', function() {
                                $('#status' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-info">CONFIRMED</span></div>'
                                );
                            });
                            alert('Request Confirmed Successifully!! ...');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            alert('Overtime Confirmation Failed!! ...');
                        });
                }
            });
        }




        function cancelOvertime(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Cancel This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/cancelOvertime') }}/" + overtimeid
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
                                'Request Cancelled Successifully!!.',
                                'success'
                            )

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Overtime Cancellation Failed!! ....',
                                'success'
                            )

                            alert('Overtime Cancellation Failed!! ...');
                        });
                }
            });
        }
    </script>


    <script type="text/javascript">
        $(".select_category").select2({
            placeholder: "Select Category",
            allowClear: true
        });

        $(function() {

            $('#time_range').daterangepicker({
                autoUpdateInput: false,
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                singleClasses: "picker_1",
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD/MM/YYYY H:mm'
                }
            });

            $('#time_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY H:mm') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY H:mm'));
            });

            $('#time_range').on('cancel.daterangepicker', function(ev, picker) {
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

            var dateToday = dd + '-' + mm + '-' + yyyy;

            $('#time_start').daterangepicker({
                drops: 'down',
                singleDatePicker: true,
                autoUpdateInput: false,
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                startDate: dateToday,
                minDate: dateToday,
                locale: {
                    format: 'DD-MM-YYYY H:mm'
                },
                singleClasses: "picker_4"
            }, function(start, end, label) {
                // var years = moment().diff(start, 'years');
                // alert("The Employee is " + years+ " Years Old!");
            });

            $('#time_start').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + '  at  ' + picker.startDate.format(
                    'H:mm'));
            });

            $('#time_start').on('cancel.daterangepicker', function(ev, picker) {
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
            var dateToday = dd + '-' + mm + '-' + yyyy;

            $('#time_end').daterangepicker({
                drops: 'down',
                singleDatePicker: true,
                autoUpdateInput: false,
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                startDate: dateToday,
                minDate: dateToday,
                locale: {
                    format: 'DD-MM-YYYY H:mm'
                },
                singleClasses: "picker_4"
            }, function(start, end, label) {
                // var years = moment().diff(start, 'years');
                // alert("The Employee is " + years+ " Years Old!");
            });

            $('#time_end').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + '  at  ' + picker.startDate.format(
                    'H:mm'));
            });

            $('#time_end').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>

    <script type="text/javascript">
        $('#applyOvertime').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: "{{ url('/flex/applyOvertime') }}",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false
                })
                .done(function(data) {
                    $('#remaining').fadeOut('slow', function() {
                        $('#remaining').fadeIn('slow').html(data);
                    });

                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                    //   $('#updateName')[0].reset();
                })
                .fail(function() {
                    alert('Request Failed!! ...');
                });
        });
    </script>


    <script>
        $('#docNo').change(function() {
            var id = $(this).val();
            var url = '{{ route('getDetails', ':id') }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response != null) {

                        document.getElementById("oldsalary").value = response.salary;
                        document.getElementById("oldRate").value = response.rate;

                        $('#salary').val(response.salary + ' ' + response.currency);
                        $('#oldLevel').val(response.emp_level);
                        $('#oldPosition').val(response.position.name);
                    }
                }
            });
        });
    </script>
    {{-- @include("app.includes.overtime_operations") --}}

    <script>
        function holdOvertime(id) {

            if (confirm("Are You Sure You Want to Hold This Overtime Request") == true) {
                var overtimeid = id;

                $.ajax({
                        url: "{{ url('flex/holdOvertime') }}/" + overtimeid
                    })
                    .done(function(data) {
                        $('#resultfeedOvertime').fadeOut('fast', function() {
                            $('#resultfeedOvertime').fadeIn('fast').html(data);
                        });

                        $('#status' + id).fadeOut('fast', function() {
                            $('#status' + id).fadeIn('fast').html(
                                '<div class="col-md-12"><span class="label label-success">HELD</span></div>'
                            );
                        });

                        alert('Request Canceled!');

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    })
                    .fail(function() {
                        alert('Overtime Hold Failed!! ...');
                    });
            }
        }

        function approveOvertime(id) {


            Swal.fire({
                title: 'Are You Sure You Want to Approve This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/approveOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            /*$('#status'+id).fadeOut('fast', function(){
                                 $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });
                            $('#record'+id).fadeOut('fast', function(){
                                 $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });*/
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            alert('Overtime Approval Failed!! ...');
                        });
                }
            });
        }




        function lineapproveOvertime(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Approve This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/lineapproveOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {

                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });

                            /*$('#status'+id).fadeOut('fast', function(){
                                $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                                });
                            $('#record'+id).fadeOut('fast', function(){
                                $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                                });*/

                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            // Basic initialization

                            alert('Overtime Approval Failed!! ...');
                        });
                }
            });
        }

        function hrapproveOvertime(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Approve This Overtime Request?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/hrapproveOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            /*$('#status'+id).fadeOut('fast', function(){
                                 $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });
                            $('#record'+id).fadeOut('fast', function(){
                                 $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });*/
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            alert('Overtime Approval Failed!! ...');
                        });
                }
            });
        }

        function fin_approveOvertime(id) {


            Swal.fire({
                title: 'Are You Sure You Want to Approve This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: "{{ url('flex/fin_approveOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            /*$('#status'+id).fadeOut('fast', function(){
                                 $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });
                            $('#record'+id).fadeOut('fast', function(){
                                 $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                               });*/
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            alert('Overtime Approval Failed!! ...');
                        });
                }
            });
        }


        function denyOvertime(id) {
            Swal.fire({
                title: 'Are You Sure You Want to Dissaprove This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Dissaprove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/denyOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            $('#status' + id).fadeOut('fast', function() {
                                $('#status' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>'
                                );
                            });
                            $('#record' + id).fadeOut('fast', function() {
                                $('#record' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>'
                                );
                            });
                            alert('Request Dissaproved! ...');
                        })
                        .fail(function() {
                            alert('Overtime Dissaproval Failed!! ...');
                        });
                }
            });

        }


        function recommendOvertime(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Recommend This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Recommend it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/recommendOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            $('#status' + id).fadeOut('fast', function() {
                                $('#status' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-info">RECOMENDED</span></div>'
                                );
                            });
                            alert('Request Recommended Successifully!! ...');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            alert('Overtime Recommendation Failed!! ...');
                        });
                }
            });
        }



        function confirmOvertime(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Confirm This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, confirm it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/confirmOvertime') }}/" + overtimeid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });
                            $('#status' + id).fadeOut('fast', function() {
                                $('#status' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-info">CONFIRMED</span></div>'
                                );
                            });
                            alert('Request Confirmed Successifully!! ...');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        })
                        .fail(function() {
                            alert('Overtime Confirmation Failed!! ...');
                        });
                }
            });
        }




        function cancelOvertime(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Cancel This Overtime Request?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                            url: "{{ url('flex/cancelOvertime') }}/" + overtimeid
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
                                'Request Cancelled Successifully!!.',
                                'success'
                            )

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Overtime Cancellation Failed!! ....',
                                'success'
                            )

                            alert('Overtime Cancellation Failed!! ...');
                        });
                }
            });
        }
    </script>


    <script type="text/javascript">
        $(".select_category").select2({
            placeholder: "Select Category",
            allowClear: true
        });

        $(function() {

            $('#time_range').daterangepicker({
                autoUpdateInput: false,
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                singleClasses: "picker_1",
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD/MM/YYYY H:mm'
                }
            });

            $('#time_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY H:mm') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY H:mm'));
            });

            $('#time_range').on('cancel.daterangepicker', function(ev, picker) {
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

            var dateToday = dd + '-' + mm + '-' + yyyy;

            $('#time_start').daterangepicker({
                drops: 'down',
                singleDatePicker: true,
                autoUpdateInput: false,
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                startDate: dateToday,
                minDate: dateToday,
                locale: {
                    format: 'DD-MM-YYYY H:mm'
                },
                singleClasses: "picker_4"
            }, function(start, end, label) {
                // var years = moment().diff(start, 'years');
                // alert("The Employee is " + years+ " Years Old!");
            });

            $('#time_start').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + '  at  ' + picker.startDate.format(
                    'H:mm'));
            });

            $('#time_start').on('cancel.daterangepicker', function(ev, picker) {
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
            var dateToday = dd + '-' + mm + '-' + yyyy;

            $('#time_end').daterangepicker({
                drops: 'down',
                singleDatePicker: true,
                autoUpdateInput: false,
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                startDate: dateToday,
                minDate: dateToday,
                locale: {
                    format: 'DD-MM-YYYY H:mm'
                },
                singleClasses: "picker_4"
            }, function(start, end, label) {
                // var years = moment().diff(start, 'years');
                // alert("The Employee is " + years+ " Years Old!");
            });

            $('#time_end').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + '  at  ' + picker.startDate.format(
                    'H:mm'));
            });

            $('#time_end').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>




    <script>
        $('#docNo').change(function() {
            var id = $(this).val();
            var url = '{{ route('getDetails', ':id') }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response != null) {

                        document.getElementById("oldsalary").value = response.salary;
                        document.getElementById("oldRate").value = response.rate;

                        $('#salary').val(response.salary + ' ' + response.currency);
                        $('#oldLevel').val(response.emp_level);
                        $('#oldPosition').val(response.position.name);
                    }
                }
            });
        });
    </script>
@endpush
