@extends('layouts.vertical', ['title' => 'Dashboard'])

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
<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        @can('add-loan')
            @if(session('recom_paym') || session('appr_paym'))
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card border-top border-top-width-3 border-top-main rounded-0">
                        <div class="card-head px-2">
                            <h2>Loans Application/Assignment (To Be Responded)</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <div id="resultfeed"></div>
                            <div id="resultfeedCancel"></div>
                            @if (Session::has('note'))
                                {{ session('note') }}
                            @endif
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Application Date</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($otherloan as $row)
                                        @if ($row->status != 2)
                                            <tr id="domain{{ $row->id }}">
                                                <td width="1px">{{ $row->SNo }}</td>
                                                <td>{{ $row->NAME }}</td>
                                                <td>{{ $row->DEPARTMENT }}<br>{{ $row->POSITION }}</td>
                                                <td>{{ $row->TYPE }}</td>
                                                <td>{{ $row->amount }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->application_date)->format('d-m-Y') }}</td>
                                                <td>
                                                    <div id="status{{ $row->id }}">
                                                        @if ($row->status == 0)
                                                            <div class="col-md-12">
                                                                <span class="label label-default">SENT</span>
                                                            </div>
                                                        @elseif ($row->status == 6)
                                                            <div class="col-md-12">
                                                                <span class="label label-info">RECOMMENDED BY HR</span>
                                                            </div>
                                                        @elseif ($row->status == 1)
                                                            <div class="col-md-12">
                                                                <span class="label label-info">RECOMMENDED BY FINANCE</span>
                                                            </div>
                                                        @elseif ($row->status == 2)
                                                            <div class="col-md-12">
                                                                <span class="label label-success">APPROVED</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/flex/updateloan', ['id' => $row->id]) }}" title="Info and Details" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-main btn-xs">
                                                            <i class="ph-info"></i> | <i class="ph-pencil"></i>
                                                        </button>
                                                    </a>
                                                    @if ($level_check == $row->approval_status)
                                                        <a href="javascript:void(0)" onclick="approveLoan({{ $row->id }})">
                                                            <button class="btn btn-main"><i class="ph-check"></i></button>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <b>HR:</b> {{ $row->reason_hr }}<br><b>Finance:</b> {{ $row->reason_finance }}
                                                    <a href="{{ url('/flex/loan_application_info', ['id' => $row->id]) }}">
                                                        <br>
                                                        <button type="submit" name="go" class="btn btn-main btn-xs">Add Remark</button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        @endcan
    </div>
</div>

                <!--END SALARY ADVANCES TO BE PROVED/RECOMMENDED-->


                <!--APPLY SALARY ADVANCE-->


                <!--END APPLY SALARY ADVANCE-->



                <!--INSERT DIRECT LOAN-->
              <!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        @if(session('mng_emp'))
            <div id="insertDirectForm" class="col-md-12 col-sm-12 col-xs-12 mx-auto">
                <div class="card border-top border-top-width-3 border-top-main rounded-0">
                    <div class="card-head px-3 py-2">
                        <h2><i class="fa fa-tasks"></i> Insert Direct Deduction (HESLB, Custom Deductions, etc..)</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body">  
                        <div id="resultfeedSubmissionDirect"></div>
                        <form id="directLoan" autocomplete="off" method="post" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="row">
                                <!-- START -->
                                <div class="form-group col-12 mb-3">
                                    <label class="control-label col-md-3 col-xs-6">Employee</label>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <select name="employee" class="form-control select" required>
                                            @foreach ($employee as $row)
                                                <option value="{{ $row->empID }}">{{ $row->NAME }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-6 mb-3">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">Type</label>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <select name="type" class="select_type form-control" required tabindex="-1" id="type">
                                            <option value="">Select Loan</option>
                                            <option value="1">Other Company Debt</option>
                                            <option value="2">HESLB</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-6 mb-3">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount</label>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <input required="required" type="number" min="1" max="100000001" step="0.01" name="amount" placeholder="Amount" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group col-6 mb-3" id="index_no">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="index_no">Form Four Index No.</label>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <input type="text" id="index_nof" required min="1" max="100000001" placeholder="Form Four Index Number" name="index_no" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group col-6 mb-3" id="deduction">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="deduction">Deduction Per Month</label>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <input required type="number" id="deductionf" min="1" max="100000001" name="deduction" placeholder="Deduction Per Month" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="reason">Other Remarks</label>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <textarea maxlength="256" class="form-control col-md-7 col-xs-12" name="reason" placeholder="Reason(Optional)" rows="3"></textarea>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <!-- END -->
                            </div>
                            <div class="form-group py-2">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-main float-end">Insert</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>


    <!-- /page content -->

    @include('app/includes/loan_operations')


    <script>
        jQuery(document).ready(function($) {

            $('#advance_type').change(function() {

                $("#advance_type option:selected").each(function() {
                    var value = $(this).val();
                    if (value == "1") {
                        $('#amount_mid').show();
                        $("#amount_midf").removeAttr("disabled");
                        $('#monthly_deduction').hide();
                        $("#monthly_deductionf").attr("disabled", "disabled");

                    } else if (value == "2") {
                        $('#amount').show();
                        $('#monthly_deduction').show();
                        $("#amountf").removeAttr("disabled");
                        $("#monthly_deductionf").removeAttr("disabled");
                        $('#amount_mid').hide();
                        $("#amount_midf").attr("disabled", "disabled");

                    }

                });
            });


            $('#type').change(function() {

                $("#type option:selected").each(function() {
                    var value = $(this).val();
                    if (value == "1") {
                        $('#deduction').show();
                        $('#index_no').hide();
                        $("#index_nof").attr("disabled", "disabled");
                        $("#deductionf").removeAttr("disabled");

                    } else if (value == "2") {
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
