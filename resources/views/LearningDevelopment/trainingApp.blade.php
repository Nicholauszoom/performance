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

    <form name ="taining_form" method="post" action="{{url('insertData')}}">
    @csrf <!-- {{ csrf_field() }} -->
        <div class="card">
        <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Learning and Development</h5>
    </div>
    <div class="card-body">
        Training Application Form
    </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label class="form-label">first name:</label>
                        <input type="text" name="fname" class="form-control" placeholder="Eugene ">
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label">second name:</label>
                        <input type="text" name="mname" class="form-control" placeholder="Kopyov">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label class="form-label">third name:</label>
                        <input type="text" name="lname" class="form-control" placeholder="Eugene">
                    </div>
                    <div class="col-lg-6">
                    <label class="form-label">skill:</label>
                  <input type="text" name="skill" class="form-control" placeholder="Account">       
                </div>   
            </div>
            <div class="row">
            <div class="col-lg-6">
                        <label class="col-form-label col-lg-3">description</label>
                        
                        <div class="mb-3">
                            <select name="reason" class="form-select">
                                <option name="reason" >Missing Skills</option>
                                <option name="reason" >Performance improvement program(PIP)</option>
                                <option name="reason" >Succession plan</option>
                                <option name="reason" >New strategy</option>
                                <option name="reason" >Direct Registration</option>
                            </select>
                        </div>
                    </div>
                <div class="col-lg-6">
                    <label class="form-label">expected start date:</label>
                    <input type="date" name="start_date" class="form-control" placeholder="enter start date">
                </div>
</div>
<div class="row">
                <div class="col-lg-6">
                    <label class="form-label">expected end date:</label>
                    <input type="date" name="end_date" class="form-control" placeholder="enter end date">
                </div>

                <div class="col-lg-6">
                    <label class="form-label">Location:</label>
                    <input type="text" name="location" class="form-control" placeholder="enter location">
                </div>
</div>
<div class="row">
                <div class="col-lg-6">
                    <label class="form-label">Budget:</label>
                    <input type="text" name="budget" class="form-control" placeholder="enter Budget">
                </div>
            </div>
</div>
            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                <button type="reset" class="btn btn-link">Cancel</button>
                <button type="submit" class="btn btn-main">Request </button>
            </div>
        </div>
    </form>
</div>

@endsection
