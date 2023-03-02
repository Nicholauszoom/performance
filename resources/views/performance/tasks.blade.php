@extends('layouts.vertical', ['title' => 'All Adhoc Tasks'])

@push('head-script')
<script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')



        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
         

            <div class="row">
                <!--ALL PROJECTS -->
          
                
              
              
              <div class="col-md-12 col-sm-12 col-xs-12">
            
                <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                  <div class="card-head px-3 py-1">
                    <h2>Adhoc Tasks
                    </h2>
                    <a href="{{ route('flex.add-adhock_task') }}" class="btn btn-main float-end">
                        <i class="ph-plus me-2"></i> Add Adhoc Task
                      </a>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>

                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                      <div id="resultfeed"></div>
                      <div id="resultfeedCancel"></div> 
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Task Name</th>
                          <th>Assigned To</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Target</th>
                          <th>Status</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($project as $item)
                            <tr>
                                <td>S/N</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->start_date }}</td>
                                <td>{{ $item->end_date }}</td>
                                <td>{{ $item->end_date }}</td>
                                  <td>{{ $item->target }}</td>
                                <td>
                                    {{-- {{ $item->status }}     --}}
                                <span class="badge {{ $item->status == '1' ? 'bg-secondary':'bg-pending' }} disabled">
                                    {{ $item->status == '1' ? 'Completed':'Pending' }}
                                </span>
                                
                                </td>
                                <td>
                             {{-- for completion initiation --}}
                             @if ($item->status==0)

                             <a href="{{ url('flex/completed_adhoctask/'.$item->id); }}" class="btn btn-sm bg-success text-light">
                               <i class="ph-check"></i>
                           </a>
                           @endif
                           {{-- For Task Editing and deletion --}}
                           {{-- @if ($item->created_by==Auth::user()->emp_id) --}}
                                         <a href="" class="btn btn-sm bg-main">
                                 <i class="ph-pen"></i>
                             </a>
                             <a href="{{ url('flex/delete-task/'.$item->id); }}" class="btn btn-sm btn-danger">
                                 <i class="ph-trash"></i>
                             </a> 
                           {{-- @endif --}}
                  
                             {{-- For Task Assessment --}}
                             @if ($item->status==1)
                               {{-- @if ($item->employee->line_manager == Auth()->user()->emp_id) --}}
                               <hr>   
                               <a href="{{ url('flex/assess-adhoctask/'.$item->id); }}" class="btn btn-sm bg-main">
                                 Task Assessment
                               </a> 
                               {{-- @endif --}}
                             @endif
                             {{-- , --}}
                        
                         
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
              
            
            </div>
          </div>


        </div>

        {{-- </[object Object]> --}}
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