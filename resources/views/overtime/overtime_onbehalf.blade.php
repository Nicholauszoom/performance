@extends('layouts.vertical', ['title' => 'Overtime'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    {{-- start of apply overtime div --}}
    @can('add-overtime')
        <div id="apply_overtime">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                        <div class="card-header border-0 shadow-none">
                            <h5 class="text-warning">Apply Overtime On Behalf</h5>
                        </div>

                        <div class="card-body">
                            <div class="col-6 form-group text-sucess text-secondary" id="remaining" style="display:none">
                                <code class="text-success"> <span id="remain" class="text-success"></span> </code>

                            </div>
                            <form id="applyOvertime" enctype="multipart/form-data" method="post" data-parsley-validate
                                autocomplete="off">
                                @csrf

                                <div class="row">
                                    <div class="col-6 col-md-4 mb-2">
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
                                    <div class="col-6 col-md-4 mb-2">
                                        <label class="col-form-label ">Select Employee <span class="text-danger">*</span>
                                            :</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select" name="empID" id="empID">
                                                <option selected disabled> Select Employee</option>
                                                @foreach ($employees as $employee)
                                                    @if ($employee->emp_id != auth()->user()->emp_id)
                                                        <option value="{{ $employee->emp_id }}">{{ $employee->emp_id }} -
                                                            {{ $employee->fname }}
                                                            {{ $employee->mname }} {{ $employee->lname }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-6 col-md-4 mb-2">
                                        <label class="col-form-label ">Hours <span class="text-danger">*</span>
                                            :</label>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ph-calendar"></i></span>
                                                <input type="number" required placeholder="Hours" name="days" step="0.01"
                                                    class="form-control daterange-single">
                                            </div>
                                        </div>
                                    </div>


                                    {{-- <div class="col-6 col-md-3 mb-2">
                                    <label class="col-form-label ">Select Aprover <span
                                            class="text-danger">*</span> :</label>
                                    <div class="col-sm-12">
                                        <select class="form-control select" name="linemanager" id="linemanager">
                                            <option selected disabled> Select Approver</option>
                                            @foreach ($employees as $employee)

                                                <option value="{{ $employee->emp_id }}">{{ $employee->emp_id }} - {{ $employee->fname }}
                                                    {{ $employee->mname }} {{ $employee->lname }}</option>

                                             @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                                    {{-- <div class="col-12  mb-3">
                                    <label class="col-form-label ">Reason for overtime <span
                                            class="text-danger">*</span> :</label>
                                    <div class="col-sm-12">
                                        <textarea rows="3" cols="3" required class="form-control" name="reason" placeholder='Reason'></textarea>
                                    </div>
                                </div> --}}

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-perfrom float-end">Save</button>
                                    </div>


                            </form>
                            <br>
                            <hr>
                            <table class="table table-striped table-bordered datatable-basic">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Employee Name</th>
                                        <th>Department</th>
                                        <th>Overtime Category</th>
                                        <th>Total Overtime(in Hrs.)</th>
                                        <th>Amount</th>
                                        <th>Action</th>


                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    <?php foreach ($line_overtime as $row) { ?>



                                    <tr>
                                        <td width="1px"><?php echo $i++; ?></td>
                                        <td><?php echo $row->name; ?></td>
                                        <td><?php echo '<b>Department: </b>' . $row->DEPARTMENT . '<br><b>Position: </b>' . $row->POSITION; ?></td>
                                        <td>{{ $row->overtime_category }} </td>
                                        <td>{{ $row->totoalHOURS }} </td>
                                        <td><?php echo $row->amount; ?></td>


                                        <td> <a href="javascript:void(0)" title="Approve" class="me-2"
                                                onclick="cancelOvertime(<?php echo $row->id; ?>)">
                                                <button class="btn btn-danger btn-xs"><i class="ph-x"></i></button>
                                            </a></td>
                                    </tr>

                                    <?php }  ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    {{-- / --}}


    </div>
    {{-- @endcan --}}
    {{-- / --}}
@endsection

@push('footer-script')
    {{-- @include("app.includes.overtime_operations") --}}

    <script>
        function holdOvertime(id) {
            // Swal.fire({

            //         var overtimeid = id;

            //         $.ajax({
            //             url: "{{ url('flex/holdOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });

            //             $('#status' + id).fadeOut('fast', function() {
            //                 $('#status' + id).fadeIn('fast').html(
            //                     '<div class="col-md-12"><span class="label label-success">HELD</span></div>'
            //                     );
            //             });

            //             alert('Request Canceled!');

            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Hold Failed!! ...');
            //         });
            //     }
            // });


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

            // if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
            //     var overtimeid = id;

            //     $.ajax({
            //             url: "{{ url('flex/approveOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });
            //             /*$('#status'+id).fadeOut('fast', function(){
            //                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });
            //             $('#record'+id).fadeOut('fast', function(){
            //                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });*/
            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Approval Failed!! ...');
            //         });
            // }
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


            // if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {

            //         var overtimeid = id;

            //         $.ajax({
            //             url: "{{ url('flex/lineapproveOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {

            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });

            //             /*$('#status'+id).fadeOut('fast', function(){
            //                 $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                 });
            //             $('#record'+id).fadeOut('fast', function(){
            //                 $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                 });*/

            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             // Basic initialization

            //             alert('Overtime Approval Failed!! ...');
            //         });
            // }
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


            // if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
            //         var overtimeid = id;

            //         $.ajax({
            //             url: "{{ url('flex/hrapproveOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });
            //             /*$('#status'+id).fadeOut('fast', function(){
            //                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });
            //             $('#record'+id).fadeOut('fast', function(){
            //                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });*/
            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Approval Failed!! ...');
            //         });
            // }
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


            // if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
            //         var overtimeid = id;

            //         $.ajax({
            //             url: "{{ url('flex/fin_approveOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });
            //             /*$('#status'+id).fadeOut('fast', function(){
            //                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });
            //             $('#record'+id).fadeOut('fast', function(){
            //                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });*/
            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Approval Failed!! ...');
            //         });
            // }
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


            // if (confirm("Are You Sure You Want to Dissaprove This Overtime Request") == true) {
            //     var overtimeid = id;

            //     $.ajax({
            //         url: "{{ url('flex/denyOvertime') }}/" + overtimeid
            //     })
            //     .done(function(data) {
            //         $('#resultfeedOvertime').fadeOut('fast', function() {
            //             $('#resultfeedOvertime').fadeIn('fast').html(data);
            //         });
            //         $('#status' + id).fadeOut('fast', function() {
            //             $('#status' + id).fadeIn('fast').html(
            //                 '<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>'
            //                 );
            //         });
            //         $('#record' + id).fadeOut('fast', function() {
            //             $('#record' + id).fadeIn('fast').html(
            //                 '<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>'
            //                 );
            //         });
            //         alert('Request Dissaproved! ...');
            //     })
            //     .fail(function() {
            //         alert('Overtime Dissaproval Failed!! ...');
            //     });
            // }
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

            // if (confirm("Are You Sure You Want to Recommend This Overtime Request") == true) {
            //     var overtimeid = id;

            //     $.ajax({
            //             url: "{{ url('flex/recommendOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });
            //             $('#status' + id).fadeOut('fast', function() {
            //                 $('#status' + id).fadeIn('fast').html(
            //                     '<div class="col-md-12"><span class="label label-info">RECOMENDED</span></div>'
            //                     );
            //             });
            //             alert('Request Recommended Successifully!! ...');
            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Recommendation Failed!! ...');
            //         });
            // }
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


            // if (confirm("Are You Sure You Want to Confirm This Overtime Request") == true) {
            //     var overtimeid = id;

            //         $.ajax({
            //             url: "{{ url('flex/confirmOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });
            //             $('#status' + id).fadeOut('fast', function() {
            //                 $('#status' + id).fadeIn('fast').html(
            //                     '<div class="col-md-12"><span class="label label-info">CONFIRMED</span></div>'
            //                     );
            //             });
            //             alert('Request Confirmed Successifully!! ...');
            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Confirmation Failed!! ...');
            //         });
            // }
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
                            url: "{{ url('flex/cancelApprovedOvertimes') }}/" + overtimeid
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
                                'Request Cancelled Successfully!',
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
                    url: "{{ url('/flex/applyOvertimeOnbehalf') }}",
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
                        setTimeout(function() {
                            location.reload();
                        }, 5000)
                    });


                    // setTimeout(function() {
                    //                         var url =
                    //                             "{{ route('flex.overtime') }}"
                    //                         window.location.href = url;
                    //                     }, 1000)


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
@endpush
@push('footer-script')
    {{-- @include("app.includes.overtime_operations") --}}

    <script>
        function holdOvertime(id) {
            // Swal.fire({

            //         var overtimeid = id;

            //         $.ajax({
            //             url: "{{ url('flex/holdOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });

            //             $('#status' + id).fadeOut('fast', function() {
            //                 $('#status' + id).fadeIn('fast').html(
            //                     '<div class="col-md-12"><span class="label label-success">HELD</span></div>'
            //                     );
            //             });

            //             alert('Request Canceled!');

            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Hold Failed!! ...');
            //         });
            //     }
            // });


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

            // if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
            //     var overtimeid = id;

            //     $.ajax({
            //             url: "{{ url('flex/approveOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });
            //             /*$('#status'+id).fadeOut('fast', function(){
            //                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });
            //             $('#record'+id).fadeOut('fast', function(){
            //                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });*/
            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Approval Failed!! ...');
            //         });
            // }
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


            // if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {

            //         var overtimeid = id;

            //         $.ajax({
            //             url: "{{ url('flex/lineapproveOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {

            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });

            //             /*$('#status'+id).fadeOut('fast', function(){
            //                 $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                 });
            //             $('#record'+id).fadeOut('fast', function(){
            //                 $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                 });*/

            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             // Basic initialization

            //             alert('Overtime Approval Failed!! ...');
            //         });
            // }
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


            // if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
            //         var overtimeid = id;

            //         $.ajax({
            //             url: "{{ url('flex/hrapproveOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });
            //             /*$('#status'+id).fadeOut('fast', function(){
            //                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });
            //             $('#record'+id).fadeOut('fast', function(){
            //                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });*/
            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Approval Failed!! ...');
            //         });
            // }
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


            // if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
            //         var overtimeid = id;

            //         $.ajax({
            //             url: "{{ url('flex/fin_approveOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });
            //             /*$('#status'+id).fadeOut('fast', function(){
            //                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });
            //             $('#record'+id).fadeOut('fast', function(){
            //                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
            //                });*/
            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Approval Failed!! ...');
            //         });
            // }
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


            // if (confirm("Are You Sure You Want to Dissaprove This Overtime Request") == true) {
            //     var overtimeid = id;

            //     $.ajax({
            //         url: "{{ url('flex/denyOvertime') }}/" + overtimeid
            //     })
            //     .done(function(data) {
            //         $('#resultfeedOvertime').fadeOut('fast', function() {
            //             $('#resultfeedOvertime').fadeIn('fast').html(data);
            //         });
            //         $('#status' + id).fadeOut('fast', function() {
            //             $('#status' + id).fadeIn('fast').html(
            //                 '<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>'
            //                 );
            //         });
            //         $('#record' + id).fadeOut('fast', function() {
            //             $('#record' + id).fadeIn('fast').html(
            //                 '<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>'
            //                 );
            //         });
            //         alert('Request Dissaproved! ...');
            //     })
            //     .fail(function() {
            //         alert('Overtime Dissaproval Failed!! ...');
            //     });
            // }
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

            // if (confirm("Are You Sure You Want to Recommend This Overtime Request") == true) {
            //     var overtimeid = id;

            //     $.ajax({
            //             url: "{{ url('flex/recommendOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });
            //             $('#status' + id).fadeOut('fast', function() {
            //                 $('#status' + id).fadeIn('fast').html(
            //                     '<div class="col-md-12"><span class="label label-info">RECOMENDED</span></div>'
            //                     );
            //             });
            //             alert('Request Recommended Successifully!! ...');
            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Recommendation Failed!! ...');
            //         });
            // }
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


            // if (confirm("Are You Sure You Want to Confirm This Overtime Request") == true) {
            //     var overtimeid = id;

            //         $.ajax({
            //             url: "{{ url('flex/confirmOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });
            //             $('#status' + id).fadeOut('fast', function() {
            //                 $('#status' + id).fadeIn('fast').html(
            //                     '<div class="col-md-12"><span class="label label-info">CONFIRMED</span></div>'
            //                     );
            //             });
            //             alert('Request Confirmed Successifully!! ...');
            //             setTimeout(function() {
            //                 location.reload();
            //             }, 2000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Confirmation Failed!! ...');
            //         });
            // }
        }




        // function cancelOvertime(id) {

        //     Swal.fire({
        //         title: 'Are You Sure You Want to Cancel This Overtime Request?',
        //         // text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             var overtimeid = id;

        //             $.ajax({
        //                     url: "{{ url('flex/cancelOvertime') }}/" + overtimeid
        //                 })
        //                 .done(function(data) {
        //                     $('#resultfeedOvertime').fadeOut('fast', function() {
        //                         $('#resultfeedOvertime').fadeIn('fast').html(data);
        //                     });

        //                     $('#status' + id).fadeOut('fast', function() {
        //                         $('#status' + id).fadeIn('fast').html(
        //                             '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
        //                         );
        //                     });

        //                     // alert('Request Cancelled Successifully!! ...');

        //                     Swal.fire(
        //                         'Cancelled!',
        //                         'Request Cancelled Successifully!!.',
        //                         'success'
        //                     )

        //                     setTimeout(function() {
        //                         location.reload();
        //                     }, 1000);
        //                 })
        //                 .fail(function() {
        //                     Swal.fire(
        //                         'Failed!',
        //                         'Overtime Cancellation Failed!! ....',
        //                         'success'
        //                     )

        //                     alert('Overtime Cancellation Failed!! ...');
        //                 });
        //         }
        //     });

        //     // if (confirm("Are You Sure You Want to Cancel This Overtime Request") == true) {

        //     //     var overtimeid = id;

        //     //     $.ajax({
        //     //             url: "{{ url('flex/cancelOvertime') }}/" + overtimeid
        //     //         })
        //     //         .done(function(data) {
        //     //             $('#resultfeedOvertime').fadeOut('fast', function() {
        //     //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
        //     //             });

        //     //             $('#status' + id).fadeOut('fast', function() {
        //     //                 $('#status' + id).fadeIn('fast').html(
        //     //                     '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
        //     //                     );
        //     //             });

        //     //             alert('Request Cancelled Successifully!! ...');

        //     //             setTimeout(function() {
        //     //                 location.reload();
        //     //             }, 1000);
        //     //         })
        //     //         .fail(function() {
        //     //             alert('Overtime Cancellation Failed!! ...');
        //     //         });
        //     // }
        // }
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
