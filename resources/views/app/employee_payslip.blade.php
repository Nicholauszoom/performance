@extends('layouts.vertical', ['title' => 'Payslip'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

    <div class="right_col" role="main">
        <div class="clearfix"></div>
        <div class="">
            <div class="col-md-12 col-sm-6 col-xs-12">
                    <!-- PANEL-->
            <div class="card">
                <div class="card-head">
                <h2>Employee Payslip </h2>
                <div class="clearfix"></div>
                </div>
                <div class="card-body">
                @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="{{ url("/flex/reports/payslip") }}" target="_blank"  data-parsley-validate class="form-horizontal form-label-left">

                <div class="form-group">
                    <label class="control-label col-md-3  col-xs-6" >Employee Type</label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                    <select id="employee_exited_list" onchange="filterType()" class="form-control" tabindex="-1">
                        <option value="1">Active</option>
                        <option value="2">Exited</option>
                    </select>
                    </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-md-3  col-xs-6" >Employee Name</label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                    <select required="" name="employee" id="employee_list" class="select4_single form-control" tabindex="-1">
                    <option></option>
                        <?php
                        foreach ($employee as $row) {
                            # code... ?>
                        <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                    </select>
                    </div>
                    </div>
                    <input hidden name ="profile" value="0">
                    <div class="form-group">
                    <label class="control-label col-md-3  col-xs-6" >Payroll Month</label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                    <select required="" name="payrolldate" class="select_payroll_month form-control" tabindex="-1">
                    <option></option>
                        <?php
                        foreach ($month_list as $row) {
                            # code... ?>
                        <option value="<?php echo $row->payroll_date; ?>"><?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                    </select>
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="reset" class="btn btn-success">CANCEL</button>
                        <input type="submit"  value="PRINT" id="print" name="print" class="btn btn-main"/>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Payslip Type</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label class="containercheckbox"> Employee
                                    <input type="radio" checked name="type" value="1">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="containercheckbox">temporary
                                    <input type="radio" name="type" value="2">
                                    <span class="checkmark"></span>
                                </label>
                                <span class="text-danger"><?php// echo form_error("fname");?></span>
                            </div>
                        </div>


                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <input type="submit"  value="PRINT ALL" id="print_all" name="print_all" class="btn btn-info"/>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
            </div>

            <div class="col-md-12 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-head">
                <h2>Payslip Mail Delivery List</h2>
                <div class="clearfix"></div>
                </div>
                <div class="card-body">
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
                                            <a href ="<?php echo  url(''); ?>/flex/reports/payroll_report/?pdate=<?php echo base64_encode($row->payroll_date); ?>" target = "blank" title="Print Report" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-file"></i></button> </a>
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
                            }, 1500);
                        }

                    }
                });
            }
        }

        $('#print_all').on('click',function () {
            $('#employee_list').prop('required',false);
        });

        $('#print').on('click',function () {
            $('#employee_list').prop('required',true);
        });

        function filterType(){
            let type = $('#employee_exited_list').val(); //1 active, 2 inactive

            $.ajax({
                url:"<?php echo url('flex/payroll/employeeFilter');?>/"+type,
                success:function(data)
                {
                    let jq_json_obj = $.parseJSON(data);
                    let jq_obj = eval (jq_json_obj);

                    //populate employee
                    $("#employee_list option").remove();

                    $('#employee_list').append($("<option value='' selected disabled>Select Employee</option>"));

                    $.each(jq_obj, function (detail, name) {
                        $('#employee_list').append($('<option>', {value: name.empID, text: name.NAME}));
                    });

                }
            });
        }

    </script>

@endsection
