
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php
?>

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

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Employee</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit Employee</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> <br>
                        <?php

                     echo session("note");  ?>

                        <div class="col-lg-12">
                            <div class="col-lg-6">

                                <!--First Name-->
                                <form id="updateFirstName" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackFname"></div>
                                        <div class="form-group">
                                            <label for="stream">First Name</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" name="fname" value="<?php echo $fname; ?>"
                                                    class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!--Middle Name-->
                                <form id="updateMiddleName" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackMname"></div>
                                        <div class="form-group">
                                            <label for="stream">Middle Name</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" name="mname" value="<?php echo $mname; ?>"
                                                    class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!--Last Name-->
                                <form id="updateLastName" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackLname"></div>
                                        <div class="form-group">
                                            <label for="stream">Last Name</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" name="lname" value="<?php echo $lname; ?>"
                                                    class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!--Last Name-->
                                <form id="updateOldID" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackOldID"></div>
                                        <div class="form-group">
                                            <label for="stream">Old Employee ID</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" name="old_id" value="<?php echo $old_empID; ?>"
                                                    class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!--Gender-->
                                <form id="updateGender" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackGender"></div>
                                        <div class="form-group">
                                            <label for="stream">Gender</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <label class="containercheckbox">Male
                                                    <input <?php if($gender == 'Male'){ ?> checked <?php } ?>
                                                        type="radio" value="Male" name="gender">
                                                    <span class="checkmarkradio"></span>
                                                </label>
                                                <label class="containercheckbox">Female
                                                    <input <?php if($gender == 'Female'){ ?> checked <?php } ?>
                                                        type="radio" value="Female" name="gender">
                                                    <span class="checkmarkradio"></span>
                                                </label>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>



                                <!--Profile-->
                                <form id="updateExpatriate" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackExpatriate"></div>
                                        <div class="form-group">
                                            <label for="stream">Profile </label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <label class="containercheckbox">Expatriate
                                                    <input <?php if($expatriate  == 1){ ?> checked <?php } ?>
                                                        type="radio" value="1" name="expatriate">
                                                    <span class="checkmarkradio"></span>
                                                </label>
                                                <label class="containercheckbox">Normal Employee
                                                    <input <?php if($expatriate  == 0){ ?> checked <?php } ?>
                                                        type="radio" value="0" name="expatriate">
                                                    <span class="checkmarkradio"></span>
                                                </label>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <!-- Position -->
                                <!--                    <form id="updatePosition" class="form-horizontal form-label-left"> -->
                                <!--                        <div class="col-sm-9">-->
                                <!--                        <div id ="feedBackPosition"></div>-->
                                <!--                        --><?php //if($positionTransfer>0 || $departmentTransfer>0 || $branchTransfer>0){ ?>
                                <!--                        <p class='alert alert-warning text-center'>The Request For Department or  Position Transfer on this Employee is Already Pending For Approval</p>-->
                                <!--                        --><?php //} ?>
                                <!--                          <div class="form-group">-->
                                <!--                            <label for="stream" >Position</label>-->
                                <!--                             <div class="input-group">-->
                                <!--                                <input hidden name ="empID" value="--><?php //echo $empID; ?>
                                <!--">-->
                                <!--                                <input hidden name ="old" value="--><?php //echo $positionID; ?>
                                <!--">-->
                                <!--                                <select required name="position" class="select1_single form-control" tabindex="-1">-->
                                <!--                                   --><?php //foreach ($pdrop as $row){ ?>
                                <!--                                  <option --><?php //if($positionID == $row->id){ ?>
                                <!-- selected="" --><?php //} ?>
                                <!--  value="--><?php //echo $row->id; ?>
                                <!--">--><?php //echo $row->name; ?>
                                <!--</option> --><?php //} ?>
                                <!--                                </select>-->
                                <!--                                <span class="input-group-btn">-->
                                <!--                                  <button --><?php //if($positionTransfer>0 || $departmentTransfer>0){ ?>
                                <!--disabled="" --><?php //} ?>
                                <!-- class="btn btn-primary">UPDATE</button>-->
                                <!--                                </span>-->
                                <!--                              </div>-->
                                <!--                          </div>-->
                                <!--                        </div>-->
                                <!--                    </form>                    -->


                                <!--Position and Department-->
                                <form id="updateDeptPos" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackDeptPos"></div>
                                        <?php if($positionTransfer>0 || $departmentTransfer>0 || $branchTransfer>0){ ?>
                                        <p class='alert alert-warning text-center'>The Request For Department or
                                            Position Transfer on this Employee is Already Pending For Approval</p>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label for="stream">Department</label>
                                            <span class="badge bg-green"><?php echo $department;?></span>
                                            <div class="input-group">
                                                <div class="input-group">
                                                    <input hidden name="empID" value="<?php echo $empID; ?>">
                                                    <input hidden name="oldPosition" value="<?php echo $positionID; ?>">
                                                    <input hidden name="oldDepartment"
                                                        value="<?php echo $departmentID; ?>">
                                                    <select required id='department' name="department"
                                                        class="select3_single form-control">
                                                        <option></option>
                                                        <?php foreach ($ddrop as $row){ ?>
                                                        <option value="<?php echo $row->id; ?>">
                                                            <?php echo $row->name; ?></option> <?php } ?>
                                                    </select>
                                                    <label for="stream">Position</label>
                                                    <span class="badge bg-green"><?php echo $position;?></span>
                                                    <select required id="pos" name="position"
                                                        class="select1_single form-control" tabindex="-1">
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button
                                                            <?php if($positionTransfer>0 || $departmentTransfer>0){ ?>disabled=""
                                                            <?php } ?> class="btn btn-primary">UPDATE</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Position -->
                                <form id="updateBranch" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackBranch"></div>
                                        <div class="form-group">
                                            <label for="stream">Company Branch</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <!-- <input hidden name ="old" value="<?php echo $branchCode; ?>"> -->
                                                <select required="" name="branch" class="select1_single form-control"
                                                    tabindex="-1">
                                                    <?php foreach ($branchdrop as $row){ ?>
                                                    <option <?php if($branchCode == $row->code){ ?> selected=""
                                                        <?php } ?> value="<?php echo $row->code; ?>">
                                                        <?php echo $row->name; ?></option> <?php } ?>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Position -->
                                <form id="updateNationality" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackNationality"></div>
                                        <div class="form-group">
                                            <label for="stream">Nationality</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <select required="" name="nationality"
                                                    class="select1_single form-control" tabindex="-1">
                                                    <?php foreach ($countrydrop as $row){ ?>
                                                    <option <?php if($nationality == $row->code){ ?> selected=""
                                                        <?php } ?> value="<?php echo $row->code; ?>">
                                                        <?php echo $row->name; ?></option> <?php } ?>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>



                                <!-- Merital Status -->
                                <form id="updateMeritalStatus" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackMeritalStatus"></div>
                                        <div class="form-group">
                                            <label for="stream">Merital Status</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <select required name="merital_status"
                                                    class="select_merital_status form-control" tabindex="-1">
                                                    <option <?php if($merital_status == "Single"){ ?> selected=""
                                                        <?php } ?> value="Single">Single</option>
                                                    <option <?php if($merital_status == "Married"){ ?> selected=""
                                                        <?php } ?> value="Married">Married</option>
                                                    <option <?php if($merital_status == "Widowed"){ ?> selected=""
                                                        <?php } ?> value="Widowed">Widowed</option>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <!-- Line Manager -->
                                <form id="updateLineManager" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackLineManager"></div>
                                        <div class="form-group">
                                            <label for="stream">Line Manager</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <select required name="line_manager" class="select2_single form-control"
                                                    tabindex="-1">
                                                    <option></option>
                                                    <?php foreach ($ldrop as $row){ ?>
                                                    <option <?php if($line_managerID == $row->empID){ ?> selected=""
                                                        <?php } ?> value="<?php echo $row->empID; ?>">
                                                        <?php echo $row->NAME; ?></option> <?php } ?>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <!-- Code -->
                                <form id="updateCode" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackLineManager"></div>
                                        <div class="form-group">
                                            <label for="stream">Code</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" name="emp_code" value="<?php echo $emp_code; ?>"
                                                    class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- level -->
                                <form id="updateLevel" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackLineManager"></div>
                                        <div class="form-group">
                                            <label for="stream">Level</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" name="emp_level" value="<?php echo $emp_level; ?>"
                                                    class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- picture-->


                                <form id="updateEmployeePhoto" enctype="multipart/form-data"
                                    class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackEmployeePhoto"></div>
                                        <div class="form-group">
                                            <label for="stream">Employee Picture</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input required type='file' id="imgInp" name='userfile' />
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                        <img height="250px" width="250px" style="border-radius: 50%;" id="blah"
                                            src="<?php echo url('uploads/userprofile/').$photo; ?>"
                                            alt="Current Employee Picture" />
                                    </div>
                                </form>


                            </div>
                            <div class="col-lg-6">

                                <!--Middle Salary-->
                                <form id="updateSalary" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackSalary"></div>
                                        <?php if($salaryTransfer>0){ ?>
                                        <p class='alert alert-warning text-center'>The Request For Salary Updation on
                                            this Employee is Already Pending For Approval</p>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label for="stream">Salary</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input hidden name="old" value="<?php echo $salary; ?>">
                                                <input type="text" name="salary" value="<?php echo $salary; ?>"
                                                    class="form-control">
                                                <span class="input-group-btn">
                                                    <button <?php if($salaryTransfer>0){ ?> disabled="" <?php } ?>
                                                        class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>



                                <!--Bank Information-->
                                <form id="updateBank_Bankbranch" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackBank_Bankbranch"></div>
                                        <?php if($pendingPayroll>0){ ?>
                                        <p class='alert alert-warning text-center'>Updating Employee Bank Information is
                                            Not Allowed When There is Pending Payroll</p>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label for="stream">Bank</label>
                                            <span class="badge bg-green"><?php echo $bankName;?></span>
                                            <div class="input-group">
                                                <div class="input-group">
                                                    <input hidden name="empID" value="<?php echo $empID; ?>">
                                                    <select required id='bank' name="bank"
                                                        class="select_bank form-control">
                                                        <option value="">Select Employee Bank</option>
                                                        <?php foreach ($bankdrop as $row){ ?>
                                                        <option value="<?php echo $row->id; ?>">
                                                            <?php echo $row->name; ?></option> <?php } ?>
                                                    </select>
                                                    <label for="stream">Branch</label>
                                                    <span class="badge bg-green"><?php echo $bankBranch;?></span>
                                                    <select required id="bank_branch" name="bank_branch"
                                                        class="select_bank_branch form-control" tabindex="-1">
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button <?php if($pendingPayroll>0){ ?> disabled="" <?php } ?>
                                                            class="btn btn-primary">UPDATE</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>



                                <!-- Bank Account No-->
                                <form id="updateBankAccountNo" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackBankAccountNo"></div>
                                        <div class="form-group">
                                            <label for="stream">Account No</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" required="" name="acc_no"
                                                    value="<?php echo $account_no; ?>" class="form-control">
                                                <span class="input-group-btn">
                                                    <button <?php if($pendingPayroll>0){ ?> disabled="" <?php } ?>
                                                        class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!--Middle Email-->
                                <form id="updateEmail" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackEmail"></div>
                                        <div class="form-group">
                                            <label for="stream">Email</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" required="" name="email"
                                                    value="<?php echo $email; ?>" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Postal Address-->
                                <form id="updatePostAddress" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackPostAddress"></div>
                                        <div class="form-group">
                                            <label for="stream">Postal Address</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" required="" name="address"
                                                    value="<?php echo $postal_address; ?>" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Postal city-->
                                <form id="updatePostCity" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackPostCity"></div>
                                        <div class="form-group">
                                            <label for="stream">Postal city</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" required="" name="city"
                                                    value="<?php echo $postal_city; ?>" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Physical Address-->
                                <form id="updatePhysicalAddress" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackPhysicalAddress"></div>
                                        <div class="form-group">
                                            <label for="stream">Physical Address</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" required="" name="phys_address"
                                                    value="<?php echo $physical_address; ?>" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Line Manager -->
                                <form id="updateContract" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackContract"></div>
                                        <div class="form-group">
                                            <label for="stream">Contract Type</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <select required name="contract" class="select_contract form-control"
                                                    tabindex="-1">
                                                    <option></option>
                                                    <?php foreach ($contract as $row){ ?>
                                                    <option <?php if($ctype == $row->id){ ?> selected="" <?php } ?>
                                                        value="<?php echo $row->id; ?>"><?php echo $row->name; ?>
                                                    </option> <?php } ?>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Mobile-->
                                <form id="updateMobile" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackMobile"></div>
                                        <div class="form-group">
                                            <label for="stream">Mobile</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" required="" name="mobile"
                                                    value="<?php echo $mobile; ?>" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Home Address-->
                                <form id="updateHomeAddress" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackHomeAddress"></div>
                                        <div class="form-group">
                                            <label for="stream">Home Address</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" required="" name="home_address"
                                                    value="<?php echo $home_address; ?>" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>



                                <!-- Pension-->
                                <form id="updatePensionFund" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackPension"></div>
                                        <div class="form-group">
                                            <label for="stream">Pension Fund</label>
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
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <!-- Pension-->
                                <form id="updatePensionFundNo" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackPensionFundNo"></div>
                                        <div class="form-group">
                                            <label for="stream">Pension Fund No</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" required="" name="pension_no"
                                                    value="<?php echo $pf_membership_no; ?>" class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <form id="updateNationalID" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackNationalID"></div>
                                        <div class="form-group">
                                            <label for="stream">National ID</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" name="nationalid" value="<?php echo $national_id; ?>"
                                                    class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <form id="updateTin" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackTin"></div>
                                        <div class="form-group">
                                            <label for="stream">TIN</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" name="tin" value="<?php echo $tin; ?>"
                                                    class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <form id="updatedob" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackDob"></div>
                                        <div class="form-group">
                                            <label for="stream">DATE OF BIRTH</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" name="dob" value="<?php echo $birthdate; ?>"
                                                    class="form-control">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <!-- contract start-->
                                <form id="updateContractStart" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackContractStart"></div>
                                        <div class="form-group">
                                            <label for="stream">Contract Start</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" required name="contract_start"
                                                    value="<?php echo $hire_date?>" placeholder="Contract Start Date"
                                                    class="form-control col-xs-12 has-feedback-left" id="contract_start"
                                                    aria-describedby="inputSuccess2Status">
                                                <span class="fa fa-calendar-o form-control-feedback right"
                                                    aria-hidden="true"></span>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <!-- contract end-->
                                <form id="updateContractEnd" class="form-horizontal form-label-left">
                                    <div class="col-sm-9">
                                        <div id="feedBackContractEnd"></div>
                                        <div class="form-group">
                                            <label for="stream">Contract End</label>
                                            <div class="input-group">
                                                <input hidden name="empID" value="<?php echo $empID; ?>">
                                                <input type="text" required name="contract_end"
                                                    value="<?php echo $contract_end?>" placeholder="Contract End Date"
                                                    class="form-control col-xs-12 has-feedback-left" id="contract_end"
                                                    aria-describedby="inputSuccess2Status">
                                                <span class="fa fa-calendar-o form-control-feedback right"
                                                    aria-hidden="true"></span>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary">UPDATE</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                            </div>

                        </div>
                        <!-- test -->
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>
<!-- /page content -->

<?php 
      
     @include("app/includes/dropdown")
     @include("app/includes/update_employee")
     
?>
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
 @endsection