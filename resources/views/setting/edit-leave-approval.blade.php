@extends('layouts.vertical', ['title' => 'Edit Leave Approvals'])

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


{{-- start of add approval modal --}}

<div id="approval" class="col-12 mt-5" tabindex="-1">
    <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Leave Approval</h5>
            </div>

            <form
                action="{{ route('flex.update-leave-approval') }}"
                method="POST"
                class="form-horizontal"
            >
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">

                    <div class="form-group col-6">
                        <label class="col-form-label col-sm-3">Employee Name: </label>
                            <select name="empID" class="form-control select "  disabled>
                                <option value=""> -- Choose Employee Here -- </option>
                                @foreach($employees as $item)
                                <option value="{{ $item->emp_id }}" {{ $approval->empID == $item->emp_id ? 'selected':'' }}  class="text-center "> {{ $item->fname }} {{ $item->mname }} {{ $item->lname }} </option>
                                
                                @endforeach
                            </select>
                            <input type="text" name="id" value="{{ $approval->id }}" hidden>
                           
                    </div>

                    <div class="form-group col-6">
                        <label class="col-form-label ">Escallation Time ( <small class="text-danger">*days</small> ) </label>
                            <input type="number" name="escallation_time" placeholder="Enter Escallation Time"  value="{{ $approval->escallation_time }}" class="form-control @error('escallation_time') is-invalid @enderror">

                            @error('escallation_time')
                                <p class="text-danger mt-1"> Field Escallation Time has an error </p>
                            @enderror
                    </div>
                    <div class="form-group col-6">
                        <label class="col-form-label col-sm-3">Level 1 Approval</label>
                           <select name="level_1" class="form-control select">
                            <option value="" class="text-center"> -- select Level 1 Approver -- </option>
                            @foreach($employees as $item)
                            <option value="{{ $item->emp_id }}" class="text-center" {{ $approval->level1 == $item->emp_id ? 'selected':'' }}> {{ $item->fname }} {{ $item->mname }} {{ $item->lname }} </option>
                            @endforeach
                           </select>
                            @error('escallation_time')
                                <p class="text-danger mt-1"> Field Escallation Time has an error </p>
                            @enderror
                    </div>
                    <div class="form-group col-6">
                        <label class="col-form-label ">Level 2 Approval</label>
                           <select name="level_2" class="form-control select text-center">
                            <option value="" class="text-center"> -- select Level 2 Approver -- </option>
                            @foreach($employees as $item)
                            <option value="{{ $item->emp_id }}" class="text-center" {{ $approval->level2 == $item->emp_id ? 'selected':'' }}> {{ $item->fname }} {{ $item->mname }} {{ $item->lname }} </option>
                            @endforeach
                           </select>
                            @error('escallation_time')
                                <p class="text-danger mt-1"> Field Escallation Time has an error </p>
                            @enderror
                    </div>
                    <div class="form-group col-6">
                        <label class="col-form-label ">Level 3 Approval</label>
                        <select name="level_3" class="form-control select text-center">
                            <option value="" class="text-center"> -- select Level 3 Approver -- </option>
                            @foreach($employees as $item)
                            <option value="{{ $item->emp_id }}" class="text-center" {{ $approval->level3 == $item->emp_id ? 'selected':'' }}> {{ $item->fname }} {{ $item->mname }} {{ $item->lname }} </option>
                            @endforeach
                           </select>
                            @error('escallation_time')
                                <p class="text-danger mt-1"> Field Escallation Time has an error </p>
                            @enderror
                    </div>

                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                  
                    <button type="submit" class="btn btn-perfrom">Update Leave Approval</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

