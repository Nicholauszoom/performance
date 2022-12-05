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
$payroll_details = $data['payroll_details'];
$payroll_month_info =$data['payroll_month_info'];
$payroll_list = $data['payroll_list'];
$payroll_date = $data['payroll_date'];
$payroll_totals = $data['payroll_totals'];

$total_allowances = $data['total_allowances'];
$total_bonuses = $data['total_bonuses'];
$total_loans = $data['total_loans'];
$total_overtimes = $data['total_overtimes'];
$total_deductions = $data['total_deductions'];
$payroll_state = $data['payroll_state'];

$payrollMonth = $payroll_date;
$payrollState = $payroll_state;
foreach ($payroll_totals as $row) {
$salary = $row->salary;
$pension_employee = $row->pension_employee;
$pension_employer = $row->pension_employer;
$medical_employee = $row->medical_employee;
$medical_employer = $row->medical_employer;
$sdl = $row->sdl;
$wcf = $row->wcf;
$allowances = $row->allowances;
$taxdue = $row->taxdue;
$meals = $row->meals;
}
$paid_heslb = null;
$remained_heslb = null;
$paid = null;
$remained = null;
foreach ($total_loans as $key) {
if ($key->description == "HESLB"){
$paid_heslb = $key->paid;
$remained_heslb = $key->remained;

}else{
$paid = $key->paid;
$remained = $key->remained;
}
}
foreach ($payroll_month_info as $key) {
// $paid = $key->payroll_date;
$cheklist = $key->pay_checklist;
$state = $key->state;
}

@endphp

<div class="card">
    <div class="card-header border-0">
        <h3>Payroll Info <?php if($payrollState == 1){ ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
                href="<?php echo base_url(); ?>index.php/reports/payroll_report/?pdate=<?php echo base64_encode($payrollMonth); ?>"
                target="blank"><button type="button" name="print" value="print" class="btn btn-info">EXPORT
                    INFO</button></a><?php } ?></h3>
    </div>




    <div class="card-body">

        <div class="col-md-6 col-sm-6 col-xs-12 offset-4">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Details</b></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <h5> Salaries:
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($salary,2); ?></b></h5>
                    <h5>Total Allowances:
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($allowances,2); ?></b></h5>
                    <h5> Pension(Employer):
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($pension_employer,2); ?></b>
                    </h5>
                    <h5> Pension (Employee):
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($pension_employee,2); ?></b>
                    </h5>


                    <?php if ($meals) { ?>
                    <h5> Meals:
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($meals,2); ?></b></h5>
                    <?php } ?>
                    <h5> Taxdue (PAYE):
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($taxdue,2); ?></b></h5>
                    <h5> WCF:
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($wcf,2); ?></b></h5>
                    <h5> SDL:
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($sdl,2); ?></b></h5>

                </div>
            </div>
        </div>

        <?php if($payrollState == 0){ ?>
        <div class="col-md-6 col-sm-6 col-xs-12 offset-4">
            <div class="x_panel">
                <div id="resultConfirmation"></div>
                <div class="x_title">
                    <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>More Details</b></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php if($payrollState == 1){ ?>
                    <h5> Normal Allowances:
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format(($total_allowances-$total_overtimes-$total_bonuses),2); ?></b>
                    </h5>
                    <h5> Overtime:
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($total_overtimes,2); ?></b></h5>
                    <h5> Incentives:
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($total_bonuses,2); ?></b></h5>
                    <?php } ?>
                    <?php if ($paid_heslb) {?>
                    <h5> HESLB (Total Repayment):
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($paid_heslb,2); ?></b></h5>
                    <?php if ($remained_heslb>0) {?>
                    <h5> HESLB (Total Outstanding):
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($remained_heslb,2); ?></b></h5>
                    <?php }else {?>
                    <h5> HESLB (Total Outstanding):
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format(0,2); ?></b></h5>
                    <?php } ?>
                    <?php }?>
                    <?php if ($paid) {?>
                    <h5> Loans (Total Returns):
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($paid,2); ?></b></h5>
                    <h5> Loans (Total Outstanding):
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($remained,2); ?></b></h5>
                    <?php }?>
                    <!--                      <h5> Other Deductions:-->
                    <!--                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>--><?php //echo number_format($total_deductions,2); ?>
                    <!--</b></h5> -->

                </div>


                <div class="x_content">
                    <?php if($payrollState == 0 /*&&  $this->session->userdata('mng_emp')*/){ ?>
                    <a href="javascript:void(0)" onclick="generate_checklist()"><button type="button"
                            class="btn btn-success"><b>PAY CHECKLIST<br>
                                <small>Full Payment</b></small></button></a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php if($state==2 || $state==1){ ?>
                    <a href="{{route('ADVtemp_less_payments',['pdate',base64_encode($payrollMonth)])}}"><button
                            type="button" name="print" value="print" class="btn btn-warning"><b>PAY CHECKLIST<br>
                                <small>Payment With Arrears</b></small></button></a>
                    <?php } else { ?>
                    <a href="{{route('less_payments',['pdate',base64_encode($payrollMonth)])}}"><button type="button"
                            name="print" value="print" class="btn btn-warning"><b>PAY CHECKLIST<br>
                                <small>Payment With Arrears</b></small></button></a>
                    <?php } ?>
                    <?php }  else { ?>
                    <a href="{{route('ADVtemp_less_payments',['pdate',base64_encode($payrollMonth)])}}"><button
                            type="button" name="print" value="print" class="btn btn-warning"><b>PAY CHECKLIST<br>
                                <small>View</b></small></button></a>
                    <?php } ?>
                    <br>
                    <br>
                    <a target="_blank"
                        href="{{route('less_payments_print',['pdate',base64_encode($payrollMonth)])}}"><button
                            type="button" name="print_payroll" class="btn btn-primary"><b>PRINT<br></button></a>
                    <?php if($payrollState == 0) {?>
                    <a target="_self"
                        href="{{route('grossReconciliation',['pdate',base64_encode($payrollMonth)])}}"><button
                            type="button" name="print_payroll" class="btn btn-info"><b>GROSS RECON<br></button></a>
                    <a target="_self"
                        href="{{route('netReconciliation',['pdate',base64_encode($payrollMonth)])}}"><button
                            type="button" name="print_payroll" class="btn btn-info"><b>NET RECON<br></button></a>
                    <a target="_self" href="{{route('sendReviewEmail',['pdate',base64_encode($payrollMonth)])}}"><button
                            type="button" name="print_payroll" class="btn btn-info"><b>REVIEWED<br></button></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>


</div>

@endsection
@push('footer-script')
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

let check = <?php /*echo $this->session->userdata("email_sent"); */ ?>;

if (check) {
    <?php /*unset($this->session->userdata['email_sent']); */ ?>
    notify('Reviewed added successfuly!', 'top', 'right', 'success');
} else {
    <?php/* unset($this->session->userdata['email_sent']); */ ?>
    notify('Reviewed added successfuly!', 'top', 'right', 'warning');
}
</script>

<script>
function generate_checklist() {
    if (confirm("Are You Sure You Want To a Full Payment Cheklist for This Payroll") == true) {
        // var id = id;
        $('#hideList').hide();
        $.ajax({
            url: "{{route('generate_checklist',['pdate'=>base64_encode($payroll_date)])}}",
            success: function(data) {
                if (data.status == 1) {
                    alert("Pay CheckList Generated Successiful!");

                    $('#resultConfirmation').fadeOut('fast', function() {
                        $('#resultConfirmation').fadeIn('fast').html(data.message);
                    });
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the div to clear the success notification
                    }, 1500);
                } else {
                    alert(
                        "FAILED to Generate Pay Checklist, Try again, If the Error persists Contact Your System Admin."
                    );

                    $('#resultConfirmation').fadeOut('fast', function() {
                        $('#resultConfirmation').fadeIn('fast').html(data.message);
                    });
                }

            }

        });
    }
}
</script>
@endpush