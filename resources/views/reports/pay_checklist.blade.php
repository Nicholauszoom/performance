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
                        <tr>
                            <th style="text-align: right;"><b>S/N</b></th>
                            <th style="text-align: center;"><b>Payroll No</b></th>
                            <th><b>Name</b></th>

                            <th style="text-align: center;"><b>Bank</b></th>

                            <th style="text-align: center;"><b>BranchCode</b></th>
                            <th style="text-align: center;"><b>Account No</b></th>
                            <th><b>Currency</b></th>
                            <th style="text-align: right;"><b>Net Pay</b></th>
                        </tr>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno =0;
                        $total = 0;
                        foreach($employee_list as $row){

                            if($row->currency == $currency){
                                    $sno++;
                                    $empID =  $row->empID;
                                    $name = $row->name;
                                    $bank = $row->bank;
                                    $branch = $row->branch;
                                    $swiftcode = $row->swiftcode;
                                    $less_takehome = $row->less_takehome;
                                    $account_no = $row->account_no;
                                    if($less_takehome==0){
                                    $amount = $row->salary + $row->allowances-($row->pension-$row->deductions-$row->taxdue); }
                                     else {
                                     $amount = $less_takehome;
                                     }
                                     $total += $amount;
                                    if  ($sno % 2 == 0) { $background = "#d3d3d3;"; } else { $background = "#FFFFFF;"; }
                                    ?>
                        <tr nobr="true" style="border-bottom:2px solid rgb(67, 67, 73)">
                            <td  style="text-align: right;">{{ $sno }}</td>
                            <td style="text-align: center;">&nbsp;{{ $empID }}</td>
                            <td>&nbsp;{{ $name }}</td>

                            <td style="text-align: center;">&nbsp;{{ $bank }}</td>

                            <td style="text-align: center;">&nbsp;{{ $swiftcode }}</td>
                            <td style="text-align: center;">&nbsp;{{ $account_no }}</td>
                            <td style="text-align: center;">&nbsp;{{ $row->currency }}</td>
                            <td  style="text-align: right;">&nbsp;{{ number_format($amount / $row->rate, 2) }}</td>
                        </tr>
                        <?php }} ?>
                        <tr nobr="true" style="border-bottom:2px solid rgb(67, 67, 73)">
                            <td  style="text-align: right;" colspan="6">TOTAL</td>
                            <td  style="text-align: right;" colspan="2">&nbsp;{{ number_format($total / $row->rate, 2) }}</td>
                        </tr>
                    </tbody>
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
