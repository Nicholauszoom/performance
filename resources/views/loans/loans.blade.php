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
    <div class="card border-top  border-top-width-3 border-top-main rounded-0">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border-0 shadow-none">
                            <div class="d-flex justify-content-between align-itens-center">
                                <h5 class="h5 text-muted">All Bank Loans</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                            {{-- start of upload loans form --}}
                                            @can('add-loan')
                                            <form action="{{ route('loans.import') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="row mb-3">
                                                        <div class="col-3">
                                                            <input type="date" name="date" class="form-control">
                                                        </div>
                                                        <div class="col-5">
                                                            <input type="file" name="file" required class="form-control">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <button class="btn btn-sm btn-main">
                                                                <i class="ph-file-csv"></i>
                                                                IMPORT Loans
                                                            </button>


                                                            <a class="btn btn-info btn-sm " href="{{ route('loans.export') }}"><i class="ph-file-csv"></i> EXPORT Loans</a>

                                                        </div>
                                                    </div>

                                                </div>


                                            </form>
                                            @endcan
                                            {{-- / --}}
                                            {{-- start of generate loan template --}}
                                            @can('add-loan')
                                            <div class="col-md-4">
                                                <a href="{{ route('loans.template') }}" class=""> <span class="badge bg-main"> Get Excel Template</span></a>
                                            </div>
                                            @endcan
                                            {{-- / --}}
                                </div>

                            </div>


                        </div>

                        <div class="card-body">
                            <div id="deleteFeedback"></div>
                            <div id="resultSubmission"></div>
                            @if (session('status'))
                            <div class="alert alert-danger" role="alert">
                            {{ session('status') }}
                            </div>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <table id="datatable" class="table table-striped table-bordered datatable-basic">
                                <thead>
                                        <th>LoanID</th>
                                        <th>Employee Id</th>
                                        <th>Product</th>
                                        <th>Amount</th>
                                        <th>Issued Date</th>
                                        <th>Options</th>

                                </thead>


                                <tbody>
                                    @foreach($loans as $loan)
                                    <tr>
                                        <td>{{ $loan->id }}</td>
                                        <td>{{ $loan->employee_id }}</td>
                                        <td>{{ $loan->product }}</td>
                                        <td>{{ $loan->amount }}</td>
                                        <td>{{ $loan->created_at->toDayDateTimeString()}}</td>
                                        <td>
                                            <a  href=""  title="Edit Loan">
                                                <button type="button" class="btn btn-danger btn-xs" disabled><i class="ph-trash"></i></button>
                                            </a>


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

@endsection

@push('footer-script')

<script type="text/javascript">


        /*
                    check if form submitted is for creating or updating
                */
                $("#save-loan-btn").click(function(event ){
                    event.preventDefault();
                    if($("#update_id").val() == null || $("#update_id").val() == "")
                    {
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
