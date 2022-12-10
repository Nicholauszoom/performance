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
                <h3>Payroll</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div id="payrollFeedback"></div>
                    <div class="x_title"><br>
                        <h2>Partial Payment</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <!-- PANEL-->
                        <div class="x_panel">

                            <div class="x_title">
                                <h2>Partial Payment List</h2>
                                <div class="clearfix"></div>
                                <div id="feedBack"></div>
                            </div>

                            <div id="employeeList" class="x_content">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Employee Name</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Days</th>
                                        <th>Payroll Date</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($partial_payments as $row) { ?>
                                        <tr id="record<?php echo $row->id; ?>">
                                            <td width="1px"><?php echo $row->SNo; ?></td>
                                            <td><?php echo $row->name; ?></td>
                                            <td><?php echo $row->start_date; ?></td>
                                            <td><?php echo $row->end_date; ?></td>
                                            <td><?php echo $row->days; ?></td>
                                            <td><?php echo $row->payroll_date; ?></td>
                                            <td id="status<?php echo $row->empID; ?>">
                                                <?php if ($row->status == 1) { ?>
                                                    <span class="label label-success">Paid</span><br>
                                                <?php } else { ?>
                                                    <span class="label label-warning">Not Paid</span><br>
                                                <?php } ?>
                                            </td>
                                            <td id="status<?php echo $row->empID; ?>">
                                                <?php if ($row->status == 0 && session('mng_paym')) { ?>
                                                    <a href="javascript:void(0)"
                                                       onclick="deletePayment(<?php echo $row->id; ?>)"
                                                       title="Delete Payment" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-danger btn-xs"><i
                                                                    class="fa fa-trash"></i></button>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if ($pendingPayroll > 0) { ?>
                                <p class='alert alert-warning text-center'>No Incentive Payments Can Be Scheduled until
                                    the Pending Payoll is Responded</p>
                            <?php } ?>
                            <?php if ($pendingPayroll == 0 && session('mng_paym')) { ?>
                                <div class="x_title">
                                    <h2> Partial Payment</h2>
                                    <div class="clearfix"></div>
                                    <div id="feedBackSubmission"></div>
                                </div>
                                <form id="addPartialPayment" class="form-horizontal form-label-left input_mask"
                                      method="POST">

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Employee</label>
                                        <div class="col-md-3 col-sm-3 col-xs-6 form-group">
                                            <select required name="employee" class="select4_single form-control"
                                                    tabindex="-1">
                                                <option></option>
                                                <?php foreach ($employee as $row) { ?>
                                                    <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="text-danger"><?php// echo form_error("linemanager"); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">From Date</label>
                                        <div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
                                            <input type="text" required name="from" placeholder="from"
                                                   class="form-control col-xs-6 has-feedback-left" id="from" readonly
                                                   autocomplete="off" aria-describedby="inputSuccess2Status">
                                            <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">To Date</label>
                                        <div class="col-md-3 col-sm-3 col-xs-6 form-group has-feedback">
                                            <input type="text" required name="to" placeholder="to"
                                                   class="form-control col-xs-6 has-feedback-left" id="to" readonly
                                                   autocomplete="off" aria-describedby="inputSuccess2Status">
                                            <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                    </div>

                                    <input type="hidden" id="days" name="days">

                                    <!--<div class="ln_solid"></div>-->
                                    <div class="form-group">
                                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                            <?php if ($pendingPayroll == 0 && session('mng_paym')) { ?>
                                                <button type="reset" class="btn btn-default">Cancel</button>
                                                <button class="btn btn-primary">Submit</button>
                                            <?php } else { ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                </form>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <!--Employee Incentive List for this Montyh-->
        </div>
    </div>
</div>
<!-- /page content -->

<?php 
?>

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

<script>

    function deletePayment(id)
    {
        if (confirm("Are You Sure You Want To Delete This Payment?") == true) {
            var id = id;

            $.ajax({
                url:"<?php echo url('flex/deletePayment');?>/"+id,
                success:function(data)
                {
                    let jq_json_obj = $.parseJSON(data);
                    let jq_obj = eval (jq_json_obj);

                    if(jq_obj.status == 'OK'){
                        notify('Payment deleted successfuly!', 'top', 'right', 'success');
                        setTimeout(function(){// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    }else if(jq_obj.status = 'ERR'){
                        notify('Payment deletion failed!', 'top', 'right', 'warning');
                    }



                }

            });
        }
    }

    $('#addPartialPayment').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            url: "<?php echo  url(''); ?>/flex/partial",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                let jq_json_obj = $.parseJSON(data);
                let jq_obj = eval (jq_json_obj);

                if(jq_obj.status == 'OK'){
                    notify('Payment added successfully!', 'top', 'right', 'success');
                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                }else if(jq_obj.status == 'no_date'){
                    notify('Please input dates!', 'top', 'right', 'warning');
                }else if(jq_obj.status == 'date_mismatch'){
                    notify('Date mismatch!', 'top', 'right', 'warning');
                }

            }
        })
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
        $('#from').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_2"
        }, function (start, end, label) {

        });
        $('#from').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#from').on('cancel.daterangepicker', function (ev, picker) {
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
        $('#to').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_2"
        }, function (start, end, label) {

        });
        $('#to').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#to').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });

</script>



 @endsection