
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')('content')

<?php ?>

<!-- /top navigation -->


<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="page-title">
        <div class="title_left">
            <h3>Payroll</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <?php if($pendingPayroll==0 && session('mng_paym')){ ?>
            <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Run Payroll</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="payrollFeedback"></div>
                        <form autocomplete="off" id="initPayroll" method="POST" class="form-horizontal form-label-left">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Payroll Month</label>
                            <div class="form-group">
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <div class="has-feedback">
                                            <input type="text" required="" placeholder="Payroll Month" name="payrolldate" class="form-control col-xs-12 has-feedback-left" id="payrollDate"  aria-describedby="inputSuccess2Status">
                                            <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                        <span class="input-group-btn">
                              <button name="init" class="btn btn-success">RUN PAYROLL</button>
                            </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div id="hideList" class="col-md-12 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Payslip Mail Delivery List


                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="feedBackMail"></div>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Payroll Month</th>
                            <th>Status</th>
                            <th>Mail Status</th>
                            <th>Option</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        foreach ($payrollList as $row) { ?>

                            <tr id="domain<?php echo $row->id;?>">
                                <td width="1px"><?php echo $row->SNo; ?></td>
                                <td><?php //echo $row->payroll_date; ?><?php echo date('F, Y', strtotime($row->payroll_date));; ?></td>
                                <td>
                                    <?php if($row->state==1 || $row->state==2 ){   ?>

                                        <span class="label label-warning">PENDING</span><br>

                                    <?php if(!$row->pay_checklist==1){ ?>
                                        <script>   setTimeout(function(){
                                                var url = "<?php echo url('flex/payroll/temp_payroll_info/?pdate='.base64_encode($payrollList[0]->payroll_date))?>"
                                                window.location.href = url;
                                            }, 1000)
                                        </script>
                                    <?php  }?>
                                    
                                    <?php } else { ?>
                                        <span class="label label-success">APPROVED</span><br>
                                    <?php  } ?>
                                </td>
                                <td>
                                    <?php if($row->email_status==0){ ?>
                                        <span class="label label-warning">NOT SENT</span><br>
                                    <?php } else { ?>
                                        <span class="label label-success">SENT</span><br>
                                    <?php  } ?>
                                </td>

                                <td class="options-width">
                                    <?php if($row->state==1 || $row->state==2){ ?>

                                        <a href="javascript:void(0)" onclick="cancelPayroll()"  title="Cancel Payroll" class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-danger btn-xs"> <i class="fa fa-times"></i></button></a>

                                        <a href="<?php echo url('flex/payroll/temp_payroll_info/?pdate='.base64_encode($row->payroll_date));?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                    <?php } else {  ?>
                                        <a href="<?php echo url('flex/payroll/payroll_info/?pdate='.base64_encode($row->payroll_date));?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>

                                        <?php if($row->state==0){ ?>
                                            <?php if($row->pay_checklist==1){ ?>
                                                <a href ="<?php echo url(); ?>flex/reports/payroll_report/?pdate=<?php echo base64_encode($row->payroll_date); ?>" target = "blank" title="Print Report" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-file"></i></button> </a>
                                            <?php } else {  ?>
                                                <a title="Checklist Report Not Ready" class="icon-2 info-tooltip"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-file"></i></button> </a>
                                            <?php } ?>

                                            <?php if($row->email_status==0){ ?>
                                                <a href="javascript:void(0)" onclick="sendEmail('<?php echo $row->payroll_date; ?>')" title="Send Pay Slip as Email" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-envelope"></i></button> </a>
                                            <?php } else { ?>
                                                <a href="javascript:void(0)" onclick="sendEmail('<?php echo $row->payroll_date; ?>')" title="Resend Pay Slip as Email" class="icon-2 info-tooltip"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i>&nbsp;&nbsp;<i class="fa fa-envelope"></i></button> </a>
                                            <?php } } ?>
                                    <?php } ?>

                                </td>
                            </tr>
                        <?php }  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<!-- NEW PAGE CONTENT -->

@include ("app/includes/update_allowances")

<script type="text/javascript">
    $('#initPayroll').submit(function(e){
        e.preventDefault();
        $('#initPayroll').hide();
        $.ajax({
            url:"<?php echo url(); ?>flex/payroll/initPayroll",
            type:"post",
            data:new FormData(this),
            processData:false,
            contentType:false,
            cache:false,
            async:false
        })
            .done(function(data){
                $('#payrollFeedback').fadeOut('fast', function(){
                    $('#payrollFeedback').fadeIn('fast').html(data);
                });
                setTimeout(function(){
                    location.reload();
                }, 1000)
            })
            .fail(function(){
                alert('Payroll Failed!! ...');
            });


    });
</script>

<script >
    function approvePayroll() {
        if (confirm("Are You Sure You Want To Approve This Payroll") == true) {
            // var id = id;
            $('#hideList').hide();
            $.ajax({
                url:"<?php echo url('flex/payroll/runpayroll');?>/<?php echo $pendingPayroll_month; ?>",
                success:function(data)
                {
                    if(data.status == 'OK'){
                        alert("Payroll Approved Successifully");

                        // SEND EMAILS
                        if (confirm("Payroll Approved Successifully!\n Do you want to send The Payslip as Email to All Employees??") == true) {
                            $.ajax({
                                url:"<?php echo url('flex/payroll/send_payslips');?>/<?php echo $pendingPayroll_month; ?>",
                                success:function(data) { }
                            });
                            // SEND EMAILS
                        }

                        $('#payrollFeedback').fadeOut('fast', function(){
                            $('#payrollFeedback').fadeIn('fast').html(data.message);
                        });
                        setTimeout(function(){// wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);
                    } else {
                        alert("Payroll Approval FAILED, Try again,  If the Error persists Contact Your System Admin.");

                        $('#payrollFeedback').fadeOut('fast', function(){
                            $('#payrollFeedback').fadeIn('fast').html(data.message);
                        });
                    }

                }

            });
        }
    }
</script>
<script >
    function recomendPayroll() {
        if (confirm("Are You Sure You Want To Recommend This Payroll") == true) {
            // var id = id;
            $('#hideList').hide();
            $.ajax({
                url:"<?php echo url('flex/payroll/recommendpayroll');?>/<?php echo $pendingPayroll_month; ?>",
                success:function(data)
                {
                    if(data.status == 'OK'){
                        alert("Payroll Recommend Successifully");


                        $('#payrollFeedback').fadeOut('fast', function(){
                            $('#payrollFeedback').fadeIn('fast').html(data.message);
                        });
                        setTimeout(function(){// wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);
                    } else {
                        alert("Payroll Recommendation FAILED, Try again,  If the Error persists Contact Your System Admin.");

                        $('#payrollFeedback').fadeOut('fast', function(){
                            $('#payrollFeedback').fadeIn('fast').html(data.message);
                        });
                    }

                }

            });
        }
    }
</script>


<script >
    function cancelPayroll() {
        if (confirm("Are You Sure You Want To Cancel This Payroll") == true) {
            // var id = id;
            $('#hideList').hide();
            $.ajax({
                url:"<?php echo url('flex/payroll/cancelpayroll');?>",
                success:function(data)
                {
                    if(data.status == 'OK'){
                        alert("Payroll was Cancelled Successifully!");

                        $('#payrollFeedback').fadeOut('fast', function(){
                            $('#payrollFeedback').fadeIn('fast').html(data.message);
                        });
                        setTimeout(function(){// wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);
                    } else {
                        alert("FAILED to Cancel Payroll, Try again,  If the Error persists Contact Your System Admin.");

                        $('#payrollFeedback').fadeOut('fast', function(){
                            $('#payrollFeedback').fadeIn('fast').html(data.message);
                        });
                    }

                }

            });
        }
    }
</script>
<script>
    $(function() {
        var minStartDate = "<?php echo date("d/m/Y", strtotime("-1 month") ); ?>";
        var dateToday = "<?php echo date("d/m/Y"); ?>";
        var maxEndDate = "<?php echo date("d/m/Y", strtotime("+1 month") ); ?>";
        $('#payrollDate').daterangepicker({
            drops: 'down',
            singleDatePicker: true,
            autoUpdateInput: false,
            startDate:dateToday,
            // minDate:minStartDate,
            maxDate:maxEndDate,
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_1"
        }, function(start, end, label) {
            // var years = moment().diff(start, 'years');
            // alert("The Employee is " + years+ " Years Old!");

        });
        $('#payrollDate').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#payrollDate').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
<script>
    function sendEmail(payrollDate) {

        if (confirm("Are You Sure You Want To want to Send The Payslips Emails to the Employees For the selected Payroll Month??") == true) {

            $.ajax({
                url:"<?php echo url('flex/payroll/send_payslips');?>/"+payrollDate,
                success:function(data)
                {
                    let jq_json_obj = $.parseJSON(data);
                    let jq_obj = eval (jq_json_obj);
                    if (jq_obj.status === 'SENT'){
                        $('#feedBackMail').fadeOut('fast', function(){
                            $('#feedBackMail').fadeIn('fast').html("<p class='alert alert-success text-center'>Emails Have been sent Successifully</p>");
                        });
                        setTimeout(function(){// wait for 2 secs(2)
                        location.reload(); // then reload the div to clear the success notification
                        }, 1500);
                    }else{
                        $('#feedBackMail').fadeOut('fast', function(){
                            $('#feedBackMail').fadeIn('fast').html("<p class='alert alert-danger text-center'>Emails sent error</p>");
                        });
                        setTimeout(function(){// wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);                    }
                }


            });

        }
    }
</script>

 @endsection