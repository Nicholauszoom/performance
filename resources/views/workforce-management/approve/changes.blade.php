@extends('layouts.vertical', ['title' => 'Employee Approval'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Pending Approval</h5>
    </div>

    <div class="card-body">
        <!-- Highlighted tabs -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card card-primary card-outline card-outline-tabs border-0 shadow-none">

                    <div class="card-header border-0 shadow-none">
                        <ul class="nav nav-tabs nav-tabs-highlight">
                            @include('workforce-management.approve.inc.tab')
                        </ul>
                    </div>

                    <div class="card-body border-0 shadow-none">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="{{ route('approve.changes') }}" role="tabpanel" aria-labelledby="custom-tabs-four-ivr-tab">

                                <div class="card border-0 shadow-none">
                                    <div class="card-header border-0 shadow-none">
                                        <h5 class="text-muted">Current Employee Transfer</h5>
                                    </div>
                                </div>

                                <table class="table datatable-basic">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Transfer Attribute</th>
                                            <th>Destination</th>
                                            <th>Status</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /highlighted tabs -->
    </div>

</div>

@endsection


