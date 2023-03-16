@extends('layouts.vertical', ['title' => 'Termination'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card border-top card-flex border-top-width-3 border-top-main rounded-0">
    <div class="card-header rounded-0 border-0" >
        <div class="d-flex justify-content-between">
            <h5 class="mb-0 text-warning">Terminated Employees</h5>


            @can('add-termination')

                <a href="{{ route('flex.addTermination') }}" class="btn btn-perfrom ">
                    <i class="ph-plus me-2"></i> Add Termination
                </a>
            @endcan
        </div>

    </div>
    <hr class="text-warning">

    @if (session('msg'))
    <div class="alert alert-success col-md-8 mx-auto" role="alert">
    {{ session('msg') }}
    </div>
    @endif

    <table class="table table-striped table-bordered  datatable-basic">
        <thead>
            <tr>
                <th>SN</th>
                <th>Date</th>
                <th>Employee Name</th>
                <th>Reason(Description)</th>
                <th>Status</th>
                <th>Option</th>
            </tr>
        </thead>

        <tbody>
               @foreach ($terminations as $item)
            <tr>
            <td>{{$i++}}</td>
            <td>{{ $item->terminationDate }}</td>
             <td>{{ $item->employee->fname}} {{ $item->employee->mname}} {{ $item->employee->lname}}</td>
             <td>{{ $item->reason}}</td>


             <td>
                <span class="badge bg-pending disabled">
                    {{ $item->status == '1' ? 'Terminated':'Pending' }}
                </span>

             </td>
             <td>

                <a  href="{{ url('flex/view-termination/'.$item->id) }}"  title="Print Terminal Benefit">
                    <button type="button" class="btn btn-main btn-xs" ><i class="ph-printer"></i></button>
                </a>

                @if($level)
                @if($item->status!='1')
                @if ($item->status!=$check)
                <br><br>
                @can('confirm-termination')
                {{-- start of termination confirm button --}}
                <a href="javascript:void(0)" title="Approve" class="me-2"
                onclick="approveTermination(<?php echo $item->id; ?>)">
                <button class="btn btn-main btn-xs">
                    <i class="ph-check"></i>
                    Confirm
                </button>
            </a>
                {{-- / --}}

                {{-- start of termination confirm button --}}

                <a href="javascript:void(0)" title="Cancel" class="icon-2 info-tooltip"
                onclick="cancelTermination(<?php echo $item->id; ?>)">
                <button class="btn btn-danger btn-xs">
                    <i class="ph-x"></i>
                      Cancel
                </button>
                 </a>
                {{-- / --}}
                @endcan
                @endif
                @endif
                @endif
             </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection


@push('footer-script')
    {{-- @include("app.includes.overtime_operations") --}}

    <script>

        function approveTermination(id) {


            Swal.fire({
                title: 'Are You Sure You Want to Terminate This Employee?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Confirm it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                        url: "{{ url('flex/approve-termination') }}/" + overtimeid
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
                confirmButtonColor: '#00204e',
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


        }



        function confirmOvertime(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Terminate this Employee ?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, confirm it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var terminationid = id;

                    $.ajax({
                        url: "{{ url('flex/confirmOvertime') }}/" + terminationid
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
                        alert('Employee is Terminated Successifully!! ...');
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




        function cancelTermination(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Cancel This Employee Termination?',
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
                        url: "{{ url('flex/cancel-termination') }}/" + terminationid
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
                            'Employee Termination Cancelled Successifully!!.',
                            'success'
                        )

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Employee Termination Cancellation Failed!! ....',
                            'success'
                        )

                        alert('Employee Termination Cancellation Failed!! ...');
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





@endpush
