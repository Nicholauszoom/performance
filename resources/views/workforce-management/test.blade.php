<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Terminal Benefits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>

    <main>
        <div class="row my-4">

            <div class="col-md-9 mx-auto">
                <h4 class="text-end text-secondary font-weight-bolder" style="font-weight:bolder;">Payroll Detail_By Number</h4>
                <div class="row" style="border-bottom: 10px solid rgb(242, 183, 75) !important; ">
                    <div class="col-md-5 col-5">
                        <img src="https://www.bancabc.co.tz/images/banc_abc_logo.png" alt="logo here" width="30%">
                        <br>
                        <p>AFRICAN BANKING CORPORATION <br>P.O. BOX 31<br>DAR ES SALAAM</p>

                    </div>
                    <div class="col-md-7 col-7">



                    </div>
                    <div class="col-md-6 col-6">

                    </div>


                </div>


                <div class="row" style="border-bottom: 10px solid rgb(23, 57, 137) !important; ">
                    <table class="table datatable-button-html5-columns">
                        <thead>
                            <tr>  <th><b>Pay No</b></th>

                                <th  ><b>Name</b></th>
                                <th  ><b>Monthly Basic Salary</b></th>
                                <th  ><b>Overtime</b></th>
                                <th   ><b>Allowance</b></th>
                                <th   ><b>Cost OF Living</b></th>
                                <th   ><b>Utility</b></th>
                                <th   ><b>House Allowance</b></th>
                                <th   ><b>Areas</b></th>
                                <th   ><b>Other Payments</b></th>
                                <th   ><b>Gross Salary</b></th>
                                <th   ><b>Tax Benefit</b></th>
                                <th   ><b>Taxable Gross</b></th>
                                <th   ><b>Tax</b></th>
                                <th   ><b>NSSF</b></th>
                                <th   ><b>Total Deduction</b></th>
                                <th   ><b>Ammount Payable</b></th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(!empty($summary)){
                            foreach ($summary as $row){


                            ?>

                            <tr>
                                <td  ><b>{{ $row->emp_id }}</b></td>

                                <td   ><b>{{ $row->fname }}  {{ $row->mname }}  {{ $row->lname }}</b></td>
                                <td  ><b>{{ $row->salary }}</b></td>
                                <td  ><b>0</b></td>
                                <td   ><b>{{ $row->allowances }}</b></td>
                                <td   ><b>0</b></td>
                                <td   ><b>0</b></td>
                                <td   ><b>0</b></td>
                                <td   ><b>0<b></td>
                                <td   ><b>0</b></td>
                                <td   ><b>{{ $row->salary + $row->allowances }}</b></td>
                                <td   ><b>0</b></td>
                                <td   ><b>Taxable Gross</b></td>
                                <td   ><b>{{ $row->taxdue }}</b></td>
                                <td   ><b>{{ $row->pension_employer + $row->pension_employee }}</b></td>
                                <td   ><b>{{ $row->pension_employer + $row->pension_employee + $row->taxdue }}</b></td>
                                <td   ><b>Ammount Payable</b></td>


                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>

            <









        <div class="row" style="border-bottom: 10px solid rgb(242, 183, 75) !important; ">
            <div class="col-md-3">
                <img src="https://www.bancabc.co.tz/images/banc_abc_logo.png" alt="logo here" width="100%">
            </div>
            <div class="col-md-9">
                <h4 class="text-end text-secondary font-weight-bolder" style="font-weight:bolder;">Terminal Benefit</h4>
                <h4>AFRICAN BANKING CORPORATION</h4>
                <h4>P.O. BOX 31</h4>
                <h4>DAR ES SALAAM</h4>

            </div>
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="row text-end">
                    <div class="col-md-6">
                        <p>Employment Date</p>
                    </div>
                    <div class="col-md-6">
                        <p>{{ $termination->employee->created_at}}</p>
                    </div>
                    <div class="col-md-6">
                        <p>Termination Date</p>
                    </div>
                    <div class="col-md-6">
                        <p>{{ $termination->terminationDate}}</p>
                    </div>
                </div>
            </div>

        </div>

            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>
