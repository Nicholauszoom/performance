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
</head>

<body>

    <main class=" mx-auto">
        <div class="row ">
            <div class="col-md-9 col-12 mx-auto">
                <h5 class="text-end text-secondary font-weight-bolder" style="font-weight:bolder;">Terminal Benefit</h5>

                <div class="row" style="border-bottom: 10px solid rgb(242, 183, 75) !important; ">
                    <div class="col-md-7 col-7">
                        <div class="row">
                            <div class="col-md-3 col-3">
                                <img src="https://www.bancabc.co.tz/images/banc_abc_logo.png" alt="logo here"
                                    width="100%">

                            </div>
                            <div class="col-md-9 col-9">
                                {{-- <br> --}}
                                <p>AFRICAN BANKING CORPORATION <br>P.O. BOX 31<br>DAR ES SALAAM</p>
                                <button id="printbtn" onclick="window.print()">Print this page</button>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-5 col-5">
                        <div class="row text-end">
                            <div class="col-md-6 col-6">
                                <p>Employment Date</p>
                            </div>
                            <div class="col-md-6 col-6">
                                <p>{{ $termination->employee->hire_date }}</p>
                            </div>
                            <div class="col-md-6 col-6">
                                <p>Termination Date</p>
                            </div>
                            <div class="col-md-6 col-6">
                                <p>{{ $termination->terminationDate }}</p>
                            </div>
                        </div>

                    </div>



                </div>

                <div class="row" style="border-bottom: 10px solid rgb(23, 57, 137) !important; ">
                    <div class="col-md-6 col-6">
                        <h6>Payroll Number</h6>
                        <h6>Full Name: </h6>

                        <h6>Department:</h6>
                    </div>
                    <div class="col-md-6 text-end col-6">
                        <h6>{{ $termination->employee->payroll_no }}</h6>
                        <h6>{{ $termination->employee->fname.' '.$termination->employee->mname.' '.$termination->employee->lname }}</h6>

                        <h6>{{ $employee_info[0]->deptname }}</h6>
                    </div>
                </div>

                <div class="row" style="border-bottom: 10px solid rgb(23, 57, 137) !important;">
                    <h5 class="text-center p-1"
                        style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                        PAYMENTS</h5>

                    <div class="col-md-6 col-6">
                        <h6>Salary Enrollment</h6>
                        <h6>Overtime Normal Days</h6>
                        <h6>Overtime Public</h6>
                        <h6>Notice Payment</h6>
                        <h6>Outstanding Leave Pay</h6>
                        <h6>House Allowance</h6>
                        <h6>Cost of Living</h6>
                        <h6>Utility Allowance</h6>
                        <h6>Leave Allowance</h6>
                        <h6>Serevance Pay</h6>
                        <h6>Leave & 0/stand</h6>
                        <h6>Teller Allowance</h6>
                        <h6>Arrears</h6>
                        <h6>Discr Exgracia</h6>
                        <h6>Bonus</h6>
                        <h6>Long Serving</h6>
                        <h6>Other Non Taxable Payments </h6>
                    </div>
                    <div class="col-md-6 col-6 text-end">
                        <h6>{{ number_format($termination->salaryEnrollment, 2) }}</h6>
                        <h6>{{ number_format($termination->normal_days_overtime_amount , 2) }}</h6>
                        <h6>{{ number_format($termination->public_overtime_amount, 2) }}</h6>
                        <h6>{{ number_format($termination->noticePay, 2) }}</h6>

                        <h6>{{ number_format($termination->leavePay, 2) }}</h6>
                        <h6>{{ number_format($termination->livingCost, 2) }}</h6>
                        <h6>{{ number_format($termination->utilityAllowance, 2) }}</h6>

                        <h6>{{ number_format($termination->serevanceCost, 2) }}</h6>
                        <h6>{{ number_format($termination->leaveAllowance, 2) }}</h6>
                        <h6>{{ number_format($termination->tellerAllowance, 2) }}</h6>
                        <h6>{{ number_format($termination->leaveStand, 2) }}</h6>

                        <h6>{{ number_format($termination->serevanceCost, 2) }}</h6>
                        <h6>{{ number_format($termination->arrears, 2) }}</h6>
                        <h6>{{ number_format($termination->exgracia, 2) }}</h6>
                        <h6>{{ number_format($termination->bonus, 2) }}</h6>
                        <h6>{{ number_format($termination->longServing, 2) }}</h6>
                        <h6>{{ number_format($termination->otherPayments, 2) }}</h6>
                    </div>
                </div>

                <div class="row" style="border-bottom: 10px solid rgb(23, 57, 137) !important;">
                    <h5 class="text-center p-1"
                        style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                        TAXATION</h5>

                    <div class="col-md-6 col-6">
                        <h6>TOTAL GROSS </h6>
                        <h6>Pension </h6>
                        <h6>Taxable Gross Pay</h6>
                        <h6>P.A.Y.E </h6>

                    </div>
                    <div class="col-md-6  col-6 text-end">
                        <h6>{{ number_format($termination->total_gross, 2) }}</h6>
                        <h6>{{ number_format($termination->pension_employee, 2) }}</h6>
                        <h6>{{ number_format($termination->taxable, 2) }}</h6>
                        <h6>{{ number_format($termination->paye, 2) }}</h6>


                    </div>



                </div>




                <div class="row" style="border-bottom: 10px solid rgb(23, 57, 137) !important;">
                    <h5 class="text-center p-1"
                        style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                        DEDUCTION</h5>

                    <div class="col-md-6 col-6">
                        <h6>P.A.Y.E</h6>
                        <h6>Outstanding Loan Balance</h6>
                        <h6>Pension</h6>
                        <h6>Salary Advances</h6>
                        <h6>Any Other Deductions</h6>
                    </div>
                    <div class="col-md-6 col-6 text-end">
                        <h6>{{ number_format($termination->paye, 2) }}</h6>
                        <h6>{{ number_format($termination->loan_balance,2)}}</h6>
                        <h6>{{ number_format($termination->pension_employee, 2) }}</h6>
                        <h6>{{ number_format($termination->salaryAdvance, 2) }}</h6>
                        <h6>{{ number_format($termination->otherDeductions, 2) }}</h6>

                    </div>

                    <div class="px-1"
                        style="border-bottom: 4px solid rgb(20, 22, 27) !important; border-top: 4px solid rgb(20, 22, 27) !important;">
                        <div class="row mx-auto">
                            <div class="col-md-6 col-6">
                                <h5>
                                    Total Deductions
                                </h5>
                            </div>
                            <div class="col-md-6 col-6 text-end">
                                <h5>{{ number_format($termination->pension_employee + $termination->paye + $termination->otherDeductions + $termination->loan_balance, 2) }}
                                </h5>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <h5 class="text-center" style="background-color:  rgb(64, 190, 199) !important; "> SUMMARY</h5>

                    <div class="col-md-6 col-6">
                        <h6>TOTAL GROSS</h6>
                        <h6>Total Deductions</h6>
                        <h6>Net Pay </h6>
                        <h6>Take home after loan deduction </h6>
                        <h6>Take home</h6>
                        {{-- <h6>Take home after loan deduction</h6> --}}

                        <h6 class="mt-3" style="border-bottom: 3px  !important;"><b>Employee Signature:______________________</b></h6>

                        <h6 class="mt-3" style="border-bottom: 3px  !important;"><b>Employer's Signature:____________________</b></h6>

                    </div>
                    <div class="col-md-6 col-6 text-end">
                        <h6>{{ $termination->total_gross }}</h6>

                        <h6>{{ number_format($termination->pension_employee + $termination->paye + $termination->otherDeductions + $termination->loan_balance, 2) }}
                        </h6>
                        <h6>{{ number_format($termination->taxable -$termination->paye , 2) }}
                        </h6>
                        <h6>{{ number_format(($termination->taxable -$termination->paye)-$termination->loan_balance , 2) }}</h6>
                        <h6>{{ number_format(($termination->taxable -$termination->paye)-$termination->loan_balance , 2) }}</h6>
                        <hr>



                    </div>
                </div>


                <div class="row" style="border-bottom: 10px solid rgb(242, 183, 75) !important; ">


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
