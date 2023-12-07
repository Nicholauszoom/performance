@extends('layouts.vertical', ['title' => 'Payroll'])
<style> .hdr {

    font-size: 15px !important;
}
</style>
@push('head-script')
@endpush

@push('head-scriptTwo')
@endpush

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/buttons.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_extension_buttons_excel.js') }}"></script>
@endpush

@section('content')
    @php

        $payrollMonth = $payroll_date;
        $payrollState = $payroll_state;

        $total_previous = 0;
                    $total_current = 0;
                    $total_amount = 0;

    @endphp


<div class="card border-bottom-main rounded-0 border-0 shadow-none">

            @include('payroll.payroll_info_buttons')
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h4 class="me-4 text-center">Payroll Checklist</h4>
                   
                    <a href="{{ route('reports.payrolldetails', ['payrolldate' => $payroll_date, 'payrollState' => $payrollState, 'type' => 1]) }}" target="blank">
                        <button type="button" name="print" value="print" class="btn btn-main btn-sm"> PDF</button>
                    </a>
                

                <table class="table table datatable-excel-filter">

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
        $allowanceCat_col="";
        $otherPayments_col="";
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
        $colspan_col = "6";
        $show_terminations=false;

        @endphp
        @include('reports.payrolldetails.payroll_details_calculation')

        </table>
    </div>


    <!-- /column selectors -->
@endsection
