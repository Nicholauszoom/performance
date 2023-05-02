@extends('layouts.vertical', ['title' => 'Edit Pillar'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('page-header')
    @include('layouts.shared.page-header')
@endsection

@section('content')
    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0 text-warning">Edit Performance Pillar</h5>
            </div>
            <a href="{{ route('flex.performance-pillars') }}" class="btn btn-main float-end"> <i class="ph-list"></i> All
                Pillars</a>


        </div>
        <hr>
        <div id="save_termination" class="" tabindex="-1">


            @if (session('msg'))
                <div class="alert alert-success col-md-8 mx-auto" role="alert">
                    {{ session('msg') }}
                </div>
            @endif

            <form action="{{ route('flex.update-pillar') }}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="row mb-1 mx-auto">
                        <div class="col-6 mx-auto col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">Pillar Name:</label>
                                <input type="text" name="name" value="{{ $pillar->name }}" class="form-control"
                                    placeholder="Enter Pillar Name">
                                <input type="hidden" value="{{ $pillar->id }}" name="pillar_id">
                            </div>
                        </div>
                        <div class="col-6 mx-auto col-lg-6">
                            <label class="form-label">Pillar Type:</label>
                            <select name="type" class="form-control">
                                <option value="Strategy">Strategy</option>
                                <option value="Behaviour">Behaviour</option>
                            </select>
                        </div>
                        <div class="col-12 mx-auto col-lg-12 mt-2">
                            <div class="mb-1">

                                <label for="recurring" class="form-label">Status:</label>
                                <input type="checkbox" name="status" id="recurring" class="check">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-perfrom mb-1 float-end">Update</button>
                </div>
            </form>


        </div>
    </div>
@endsection
