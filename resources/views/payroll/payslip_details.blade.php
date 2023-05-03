@extends('layouts.vertical', ['title' => 'Pending Payments'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <!-- notification Js -->



    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush


@section('content')

<?php

foreach ($slipinfo as $row) {
    $rate = $row->rate;
    $id = $row->empID;
    $old_id = $row->oldID;
    if ($row->oldID == 0) {
        $employeeID = $row->empID;
    } else {
        $employeeID = $row->oldID;
    }
    $hiredate = $row->hire_date;
    $name = $row->name;
    $position = $row->position_name;
    $department = $row->department_name;
    $branch = $row->branch_name;
    $salary = $row->salary / $row->rate;
    $pension_fund = $row->pension_fund_name;
    $pension_fund_abbrv = $row->pension_fund_abbrv;
    $membership_no = $row->membership_no;
    $bank = $row->bank_name;
    $account_no = $row->account_no;
    $hiredate = $row->hire_date;
    $payroll_month = $row->payroll_date;
    $pension_employee = $row->pension_employee / $row->rate;
    $meals = $row->meals / $row->rate;
    $taxdue = $row->taxdue / $row->rate;
}

foreach ($companyinfo as $row) {
    $companyname = $row->cname;
}

foreach ($total_pensions as $row) {
    $uptodate_pension_employee = $row->total_pension_employee / $row->rate;
    $uptodate_pension_employer = $row->total_pension_employer / $row->rate;
}

$sum_allowances = $total_allowances / $rate;
$sum_deductions = $total_deductions / $rate;
$sum_loans = 0;

// DATE MANIPULATION
$hire = date_create($hiredate);
$today = date_create($payroll_month);
$diff = date_diff($hire, $today);
$accrued = (37 * $diff->format('%a%')) / 365;
$totalAccrued = number_format((float) $accrued, 2, '.', ''); //3,04days

$balance = $totalAccrued - $annualLeaveSpent; //days
if ($balance < 0) {
    $balance = 0;
}

foreach ($loans as $row) {
    $paid = $row->paid;
    if ($row->remained == 0) {
        $get_remainder = $row->paid / $row->policy;
        $array = explode('.', $get_remainder);
        if (isset($array[1])) {
            $num = '0' . '.' . $array[1];
        } else {
            $num = '0';
        }
        //        $paid = $num*$row->policy;
        $paid = $salary_advance_loan_remained;
    }
    $sum_loans = $sum_loans + $paid;
}

// START TAKE HOME
$amount_takehome = $sum_allowances + $salary - ($sum_loans + $pension_employee + $taxdue + $sum_deductions + $meals);

$paid_salary = $amount_takehome;
foreach ($paid_with_arrears as $paid_with_arrear) {
    if ($paid_with_arrear->with_arrears) {
        $with_arr = $paid_with_arrear->with_arrears; //with held
        $paid_salary = $amount_takehome - $with_arr; //paid amount
    } else {
        $with_arr = 0; //with held
    }
}

foreach ($arrears_paid as $arrear_paid) {
    if ($arrear_paid->arrears_paid) {
        $paid_salary = $amount_takehome + $arrear_paid->arrears_paid - $with_arr;
        $paid_arr = $arrear_paid->arrears_paid;
    } else {
        $paid_arr = 0;
    }
}

foreach ($paid_with_arrears_d as $paid_with_arrear_d) {
    if ($paid_with_arrear_d->arrears_paid) {
        $paid_arr_all = $paid_with_arrear_d->arrears_paid;
    } else {
        $paid_arr_all = 0;
    }
}

if ($with_arr > 0) {
    foreach ($arrears_all as $arrear_all) {
        if ($arrear_all->arrears_all) {
            $due_arr = $arrear_all->arrears_all - $paid_arr_all;
        } else {
            $due_arr = 0;
        }
    }
} else {
    foreach ($arrears_all as $arrear_all) {
        if ($arrear_all->arrears_all) {
            $due_arr = $arrear_all->arrears_all - $paid_arr_all;
        } else {
            $due_arr = 0;
        }
    }
}

$sum_allowances = $total_allowances / $rate;
$sum_deductions = $total_deductions / $rate;

?>




    <div class="card border-top  border-top-width-3 border-top-main rounded-0 px-0 pt-0 pb-5">
        <div class="card-header border-0">
            <h5 class="text-main">Payslip<small></small></h5>
        </div>

        <div class="card rounded-0" style="background: #fff !important;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Payslip For the month : {{ date('M-Y', strtotime($payroll_date)) }}</h5>

                <p> <img src="{{ asset('img/logo.png') }}" class="img-fluid" alt="" width="100px" height="100px"></p>
            </div>

            <div class="card-body bg-light p-2">
                <div class="row row-cols-sm-3">

                    <div class="col-sm">
                        <div class="card h-sm-100 mb-sm-0">

                            <h3 style="background: url({{ asset('img/yellow.png') }}) no-repeat 0 0; color: #fff; height: 46px; line-height: 45px; margin: 0; text-transform:uppercase; padding: 0 0 0 20px; font-size: 14px;">Employee Details</h3>


                            <ul class="list-group list-group-flush ">
                                <li class="list-group-item d-flex">
                                <span class="fw-semibold">Full Name</span>
                                <div class="ms-auto">{{ $name }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Department</span>
                                    <div class="ms-auto">{{ $department }}</div>
                                    </li>
                                <li class="list-group-item d-flex">
                                <span class="fw-semibold">Position</span>
                                <div class="ms-auto">{{ $position }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                <span class="fw-semibold">Branch</span>
                                <div class="ms-auto"> {{ $branch }} </div>
                                </li>
                                <li class="list-group-item d-flex">
                                <span class="fw-semibold">Payroll Number</span>
                                <div class="ms-auto"> {{ $employeeID }} </div>
                                </li>

                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Annual leave remaining</span>
                                    <div class="ms-auto"> {{ number_format($leaveBalance,2) }} </div>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <div class="col-sm">

                        <div class="card h-sm-100 mb-sm-0 rounded-0">

                            <h3 style="background: url({{ asset('img/blue.png') }}) no-repeat 0 0; color: #fff; height: 46px; line-height: 45px; margin: 0; text-transform:uppercase; padding: 0 0 0 20px; font-size: 14px;"> Earnings</h3>


                            <ul class="list-group list-group-flush ">
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Basic Pay</span>
                                    <div class="ms-auto">{{ number_format($salary, 2) }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Net Basic</span>
                                    <div class="ms-auto">{{ number_format($salary, 2) }}</div>
                                </li>
                                <?php foreach($allowances as $row){
                                    ?>

                                      <li class="list-group-item d-flex">
                                        @if($row->description == "N-Overtime")
                                        <span class="fw-semibold">Normal Days Overtime</span>
                                        @elseif($row->description == "S-Overtime")
                                        <span class="fw-semibold">Sunday Overtime</span>
                                        @else
                                        <span class="fw-semibold">{{ $row->description }}</span>
                                        @endif
                                        <div class="ms-auto">{{ number_format($row->amount / $rate, 2) }}</div>
                                    </li>

                                <?php } ?>
                            </ul>

                            <div class="card-footer d-flex justify-content-between border-top" >
                                <span class="text-muted">Total</span>
                                <span class="hstack gap-1">
                                <span class="text-muted ms-1">{{ number_format($sum_allowances + $salary, 2) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>




                    <div class="col-sm">
                        <div class="card  h-sm-100 mb-sm-0">
                            <h3 style="background: url({{ asset('img/green.png') }}) no-repeat 0 0; color: #fff; height: 46px; line-height: 45px; margin: 0; text-transform:uppercase; padding: 0 0 0 20px; font-size: 14px;"> Deductions</h3>

                            <ul class="list-group list-group-flush ">
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Net Tax</span>
                                    <div class="ms-auto">{{ number_format($taxdue, 2) }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">NSSF</span>
                                    <div class="ms-auto">{{ number_format($pension_employee, 2) }}</div>
                                </li>
                                @foreach ($deductions as $row)
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">{{ $row->description }}</span>
                                    <div class="ms-auto">{{ number_format($row->paid / $rate, 2) }}</div>
                                </li>
                            @endforeach
                            @foreach ($loans as $row)
                            <li class="list-group-item d-flex">
                                <span class="fw-semibold">{{ $row->description }}</span>
                                <div class="ms-auto">{{ number_format($row->paid / $rate, 2) }}</div>
                            </li>
                        @endforeach
                            </ul>
                            <div class="card-footer d-flex justify-content-between border-top" >
                                <span class="text-muted">Total Deduction</span>
                                <span class="hstack gap-1">
                                <span class="text-muted ms-1">{{ number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-2">
                <div class="row row-cols-sm-3">





                    <div class="col-sm">
                        <div class="card h-sm-100 mb-sm-0">
                            <h6 style="background: url({{ asset('img/yellow.png') }}) no-repeat 0 0; color: #fff; height: 46px; line-height: 45px; margin: 0; text-transform:uppercase; padding: 0 0 0 20px; font-size: 14px;">Taxation</h6>

                            <ul class="list-group list-group-flush ">
                                <li class="list-group-item d-flex">
                                <span class="fw-semibold">Gross pay</span>
                                <div class="ms-auto">{{ number_format($sum_allowances + $salary, 2) }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                <span class="fw-semibold">Less: Tax free Pension</span>
                                <div class="ms-auto">{{ number_format($pension_employee, 2) }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                <span class="fw-semibold">Taxable Gross</span>
                                <div class="ms-auto"> {{ number_format($sum_allowances + $salary - $pension_employee, 2) }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                <span class="fw-semibold">PAYE</span>
                                <div class="ms-auto"> {{ number_format($taxdue, 2) }} </div>
                                </li>

                            </ul>

                        </div>
                    </div>

                    <div class="col-sm">

                        <div class="card  h-sm-100 mb-sm-0">

                            <h6 style="background: url({{ asset('img/blue.png') }}) no-repeat 0 0; color: #fff; height: 46px; line-height: 45px; margin: 0; text-transform:uppercase; padding: 0 0 0 20px; font-size: 14px;">Summary</h6>




                            @if ($total_bank_loan > 0)
                                <tr class="headers text-center">
                                    <td colspan="2"> Bank Loans</td>
                                </tr>
                                @foreach ($bank_loan as $row)
                                    <tr class="table-body">
                                        <td>{{ $row->product }}</td>
                                        <td class="contents">{{ number_format($row->amount / $rate, 2) }}</td>
                                    </tr>
                                @endforeach

                                <tr class="table-body">
                                    <td>Total</td>
                                    <td class="contents"><?php echo number_format($total_bank_loan, 2); ?></td>
                                </tr>
                            @endif


                            <ul class="list-group list-group-flush ">
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Total Income</span>
                                    <div class="ms-auto">{{ number_format($sum_allowances + $salary, 2) }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Total Deduction</span>
                                    <div class="ms-auto">{{ number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2) }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Net pay</span>
                                    <div class="ms-auto">{{ number_format($amount_takehome, 2) }}</div>
                                </li>
                                @if ($total_bank_loan > 0)
                                <tr class="headers text-center">
                                    <td colspan="2"> Bank Loans</td>
                                </tr>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Bank Loans</span>
                                    <div class="ms-auto">.</div>
                                </li>
                                @foreach ($bank_loan as $row)
                                      <li class="list-group-item d-flex">
                                    <span class="fw-semibold">{{ $row->product }}</span>
                                    <div class="ms-auto">{{ number_format($row->amount / $rate, 2) }}</div>
                                </li>
                                @endforeach
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Total Bank Loan</span>
                                    <div class="ms-auto">{{ number_format($total_bank_loan/$rate, 2) }}</div>
                                </li>

                            @endif

                            </ul>

                            {{-- <div class="card-footer d-flex justify-content-between border-top" >
                                <span class="text-muted">Total Deduction</span>
                                <span class="hstack gap-1">
                                <span class="text-muted ms-1">ff</span>
                                </span>
                            </div> --}}
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="card  h-sm-100 mb-sm-0">

                            <h6 style="background: url({{ asset('img/green.png') }}) no-repeat 0 0; color: #fff; height: 46px; line-height: 45px; margin: 0; text-transform:uppercase; padding: 0 0 0 20px; font-size: 14px;">Take Home</h6>






                            <ul class="list-group list-group-flush ">
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Take home</span>
                                    <div class="ms-auto">{{ number_format($amount_takehome, 2) }}</div>
                                </li>
                                @if ($total_bank_loan > 0)
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Take Home After Loan Deductions</span>
                                    <div class="ms-auto">{{ number_format($amount_takehome - $total_bank_loan, 2) }}</div>
                                </li>

                            @endif
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">NSSF Number:</span>
                                    <div class="ms-auto">{{ $membership_no }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Method of Payment:</span>
                                    <div class="ms-auto">Bank</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Account No:</span>
                                    <div class="ms-auto">{{ $account_no }}</div>
                                </li>

                            </ul>

                            {{-- <div class="card-footer d-flex justify-content-between border-top" >
                                <span class="text-muted">Total</span>
                                <span class="hstack gap-1">
                                <span class="text-muted ms-1">$346.15</span>
                                </span>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>




@endsection

@push('footer-script')





@endpush
