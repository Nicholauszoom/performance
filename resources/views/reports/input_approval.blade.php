<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Terminal Benefits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style type="text/css">
            @media print {
                #printbtn {
                    display :  none;
                }
            }
            </style>

<style media="print">
    @page {
     size: auto;
     margin: 0;
          }
   </style>
</head>

<body>

    <main>
        <div class="row my-4">

            <div class="col-md-9 mx-auto">
                <button id="printbtn" onclick="window.print()">Print this page</button>

                <div class="d-flex justify-content-between" style="border-bottom: 10px solid rgb(242, 183, 75) !important; ">
                    <div>

                        <img src="{{ asset('assets/images/logo-dif2.png') }}" alt="logo here" class="image-fluid">
                    </div>
                    <div class="text-center">
                        <p style="font-weight:600">AFRICAN BANKING CORPORATION <br>P.O. BOX 31<br>DAR ES SALAAM</p>
                        <button id="printbtn" onclick="window.print()">Print this page</button>
                    </div>
                    <div>
                        <h5 class="text-end font-weight-bolder" style="font-weight:bolder;">Input Changes Approval Report</h5>
                        <p class="text-end font-weight-bolder text-primary" style="font-weight:bolder;"> Date:
                            {{ $payroll_date }}
                        </p>
                    </div>
                </div>


                <div class="row mb-4">
                    <div class="col-md-12 col-12 mb-5 px-3">
                        <table class="table datatable-button-html5-columns" style="font-size:10px; border:1px solid #000">
                            <thead>
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
                                    <tr id="{{ 'domain'.$row->id }}">
                                        <td>{{ $row->payrollno }}</td>

                                        <td> {{ $row->empName }} </td>

                                        <td>
                                            @php
                                                $temp = explode(' ',$row->created_at);
                                            @endphp

                                            <p> <strong>Date </strong> : {{ $temp[0] }} </p>
                                            <p> <strong>Time </strong> : {{ $temp[1] }} </p>
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
                    </div>

                </div>



            </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> <br><br><br><br>

        <div class="row mt-5 mx-4" style="margin-top:20px; border:none 1px gray;">
            <div class="col-md-12 mb-3">
                <p class="text-start"><small><b>Prepared By</b></small></p>

                <div class="row mt-3">
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:__________________________</div>
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:__________________________</div>
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:__________________________</div>
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date_________________________</div>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <p><small><b>Checked and Approved By</b></small></p>

                <div class="row mt-3">
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:__________________________</div>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:__________________________</div>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:__________________________</div>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date_________________________</div>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <b>Checked and Approved By</b>

                <div class="row mt-3">
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:__________________________</div>
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:__________________________</div>
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:__________________________</div>
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date_________________________</div>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <p><small><b>Approved By</b></small></p>

                <div class="row mt-3">
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:__________________________</div>
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:__________________________</div>
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:__________________________</div>
                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date_________________________</div>
                </div>
            </div>

        </div>
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
