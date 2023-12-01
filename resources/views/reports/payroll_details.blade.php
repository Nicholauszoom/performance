<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Details </title>
    <link rel="stylesheet" href="{{ public_path('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ public_path('assets/css/report.css') }}">
</head>

<body>

    <main class="body-font p-1">
        <div id="logo" style="margin-left: 7px; z-index: -10">
            <img src="{{ public_path('assets/images/x-left.png') }}" width="100px;" height="50px;">
        </div>

        <div style="margin-top:20px;">
            <div class="col-md-12">

                <table class="table" id="img">
                    <tfoot>
                        <tr>
                            <td class="">
                                <div class="box-text text-right" style="text-align:left;">
                                    <p class="p-space">
                                    <h5 style="font-weight:bolder;margin-top:15px;">HC-HUB</h5>
                                    </p>
                                    <p class="p-space">5th & 6th Floor, Uhuru Heights</p>
                                    <p class="p-space">Bibi Titi Mohammed Road</p>
                                    <p class="p-space">P.O. Box 31, Dar es salaam </p>

                                    <p class="p-space">+255 22 22119422/2111990 </p>
                                    <p class="p-space"> web:<a href="www.bancabc.co.tz">www.bancabc.co.tz</a></p>

                                </div>
                            </td>
                            <td> </td>
                            <td>
                                <div class="box-text"> </div>
                            </td>

                            <td colspan="4" class="w-50" style="">
                                <div class="box-text text-end">
                                    <img src="{{ public_path('assets/images/logo-dif2.png') }}" alt="logo here" width="180px"
                                        height="150px" class="image-fluid">
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <hr>

                <table class="table" style="background-color: #165384; color:white">
                    <thead>
                        <tr>
                            <td class="">
                                <div class="box-text">
                                    <h5 style="font-weight:bolder;text-align: left;"> Payroll Details </h5>
                                </div>
                            </td>
                            <td>
                                <div class="box-text text-end"></div>
                            </td>
                            <td>
                                <div class="box-text"> </div>
                            </td>
                            <td colspan="4" class="w-50" style="">
                                <P class="mt-1" style="text-align: right; "> For the month of
                                    {{ date('M-Y', strtotime($payroll_date)) }}</p>
                            </td>
                        </tr>
                    </thead>
                </table>

                <hr>

                <table class="table" id="reports" style="font-size:5px; ">
                    <thead style="font-size:8px;">
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Pay No</b></th>
                            <th colspan="2" style="margin-bottom: 30px;" class="text-center"><b>Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Basic Salary</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Overtime</b></th>
                            @foreach($allowance_categories as $row)
                                    <th class="text-end" style="margin-bottom: 30px;"><b>{{ $row->name}}</b></th>
                                    @endforeach
                            
                            <th class="text-end" style="margin-bottom: 30px;"><b>Other Payment</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Gross Salary</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Tax Benefit</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Taxable Gross</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>PAYE</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>NSSF</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Loan Board</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Advance/Others</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Total Deduction</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Amount Payable</b></th>

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
                                    //$total_gross_salary = 0;
                                    $total_taxs = 0;
                                    $total_salary = 0; $total_netpay = 0; $total_arrears = 0; $total_allowance = 0; $total_overtime = 0; $total_house_rent = 0; $total_sdl = 0; $total_wcf = 0;
                                    $total_tax = 0; $total_pension = 0; $total_others = 0; $total_deduction = 0; $total_gross_salary = 0; $taxable_amount = 0;
                                foreach ($summary as $row){
                                    $i++;
                                    $amount = $row->salary + $row->allowances-$row->pension_employer-$row->loans-$row->deductions-$row->meals-$row->taxdue;
                                    $total_netpay = round($total_netpay,2)+ round($amount,2);

                                    $total_gross_salary += round(($row->salary + $row->allowances),2);
                                    $total_salary = round($total_salary + $row->salary,2);
                                    $total_allowance = round($total_allowance + $row->allowances,2) ;
                                    $total_arrears = round($total_arrears + $row->arrears_allowance,2);
                                    $total_overtime = round($total_overtime +$row->overtime,2);
                                    // $total_house_rent = round($total_house_rent + $row->house_rent,2);
                                    $total_others = round($total_others + $row->other_payments,2) ;
                                    $total_taxs += round($row->taxdue,2);

                                    $categories_total = [];


                                    foreach($allowance_categories as $category){

                                        $categories_total["category".$category->id]=0;

                                    }

                                    $total_pension = round($total_pension + $row->pension_employer,2);
                                    $total_deduction += round(($row->salary + $row->allowances)-$amount,2);
                                    $total_sdl = round($total_sdl + $row->sdl,2);
                                    $total_wcf = round($total_wcf + $row->wcf,2);
                                    $total_taxable_amount += round($row->salary + $row->allowances-$row->pension_employer,2);
                                    $total_loans = round($total_loans + $row->total_loans,2);
                                    // $total_teller_allowance += round($row->teller_allowance,2);

                                    $others += round($row->deductions,2);


                                ?>

                        <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                            <td class="text-end">{{ $row->emp_id }}</td>

                            <td class="" style="margin-right: 0px" colspan="">{{ $row->fname }} @if ($row->fname == '' || $row->fname == '')
                                    {{ substr($row->lname, 0, 3) }}
                                @else
                                @endif
                            </td>
                            <td class="" style="margin-left: 0px;" colspan="">{{ $row->lname }} @if ($row->fname == '' || $row->fname == '')
                                    {{ substr($row->lname, 0, 3) }}
                                @else
                                @endif
                            </td>

                            <td class="text-end">{{ number_format($row->salary, 2) }}</td>

                            <td class="text-end">{{ number_format($row->overtime, 2) }}</td>

                            @foreach($allowance_categories as $category)

                            @php

                            $category_id="category".$category->id;

                            $categories_total["category".$category->id]+= round($row->$category_id,2);


                            @endphp

                            <td class="text-end">{{ number_format($row->$category_id, 2) }}</td>

                            @endforeach
                           

                            <td class="text-end">{{ number_format($row->salary + $row->allowances, 2) }}
                            </td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            <td class="text-end">
                                {{ number_format($row->salary + $row->allowances - $row->pension_employer, 2) }}
                            </td>
                            <td class="text-end">{{ number_format($row->taxdue, 2) }}</td>

                            <td class="text-end">{{ number_format($row->pension_employer, 2) }}</td>
                            <td class="text-end">{{ number_format($row->loans, 2) }}</td>

                            <td class="text-end">{{ number_format($row->deductions, 2) }}</td>

                            <td class="text-end">
                                {{ number_format($row->salary + $row->allowances - $amount, 2) }}
                            </td>
                            <td class="text-end">{{ number_format($amount, 2) }}</td>


                        </tr>

                        <?php } ?>
                        @foreach ($termination as $row2)
                            @if ($row2->taxable != 0)
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="">{{ $row2->emp_id }}</td>


                                    <td class="" style="margin-right: 0px" colspan="">{{ $row2->fname }}
                                    </td>
                                    <td class="" style="margin-left: 0px;" colspan="">{{ $row2->lname }}
                                    </td>


                                    <td class="text-end">{{ number_format($row2->salaryEnrollment, 2) }}
                                    </td>

                                    <td class="text-end">{{ number_format(($row2->normal_days_overtime_amount + $row2->public_overtime_amount), 2) }}</td>



                                    <td class="text-end">{{ number_format($row2->tellerAllowance, 2) }}</td>
                                    <td class="text-end">{{ number_format($row2->houseAllowance, 2) }}</td>

                                    <td class="text-end">{{ number_format(0, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row2->leavePay + $row2->leaveAllowance+$row2->transport_allowance+$row2->nightshift_allowance, 2) }}
                                    </td>
                                    @php $gros = $row2->salaryEnrollment + $row2->leaveAllowance + $row2->leavePay+$row2->normal_days_overtime_amount+$row2->public_overtime_amount;  @endphp
                                    <td class="text-end">
                                        {{ number_format($row2->total_gross, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format($row2->arrears, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($row2->taxable, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format($row2->paye, 2) }}</td>

                                    <td class="text-end">{{ number_format($row2->pension_employee, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format(0, 2) }}</td>
                                    <td class="text-end">{{ number_format($row2->loan_balance+$row2->otherDeductions, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($row2->pension_employee + $row2->paye + $row2->otherDeductions, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format(0, 2) }}</td>


                                </tr>
                                @php
                                    $others += round($row2->loan_balance,2);
                                    $total_arrears +=round($row2->arrears,2);
                                    $total_overtime +=round(($row2->normal_days_overtime_amount+$row2->public_overtime_amount),2);

                                    $total_salary += round($row2->salaryEnrollment,2);
                                    $total_others += round($row2->leavePay + $row2->leaveAllowance+$row2->transport_allowance+$row2->nightshift_allowance,2);
                                    $total_taxable_amount += round($row2->taxable,2);
                                    $total_taxs += round($row2->paye,2);
                                    //$total_netpay += ($row2->taxable -$row2->paye);
                                    $total_deduction +=round( $row2->pension_employee + $row2->paye + $row2->otherDeductions,2);
                                    $total_pension += round($row2->pension_employee,2);
                                    $total_gross_salary += round($row2->total_gross,2);

                                    // $total_gross_salary += ($row2->salaryEnrollment + $row2->leaveAllowance + $row2->leavePay);

                                @endphp
                            @endif
                        @endforeach
                        <tr style="font-size:10px; !important; border:3px solid rgb(9, 5, 64)">

                            {{-- <td></td>
                                    <td></td>
                                    <td></td> --}}
                            <td colspan="3">
                                <b>
                                    <center><b>TOTAL<b></center>
                                </b>
                            </td>
                            <td class="text-end"><b><b>{{ number_format($total_salary, 2) }}</b></b></td>
                            <td class="text-end"><b><b>{{ number_format($total_overtime, 2) }}</b></b></td>
                           
                            <td class="text-end"><b><b>{{ number_format($total_others, 2) }}</b></b></td>

                            <td class="text-end">
                                <b><b>{{ number_format($total_gross_salary, 2) }}</b></b>
                            </td>

                            <td class="text-end"><b><b> {{ number_format(0, 2) }}</b></b></td>
                            <td class="text-end">

                                <b><b>{{ number_format($total_gross_salary- $total_pension, 2) }}</b></b>

                                {{-- <b><b>{{ number_format($total_salary + $total_overtime + $total_teller_allowance + $total_house_rent + $total_others - $total_pension, 2) }}</b></b> --}}
                            </td>

                            <td class="text-end"><b><b>{{ number_format($total_taxs, 2) }}</b></b></td>

                            <td class="text-end"><b><b>{{ number_format($total_pension, 1) }}</b></b></td>
                            <td class="text-end"><b><b>{{ number_format($total_loans, 2) }}</b></b></td>
                            <td class="text-end"><b><b>{{ number_format($others, 2) }}</b></b></td>
                            <td class="text-end"><b><b>{{ number_format($total_deduction, 2) }}</b></b></td>
                            <td class="text-end"><b><b>{{ number_format($total_netpay, 2) }}</b></b></td>

                        </tr>

                        <?php } ?>
                    </tbody>

                </table>

                <table class="table" id="reports">
                    <tbody>
                        <tr>
                            <td>
                                <p class="text-start" style="font-size:15px;">
                                    <small><b>Prepared By:</b></small>
                                </p>
                            </td>
                            <td>
                                <p class="text-start" style="font-size:15px;"><small><b>1st Checker & Approved
                                            By:</b></small></p>
                            </td>
                            <td>
                                <p class="text-start" style="font-size:15px;"><small><b>2nd Checker & Approved
                                            By:</b></small></p>
                            </td>
                            <td>
                                <p class="text-start" style="font-size:15px;"><small><b>Approved By:</b></small></p>
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <p class="text-start"><small>Name:________________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Name:________________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Name:________________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Name:________________________</small></p>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <p class="text-start"><small>Position:_______________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Position:_______________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Position:_______________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Position:_______________________</small></p>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <p class="text-start"><small>Signature:______________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Signature:______________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Signature:______________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Signature:______________________</small></p>

                        </tr>

                        <tr>

                            <td>
                                <p class="text-start"><small>Date:__________________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Date:__________________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Date:__________________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Date:__________________________</small></p>
                            </td>

                        </tr>
                    </tbody>
                </table>

            </div>
        </div>




        <div id="logo2" style="margin-left: 7px; z-index: -10">
            <img src="{{ public_path('assets/images/x-right.png') }}" width="100px;" height="50px;">
        </div>
    </main>
    <div class="footer">
        <table class="table footer-font">
            <tfoot>
                <tr>
                    <td class="">
                        <div class="box-text"> {{ date('l, F j, Y') }} </div>
                    </td>
                    <td>
                        <div class="box-text text-end"> </div>
                    </td>
                    <td>
                        <div class="box-text"> </div>
                    </td>
                    <td colspan="4" class="w-50" style="">
                        <i> Page <span class="pagenum">.</span></i>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>






    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ public_path('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>

</body>

</html>
