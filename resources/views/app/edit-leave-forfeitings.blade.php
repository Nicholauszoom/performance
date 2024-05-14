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
                <h5 class="modal-title">Edit Leave Forfeitings</h5>
            </div>

            <form
                action="{{ url('flex/update-leave-forfeitings')}}"
                method="POST"
                class="form-horizontal"
            >
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">

                        <div class="form-group col-6">
                            <label class="form-label">Employee Name:</label>
                            <div class="form-control-feedback form-control-feedback-start">
                                <input type="text"  value="{{ $leaveForfeitings->employee->fname ?? '' }} {{ $leaveForfeitings->employee->mname ?? '' }} {{ $leaveForfeitings->employee->lname ?? '' }}" class="form-control" disabled />
                                <input type="text" name="emp_id" value="{{ $leaveForfeitings->employee->emp_id }}" class="form-control" hidden />
                            </div>
                        </div>


                    <div class="form-group col-6">
                        <label class="form-label">Leave Entitled:</label>
                        <div class="form-control-feedback form-control-feedback-start">
                            <input type="text" name="leave_days_entitled" value="{{ $Days_Entitled }}" class="form-control" disabled />
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label class="form-label">Opening Balance:</label>
                        <div class="form-control-feedback form-control-feedback-start">
                            <input type="number" name="opening_balance" value="{{ $leaveForfeitings->opening_balance ?? 0 }}" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label">Days Spent:</label>
                        <div class="form-control-feedback form-control-feedback-start">
                            <input type="text" name="days_spent" value="{{ $daysSpent }}" class="form-control" disabled />
                        </div>
                    </div>

                    <div class="form-group col-6">
                        <label class="form-label">Fortfeit Days:</label>
                        <div class="form-control-feedback form-control-feedback-start">
                            <input type="number" step="0.001" name="days" @isset($leaveForfeitings->days) value = "{{ $leaveForfeitings->days }}" @endisset class="form-control"/>
                                {{-- <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div> --}}
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label class="form-label">Current Balance Days:</label>
                        <div class="form-control-feedback form-control-feedback-start">
                            <input type="text" name="days" @isset($leaveBalance) value = "{{$leaveBalance = number_format($leaveBalance,2)}}" @endisset class="form-control"  disabled />
                                {{-- <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div> --}}
                        </div>
                    </div>

                    </div>
                </div>
                <hr>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-perfrom">Update Leave Forfeiting</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

