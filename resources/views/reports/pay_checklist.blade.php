<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Input Change Approval</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

</head>

<body>

    <main>
        <div class="row mb-4">
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

                                    <h5 class="text-end font-weight-bolder" style="font-weight:bolder;">Payment List
                                         Report</h5>
                                    <p class="text-end font-weight-bolder text-primary" style="font-weight:bolder;">
                                        For The Payroll Month:
                                        {{ date('M-y',strtotime($payroll_date)) }}
                                    </p>

                                </div>
                            </td>
                        </tr>

                    </tfoot>
                </table>

                <hr style="border: 5px solid rgb(211, 140, 10); border-radius: 2px;">
                        <table class="table" style="font-size:12px;">
                            <thead style="border-bottom:2px solid rgb(9, 5, 64);">
                                <tr>
                                    <tr style="background-color:#9a8138;color:#FFFFFF;">
                                        <th ><b>S/N</b></th>
                                        <th ><b>Payroll No</b></th>
                                        <th><b>Name</b></th>

                                        <th ><b>Bank</b></th>

                                        <th><b>BranchCode</b></th>
                                        <th ><b>Account No</b></th>
                                        <th ><b>Currency</b></th>
                                        <th ><b>Net Pay</b></th>
                                      </tr>

                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($employee_list as $row){
                                    $sno = $row->SNo;
                                    $empID =  $row->empID;
                                    $name = $row->name;
                                    $bank = $row->bank;
                                    $branch = $row->branch;
                                    $swiftcode = $row->swiftcode;
                                    $less_takehome = $row->less_takehome;
                                    $account_no = $row->account_no;
                                    if($less_takehome==0){
                                    $amount = $row->salary + $row->allowances-$row->pension-$row->loans-$row->deductions-$row->meals-$row->taxdue; } else $amount = $less_takehome;
                                    if  ($sno % 2 == 0) { $background = "#d3d3d3;"; } else { $background = "#FFFFFF;"; }
                                    ?>
                                    <tr nobr="true" style="border-bottom:2px solid rgb(67, 67, 73)">
                                        <td>{{ $sno }}</td>
                                        <td>&nbsp;{{ $empID }}</td>
                                        <td>&nbsp;{{ $name }}</td>

                                        <td>&nbsp;{{ $bank }}</td>

                                        <td>&nbsp;{{ $swiftcode }}</td>
                                        <td>&nbsp;{{ $account_no }}</td>
                                        <td>&nbsp;{{ $row->currency }}</td>
                                        <td>&nbsp;{{ number_format($amount/$row->rate,2) }}</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <hr style="border: 4px solid rgb(211, 140, 10); border-radius: 2px;">
                        <table class="table">
                            <tfoot>
                                <tr>
                                    <td collspan="4">
                                        <p class="text-start"><small><b>Prepared By</b></small></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">


                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date:________________</div>

                                    </td>
                                </tr>
                                <tr>
                                    <td collspan="4">
                                        <p><small><b>Checked and Approved By</b></small></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="">


                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date:________________</div>

                                    </td>
                                </tr>
                                <tr>
                                    <td collspan="4">
                                        <b>Checked and Approved By</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">


                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date:________________</div>

                                    </td>
                                </tr>
                                <tr>
                                    <td collspan="4">
                                        <p><small><b>Approved By</b></small></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">


                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                                    </td>
                                    <td>
                                            <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date:________________</div>

                                    </td>
                                </tr>


                            </tfoot>
                        </table>
                    </div>

                </div>





    </main>


    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

</body>

</html>
