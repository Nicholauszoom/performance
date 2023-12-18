@extends('layouts.vertical', ['title' => 'My Pensions'])

@push('head-script')
<script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')


@php
$empID= Auth()->user()->emp_id;
@endphp


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">


            <div class="clearfix"></div>

            <div class=" rounded-0 border-0 shadow-none">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
                            <div class="card-header border-0">
                                <h6 class="text-warning">Pension Summary</h6>

                                <a class="ms-3" href="{{ route('reports.employee_pension',['emp_id'=>base64_encode($empID)]) }}" target="blank">
                                    @can('print-pension-summary')
                                        
                                    
                                    <button type="button" name="print" value="print" class="btn btn-main btn-sm float-end">
                                        Print
                                    </button>

                                    @endcan
                                </a>
                                <hr>
                            </div>

                            @php
                            $total = 0;
                              foreach ($employee_pension as $row) {

                              $total +=$row->pension_employee;
                              }

                            @endphp

                            <div class="card-body">
                                <form action="{{ route('flex.revokerole') }}" method="post">
                                    @csrf

                                    <input type="text" hidden="hidden" name="empID"
                                        value="<?php echo $empID; ?>" />

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th> Total Pension Employee</th>
                                                <th>Total Pension Employer</th>

                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr>
                                                <td>{{ number_format($total,2 ) }}</td>
                                                <td>{{ number_format($total,2 ) }}</td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">Total : {{ number_format($total*2,2) }}</td>


                                            </tr>

                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 border-1 col-md-12">
                            <div class="card-header border-0">
                                <h6 class="text-warning">Detailed</h6>
                                <hr>
                            </div>

                            <div class="card-body">


                                <input type="text" hidden="hidden" name="empID"
                                    value="<?php echo $empID; ?>" />

                                <table id="datatable"
                                    class="table table-striped table-bordered datatable-basic">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Pension Employee</th>
                                            <th>Pension Employer</th>
                                            <th hidden></th>
                                            <th hidden></th>
                                            <th hidden></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($employee_pension as $row) {  ?>
                                        <tr>
                                            <td><?php echo $row->payment_date; ?></td>
                                            <td><?php echo number_format($row->pension_employee,2); ?></td>
                                            <td><?php echo number_format($row->pension_employer,2); ?></td>
                                            <td hidden></td>
                                            <td hidden></td>
                                            <td hidden></td>
                                        </tr>
                                        <?php }   ?>
                                    </tbody>
                                </table>

                            </div>
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
