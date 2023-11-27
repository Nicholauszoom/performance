<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Journal Entry Report</title>
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
                                    <img src="{{ asset('assets/images/logo-dif2.png') }}" alt="logo here" width="180px" height="150px" class="image-fluid">
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
                                    <h5 style="font-weight:bolder;text-align: left;"> Payroll Journal </h5>
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
                    $total_cr = 0; $total_dr = 0; $total_amount = 0;
                @endphp

                <table class="table" id="reports"  style="font-size:7px;">
                    <thead>
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <th><b>Item</b></th>
                            {{-- <th><b></b></th> --}}
                            <th class="text-end"><b>Amount</b></th>
                            <th class="text-end"><b>Key</b></th>
                            <th class="text-end"><b>Account Number</b></th>
                            <th class="text-end"><b>Account Name</b></th>
                            <th class="text-end"><b>Narations</b></th>
                            <th class="text-end"><b>Debit</b></th>
                            <th class="text-end"><b>Credit</b></th>

                        </tr>
                    </thead>

                    <tbody>
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>Gross Pay</b></td>
                            {{-- <td></b></td> --}}
                            <td class="text-end">{{ number_format($gross_managent, 2) }}</td>
                            <td class="text-end">D</td>
                            <td class="text-end-left">E15201100</td>
                            <td class="text-end-left">Salaries - Management</td>
                            <td class="text-end-left">Salaries for Management Staff
                                {{ date('M-Y', strtotime($payroll_date)) }}</td>
                            <td class="text-end">{{ number_format($gross_managent, 2) }}</td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            @php
                            $total_amount += $gross_managent;
                            $total_dr += $gross_managent;
                            @endphp
                        </tr>

                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>Gross Pay</td>
                            {{-- <td></td> --}}
                            <td class="text-end">{{ number_format($gross_non_managent, 2) }}</td>
                            <td class="text-end">D</td>
                            <td class="text-end-left">E15201200</td>
                            <td class="text-end-left">Salaries - Non Management</td>
                            <td class="text-end-left">Salaries for Non Management Staff
                                {{ date('M-Y', strtotime($payroll_date)) }}</td>
                            <td class="text-end">{{ number_format($gross_non_managent, 2) }}</td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            @php
                            $total_amount += $gross_non_managent;
                            $total_dr += $gross_non_managent;
                            @endphp
                        </tr>

                        @if (count($benefits_allowances) > 0)
                            @foreach ($benefits_allowances as $row)
                                <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                                    <td>{{ $row->description }}</td>
                                    {{-- <td></td> --}}
                                    <td class="text-end">{{ number_format($row->amount, 2) }}</td>
                                    <td class="text-end">D</td>
                                    <td class="text-end-left">E15201200</td>
                                    <td class="text-end-left">Salaries - {{ $row->account_name }}</td>
                                    <td class="text-end-left">Salaries for {{ $row->account_name }} Staff
                                        {{ date('M-Y', strtotime($payroll_date)) }}</td>
                                    <td class="text-end">{{ number_format($row->amount, 2) }}</td>
                                    <td class="text-end">{{ number_format(0, 2) }}</td>
                                    @php
                                    $total_amount += $row->amount;
                                    $total_dr += $row->amount;
                                    @endphp
                                </tr>
                            @endforeach
                        @endif

                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>NSSF Company Cost</td>
                            {{-- <td></td> --}}
                            <td class="text-end">{{ number_format($contributions['nssf'], 2) }}</td>
                            <td class="text-end">D</td>
                            <td class="text-end-left">E15203000</td>
                            <td class="text-end-left">Statutory Deduction -Social Sec</td>
                            <td class="text-end-left">NSSF Company Cost {{ date('M-Y', strtotime($payroll_date)) }}
                            </td>
                            <td class="text-end">{{ number_format($contributions['nssf'], 2) }}</td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            @php
                            $total_amount += $contributions['nssf'];
                            $total_dr += $contributions['nssf'];
                            @endphp
                        </tr>

                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>WCF Cost</td>
                            {{-- <td></td> --}}
                            <td class="text-end">{{ number_format($contributions['wcf'], 2) }}</td>
                            <td class="text-end">D</td>
                            <td class="text-end-left">E15202100</td>
                            <td class="text-end-left">Pension</td>
                            <td class="text-end-left">WCF Cost {{ date('M-Y', strtotime($payroll_date)) }}</td>
                            <td class="text-end">{{ number_format($contributions['wcf'], 2) }}</td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            @php
                            $total_amount += $contributions['wcf'];
                            $total_dr += $contributions['wcf'];
                            @endphp
                        </tr>

                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>SDL Cost</td>
                            {{-- <td></td> --}}
                            <td class="text-end">{{ number_format($contributions['sdl'], 2) }}</td>
                            <td class="text-end">D</td>
                            <td class="text-end-left">E15202100</td>
                            <td class="text-end-left">Pension</td>
                            <td class="text-end-left">SDL Cost {{ date('M-Y', strtotime($payroll_date)) }}</td>
                            <td class="text-end">{{ number_format($contributions['sdl'], 2) }}</td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            @php
                            $total_amount += $contributions['sdl'];
                            $total_dr += $contributions['sdl'];
                            @endphp
                        </tr>

                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>PAYE</td>
                            {{-- <td></td> --}}
                            <td class="text-end">{{ number_format($contributions['paye'], 2) }}</td>
                            <td class="text-end">C</td>
                            <td class="text-end-left">L30700000</td>
                            <td class="text-end-left">PAYE payable</td>
                            <td class="text-end-left">Pay As You Earn {{ date('M-Y', strtotime($payroll_date)) }}</td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            <td class="text-end">{{ number_format($contributions['paye'], 2) }}</td>
                            @php
                            $total_amount += $contributions['paye'];
                            $total_cr += $contributions['paye'];
                            @endphp

                        </tr>


                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>NSSF Payable</td>
                            {{-- <td></td> --}}
                            <td class="text-end">{{ number_format($contributions['nssf'] * 2, 2) }}</td>
                            <td class="text-end">C</td>
                            <td class="text-end-left">L20800000</td>
                            <td class="text-end-left">Other Liab - Payroll Deductions</td>
                            <td class="text-end-left">NSSF Payable {{ date('M-Y', strtotime($payroll_date)) }}</td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            <td class="text-end">{{ number_format($contributions['nssf'] * 2, 2) }}</td>
                            @php
                            $total_amount += ($contributions['nssf']*2);
                            $total_cr += ($contributions['nssf']*2);
                            @endphp

                        </tr>

                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>WCF Payable</td>
                            {{-- <td></td> --}}
                            <td class="text-end">{{ number_format($contributions['wcf'], 2) }}</td>
                            <td class="text-end">C</td>
                            <td class="text-end-left">L20800000</td>
                            <td class="text-end-left">Other Liab - Payroll Deductions</td>
                            <td class="text-end-left">WCF Payable {{ date('M-Y', strtotime($payroll_date)) }}</td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            <td class="text-end">{{ number_format($contributions['wcf'], 2) }}</td>
                            @php
                            $total_amount += $contributions['wcf'];
                            $total_cr += $contributions['wcf'];
                            @endphp
                        </tr>

                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>SDL Payable</td>
                            {{-- <td></td> --}}
                            <td class="text-end">{{ number_format($contributions['sdl'], 2) }}</td>
                            <td class="text-end">C</td>
                            <td class="text-end-left">L20800000</td>
                            <td class="text-end-left">Other Liab - Payroll Deductions</td>
                            <td class="text-end-left">SDL Payable {{ date('M-Y', strtotime($payroll_date)) }}</td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            <td class="text-end">{{ number_format($contributions['sdl'], 2) }}</td>
                            @php
                            $total_amount += $contributions['sdl'];
                            $total_cr += $contributions['sdl'];
                            @endphp

                        </tr>

                        @if (count($deductions) > 0)
                            @foreach ($deductions as $row)
                                <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                                    <td>{{ $row->description }}</td>
                                    {{-- <td></td> --}}
                                    <td class="text-end">{{ number_format($row->amount, 2) }}</td>
                                    <td class="text-end">C</td>
                                    <td class="text-end-left">A50106000</td>
                                    <td class="text-end-left">Staff Addvances</td>
                                    <td class="text-end-left">{{ $row->naration }}</td>
                                    <td class="text-end">{{ number_format(0, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->amount, 2) }}</td>
                                    @php
                                    $total_amount += $row->amount;
                                    $total_cr += $row->amount;
                                    @endphp
                                </tr>
                            @endforeach
                        @endif

                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>HESLB</td>
                            {{-- <td></td> --}}
                            <td class="text-end">{{ number_format($heslb, 2) }}</td>
                            <td class="text-end">C</td>
                            <td class="text-end-left">L20800000</td>
                            <td class="text-end-left">Other Liab - Payroll Deductions</td>
                            <td class="text-end-left">HESLB - {{ date('M-Y', strtotime($payroll_date)) }}</td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            <td class="text-end">{{ number_format($heslb, 2) }}</td>
                            @php
                            $total_amount += $heslb;
                            $total_cr += $heslb;
                            @endphp
                        </tr>

                        @if (count($net_terminal_benefit) > 0)
                            @foreach ($net_terminal_benefit as $row)
                                <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                                    <td>Terminal Benefit</td>
                                    <td></td>
                                    <td class="text-end">{{ number_format($row->amount, 2) }}</td>
                                    <td class="text-end">C</td>
                                    <td class="text-end-left">L20800000</td>
                                    <td class="text-end-left">Other Liab - Payroll Deductions</td>
                                    <td class="text-end-left">Terminal benefit-{{ $row->name }}</td>
                                    <td class="text-end">{{ number_format(0, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->amount, 2) }}</td>
                                    @php
                                    $total_amount += $row->amount;
                                    $total_cr += $row->amount;
                                    @endphp
                                </tr>
                            @endforeach
                        @endif

                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>Net pay</td>
                            {{-- <td></td> --}}
                            <td class="text-end">{{ number_format($net_pay, 2) }}</td>
                            <td class="text-end">C</td>
                            <td class="text-end-left">A50106000</td>
                            <td class="text-end-left">Staff Advances</td>
                            <td class="text-end-left">Net pay  - {{ date('M-Y', strtotime($payroll_date)) }}</td>
                            <td class="text-end">{{ number_format(0, 2) }}</td>
                            <td class="text-end">{{ number_format($net_pay, 2) }}</td>
                            @php
                            $total_amount += $net_pay;
                            $total_cr += $net_pay;
                            @endphp
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <td>Grand Total</td>
                            {{-- <td></td> --}}
                            <td class="text-end">{{ number_format($total_amount, 2) }}</td>
                            <td class="text-end"></td>
                            <td class="text-end-left"></td>
                            <td class="text-end-left"></td>
                            <td class="text-end-left"></td>
                            <td class="text-end">{{ number_format($total_dr, 2) }}</td>
                            <td class="text-end">{{ number_format($total_dr, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
                <hr style="border: 2px solid rgb(211, 140, 10); border-radius: 2px;">

            </div>


        </div>


        </div>
        </div>

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
