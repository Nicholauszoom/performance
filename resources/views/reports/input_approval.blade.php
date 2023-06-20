<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Input Change Approval</title>
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
                                    <h5 style="font-weight:bolder;text-align: left;"> Payroll Input Change Report </h5>
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
                        <table class="table" id="reports"  style="font-size:12px;">
                            <thead style="border-bottom:2px solid rgb(9, 5, 64);">
                                <tr>
                                    <th>Payrollno</th>
                                    <th>Name</th>
                                    <th>Time Stamp</th>
                                    <th>Change Made By</th>
                                    <th>FieldName</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>InputScreen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $row)
                                    <tr style="border-bottom:2px solid rgb(67, 67, 73);" id="{{ 'domain' . $row->id }}">
                                        <td>{{ $row->payrollno }}</td>

                                        <td> {{ $row->empName }} </td>

                                        <td>
                                            @php
                                                $temp = explode(' ', $row->created_at);
                                            @endphp

                                            <p style="margin-bottom:0;"> <strong>Date </strong> : {{ $temp[0] }} </p>
                                            <p style="margin : 0; padding-top:0;"> <strong>Time </strong> : {{ $temp[1] }} </p>
                                        </td>

                                        <td> {{ $row->authName }} </td>

                                        <td>{{ $row->field_name }}</td>

                                        <td>{{ $row->action_from }}</td>

                                        <td>{{ $row->action_to }}</td>

                                        <td>{{ $row->input_screen }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>

                        <table class="table" id="reports">
                            <tbody>
                               
                                <tr>

                                    <td>
                                        <p class="text-start"><small>Approved By:</small></p>
                                    </td>
                                    <td>
                                        <p class="text-start"><small>Name______________________</small></p>
                                    </td>
                                    <td>
                                        <p class="text-start"><small>Signature and Date___________</small></p>
                                    </td>

                                </tr>
                               
                                
                            </tbody>
                        </table>
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
