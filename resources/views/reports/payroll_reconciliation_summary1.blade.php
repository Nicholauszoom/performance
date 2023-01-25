<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Reconciliation-Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        {{-- <link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}"> --}}






</head>

<body>

    <main>
        <div class="row my-4">

            <div class="col-md-10 mx-auto">

                <div class="row">
                    <div class="col-md-7 col-7">
                        <div class="row">
                            <div class="col-md-3 col-3">
                                <img src="https://www.bancabc.co.tz/images/banc_abc_logo.png" alt="logo here"
                                    width="100%">

                            </div>
                            <div class="col-md-9 col-9">
                                {{-- <br> --}}
                                <p>AFRICAN BANKING CORPORATION <br>P.O. BOX 31<br>DAR ES SALAAM</p>
                                <button onclick="window.print()">Print this page</button>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-5 col-5">

                        <h5 class="text-end font-weight-bolder" style="font-weight:bolder;">Payroll
                            Reconciliation-Summary
                        </h5><br>
                        <p class="text-end font-weight-bolder text-primary" style="font-weight:bolder;">For the month:
                            {{ date('F, Y', strtotime($payroll_date)) }}
                        </p>

                    </div>



                </div>


                <div class="row mt-4 mb-5">
                    <hr style="border-bottom: 10px solid rgb(215, 154, 41); ">
                    <div class="col-md-12 col-12">
                        <table class="table table-stripped " style="font-size:14px;">
                            <thead>
                                <tr class="bg-light">
                                    <th><b>RefNo</b></th>
                                    <th><b>Desc</b></th>
                                    <th class="text-end"><b>Last Month</b></th>
                                    <th class="text-end"><b>This Month</b></th>
                                    <th class="text-end"><b>Amount</b></th>
                                    <th class="text-end"><b>Count</b></th>

                                </tr>
                            </thead>

                            <tbody >
                                <tr >
                                    <td class="text-start">00001</td>
                                    <td class="text-start">Last Month Gross Salary</td>
                                    <td class="text-end">
                                        {{ number_format($total_previous_basic - $total_previous_basic, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($total_previous_basic - $total_previous_basic, 2) }}</td>
                                    <td class="text-end">{{ number_format($total_previous_basic, 2) }}</td>
                                    <td class="text-end">{{ $count_previous_month }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start">00002</td>
                                    <td class="text-start">Add New Employee</td>
                                    <td class="text-end">
                                        {{ number_format($total_previous_basic - $total_previous_basic, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($total_current_basic - $total_previous_basic, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($total_current_basic - $total_previous_basic, 2) }}</td>
                                    <td class="text-end">{{ $count_current_month - $count_previous_month }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start">00004</td>
                                    <td class="text-start">Add Increase in Basic Pay incomparison to Last M </td>
                                    <td class="text-end">
                                        {{ number_format($total_previous_gross - $total_previous_gross, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($total_current_gross - $total_previous_gross, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($total_current_gross - $total_previous_gross, 2) }}</td>
                                    <td class="text-end"></td>
                                </tr>

                                <tr>
                                    <td class="text-start">00004</td>
                                    <td class="text-start">Less Decrease in Basic Pay incomparison to Las </td>
                                    <td class="text-end">
                                        {{ number_format($total_previous_gross - $total_previous_gross, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($total_current_gross - $total_previous_gross, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($total_current_gross - $total_previous_gross, 2) }}</td>
                                    <td class="text-end"></td>
                                </tr>
                                <tr>
                                    <td class="text-start">00004</td>
                                    <td class="text-start">Add/Less Day Overtime Hours </td>
                                    <td class="text-end">{{ number_format($total_previous_overtime, 2) }}</td>
                                    <td class="text-end">{{ number_format($total_current_overtime, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($total_current_overtime - $total_previous_overtime, 2) }}</td>
                                    <td class="text-end"></td>
                                </tr>
                                @if (count($total_allowances) > 0)
                                    @php $i = 1;  @endphp
                                    @foreach ($total_allowances as $row)
                                        @php $i++;  @endphp
                                        <tr>
                                            <td class="text-start">{{ '000' . $i + 4 }}</td>
                                            <td class="text-start">{{ $row->description }} </td>
                                            <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                            <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>
                                            <td class="text-end">{{ number_format($row->difference, 2) }}</td>
                                            <td class="text-end"></td>
                                        </tr>
                                    @endforeach
                                @endif
                            {{-- </tbody>
                            <tbody> --}}
                                <tr style="border-top: 2px solid rgb(18, 93, 54) !important; ">
                                    <td class="text-start"></td>
                                    <td class="text-start"><b>This Month</b> </td>
                                    <td class="text-end">
                                        <b>{{ number_format(!empty($total_previous_net) ? $total_previous_net : 0, 2) }}</b>
                                    </td>
                                    <td class="text-end"><b>{{ number_format($total_current_net, 2) }}</b></td>
                                    <td class="text-end">
                                        <b>{{ number_format($total_current_net - $total_previous_net, 2) }}</b></td>
                                    <td class="text-end"><b>{{ $count_current_month }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>


                <div class="row mt-4">


                    <div class="col-md-12 col-12 col-lg" >


                        {{-- <h5>FINANCE DEPARTMENT</h5> --}}
                        <div class="col-md-12 col-sm-12 col-12 p-2 mt-4" style="border:solid 1px gray ;border-bottom:none !important; ">
                            <p class="mt-2"><small><b>Prepared By</b></small></p>


                            <div class="row p-1">
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Name:______________________________</div>
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Position:__________________________</div>
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Signature:__________________________</div>
                                <div class="col-md-6  col-6 col-lg-6 mb-3">Date_________________________</div>
                            </div>
                            <br>
                            <p><small><b>Checked and Approved By</b></small></p>
                            <div class="row p-1">
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Name:______________________________</div>
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Position:__________________________</div>
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Signature:__________________________</div>
                                <div class="col-md-6  col-6 col-lg-6 mb-3">Date_________________________</div>
                            </div>

                            <p><small><b>Checked and Approved By</b></small></p>

                            <div class="row p-1">
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Name:______________________________</div>
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Position:__________________________</div>
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Signature:__________________________</div>
                                <div class="col-md-6  col-6 col-lg-6 mb-3">Date_________________________</div>
                            </div>

                            <p><small><b>Approved By</b></small></p>

                            <div class="row p-1">
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Name:______________________________</div>
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Position:__________________________</div>
                                <div class="col-md-4  col-4 col-lg-4 mb-3">Signature:__________________________</div>
                                <div class="col-md-6  col-6 col-lg-6 mb-3">Date_________________________</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        </div>
    </main>




    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


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
