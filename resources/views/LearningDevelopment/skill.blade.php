@extends('layouts.vertical', ['title' => 'Learning and Development'])

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

    <form name ="skills" method="post" action="{{url('addSkills')}}">
    @csrf <!-- {{ csrf_field() }} -->
        <div class="card">
        <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Learning and Development</h5>
    </div>
    <div class="card-body">
       Skills Registration Form
    </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label class="form-label">Skill</label>
                        <input type="text" name="skill" class="form-control" placeholder="Eugene ">
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label">Budget:</label>
                        <input type="text" name="budget" class="form-control" placeholder="Kopyov">
                    </div>
                </div>
</div>
            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                <button type="reset" class="btn btn-link">Cancel</button>
                <button type="submit" class="btn btn-primary">Request </button>
            </div>
        </div>
    </form>
</div>

@endsection
