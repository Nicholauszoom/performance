@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')

<style> .hdr {

font-size: 15px !important;
}
</style>
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
                    <h4 class="me-4 text-center">Payroll Reconciliation Details</h4>
                   
                    <a href="{{ route('reports.payrollReconciliationDetails', ['payrolldate' => $payroll_date,'payrollState'=>$payrollState,'type'=>1]) }}" target="blank">
                        <button type="button" name="print" value="print" class="btn btn-main btn-sm"> <i class="ph-file-pdf"></i> PDF</button>
                    </a>
                

                    @include("reports.reconciliationDetails.reconciliation_details_calculations")

                </div>
            </div>


            <?php ?>

        </div>


    </div>
@endsection


@include('payroll.payroll_sripts')

