<div role="tabpanel" class="tab-pane " id="page3" aria-labelledby="asset-tab">

    <div class="card  rounded-0 border-0 shadow-none">
        <div class="card-header">
            <h5 class="text-main">EMPLOYMENT HISTORY: </h5>
        </div>
        <div class="row p-2">

            <div class="col-md-12">
                <div class="card border-top border-top-width-3 border-top-main  rounded-0 p-2">
                    <h5>Emmergency Contact Details</h5>
                    <p>
                        <small>
                        <i>
                        *
                        For Emergency Purpose
                        </i>
                        </small>
                        </p>

                        <form action="{{ route('flex.saveEmployeeEmergency') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">


                        <div class="row mb-2">

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="">First Name</label>
                                <input type="text" name="em_fname" @if($emergency) value="{{ $emergency->em_fname}}" @endif class="form-control">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="">Middle Name</label>
                                <input type="text" name="em_mname" @if($emergency) value="{{ $emergency->em_mname}}" @endif class="form-control">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="">Surname</label>
                                <input type="text" name="em_lname" @if($emergency) value="{{ $emergency->em_sname}}" @endif class="form-control">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="">Relationship</label>
                                <input type="text" name="em_relationship" @if($emergency) value="{{ $emergency->em_relationship}}" @endif id="" class="form-control">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="">Occupation</label>
                                <input type="text" name="em_occupation" @if($emergency) value="{{ $emergency->em_occupation}}" @endif id="" class="form-control">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="">Cellphone Number</label>
                                <input type="text" name="em_phone" @if($emergency) value="{{ $emergency->em_phone}}" @endif id="" class="form-control">
                            </div>


                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-main float-end"> Save Details</button>
                        </div>
                        </form>
                </div>


            </div>
            <div class="col-md-12">
                <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                    <h5 class="text-warning">Employment Details</h5>

                    <form action="{{ route('flex.saveDetailsEmployment') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">

                        <div class="row mb-2">
                            <div class="col-6 mb-2">
                                <label class="form-label" for="">Date of Employment</label>
                                <input type="date" name="employment_date" value="<?php echo $hire_date; ?>" class="form-control">
                            </div>

                            <div class="form-group col-6 mb-2">
                                <label class="form-label" for="">First Job Title</label>
                                <input type="text" name="former_title" @if($details) value="{{ $details->former_title}}" @endif class="form-control">
                            </div>

                            <div class="form-group col-6 mt-3">
                                <h5 class="form-label" for="">Current Job Title: <?php echo $title; ?></h5>

                                <p><b>Department</b>: <span><?php echo $department; ?></span></p>
                                <p><b>Branch</b>: <span><?php echo $branch; ?></span></p>

                            </div>



                            <div class="form-group col-12 mb-2">
                                <label class="form-label" for="">Line Manager</label>
                                <br>
                                <p>
                                    Current:
                                    @php
                                    $employee = App\Models\Employee::where('emp_id', $line_managerID)->first();
                                    @endphp

                                    @if ($employee)
                                        {{ $employee->full_name }}
                                    @else
                                        Line manager not found
                                    @endif
                                </p>

                                <label class="form-label" for="">Update Line Manager</label>
                                <select class="form-control select @error('line_manager') is-invalid @enderror" name="line_manager">
                                    <option value="<?php echo $line_managerID; ?>"> Select New Line Manager </option>
                                    @foreach ($employees as $depart)

                                    <option value="{{ $depart->emp_id }}" >{{ $depart->fname }}  {{ $depart->lname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="form-group col-12 mb-2">
                                <label class="form-label" for="">Head Of Department</label>
                                <input type="text" name="hod" value="" class="form-control">
                            </div> --}}



                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-main float-end"> Save Details</button>
                        </div>
                    </form>
                </div>


            </div>

        </div>

    </div>

 </div>
{{-- / --}}
