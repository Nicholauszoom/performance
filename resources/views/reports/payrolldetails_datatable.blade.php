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

                    <th scope="col"><b>Pay No</b></th>
                    <th scope="col"><b>Name</b></th>
                    <th scope="col" class="text-end"><b>Monthly Basic Salary</b></th>
                    <th scope="col" class="text-end"><b>Overtime</b></th>
                    <th scope="col" class="text-end"><b>Allowance</b></th>

                    <th scope="col" class="text-end"><b>Utility</b></th>
                    <th scope="col" class="text-end"><b>House Allowance</b></th>
                    <th scope="col" class="text-end"><b>Areas</b></th>
                    <th scope="col" class="text-end"><b>Other Payments</b></th>
                    <th scope="col" class="text-end"><b>Gross Salary</b></th>
                    <th scope="col" class="text-end"><b>Tax Benefit</b></th>
                    <th scope="col" class="text-end"><b>Taxable Gross</b></th>
                    <th scope="col" class="text-end"><b>PAYE</b></th>
                    <th scope="col" class="text-end"><b>SDL</b></th>
                    <th scope="col" class="text-end"><b>WCF</b></th>

                    <th scope="col" class="text-end"><b>NSSF</b></th>
                    <th scope="col" class="text-end"><b>Loan Board</b></th>
                    <th scope="col" class="text-end"><b>Total Deduction</b></th>
                    <th scope="col" class="text-end"><b>Amount Payable</b></th>

                </tr>
            </thead>
            <tbody>
                <?php
                                $i =0;
                                if(!empty($summary)){
                                    $total_loans = 0;
                                    $total_taxable_amount = 0;
                                    $total_taxs = 0;
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
                                    $total_taxs += $row->taxdue ;
                                    $total_pension = $total_pension + $row->pension_employer;
                                    $total_deduction = $total_deduction + ($row->salary + $row->allowances)-$amount;
                                    $total_sdl = $total_sdl + $row->sdl;
                                    $total_wcf = $total_wcf + $row->wcf;
                                    $total_taxable_amount += ($row->salary + $row->allowances-$row->pension_employer);
                                    $total_loans = $total_loans + $row->total_loans;

                                ?>
                <tr>

                    <td class=""><b>{{ $row->emp_id }}</b></td>

                    <td class=""><b>{{ $row->fname }} {{ $row->mname }}
                            {{ $row->lname }}</b></td>
                    <td class="text-end"><b>{{ number_format($row->salary, 2) }}</b></td>
                    {{-- <td class="text-end"><b>{{ number_format($row->allowance_id =="Overtime"? $row->allowance_amount:0 }}</b></td> --}}
                    <td class="text-end"><b>{{ number_format($row->overtime, 2) }}</b></td>

                    <td class="text-end"><b>{{ number_format($row->allowances, 2) }}</b></td>

                    <td class="text-end"><b>{{ number_format(0, 2) }}</b></td>
                    <td class="text-end"><b>{{ number_format($row->house_rent, 2) }}</b></td>

                    <td class="text-end"><b>{{ number_format(0, 2) }}<b></td>

                    <td class="text-end"><b>{{ number_format($row->other_payments, 2) }}</b></td>

                    <td class="text-end"><b>{{ number_format($row->salary + $row->allowances, 2) }}</b></td>
                    <td class="text-end"><b>{{ number_format(0, 2) }}</b></td>
                    <td class="text-end">
                        <b>{{ number_format($row->salary + $row->allowances - $row->pension_employer, 2) }}</b>
                    </td>
                    <td class="text-end"><b>{{ number_format($row->taxdue, 2) }}</b></td>
                    <td class="text-end"><b>{{ number_format($row->sdl, 2) }}</b></td>
                    <td class="text-end"><b>{{ number_format($row->wcf, 2) }}</b></td>
                    <td class="text-end"><b>{{ number_format($row->pension_employer * 2, 2) }}</b></td>
                    <td class="text-end"><b>{{ number_format($row->loans, 2) }}</b></td>
                    <td class="text-end"><b>{{ number_format($row->salary + $row->allowances - $amount, 2) }}</b></td>
                    <td class="text-end"><b>{{ number_format($amount, 2) }}</b></td>


                </tr>

                <?php } ?>



            </tbody>
            <tfoot>
                <tr style="">

                    <th></th>
                    <th class=""><b>
                            <b>TOTAL</b><b></th>
                    <th class="text-end"><b><b>{{ number_format($total_salary, 2) }}</b></b></th>
                    <th class="text-end"><b><b>{{ number_format($total_overtime, 2) }}</b></b></th>
                    <th class="text-end"><b><b>{{ number_format($total_allowance, 2) }}</b></b></th>
                    <th class="text-end"><b><b>{{ number_format(0, 2) }}</b></b></th>

                    <th class="text-end"><b><b>{{ number_format($total_house_rent, 2) }}</b></b></th>
                    <th class="text-end"><b><b>{{ number_format(0, 2) }}<b></b></th>
                    <th class="text-end"><b><b>{{ number_format($total_others, 2) }}</b></b></th>
                    <th class="text-end"><b><b>{{ number_format($total_gross_salary, 2) }}</b></b></th>
                    <th class="text-end"><b><b> {{ number_format(0, 2) }}</b></b></th>
                    <th class="text-end"><b><b>{{ number_format($total_taxable_amount, 2) }}</b></b></th>

                    <th class="text-end"><b><b>{{ number_format($total_taxs, 2) }}</b></b></th>
                    <th class="text-end"><b><b>{{ number_format($total_sdl, 2) }}</b></b></th>
                    <th class="text-end"><b><b>{{ number_format($total_wcf, 2) }}</b></b></th>

                    <th class="text-end"><b><b>{{ number_format($total_pension * 2, 2) }}</b></b></th>
                    <th class="text-end"><b><b>{{ number_format($total_loans, 2) }}</b></b></th>
                    <th class="text-end"><b><b>{{ number_format($total_deduction, 2) }}</b></b></th>
                    <th class="text-end"><b><b>{{ number_format($total_netpay, 2) }}</b></b></th>

                </tr>
            </tfoot>
            <?php } ?>
        </table>
    </div>


    <!-- /column selectors -->
@endsection
