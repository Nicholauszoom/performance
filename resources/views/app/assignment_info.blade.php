@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Assignment </h3>
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

            }

            ?>

            <!-- UPDATE INFO AND SECTION -->
            <div class="row">
                <!-- Groups -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Details</b></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="feedBackAssignment"></div>
                                <h5> <b>Name:</b>
                                    &nbsp;<?php echo $name; ?></h5>
                                <h5> <b>Project:</b>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $project; ?></h5>
                                <h5> <b>Activity:</b>
                                    <?php echo $activity; ?></h5>
                                <h5><b>Description:</b> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $description; ?>
                                </h5>
                                <h5><b>Start Date:</b> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $start_date; ?>
                                </h5>
                                <h5><b>End Date:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $end_date; ?>
                                </h5>
                                <h5><b>Progress:</b> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $progress; ?>%
                                </h5>
                                <br>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Team Members</b></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="table table-striped table-bordered" style="width:100%">
                                    <?php $sn = 1;
                                    foreach ($assignments as $row) { ?>
                                    <tr>
                                        <td><?php echo $sn?></td>
                                        <td><?php echo $row->e_name?></td>
                                        <td>
                                            <a href='javascript:void(0)' onclick='deleteEmployeeAssignment(<?php echo json_encode($row); ?>)' title="Delete Assignment" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                        </td>
                                    </tr>
                                    <?php $sn++; } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Groups -->

                <!--UPDATE-->
                <?php if (session('mng_proj')) { ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Update</b></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="feedbackResult"></div>
                                <form id="assignActivity" enctype="multipart/form-data" method="post"
                                      data-parsley-validate class="form-horizontal form-label-left">
                                    <input type="hidden" name="assignID" value="<?php echo $assignID?>">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                               for="last-name">Name</label>
                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input required="" id="assignment_name" type="text"
                                                   class="form-control col-md-7 col-xs-12"
                                                   name="assignment_name" value="<?php echo $name?>"
                                                   placeholder="Assignment Name"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6">Project
                                            Name</label>
                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <select required="" id="projectSelectList2" name="project_assign"
                                                    class="select2_project form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($projects as $row) { ?>
                                                    <option value="<?php echo $row->code; ?>"
                                                        <?php if ($project == $row->code) echo ' selected="selected"'; ?>><?php echo $row->code; ?></option> <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6">Activity
                                            Name</label>
                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <span class="badge bg-green"><?php echo $activity;?></span>
                                            <select required="" id="activitySelectList2" name="activity"
                                                    class="select_activity form-control" tabindex="-1">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6">Start
                                            Date</label>
                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input type="text" name="start_date"
                                                   autocomplete="off" placeholder="Start Date"
                                                   class="form-control col-xs-12 has-feedback-left"
                                                   id="start_date_assign" value="<?php echo $start_date?>"
                                                   aria-describedby="inputSuccess2Status">
                                            <span class="fa fa-calendar-o form-control-feedback right"
                                                  aria-hidden="true"></span>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6">End Date</label>
                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <input type="text" name="end_date"
                                                   autocomplete="off" placeholder="End Date"
                                                   class="form-control col-xs-12 has-feedback-left"
                                                   id="end_date_assign" value="<?php echo $end_date?>"
                                                   aria-describedby="inputSuccess2Status">
                                            <span class="fa fa-calendar-o form-control-feedback right"
                                                  aria-hidden="true"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6">Employee
                                            Name</label>
                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <select required="" id='employee1' name="employee[]"
                                                    class="select_multiple_employees_ form-control"
                                                    multiple="multiple">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                               for="last-name">Description </label>
                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                            <textarea required="" class="form-control col-md-7 col-xs-12" name="description"
                                                      placeholder="Project Description" rows="3"><?php echo $description; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button id="submitButton" class="btn btn-primary">Assign
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- END UPDATE SECTION  -->

            <?php if (session('vw_proj') || session('mng_proj')) { ?>
                <div class="row">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Cost</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table table-striped table-bordered" style="width:100%">
                                 <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Cost Category</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Created By</th>
                                        <!-- <th>Date Registered</th>
                                        <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                            <th>Option</th>
                                        <?php } ?> -->
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $SNo = 1;
                                foreach ($assignment_costs as $row) { ?>
                                    <tr id="domain<?php //echo $row->id;?>">
                                        <td width="1px"><?php echo $SNo; ?></td>
                                        <td width="1px"><?php echo $row->cost_category; ?></td>
                                        <td width="1px"><?php echo $row->description; ?></td>
                                        <td width="1px"><?php echo number_format($row->amount,2); ?></td>
                                        <td width="1px"><?php echo $row->name; ?></td>
                                    </tr>
                                    <?php $SNo++;
                                } ?>
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

    </div>
</div>


<!-- /page content -->




<script>
    $(".select2_project").select2({
        placeholder: "Select Project",
        allowClear: true
    });

    $(".select_activity").select2({
        placeholder: "Select Activity",
        allowClear: true
    });

    $(".select_multiple_employees_").select2({
        maximumSelectionLength: 10,
        placeholder: "Select Employees",
        allowClear: true
    });

</script>

<script>
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
        $('#end_date_assign').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
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
        $('#start_date_assign').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#start_date_assign').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

</script>

<script>

    $('#projectSelectList2').on('change', function () {
        var projectCode = $('#projectSelectList2').val();
        if (projectCode) {
            $.ajax({
                type: 'POST',
                url: '<?php echo url(); ?>flex/project/fetchActivity',
                data: 'projectCode=' + projectCode,
                success: function (html) {
                    $('#activitySelectList2').html(html);
                }
            });
        } else {
            $('#activitySelectList2').html('<option value="">Select Project</option>');
        }
    });

    $('#activitySelectList2').on('change', function () {
        var activityCode = $('#activitySelectList2').val();
        if (activityCode) {
            $.ajax({
                type: 'POST',
                url: '<?php echo url(); ?>flex/project/fetchEmployee',
                data: 'activityCode=' + activityCode,
                success: function (html) {
                    let jq_json_obj = $.parseJSON(html);
                    let jq_obj = eval(jq_json_obj);

                    //populate employee
                    $("#employee1 option").remove();

                    $.each(jq_obj, function (detail, name) {
                        $('#employee1').append($('<option>', {value: name.empID, text: name.name}));
                    });
                }
            });
        } else {
            // $('#grantList1').html('<option value="">Select Activity</option>');
        }
    });


</script>

<script type="text/javascript">

    function deleteEmployeeAssignment(row) {
        if (confirm("Are You Sure You Want To Delete This Assignment") == true) {
            var row = row;
            var id = row.id;
            var emp_id = row.emp_id;

            $.ajax({
                url: "<?php echo url('flex/project/deleteEmployeeAssignment');?>/" + id +"/"+emp_id,
                success: function (data) {

                    if (data.status == 'OK') {
                        notify('Assignment deleted successfully!', 'top', 'right', 'success');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    } else {
                        notify('Assignment deletion error!', 'top', 'right', 'danger');
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
        $('#end_date').daterangepicker({
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
        $('#end_date').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#end_date').on('cancel.daterangepicker', function (ev, picker) {
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
        $('#start_date').daterangepicker({
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
        $('#start_date').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#start_date').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

</script>

<script>
    $('#assignActivity').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo url(); ?>flex/project/updateAssignment",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
            .done(function (response) {
                let jq_json_obj = $.parseJSON(response);
                let jq_obj = eval(jq_json_obj);
                if (jq_obj.status == 'OK') {
                    notify('Assignment successfully!', 'top', 'right', 'success');
                    setTimeout(function () {// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                } else {
                    notify('Assignment error', 'top', 'right', 'danger');
                }
            })
            .fail(function () {
                alert('Request Failed!! ...');
            });
    });
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