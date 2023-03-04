@extends('layouts.vertical', ['title' => 'Performance Ranges'])

@push('head-script')
<script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')


<div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-body border-0">
        <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="#employee-transfer" class="nav-link active show" data-bs-toggle="tab" aria-selected="true" role="tab" tabindex="-1">
                    Target Ranges
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="#register-approve" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                    Behaviour Ranges
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="#time-ratios" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                    Time Ranges
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="myTabContent">
        {{-- transfered employee --}}
        <div role="tabpanel" class="tab-pane fade  active show " id="employee-transfer" aria-labelledby="transfer-tab">

            <h6 class="mb-3 mx-3 text-warning">Target Ranges</h6>
            {{-- <a href="" class="btn btn-sm bg-main  mx-1 float-end mb-2">
                <i class="ph-plus"></i>
                Add Target Ranges
            </a> --}}
            <button class="float-end btn btn-main mb-2 mx-1"  data-bs-toggle="modal" data-bs-target="#approval">   <i class="ph-plus"></i>  Add Target Ranges</button>
            <div id="resultFeedback" class="my-3"></div>

            <table id="datatable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Range Name</th>
                        <th>Maximum Value</th>
                        <th>Minimum Value</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($target_ratio as $item)
                    <tr>
                        <td>{{ $item->id}}</td>
                        <td>{{ $item->name}}</td>
                        <td>{{ $item->max}}</td>
                        <td> {{ $item->min}}</td>
                        <td>{{ $item->status}}</td>
                        <td>
                            <a href="" class="btn btn-sm bg-main">
                                <i class="ph-pen"></i>
                            </a>
                            <a href="{{ url('flex/delete-target-ratio/'.$item->id); }}" class="btn btn-sm btn-danger">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                    </tr>

                    @endforeach
      
                </tbody>
            </table>

        </div>
        {{-- / --}}

        {{-- Behaviour Ratios --}}
        <div role="tabpanel" class="tab-pane  " id="register-approve" aria-labelledby="approve-tab">

            <h6 class="text-warning mb-3 mx-3">Behaviour Ranges</h6>
            <button class="float-end btn btn-main mb-2 mx-1"  data-bs-toggle="modal" data-bs-target="#behaviour-ratio">   <i class="ph-plus"></i>  Add Behaviour Ranges</button>
            <div id="resultFeedback"></div>

            <table id="datatable1" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Range Name</th>
                        <th>Maximum Value</th>
                        <th>Minimum Value</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($behaviour_ratio as $item)
                    <tr>
                        <td>{{ $item->id}}</td>
                        <td>{{ $item->name}}</td>
                        <td>{{ $item->max}}</td>
                        <td> {{ $item->min}}</td>
                        <td>{{ $item->status}}</td>
                        <td>
                            <a href="" class="btn btn-sm bg-main">
                                <i class="ph-pen"></i>
                            </a>
                            <a href="{{ url('flex/delete-behaviour-ratio/'.$item->id); }}" class="btn btn-sm btn-danger">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

        </div>
        {{-- / --}}

        {{-- Time ratios employee --}}
        <div role="tabpanel" class="tab-pane  " id="time-ratios" aria-labelledby="approve-tab">

            <h6 class="text-warning mb-3 mx-3">Time Ranges</h6>
            <button class="float-end btn btn-main mb-2 mx-1"  data-bs-toggle="modal" data-bs-target="#time-ratio">   <i class="ph-plus"></i>  Add Time Ranges</button>
            <div id="resultFeedback"></div>

            <table id="datatable1" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Range Name</th>
                        <th>Maximum Value</th>
                        <th>Minimum Value</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($time_ratio as $item)
                    <tr>
                        <td>{{ $item->id}}</td>
                        <td>{{ $item->name}}</td>
                        <td>{{ $item->max}}</td>
                        <td> {{ $item->min}}</td>
                        <td>{{ $item->status}}</td>
                        <td>
                            <a href="" class="btn btn-sm bg-main">
                                <i class="ph-pen"></i>
                            </a>
                            <a href="{{ url('flex/delete-time-ratio/'.$item->id); }}" class="btn btn-sm btn-danger">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

        </div>
        {{-- / --}}
    </div>
</div>
        {{-- </[object Object]> --}}

        {{-- start of add Target Ranges modal --}}
        <div id="approval" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Target Ranges Form</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal">

                        </button>
                    </div>

                    <form
                        action="{{ route('flex.save_target_ratio') }}"
                        method="POST"
                        class="form-horizontal"
                    >
                        @csrf

                        <div class="modal-body">
                            <div class="row mb-3">

                            <div class="form-group">
                                <label class="col-form-label col-sm-3">Range Name: </label>
                                    <input type="text"  name="name"  value="{{ old('process_name') }}" placeholder="Enter Range Name" class="form-control @error('process_name') is-invalid @enderror">

                                    @error('process_name')
                                        <p class="text-danger mt-1"> Field Process Name has an error </p>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label col-sm-3"> Minimum Value</label>
                                    <input type="number" name="min_value" placeholder="Minimum Value"   value="{{ old('escallation_time') }}" class="form-control @error('escallation_time') is-invalid @enderror">

                            
                            </div>
                            <div class="form-group">
                                <label class="col-form-label col-sm-3"> Maximum Value</label>
                                    <input type="number" name="max_value"  placeholder="Maximum Value"  value="{{ old('escallation_time') }}" class="form-control @error('escallation_time') is-invalid @enderror">

                            </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-perfrom">Save Target Ranges</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- end of Target Ranges modal --}}

        {{-- start of add Behaviour Ranges modal --}}
        <div id="behaviour-ratio" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Behaviour Ranges Form</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal">
    
                            </button>
                        </div>
    
                        <form
                            action="{{ route('flex.save_behaviour_ratio') }}"
                            method="POST"
                            class="form-horizontal"
                        >
                            @csrf
    
                            <div class="modal-body">
                                <div class="row mb-3">
    
                                <div class="form-group">
                                    <label class="col-form-label col-sm-3">Range Name: </label>
                                        <input type="text"  name="name"  value="{{ old('process_name') }}" placeholder="Enter Range Name" class="form-control @error('process_name') is-invalid @enderror">
    
                                        @error('process_name')
                                            <p class="text-danger mt-1"> Field Process Name has an error </p>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label col-sm-3"> Minimum Value</label>
                                        <input type="number" name="min_value" placeholder="Minimum Value"   value="{{ old('escallation_time') }}" class="form-control @error('escallation_time') is-invalid @enderror">
    
                                
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label col-sm-3"> Maximum Value</label>
                                        <input type="number" name="max_value"  placeholder="Maximum Value"  value="{{ old('escallation_time') }}" class="form-control @error('escallation_time') is-invalid @enderror">
    
                                </div>
                                </div>
                            </div>
    
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-perfrom">Save Target Ranges</button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
        {{-- end of Behaviour Ranges modal --}}

              {{-- start of add Time Ranges modal --}}
              <div id="time-ratio" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Time Ranges Form</h5>
                            <button type="button" class="btn-close " data-bs-dismiss="modal">
    
                            </button>
                        </div>
    
                        <form
                            action="{{ route('flex.save_time_ratio') }}"
                            method="POST"
                            class="form-horizontal"
                        >
                            @csrf
    
                            <div class="modal-body">
                                <div class="row mb-3">
    
                                <div class="form-group">
                                    <label class="col-form-label col-sm-3">Range Name: </label>
                                        <input type="text"  name="name"  value="{{ old('process_name') }}" placeholder="Enter Range Name" class="form-control @error('process_name') is-invalid @enderror">
    
                                        @error('process_name')
                                            <p class="text-danger mt-1"> Field Process Name has an error </p>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label col-sm-3"> Minimum Value</label>
                                        <input type="number" name="min_value" placeholder="Minimum Value"   value="{{ old('escallation_time') }}" class="form-control @error('escallation_time') is-invalid @enderror">
    
                                
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label col-sm-3"> Maximum Value</label>
                                        <input type="number" name="max_value"  placeholder="Maximum Value"  value="{{ old('escallation_time') }}" class="form-control @error('escallation_time') is-invalid @enderror">
    
                                </div>
                                </div>
                            </div>
    
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-perfrom">Save Target Ratio</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- end of Target Ratio modal --}}
<script>

jQuery(document).ready(function($){
  
    $('#advance_type').change(function () {
        
    $("#advance_type option:selected").each(function () {
        var value = $(this).val();
        if(value == "1") {
            $('#amount_mid').show();
            $("#amount_midf").removeAttr("disabled");
            $('#monthly_deduction').hide();
            $("#monthly_deductionf").attr("disabled", "disabled");
           
        } else if(value == "2") {
            $('#amount').show();
            $('#monthly_deduction').show();
            $("#amountf").removeAttr("disabled");
            $("#monthly_deductionf").removeAttr("disabled");
            $('#amount_mid').hide();
            $("#amount_midf").attr("disabled", "disabled");
           
        }

    });
  }); 

  
    $('#type').change(function () {
        
    $("#type option:selected").each(function () {
        var value = $(this).val();
        if(value == "1") {
            $('#deduction').show();
            $('#index_no').hide();
            $("#index_nof").attr("disabled", "disabled");
            $("#deductionf").removeAttr("disabled");
           
        } else if(value == "2") {
            $('#index_no').show();
            $('#deduction').hide();
            $("#deductionf").attr("disabled", "disabled");
            $("#index_nof").removeAttr("disabled");
           
        }

    });
  }); 


});
</script>
 @endsection