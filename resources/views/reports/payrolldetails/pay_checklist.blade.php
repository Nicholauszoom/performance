<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pay Checklist</title>
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
                                    <img src="{{ public_path('assets/images/logo-dif2.png') }}" alt="logo here" width="180px"
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

                @php

                $payNo_col = "";
                $name_col = "";
                $bank_col="";
                $branchCode_col="d-none";
                $accountNumber_col = "";
                $pensionNumber_col = "d-none";
                $currency_col="";
                $department_col = "d-none";
                $costCenter_col = "d-none";
                $basicSalary_col = "d-none";
                $netBasic_col = "d-none";
                $overtime_col = "d-none";
                $allowanceCat_col="d-none";
                $otherPayments_col="d-none";
                $grossSalary_col = "d-none";
                $taxBenefit_col = "d-none";
                $taxableGross_col = "d-none";
                $paye_col = "d-none";
                $nssfEmployee_col = "d-none";
                $nssfEmployer_col = "d-none";
                $nssfPayable_col = "d-none";
                $sdl_col = "d-none";
                $wcf_col = "d-none";
                $loanBoard_col = "d-none";
                $advanceOthers_col = "d-none";
                $totalDeduction_col = "d-none";
                $amountPayable_col = "";
                $colspan_col = "2";
                $show_terminations=false;
                $fitler_by_currency=true;



                @endphp
                @include('reports.payrolldetails.payroll_checklist_calculation')

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
