
 <h3 class="me-4 text-center">Payroll Review For : {{ date('F, Y',strtotime($payrollMonth)) }}</h3>
 <div class="d-flex">
    @if($payrollState != 1)
    <a href="{{route('reports.get_reconsiliation_summary',['payrolldate'=>$payrollMonth])}}" target="blank">
        <button type="button" name="print" value="print" class="btn btn-main btn-sm"> Reconsiliation</button>
    </a>
    @else
    <a href="{{route('reports.get_reconsiliation_summary1',['payrolldate'=>$payrollMonth])}}" target="blank">
        <button type="button" name="print" value="print" class="btn btn-main btn-sm"> Reconsiliation</button>
    </a>
@endif
     {{-- payroll summary button 1--}}
     @if($payrollState != 1)
     @can('download-summary')
     <a class="ms-3" href="{{route('reports.get_payroll_temp_summary',['date'=>$payrollMonth,'type'=>1])}}" target="blank">
         <button type="button" name="print" value="print" class="btn btn-main btn-sm"> Payroll Summary</button>
     </a>
     @endcan
     @endif


     @if($payrollState != 1)
     @can('download-summary')
     <a class="ms-3" href="{{ route('reports.payrollReportLogs',['payrolldate'=>$payrollMonth,'type'=>2,'payrollState'=>2]) }}" target="blank">
         <button type="button" name="print" value="print" class="btn btn-main btn-sm">
             Payroll Changes
         </button>
     </a>
     <a class="ms-3" href="{{ route('reports.payroll_inputs',['date'=>$payrollMonth,'type'=>1,'nature'=>1]) }}" target="blank">
         <button type="button" name="print" value="print" class="btn btn-main btn-sm">
             Payroll Inputs
         </button>
     </a>

     <a href="javascript:void(0)" onclick="generate_checklist()" class="ms-3">
        <button type="button" class="btn btn-main">Perform Calculation </button>
    </a>
    <a href="{{route('payroll.cancelpayroll','none')}}" class="ms-3">
        <button type="button" class="btn btn-warning">Cancel Payroll </button>
    </a>
     @endcan
     @endif
     {{-- / --}}

     @if($payrollState == 1)
     <a class="ms-3" href="{{route('reports.payroll_report',['pdate'=>base64_encode($payrollMonth)])}}>" target="blank">
        <button type="button" name="print" value="print" class="btn btn-main"> Export</button>
    </a>
     <a class="ms-3" href="{{ route('reports.payrollReportLogs',['payrolldate'=>$payrollMonth,'type'=>2]) }}" target="blank">
        <button type="button" name="print" value="print" class="btn btn-main btn-sm">
            Payroll Changes
        </button>
    </a>
    <a class="ms-3" href="{{ route('reports.payroll_inputs',['date'=>$payrollMonth,'type'=>1,'nature'=>2]) }}" target="blank">
        <button type="button" name="print" value="print" class="btn btn-main btn-sm">
            Payroll Inputs
        </button>
    </a>
    <a class="ms-3" href="{{ route('flex.financial_reports') }}" target="blank">
        <button type="button" name="print" value="print" class="btn btn-main btn-sm">
            Other Reports
        </button>
    </a>
     <a class="px-4" href="{{route('reports.payroll_report1',['pdate'=>base64_encode($payrollMonth)])}}>" target="blank">
         <button type="button" name="print" value="print" class="btn btn-main"> <i class="ph-download-simple me-2"></i> Pay Checklist</button>
     </a>
     @can('download-summary')
     @if($payrollState == 0)
     <a class="px-4" href="{{route('reports.get_payroll_temp_summary1',$payrollMonth)}}" target="blank">
         <button type="button" name="print" value="print" class="btn btn-main"> Payroll Summary</button>
     </a>
     @endif
     @endcan
     @endif
 </div>
