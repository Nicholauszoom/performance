@extends('layouts.vertical', ['title' => 'Statutory Deductions'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')



<div class="card">
    <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{ url('/flex/financial_group')}}" class="nav-link "
                aria-selected="false" role="tab" tabindex="-1">
                <i class="ph-list me-2"></i>
                Packages
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ url('/flex/allowance_overtime')}}" class="nav-link " aria-selected="false" role="tab"
                tabindex="-1">
                <i class="ph-list me-2"></i>
                Overtime
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ url('/flex/allowance')}}" class="nav-link" 
                aria-selected="false" role="tab" tabindex="-1">
                <i class="ph-list me-2"></i>
                Allowance
            </a>
        </li>
    
      
        <li class="nav-item" role="presentation">
            <a href="{{ url('/flex/statutory_deductions')}}" class="nav-link active show"
                aria-selected="false" role="tab" tabindex="-1">
                <i class="ph-list me-2"></i>
                Statutory Deductions
            </a>
        </li>
        <li class="nav-item" role="presentation">
          <a href="{{ url('/flex/non_statutory_deductions')}}" class="nav-link "
              aria-selected="false" role="tab" tabindex="-1">
              <i class="ph-list me-2"></i>
              Non Statutory Deductions
          </a>
      </li>
     
    </ul>
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0">Pension Funds</h5>
        </div>
    </div>
    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Employee Amount</th>
                <th>Employer Amount</th>
                <th>Deduction From</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pension as $row)
                <tr id="{{ 'domain'.$row->id }}">
                    <td>{{ $row->SNo }}</td>
                    <td>{{ $row->name.' ('.$row->abbrv.')' }}</td>
                    <td>{{ ($row->amount_employee) * 100 .'%' }}</td>
                    <td> {{ ($row->amount_employer) * 100 .'%' }}</td>

                    <td>
                        @if ($row->deduction_from == 1)
                        <span class="badge bg-success">Basic Salary</span>
                        @else
                        <span class="badge bg-success">Gross</span>
                        @endif
                    </td>

                    <td>
                        <?php $par = $row->id. "|1" ?>
                        <a href="{{ route('flex.deduction_info', $par) }}" title="Info and Details" class="icon-2 info-tooltip">
                            <button type="button" class="btn btn-main btn-xs"><i class="ph-info"></i></button>
                        </a>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0">List of Deduction</h5>
        </div>
    </div>
    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Employee Amount(in %)</th>
                <th>Employer Amonut(in %)</th>
                @if ($pendingPayroll == 0)
                <th class="text-center">Option</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($deduction as $row)
                <tr>
                    <td>{{ $row->SNo }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ 100*($row->rate_employee) .'%' }}</td>
                    <td>{{ 100*($row->rate_employer) .'%' }}</td>

                    @if ($pendingPayroll == 0)
                    <td class="options-width">
                        <a

                            href="{{ url('/flex/common_deductions_info', $row->id) }}"  title="More Info" class="icon-2 info-tooltip">
                            <button type="button" class="btn btn-main btn-xs"><i class="ph-note-pencil"></i></button>
                        </a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0">P .A .Y .E Ranges</h5>
            <button type="button" class="btn btn-perfrom" data-bs-toggle="modal" data-bs-target="#save_department">
                <i class="ph-plus me-2"></i> Add New P.A.Y.E Range
            </button>
        </div>
    </div>

    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>S/N</th>
                    <th>Minimum Amount</th>
                    <th>Maximum Amount</th>
                    <th>Excess Added as </th>
                    <th>Rate to an Amount Excess of Minimum </th>
                    @if($pendingPayroll==0)
                    <th>Option</th>
                    @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($paye as $row)
                <tr>
                    <td>{{ $row->SNo }}</td>
                    <td>{{ number_format($row->minimum, 2) }}</td>
                    <td>{{ number_format($row->maximum, 2) }}</td>
                    <td>{{ number_format($row->excess_added, 2) }} </td>
                    <td> {{ 100 * ($row->rate) .'%' }} </td>
                    @if ( $pendingPayroll == 0 )
                    <td class="options-width">
                        <a class="tooltip-demo" data-toggle="tooltip" data-placement="top" title="Edit"  href="<?php echo url('')."/flex/paye_info/".$row->id; ?>">
                            <button type="button" class="btn btn-main btn-xs" ><i class='ph-note-pencil'></i></button>
                        </a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<div>
    <div id="save_department" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New P .A .Y .E Range</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <form autocomplete="off" id="addPAYE" enctype="multipart/form-data"  method="post"    data-parsley-validate class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <label class="form-label" for="first-name">Minimum Amount</label>
                            <input required="" type="number" min="0" max="100000000" step="1" name="minimum" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="first-name">Maximum Amount</label>
                            <input required="" type="number" min="0" max="100000000" step="1" name="maximum" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="first-name">Excess Added To an Amount Exceeding the Minimum Amount </label>
                            <input required="" type="number" min="0" max="100000000" step="1" name="excess" class="form-control">
                        </div>
                        <div class="mb-3">
                             <label class="form-label mb" for="first-name">Percentage Contribution to Amount that Exceed the Minimum Amount</label>
                            <input required="" type="number" min="0" max="99" step="1" name="rate" class="form-control">
                        </div>
                        <!-- END -->
                        <div class="mb-3">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button  class="btn btn-main">ADD</button>
                          </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-script')
<script type="text/javascript">
    $('#addPAYE').submit(function(e){
        e.preventDefault(); // Prevent Default Submission

        $.ajax({
            url: '{{ url("/flex/addpaye") }}',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: $(this).serialize(), // it will serialize the form data
            dataType: 'json'
        })
        .done(function(data){
            alert(data.title);

            if(data.status == 'OK'){
                // alert(data.title);
                $('#feedBackSubmission').fadeOut('fast', function(){
                    $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });
                setTimeout(function(){// wait for 5 secs(2)
                    location.reload()// then reload the page.(3)
                }, 2000);

            } else{
                // alert(data.title);
                $('#feedBackSubmission').fadeOut('fast', function(){
                    $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });
            }
        })
        .fail(function(){
            alert('Registration Failed, Review Your Network Connection...');
        });
    });


    $("#newPaye").click(function() {
        $('html,body').animate({
            scrollTop: $("#insertPaye").offset().top},
            'slow');
    });
</script>
@endpush
