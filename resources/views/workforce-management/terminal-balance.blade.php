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
            <div class="col-md-10 mx-auto">

                <div class="row" style="border-bottom: 10px solid rgb(242, 183, 75) !important; ">
                    <div class="col-md-3">
                        <img src="https://www.bancabc.co.tz/images/banc_abc_logo.png" alt="logo here" width="100%">
                    </div>
                    <div class="col-md-9">
                        <h4>AFRICAN BANKING CORPORATION</h4>
                        <h4>P.O. BOX 31</h4>
                        <h4>DAR ES SALAAM</h4>
                    </div>
                    <div class="col-md-6">

                    </div>
                    <div class="col-md-6">
                        <div class="row">
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


                <div class="row" style="border-bottom: 10px solid rgb(23, 57, 137) !important; ">
                    <div class="col-md-6">
                        <h6>Payroll Number</h6>
                        <h6>First Name: </h6>
                        <h6>Last name:</h6>
                        <h6>Department:</h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <h6 >{{ $termination->employee->payroll_no }}</h6>
                        <h6>{{ $termination->employee->fname }}</h6>
                        <h6>{{ $termination->employee->lname }}</h6>
                        <h6>Banking Operations & IT</h6>
                    </div>
                </div>

            <div class="row" style="border-bottom: 10px solid rgb(23, 57, 137) !important;">
                    <h4 class="text-center" style="background-color:  rgb(64, 190, 199) !important; "> PAYMENTS</h4>

                <div class="col-md-6">
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
                <div class="col-md-6 text-end">
                    <h6>{{ $termination->salaryEnrollment}}</h6>
                    <h6>{{ $termination->normalDays}}</h6>
                    <h6>{{ $termination->publicDays}}</h6>
                    <h6>{{ $termination->noticePay}}</h6>
                    <h6>{{ $termination->leavePay}}</h6>
                    <h6>{{ $termination->houseAllowance}}</h6>
                    <h6>{{ $termination->livingCost}}</h6>
                    <h6>{{ $termination->utilityAllowance}}</h6>
                    <h6>{{ $termination->leavePay}}</h6>
                    <h6>{{ $termination->serevanceCost}}</h6>
                    <h6>{{ $termination->leaveStand}}</h6>
                    <h6>{{ $termination->tellerAllowance}}</h6>
                    <h6>{{ $termination->utilityAllowance}}</h6>
                    <h6>{{ $termination->leavePay}}</h6>
                    <h6>{{ $termination->serevanceCost}}</h6>
                    <h6>{{ $termination->leaveStand}}</h6>
                    <h6>{{ $termination->tellerAllowance}}</h6>
                    <h6>{{ $termination->serevanceCost}}</h6>
                    <h6>{{ $termination->leaveStand}}</h6>
                    <h6>{{ $termination->tellerAllowance}}</h6>
                </div>
                </div>

                <div class="row" style="border-bottom: 10px solid rgb(23, 57, 137) !important;">
                    <h4 class="text-center" style="background-color:  rgb(64, 190, 199) !important; "> TAXATION</h4>

                <div class="col-md-6">
                    <h6>Salary Enrollment</h6>
                    <h6>Overtime Normal Days</h6>
                    <h6>Overtime Public</h6>
                    <h6>Notice Payment</h6>
                    
                </div>
                <div class="col-md-6 text-end">
                    <h6>{{ $termination->salaryEnrollment}}</h6>
                    <h6>{{ $termination->normalDays}}</h6>
                    <h6>{{ $termination->publicDays}}</h6>
                    <h6>{{ $termination->noticePay}}</h6>
                    <h6>{{ $termination->leavePay}}</h6>
              
                </div>

                

            </div>
                

        

            <div class="row" style="border-bottom: 10px solid rgb(23, 57, 137) !important;">
                <h4 class="text-center" style="background-color:  rgb(64, 190, 199) !important; "> DEDUCTION</h4>

            <div class="col-md-6">
                <h6>P.A.Y.E</h6>
                <h6>Outstanding Loan Balance</h6>
                <h6>Pension</h6>
                <h6>Salary Advances</h6>
                <h6>Any Other Deductions</h6>
            </div>
            <div class="col-md-6 text-end">
                <h6>{{ $termination->salaryEnrollment}}</h6>
                <h6>{{ $termination->normalDays}}</h6>
                <h6>{{ $termination->publicDays}}</h6>
                <h6>{{ $termination->noticePay}}</h6>
                <h6>{{ $termination->leavePay}}</h6>
                <h6>{{ $termination->leavePay}}</h6>
            </div>

            <div class="px-1" style="border-bottom: 4px solid rgb(20, 22, 27) !important; border-top: 4px solid rgb(20, 22, 27) !important;"> 
                <div class="row">
                    <div class="col-md-6">
                        <h5>
                            Total Deductions 
                        </h5>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5>7,849,071.37</h5>
                    </div>
                </div>
              
            </div>
        </div>


        <div class="row" >
            <h4 class="text-center" style="background-color:  rgb(64, 190, 199) !important; "> SUMMARY</h4>

        <div class="col-md-6">
            <h6>TOTAL GROSS</h6>
            <h6>Total Deductions</h6>
            <h6>Net Pay </h6>
            <h6>Notice Payment</h6>
            <h6>Take home after loan deduction</h6>

            <h6 class="mt-3"  style="border-bottom: 3px  !important;">Employee Signature:</h6>
           
            <h6 class="mt-3"  style="border-bottom: 3px  !important;">Employer's Signature:</h6>
           
        </div>
        <div class="col-md-6 text-end">
            <h6>{{ $termination->salaryEnrollment}}</h6>
            <h6>{{ $termination->normalDays}}</h6>
            <h6>{{ $termination->publicDays}}</h6>
            <h6>{{ $termination->noticePay}}</h6>
            <h6>{{ $termination->leavePay}}</h6>
            <h6 class="mt-4" style="margin-top:40px;border-bottom: 3px solid rgb(4, 11, 28) !important;"></h6>
            <br>
            <h6 class="mt-4" style="margin-top:40px;border-bottom: 3px solid rgb(4, 11, 28) !important;"></h6>

           
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