
@extends('layouts.vertical', ['title' => 'Update Employee'])

@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')

<!-- page content -->
<?php
                foreach ($employee as $row) {

                  $name = $row->fname." ".$row->mname." ".$row->lname;
                  $fname = $row->fname;
                  $mname = $row->mname;
                  $lname = $row->lname;
                  $pension_fund_id= $row->pension_fund;
                  $department = $row->deptname;
                  $branch = $row->branch_name;
                  $branchCode = $row->branch;
                  $emp_code = $row->emp_code;
                  $emp_level = $row->emp_level;
                  $empID = $row->emp_id;
                  $old_empID = $row->old_emp_id;
                  $gender = $row->gender;
                  $merital_status = $row->merital_status;
                  $birthdate = $row->birthdate;
                  $hire_date = $row->hire_date;
                  $contract_end = $row->contract_end;
                  $departmentID = $row->department;
                  $position = $row->pName;
                  $bankName = $row->bankName;
                  $bankBranch = $row->bankBranch;
                  $positionID = $row->position;
                  $ctype = $row->contract_type;
                  $emp_shift = $row->shift;
                  $line_managerID = $row->line_manager;
                  $linemanager = $row->LINEMANAGER;
                  $pf_membership_no = $row->pf_membership_no;
                  $account_no = $row->account_no;
                  $mobile = $row->mobile;
                  $salary = $row->salary;
                  $nationality = $row->nationality;
                  $email = $row->email;
                  $photo = $row->photo;
                  $postal_address = $row->postal_address;
                  $postal_city = $row->postal_city;
                  $physical_address = $row->physical_address;
                  $home_address = $row->home;
                  $expatriate = $row->is_expatriate;
                  $national_id = $row->national_id;
                  $tin = $row->tin;
 }  ?>


<div class="card">
    <div class="card-header">
        <h5 class="text-main mb-0">Account settings</h5>

        <div class="mt-2">
            <?php echo session("note");  ?>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateFirstName">
                        <div id="feedBackFname"></div>
                        <label for="stream" class="form-label">First Name</label>
                        <div class="input-group">
                            <input type="text" name="fname" value="<?php echo $fname; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateMiddleName">
                        <div id="feedBackMname"></div>
                        <label for="stream" class="form-label">Middle Name</label>
                        <div class="input-group">
                            <input type="text" name="mname" value="<?php echo $mname; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateLastName">
                        <div id="feedBackLname"></div>
                        <label for="stream" class="form-label">Last Name</label>
                        <div class="input-group">
                            <input type="text" name="lname" value="<?php echo $lname; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateGender">
                        <div id="feedBackGender"></div>
                        <label for="stream" class="form-label">Gender</label>
                        <div>
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="gender" value="Male" id="dc_li_c" {{ ($gender == 'Male') ? 'checked' : null }}>
                                <label class="ms-2" for="dc_li_c">Male</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="gender" value="Female" id="dc_li_u" {{ ($gender == 'Female') ? 'checked' : null }}>
                                <label class="ms-2" for="dc_li_u">Female</label>
                            </div>

                            <button class="btn btn-main ms-5">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateEmail">
                        <div id="feedBackEmail"></div>
                        <label for="stream" class="form-label">Email</label>
                        <div class="input-group">
                            <input type="text" required name="email" value="<?php echo $email; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateMobile">
                        <div id="feedBackMobile"></div>
                        <label for="stream" class="form-label">Mobile</label>
                        <div class="input-group">
                            <input type="text" required="" name="mobile" value="<?php echo $mobile; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updatedob">
                        <div id="feedBackDob"></div>
                        <label for="stream" class="form-label">Date of birth</label>
                        <div class="input-group">
                            <input type="text" name="dob" value="<?php echo $birthdate; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateEmployeePhoto" enctype="multipart/form-data">
                        <div id="feedBackEmployeePhoto"></div>
                        <label for="stream" class="form-label">Employee Picture</label>

                        <div class="input-group">
                            <input required type='file' id="imgInp" name='userfile' class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                        <small class="text-muted">The size of the image should not exced 30MB</small>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateMeritalStatus">
                        <div id="feedBackMeritalStatus"></div>
                        <label for="stream" class="form-label">Merital Status</label>

                        <div class="input-group">
                            <select required name="merital_status" class="select_merital_status form-control" tabindex="-1">
                                <option <?php if($merital_status == "Single"){ ?> selected=""
                                    <?php } ?> value="Single">Single</option>
                                <option <?php if($merital_status == "Married"){ ?> selected=""
                                    <?php } ?> value="Married">Married</option>
                                <option <?php if($merital_status == "Widowed"){ ?> selected=""
                                    <?php } ?> value="Widowed">Widowed</option>
                            </select>
                            <button class="btn btn-main">UPDATE</button>

                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateExpatriate">
                        <div id="feedBackExpatriate"></div>
                        <label for="stream" class="form-label">Profile </label>
                        <div>
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="gender" value="1" id="dm1" {{ ($expatriate  == 1) ? 'checked' : null }}>
                                <label class="ms-2" for="dm1">Expatriate</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="gender" value="0" id="dm2" {{ ($expatriate  == 0) ? 'checked' : null }}>
                                <label class="ms-2" for="dm2">Normal Employee</label>
                            </div>

                            <button class="btn btn-main ms-5">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateOldID">
                        <div id="feedBackOldID"></div>
                        <label for="stream" class="form-label">Old Employee ID</label>
                        <div class="input-group">
                            <input type="text" name="old_id" value="<?php echo $old_empID; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateNationality">
                        <div id="feedBackNationality"></div>
                        <label for="stream" class="form-label">Nationality</label>
                        <div class="input-group">
                            <select required="" name="nationality" class="select1_single form-control select" data-width="1%">
                                <?php foreach ($countrydrop as $row){ ?>
                                <option <?php if($nationality == $row->code){ ?> selected=""<?php } ?> value="<?php echo $row->code; ?>"><?php echo $row->name; ?></option>
                                <?php } ?>
                            </select>
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateDeptPos">
                        <div id="feedBackDeptPos"></div>

                        <?php if($positionTransfer > 0 || $departmentTransfer > 0 || $branchTransfer > 0){ ?>
                        <p class='alert alert-warning text-center mt-2'>
                            The Request For Department or Position Transfer on this Employee is Already Pending For Approval
                        </p>
                        <?php } ?>

                        <label for="stream" class="form-label">Department <span class="badge bg-green"><?php echo $department;?> Good</span></label>

                        <select required id='department' name="department" class="select3_single form-control select">
                            <option> Select Department </option>
                            <?php foreach ($ddrop as $row){ ?>
                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                            <?php } ?>
                        </select>

                        <input hidden name="empID" value="<?php echo $empID; ?>">
                        <input hidden name="oldPosition" value="<?php echo $positionID; ?>">
                        <input hidden name="oldDepartment" value="<?php echo $departmentID; ?>">

                        <label for="stream" class="form-label mt-2">Position <span class="badge bg-green"><?php echo $position;?></span></label>

                        <select required id="pos" name="position" class="select1_single form-control select" tabindex="-1"></select>

                        <button <?php if($positionTransfer>0 || $departmentTransfer>0){ ?>disabled <?php } ?> class="btn btn-main mt-2">UPDATE</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                     <form id="updateBranch">
                        <div id="feedBackBranch"></div>
                        <label for="stream" class="form-label">Company Branch</label>
                        <div class="input-group">
                            <!-- <input hidden name ="old" value="<?php echo $branchCode; ?>"> -->
                            <select required="" name="branch" class="select1_single form-control select" data-width="1%">
                                <?php foreach ($branchdrop as $row){ ?>
                                <option <?php if($branchCode == $row->code){ ?> selected <?php } ?> value="<?php echo $row->code; ?>"> <?php echo $row->name; ?></option>
                                <?php } ?>
                            </select>
                            <button class="btn btn-main">UPDATE</button>
                        </div>

                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                     <form id="updateLineManager">
                        <div id="feedBackLineManager"></div>
                        <label for="stream" class="form-label">Line Manager</label>

                        <div class="input-group">
                            <select required name="line_manager" class="select2_single form-control select" data-width="1%">
                                <option> Select Line Manager </option>
                                <?php foreach ($ldrop as $row){ ?>
                                <option <?php if($line_managerID == $row->empID){ ?> selected <?php } ?> value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option>
                                <?php } ?>
                            </select>
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                     <form id="updateCode">
                        <div id="feedBackLineManager"></div>
                        <label for="stream" class="form-label">Code</label>

                        <div class="input-group">
                            <input type="text" name="emp_code" value="<?php echo $emp_code; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                     <form id="updateLevel">
                        <div id="feedBackLineManager"></div>
                        <label for="stream" class="form-label">Level</label>
                        <input hidden name="empID" value="<?php echo $empID; ?>">

                        <div class="input-group">
                            <input type="text" name="emp_level" value="<?php echo $emp_level; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateSalary">
                        <div id="feedBackSalary"></div>

                        <?php if($salaryTransfer>0){ ?>
                        <p class='alert alert-warning text-center'>
                            The Request For Salary Updation on this Employee is Already Pending For Approval
                        </p>
                        <?php } ?>

                        <label for="stream" class="form-label">Salary</label>

                        <div class="input-group">
                            <input type="text" name="salary" value="<?php echo $salary; ?>" class="form-control">
                            <button <?php if( $salaryTransfer > 0){ ?> disabled <?php } ?> class="btn btn-main">UPDATE</button>
                        </div>

                        <input hidden name="old" value="<?php echo $salary; ?>">
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateBank_Bankbranch">
                        <div id="feedBackBank_Bankbranch"></div>

                        <?php if($pendingPayroll>0){ ?>
                        <p class='alert alert-warning text-center'>
                            Updating Employee Bank Information is Not Allowed When There is Pending Payroll
                        </p>
                        <?php } ?>

                        <label for="stream" class="form-label">Bank <span class="badge bg-green"><?php echo $bankName;?></span> </label>

                        <input hidden name="empID" value="<?php echo $empID; ?>">

                        <select required id='bank' name="bank" class="select_bank form-control select">
                            <option value="">Select Employee Bank</option>
                            <?php foreach ($bankdrop as $row){ ?>
                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                            <?php } ?>
                        </select>

                        <label for="stream" class="form-label mt-2">Branch <span class="badge bg-green"><?php echo $bankBranch;?></span></label>

                        <select required id="bank_branch" name="bank_branch" class="select_bank_branch form-control select" tabindex="-1"></select>

                        <button <?php if($pendingPayroll>0){ ?> disabled <?php } ?> class="btn btn-main mt-2">UPDATE</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateBankAccountNo">
                        <div id="feedBackBankAccountNo"></div>
                        <label for="stream" class="form-label">Account No</label>
                        <div class="input-group">
                            <input type="text" required="" name="acc_no" value="<?php echo $account_no; ?>" class="form-control">
                            <button <?php if($pendingPayroll>0){ ?> disabled <?php } ?> class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateContract">
                        <div id="feedBackContract"></div>
                        <label for="stream" class="form-label">Contract Type</label>

                        <div class="input-group">
                            <select required name="contract" class="select_contract form-control" data-width="1%">
                                <option> Select </option>
                                <?php foreach ($contract as $row){ ?>
                                <option <?php if($ctype == $row->id){ ?> selected="" <?php } ?>value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                <?php } ?>
                            </select>
                            <button class="btn btn-main">UPDATE</button>
                        </div>

                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateContractStart">
                        <div id="feedBackContractStart"></div>
                        <label for="stream" class="form-label">Contract Start</label>

                        <div class="input-group">
                            <span class="input-group-text"><i class="ph-calendar"></i></span>
                            <input type="text" required name="contract_start" value="<?php echo $hire_date?>" placeholder="Contract Start Date" class="form-control daterange-single" id="contract_start">
                            <button class="btn btn-main">UPDATE</button>
                        </div>

                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateContractEnd">
                        <div id="feedBackContractEnd"></div>
                        <label for="stream" class="form-label">Contract End</label>

                        <div class="input-group">
                            <span class="input-group-text"><i class="ph-calendar"></i></span>
                            <input type="text" required name="contract_end" value="<?php echo $contract_end?>" placeholder="Contract End Date" class="form-control" id="contract_end">
                            <button class="btn btn-main">UPDATE</button>
                        </div>

                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <form id="updatePostAddress">
                        <div id="feedBackPostAddress"></div>

                        <label for="stream" class="form-label">Postal Address</label>

                        <div class="input-group">
                            <input type="text" required name="address" value="<?php echo $postal_address; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>

                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <form id="updatePostCity">
                        <div id="feedBackPostCity"></div>

                        <label for="stream" class="form-label">Postal city</label>

                        <div class="input-group">
                            <input type="text" required="" name="city" value="<?php echo $postal_city; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>

                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <form id="updatePhysicalAddress">
                        <div id="feedBackPhysicalAddress"></div>

                        <label for="stream" class="form-label">Physical Address</label>

                        <div class="input-group">
                            <input type="text" required="" name="phys_address" value="<?php echo $physical_address; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>

                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateHomeAddress">
                        <div id="feedBackHomeAddress"></div>
                        <label for="stream" class="form-label">Home Address</label>
                        <div class="input-group">
                            <input type="text" required="" name="home_address" value="<?php echo $home_address; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updatePensionFund">
                        <div id="feedBackPension"></div>

                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="stream" class="form-label">Pension Fund</label>
                                <div class="input-group">
                                    <input hidden name="empID" value="<?php echo $empID; ?>">
                                    <select required name="pension_fund" class="select2_single form-control"
                                        tabindex="-1">
                                        <option></option>
                                        <?php foreach ($pension as $row){ ?>
                                        <option <?php if($pension_fund_id == $row->id){ ?> selected=""
                                            <?php } ?> value="<?php echo $row->id; ?>">
                                            <?php echo $row->name; ?></option> <?php } ?>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-main">UPDATE</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updatePensionFundNo">
                        <div class="col-sm-9">
                            <div id="feedBackPensionFundNo"></div>
                            <div class="form-group">
                                <label for="stream" class="form-label">Pension Fund No</label>
                                <div class="input-group">
                                    <input hidden name="empID" value="<?php echo $empID; ?>">
                                    <input type="text" required="" name="pension_no"
                                        value="<?php echo $pf_membership_no; ?>" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-main">UPDATE</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateNationalID">
                        <div id="feedBackNationalID"></div>
                        <label for="stream" class="form-label">National ID</label>
                        <div class="input-group">
                            <input type="text" name="nationalid" value="<?php echo $national_id; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <form id="updateTin">
                        <div id="feedBackTin"></div>
                        <label for="stream" class="form-label">TIN</label>
                        <div class="input-group">
                            <input type="text" name="tin" value="<?php echo $tin; ?>" class="form-control">
                            <button class="btn btn-main">UPDATE</button>
                        </div>
                        <input hidden name="empID" value="<?php echo $empID; ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





     {{-- @include("app/includes/dropdown") --}}
     {{-- @include("app/includes/update_employee") --}}


@endsection

@push('footer-script')
<script>
    $(document).ready(function() {

        $('#bank').on('change', function() {
            var bankID = $(this).val();
            if (bankID) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo  url(''); ?>/flex/bankBranchFetcher/',
                    data: 'bank=' + bankID,
                    success: function(html) {
                        $('#bank_branch').html(html);
                    }
                });
            } else {
                $('#bank_branch').html('<option >Select Bank First</option>');
            }
        });
    });
    </script>

    <script>
    $(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear() - 18;
        var endYear = today.getFullYear() - 60;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }


        var dateStart = dd + '/' + mm + '/' + startYear;
        var dateEnd = dd + '/' + mm + '/' + endYear;
        $('#contract_start').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'), 100),
            minDate: dateEnd,
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_2"
        }, function(start, end, label) {

        });
        $('#contract_start').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#contract_start').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });

    $(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear() - 18;
        var endYear = today.getFullYear() - 60;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }


        var dateStart = dd + '/' + mm + '/' + startYear;
        var dateEnd = dd + '/' + mm + '/' + endYear;
        $('#contract_end').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'), 100),
            minDate: dateEnd,
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_2"
        }, function(start, end, label) {

        });
        $('#contract_end').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#contract_end').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
    </script>

    <script>
    $('#updateContractStart').submit(function(e) {
        e.preventDefault();
        $.ajax({
                url: "<?php echo  url(''); ?>/flex/updateContractStart",
                type: "post",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false
            })
            .done(function(data) {
                $('#feedBackContractStart').fadeOut('fast', function() {
                    $('#feedBackContractStart').fadeIn('fast').html(data);
                });
                setTimeout(function() { // wait for 2 secs(2)
                    $("#feedBackContractStart").load(
                    " #feedBackContractStart"); // then reload the div to clear the success notification
                }, 2000);
                //   $('#updateName')[0].reset();
            })
            .fail(function() {
                alert('Updation Failed!! ...');
            });
    });

    $('#updateContractEnd').submit(function(e) {
        e.preventDefault();
        $.ajax({
                url: "<?php echo  url(''); ?>/flex/updateContractEnd",
                type: "post",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false
            })
            .done(function(data) {
                $('#feedBackContractEnd').fadeOut('fast', function() {
                    $('#feedBackContractEnd').fadeIn('fast').html(data);
                });
                setTimeout(function() { // wait for 2 secs(2)
                    $("#feedBackContractEnd").load(
                    " #feedBackContractEnd"); // then reload the div to clear the success notification
                }, 2000);
                //   $('#updateName')[0].reset();
            })
            .fail(function() {
                alert('Updation Failed!! ...');
            });
    });
    </script>
@endpush
