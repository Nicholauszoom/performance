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
@php
$total_salary = 0;
$total_gross = 0;
$total_deductions = 0;
$total_taxable = 0;
$total_taxdue = 0;
@endphp
<!-- Column selectors -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">(P.A.Y.E)</h5>
        <li> <a href="{{ route('reports.p9',['payroll_date'=>$payroll_date,'type'=>1,'print_type'=>'PDF']) }}">PDF</a></li>
    </div>
    <table class="table datatable-button-html5-columns">
        <thead>
            <tr>
                <td width="50"><b>S/NO</b></td>
                <th width="180"><b>NAME OF EMPLOYEE</b></th>
                <th width="140"><b>BASIC PAY</b></th>
                <th width="140"><b>GROSS PAY</b></th>
                <th width="140"><b>DEDUCTIONS</b></th>
                <th width="140"><b>TAXABLE AMOUNT</b></th>
                <th width="140"><b>TAX DUE</b></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($paye as $key) {
                $salary = $key->salary;
                $gross = $key->salary + $key->allowances;
                $name = $key->name;
                $deductions = $key->pension_employee;
                $taxable = $key->salary + $key->allowances - $key->pension_employee;
                $taxdue = $key->taxdue;

                $total_salary += $salary;
                $total_gross += $gross;
                $total_deductions += $deductions;
                $total_taxable += $taxable;
                $total_taxdue += $taxdue;

            ?>
                <tr>
                    <td width="50">{{ $key->sNo }}</td>
                    <td align="left" width="180">{{ $name }}</td>
                    <td width="140" style="text-align: right;">{{ number_format($salary,2) }}</td>
                    <td width="140" style="text-align: right;">{{ number_format($gross,2) }}</td>
                    <td width="140" style="text-align: right;">{{ number_format($deductions,2) }}</td>
                    <td width="140" style="text-align: right;">{{ number_format($taxable,2) }}</td>
                    <td width="140" style="text-align: right;">{{ number_format($taxdue,2) }}</td>
                </tr>
            <?php } ?>

            @if(!empty($paye_termination))
            @foreach($paye_termination as $key)
            @php

            $salary = $key->salaryEnrollment;
            $gross = $key->total_gross;
            $name = $key->name;
            $deductions = $key->pension_employee;
            $taxable = $key->taxable;
            $taxdue = $key->paye;

            $total_salary +=$salary;
            $total_gross +=$gross;
            $total_deductions +=$deductions;
            $total_taxable +=$taxable;
            $total_taxdue +=$taxdue;
            @endphp
            <tr>
                <td width="50">{{ $key->sNo }}</td>
                <td align="left" width="180">{{ $name }}</td>
                <td width="140" style="text-align: right;">{{ number_format($salary,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($gross,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($deductions,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($taxable,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($taxdue,2) }}</td>
            </tr>
            @endforeach
            @endif
        <tbody>
            <tr>
                <td colspan="2">TOTAL</td>

                <td width="140" style="text-align: right;">{{ number_format($total_salary,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($total_gross,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($total_deductions,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($total_taxable,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($total_taxdue,2) }}</td>
            </tr>
        </tbody>
        <tfoot hidden>
            <tr>
                <td colspan="2">TOTAL</td>

                <td width="140" style="text-align: right;">{{ number_format($total_salary,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($total_gross,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($total_deductions,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($total_taxable,2) }}</td>
                <td width="140" style="text-align: right;">{{ number_format($total_taxdue,2) }}</td>
            </tr>
        </tfoot>
        </tbody>
    </table>
</div>
<!-- /column selectors -->
@endsection