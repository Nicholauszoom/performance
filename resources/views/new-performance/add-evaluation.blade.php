@extends('layouts.vertical', ['title' => 'Add Pillar'])

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
                <h5 class="mb-0 text-warning">New {{ $employee->fname }} {{ $employee->lname }} Evaluation</h5>
            </div>
            <a href="{{ route('flex.performance-pillars') }}" class="btn btn-main float-end"> <i class="ph-list"></i> Back</a>


        </div>
        <hr>
        <div id="save_termination" class="" tabindex="-1">


            @if (session('msg'))
                <div class="alert alert-success col-md-8 mx-auto" role="alert">
                    {{ session('msg') }}
                </div>
            @endif

            <form action="{{ route('flex.save-pillar') }}" method="POST">
                @csrf


                <div class="card-body">
                    <h5><span  class="text-danger">*</span> </h5>
                    <hr>
                    <div class="row mb-1 ">

                        <small class="text-muted"><b> STRATEGY</b></small>
                        <hr>
                        @foreach ($strategy as $item)
                        <div class="col-6  col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">{{ $item->name }}:</label>
                                <input type="number" min="0" name="Capability" id="" class="form-control"
                                    placeholder="Enter {{ $item->name }} Percentage">
                            </div>
                        </div>
                        @endforeach

             
                    </div>

                    <div class="row mb-1 mx-auto">
                        <small class="text-muted"><b>BEHAVIOUR</b> </small>
                        <hr>
                        @foreach ($behaviour as $item)
                        <div class="col-6  col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">{{ $item->name }}:</label>
                                <input type="number" min="0" name="Capability" id="" class="form-control"
                                    placeholder="Enter {{ $item->name }} Percentage">
                            </div>
                        </div>
                        @endforeach
                    </div>


                    
                    <button type="submit" class="btn btn-perfrom mb-1 float-end">Submit</button>
                </div>
            </form>


       


        </div>
    </div>

    
@endsection
