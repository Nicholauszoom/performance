@extends('layouts.vertical', ['title' => 'All Projects'])

@push('head-script')
  <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
  <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
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
                    <h2>All Projects
                    </h2>
                    <a href="{{ url('/flex/add-project') }}" class="btn btn-main float-end">
                        <i class="ph-plus me-2"></i> Add New Project
                      </a>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>

                    {{-- <div class="clearfix"></div> --}}
                  </div>
                  {{-- <div class="card-body"> --}}

                    <table id="datatable" class="table table-striped table-bordered datatable-basic">
                      <thead>
                        <tr>
                          <?php $i=1; ?>
                          <th>SN</th>
                          <th>Project Name</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Tasks</th>
                          <th>Status</th>
                          <th>Option</th>
                        
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($project as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->start_date }}</td>
                                <td>{{ $item->end_date }}</td>
                                <td>
                                  @php
                                  $tasks= App\Models\ProjectTask::where('project_id',$item->id)->count();
                                  @endphp

                                   {{ $tasks  }}
                                </td>
                                <td>
                                    {{-- {{ $item->status }}     --}}
                                <span class="badge {{ $item->status == '1' ? 'bg-secondary':'bg-pending' }} disabled">
                                    {{ $item->status == '1' ? 'Completed':'Pending' }}
                                </span>
                                
                                </td>
                                <td>
                                    <a href="{{ url('flex/view-project/'.$item->id); }}" class="btn btn-sm bg-main">
                                        <i class="ph-info"></i>
                                    </a>
                                    <a href="" class="btn btn-sm bg-main">
                                        <i class="ph-pen"></i>
                                    </a>
                                    <a href="{{ url('flex/delete-project/'.$item->id); }}" class="btn btn-sm btn-danger">
                                        <i class="ph-trash"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                  {{-- </div> --}}
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