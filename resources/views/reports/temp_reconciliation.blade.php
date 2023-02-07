<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Reconciliation-Summary</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
</head>

<body>

    <main>
        <div class="row my-4">

            <div class="col-md-10 mx-auto">

                <div class="row" >
                    <div class="col-md-7 col-5">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="https://www.bancabc.co.tz/images/banc_abc_logo.png" alt="logo here" width="100%">

                            </div>
                            <div class="col-md-9">
                                {{-- <br> --}}
                                <p>AFRICAN BANKING CORPORATION <br>P.O. BOX 31<br>DAR ES SALAAM</p>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-5 col-5">

                        <h5 class="text-end font-weight-bolder" style="font-weight:bolder;">Payroll Reconciliation-Summary
                        </h5><br>
                        <p class="text-end font-weight-bolder text-primary" style="font-weight:bolder;">For the month: November,2022
                        </p>

                    </div>



                </div>


                <div class="row mt-4" >
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
                            <tbody style="border-bottom: 2px solid rgb(18, 93, 54) !important; ">
                                <tr>
                                    <td class="text-start">00001</td>
                                    <td class="text-start">Last Month Gross Salary</td>
                                    <td class="text-end">0</td>
                                    <td class="text-end">0</td>
                                    <td class="text-end">663,091,795</td>
                                    <td class="text-end">179</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                    <tr>
                                        <td class="text-start"></td>
                                        <td class="text-start"><b>This Month</b> </td>
                                        <td class="text-end"><b>16,259,224</b></td>
                                        <td class="text-end"><b>35,698,923</b></td>
                                        <td class="text-end"><b>682,531,494</b></td>
                                        <td class="text-end"><b>181</b></td>
                                    </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-6" >
                    <h5>FINANCE DEPARTMENT</h5>
                    <div class="col-md-12 p-2" style="border:solid 1px gray ;border-bottom:none;">
                    <p><small>Checked By</small></p>

                    <div class="row">
                        <div class="col-md-5">Name:__________________________</div>
                        <div class="col-md-7">Signature and Date_________________________</div>
                    </div>
                    <br>
                    <p><small>Approved BY</small></p>

                    <div class="row mb-3">
                        <div class="col-md-5">Name:__________________________</div>
                        <div class="col-md-7">Signature and Date_________________________</div>
                    </div>
                    </div>
                    </div>

                    <div class="col-md-6">
                    <h5>HR DEPARTMENT</h5>

                    <div class="col-md-12 p-2" style="border:solid 1px gray ;border-bottom:none;">
                        <p class="mb-5 mt-4"><small>Review By</small></p>





                        <div class="row mb-5">
                            <div class="col-md-5">Name:__________________________</div>
                            <div class="col-md-7">Signature and Date_________________________</div>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>


        </div>
        </div>
    </main>


    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script> --}}
    
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>


</body>

</html>
