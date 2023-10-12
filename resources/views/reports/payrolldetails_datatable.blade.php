@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('assets/js/components/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/buttons.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables_extension_buttons_html5.js') }} "></script>
@endpush

@section('content')
    <!-- Column selectors -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">(Payroll Details)</h5>
        </div>

        <table class="table datatable-button-html5-columns">
            <thead>
                <tr>
                    <th ><b>Pay No</b></th>

                                <th  class="text-center"><b>Name</b><br>
                                </th>
                                <th  class="text-center"><b>Account Number</b><br>
                                </th>
                                <th  class="text-center"><b>Pension Number</b><br>
                                </th>
                                <th  class="text-center"><b>Department</b><br>
                                </th>
                                <th  class="text-center"><b>Cost Center</b><br>
                                </th>
                                <th  class="text-end"><b>Basic Salary</b></th>

                                <th  class="text-end"><b>Net Basic Salary</b></th>
                                <th  class="text-end"><b>Overtime</b></th>

                                <th  class="text-end"><b>Respons. Allowance</b></th>
                                <th  class="text-end"><b>House Allowance</b></th>
                                <th  class="text-end"><b>Arrears</b></th>
                                <th  class="text-end"><b>Other Payment</b></th>
                                <th  class="text-end"><b>Gross Salary</b></th>
                                <th  class="text-end"><b>Tax Benefit</b></th>
                                <th  class="text-end"><b>Taxable Gross</b></th>
                                <th  class="text-end"><b>PAYE</b></th>


                                <th  class="text-end"><b>NSSF Employee</b></th>
                                <th  class="text-end"><b>NSSF Employer</b></th>
                                <th  class="text-end"><b>NSSF Payable</b></th>
                                <th  class="text-end"><b>SDL</b></th>
                                <th  class="text-end"><b>WCF</b></th>
                                <th  class="text-end"><b>Loan Board</b></th>
                                <th  class="text-end"><b>Advance/Others</b></th>
                                <th  class="text-end"><b>Total Deduction</b></th>
                                <th  class="text-end"><b>Amount Payable</b></th>


                </tr>
            </thead>
            <tbody>
                <?php
                            $i =0;
                            if(!empty($summary)){
                                $total_loans = 0;
                                $others = 0;
                                $totalsdl=0;
                                $totalwcf=0;
                                $total_actual_salary = 0;
                                $total_teller_allowance = 0;
                                $total_taxable_amount = 0;
                                $total_gross_salary = 0;
                                $total_taxs = 0;
                                $total_salary = 0; $total_netpay = 0; $total_allowance = 0; $total_arrears = 0; $total_overtime = 0; $total_house_rent = 0; $total_sdl = 0; $total_wcf = 0;
                                $total_tax = 0; $total_pension = 0; $total_others = 0; $total_deduction = 0; $total_gross_salary = 0; $taxable_amount = 0;
                            foreach ($summary as $row){
                                $i++;
                                $amount = $row->salary + $row->allowances-$row->pension_employer-$row->loans-$row->deductions-$row->taxdue;
                                $total_netpay +=  round($amount,2);

                                $total_gross_salary +=round( ($row->salary + $row->allowances),2);
                                $total_salary = round($total_salary + $row->salary,2);
                                $total_allowance = round($total_allowance + $row->allowances,2) ;
                                $total_overtime = round($total_overtime +$row->overtime,2);
                                $total_arrears = round($total_arrears + $row->arrears_allowance,2);
                                $total_house_rent = round($total_house_rent + $row->house_rent,2);
                                $total_others +=  round($row->other_payments,2) ;
                                $total_taxs += round($row->taxdue,2);

                                $total_pension = round($total_pension + $row->pension_employer,2);
                                $total_deduction += round(($row->salary + $row->allowances)-$amount,2);
                                $total_sdl = round($total_sdl + $row->sdl,2);
                                $total_wcf = round($total_wcf + $row->wcf,2);
                                $total_taxable_amount += round($row->salary + $row->allowances-$row->pension_employer,2);
                                $total_loans = round($total_loans + $row->total_loans,2);
                                $total_teller_allowance += round($row->teller_allowance,2);

                                $total_actual_salary += round($row->actual_salary,2);
                                $others += round($row->deductions,2);
                                $totalsdl  += round($row->sdl,2);
                                    $totalwcf  += round($row->wcf,2);


                            ?>

                            <tr>

                                <td class="text-end">{{ $row->emp_id }}</td>

                                <td class="" style="margin-right: 0px" colspan="">{{ $row->fname }} {{ $row->mname }} {{ $row->lname }}
                                </td>
                                <td class="" style="margin-right: 0px" colspan="">{{ $row->account_no }}
                                </td>
                                <td class="" style="margin-right: 0px" colspan="">{{ $row->pf_membership_no }}
                                </td>
                                <td class="" style="margin-right: 0px" colspan="">{{ $row->name}}
                                </td>
                                <td class="" style="margin-right: 0px" colspan="">{{ $row->costCenterName}}
                                </td>

                                <td class="text-end">{{ number_format($row->actual_salary, 2) }}</td>
                                <td class="text-end">{{ number_format($row->salary, 2) }}</td>

                                <td class="text-end">{{ number_format($row->overtime, 2) }}</td>


                                <td class="text-end">{{ number_format($row->teller_allowance, 2) }}</td>
                                <td class="text-end">{{ number_format($row->house_rent, 2) }}</td>

                                <td class="text-end">{{ number_format($row->arrears_allowance, 2) }}</td>

                                <td class="text-end">{{ number_format($row->other_payments, 2) }}</td>

                                <td class="text-end">{{ number_format($row->salary + $row->allowances, 2) }}
                                </td>
                                <td class="text-end">{{ number_format(0, 2) }}</td>
                                <td class="text-end">
                                    {{ number_format($row->salary + $row->allowances - $row->pension_employer, 2) }}
                                </td>
                                <td class="text-end">{{ number_format($row->taxdue, 2) }}</td>

                                <td class="text-end">{{ number_format($row->pension_employer, 2) }}</td>
                                <td class="text-end">{{ number_format($row->pension_employer, 2) }}</td>
                                <td class="text-end">{{ number_format($row->pension_employer*2, 2) }}</td>
                                <td class="text-end">{{ number_format($row->sdl, 2) }}</td>
                                <td class="text-end">{{ number_format($row->wcf, 2) }}</td>
                                <td class="text-end">{{ number_format($row->loans, 2) }}</td>

                                <td class="text-end">{{ number_format($row->deductions, 2) }}</td>

                                <td class="text-end">


                                    {{ number_format($row->salary + $row->allowances - $amount, 2) }}
                                </td>
                                <td class="text-end">{{ number_format($amount, 2) }}</td>


                            </tr>

                            <?php } ?>
                            @foreach ($termination as $row2)
                            @if ($row2->taxable != 0)
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="">{{ $row2->emp_id }}</td>


                                    <td class="" style="margin-right: 0px" colspan="">{{ $row2->fname }} {{ $row2->mname }} {{ $row2->lname }}
                                    </td>
                                    <td class="" style="margin-right: 0px" colspan="">{{ $row2->account_no }}
                                    </td>
                                    <td class="" style="margin-right: 0px" colspan="">{{ $row2->pf_membership_no }}
                                    </td>
                                    <td class="" style="margin-right: 0px" colspan="">{{ $row2->name}}
                                    </td>
                                    <td class="" style="margin-right: 0px" colspan="">{{ $row2->costCenterName}}



                                    <td class="text-end">{{ number_format($row2->actual_salary, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format($row2->salaryEnrollment, 2) }}
                                    </td>

                                    <td class="text-end">{{ number_format(($row2->normal_days_overtime_amount+$row2->public_overtime_amount), 2) }}</td>



                                    <td class="text-end">{{ number_format($row2->tellerAllowance, 2) }}</td>
                                    <td class="text-end">{{ number_format($row2->houseAllowance, 2) }}</td>

                                    <td class="text-end">{{ number_format(0, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row2->leavePay + $row2->leaveAllowance+$row2->transport_allowance+$row2->nightshift_allowance, 2) }}
                                    </td>
                                    @php $gros = $row2->salaryEnrollment + $row2->leaveAllowance + $row2->leavePay+$row2->normal_days_overtime_amount+$row2->public_overtime_amount;  @endphp
                                    <td class="text-end">
                                        {{ number_format($row2->total_gross, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format(0, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($row2->taxable, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format($row2->paye, 2) }}</td>

                                    <td class="text-end">{{ number_format($row2->pension_employee, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format($row2->pension_employee, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format($row2->pension_employee*2, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format($row2->sdl, 2) }}</td>
                                    <td class="text-end">{{ number_format($row2->wcf, 2) }}</td>
                                    <td class="text-end">{{ number_format(0, 2) }}</td>
                                    <td class="text-end">{{ number_format($row2->loan_balance+$row2->otherDeductions, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($row2->pension_employee + $row2->paye + $row2->otherDeductions, 2) }}
                                    </td>
                                    <td class="text-end">{{ number_format(0, 2) }}</td>


                                </tr>
                                @php
                                $total_actual_salary += round($row2->actual_salary,2);
                                    $others += round($row2->loan_balance,2);
                                    $total_salary += round($row2->salaryEnrollment,2);
                                    $total_overtime +=round(($row2->normal_days_overtime_amount+$row2->public_overtime_amount),2);

                                    $total_others += round($row2->leavePay + $row2->leaveAllowance+$row2->transport_allowance+$row2->nightshift_allowance,2);
                                    $total_taxable_amount += round($row2->taxable,2);
                                    $total_taxs += round($row2->paye,2);
                                    //$total_netpay += ($row2->taxable -$row2->paye);
                                    $total_deduction += round($row2->pension_employee + $row2->paye + $row2->otherDeductions,2);
                                    $total_pension += round($row2->pension_employee,2);
                                    $total_gross_salary += round($row2->total_gross,2);

                                    $totalsdl  += round($row2->sdl,2);
                                    $totalwcf  += round($row2->wcf,2);




                                @endphp
                            @endif
                        @endforeach
                            <tfoot>
                            <tr style="font-size:10px; !important; border:3px solid rgb(9, 5, 64)">

                                {{-- <td></td>
                                <td></td> --}}
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td>
                                        <b>
                                            <center><b>TOTAL<b></center>
                                            </b></td>
                                <td class="text-end"><b><b>{{ number_format($total_actual_salary, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($total_salary, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($total_overtime, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($total_teller_allowance, 2) }}</b></b>
                                </td>

                                <td class="text-end"><b><b>{{ number_format($total_house_rent, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($total_arrears, 2) }}<b></b></td>
                                <td class="text-end"><b><b>{{ number_format($total_others, 2) }}</b></b></td>

                                <td class="text-end">
                                    <b><b>{{ number_format($total_gross_salary, 2) }}</b></b>
                                </td>

                                <td class="text-end"><b><b> {{ number_format(0, 2) }}</b></b></td>
                                <td class="text-end">
                                    <b><b>{{ number_format($total_gross_salary - $total_pension, 2) }}</b></b>
                                </td>

                                <td class="text-end"><b><b>{{ number_format($total_taxs, 2) }}</b></b></td>

                                <td class="text-end"><b><b>{{ number_format($total_pension, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($total_pension, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($total_pension*2, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($totalsdl, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($totalwcf, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($total_loans, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($others, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($total_deduction, 2) }}</b></b></td>
                                <td class="text-end"><b><b>{{ number_format($total_netpay, 2) }}</b></b></td>

                            </tr>
                        </tfoot>

                            <?php } ?>
        </table>
    </div>


    <!-- /column selectors -->
@endsection
