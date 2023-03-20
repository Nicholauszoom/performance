<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Details </title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
</head>

<body>

    <main class="mb-5">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tfoot>

                        <tr>
                            <td class="">
                                <div class="box-text">
                                    <img src="{{ asset('assets/images/logo-dif2.png') }}" alt="logo here"
                                        class="image-fluid"> <br>

                                </div>
                            </td>
                            <td>
                                <div class="box-text text-center">
                                    <p style="font-weight:700" class="">
                                        AFRICAN BANKING CORPORATION<br>
                                        P.O. BOX 31 ,DAR ES SALAAM

                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="box-text"> </div>
                            </td>

                            <td colspan="4" class="w-50" style="">
                                <div class="" style="text-align: right; padding-right:20px">

                                    <h5 class="text-end font-weight-bolder" style="font-weight:bolder;">Payroll
                                        Detail_By Number</h5>
                                    <p class="text-end font-weight-bolder text-primary" style="font-weight:bolder;">
                                        Date:
                                        {{ $payroll_date }}

                                </div>
                            </td>
                        </tr>

                    </tfoot>
                </table>

<hr style="border: 10px solid rgb(211, 140, 10); border-radius: 2px;">

                        <table class="table" style="font-size:9px; ">
                            <thead style="font-size:8px;">
                                <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                                    <th ><b>Pay No</b></th>
                                    <td></td>
                                    <th  colspan="2" style="margin-bottom: 30px;" class="text-center"><b>Name</b><br>
                                    </th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Basic Salary</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Overtime</b></th>

                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Respons. Allowance</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>House Allowance</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Areas</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Other Payment</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Gross Salary</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Tax Benefit</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Taxable Gross</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>PAYE</b></th>


                                    <th  class="text-end" style="margin-bottom: 30px;"><b>NSSF</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Loan Board</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Advance/Others</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Total Deduction</b></th>
                                    <th  class="text-end" style="margin-bottom: 30px;"><b>Ammount Payable</b></th>

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
                                    $total_taxs += $row->taxdue;

                                    $total_pension = $total_pension + $row->pension_employer;
                                    $total_deduction += ($row->salary + $row->allowances)-$amount;
                                    $total_sdl = $total_sdl + $row->sdl;
                                    $total_wcf = $total_wcf + $row->wcf;
                                    $total_taxable_amount += intval($row->salary + $row->allowances-$row->pension_employer);
                                    $total_loans = $total_loans + $row->total_loans;
                                    $total_teller_allowance += $row->teller_allowance;

                                    $others += $row->deductions;


                                ?>

                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

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
                                @if($row2->taxable != 0)
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
                                    @endif
                                @endforeach
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

                                <?php } ?>
                            </tbody>

                        </table>

            </div>
        </div>


        <table class="table">
            <tfoot>

                <tr>
                    <td class="">
                        <p class="text-start"><small><b>Prepared By</b></small></p>
                        <div class="row mt-3">
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date:________________</div>
                        </div>
                    </td>
                    <td>
                        <p><small><b>Checked and Approved By</b></small></p>

                        <div class="row mt-3">
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date:________________</div>
                        </div>
                    </td>
                    <td>
                        <b>Checked and Approved By</b>

                        <div class="row mt-3">
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date________________</div>
                        </div>
                    </td>

                    <td colspan="4" class="w-50" style="">
                        <p><small><b>Approved By</b></small></p>

                        <div class="row mt-3">
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date________________</div>
                        </div>
                    </td>
                </tr>

            </tfoot>
        </table>


    </main>







    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

</body>

</html>
