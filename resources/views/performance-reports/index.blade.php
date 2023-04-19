@extends('layouts.vertical', ['title' => 'Performance Reports'])

@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>

    <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/picker_date.js') }}"></script> --}}
@endpush

@section('content')
    <div class="mb-3">
        <h4 class="text-main">Performance Reports</h4>
    </div>

    <div class="row">

        {{-- For Organizaional Report --}}
        <div class="col-md-6">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                <div class="card-header">
                    <h5 class="text-warning"> Organisation Performance Report</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('flex.organization-reports') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">
                        <div class="input-group row d-flex">
                            <div class="col-6 col-md-6 mb-2">
                                <label class="col-form-label ">Start Date <span class="text-danger">*</span>
                                    :</label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                                        <input type="date" required placeholder="Start Time" name="start_date"
                                            id="time_start" class="form-control daterange-single">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <label class="col-form-label ">End Date <span class="text-danger">*</span>
                                    :</label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                                        <input type="date" required placeholder="Start Time" name="end_date"
                                            id="time_start" class="form-control daterange-single">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            {{-- <label class="form-label">Report Format:</label> --}}

                            <div class="">

                                <button type="submit" class="btn btn-main float-end">
                                    {{-- <i class="ph-printer me-2"></i>Print --}}
                                    View
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- ./ --}}

        {{-- For Project Report --}}
        <div class="col-md-6">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                <div class="card-header">
                    <h5 class="text-warning"> Employee Projects Performance Report</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('flex.projects-report') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">
                        <div class="col-12 col-md-12 mb-2">
                            <label class="col-form-label col-sm-3">Select Project:</label>
                            <select name="project_id" class="form-control select" id="">
                                @php
                                    $project = App\Models\Project::get();
                                @endphp

                                @foreach ($project as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach



                            </select>
                        </div>

                        <div class="input-group row d-flex">
                            <div class="col-6 col-md-6 mb-2">
                                <label class="col-form-label ">Start Date <span class="text-danger">*</span>
                                    :</label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                                        <input type="date" required placeholder="Start Time" name="time_start"
                                            id="time_start" class="form-control daterange-single">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <label class="col-form-label ">End Date <span class="text-danger">*</span>
                                    :</label>
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                                        <input type="date" required placeholder="Start Time" name="time_start"
                                            id="time_start" class="form-control daterange-single">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            {{-- <label class="form-label">Report Format:</label> --}}

                            <div class="">

                                <button type="submit" class="btn btn-main float-end">
                                    {{-- <i class="ph-printer me-2"></i> --}}
                                        View
                                    </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- ./ --}}


                {{-- For Project Report --}}
                <div class="col-md-6">
                    <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                        <div class="card-header">
                            <h5 class="text-warning"> Department Performance Report</h5>
                        </div>
        
                        <form id="demo-form2" enctype="multipart/form-data" method="post"
                            action="{{ route('reports.payrollReconciliationSummary') }}" data-parsley-validate
                            class="form-horizontal form-label-left">
                            @csrf
        
                            <div class="card-body">
                                <div class="col-12 col-md-12 mb-2">
                                    <label class="col-form-label col-sm-3">Select Department:</label>
                                    <select name="project_id" class="form-control select" id="">
                                        @php
                                            $project = App\Models\Department::get();
                                        @endphp
        
                                        @foreach ($project as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
        
        
        
                                    </select>
                                </div>
        
                                <div class="col-12 col-md-12 mb-2">
                                    <label class="col-form-label col-sm-3">Select Project:</label>
                                    <select name="project_id" class="form-control select" id="">
                                        @php
                                            $project = App\Models\Project::get();
                                        @endphp
        
                                        @foreach ($project as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
        
        
        
                                    </select>
                                </div>

                                <div class="input-group row d-flex">
                                    <div class="col-6 col-md-6 mb-2">
                                        <label class="col-form-label ">Start Date <span class="text-danger">*</span>
                                            :</label>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ph-calendar"></i></span>
                                                <input type="date" required placeholder="Start Time" name="time_start"
                                                    id="time_start" class="form-control daterange-single">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6 mb-2">
                                        <label class="col-form-label ">End Date <span class="text-danger">*</span>
                                            :</label>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ph-calendar"></i></span>
                                                <input type="date" required placeholder="Start Time" name="time_start"
                                                    id="time_start" class="form-control daterange-single">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    {{-- <label class="form-label">Report Format:</label> --}}
        
                                    <div class="">
        
                                        <button type="submit" class="btn btn-main float-end">
                                            {{-- <i class="ph-printer me-2"></i> --}}
                                                View</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- ./ --}}



    </div>
@endsection

@push('footer-script')
    <!-- <script>
        $(function() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!

            var startYear = today.getFullYear() - 18;
            var endYear = today.getFullYear() - 60;
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }


            var dateStart = dd + '/' + mm + '/' + startYear;
            var dateEnd = dd + '/' + mm + '/' + endYear;
            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#duration span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#duration').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'), 10)
            }, cb);

            cb(start, end);

        });
        -- >

        <
        !--$(function() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!

            var startYear = today.getFullYear() - 18;
            var endYear = today.getFullYear() - 60;
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }


            var dateStart = dd + '/' + mm + '/' + startYear;
            var dateEnd = dd + '/' + mm + '/' + endYear;
            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#duration_ span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#duration_').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'), 10)
            }, cb);

            cb(start, end);

        });
        -- >
    </script>
@endpush
