<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pay Checklist</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">

</head>

<body>

    <main class="body-font p-1">
        <div id="logo" style="margin-left: 7px; z-index: -10">
            <img src="{{ asset('assets/images/x-left.png') }}" width="100px;" height="50px;">
        </div>

        <div style="margin-top:20px;">
            <div class="col-md-12">

                <table class="table" id="img">
                    <tfoot>
                        <tr>
                            <td class="">
                                <div class="box-text text-right" style="text-align:left;">
                                    <p class="p-space">
                                    <h5 style="font-weight:bolder;margin-top:15px;">HC-HUB
                                    </h5>
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
                                    <img src="{{ asset('assets/images/logo-dif2.png') }}" alt="logo here" width="180px"
                                        height="150px" class="image-fluid">
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <hr>

                <table class="table" style="background-color: #165384; color:white;font-size:12px;">
                    <thead>
                        <tr>
                            <td class="">
                                <div class="box-text">
                                    <h5 style="font-weight:bolder;text-align: left;"> Payment List </h5>
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
                <table class="table" id="reports" style="font-size:10px;">
                    <thead style="border-bottom:2px solid rgb(9, 5, 64);">
                        
                        <tr>
                            <th style="text-align: right;"><b>S/N</b></th>
                            <th style="text-align: center;"><b>Payroll No</b></th>
                            <th colspan="2"><b>Name</b></th>

                            <th style="text-align: center;"><b>Bank</b></th>

                            <th style="text-align: center;"><b>Account No</b></th>
                            <th><b>Currency</b></th>
                            <th style="text-align: right;"><b>Net Pay</b></th>
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
                                        if($row->currency == $currency){
                                        $i++;
                                        $amount = $row->salary + $row->allowances-$row->pension_employer-$row->loans-$row->deductions-$row->meals-$row->taxdue;
                                        $total_netpay = round($total_netpay,2) + round($amount/$row->rate,2);
                                        $amount=round($amount);
                                        $total_gross_salary += ($row->salary + $row->allowances);
                                        $total_salary = $total_salary + $row->salary;
                                        $total_allowance = $total_allowance + $row->allowances ;
                                        $total_overtime = $total_overtime +$row->overtime;
                                        $total_house_rent = $total_house_rent + $row->house_rent;
                                        $total_others = $total_others + $row->other_payments ;
                                        $total_taxs += round($row->taxdue,2);
        
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
                                        <td class="text-end">{{ $i }}</td>
                                        <td class="text-end">{{ $row->emp_id }}</td>
                                    
                                        <td class="" style="margin-right: 0px" colspan="2">{{ $row->fname }}  {{ $row->mname }} {{ $row->lname }}
                                        </td>
                                       
        
                                        <td class="text-end">{{ $row->bank_name }}</td>
        
                
        
                                        <td class="text-end">{{ $row->account_no }}</td>
        
        
                                        <td class="text-end">{{ $row->currency }}</td>
                  
                         
                                        <td class="text-end">{{ number_format($amount/$row->rate, 2) }}</td>
        
        
                                    </tr>
        
                                    <?php } } ?>
                    </tbody>
                                    <tfoot>
                                    <tr style="font-size:10px; !important; border:3px solid rgb(9, 5, 64)">
        
                                        {{-- <td></td>
                                        <td></td>
                                        <td></td> --}}
                                        <td colspan="7">
                                                <b>
                                                    <b>TOTAL<b>
                                                    </b></td>
                                       
                                        <td colspan="2" class="text-end"><b><b>{{ number_format($total_netpay, 2) }}</b></b></td>
        
                                    </tr>
                                </tfoot>
        
                                    <?php  } ?>
                </table>
                

                <table class="table" id="reports" style="font-size:10px; height:20px;">
                    <tbody>
                        <tr>
                            <td>
                                <p class="text-start" style="font-size:12px !important;">
                                    <small><b>Approved By:</b></small>
                                </p>
                            </td>
                            <td>
                                <p class="text-start" style="font-size:14px !important;">
                                    <small><b>Approved By:</b></small>
                                </p>
                            </td>

                        </tr>

                        <tr>


                            <td>
                                <p class="text-start"><small>Name_______________________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Name_______________________________</small></p>
                            </td>

                        </tr>
                        <tr>


                            <td>
                                <p class="text-start"><small>Position_____________________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Position_____________________________</small></p>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <p class="text-start"><small>Signature____________________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Signature____________________________</small></p>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <p class="text-start"><small>Date________________________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Date________________________________</small></p>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

<br><br>

        <div id="logo2" style="margin-left: 7px; z-index: -10">
            <img src="{{ asset('assets/images/x-right.png') }}" width="100px;" height="50px;">
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


    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

</body>

</html>
