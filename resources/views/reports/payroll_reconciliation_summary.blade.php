!DOCTYPE html>
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

            <div class="col-md-10 mx-auto">

                <div class="row" style="border-bottom: 10px solid rgb(242, 183, 75) !important; ">
                    <div class="col-md-5 col-5">
                        <img src="{{ asset('assets/images/logo-dif2.png') }}" alt="logo here" width="30%">
                        <br>
                        <p>AFRICAN BANKING CORPORATION <br>P.O. BOX 31<br>DAR ES SALAAM</p>

                    </div>
                    <div class="col-md-7 col-7">

                        <h5 class="text-end font-weight-bolder" style="font-weight:bolder;">Payroll Detail_By Number
                        </h5>

                    </div>



                </div>


                <div class="row" style="border-bottom: 10px solid rgb(23, 57, 137) !important; ">
                    <div class="col-md-12 col-12">
                        <table class="table datatable-button-html5-columns" style="font-size:9px;">
                            <thead>
                                <tr>
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
                                    <th><b>Tax</b></th>
                                    <th><b>NSSF</b></th>
                                    <th><b>Total Deduction</b></th>
                                    <th><b>Ammount Payable</b></th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(!empty($summary)){
                                foreach ($summary as $row){

                                    $start = $row->payroll_date;
            //For redirecting Purpose
            $date_separate = explode("-", $start);

            $mm = $date_separate[1];
            $yyyy = $date_separate[0];
            $dd = $date_separate[2];
            $one_year_back = $date_separate[0] - 1;

            $payroll_date = $yyyy . "-" . $mm . "-" . $dd;
            $payroll_month_end = $yyyy . "-" . $mm . "-31";
            $payroll_month = $yyyy . "-" . $mm;
                                        $report_model =new \App\Models\Payroll\ReportModel();
                               $total_allowances = $report_model->total_allowances($row->empID, $payroll_month);
                               $total_pensions = $report_model->total_pensions($row->empID, $payroll_date);
                               $total_deductions = $report_model->total_deductions($row->empID, $payroll_month);
                               //$loans = $$report_model->loans($$row->empID, $payroll_month);
                               $amount_takehome = ($total_allowances+$row->salary) - ($row->pension_employee+$row->taxdue+$total_deductions);

                                ?>

                                <tr>
                                    <td><b>{{ $row->emp_id }}</b></td>

                                    <td><b>{{ $row->fname }} {{ $row->mname }} {{ $row->lname }}</b></td>
                                    <td><b>{{ $row->salary }}</b></td>
                                    <td><b>0</b></td>
                                    <td><b>{{ $row->allowances }}</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0<b></td>
                                    <td><b>0</b></td>
                                    <td><b>{{ $row->salary + $row->allowances }}</b></td>
                                    <td><b>0</b></td>
                                    <td><b>Taxable Gross</b></td>
                                    <td><b>{{ $row->taxdue }}</b></td>
                                    <td><b>{{ $row->pension_employer + $row->pension_employee }}</b></td>
                                    <td><b>{{ $row->pension_employer + $row->pension_employee + $row->taxdue }}</b></td>
                                    <td><b>{{ $amount_takehome }}</b></td>


                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="row" style="border-bottom: 10px solid rgb(242, 183, 75) !important; ">


                    <div class="col-md-12">
                        <table class="table datatable-button-html5-columns" style="font-size:9px;">

                            <thead>
                                <tr>
                                    <th>Initiated By:</th>
                                    <th>name..........................................</th>
                                    <th>position......................................</th>
                                    <th>signature.....................................</th>
                                    <th>date..........................................</th>
                                </tr>
                                <tr>
                                    <th>Checked & Approved By:</th>
                                    <th>name...........................................</th>
                                    <th>position.......................................</th>
                                    <th>signature......................................</th>
                                    <th>date..........................................</th>
                                </tr>
                                <tr>
                                    <th>Checked & Approved By:</th>
                                    <th>name............................................</th>
                                    <th>position.........................................</th>
                                    <th>signature.......................................</th>
                                    <th>date.............................................</th>
                                </tr>
                                <tr>
                                    <th>Approved By:</th>
                                    <th>name.............................................</th>
                                    <th>position..........................................</th>
                                    <th>signature.........................................</th>
                                    <th>date................................................</th>
                                </tr>
                            </thead>
                            <tbody></tbody>

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
