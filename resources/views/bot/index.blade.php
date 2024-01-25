@extends('layouts.vertical', ['title' => 'Organisatin Reports'])

@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
    <script src="{{ asset('assets/js/pages/picker_date.js') }}"></script>
@endpush

@section('content')
    <div class="mb-3">
        <h4 class="text-main">Post Data To BOT</h4>
    </div>
    @if(session('status'))
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('.alert-success').fadeOut();
            }, 3000); // Adjust the duration in milliseconds
        });
    </script>
    @php
        $statusData = session('status');
        $httpStatus = $statusData['http_status'];
        $responseText = $statusData['response'];
    @endphp
    <div class="alert alert-success text-center">
        {{ $httpStatus }} - {{ $responseText }}
    </div>
@endif


    {{-- Your existing Blade code here --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card border-top border-top-width-3 border-top-main rounded-0 p-2">
                <div class="card-header">
                </div>
                <form id="demo-form2" enctype="multipart/form-data" method="POST" action="{{ route('bot.postEmployeeData') }}"
                    data-parsley-validate class="form-horizontal form-label-left">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12 col-lg-12">
                                <div class="">
                                    <label class="form-label"> Employee:</label>
                                    <select required name="emp_id" class="select form-control">
                                        <option selected disabled>Select Employee</option>
                                        <option value="all">All </option>
                                        <?php foreach ($employee as $row) { ?>
                                        <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname . ' ' . $row->mname . ' ' . $row->lname; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <!-- Add your additional scripts or adjustments here -->
@endpush
