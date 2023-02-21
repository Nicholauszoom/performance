<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Details </title>
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

    <main class="mb-5">
        <div class="row my-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between" style="border-bottom: 10px solid rgb(242, 183, 75) !important; ">
                    <div>
                        <img src="{{ asset('assets/images/logo-dif2.png') }}" alt="logo here" class="image-fluid">
                    </div>
                    <div class="text-center">
                        <p style="font-weight:600">AFRICAN BANKING CORPORATION <br>P.O. BOX 31<br>DAR ES SALAAM</p>
                        <button id="printbtn" onclick="window.print()">Print this page</button>
                    </div>
                    <div>
                        <h5 class="text-end font-weight-bolder" style="font-weight:bolder;">Payroll Detail_By Number</h5>
                        <p class="text-end font-weight-bolder text-primary" style="font-weight:bolder;"> Date:
                            {{ $payroll_date }}
                        </p>
                    </div>
                </div>


                <div class="row mb-4">
                    <div class="col-md-12 col-12 mb-5 px-3">
                        <table class="table" style="font-size:9px; border:1px solid #000">
                            <thead>
                                <tr>

                                    <th scope="col" ><b>Pay No</b></th>
                                    <th scope="col" colspan="2" style="width:;" class="text-center" ><b>Name</b></th>
                                    <th scope="col" class="text-end"><b>Monthly Basic Salary</b></th>
                                    <th scope="col" class="text-end"><b>Overtime</b></th>

                                    <th scope="col" class="text-end"><b>Respons. Allowance</b></th>
                                    <th scope="col" class="text-end"><b>House Allowance</b></th>
                                    <th scope="col" class="text-end"><b>Areas</b></th>
                                    <th scope="col" class="text-end"><b>Other Payments</b></th>
                                    <th scope="col" class="text-end"><b>Gross Salary</b></th>
                                    <th scope="col" class="text-end"><b>Tax Benefit</b></th>
                                    <th scope="col" class="text-end"><b>Taxable Gross</b></th>
                                    <th scope="col" class="text-end"><b>PAYE</b></th>


                                    <th scope="col" class="text-end"><b>NSSF</b></th>
                                    <th scope="col" class="text-end"><b>Loan Board</b></th>
                                    <th scope="col" class="text-end"><b>Advance/Others</b></th>
                                    <th scope="col" class="text-end"><b>Total Deduction</b></th>
                                    <th scope="col" class="text-end"><b>Ammount Payable</b></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i =0;
                                if(!empty($summary)){
                                    $total_loans = 0;
                                    $others = 0;
                                    $total_teller_allowance = 0;
                                    $total_taxable_amount = 0;
                                    $total_gross_salary = 0;
                                    $total_taxs = 0;
                                    $total_salary = 0; $total_netpay = 0; $total_allowance = 0; $total_overtime = 0; $total_house_rent = 0; $total_sdl = 0; $total_wcf = 0;
                                    $total_tax = 0; $total_pension = 0; $total_others = 0; $total_deduction = 0; $total_gross_salary = 0; $taxable_amount = 0;
                                foreach ($summary as $row){
                                    $i++;
                                    $amount = $row->salary + $row->allowances-$row->pension_employer-$row->loans-$row->deductions-$row->meals-$row->taxdue;
                                    $total_netpay = $total_netpay +  $amount;

                                    $total_gross_salary += ($row->salary + $row->allowances);
                                    $total_salary = $total_salary + $row->salary;
                                    $total_allowance = $total_allowance + $row->allowances ;
                                    $total_overtime = $total_overtime +$row->overtime;
                                    $total_house_rent = $total_house_rent + $row->house_rent;
                                    $total_others = $total_others + $row->other_payments ;
                                    $total_taxs += $row->taxdue ;
                                    $total_pension = $total_pension + $row->pension_employer;
                                    $total_deduction = $total_deduction + ($row->salary + $row->allowances)-$amount;
                                    $total_sdl = $total_sdl + $row->sdl;
                                    $total_wcf = $total_wcf + $row->wcf;
                                    $total_taxable_amount += ($row->salary + $row->allowances-$row->pension_employer);
                                    $total_loans = $total_loans + $row->total_loans;
                                    $total_teller_allowance += $row->teller_allowance;

                                    $others += $row->deductions;


                                ?>

                                <tr >

                                    <td class=""><b>{{ $row->emp_id }}</b></td>

                                    <td class="" colspan="2"><b>{{  $row->fname }} {{ $row->lname }}</b></td>

                                    <td class="text-end"><b>{{ number_format($row->salary,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format($row->overtime,2) }}</b></td>


                                    <td class="text-end"><b>{{ number_format($row->teller_allowance,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format($row->house_rent,2) }}</b></td>

                                    <td class="text-end"><b>{{ number_format(0,2) }}<b></td>

                                    <td class="text-end"><b>{{ number_format($row->other_payments,2) }}</b></td>

                                    <td class="text-end"><b>{{ number_format($row->salary + $row->allowances,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format(0,2) }}</b></td>
                                    <td class="text-end">
                                        <b>{{ number_format($row->salary + $row->allowances - $row->pension_employer,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format($row->taxdue,2) }}</b></td>

                                    <td class="text-end"><b>{{ number_format($row->pension_employer,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format($row->loans,2) }}</b></td>

                                    <td class="text-end"><b>{{ number_format($row->deductions,2) }}</b></td>

                                    <td class="text-end"><b>{{ number_format($row->salary + $row->allowances - $amount,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format($amount,2) }}</b></td>


                                </tr>

                                <?php } ?>
                                @foreach($termination as $row2)
                                <tr >

                                    <td class=""><b>{{ $row2->emp_id }}</b></td>


                                    <td class="" colspan="2"><b>{{  $row->fname }}  {{ $row->lname }}</b></td>

                                    <td class="text-end"><b>{{ number_format($row2->salaryEnrollment,2) }}</b></td>

                                    <td class="text-end"><b>{{ number_format(0,2) }}</b></td>



                                    <td class="text-end"><b>{{ number_format(0,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format(0,2) }}</b></td>

                                    <td class="text-end"><b>{{ number_format(0,2) }}<b></td>

                                    <td class="text-end"><b>{{ number_format($row2->leavePay+$row2->leaveAllowance,2) }}</b></td>
                                     @php $gros = $row2->salaryEnrollment + $row2->leaveAllowance + $row2->leavePay;  @endphp
                                    <td class="text-end"><b>{{ number_format($row2->salaryEnrollment + $row2->leaveAllowance + $row2->leavePay,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format(0,2) }}</b></td>
                                    <td class="text-end">
                                        <b>{{ number_format($row2->taxable,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format($row2->paye,2) }}</b></td>

                                    <td class="text-end"><b>{{ number_format($row2->pension_employee,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format(0,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format($row2->loan_balance,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format($row2->pension_employee + $row2->paye + $row2->otherDeductions,2) }}</b></td>
                                    <td class="text-end"><b>{{ number_format((0),2) }}</b></td>


                                </tr>
                                @php
                                $others += $row2->loan_balance;
                                 $total_salary += $row2->salaryEnrollment;
                                 $total_others += ($row2->leavePay+$row2->leaveAllowance);
                                 $total_taxable_amount += $row2->taxable;
                                 $total_taxs += $row2->paye;
                                 //$total_netpay += ($row2->taxable -$row2->paye);
                                 $total_deduction += ($row2->pension_employee + $row2->paye + $row2->otherDeductions + $row2->loan_balance);
                                 $total_pension += $row2->pension_employee;
                                 $total_gross_salary += ($row2->total_gross);

                                // $total_gross_salary += ($row2->salaryEnrollment + $row2->leaveAllowance + $row2->leavePay);

                                @endphp
                                @endforeach
                                <tr style="font-size: 10px !important;">

                                    <td></td>
                                    <td></td>
                                    <td class=""><b>
                                    <b><center>TOTAL</center></b><b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_salary,0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_overtime,0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_teller_allowance,0) }}</b></b></td>

                                    <td class="text-end"><b><b>{{ number_format($total_house_rent,0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format(0,0) }}<b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_others,0) }}</b></b></td>

                                    <td class="text-end"><b><b>{{ number_format($total_salary+$total_overtime+$total_teller_allowance+$total_house_rent+$total_others,0) }}</b></b></td>

                                    {{-- <td class="text-end"><b><b>{{ number_format($total_gross_salary,0) }}</b></b></td> --}}
                                    <td class="text-end"><b><b> {{ number_format(0,0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_salary+$total_overtime+$total_teller_allowance+$total_house_rent+$total_others-$total_pension,2) }}</b></b></td>
                                    {{-- <td class="text-end"><b><b>{{ number_format($total_taxable_amount,2) }}</b></b></td> --}}

                                    <td class="text-end"><b><b>{{ number_format($total_taxs,2) }}</b></b></td>

                                    <td class="text-end"><b><b>{{ number_format($total_pension,0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_loans,0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($others,0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_deduction,0) }}</b></b></td>
                                    <td class="text-end"><b><b>{{ number_format($total_netpay,0) }}</b></b></td>

                                </tr>

                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br><br><br>   <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> <br><br><br><br>

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
