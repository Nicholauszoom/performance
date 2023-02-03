@extends('layouts.vertical', ['title' => 'Add Termination'])

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

<div class="card">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0 text-muted">Add Employee To Unpaid Leave</h5>

                {{-- start of unpaid all unpaid leaves button --}}
                <a href="{{ route('flex.unpaid_leave') }}" class="btn btn-perfrom">
                    <i class="ph-list me-2"></i> All Unpaid leave List
                </a>
                {{-- / --}}
        </div>
    <hr>
    </div>


            <div id="save_termination" class="" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">


                        <form
                            action="{{ route('flex.save_unpaid_leave') }}"
                            method="POST"
                            class="form-horizontal"
                        >
                            @csrf

                            <div class="modal-body">
                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-3"> Employee :</label>
                                    <div class="col-sm-9">

                                        <select class="form-control select" name="empID" id="empID">
                                            <option selected disabled> Select Employee</option>
                                            @foreach ($employees as $employee)
                                            <option value="{{ $employee->emp_id }}">{{ $employee->fname }} {{ $employee->mname }} {{ $employee->lname }}</option>
                                            @endforeach
                                        </select>

                                        @error('employeeID')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-3">Start Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="start_date" class="form-control" id="start_date">

                                        @error('name')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-3">End Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="end_date" class="form-control" id="start_date">

                                        @error('name')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label class="col-form-label col-sm-3">Reason for Unpaid Leave <span class="text-danger">*</span> :</label>
                                    <div class="col-sm-9">
                                        <textarea rows="3" cols="3" class="form-control" placeholder="Enter your message here" name="reason"></textarea>
                                        @error('name')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                    </div>
                                </div>





                            </div>

                            <div class="modal-footer">
                                <hr>

                                <button type="submit" class="btn btn-perfrom mb-2 mt-2">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


</div>

@endsection

@push('footer-script')
<script type="text/javascript">
    $('#terminationDate').change(function(e){
        var terminationDate  = document.getElementById("terminationDate").value;
        var employeeID  = document.getElementById("employeeID").value;




        //e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/get_employee_available_info",
                 type:"post",
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                 data:{
                    "terminationDate" : terminationDate,
                    "employeeID" : employeeID,
                 },
                //  processData:false,
                //  contentType:false,
                //  cache:false,
                //  async:false
             })
        .done(function(data){
            var data =  JSON.parse(data);

            //alert(data.leave_allowance);

             document.getElementById("leaveAllowance").value  =  data.leave_allowance;
             document.getElementById("salaryEnrollment").value = data.employee_salary;



        })
        .fail(function(){
     alert('Update Failed!! ...');
        });

    });
</script>
@endpush

