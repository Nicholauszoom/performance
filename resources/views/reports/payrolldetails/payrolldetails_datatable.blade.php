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
                    <h4 class="me-4 text-center">Payroll Details</h4>
                   
                    <a href="{{ route('reports.payrolldetails', ['payrolldate' => $payroll_date,'nature' => 1, 'payrollState' => $payrollState, 'type' => 1]) }}" target="blank">
                        <button type="button" name="print" value="print" class="btn btn-main btn-sm"> PDF</button>
                    </a>
                

                <table class="table table datatable-excel-filter">

                @php

                $payNo_col = "";
                $name_col = "";
                $bank_col="d-none";
                $branchCode_col="d-none";
                $accountNumber_col = "d-none";
                $pensionNumber_col = "d-none";
                $currency_col="d-none";
                $department_col = "d-none";
                $costCenter_col = "d-none";
                $basicSalary_col = "";
                $netBasic_col = "";
                $overtime_col = "";
                $allowanceCat_col="";
                $grossSalary_col = "";
                $otherPayments_col="";
                $taxBenefit_col = "";
                $taxableGross_col = "";
                $paye_col = "";
                $nssfEmployee_col = "";
                $nssfEmployer_col = "";
                $nssfPayable_col = "";
                $sdl_col = "";
                $wcf_col = "";
                $loanBoard_col = "";
                $advanceOthers_col = "";
                $totalDeduction_col = "";
                $amountPayable_col = "";
                $colspan_col = "3";
                $show_terminations=true;
                $fitler_by_currency=false;



                @endphp




            @include('reports.payrolldetails.payroll_details_calculation')

                    </table>
                </div>
            </div>


            <?php ?>

        </div>


    </div>
@endsection


@include('payroll.payroll_sripts')

