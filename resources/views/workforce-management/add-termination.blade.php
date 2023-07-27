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
    <div class="card  border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0 text-warning">Terminate Employee</h5>

                <a href="{{ route('flex.termination') }}" class="btn btn-perfrom">
                    <i class="ph-list me-2"></i> All Terminations
                </a>
            </div>
            <hr class="text-warning">
        </div>


        <div id="save_termination" class="" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">


                    <form action="{{ route('flex.saveTermination') }}" method="POST" class="form-horizontal">
                        @csrf

                        <div class="modal-body">
                            <div class="row mb-3">
                                <label class="col-form-label col-sm-3">Terminating Employee :</label>
                                <div class="col-sm-9">

                                    <select class="form-control select" name="employeeID" id="employeeID">
                                        <option selected disabled> Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->emp_id }}">{{ $employee->emp_id }} -
                                                {{ $employee->fname }} {{ $employee->mname }} {{ $employee->lname }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('employeeID')
                                        <p class="text-danger mt-1"> Input field Error </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-form-label col-sm-3">Termination Date</label>
                                <div class="col-sm-9">
                                    <input type="date" name="terminationDate" class="form-control" id="terminationDate">

                                    @error('name')
                                        <p class="text-danger mt-1"> Input field Error </p>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-form-label col-sm-3">Reason for Termination <span
                                        class="text-danger">*</span> :</label>
                                <div class="col-sm-9">
                                    <textarea rows="3" cols="3" class="form-control" placeholder="Enter your message here" name="reason"></textarea>
                                    @error('name')
                                        <p class="text-danger mt-1"> Input field Error </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3" style="display:none" id="deligation">
                                <label class="col-form-label col-sm-3">Deligate Leave Approving To :</label>
                                <div class="col-sm-9">

                                    <select class="form-control select" name="deligated" id="deligated">
                                        <option selected disabled> Select Deligated</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->emp_id }}">{{ $employee->emp_id }} -
                                                {{ $employee->fname }} {{ $employee->mname }} {{ $employee->lname }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('employeeID')
                                        <p class="text-danger mt-1"> Input field Error </p>
                                    @enderror
                                </div>
                            </div>


                            <p class="text-secondary font-weight-bolder">
                                <hr>
                                PAYMENTS DETAILS
                            </p>

                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label for="">Salary Enrollments</label>
                                    <input type="text" value="0" name="salaryEnrollment" class="form-control"
                                        id="salaryEnrollment">
                                    <input type="hidden" value="0" name="actual_salary" class="form-control"
                                        id="actual_salary">

                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Overtime Normal Days</label>
                                    <input type="text" value="0" name="normalDays" class="form-control"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Overtime Public</label>
                                    <input type="text" value="0" name="publicDays" class="form-control"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Notice Payment</label>
                                    <input type="text" class="form-control" value="0" name="noticePay"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Outstanding Leave Pay</label>
                                    <input type="text" class="form-control" value="0" name="leavePay"
                                        id="leavePay">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">House Allowance</label>
                                    <input type="text" class="form-control" value="0" name="houseAllowance"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Cost of Living</label>
                                    <input type="text" class="form-control" value="0" name="livingCost"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Utility Allowance</label>
                                    <input type="text" class="form-control" value="0" name="utilityAllowance"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Leave Allowance</label>
                                    <input type="text" class="form-control" value="0" name="leaveAllowance"
                                        id="leaveAllowance">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Serevance Pay</label>
                                    <input type="text" class="form-control" value="0" name="serevancePay"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Leave & O/stand</label>
                                    <input type="text" class="form-control" value="0" name="leaveStand"
                                        id="leaveStand">
                                    <input type="number" name="leave_entitled" id="leave_entitled" hidden>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Teller Allowance</label>
                                    <input type="text" class="form-control" value="0" name="tellerAllowance"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Arrears</label>
                                    <input type="text" class="form-control" value="0" name="arrears"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Discr Exgracia</label>
                                    <input type="text" class="form-control" value="0" name="exgracia"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Bonus</label>
                                    <input type="text" class="form-control" value="0" name="bonus"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Long Serving</label>
                                    <input type="text" class="form-control" value="0" name="longServing"
                                        id="">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">Other Non Taxable Payments </label>
                                    <input type="text" class="form-control" value="0" name="otherPayments"
                                        id="">
                                </div>
                            </div>
                            <input type="hidden" class="form-control" value="0" name="employee_actual_salary"
                                id="employee_actual_salary">


                            <p class="text-secondary font-weight-bolder">
                                <hr>
                                DEDUCTION DETAILS
                            </p>

                            <div class="row">

                                <div class="col-md-6 form-group">
                                    <label for="">Salary Advances</label>
                                    <input type="text" value="0" name="salaryAdvance" class="form-control"
                                        id="">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">Outstanding Loan Balance</label>
                                    <input type="text" class="form-control" value="0" name="loan_balance"
                                        id="">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">Any Other Deductions</label>
                                    <input type="text" class="form-control" value="0" name="otherDeductions"
                                        id="">
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
        $('#terminationDate').change(function(e) {
            var terminationDate = document.getElementById("terminationDate").value;
            var employeeID = document.getElementById("employeeID").value;




            //e.preventDefault();
            $.ajax({
                    url: "<?php echo url(''); ?>/flex/get_employee_available_info",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    data: {
                        "terminationDate": terminationDate,
                        "employeeID": employeeID,
                    },
                    //  processData:false,
                    //  contentType:false,
                    //  cache:false,
                    //  async:false
                })
                .done(function(data) {
                    var data = JSON.parse(data);

                    //alert(data.leave_allowance);
                    var deligate = data.deligate;
                    if(deligate > 0){
                        $("#deligation").show();
                    }else{
                        $("#deligation").hide();
                    }

                    document.getElementById("leaveAllowance").value = data.leave_allowance;
                    document.getElementById("salaryEnrollment").value = data.employee_salary;
                    document.getElementById("employee_actual_salary").value = data.employee_actual_salary;
                    document.getElementById("leave_entitled").value = data.leave_entitled;






                })
                .fail(function() {
                    alert('Update Failed!! ...');
                });

        });
    </script>

    <script type="text/javascript">
        $('#leaveStand').change(function(e) {
             var leaveStand = document.getElementById("leaveStand").value;
            var salaryEnrollment = document.getElementById("employee_actual_salary").value;
            var leave_entitled = document.getElementById("leave_entitled").value;

            // alert(leave_entitled);

            var leave_pay = (leaveStand / leave_entitled) * salaryEnrollment;

            document.getElementById("leavePay").value = leave_pay;


            //number formatter
            // alert(numberWithCommas(leaveStand));




        });


        // $('input.number').keyup(function(event) {

        //     // skip for arrow keys
        //     if (event.which >= 37 && event.which <= 40) {
        //         event.preventDefault();
        //     }

        //     $(this).val(function(index, value) {
        //         value = value.replace(/,/g, ''); // remove commas from existing input
        //         return numberWithCommas(value); // add commas back in
        //     });
        // });

        function numberWithCommas(x) {
            var parts = x.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return parts.join(".");
        }
    </script>
@endpush
