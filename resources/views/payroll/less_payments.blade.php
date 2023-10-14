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
        <h5 class="mb-0 text-muted">Payroll</h5>
    </div>




    <div class="card-body">
        <?php //if($pendingPayroll==0 ){ ?>
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
                    <div id="payrollFeedback"></div>
                    <form autocomplete="off" id="initPayroll" method="POST" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <label class="form-label">Payroll Month:</label>
                            <input type="text" required="" placeholder="Payroll Month" name="payrolldate"
                                class="form-control col-xs-12 has-feedback-left" id="payrollDate"
                                aria-describedby="inputSuccess2Status">
                            <span class="ph-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        <div class="d-flex justify-content-end align-items-center">
                            <button name="init" type="submit" class="btn btn-success">RUN PAYROLL
                            </button>
                        </div>



                    </form>
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
                        action="{{route('reports.employeeCostExport_temp') }}"
                        data-parsley-validate class="form-horizontal form-label-left" target="_blank">
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
            url: (num == "0") ? "{{route('submitLessPayments')}}" :
                "{{route('temp_submitLessPayments')}}",
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