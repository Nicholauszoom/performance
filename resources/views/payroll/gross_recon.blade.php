@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
<script src="../../../../global_assets/js/plugins/forms/selects/select2.min.js"></script>
@endpush

@push('head-scriptTwo')

<script src="{{ asset('assets/js/form_layouts.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
@include('layouts.shared.page-header')
@endsection

@section('content')
@php
$payroll_date = $data['payroll_date'];
$payrollMonth = $payroll_date;
$previous = $data['previous'];
$payroll_list = $data['payroll_list'];
$confirmed = $data['confirmed'];
$payroll_state = $data['payroll_state'];
@endphp

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">{{$title}}</h5>
    </div>




    <div class="card-body">
        <?php //if($pendingPayroll==0 && session('mng_paym')){ ?>
        <div class="col-lg-6 offset-3">
            <!-- Basic layout-->
            <div class="card">
                <div class="card-header">
                    <h5>Employees in this Payroll<b>(<?php echo date("F, Y", strtotime($payroll_date));?>)</b> </h5>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>

                    <div class="clearfix"></div>
                </div>

                <div class="card-body">
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div id="payrollFeedback"></div>
                                <div class="card-head"><br>
                                    <!--                        <h2>Partial Payment</h2>-->
                                    <div class="clearfix"></div>
                                </div>
                                <div class="card-body">

                                    <div class="card">

                                        <div class="card-head">
                                            <h2>Gross Summary</h2>
                                            <div class="clearfix"></div>
                                            <div id="feedBack"></div>
                                        </div>

                                        <div id="employeeList" class="card-body">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th><b>Previous Month</b></th>
                                                        <td align="right">
                                                            <?php echo number_format($total_previous_gross,2); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Movement</b></th>
                                                        <td align="right">
                                                            <?php echo number_format($total_current_gross - $total_previous_gross,2); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><b>Current Month</b></th>
                                                        <td align="right">
                                                            <?php echo number_format($total_current_gross,2); ?></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>

                                    </div>

                                    <!-- PANEL-->
                                    <div class="card">

                                        <div class="card-head">
                                            <h2>Details</h2>
                                            <div class="clearfix"></div>
                                            <div id="feedBack"></div>
                                        </div>

                                        <div id="employeeList" class="card-body">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th><b>S/N</b></th>
                                                        <th><b>Employee Name</b></th>
                                                        <th><b>Current</b></th>
                                                        <th><b>Previous</b></th>
                                                        <th><b>Movement</b></th>
                                                        <th><b>Remarks</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                            $i = 1;
                            $i_move=0;
                            $current_staff = 0;
                            $previous_staff = 0;
                            foreach ($emp_ids as $row) { ?>
                                                    <?php
                                $remarks = '';
                                foreach ($current_payroll[$row->empID] as $current){
                                    if (isset($current->gross)){
                                        $current_staff++;
                                        $current_gross = $current->gross;
                                    }else{
                                        $current_gross = 0;
                                        $remarks = 'Employee Exit';
                                    }
                                }

                                foreach ($previous_payroll[$row->empID] as $previous){
                                    if (isset($previous->gross)){
                                        $previous_staff++;
                                        $previous_gross = $previous->gross;
                                    }else{
                                        $previous_gross = 0;
                                        $remarks = 'Employee Hired';
                                    }
                                }


                                ?>
                                                    <tr id="record<?php echo $row->empID; ?>">
                                                        <td width="1px"><?php echo $i?></td>
                                                        <td><?php echo $row->name; ?></td>
                                                        <td align="right"><?php echo number_format($current_gross,2); ?>
                                                        </td>
                                                        <td align="right">
                                                            <?php echo number_format($previous_gross,2); ?></td>
                                                        <td align="right"><?php
                                        $diff  = $current_gross - $previous_gross;
                                        $i_move += $diff;
                                        echo number_format($diff,2);
                                        ?></td>
                                                        <td><?php echo $remarks; ?></td>

                                                    </tr>
                                                    <?php $i++; ?>
                                                    <?php } ?>
                                                    <tr>
                                                        <th colspan="2" align="center"><b>Total</b></th>
                                                        <td align="right">
                                                            <?php echo number_format($total_current_gross,2); ?></td>
                                                        <td align="right">
                                                            <?php echo number_format($total_previous_gross,2); ?></td>
                                                        <td align="right"><?php echo number_format($i_move,2); ?></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="card">

                                        <div class="card-head">
                                            <!--                                <h2>Notes</h2>-->
                                            <div class="clearfix"></div>
                                            <div id="feedBack"></div>
                                        </div>

                                        <div id="employeeList" class="card-body">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <th><b>Staff changes</b></th>
                                                    <th><b>Number of staff</b></th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Last month</td>
                                                        <td align="right"><?php echo $previous_staff; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Current month</td>
                                                        <td align="right"><?php echo $current_staff; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="card">

                                        <div class="card-head">
                                            <!--                                <h2>Notes</h2>-->
                                            <div class="clearfix"></div>
                                            <div id="feedBack"></div>
                                        </div>

                                        <div id="employeeList" class="card-body">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <th><b>Staff Exit</b></th>
                                                </thead>
                                                <tbody>
                                                    <?php

                            foreach ($emp_ids as $row) { ?>
                                                    <?php
                                $name_exit = '';
                                foreach ($current_payroll[$row->empID] as $current){
                                    if (isset($current->gross)){
                                       //
                                    }else{
                                        $name_exit = $row->name;
                                    }
                                }
                                ?>
                                                    <?php if ($name_exit != '') {?>
                                                    <tr>
                                                        <td><?php echo $name_exit; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="card">

                                        <div class="card-head">
                                            <!--                                <h2>Notes</h2>-->
                                            <div class="clearfix"></div>
                                            <div id="feedBack"></div>
                                        </div>

                                        <div id="employeeList" class="card-body">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <th><b>Staff Joining</b></th>
                                                </thead>
                                                <tbody>
                                                    <?php

                            foreach ($emp_ids as $row) { ?>
                                                    <?php
                                $name_join = '';
                                foreach ($previous_payroll[$row->empID] as $previous){
                                    if (isset($previous->gross)){
                                        //
                                    }else{
                                        $name_join = $row->name;
                                    }
                                }
                                ?>
                                                    <?php if ($name_join != '') {?>
                                                    <tr>
                                                        <td><?php echo $name_join; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--Employee Incentive List for this Montyh-->
                    </div>
                </div>
            </div>

        </div>
        <?php //} ?>
        <div class="col-lg-12 col-md-12 col-sm-6" id="hideList">
            <!-- Basic layout-->
            <div class="card">
                <div class="card-body">
                    <?php if(isset($previous)) {?>
                    <form id="demo-form2" enctype="multipart/form-data" method="post"
                        action="{{route('reports.employeeCostExport_temp') }}" data-parsley-validate
                        class="form-horizontal form-label-left" target="_blank">
                        <input type="hidden" name="payrolldate" value="<?php echo $payroll_date; ?>">
                        <button type="submit" name="submit" value="submit" class="btn btn-main">PRINT</button>
                    </form>
                    <?php } ?>
                    <?php /*echo $this->session->flashdata("note"); */  ?>
                    <div id="feedBack"></div>
                    <!-- <form id="LessPaymentForm" method="post"> -->

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Department</th>
                                <th>Arreas</th>
                                <th>Expected</th>
                                <th>Confirmed</th>
                                <?php //if(session('mng_emp')){  ?>
                                <form method="post" id="lessPaymentForm">
                                    <input name="payroll_date" value="<?php echo $payrollMonth; ?>" type="hidden">
                                    <th>&nbsp;
                                        <button type="submit" name="submit" value="submit"
                                            class="btn btn-main">CONFIRM</button>
                                    </th>
                                </form>

                                <?php // } ?>
                                <?php if(isset($temp_check)) {?>
                                <?php if (isset($temp_check) && $temp_check == 1) {?>
                                <th>Pay Slip</th>
                                <?php }?>
                                <?php }?>

                            </tr>

                        </thead>
                        <tbody>
                            <?php
                          foreach ($payroll_list as $row) {
                            $net_salary = $row->salary + $row->allowances-$row->pension-$row->loans-$row->deductions-$row->meals-$row->taxdue;
                            $amount = round($net_salary,2); ?>
                            <tr>
                                <td width="1px"><?php echo $row->SNo; ?></td>
                                <td><?php echo $row->empID;?></td>
                                <td><?php echo $row->empName; ?></td>
                                <td>Department:<?php echo $row->department; ?><br>
                                    Position:<?php echo $row->position; ?></td>
                                <td><?php echo number_format($row->arrear_amount,2); ?></td>
                                <td><?php echo number_format($amount,2); ?></td>
                                <td><?php echo number_format($amount - $row->arrear_amount,2); ?></td>
                                <?php if(session('mng_emp')){  ?>
                                <td>

                                    <div class="form-group">
                                        <div class="col-sm-9">
                                            <input name="expected_takehome<?php echo $row->empID;?>"
                                                value="<?php echo $amount; ?>" type="hidden">
                                            <input style="width: 150%" name="actual_takehome<?php echo $row->empID;?>"
                                                value="<?php echo ($amount); ?>" min="1" max="<?php echo $amount; ?>"
                                                type="number" step="0.01" placeholder="Confirmed" class="form-control">
                                        </div>
                                    </div>
                                </td>
                                <?php } ?>
                                <?php if ($payroll_state == 0) {?>
                                <td>
                                    <form action="<?php echo base_url(); ?>index.php/reports/temp_payslip" method="post"
                                        target="_blank">
                                        <input type="hidden" value="<?php echo $row->empID;?>" name="employee">
                                        <input type="hidden" value="<?php echo $payroll_date;?>" name="payrolldate">
                                        <input hidden name="profile" value="0">
                                        <button type="submit" class="btn btn-sm btn-main"><i
                                                class="fa fa-file-pdf-o"></i></button>
                                    </form>
                                </td>
                                <?php }?>

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
<script type="text/javascript">
$('#lessPaymentForm').submit(function(e) {
    e.preventDefault();
    var num = <?php echo $confirmed ?>;
    $.ajax({
            url: (num == "0") ? "{{route('submitLessPayments')}}" : "{{route('temp_submitLessPayments')}}",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(data) {
            if (data.status == 1) {
                $('#feedBack').fadeOut('fast', function() {
                    $('#feedBack').fadeIn('fast').html(data.message);
                });
            } else {
                $('#feedBack').fadeOut('fast', function() {
                    $('#feedBack').fadeIn('fast').html(data.message);
                });
            }
            // setTimeout(function(){// wait for 2 secs(2)
            //           location.reload(); // then reload the page.(3)
            //       }, 1500);
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});
</script>
@endpush