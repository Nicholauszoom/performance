@extends('layouts.vertical', ['title' => 'Acceleration Matrix'])

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
                    <h2>Employees
                    </h2>
                    <a href="{{ route('flex.acceleration-report') }}" class="btn btn-main float-end">
                        <i class="ph-plus me-2"></i> Performance Matrix
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
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Performance</th>
                                <th>Behavior</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $j = 1; ?>
                            @if (count($result) > 0)
                                @for ($i = 0; $i < count($result); $i++)
                                    <tr>
                                        <td>{{ $j++ }}</td>
                                        <td>{{ $result[$i]['full_name'] }}</td>
                                        <td>{{ $result[$i]['department'] }}</td>
                                        <td>{{ $result[$i]['performance'] }}</td>
                                        <td>{{ $result[$i]['behavior'] }}</td>
                                    </tr>
                                @endfor
                            @endif
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
