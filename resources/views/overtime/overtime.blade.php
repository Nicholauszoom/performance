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
                        <h5 class="text-warning">Apply Overtime</h5>
                    </div>

                    <div class="card-body">
                        <div id="resultfeedSubmission" class="mb-3"></div>

                        <form id="applyOvertime" enctype="multipart/form-data" method="post" data-parsley-validate
                            autocomplete="off">
                            @csrf

                            <div class="modal-body">
                                <div class="row">

                            
                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-3">Overtime Category <span
                                            class="text-danger">*</span> :</label>
                                    <div class="col-sm-9">

                                        <select class="form-control select_category select" name="category" required>
                                            <option selected disabled> Select </option>
                                            @foreach ($overtimeCategory as $overtimeCategorie)
                                                <option value="{{ $overtimeCategorie->id }}"> {{ $overtimeCategorie->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-3">Time Start <span class="text-danger">*</span>
                                        :</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ph-calendar"></i></span>
                                            <input type="text" required placeholder="Start Time" name="time_start"
                                                id="time_start" class="form-control daterange-single">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-3">Time End <span class="text-danger">*</span>
                                        :</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ph-calendar"></i></span>
                                            <input type="text" required placeholder="Finish Time" name="time_finish"
                                                id="time_end" class="form-control daterange-single">
                                        </div>
                                    </div>
                                </div>



                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-3">Select Aprover <span
                                            class="text-danger">*</span> :</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select" name="linemanager" id="linemanager">
                                            <option selected disabled> Select Approver</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->emp_id }}">{{ $employee->fname }}
                                                    {{ $employee->mname }} {{ $employee->lname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-3">Reason for overtime <span
                                            class="text-danger">*</span> :</label>
                                    <div class="col-sm-9">
                                        <textarea rows="3" cols="3" required class="form-control" name="reason" placeholder='Reason'></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-perfrom">Send Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
    {{-- / --}}

    {{-- start of view my overtime card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0--}}
    @can('view-my-overtime')
    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header mb-0">
            <div class="d-flex justify-content-between">
                <h4 class="text-warning">My Overtime</h4>
                {{-- start of apply overtime button --}}
                @can('apply-overtme')
                <a href="#apply_overtime" class="btn btn-perfrom"><i class="ph-plus me-2"></i> Apply Overtime</a>
                @endcan
                {{-- / --}}
            </div>
        </div>

        <div class="card-body border-0 shadow-none">
            <?php session('note'); ?>
            <div id="myResultfeedOvertime"></div>
        </div>

        <table id="datatable" class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Date</th>
                    <th>Total Overtime(in Hrs.)</th>
                    <th>Reason(Description)</th>
                    <th>Status</th>
                    <th>Option</th>
                </tr>
            </thead>


            <tbody>
                <?php foreach ($my_overtimes as $row) { ?>
                <?php if(!$row->status==2) { ?>
                <tr id="domain<?php //echo $row->id;
                ?>">
                    <td width="1px"><?php echo $row->SNo; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($row->applicationDATE)); ?></td>
                    <td>
                        <?php echo '<b>Duration: </b>' . $row->totoalHOURS . ' Hrs.<br><b>From: </b>' . $row->time_in . ' <b> To </b>' . $row->time_out; ?>
                    </td>
                    <td><?php echo $row->reason; ?></td>
                    <td>
                        <div id="status<?php echo $row->eoid; ?>">
                            <?php if($row->status==0){ ?> <span class="badge bg-secondary">REQUESTED</span> <?php }
                        elseif($row->status==1){ ?> <span
                                class="badge bg-info">RECOMENDED</span> <?php }
                        elseif($row->status==2){ ?> <span
                                class="badge bg-success">APPROVED</span> <?php }
                        elseif($row->status==3){ ?> <i style="color:red"
                                class="ph-paper-plane-tilt"></i><?php }  ?>
                        </div>
                    </td>
                    <td class="options-width">
                        <?php if($row->status==0 || $row->status==3){ ?>
                        <a href="javascript:void(0)" onclick="cancelOvertime(<?php echo $row->eoid; ?>)" title="Cancel overtime">
                            <button type="button" class="btn btn-danger btn-xs"><i class="ph-x"></i></button>
                        </a>
                        <?php } ?>
                    </td>
                </tr>
                <?php }  ?>
                <?php }  ?>
            </tbody>
        </table>
    </div>
    @endcan
    {{-- / --}}

    {{--  start of others overtime --}}
    @can('view-others-overtime')
    @if (count($line_overtime) > 0)
        <div class="card border-top  border-top-width-3 border-top-main rounded-0">
            <div class="card-header">
                <h4 class="text-warning">Others Overtime</h4>

                <?php session('note'); ?>
                <div id="myResultfeedOvertime"></div>
            </div>

            <table id="datatable-keytable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Total Overtime(in Hrs.)</th>
                        <th>Reason(Description)</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($line_overtime as $row) { ?>
                    <?php if ($row->status == 2) {
                        continue;
                    } ?>
                    <tr>
                        <td width="1px"><?php echo $row->SNo; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo '<b>Department: </b>' . $row->DEPARTMENT . '<br><b>Position: </b>' . $row->POSITION; ?></td>
                        <td><?php echo '<b>On: </b>' . date('d-m-Y', strtotime($row->applicationDATE)) . '<br><b>Duration: </b>' . $row->totoalHOURS . ' Hrs.<br><b>From: </b>' . $row->time_in . ' <b> To </b>' . $row->time_out; ?> </td>
                        <td><?php echo $row->reason; ?></td>

                        <td>
                            <div id="record<?php echo $row->eoid; ?>" class="mb-2">
                                <?php if($row->status==0){ ?> <span
                                    class="badge bg-default">REQUESTED</span><?php }
                            elseif($row->status==1 && $pendingPayroll==0){ ?><span
                                    class="badge bg-info">RECOMENDED BY LINE MANAGER</span><?php }
                            elseif($row->status==4 && $pendingPayroll==0){ ?><span
                                    class="badge bg-success">APPROVED BY FINANCE</span><?php }
                            elseif($row->status==3 && $pendingPayroll==0 ){ ?><span
                                    class="badge bg-success">APPROVED BY HR</span><?php }
                            elseif($row->status==2){ ?><span
                                    class="badge bg-success">APPROVED BY CD</span><?php }
                            elseif($row->status==5){ ?><span
                                    class="badge bg-success">RETIREMENT CONFIRMED</span><?php }
                            elseif($row->status==6){ ?><span
                                    class="badge bg-danger">DISSAPPROVED</span><?php }
                            elseif($row->status==7){ ?><span
                                    class="badge bg-danger">UNCONFIRMED</span><?php }
                            elseif($row->status==8){ ?><span
                                    class="badge bg-danger">UNCONFIRMED RETIREMENT</span><?php } ?>
                            </div>


                            <?php  if ($row->status==0) {   ?>

                            {{-- start of approve overtime button --}}
                            @can('approve-overtime')
                            <a href="javascript:void(0)" title="Approve" class="me-2"
                                onclick="lineapproveOvertime(<?php echo $row->eoid; ?>)">
                                <button class="btn btn-main btn-xs"><i class="ph-check"></i></button>
                            </a>
                            @endcan
                            {{-- / --}}

                            {{-- start of cancel overtime button --}}
                            @can('cancel-overtime')
                            <a href="javascript:void(0)" title="Cancel" class="icon-2 info-tooltip"
                                onclick="cancelOvertime(<?php echo $row->eoid; ?>)">
                                <button class="btn btn-danger btn-xs"><i class="ph-x"></i></button>
                            </a>
                            @endcan
                            {{-- /  --}}

                            <?php }?>
                        </td>

                        {{-- start of cancel overtime --}}
                        @can('cancel-overtime')
                        <td class="options-width">
                            <?php //if($row->status==1 || $this->session->userdata('line') !=0 ){
                            ?> <?php //}
                            ?>
                            <?php //if ($row->status==2) {
                            ?>
                            {{-- start of cancel overtime button --}}
                            <a href="{{ route('flex.fetchOvertimeComment', $row->eoid) }}">
                                <button class='btn btn-main btn-xs'>Comment</i></button>
                            </a>
                            {{-- / --}}
                            <?php //}
                            ?>
                        </td>
                        @endcan
                        {{-- / --}}
                    </tr>
                    <?php }  ?>
                </tbody>
            </table>
        </div>
    @endif
    @endcan
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
                timePickerIncrement: 30,
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
                timePickerIncrement: 30,
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
                timePickerIncrement: 30,
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
                    $('#resultfeedSubmission').fadeOut('slow', function() {
                        $('#resultfeedSubmission').fadeIn('slow').html(data);
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

$('#docNo').change(function(){
    var id = $(this).val();
    var url = '{{ route("getDetails", ":id") }}';
    url = url.replace(':id', id);

    $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        success: function(response){
            if(response != null){

                document.getElementById("oldsalary").value = response.salary;
                document.getElementById("oldRate").value = response.rate;

                $('#salary').val(response.salary+' '+response.currency);
                $('#oldLevel').val(response.emp_level);
                $('#oldPosition').val(response.position.name);
            }
        }
    });
});


</script>


@endpush