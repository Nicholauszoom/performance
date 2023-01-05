@extends('layouts.vertical', ['title' => 'Allowance'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card">
        <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/financial_group')}}" class="nav-link" aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Packages
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/allowance_overtime') }}" class="nav-link" aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Overtime
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/allowance') }}" class="nav-link  active show" aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Allowance
                </a>
            </li>


            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/statutory_deductions') }}" class="nav-link " aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Statutory Deductions
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/non_statutory_deductions') }}" class="nav-link " aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Non Statutory Deductions
                </a>
            </li>
        </ul>
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header border-0 shadow-none">
                            <div class="d-flex justify-content-between align-itens-center">
                                <h5 class="h5 text-muted">Allowance</h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="deleteFeedback"></div>
                            <div id="resultSubmission"></div>
                            {{ session('note') }}
                        </div>

                        <table class="table table-bordered datatable-basic">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Taxable</th>
                                    <th>Pentionable</th>
                                    <!-- <th>Apply To</th> -->
                                    @if ($pendingPayroll == 0)
                                        <th>Option</th>
                                    @endif
                                </tr>
                            </thead>


                            <tbody>
                                <?php foreach ($allowance as $row) { ?>
                                <tr <?php if($row->state ==0){ ?> bgcolor="#FADBD8" <?php  } ?>
                                    id="record<?php echo $row->id; ?>">
                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                    <td><?php echo $row->name; ?></td>

                                    <td>
                                        <?php if($row->mode==1){ ?>
                                        <span class="badge bg-success">Fixed Amount</span><br>
                                        <?php echo number_format($row->amount, 2); } else { ?>
                                        <span class="badge bg-success">Salary dependent</span><br>
                                        <?php echo 100*($row->percent)."%"; } ?>
                                    </td>

                                    <td><?php echo $row->taxable; ?></td>
                                    <td><?php echo $row->pentionable; ?></td>


                                    <?php if($pendingPayroll == 0){ ?>
                                    <td class="options-width">
                                        <a href="{{ route('flex.allowance_info', base64_encode($row->id)) }}"
                                            title="Info and Details" class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-main btn-xs"><i
                                                    class="ph-info"></i></button>
                                        </a>

                                        <?php if($row->state ==1){ ?>
                                        <a href="javascript:void(0)" onclick="deleteAllowance(<?php echo $row->id; ?>)"
                                            title="Delete Allowance" class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-danger btn-xs"><i
                                                    class="ph-trash"></i></button>
                                        </a>
                                        <?php } else{ ?>

                                        <a href="javascript:void(0)" onclick="activateAllowance(<?php echo $row->id; ?>)"
                                            title="Activate Allowance" class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-success btn-xs"><i
                                                    class="ph-check"></i></button>
                                        </a><?php } ?>
                                    </td><?php } ?>
                                </tr>
                                <?php }  ?>
                            </tbody>
                        </table>

                    </div>
                </div>


                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-muted">Add Allowance</h5>
                        </div>

                        <div class="card-body">
                            <div id="resultSubmission"></div>

                            <form id="addAllowance" method="post" autocomplete="off"
                                class="form-horizontal form-label-left">
                                <div class="mb-3">
                                    <label class="allName">Allowance Name:</label>
                                    <textarea required type="text" name="name" class="form-control"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Payment Policy:</label>
                                    <select class="form-control select_type select" name="policy" id="policy">
                                        <option selected disabled> Select </option>
                                        <option value=1>Fixed Amount</option>
                                        <option value=2>Percent From Basic Salary</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Is Taxable?</label>
                                    <select class="form-control select_type select" name="taxable" id="policy">
                                        <option selected disabled> Select </option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Is Pentionable?</label>
                                    <select class="form-control select_type select" name="pentionable" id="policy">
                                        <option selected disabled> Select </option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="allName">Percent:</label>
                                    <input required id="percentf" type="number" name="rate" min="0"
                                        max="99" step="0.1" placeholder="Percent (Less Than 100)"
                                        class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="allName">Amount:</label>
                                    <input required id="amountf" type="number" step="1"
                                        placeholder="Fixed Amount" name="amount" class="form-control">
                                </div>


                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-main">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
    </div>
@endsection

@push('footer-script')
    <script>
        jQuery(document).ready(function($) {

            $('#policy').change(function() {

                $("#policy option:selected").each(function() {
                    var value = $(this).val();
                    if (value == "1") {
                        // $('#amount').show();
                        // $('#percent').hide();
                        $("#percentf").attr("disabled", "disabled");
                        $("#amountf").removeAttr("disabled");

                    } else if (value == "2") {
                        // $('#percent').show();
                        // $('#amount').hide();
                        $("#amountf").attr("disabled", "disabled");
                        $("#percentf").removeAttr("disabled");

                    }
                });
            });

        });
    </script>


    <script>
        jQuery(document).ready(function($) {

            $('#deduction_policy').change(function() {

                $("#deduction_policy option:selected").each(function() {
                    var value = $(this).val();
                    if (value == "1") {
                        $("#deduction_percentf").attr("disabled", "disabled");
                        $("#deduction_amountf").removeAttr("disabled");

                    } else if (value == "2") {
                        $("#deduction_amountf").attr("disabled", "disabled");
                        $("#deduction_percentf").removeAttr("disabled");

                    } else if (value == "3") {
                        $("#deduction_amountf").attr("disabled", "disabled");
                        $("#deduction_percentf").removeAttr("disabled");

                    }

                });
            });


        });
    </script>

    <script>
        $('#addAllowance').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: '{{ url('/flex/addAllowance') }}',
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false
                })
                .done(function(data) {

                    $('#resultSubmission').fadeOut('fast', function() {
                        $('#resultSubmission').fadeIn('fast').html(data);
                    });

                    $('#addAllowance')[0].reset();
                })
                .fail(function() {
                    alert('FAILED, Check Your Network Connection and Try Again! ...');
                });
        });
    </script>

    <script>
        $('#addOvertime').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: '{{ url('/flex/addOvertimeCategory') }}',
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false
                })
                .done(function(data) {
                    $('#resultOvertimeSubmission').fadeOut('fast', function() {
                        $('#resultOvertimeSubmission').fadeIn('fast').html(data);
                    });

                    $('#addOvertime')[0].reset();
                })
                .fail(function() {
                    alert('FAILED, Check Your Network Connection and Try Again! ...');
                });
        });
    </script>


    <script>
        $('#addDeduction').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: '{{ url('/flex/addDeduction') }}',
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false
                })
                .done(function(data) {
                    $('#resultSubmissionDeduction').fadeOut('fast', function() {
                        $('#resultSubmissionDeduction').fadeIn('fast').html(data);
                    });

                    $('#addDeduction')[0].reset();
                })
                .fail(function() {
                    alert('FAILED, Check Your Network Connection and Try Again! ...');
                });
        });
    </script>
@endpush
