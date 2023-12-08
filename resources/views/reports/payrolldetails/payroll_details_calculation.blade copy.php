                <thead style="font-size:8px;">
                    <tr class="hdr" style="border-bottom:2px solid rgb(9, 5, 64);">

                        <th class=" {{ $payNo_col }} " ><b>Pay No</b></th>

                        <th class=" {{ $name_col }} text-center" colspan="2" style="margin-bottom: 30px;"><b>Name</b><br>
                        </th>

                        <th class=" {{ $bank_col }} text-center" colspan="" style="margin-bottom: 30px;"><b>Bank</b><br>
                        </th>
                        <th class=" {{ $branchCode_col }} text-center" style="margin-bottom: 30px;"><b>Branch Code</b><br>
                        </th>

                        <th class=" {{ $accountNumber_col }} text-center" style="margin-bottom: 30px;"><b>Account Number</b><br>
                        </th>

                        <th class=" {{ $pensionNumber_col }} text-center" style="margin-bottom: 30px;"><b>Pension Number</b><br>
                        </th>

                        <th class=" {{ $currency_col }} text-center" style="margin-bottom: 30px;"><b>Currency</b><br>
                        </th>
                        <th class=" {{ $department_col }} text-center" style="margin-bottom: 30px;"><b>Department</b><br>
                        </th>
                        <th class=" {{ $costCenter_col }} text-center" style="margin-bottom: 30px;"><b>Cost Center</b><br>
                        </th>
                        <th class=" {{ $basicSalary_col }} text-end" style="margin-bottom: 30px;"><b>Basic Salary</b></th>

                        <th class=" {{ $netBasic_col }} text-end" style="margin-bottom: 30px;"><b>Net Basic Salary</b></th>

                        <th class=" {{ $overtime_col }} text-end" style="margin-bottom: 30px;"><b>Overtime</b></th>

                        @foreach($allowance_categories as $row)
                        <th class="text-end" style="margin-bottom: 30px;" style="margin-bottom: 30px;"><b>{{ $row->name}}</b></th>
                        @endforeach
                        <th class=" {{ $otherPayments_col }} text-end" style="margin-bottom: 30px;"><b>Other Payments</b></th>

                        <th class=" {{ $grossSalary_col }} text-end" style="margin-bottom: 30px;"><b>Gross Salary</b></th>
                        <th class=" {{ $taxBenefit_col }} text-end" style="margin-bottom: 30px;"><b>Tax Benefit</b></th>
                        <th class=" {{ $taxableGross_col }} text-end" style="margin-bottom: 30px;"><b>Taxable Gross</b></th>
                        <th class=" {{ $paye_col }} text-end" style="margin-bottom: 30px;"><b>PAYE</b></th>
                        <th class=" {{ $nssfEmployee_col }} text-end" style="margin-bottom: 30px;"><b>NSSF Employee</b></th>
                        <th class=" {{ $nssfEmployer_col }} text-end" style="margin-bottom: 30px;"><b>NSSF Employer</b></th>
                        <th class=" {{ $nssfPayable_col }} text-end" style="margin-bottom: 30px;"><b>NSSF Payable</b></th>
                        <th class=" {{ $sdl_col }} text-end" style="margin-bottom: 30px;"><b>SDL</b></th>
                        <th class=" {{ $wcf_col }} text-end" style="margin-bottom: 30px;"><b>WCF</b></th>
                        <th class=" {{ $loanBoard_col }} text-end" style="margin-bottom: 30px;"><b>Loan Board</b></th>
                        <th class=" {{ $advanceOthers_col }} text-end" style="margin-bottom: 30px;"><b>Advance/Others</b></th>
                        <th class=" {{ $totalDeduction_col }} text-end" style="margin-bottom: 30px;"><b>Total Deduction</b></th>
                        <th class=" {{ $amountPayable_col }} text-end" style="margin-bottom: 30px;"><b>Amount Payable</b></th>

                    </tr>
                </thead>
                <tbody>


                    <?php
                    $i = 0;
                    if (!empty($summary)) {
                        $total_loans = 0;
                        $others = 0;
                        $totalsdl = 0;
                        $totalwcf = 0;
                        $total_actual_salary = 0;
                        $total_teller_allowance = 0;
                        $total_taxable_amount = 0;
                        $total_gross_salary = 0;
                        $total_taxs = 0;
                        $total_salary = 0;
                        $total_netpay = 0;
                        $total_allowance = 0;
                        $total_arrears = 0;
                        $total_overtime = 0;
                        $total_house_rent = 0;
                        $total_sdl = 0;
                        $total_wcf = 0;
                        $total_tax = 0;
                        $total_pension = 0;
                        $total_others_normal = 0;
                        $total_others_term = 0;
                        $total_deduction = 0;
                        $total_gross_salary = 0;
                        $taxable_amount = 0;
                        foreach($allowance_categories as $category){



                                $category_id="category".$category->id;

                                $categories_total["category".$category->id]=0;


                        }
                        foreach ($summary as $row) {
                            $i++;
                            $amount = $row->salary + $row->allowances - $row->pension_employer - $row->loans - $row->deductions - $row->taxdue;
                            $total_netpay +=  round($amount, 2);

                            $total_gross_salary += round(($row->salary + $row->allowances), 2);
                            $total_salary = round($total_salary + $row->salary, 2);
                            $total_allowance = round($total_allowance + $row->allowances, 2);
                            $total_overtime = round($total_overtime + $row->overtime, 2);
                            $total_arrears = round($total_arrears + $row->arrears_allowance, 2);
                            // $total_house_rent = round($total_house_rent + $row->house_rent,2);
                            $total_others_normal +=  round($row->other_payments, 2);
                            $total_taxs += round($row->taxdue, 2);

                            $total_pension = round($total_pension + $row->pension_employer, 2);
                            $total_deduction += round(($row->salary + $row->allowances) - $amount, 2);
                            $total_sdl = round($total_sdl + $row->sdl, 2);
                            $total_wcf = round($total_wcf + $row->wcf, 2);
                            $total_taxable_amount += round($row->salary + $row->allowances - $row->pension_employer, 2);
                            $total_loans = round($total_loans + $row->total_loans, 2);
                            // $total_teller_allowance += round($row->teller_allowance,2);

                            $total_actual_salary += round($row->actual_salary, 2);
                            $others += round($row->deductions, 2);
                            $totalsdl  += round($row->sdl, 2);
                            $totalwcf  += round($row->wcf, 2);


                    ?>

                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class=" {{ $payNo_col }} text-end">{{ $row->emp_id }}</td>

                                <td class=" {{ $name_col }} " style="margin-right: 0px" colspan="">{{ $row->fname }}
                                </td>
                                <td class=" {{ $name_col }} " style="margin-right: 0px" colspan=""> {{ $row->lname }}
                                </td>
                                <td class=" {{$bank_col }} " style="margin-right: 0px" colspan="">{{ $row->bank_name }}
                                </td>
                                <td class=" {{$branchCode_col }} " style="margin-right: 0px" colspan="">{{ $row->branch_code }}
                                </td>
                                <td class=" {{ $accountNumber_col }} " style="margin-right: 0px" colspan="">{{ $row->account_no }}
                                </td>
                                <td class=" {{ $pensionNumber_col }} " style="margin-right: 0px" colspan="">{{ $row->pf_membership_no }}
                                </td>
                                <td class=" {{$currency_col }} " style="margin-right: 0px" colspan="">{{ $row->currency}}
                                </td>
                                <td class=" {{ $department_col }} " style="margin-right: 0px" colspan="">{{ $row->name}}
                                </td>
                                <td class=" {{ $costCenter_col }} " style="margin-right: 0px" colspan="">{{ $row->costCenterName}}
                                </td>

                                <td class=" {{ $basicSalary_col }} text-end">{{ number_format($row->actual_salary, 2) }}</td>
                                <td class=" {{ $netBasic_col }} text-end">{{ number_format($row->salary, 2) }}</td>

                                <td class=" {{ $overtime_col }} text-end">{{ number_format($row->overtime, 2) }}</td>


                                @foreach($allowance_categories as $category)

                                @php

                                $category_id="category".$category->id;

                                $categories_total["category".$category->id]+= round($row->$category_id,2);


                                @endphp

                                <td class="text-end">{{ number_format($row->$category_id, 2) }}</td>

                                @endforeach
                                <td class=" {{ $otherPayments_col }} text-end">{{ number_format($row->other_payments,2) }}
                                </td>

                                <td class=" {{ $grossSalary_col }} text-end">{{ number_format($row->salary + $row->allowances, 2) }}
                                </td>
                                <td class=" {{ $taxBenefit_col }} text-end">{{ number_format(0, 2) }}</td>
                                <td class=" {{ $taxableGross_col }} text-end">
                                    {{ number_format($row->salary + $row->allowances - $row->pension_employer, 2) }}
                                </td>
                                <td class=" {{ $paye_col }} text-end">{{ number_format($row->taxdue, 2) }}</td>

                                <td class=" {{ $nssfEmployee_col }} text-end">{{ number_format($row->pension_employer, 2) }}</td>
                                <td class=" {{ $nssfEmployer_col }} text-end">{{ number_format($row->pension_employer, 2) }}</td>
                                <td class=" {{ $nssfPayable_col }} text-end">{{ number_format($row->pension_employer*2, 2) }}</td>
                                <td class=" {{ $sdl_col }} text-end">{{ number_format($row->sdl, 2) }}</td>
                                <td class=" {{ $wcf_col }} text-end">{{ number_format($row->wcf, 2) }}</td>
                                <td class=" {{ $loanBoard_col }} text-end">{{ number_format($row->loans, 2) }}</td>

                                <td class=" {{ $advanceOthers_col }} text-end">{{ number_format($row->deductions, 2) }}</td>

                                <td class=" {{ $totalDeduction_col }} text-end">


                                    {{ number_format($row->salary + $row->allowances - $amount, 2) }}
                                </td>
                                <td class=" {{ $amountPayable_col }} text-end">{{ number_format($amount, 2) }}</td>


                            </tr>

                        <?php } ?>

                        @if($show_terminations)
                        @foreach ($termination as $row2)
                        @if ($row2->taxable != 0)
                        <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                            <td class=" {{$payNo_col }} ">{{ $row2->emp_id }}</td>


                            <td class=" {{ $name_col }} " style="margin-right: 0px" colspan="">{{ $row->fname }}
                            </td>
                            <td class=" {{ $name_col }} " style="margin-right: 0px" colspan=""> {{ $row->lname }}
                            </td>
                            <td class=" {{$bank_col }} " style="margin-right: 0px" colspan="">
                            </td>
                            <td class=" {{$branchCode_col }} " style="margin-right: 0px" colspan="">
                            </td>
                            <td class=" {{$accountNumber_col }} " style="margin-right: 0px" colspan="">{{ $row2->account_no }}
                            </td>
                            <td class=" {{$pensionNumber_col }} " style="margin-right: 0px" colspan="">{{ $row2->pf_membership_no }}
                            </td>
                            <td class=" {{$currency_col }} " style="margin-right: 0px" colspan="">
                            </td>
                             <td class=" {{$department_col }} " style="margin-right: 0px" colspan="">{{ $row2->name}}
                            </td>
                            <td class=" {{$costCenter_col }} " style="margin-right: 0px" colspan="">{{ $row2->costCenterName}}
                            </td>


                            <td class=" {{$basicSalary_col }} text-end">{{ number_format($row2->actual_salary, 2) }}
                            </td>
                            <td class=" {{$netBasic_col }} text-end">{{ number_format($row2->salaryEnrollment, 2) }}
                            </td>

                            <td class=" {{$overtime_col }} text-end">{{ number_format(($row2->normal_days_overtime_amount+$row2->public_overtime_amount), 2) }}</td>


                            @foreach($allowance_categories as $category)

                                @php

                                $category_id="category".$category->id;


                                @endphp

                                <td class="text-end">{{ number_format(0, 2) }}</td>

                            @endforeach

                            <td classs="text-end">
                                {{ number_format($row2->leavePay + $row2->leaveAllowance+$row2->transport_allowance+$row2->nightshift_allowance, 2) }}
                            </td>
                            @php $gros = $row2->salaryEnrollment + $row2->leaveAllowance + $row2->leavePay+$row2->normal_days_overtime_amount+$row2->public_overtime_amount; @endphp
                            <td class=" {{$grossSalary_col }} text-end">
                                {{ number_format($row2->total_gross, 2) }}
                            </td>
                            <td class=" {{$taxBenefit_col }} text-end">{{ number_format(0, 2) }}</td>
                            <td class=" {{$taxableGross_col }} text-end">
                                {{ number_format($row2->taxable, 2) }}
                            </td>
                            <td class=" {{$paye_col }} text-end">{{ number_format($row2->paye, 2) }}</td>

                            <td class=" {{$nssfEmployee_col }} text-end">{{ number_format($row2->pension_employee, 2) }}
                            </td>
                            <td class=" {{$nssfEmployer_col }} text-end">{{ number_format($row2->pension_employee, 2) }}
                            </td>
                            <td class=" {{$nssfPayable_col }} text-end">{{ number_format($row2->pension_employee*2, 2) }}
                            </td>
                            <td class=" {{$sdl_col }} text-end">{{ number_format($row2->sdl, 2) }}</td>
                            <td class=" {{$wcf_col }} text-end">{{ number_format($row2->wcf, 2) }}</td>
                            <td class=" {{$loanBoard_col }} text-end">{{ number_format(0, 2) }}</td>
                            <td class=" {{$advanceOthers_col }} text-end">{{ number_format($row2->loan_balance+$row2->otherDeductions, 2) }}</td>
                            <td class=" {{$totalDeduction_col }} text-end">
                                {{ number_format($row2->pension_employee + $row2->paye + $row2->otherDeductions, 2) }}
                            </td>
                            <td class=" {{$amountPayable_col }} text-end">{{ number_format(0, 2) }}</td>


                        </tr>
                        @php
                        $total_actual_salary += round($row2->actual_salary,2);
                        $others += round($row2->loan_balance,2);
                        $total_salary += round($row2->salaryEnrollment,2);
                        $total_overtime +=round(($row2->normal_days_overtime_amount+$row2->public_overtime_amount),2);

                        $total_others_term += round($row2->leavePay + $row2->leaveAllowance+$row2->transport_allowance+$row2->nightshift_allowance ,2);
                        $total_taxable_amount += round($row2->taxable,2);
                        $total_taxs += round($row2->paye,2);
                        //$total_netpay += ($row2->taxable -$row2->paye);
                        $total_deduction += round($row2->pension_employee + $row2->paye + $row2->otherDeductions,2);
                        $total_pension += round($row2->pension_employee,2);
                        $total_gross_salary += round($row2->total_gross,2);

                        $totalsdl += round($row2->sdl,2);
                        $totalwcf += round($row2->wcf,2);




                        @endphp
                        @endif
                        @endforeach

                        @endif
                <tfoot>
                    <tr style="font-size:10px; !important; border:3px solid rgb(9, 5, 64)">
                        <td colspan="{{ $colspan_col }}"><b>
                                <center><b>TOTAL<b></center>
                            </b></td>


                        <td class=" {{ $basicSalary_col }} text-end"><b><b>{{ number_format($total_actual_salary, 2) }}</b></b></td>
                        <td class=" {{ $netBasic_col }} text-end"><b><b>{{ number_format($total_salary, 2) }}</b></b></td>
                        <td class=" {{ $overtime_col }} text-end"><b><b>{{ number_format($total_overtime, 2) }}</b></b></td>
                        @foreach($allowance_categories as $category)


                            @php
                            $category_id="category".$category->id;

                            @endphp

                            <td class=" {{ $allowanceCat_col }} text-end">
                            <b><b>{{ number_format($categories_total["category".$category->id], 2) }}</b></b>
                        </td>

                        @endforeach


                        <td class=" {{ $otherPayments_col }} text-end"><b><b>{{ number_format($total_others_term +$total_others_normal,2) }}
                        </b></b></td>

                        <td class=" {{ $grossSalary_col }} text-end">
                            <b><b>{{ number_format($total_gross_salary, 2) }}</b></b>
                        </td>

                        <td class=" {{ $taxBenefit_col }} text-end"><b><b> {{ number_format(0, 2) }}</b></b></td>
                        <td class=" {{ $taxableGross_col }} text-end">
                            <b><b>{{ number_format($total_gross_salary - $total_pension, 2) }}</b></b>
                        </td>

                        <td class=" {{ $paye_col }} text-end"><b><b>{{ number_format($total_taxs, 2) }}</b></b></td>

                        <td class=" {{ $nssfEmployee_col }} text-end"><b><b>{{ number_format($total_pension, 2) }}</b></b></td>
                        <td class=" {{ $nssfEmployer_col }} text-end"><b><b>{{ number_format($total_pension, 2) }}</b></b></td>
                        <td class=" {{ $nssfPayable_col }} text-end"><b><b>{{ number_format($total_pension*2, 2) }}</b></b></td>
                        <td class=" {{ $sdl_col }} text-end"><b><b>{{ number_format($totalsdl, 2) }}</b></b></td>
                        <td class=" {{ $wcf_col }} text-end"><b><b>{{ number_format($totalwcf, 2) }}</b></b></td>
                        <td class=" {{ $loanBoard_col }} text-end"><b><b>{{ number_format($total_loans, 2) }}</b></b></td>
                        <td class=" {{ $advanceOthers_col }} text-end"><b><b>{{ number_format($others, 2) }}</b></b></td>
                        <td class=" {{ $totalDeduction_col }} text-end"><b><b>{{ number_format($total_deduction, 2) }}</b></b></td>
                        <td class=" {{ $amountPayable_col }} text-end"><b><b>{{ number_format($total_netpay, 2) }}</b></b></td>
                    </tr>
                </tfoot>

                <?php } ?>
