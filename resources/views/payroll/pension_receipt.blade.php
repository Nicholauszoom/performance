@extends('layouts.vertical', ['title' => 'Bank Loans'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')

    <div class="card border-top border-top-width-3 border-top-main rounded-0">
        <div class="card-header">
            <div id="deleteFeedback"></div>
            <div id="resultSubmission"></div>

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @elseif (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="card-body">

            @can('add-loan')
            <form action="{{ route('pension_receipt.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="prl-date">Select Payroll Month</label>
                        <select name="payroll_date" id="prl-date" class="select form-control select_payroll_month" required>
                            <option>Select Month</option>
                            @foreach ($month_list as $row)
                            <option value="{{ $row->payroll_date }}">{{ date('F, Y', strtotime($row->payroll_date)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="pay-date">Payment date</label>
                        <input type="date" name="date" required class="form-control" id="pay-date">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="pen-receipt">Receipt No</label>
                        <input type="text" placeholder="receipt no" name="receipt" required class="form-control" id="pen-receipt">
                    </div>

                    <div class="col-md-3 pt-4 mb-3">
                        <button type="submit" class="btn btn-sm btn-main">Update</button>
                    </div>
                </div>
            </form>
            @endcan

        </div>
    </div>

@endsection

{{-- Java script files --}}


{{-- //TODO Remove the unrelevant javascript files --}}
@push('footer-script')
<script type="text/javascript">
    // check if form submitted is for creating or updating

    $("#save-loan-btn").click(function(event ){
        event.preventDefault();

        if($("#update_id").val() == null || $("#update_id").val() == ""){
            storeLoan();
        } else {
            updateLoan();
        }
     })

                /*
                    show modal for creating a record and
                    empty the values of form and remove existing alerts
                */
                function createLoan()
                {
                    $("#alert-div").html("");
                    $("#error-div").html("");
                    $("#update_id").val("");
                    $("#employee_d").val("");
                    $("#product").val("");
                    $("#created_at").val("");
                    $("#form-modal").modal('show');
                }


                /*
                    submit the form and will be stored to the database
                */
                function storeLoan()
                {
                    $("#save-loan-btn").prop('disabled', true);
                    let url = $('meta[name=app-url]').attr("content") + "/admin/announcements";
                    let data = {
                        employee_id: $("employee_id").val(),
                        product: $("#product").val(),
                        amount: $("#amount").val(),
                        created_at: $("#created_at").val(),
                    };
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        type: "POST",
                        data: data,
                        success: function(response) {
                            $("#save-announcement-btn").prop('disabled', false);
                            let successHtml = '<div class="alert alert-success" role="alert">Announcement Was Created Successfully</div>';
                            $("#alert-div").html(successHtml);
                            $("#tite").val("");
                            $("#body").val("");
                            $("image").val("");
                            showAllAnnouncements();
                            $("#form-modal").modal('hide');
                        },
                        error: function(response) {
                            $("#save-announcement-btn").prop('disabled', false);

                            /*
                show validation error
                            */
                            if (typeof response.responseJSON.errors !== 'undefined')
                            {
                let errors = response.responseJSON.errors;
                let descriptionValidation = "";
                if (typeof errors.description !== 'undefined')
                                {
                                    descriptionValidation = '<li>' + errors.description[0] + '</li>';
                                }
                let titleValidation = "";
                if (typeof errors.title !== 'undefined')
                                {
                                    titleValidation = '<li>' + errors.title[0] + '</li>';
                                }
                let bodyValidation = "";
                if (typeof errors.body !== 'undefined')
                                {
                                    bodyValidation = '<li>' + errors.body[0] + '</li>';
                                }
                          let fileValidation = "";
                if (typeof errors.image !== 'undefined')
                                {
                                    fileValidation = '<li>' + errors.image[0] + '</li>';
                                }

                let errorHtml = '<div class="alert alert-danger" role="alert">' +
                    '<b>Validation Error!</b>' +
                    '<ul>' + titleValidation + bodyValidation + attachmentValidation + '</ul>' +
                '</div>';
                $("#error-div").html(errorHtml);
            }
                        }
                    });
                }


    </script>
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
