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
                        <div class="col-6  col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">Capability:</label>
                                <input type="number" min="0" name="Capability" id="" class="form-control"
                                    placeholder="Enter Capability Percentage">
                            </div>
                        </div>
                        <div class="col-6  col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">Enterprise Risk Managementr & Government:</label>
                                <input type="number" min="0" name="Enterprise" id="" class="form-control"
                                    placeholder="Enter Enterprise Percentage">
                            </div>
                        </div>
                        <div class="col-6  col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">People:</label>
                                <input type="number" min="0" name="People" id="" class="form-control"
                                    placeholder="Enter People Percentage">
                            </div>
                        </div>
                        <div class="col-6  col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">Customer Excellence:</label>
                                <input type="number" min="0" name="Excellence" id="" class="form-control"
                                    placeholder="Enter Customer Excellence Percentage">
                            </div>
                        </div>
                        <div class="col-6  col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">Finance:</label>
                                <input type="number" min="0" name="Finance" id="" class="form-control"
                                    placeholder="Enter Customer Finance Percentage">
                            </div>
                        </div>
             
                    </div>

                    <div class="row mb-1 mx-auto">
                        <small class="text-muted"><b>BEHAVIOUR</b> </small>
                        <hr>
                        <div class="col-6 col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">Partnership:</label>
                                <input type="number" min="0" name="Partnership"  class="form-control"
                                    placeholder="Enter Partnership Pecentage">
                            </div>
                        </div>
                        <div class="col-6 col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">Courage:</label>
                                <input type="number" min="0" name="Courage"  class="form-control"
                                    placeholder="Enter Courage Pecentage">
                            </div>
                        </div>
                        <div class="col-6 col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">Integrity:</label>
                                <input type="number" min="0" name="Integrity"  class="form-control"
                                    placeholder="Enter Integrity Pecentage">
                            </div>
                        </div>
                        <div class="col-6 col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">Respect:</label>
                                <input type="number" min="0" name="Respect"  class="form-control"
                                    placeholder="Enter Respect Pecentage">
                            </div>
                        </div>
                        <div class="col-6 col-lg-6">
                            <div class="mb-1">
                                <label class="form-label">Visible Commitment:</label>
                                <input type="number" min="0" name="VisibleCommitment"  class="form-control"
                                    placeholder="Enter Visible Commitment Pecentage">
                            </div>
                        </div>
                    </div>


                    
                    <button type="submit" class="btn btn-perfrom mb-1 float-end">Submit</button>
                </div>
            </form>


       


        </div>
    </div>

    
@endsection
