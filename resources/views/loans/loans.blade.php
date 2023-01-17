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
    <div class="card">
       
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border-0 shadow-none">
                            <div class="d-flex justify-content-between align-itens-center">
                                <h5 class="h5 text-muted">All Bank Loans</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                   
                                            <form action="{{ route('loans.import') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-7 mb-1">
                                                        <input type="file" name="file" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <button class="btn btn-sm btn-block btn-main">
                                                            <i class="ph-file-csv"></i> 
                                                            Import Loans 
                                                        </button>
                                                        
                                                    
                                                        <a class="btn btn-info btn-sm btn-lock " href="{{ route('loans.export') }}"><i class="ph-file-csv"></i> EXPORT Loans</a>

                                                    </div>
                                                </div>
                                                
                                                
                                            </form>
                                      
                                </div>
                                <div class="col-md-4">
                               
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
                                        <th>ID</th>
                                        <th>Employee Id</th>
                                        <th>Product</th>
                                        <th>Amount</th>
                                        <th>Issued Date</th>
                               
                                </thead>
    
    
                                <tbody>
                                    @foreach($loans as $loan)
                                    <tr>
                                        <td>{{ $loan->id }}</td>
                                        <td>{{ $loan->employee_id }}</td>
                                        <td>{{ $loan->product }}</td>
                                        <td>{{ $loan->amount }}</td>
                                        <td>{{ $loan->created_at->toDayDateTimeString()}}</td>
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
