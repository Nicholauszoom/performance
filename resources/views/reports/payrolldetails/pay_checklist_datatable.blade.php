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

        @php

        $payNo_col = "";
        $name_col = "";
        $bank_col="";
        $branchCode_col="";
        $accountNumber_col = "d-none";
        $pensionNumber_col = "d-none";
        $currency_col="";
        $department_col = "d-none";
        $costCenter_col = "d-none";
        $basicSalary_col = "d-none";
        $netBasic_col = "d-none";
        $overtime_col = "d-none";
        $grossSalary_col = "d-none";
        $taxBenefit_col = "d-none";
        $taxableGross_col = "d-none";
        $paye_col = "d-none";
        $nssfEmployee_col = "d-none";
        $nssfEmployer_col = "d-none";
        $nssfPayable_col = "d-none";
        $sdl_col = "d-none";
        $wcf_col = "d-none";
        $loanBoard_col = "d-none";
        $advanceOthers_col = "d-none";
        $totalDeduction_col = "d-none";
        $amountPayable_col = "";
        $colspan_col = "5";

        @endphp
        @include('reports.payrolldetails.payroll_details_calculation')

        </table>
    </div>


    <!-- /column selectors -->
@endsection
