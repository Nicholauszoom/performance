<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Reconciliation-Summary</title>
    <link rel="stylesheet" href="{{ public_path('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ public_path('assets/css/report.css') }}">






</head>


<body>


    @php
    $brandSetting = \App\Models\BrandSetting::firstOrCreate();
@endphp

    <main class="body-font p-1">
        <div id="logo" style="margin-left: 7px; z-index: -10">
            <img src="{{ public_path('assets/images/x-left.png') }}" width="100px;" height="50px;">
        </div>


        <div style="margin-top:20px;">
            <div class="col-md-12" >
                <table class="table" id="img">
                    <tfoot>
                        <tr>
                            <td class="">
                                <div class="box-text text-right" style="text-align:left;">
                                    <p class="p-space">
                                    <h5 style="font-weight:bolder;margin-top:15px;">
                                        @if ($brandSetting->report_system_name)
                                            {{$brandSetting->report_system_name }}
                                        @else
                                            HC-HUB
                                        @endif

                                    </h5>
                                    </p>
                                    <p class="p-space">
                                        @if ($brandSetting->address_1)
                                            {{ $brandSetting->address_1 }}
                                        @else
                                            5th & 6th Floor, Uhuru Heights
                                        @endif

                                    </p>
                                    <p class="p-space">
                                        @if ($brandSetting->address_2)
                                            {{ $brandSetting->address_2}}
                                        @else
                                            Bibi Titi Mohammed Road
                                        @endif
                                    </p>
                                    <p class="p-space">
                                        @if ($brandSetting->address_3)
                                            {{ $brandSetting->address_3 }}
                                        @else
                                            P.O. Box 31, Dar es salaam
                                        @endif


                                    </p>
                                    <p class="p-space">
                                        @if ($brandSetting->address_4)
                                            {{ $brandSetting->address_4 }}
                                        @else
                                            +255 22 22119422/2111990
                                        @endif
                                    </p>
                                    <p class="p-space"> web:<a href="www.bancabc.co.tz">
                                            @if ($brandSetting->website_url)
                                                {{ $brandSetting->website_url }}
                                            @else
                                                www.bancabc.co.tz
                                            @endif

                                        </a></p>
                                </div>
                            </td>
                            <td> </td>
                            <td>
                                <div class="box-text"> </div>
                            </td>

                            <td colspan="4" class="w-50" style="">
                                <div class="box-text text-end">
                                    @if ($brandSetting->report_logo)
                                    <img src="{{ asset('storage/' . $brandSetting->report_logo) }}" alt="logo here" width="180px" height="150px" class="image-fluid">          
                                    @else
                                    <img src="{{ public_path('assets/images/logo-dif2.png') }}" alt="logo here" width="180px" height="150px" class="image-fluid">          
                                    @endif                                </div>
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
                                    <h5 style="font-weight:bolder;text-align: left;"> Payroll Reconciliation Summary </h5>
                                </div>
                            </td>
                            <td> <div class="box-text text-end"></div> </td>
                            <td> <div class="box-text"> </div> </td>
                            <td colspan="4" class="w-50" style="">
                                <P class="mt-1" style="text-align: right; "> For the month of {{ date('M-Y', strtotime($payroll_date)) }}</p>
                            </td>
                        </tr>
                    </thead>
                </table>

                <hr>

                @php
                    $total_previous = 0;
                    $total_current = 0;
                    $total_amount = 0;
                @endphp

                <table class="table" id="reports" style="font-size:12px;  ">
                    <thead>
                        <tr>
                            <th><b>Reference No.</b></th>
                            <th><b>Description</b></th>
                            <th style=""><b>Last Month</b></th>
                            <th><b>This Month</b></th>
                            <th><b>Amount</b></th>
                            <th><b>Count</b></th>
                        </tr>
                    </thead>

                    @include("reports.reconciliationSummary.payroll_reconciliation_summary_calculations")

                </table>

                <hr>
                <table class="table" id="reports">
                    <tbody>
                        <tr>
                            <td>
                                <span class="text-start" style="font-size:15px;">
                                    <small><b>Prepared By:</b></small>
                                </span>
                            </td>
                            <td>
                                <span class="text-start" style="font-size:15px;"><small><b>1st Checker & Approved By:</b></small></span>
                            </td>
                            <td>
                                <span class="text-start" style="font-size:15px;"><small><b>2nd Checker & Approved By:</b></small></span>
                            </td>
                            <td><span class="text-start" style="font-size:15px;"><small><b>Approved By:</b></small></span></td>
                        </tr>
                        <tr>

                            <td>
                                <span class="text-start"><small>Name:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Name:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Name:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Name:_______________</small></span>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <span class="text-start"><small>Position:_____________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Position:_____________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Position:_____________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Position:_____________</small></span>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <span class="text-start"><small>Signature:___________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Signature:___________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Signature:___________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Signature:___________</small></span>

                        </tr>

                        <tr>

                            <td>
                                <span class="text-start"><small>Date:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Date:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Date:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Date:_______________</small></span>
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
                        <div class="box-text"> {{ date('l jS \of F Y') }} </div>
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
