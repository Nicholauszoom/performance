@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
@endpush

@push('head-scriptTwo')
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
                   
                    <a href="{{ route('reports.payrolldetails', ['payrolldate' => $payroll_date, 'payrollState' => $payrollState, 'type' => 1]) }}" target="blank">
                        <button type="button" name="print" value="print" class="btn btn-main btn-sm"> PDF</button>
                    </a>
                

                <table class="table datatable-basic">

                @php

                $payNo_col = "";
                $name_col = "";
                $accountNumber_col = "";
                $pensionNumber_col = "";
                $department_col = "";
                $costCenter_col = "";
                $basicSalary_col = "";
                $netBasic_col = "";
                $overtime_col = "";
                $grossSalary_col = "";
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
                $colspan_col = "6";

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

