@extends('layouts.vertical', ['title' => 'Payroll Input Changes'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/buttons.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_extension_buttons_excel.js') }}"></script>
@endpush

@section('content')
@php

   // $payroll_date = $data['payroll_date'];



    $payrollMonth = $payroll_date;
    $payrollState = $payroll_state;





@endphp

<div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
    <div class="card-header border-0">

       @include('payroll.payroll_info_buttons')

    </div>


    <div class="card-body">

        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <hr>
            @if($payrollState != 0)
        <a href="{{route('reports.get_payroll_temp_summary',['date'=>$payrollMonth,'type'=>2,'payrollState'=>$payrollState])}}" target="blank">
         <button type="button" name="print" value="print" class="btn btn-main btn-sm"> PDF</button>
     </a>
@else
     <a href="{{route('reports.get_payroll_temp_summary1',['payrolldate'=>$payrollMonth,'type'=>2,'payrollState'=>$payrollState])}}" target="blank">
        <button type="button" name="print" value="print" class="btn btn-main btn-sm"> PDF</button>
    </a>
    @endif
            <table class="table datatable-excel-filter">
                <thead>
                    <tr>
                        <th ><b>Pay No</b></th>
                                    <td></td>
                                    <th  colspan="2" class="text-center"><b>Name</b><br>
                                    </th>
                                    <th  class="text-end"><b>Basic Salary</b></th>
                                    <th  class="text-end"><b>Overtime</b></th>

                                    <th  class="text-end"><b>Respons. Allowance</b></th>
                                    <th  class="text-end"><b>House Allowance</b></th>
                                    <th  class="text-end"><b>Areas</b></th>
                                    <th  class="text-end"><b>Other Payment</b></th>
                                    <th  class="text-end"><b>Gross Salary</b></th>
                                    <th  class="text-end"><b>Tax Benefit</b></th>
                                    <th  class="text-end"><b>Taxable Gross</b></th>
                                    <th  class="text-end"><b>PAYE</b></th>


                                    <th  class="text-end"><b>NSSF</b></th>
                                    <th  class="text-end"><b>Loan Board</b></th>
                                    <th  class="text-end"><b>Advance/Others</b></th>
                                    <th  class="text-end"><b>Total Deduction</b></th>
                                    <th  class="text-end"><b>Ammount Payable</b></th>


                    </tr>
                </thead>
                <tbody>
                    <?php
                                $i =0;
                                if(!empty($summary)){
                                    $total_loans = 0;
                                    $others = 0;
                                    $total_teller_allowance = 0;
                                    $total_taxable_amount = 0;
                                    $total_gross_salary = 0;
                                    $total_taxs = 0;
                                    $total_salary = 0; $total_netpay = 0; $total_allowance = 0; $total_overtime = 0; $total_house_rent = 0; $total_sdl = 0; $total_wcf = 0;
                                    $total_tax = 0; $total_pension = 0; $total_others = 0; $total_deduction = 0; $total_gross_salary = 0; $taxable_amount = 0;
                                foreach ($summary as $row){
                                    $i++;
                                    $amount = $row->salary + $row->allowances-$row->pension_employer-$row->loans-$row->deductions-$row->meals-$row->taxdue;
                                    $total_netpay +=  round($amount,0);

                                    $total_gross_salary += ($row->salary + $row->allowances);
                                    $total_salary = $total_salary + $row->salary;
                                    $total_allowance = $total_allowance + $row->allowances ;
                                    $total_overtime = $total_overtime +$row->overtime;
                                    $total_house_rent = $total_house_rent + $row->house_rent;
                                    $total_others = $total_others + $row->other_payments ;
                                    $total_taxs += round($row->taxdue,0);

                                    $total_pension = $total_pension + $row->pension_employer;
                                    $total_deduction += ($row->salary + $row->allowances)-$amount;
                                    $total_sdl = $total_sdl + $row->sdl;
                                    $total_wcf = $total_wcf + $row->wcf;
                                    $total_taxable_amount += intval($row->salary + $row->allowances-$row->pension_employer);
                                    $total_loans = $total_loans + $row->total_loans;
                                    $total_teller_allowance += $row->teller_allowance;

                                    $others += $row->deductions;


                                ?>

                                <tr>

                                    <td class="text-end">{{ $row->emp_id }}</td>
                                    <td></td>
                                    <td class="" style="margin-right: 0px" colspan="">{{ $row->fname }} @if($row->fname == ""|| $row->fname == "" ) {{ substr($row->lname, 0, 3) }} @else @endif
                                    </td>
                                    <td class="" style="margin-left: 0px;" colspan="">{{ $row->lname }} @if($row->fname == ""|| $row->fname == "" ) {{ substr($row->lname, 0, 3) }} @else  @endif
                                    </td>

                                    <td class="text-end">{{ number_format($row->salary, 0) }}</td>

                                    <td class="text-end">{{ number_format($row->overtime, 0) }}</td>


                                    <td class="text-end">{{ number_format($row->teller_allowance, 0) }}</td>
                                    <td class="text-end">{{ number_format($row->house_rent, 0) }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}</td>

                                    <td class="text-end">{{ number_format($row->other_payments, 0) }}</td>

                                    <td class="text-end">{{ number_format($row->salary + $row->allowances, 0) }}
                                    </td>
                                    <td class="text-end">{{ number_format(0, 0) }}</td>
                                    <td class="text-end">
                                        {{ number_format($row->salary + $row->allowances - $row->pension_employer, 0) }}
                                    </td>
                                    <td class="text-end">{{ number_format($row->taxdue, 2) }}</td>

                                    <td class="text-end">{{ number_format($row->pension_employer, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->loans, 0) }}</td>

                                    <td class="text-end">{{ number_format(intval($row->deductions), 0) }}</td>

                                    <td class="text-end">
                                        {{ number_format(intval($row->salary) + intval($row->allowances) - intval($amount), 0) }}
                                    </td>
                                    <td class="text-end">{{ number_format($amount, 0) }}</td>


                                </tr>

                                <?php } ?>
                                @foreach ($termination as $row2)
                                    <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                        <td class="">{{ $row2->emp_id }}</td>

                                        <td></td>
                                        <td class="" style="margin-right: 0px" colspan="">{{ $row2->fname }}
                                        </td>
                                        <td class="" style="margin-left: 0px;" colspan="">{{ $row2->lname }}
                                        </td>


                                        <td class="text-end">{{ number_format($row2->salaryEnrollment,0) }}
                                        </td>

                                        <td class="text-end">{{ number_format(0,0) }}</td>



                                        <td class="text-end">{{ number_format(0,0) }}</td>
                                        <td class="text-end">{{ number_format(0,0) }}</td>

                                        <td class="text-end">{{ number_format(0,0) }}</td>

                                        <td class="text-end">
                                            {{ number_format($row2->leavePay + $row2->leaveAllowance,0) }}
                                        </td>
                                        @php $gros = $row2->salaryEnrollment + $row2->leaveAllowance + $row2->leavePay;  @endphp
                                        <td class="text-end">
                                            {{ number_format($row2->salaryEnrollment + $row2->leaveAllowance + $row2->leavePay,0) }}
                                        </td>
                                        <td class="text-end">{{ number_format(0,0) }}</td>
                                        <td class="text-end">
                                            {{ number_format($row2->taxable,0) }}
                                        </td>
                                        <td class="text-end">{{ number_format($row2->paye,2) }}</td>

                                        <td class="text-end">{{ number_format($row2->pension_employee, 2) }}
                                        </td>
                                        <td class="text-end">{{ number_format(0, 0) }}</td>
                                        <td class="text-end">{{ number_format($row2->loan_balance, 0) }}</td>
                                        <td class="text-end">
                                            {{ number_format($row2->pension_employee + $row2->paye + $row2->otherDeductions, 0) }}
                                        </td>
                                        <td class="text-end">{{ number_format(0, 0) }}</td>


                                    </tr>
                                    @php
                                        $others += $row2->loan_balance;
                                        $total_salary += $row2->salaryEnrollment;
                                        $total_others += $row2->leavePay + $row2->leaveAllowance;
                                        $total_taxable_amount += $row2->taxable;
                                        $total_taxs += $row2->paye;
                                        //$total_netpay += ($row2->taxable -$row2->paye);
                                        $total_deduction += $row2->pension_employee + $row2->paye + $row2->otherDeductions + $row2->loan_balance;
                                        $total_pension += $row2->pension_employee;
                                        $total_gross_salary += $row2->total_gross;

                                        // $total_gross_salary += ($row2->salaryEnrollment + $row2->leaveAllowance + $row2->leavePay);

                                    @endphp
                                @endforeach
                                <tfoot>
                                <tr style="font-size:10px; !important; border:3px solid rgb(9, 5, 64)">

                                    {{-- <td></td>
                                    <td></td>
                                    <td></td> --}}
                                    <td colspan="4">
                                            <b>
                                                <center><b>TOTAL<b></center>
                                                </b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_salary, 0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_overtime, 0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_teller_allowance, 0) }}</b></b>
                                    </td>

                                    <td class="text-end"><b><b>{{ number_format($total_house_rent, 0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format(0, 0) }}<b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_others, 0) }}</b></b></td>

                                    <td class="text-end">
                                        <b><b>{{ number_format($total_salary + $total_overtime + $total_teller_allowance + $total_house_rent + $total_others, 0) }}</b></b>
                                    </td>

                                    <td class="text-end"><b><b> {{ number_format(0, 0) }}</b></b></td>
                                    <td class="text-end">
                                        <b><b>{{ number_format($total_salary + $total_overtime + $total_teller_allowance + $total_house_rent + $total_others - $total_pension, 0) }}</b></b>
                                    </td>

                                    <td class="text-end"><b><b>{{ number_format($total_taxs, 2) }}</b></b></td>

                                    <td class="text-end"><b><b>{{ number_format($total_pension, 0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_loans, 0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($others, 0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_deduction, 0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_netpay, 0) }}</b></b></td>

                                </tr>
                            </tfoot>

                                <?php } ?>
            </table>

        </div>

       </div>
        <hr>

         <?php if($payrollState == 9){ ?> {{-- was 0 --}}
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="card border-top border-bottom border-bottom-width-3 border-bottom-main rounded-0 border-0 shadow-none">
                <div id="resultConfirmation"></div>

                <div class="mb-2 ms-auto">
                  <!--  <h4 class="text-muted">More Details:</h4> -->

                    @if ($payrollState == 1)
                    <div class="d-flex flex-wrap wmin-lg-400 mb-2">
                        <ul class="list list-unstyled mb-0">
                            <li><h6 class="my-2">Normal Allowances:</h6></li>
                            <li><h6 class="my-2">Overtime:</h6></li>
                            <li><h6 class="my-2">Incentives:</h6></li>
                        </ul>

                        <ul class="list list-unstyled text-end mb-0 ms-auto">
                            <li><h6 class="fw-semibold">{{ number_format(($total_allowances-$total_overtimes-$total_bonuses),2) }}</h6></li>
                            <li><h6 class="fw-semibold">{{ number_format($total_overtimes,2) }}</h6></li>
                            <li><h6 class="fw-semibold">{{ number_format($total_bonuses,2) }}</h6></li>
                        </ul>
                    </div>
                    @endif

                    @if ($paid_heslb)
                    <div class="d-flex flex-wrap wmin-lg-400 mb-2">
                        <ul class="list list-unstyled mb-0">
                            <li><h6 class="my-2">HESLB (Total Repayment):</h6></li>
                        </ul>

                        <ul class="list list-unstyled text-end mb-0 ms-auto">
                            <li><h6 class="fw-semibold">{{ number_format($paid_heslb,2) }}</h6></li>
                        </ul>
                    </div>
                    @endif

                    @if ($remained_heslb > 0)
                    <div class="d-flex flex-wrap wmin-lg-400">
                        <ul class="list list-unstyled mb-0">
                            <li><h6 class="my-2">HESLB (Total Outstanding):</h6></li>
                        </ul>

                        <ul class="list list-unstyled text-end mb-0 ms-auto">
                            <li><h6 class="fw-semibold">{{ number_format($remained_heslb,2) }}</h6></li>
                        </ul>
                    </div>
                    @elseif($remained_heslb < 0)
                    <div class="d-flex flex-wrap wmin-lg-400 mb-3">
                        <ul class="list list-unstyled mb-0">
                            <li><h6 class="my-2">HESLB (Total Outstanding):</h6></li>
                        </ul>

                        <ul class="list list-unstyled text-end mb-0 ms-auto">
                            <li><h6 class="fw-semibold">{{ number_format(0,2) }}</h6></li>
                        </ul>
                    </div>
                    @endif

                    @if ($paid)
                    <div class="d-flex flex-wrap wmin-lg-400">
                        <ul class="list list-unstyled mb-0">
                            <li><h6 class="my-2">Loans (Total Returns):</h6></li>
                            <li><h6 class="my-2">Loans (Total Outstanding):</h6></li>
                        </ul>

                        <ul class="list list-unstyled text-end mb-0 ms-auto">
                            <li><h6 class="fw-semibold">{{ number_format($paid,2) }}</h6></li>
                            <li><h6 class="fw-semibold">{{ number_format($remained,2) }}</h6></li>
                        </ul>
                    </div>
                    @endif
                </div>

                <div class="mb-2 ms-auto d-flex justify-content-around">
                    <?php if($payrollState == 0 /*&&  session('mng_emp')*/){ ?>

                        @can('approve-payroll')
                        <a href="{{route('payroll.cancelpayroll','none')}}" class="m-3">
                            <button type="button" class="btn btn-warning">Cancel Payroll </button>
                        </a>


                        <a href="javascript:void(0)" onclick="generate_checklist()" class="m-3">
                            <button type="button" class="btn btn-main">Perform Calculation </button>
                        </a>
                        @endcan
                    <?php }  else { ?>
                    <a href="{{route('ADVtemp_less_payments',['pdate',base64_encode($payrollMonth)])}}">
                        <button type="button" name="print" value="print" class="btn btn-warning">PAY CHECKLIST</button>
                    </a>
                    <?php } ?>

                    <a class="my-3" target="_blank" href="{{route('payroll.less_payments_print',['pdate',base64_encode($payrollMonth)])}}">
                        <button type="button" name="print_payroll" class="btn btn-main">Print Checklist</button>
                    </a>

                    <?php if($payrollState == 0) {?>
                    @can('view-gross')
                    <a class="m-3" target="_self" href="{{route('payroll.grossReconciliation',['pdate'=>base64_encode($payrollMonth)])}}">
                        <button type="button" name="print_payroll" class="btn btn-info">Gross Recon</button>
                    </a>
                    <a class="m-3" target="_self" href="{{route('payroll.netReconciliation',['pdate'=>base64_encode($payrollMonth)])}}">
                        <button type="button" name="print_payroll" class="btn btn-info">Net Recon</button>
                    </a>
                    @endcan
                    <!-- <a class="m-3" target="_self" href="{{route('payroll.sendReviewEmail',['pdate'=>base64_encode($payrollMonth)])}}"><button
                            type="button" name="print_payroll" class="btn btn-info"><b>REVIEWED<br></button></a> -->
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

let check = <?php /*echo session("email_sent"); */ ?>;

if (check) {
    <?php /*unset(session['email_sent']); */ ?>
    notify('Reviewed added successfuly!', 'top', 'right', 'success');
} else {
    <?php/* unset(session['email_sent']); */ ?>
    notify('Reviewed added successfuly!', 'top', 'right', 'warning');
}
</script>

<script>
function generate_checklist() {

    // Advanced initialization
    Swal.fire({
        title: 'Are you sure? you whant to confirm payroll',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm it!'
    }).then((result) => {
        if (result.isConfirmed) {

            $('#hideList').hide();

            $.ajax({
                url: "{{route('payroll.generate_checklist',['pdate'=>base64_encode($payroll_date)])}}",
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
    });

    // if (confirm("Are you sure? you whant to confirm payroll") == true) {
    //     // var id = id;
    //     $('#hideList').hide();
    //     $.ajax({
    //         url: "{{route('payroll.generate_checklist',['pdate'=>base64_encode($payroll_date)])}}",
    //         success: function(data) {
    //             if (data.status == 1) {
    //                 alert("Pay CheckList Generated Successiful!");

    //                 $('#resultConfirmation').fadeOut('fast', function() {
    //                     $('#resultConfirmation').fadeIn('fast').html(data.message);
    //                 });
    //                 setTimeout(function() { // wait for 2 secs(2)
    //                     location.reload(); // then reload the div to clear the success notification
    //                 }, 1500);
    //             } else {
    //                 alert(
    //                     "FAILED to Generate Pay Checklist, Try again, If the Error persists Contact Your System Admin."
    //                 );

    //                 $('#resultConfirmation').fadeOut('fast', function() {
    //                     $('#resultConfirmation').fadeIn('fast').html(data.message);
    //                 });
    //             }

    //         }

    //     });
    // }
}
</script>
@endpush
