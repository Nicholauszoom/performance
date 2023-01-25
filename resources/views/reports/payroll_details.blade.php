<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Terminal Benefits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>

    <main>
        <div class="row my-4">

            <div class="col-md-9 mx-auto">

                <div class="row" style="border-bottom: 10px solid rgb(242, 183, 75) !important; ">
                    <div class="col-md-5 col-5">
                        <img src="https://www.bancabc.co.tz/images/banc_abc_logo.png" alt="logo here" width="30%">
                        <br>
                        <p>AFRICAN BANKING CORPORATION <br>P.O. BOX 31<br>DAR ES SALAAM</p>

                    </div>
                    <div class="col-md-7 col-7">

                        <h5 class="text-end font-weight-bolder" style="font-weight:bolder;">Payroll Detail_By Number
                        </h5><br>
                        <h5 class="text-end font-weight-bolder" style="font-weight:bolder;">Date: {{ $payroll_date }}
                        </h5>

                    </div>



                </div>


                <div class="row" style="border-bottom: 10px solid rgb(23, 57, 137) !important; ">
                    <div class="col-md-12 col-12">
                        <table class="table datatable-button-html5-columns" style="font-size:9px;">
                            <thead>
                                <tr>
                                    <th><b>S/No</b></th>
                                    <th><b>Pay No</b></th>

                                    <th><b>Name</b></th>
                                    <th><b>Monthly Basic Salary</b></th>
                                    <th><b>Overtime</b></th>
                                    <th><b>Allowance</b></th>
                                    <th><b>Cost OF Living</b></th>
                                    <th><b>Utility</b></th>
                                    <th><b>House Allowance</b></th>
                                    <th><b>Areas</b></th>
                                    <th><b>Other Payments</b></th>
                                    <th><b>Gross Salary</b></th>
                                    <th><b>Tax Benefit</b></th>
                                    <th><b>Taxable Gross</b></th>
                                    <th><b>SDL</b></th>
                                    <th><b>WCF</b></th>
                                    <th><b>Tax</b></th>
                                    <th><b>NSSF</b></th>
                                    <th><b>Total Deduction</b></th>
                                    <th><b>Ammount Payable</b></th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i =0;
                                if(!empty($summary)){
                                    $total_salary = 0; $total_netpay = 0; $total_allowance = 0; $total_overtime = 0; $total_house_rent = 0; $total_sdl = 0; $total_wcf = 0;
                                    $total_tax = 0; $total_pension = 0; $total_others = 0; $total_deduction = 0; $total_gross_salary = 0; $taxable_amount = 0;
                                foreach ($summary as $row){
                                    $i++;
                                    $amount = $row->salary + $row->allowances-$row->pension_employer-$row->loans-$row->deductions-$row->meals-$row->taxdue;
                                    $total_netpay = $total_netpay +  $amount;

                                    $total_gross_salary = $total_gross_salary +  ($row->salary + $row->allowances);
                                    $total_salary = $total_salary + $row->salary;
                                    $total_allowance = $total_allowance + $row->allowances ;
                                    $total_overtime = $total_overtime +$row->overtime;
                                    $total_house_rent = $total_house_rent + $row->house_rent;
                                    $total_others = $total_others + $row->other_payments ;
                                    $total_tax = $total_tax + $row->taxdue ;
                                    $total_pension = $total_pension + $row->pension_employer;
                                    $total_deduction = $total_deduction + ($row->salary + $row->allowances)-$amount;
                                    $total_sdl = $total_sdl + $row->sdl;
                                    $total_wcf = $total_wcf + $row->wcf;
                                    $total_taxable_amount = $taxable_amount + ($row->salary + $row->allowances-$row->pension_employer);




                                ?>

                                <tr>
                                    <td class=""><b>{{ $i }}</b></td>
                                    <td class=""><b>{{ $row->emp_id }}</b></td>

                                    <td class=""><b>{{ $row->fname }} {{ $row->mname }} {{ $row->lname }}</b></td>
                                    <td class="text-end"><b>{{ $row->salary }}</b></td>
                                    {{-- <td class="text-end"><b>{{ $row->allowance_id =="Overtime"? $row->allowance_amount:0 }}</b></td> --}}
                                    <td class="text-end"><b>{{ $row->overtime }}</b></td>

                                    <td class="text-end"><b>{{ $row->allowances }}</b></td>
                                    <td class="text-end"><b>0</b></td>
                                    <td class="text-end"><b>0</b></td>
                                    {{-- <td class="text-end"><b>{{ $row->allowance_id =="House Rent"? $row->allowance_amount:0 }}</b></td> --}}

                                    <td class="text-end"><b>{{ $row->house_rent }}</b></td>

                                    <td class="text-end"><b>0<b></td>
                                    {{-- <td class="text-end"><b>{{ $row->allowance_id !="Overtime" && $row->allowance_id !="House Rent"? $row->allowance_amount:0 }}</b></td> --}}
                                    <td class="text-end"><b>{{ $row->other_payments }}</b></td>

                                    <td class="text-end"><b>{{ $row->salary + $row->allowances }}</b></td>
                                    <td class="text-end"><b>0</b></td>
                                    <td class="text-end"><b>{{ ($row->salary + $row->allowances)-$row->pension_employer }}</b></td>
                                    <td class="text-end"><b>{{ $row->taxdue }}</b></td>
                                    <td class="text-end"><b>{{ $row->sdl }}</b></td>
                                    <td class="text-end"><b>{{ $row->wcf }}</b></td>
                                    <td class="text-end"><b>{{ $row->pension_employer  }}</b></td>
                                    <td class="text-end"><b>{{ ($row->salary + $row->allowances)-$amount }}</b></td>
                                    <td class="text-end"><b>{{ $amount }}</b></td>


                                </tr>

                                <?php } ?>
                                <tr style="font-size: 10px">
                                    <td class="" colspan="3"><b><center>TOTAL</center><b></td>
                                    <td class="text-end"><b>{{ $total_salary }}</b></td>
                                    <td class="text-end"><b>{{ $total_overtime }}</b></td>
                                    <td class="text-end"><b>{{ $total_allowance }}</b></td>
                                    <td class="text-end"><b><b>0</b></b></td>
                                    <td class="text-end"><b><b>0</b></b></td>
                                    <td class="text-end"><b>{{ $total_house_rent }}</b></td>
                                    <td class="text-end"><b><b>0<b></b></td>
                                    <td class="text-end"><b>{{ $total_others }}</b></td>
                                    <td class="text-end"><b>{{ $total_gross_salary }}</b></td>
                                    <td class="text-end"><b>0</b></td>
                                    <td class="text-end"><b>{{ $total_taxable_amount }}</b></td>


                                    <td class="text-end"><b>{{ $total_sdl }}</b></td>
                                    <td class="text-end"><b>{{ $total_wcf }}</b></td>

                                    <td class="text-end"><b>{{ $total_tax }}</b></td>
                                    <td class="text-end"><b>{{ $total_pension }}</b></td>
                                    <td class="text-end"><b>{{ $total_deduction }}</b></td>
                                    <td class="text-end"><b>{{ $total_netpay }}</b></td>
                                        </tr>

                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                 <div class="row" style="border-bottom: 10px solid rgb(242, 183, 75) !important; ">
                    <div class="col-md-12">
                        <hr style="border-bottom: 10px solid rgb(215, 154, 41); ">
                        {{-- <h5>FINANCE DEPARTMENT</h5> --}}
                        <div class="col-md-12 p-2" style="border:solid 1px gray ;border-bottom:none;">
                            <p><small><b>Prepared By</b></small></p>

                            <div class="row">
                                <div class="col-md-3">Name:__________________________</div>
                                <div class="col-md-3">Position:__________________________</div>
                                <div class="col-md-3">Signature:__________________________</div>
                                <div class="col-md-3">Date_________________________</div>
                            </div>
                            <br>
                            <p><small><b>Checked and Approved By</b></small></p>

                            <div class="row">
                                <div class="col-md-3">Name:__________________________</div>
                                <div class="col-md-3">Position:__________________________</div>
                                <div class="col-md-3">Signature:__________________________</div>
                                <div class="col-md-3">Date_________________________</div>
                            </div>

                            <p><small><b>Checked and Approved By</b></small></p>

                            <div class="row">
                                <div class="col-md-3">Name:__________________________</div>
                                <div class="col-md-3">Position:__________________________</div>
                                <div class="col-md-3">Signature:__________________________</div>
                                <div class="col-md-3">Date_________________________</div>
                            </div>

                            <p><small><b>Approved By</b></small></p>

                            <div class="row">
                                <div class="col-md-3">Name:__________________________</div>
                                <div class="col-md-3">Position:__________________________</div>
                                <div class="col-md-3">Signature:__________________________</div>
                                <div class="col-md-3">Date_________________________</div>
                            </div>
                        </div>
                    </div>

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
