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

                                <th   class="text-center"><b>Name</b><br>
                                </th>
                                <th  class="text-end"><b>Bank</b></th>
                                <th  class="text-end"><b>BranchCode</b></th>

                                <th  class="text-end"><b>Account No</b></th>
                                <th  class="text-end"><b>Currency</b></th>

                                <th  class="text-end"><b>Net Pay</b></th>


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
                                if($row->currency == $currency){
                                $i++;
                                $amount = $row->salary + $row->allowances-$row->pension_employer-$row->loans-$row->deductions-$row->meals-$row->taxdue;
                                $total_netpay +=  round($amount/$row->rate,0);

                                $total_gross_salary += ($row->salary + $row->allowances);
                                $total_salary = $total_salary + $row->salary;
                                $total_allowance = $total_allowance + $row->allowances ;
                                $total_overtime = $total_overtime +$row->overtime;
                                $total_house_rent = $total_house_rent + $row->house_rent;
                                $total_others = $total_others + $row->other_payments ;
                                $total_taxs += round($row->taxdue,0);

                                $total_pension = $total_pension + $row->pension_employer;
                                $total_deduction += ($row->salary + $row->allowances)-$amount;
                                $total_sdl = $total_sdl + $row->sdl;
                                $total_wcf = $total_wcf + $row->wcf;
                                $total_taxable_amount += intval($row->salary + $row->allowances-$row->pension_employer);
                                $total_loans = $total_loans + $row->total_loans;
                                $total_teller_allowance += $row->teller_allowance;

                                $others += $row->deductions;


                            ?>

                            <tr>

                                <td class="text-end">{{ $row->emp_id }}</td>

                                <td  style="margin-right: 0px" >
                                    {{ $row->fname }} {{ $row->mname }} {{ $row->lname }}
                                </td>


                                <td class="text-end">{{ $row->bank_name }}</td>

                                <td class="text-end">{{ $row->branch_code }}</td>

                                <td class="text-end">{{ $row->account_no }}</td>


                                <td class="text-end">{{ $row->currency }}</td>


                                <td class="text-end">{{ number_format($amount/$row->rate, 0) }}</td>


                            </tr>

                            <?php } } ?>
            </tbody>
                            <tfoot>
                            <tr style="font-size:10px; !important; border:3px solid rgb(9, 5, 64)">

                                {{-- <td></td>
                                <td></td>
                                <td></td> --}}
                                <td colspan="7">
                                        <b>
                                            <b>TOTAL<b>
                                            </b></td>

                                <td colspan="2" class="text-end"><b><b>{{ number_format($total_netpay, 0) }}</b></b></td>

                            </tr>
                        </tfoot>

                            <?php  } ?>
        </table>
    </div>


    <!-- /column selectors -->
@endsection
