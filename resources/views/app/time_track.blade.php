@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Task and Exception </h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <?php if ($action == 0 && session('mng_proj')) { ?>

        <?php }
        if ($action == 1 && !empty($my_assignments)) {

            foreach ($my_assignments as $row) {
                $assignID = $row->id;
                $name = $row->name;
                $description = $row->description;
                $project = $row->project;
                $activity = $row->activity;
                $start_date = $row->start_date;
                $end_date = $row->end_date;
                $progress = $row->progress;
                $assignment_employee_id = $row->assignment_employee_id;

            }

            ?>

            <!-- UPDATE INFO AND SECTION -->
            <div class="row">
                <!-- Groups -->
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Assignment Details</b></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="feedBackAssignment"></div>
                                <p><b>Name:</b>
                                    &nbsp;<?php echo $name; ?>,  &nbsp&nbsp&nbsp <b>Project:</b> <?php echo $project; ?>, &nbsp&nbsp&nbsp
                                    Activity:
                                    <?php echo $activity; ?>, &nbsp&nbsp&nbsp
                                    <b>Description:</b> &nbsp<?php echo $description; ?>, &nbsp&nbsp&nbsp
                                    <b>Start Date:</b> &nbsp;&nbsp;&nbsp;<?php echo $start_date; ?>, &nbsp&nbsp&nbsp
                                    <b>End Date:</b> &nbsp;&nbsp;&nbsp;<?php echo $end_date; ?>, &nbsp&nbsp&nbsp
                                    <b>Progress:</b> &nbsp;&nbsp;&nbsp;<?php echo $progress; ?>%
                                </p>
                                <br>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="x_panel">

                            <div class="x_content">
                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#overtimeTab" id="home-tab" role="tab"
                                                                                  data-toggle="tab" aria-expanded="true">Tasks</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#exception" role="tab" id="profile-tab2"
                                                                            data-toggle="tab" aria-expanded="false">Exception</a>
                                        </li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="overtimeTab"
                                             aria-labelledby="home-tab">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="row">
                                                            <div class="col-sm-10">
                                                                <h2>Tasks </h2>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a href="#bottom">
                                                                    <button class="btn btn-primary btn-md">New Task</button>
                                                                    </a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content">
                                                        <table id="datatable" class="table table-striped table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>S/N</th>
                                                                <th>Task Name</th>
                                                                <th>Time</th>
                                                                <th>Status</th>
                                                                <?php if (session('mng_proj')) { ?>
                                                                <th>Created By</th>
                                                                <?php } ?>
                                                                <th>Option</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php $sn = 1; foreach ($time_track as $row) {?>
                                                            <tr>
                                                                <td><?php echo $sn?></td>
                                                                <td><?php echo $row->task_name?></td>
                                                                <td>
                                                                    <?php
                                                                    try {
                                                                        $d1 = new DateTime($row->start_date);
                                                                        $d2 = new DateTime($row->end_date);
                                                                        $diff = $d2->diff($d1);
                                                                        echo $diff->format('%h hour %i min ');
                                                                    } catch (Exception $e) {
                                                                        echo 'error';
                                                                    }

                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($row->status == 0) {
                                                                        echo '<span class="badge bg-primary">Pending</span>';
                                                                    }else{
                                                                        echo '<span class="badge bg-green">Approved</span>';
                                                                    }?>
                                                                </td>
                                                                <?php if (session('mng_proj')) { ?>
                                                                <td><?php echo $row->e_name ?></td>
                                                                <?php } ?>
                                                                <td>
                                                                    <?php if (session('mng_proj')) { ?>
                                                                        <?php if ($row->status == 0) { ?>
                                                                            <a href='javascript:void(0)' onclick='approveTask(<?php echo json_encode($row); ?>)' title="Approve" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>
                                                                        <?php }?>
                                                                    <?php } ?>
                                                                    <a href="<?php echo url('flex/project/commentInfo?code=') . base64_encode($assignID); ?>">
                                                                        <button type="button" class="btn btn-primary btn-xs" title="Comment"><i class="fa fa-comment"></i></button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php $sn++; } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="bottom" class="col-md-12 col-sm-6 col-xs-12">
                                                <!-- PANEL-->
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <h2>New Task</h2>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content">
                                                        <div id="feedbackResult"></div>
                                                        <form id="addTask" enctype="multipart/form-data" method="post"
                                                              data-parsley-validate class="form-horizontal form-label-left">
                                                            <input type="hidden" name="assignment_employee_id" value="<?php echo $assignment_employee_id; ?>">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                                       for="last-name">Name</label>
                                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                                    <input required type="text" max="150" class="form-control col-md-7 col-xs-12"
                                                                           name="names" placeholder="Task Name"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                                       for="last-name">Description</label>
                                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                                    <textarea required type="text" max="150" class="form-control col-md-7 col-xs-12"
                                                                              name="descriptions" placeholder="Description"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3  col-xs-6">Start
                                                                    Date Time</label>
                                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                                    <input type="text" name="start_date" required
                                                                           autocomplete="off" placeholder="Start Date Time"
                                                                           class="form-control col-xs-12 has-feedback-left"
                                                                           id="start_date_assign"
                                                                           aria-describedby="inputSuccess2Status">
                                                                    <span class="fa fa-calendar-o form-control-feedback right"
                                                                          aria-hidden="true"></span>

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3  col-xs-6">End
                                                                    Date Time</label>
                                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                                    <input type="text" name="end_date" required
                                                                           autocomplete="off" placeholder="End Date Time"
                                                                           class="form-control col-xs-12 has-feedback-left"
                                                                           id="end_date_assign"
                                                                           aria-describedby="inputSuccess2Status">
                                                                    <span class="fa fa-calendar-o form-control-feedback right"
                                                                          aria-hidden="true"></span>

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                                    <button id="submitButton" class="btn btn-primary">Save
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="exception"
                                             aria-labelledby="home-tab">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="row">
                                                            <div class="col-sm-10">
                                                                <h2>Exception </h2>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a href="#bottom1">
                                                                    <button class="btn btn-primary btn-md">New Exception</button>
                                                                    </a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content">
                                                        <table id="datatable1" class="table table-striped table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>S/N</th>
                                                                <th>Name</th>
                                                                <th>Exception Name</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $SNo = 1;
                                                            foreach ($all_exceptions as $row) { ?>
                                                                <tr id="domain<?php //echo $row->id;?>">
                                                                    <td width="1px"><?php echo $SNo; ?></td>
                                                                    <td width="1px"><?php echo $row->e_name; ?></td>
                                                                    <td width="1px"><?php echo $row->exception_type; ?></td>
                                                                    <td width="1px"><?php echo $row->start_date; ?></td>
                                                                    <td width="1px"><?php echo $row->end_date; ?></td>
                                                                </tr>
                                                                <?php $SNo++;
                                                            } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="bottom1" class="col-md-12 col-sm-6 col-xs-12">
                                                <!-- PANEL-->
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <h2>New Exception</h2>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content">
                                                        <div id="feedbackResult"></div>
                                                        <form id="addException" enctype="multipart/form-data" method="post"
                                                              data-parsley-validate class="form-horizontal form-label-left">
                                                            <input type="hidden" name="assignment_employee_id" value="<?php echo $assignment_employee_id; ?>">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                                       for="last-name">Assignment Name</label>
                                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                                    <input required type="text" max="150" class="form-control col-md-7 col-xs-12" id="name_ex" name="names" value="<?php echo $name; ?>" readonly placeholder=""/>
                                                                    <input type="hidden" max="150" class="form-control col-md-7 col-xs-12" id="name_ex_id" value="<?php echo $assignID; ?>" name="name_id" readonly placeholder=""/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                                       for="last-name">Exception</label>
                                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                                    <select class="form-control" required name="exception_type">
                                                                        <option value="" selected disabled>Select exception</option>
                                                                        <?php foreach ($exceptions as $row){ ?>
                                                                            <option value="<?php echo $row->name; ?>"><?php echo $row->name; ?></option> 
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3  col-xs-6">Start
                                                                    Date Time</label>
                                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                                    <input type="text" name="start_date" required
                                                                           autocomplete="off" placeholder="Start Date Time"
                                                                           class="form-control col-xs-12 has-feedback-left"
                                                                           id="start_date_assign_"
                                                                           aria-describedby="inputSuccess2Status">
                                                                    <span class="fa fa-calendar-o form-control-feedback right"
                                                                          aria-hidden="true"></span>

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3  col-xs-6">End
                                                                    Date Time</label>
                                                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                                    <input type="text" name="end_date" required
                                                                           autocomplete="off" placeholder="End Date Time"
                                                                           class="form-control col-xs-12 has-feedback-left"
                                                                           id="end_date_assign_"
                                                                           aria-describedby="inputSuccess2Status">
                                                                    <span class="fa fa-calendar-o form-control-feedback right"
                                                                          aria-hidden="true"></span>

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                                    <button id="submitButton" class="btn btn-primary">Save
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Groups -->

            </div>
            <!-- END UPDATE SECTION  -->
        <?php } ?>

    </div>
</div>


<!-- /page content -->




<script>
    $(document).ready(function(){
        $('#datatable1').DataTable( {
            responsive: true
        } );
    });
</script>

<script>

    $('#edit').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const modal = $(this);

        modal.find('.modal-body #id').val(button.data('id'));

    });

    $(function () {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear() - 18;
        var endYear = today.getFullYear() - 60;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }


        var dateStart = dd + '/' + mm + '/' + startYear;
        var dateEnd = dd + '/' + mm + '/' + endYear;
        $('#end_date_assign').daterangepicker({
            timePicker: true,
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'), 100),
            minDate: dateEnd,
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY,hh:mm A'
            },
            singleClasses: "picker_2"
        }, function (start, end, label) {

        });
        $('#end_date_assign').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY,hh:mm A'));
        });
        $('#end_date_assign').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

    $(function () {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear() - 18;
        var endYear = today.getFullYear() - 60;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }


        var dateStart = dd + '/' + mm + '/' + startYear;
        var dateEnd = dd + '/' + mm + '/' + endYear;
        $('#start_date_assign').daterangepicker({
            timePicker: true,
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'), 100),
            minDate: dateEnd,
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY,hh:mm A'
            },
            singleClasses: "picker_2"
        }, function (start, end, label) {

        });
        $('#start_date_assign').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY,hh:mm A'));
        });
        $('#start_date_assign').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

     $(function () {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear() - 18;
        var endYear = today.getFullYear() - 60;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }


        var dateStart = dd + '/' + mm + '/' + startYear;
        var dateEnd = dd + '/' + mm + '/' + endYear;
        $('#end_date_assign_').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'), 100),
            minDate: dateEnd,
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_2"
        }, function (start, end, label) {

        });
        $('#end_date_assign_').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#end_date_assign_').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

    $(function () {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear() - 18;
        var endYear = today.getFullYear() - 60;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }


        var dateStart = dd + '/' + mm + '/' + startYear;
        var dateEnd = dd + '/' + mm + '/' + endYear;
        $('#start_date_assign_').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'), 100),
            minDate: dateEnd,
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_2"
        }, function (start, end, label) {

        });
        $('#start_date_assign_').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#start_date_assign_').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

</script>

<script>
    $('#addTask').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo  url(''); ?>/flex/project/addTask",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
            .done(function (response) {
                if (response.status == 'OK') {
                    notify('Task added successfully!', 'top', 'right', 'success');
                    setTimeout(function () {// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                } else {
                    notify('Task error', 'top', 'right', 'danger');
                }
            })
            .fail(function () {
                alert('Request Failed!! ...');
            });
    });

     $('#addException').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo  url(''); ?>/flex/project/addException",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
            .done(function (response) {
                if (response.status == 'OK') {
                    notify('Exception added successfully!', 'top', 'right', 'success');
                    setTimeout(function () {// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                } else {
                    notify('Exception error', 'top', 'right', 'danger');
                }
            })
            .fail(function () {
                alert('Request Failed!! ...');
            });
    });

    function approveTask(row) {
        if (confirm("Are You Sure You Want To Approve This Task") == true) {
            var row = row;
            var id = row.id;
            $.ajax({
                url: "<?php echo url('flex/project/approveTask');?>/" + id,
               success: function (data) {

                   if (data.status == 'OK') {
                       notify('Task approved successfully!', 'top', 'right', 'success');
                       setTimeout(function () {// wait for 2 secs(2)
                           location.reload(); // then reload the page.(3)
                       }, 1000);
                   } else {
                       notify('Task approval error!', 'top', 'right', 'danger');
                       setTimeout(function () {// wait for 2 secs(2)
                           location.reload(); // then reload the page.(3)
                       }, 1000);

                   }
               }

            });
        }
    }

</script>

<script>
    function notify(message, from, align, type) {
        $.growl({
            message: message,
            url: ''
        }, {
            element: 'body',
            type: type,
            allow_dismiss: true,
            placement: {
                from: from,
                align: align
            },
            offset: {
                x: 30,
                y: 30
            },
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            url_target: '_blank',
            mouse_over: false,

            icon_type: 'class',
            template: '<div data-growl="container" class="alert" role="alert">' +
                '<button type="button" class="close" data-growl="dismiss">' +
                '<span aria-hidden="true">&times;</span>' +
                '<span class="sr-only">Close</span>' +
                '</button>' +
                '<span data-growl="icon"></span>' +
                '<span data-growl="title"></span>' +
                '<span data-growl="message"></span>' +
                '<a href="#!" data-growl="url"></a>' +
                '</div>'
        });
    }

</script>





 @endsection