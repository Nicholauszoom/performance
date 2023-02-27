<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Details </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                                        Reconciliation Summary</h5>
                                    <p class="text-end font-weight-bolder text-primary" style="font-weight:bolder;">
                                        Date:
                                        {{ $payroll_date }}

                                </div>
                            </td>
                        </tr>

                    </tfoot>
                </table>

                <hr style="border: 10px solid rgb(211, 140, 10); border-radius: 2px;">

                @foreach($names as $name)
                <h4>{{ $name }}</h4>

                <table class="table" style="font-size:9px; ">
                    <thead style="font-size:8px;">
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Number</b></th>

                            <th colspan="" style="margin-bottom: 30px;" class="text-center"><b>First Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Name</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Month</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>This Month</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Effect Amount</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Empl.Date</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Date Of Leaving</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($allowances))
                            @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                            @endphp
                             @endphp
                            @foreach ($allowances as $row)
                            @if($row->description == $name)
                                @php
                                    $total_previous += $row->previous_amount;
                                    $total_current += $row->current_amount;
                                    $total_amount += ($row->current_amount - $row->previous_amount);
                                @endphp
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="text-end">{{ $row->emp_id }}</td>



                                    <td class="text-end">{{ $row->fname }}</td>

                                    <td class="text-end">{{ $row->lname }}</td>


                                    <td class="text-end">{{ number_format($row->previous_amount, 0) }}</td>
                                    <td class="text-end">{{ number_format($row->current_amount, 0) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row->current_amount - $row->previous_amount, 0) }}</td>

                                    <td class="text-end">{{ $row->hire_date }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}
                                    </td>


                                </tr>
                                @endif
                            @endforeach
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class="text-end" colspan="2"><b>TOTAL</b></td>
                                <td></td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_previous, 0) }}</td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_current, 0) }}</td>

                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_amount, 0) }}</td>

                                <td class="text-end"></td>
                                <td class="text-end"></td>


                            </tr>
                        @endif
                    </tbody>

                </table>
                @endforeach

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






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

</body>

</html>
