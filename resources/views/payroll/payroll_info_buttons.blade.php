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
                Payroll Changes
            </button>
        </a>
        <a class="ms-3"
            href="{{ route('reports.payroll_inputs', ['date' => $payroll_date, 'type' => 1, 'nature' => 1, 'payrollState' => $payrollState]) }}"
            target="blank">
            <button type="button" name="print" value="print" class="btn btn-main btn-sm">
                Payroll Inputs
            </button>
        </a>
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

        <a class="px-4" href="{{ route('reports.payrolldetails',['payrolldate' => $payroll_date,  'nature' => 2, 'payrollState' => $payrollState,'type' => 2]) }}"
            target="blank">
            <button type="button" name="print" value="print" class="btn btn-main btn-sm"> <i
                    class="ph-download-simple me-2"></i> Pay Checklist</button>
        </a>

        <a class="ms-3" href="{{ route('reports.payrolldetails',['payrolldate' => $payroll_date,  'nature' => 2, 'payrollState' => $payrollState,'type' => 1]) }}"
            target="blank">
            <button type="button" name="print" value="print" class="btn btn-main btn-sm"> Export</button>
        </a>



</div>
