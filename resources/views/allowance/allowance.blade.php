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

        <div class="card border-top  border-top-width-3 border-top-main rounded-0 ">

            @include('app.headers_payroll_input')
        <div class="row">
            <div class="col-md-12">
                <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                    <div class="card-header">
                        <h5 class="text-warning">Add Allowance</h5>
                    </div>

                    <div class="card-body">
                        <div id="resultSubmission"></div>

                        <form id="addAllowance" method="post" autocomplete="off" class="form-horizontal form-label-left">
                            <div class="form-group row">
                                <div class=" col-md-4 mb-4">
                                    <label class="form-label">Allowance Name:</label>
                                    <input type="text"  name="name" class="form-control">
                                </div>



                                <div class=" col-md-4 mb-4">
                                    <label class="form-label">Allowance Category:</label>
                                    <select class="form-control select_type select" name="allowanceCategory" id="allowanceCategory">
                                        <option selected disabled>Select</option>
                                        @foreach ($allowanceCategories as $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach

                                    </select>
                                </div>
                                <div class=" col-md-4 mb-4">
                                    <label class="form-label">Taxable</label>
                                    <select class="form-control select_type select" name="taxable" id="policy">
                                        <option selected disabled> Select </option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>

                            </div>



                            <div class="form-group row">

                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Pensionable</label>
                                    <select class="form-control select_type select" name="pensionable" id="policy">
                                        <option selected disabled> Select </option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Nature</label>
                                    <select class="form-control select_type select" name="Isrecursive" id="Isrecursive">
                                        <option selected disabled> Select </option>
                                        <option value="PERMANENT">PERMANENT</option>
                                    <option value="TEMPORARY">TEMPORARY</option>
                                    <option value="ONCE OFF">ONCE OFF</option>

                                    </select>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Benefit In kind</label>
                                    <select class="form-control select_type select" name="Isbik" id="policy">
                                        <option selected disabled> Select </option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>

                                {{-- <div class="col-md-3 mb-3">
                                    <label class="form-label select_type allName">Percent:</label>
                                    <input required id="percentf" type="number" name="rate" min="0"
                                        max="99" step="0.1" placeholder="Percent (Less Than 100)"
                                        class="form-control">
                                </div> --}}

                                {{-- <div class="col-md-3 mb-3">
                                    <label class="allName select_type form-label">Amount:</label>
                                    <input required id="amountf" type="number" step="1"
                                        placeholder="Fixed Amount" name="amount" class="form-control">
                                </div> --}}
                                <input type="hidden" value="1" name="policy">
                                <input type="hidden" value="0" name="amount">
                                <input type="hidden" value="0" name="rate">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-main">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                    <div class="card-header border-0 shadow-none">
                        <div class="d-flex justify-content-between align-itens-center">
                            <h5 class="h5 text-warning">Allowance</h5>
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

                                <th>Taxable</th>
                                <th>pensionable</th>
                                <th>Nature</th>
                                <th>Benefit In Kind</th>
                                <!-- <th>Apply To</th> -->
                                @if ($pendingPayroll == 0)
                                    <th>Option</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($allowance as $row) { ?>
                            <tr <?php if($row->state ==0){ ?> bgcolor="#FADBD8" <?php  } ?> id="record<?php echo $row->id; ?>">
                                <td width="1px"><?php echo $row->SNo; ?></td>
                                <td><?php echo $row->name; ?></td>



                                <td><?php echo $row->taxable; ?></td>
                                <td><?php echo $row->pensionable; ?></td>
                                <td><?php echo $row->Isrecursive; ?></td>
                                <td><?php echo $row->Isbik; ?></td>


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




        </div>
    </div>
    @include('app.includes.update_allowances')
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

                    new Noty({
                                    text: 'Alloance Added successfully!',
                                    type: 'success'
                                }).show();

                    // $('#addAllowance')[0].reset();
                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 2000);
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
                    // $('#resultOvertimeSubmission').fadeOut('fast', function() {
                    //     $('#resultOvertimeSubmission').fadeIn('fast').html(data);
                    // });

                    // $('#addOvertime')[0].reset();
                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
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
                    // $('#resultSubmissionDeduction').fadeOut('fast', function() {
                    //     $('#resultSubmissionDeduction').fadeIn('fast').html(data);
                    // });

                    // $('#addDeduction')[0].reset();
                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                })
                .fail(function() {
                    alert('FAILED, Check Your Network Connection and Try Again! ...');
                });
        });
    </script>
@endpush
