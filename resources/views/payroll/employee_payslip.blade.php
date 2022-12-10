@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/form_layouts.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    @php
        $month_list = $data['month_list'];
        $employee = $data['employee'];
        $payrollList = $data['payrollList'];
        $pendingPayroll = $data['pendingPayroll'];
    @endphp

    <div class="card">
        <div class="card-header border-0">
            <h5 class="mb-0 text-muted">Payroll</h5>
        </div>

        <div class="card-body">


                @if ($pendingPayroll==0 && session('mng_paym'))

                <div class="col-lg-6 offset-3">
                    <!-- Basic layout-->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Run Payroll</h5>
                        </div>

                        <div class="card-body">
                            <div id="payrollFeedback"></div>
                            <?php /*echo $this->session->flashdata("note"); */ ?>
                            <form id="demo-form2" enctype="multipart/form-data" method="post"
                                action="<?php /* echo base_url(); */ ?>index.php/reports/payslip" target="_blank"
                                data-parsley-validate class="form-horizontal form-label-left">

                                <div class="form-group">
                                    <label class="control-label col-md-3  col-xs-6">Employee Type</label>
                                    <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                                        <select id="employee_exited_list" onchange="filterType()" class="form-control"
                                            tabindex="-1">
                                            <option value="1">Active</option>
                                            <option value="2">Exited</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3  col-xs-6">Employee Name</label>
                                    <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                                        <select required="" name="employee" id="employee_list"
                                            class="select4_single form-control" tabindex="-1">
                                            <option></option>
                                            <?php
                                foreach ($employee as $row) {
                                    # code... ?>
                                            <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <input hidden name="profile" value="0">
                                <div class="form-group">
                                    <label class="control-label col-md-3  col-xs-6">Payroll Month</label>
                                    <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                                        <select required="" name="payrolldate" class="select_payroll_month form-control"
                                            tabindex="-1">
                                            <option></option>
                                            <?php
                                foreach ($month_list as $row) {
                                    # code... ?>
                                            <option value="<?php echo $row->payroll_date; ?>">
                                                <?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <br>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="reset" class="btn btn-success">CANCEL</button>
                                        <input type="submit" value="PRINT" id="print" name="print" class="btn btn-primary" />
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Payslip
                                            Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php /* echo form_error("fname"); */?></span>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <input type="submit" value="PRINT ALL" id="print_all" name="print_all"
                                            class="btn btn-info" />
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
                @endif



            <div class="col-lg-12 col-md-12 col-sm-6" id="hideList">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Payslip Mail Delivery List</h5>
                    </div>

                    <div class="card-body">
                        <table class="table datatable-basic">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Payroll Month</th>
                                    <th>Status</th>
                                    <th>Mail status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                            foreach ($payrollList as $row) { ?>

                                <tr id="domain<?php echo $row->id;?>">
                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                    <td><?php echo date('F, Y', strtotime($row->payroll_date));; ?>
                                    </td>
                                    <td>
                                        <?php if($row->state==1 || $row->state==2 ){   ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning">PENDING</span>


                                        <?php if(!$row->pay_checklist==1){ ?>
                                        <script>
                                        // setTimeout(function() {
                                        //     var url =
                                        //         "{{route('temp_payroll_info',['pdate'=>base64_encode($payrollList[0]->payroll_date)])}}"
                                        //     window.location.href = url;
                                        // }, 1000)
                                        </script>
                                        <?php  }?>

                                        <?php } else { ?>
                                        <span class="badge bg-success bg-opacity-20 text-success">APPROVED</span>
                                        <br>
                                        <?php  } ?>
                                    </td>
                                    <td>
                                        <?php if($row->email_status==0){ ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning">NOT SENT</span>
                                        <br>
                                        <?php } else { ?>
                                        <span class="badge bg-success bg-opacity-20 text-success">SENT</span>

                                        <?php  } ?>
                                    </td>

                                    <td class="options-width">
                                        <?php if($row->state==1 || $row->state==2){ ?>
                                        <div class="d-flex">
                                            <span style="margin-right: 4px">
                                                <a href="javascript:void(0)" onclick="cancelPayroll()"
                                                    title="Cancel Payroll" class="icon-2 info-tooltip">
                                                    <button type="button"
                                                        class="btn bg-danger bg-opacity-20 text-danger btn-xs">
                                                        <i class="ph-x"></i>
                                                    </button>
                                                </a>
                                            </span>

                                            <span style="margin-right: 4px">
                                                <a href="{{route('temp_payroll_info',['pdate'=>base64_encode($row->payroll_date)])}}<?php //echo base_url('index.php/payroll/temp_payroll_info/?pdate='.base64_encode($row->payroll_date));?>"
                                                    onclick="cancelPayroll()" title="Resend Pay Slip as Email"
                                                    class="icon-2 info-tooltip">
                                                    <button type="button"
                                                        class="btn  bg-warning bg-opacity-20 text-warning btn-xs">
                                                        <i class="ph-repeat"></i>
                                                        <i class="ph-envelope"></i>
                                                    </button>
                                                </a>
                                            </span>
                                        </div>

                                        <?php } else {  ?>
                                        <a href="{{route('payroll_info',['pdate'=>base64_encode($row->payroll_date)])}}<?php //echo base_url('index.php/payroll/payroll_info/?pdate='.base64_encode($row->payroll_date));?>"
                                            title="Info and Details" class="icon-2 info-tooltip"><button type="button"
                                                class="btn btn-info btn-xs"><i class="ph-circle"></i></button> </a>

                                        <?php if($row->state==0){ ?>
                                        <?php if($row->pay_checklist==1){ ?>
                                        <a href="{{route('payroll_report',['pdate'=>base64_encode($row->payroll_date)])}}<?php //echo base_url(); ?>index.php/reports/payroll_report/?pdate=<?php echo base64_encode($row->payroll_date); ?>"
                                            target="blank" title="Print Report" class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-info btn-xs">
                                                <i class="ph-printer"></i>
                                            </button> </a>
                                        <?php } else {  ?>
                                        <a title="Checklist Report Not Ready" class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-warning btn-xs"><i
                                                    class="ph-file"></i></button> </a>
                                        <?php } ?>

                                        <?php if($row->email_status==0){ ?>
                                        <a href="javascript:void(0)"
                                            onclick="sendEmail('<?php echo $row->payroll_date; ?>')"
                                            title="Send Pay Slip as Email" class="icon-2 info-tooltip"><button type="button"
                                                class="btn btn-success btn-xs"><i class="ph-envelope"></i></button> </a>
                                        <?php } else { ?>
                                        <a href="javascript:void(0)"
                                            onclick="sendEmail('<?php echo $row->payroll_date; ?>')"
                                            title="Resend Pay Slip as Email" class="icon-2 info-tooltip"><button
                                                type="button" class="btn btn-warning btn-xs"><i
                                                    class="ph-repeat"></i>&nbsp;&nbsp;<i class="ph-envelope"></i></button>
                                        </a>
                                        <?php } } ?>
                                        <?php } ?>

                                    </td>
                                </tr>
                                <?php }  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /basic layout -->
            </div>

        </div>


    </div>
@endsection

@push('footer-script')
<script>
    function sendEmail(payrollDate) {

        if (confirm(
                "Are You Sure You Want To want to Send The Payslips Emails to the Employees For the selected Payroll Month??"
            ) == true) {

            $.ajax({
                url: "{{route('send_payslips',"+payrollDate+")}}",
                success: function(data) {
                    let jq_json_obj = $.parseJSON(data);
                    let jq_obj = eval(jq_json_obj);
                    if (jq_obj.status === 'SENT') {
                        $('#feedBackMail').fadeOut('fast', function() {
                            $('#feedBackMail').fadeIn('fast').html(
                                "<p class='alert alert-success text-center'>Emails Have been sent Successifully</p>"
                            );
                        });
                        setTimeout(function() { // wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);
                    } else {
                        $('#feedBackMail').fadeOut('fast', function() {
                            $('#feedBackMail').fadeIn('fast').html(
                                "<p class='alert alert-danger text-center'>Emails sent error</p>");
                        });
                        setTimeout(function() { // wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);
                    }

                }

            });

        }

    }

    $('#print_all').on('click', function() {
        $('#employee_list').prop('required', false);
    });

    $('#print').on('click', function() {
        $('#employee_list').prop('required', true);
    });

    function filterType() {
        let type = $('#employee_exited_list').val(); //1 active, 2 inactive

        $.ajax({
            url: "{{route('employeeFilter',"+type+")}}",
            success: function(data) {
                let jq_json_obj = $.parseJSON(data);
                let jq_obj = eval(jq_json_obj);


                //populate employee
                $("#employee_list option").remove();
                $('#employee_list').append($("<option value='' selected disabled>Select Employee</option>"));
                $.each(jq_obj, function(detail, name) {
                    $('#employee_list').append($('<option>', {
                        value: name.empID,
                        text: name.NAME
                    }));
                });


            }

        });



    }
</script>
@endpush
