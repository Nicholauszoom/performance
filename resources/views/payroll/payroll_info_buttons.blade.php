@if($payroll_state !=0)
<h3 class="me-4 text-center">Payroll Review For : {{ date('F, Y', strtotime($payroll_date)) }}
</h3>

@else

<h3 class="me-4 text-center">Payroll Reports For : {{ date('F, Y', strtotime($payroll_date)) }}
</h3>

@endif


<div class="d-flex justify-content-center align-items-center">
        <a
            href="{{ route('reports.payrollReconciliationSummary', ['payrolldate' => $payroll_date, 'payrollState' => $payroll_state,'type'=>2]) }}">
            <button type="button" name="print" value="print" class="btn btn-main btn-sm"> Reconciliation Summary</button>
        </a>

        <a class="ms-3"
        href="{{ route('reports.payrollReconciliationDetails', ['payrolldate' => $payroll_date, 'payrollState' => $payroll_state,'type'=>2]) }}">
        <button type="button" name="print" value="print" class="btn btn-main btn-sm"> Reconciliation details</button>
    </a>

        <a class="ms-3"
            href="{{ route('reports.payrolldetails', ['payrolldate' => $payroll_date,'nature' => 1, 'payrollState' => $payrollState, 'type' => 2]) }}"
            target="blank">
            <button type="button" name="print" value="print" class="btn btn-main btn-sm"> Payroll Details</button>
        </a>
        <a class="ms-3"
            href="{{ route('reports.payrollReportLogs', ['payrolldate' => $payroll_date, 'type' => 2, 'payrollState' => $payrollState]) }}"
            target="blank">
            <button type="button" name="print" value="print" class="btn btn-main btn-sm">
                Payroll Input Changes
            </button>
        </a>
        {{-- <a class="ms-3"
            href="{{ route('reports.payroll_inputs', ['date' => $payroll_date, 'type' => 1, 'nature' => 1, 'payrollState' => $payrollState]) }}"
            target="blank">
            <button type="button" name="print" value="print" class="btn btn-main btn-sm">
                Payroll Inputs
            </button>
        </a> --}}
        @if ($payrollState == 2)
            <a href="javascript:void(0)" onclick="generate_checklist()" class="ms-3">
                <button type="button" class="btn btn-main btn-sm" id="percal">
                    <i class="ph-circle-notch spinner me-2 d-none"></i>
                    Perform Calculation
                </button>
            </a>
            <a href="{{ route('payroll.cancelpayroll', 'none') }}" class="ms-3">
                <button type="button" class="btn btn-warning btn-sm">Cancel Payroll </button>
            </a>
        @endif

        {{-- <a class="px-4" href="{{ route('reports.payrolldetails',['payrolldate' => $payroll_date,  'nature' => 2, 'payrollState' => $payrollState,'type' => 2]) }}"
            target="blank">
            <button type="button" name="print" value="print" class="btn btn-main btn-sm"> <i
                    class="ph-download-simple me-2"></i> Pay Checklist</button>
        </a> --}}


        <div class="dropdown px-4">
            <button class="btn btn-main btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ph-download-simple me-2"></i> Pay Checklist
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('reports.payrolldetails', ['payrolldate' => $payroll_date, 'nature' => 2, 'payrollState' => $payrollState, 'type' => 2]) }}" target="blank">TZS Pay Checklist</a>
                <a class="dropdown-item" href="{{ route('reports.payrolldetails', ['payrolldate' => $payroll_date, 'nature' => 3, 'payrollState' => $payrollState, 'type' => 2]) }}" target="blank">USD Pay Checklist</a>
            </div>
        </div>

</div>
