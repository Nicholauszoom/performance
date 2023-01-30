@extends('layouts.vertical', ['title' => 'Update Employee Details'])

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
<?php
    foreach ($employee as $row) {
        $name = $row->fname." ".$row->mname." ".$row->lname;
        $fname = $row->fname;
        $mname = $row->mname;
        $lname = $row->lname;
        $pension_fund_id= $row->pension_fund;
        $HELSB= $row->form_4_index;

        $department = $row->deptname;
        $branch = $row->branch_name;
        $branchCode = $row->branch;
        // $emp_code = $row->emp_code;
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
        $title=$row->job_title;
    }
 ?>

{{-- start of user credentials --}}

<div class="">


    <form action="{{ route('flex.saveDetails') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body border-0">
                    <ul class="nav nav-tabs nav-tabs-underline nav-justified nav-tabs-filled mb-3" id="tabs-target-right" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#profile" class="nav-link active show" data-bs-toggle="tab" aria-selected="true" role="tab" tabindex="-1">
                                Profile Picture
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#page1" class="nav-link  show" data-bs-toggle="tab" aria-selected="true" role="tab" tabindex="-1">
                                Basic Details
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a href="#page2" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                               Identification
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#page3" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                               Employment Info
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#page4" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                               Family Details
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a href="#page5" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                            Education Info
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#page6" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                               Employment Hist
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="myTabContent">
                         {{-- profile --}}
                         <div role="tabpanel" class="tab-pane fade active show " id="profile" aria-labelledby="work-tab">

                            <div class="card shadow-none">
                                <div class="card-header mb-2">
                                    <h5 class="text-main">PROFILE PICTURE: </h5>
                                </div>
                                @if (session('msg'))
                                <div class="alert alert-success col-md-10 mx-auto text-center mx-auto" role="alert">
                                {{ session('msg') }}
                                </div>
                                @endif

                                    <div class="col-md-12 mt-1">
                                        <div class="card border-0 shadow-none pb-4">
                                        <div class="sidebar-section-body text-center">
                                            <div class="card-img-actions d-inline-block my-3">
                                                <img class="img-fluid rounded-circle" src="{{ ($photo == 'user.png') ? 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=00204e&color=fff' : asset('uploads/userprofile/' . $photo) }}" width="60px" height="60px" alt="">
                                            </div>

                                            <h6 class="mb-0">{{ $name }}</h6>
                                            <span class="text-muted mb-3">{{ $position }}</span>
                                        </div>
                                        <div class="row mx-auto">
                                            <div class="col-md-7 mx-auto">
                                                    <label for="file" class="text-secondary font-weight-light">Upload New Passport Image</label>
                                                    <input type="file" name="image" id="image" class="form-control">
                                                    <input type="hidden" name="empID" value="<?php echo $empID; ?>">
                                            </div>


                                            <div class="col-md-4 mb-0 mx-auto ">
                                                  <label for="" class="text-white">.</label>
                                                  <button type="submit" class="btn text-light btn-main btn-block col-lg-12" >
                                                      <i class="fa fa-save"></i>
                                                      {{ __('Update Image') }}
                                                  </button>
                                            </div>

                                        </div>
                                        <ul class="nav nav-sidebar mt-3">
                                            <li class="nav-item-divider"></li>

                                            <li class="nav-item mx-auto my-1">

                                                {{-- <button type="button" class="btn btn-main" data-bs-toggle="modal" data-bs-target="#avatar-modal">
                                                    <i class="ph-image me-2"></i>
                                                    Change Image
                                                </button> --}}

                                                @if (session('mng_emp'))
                                                <a href="{{ route('flex.userdata', base64_encode($empID)) }}" class="btn btn-main">
                                                    <i class="ph-note-pencil me-2"></i>
                                                    View Biodata
                                                </a>
                                                @endif
                                            </li>
                                        </ul>
                                        </div>

                                    </div>

                            </div>

                        </div>

                    {{-- page 1 --}}
                    <div role="tabpanel" class="tab-pane fade show " id="page1" aria-labelledby="work-tab">

                        <div class="card shadow-none">
                            <div class="card-header">
                                <h5 class="text-main">BASIC DETAILS: </h5>
                            </div>
                            <div class="card-body ">

                                   {{--displaying all the errors  --}}
                                @if ($errors->any())
                                <div class="btn disabled btn-danger ">
                                    <div class="col-12">
                                        @foreach ($errors->all() as $error)
                                        <p>{{$error}}</p>
                                        @endforeach
                                    </div>

                                </div>

                                @endif


                                <div class="row">

                                    <div class="col-12">
                                        <div class="card p-2">
                                            <h5>Name Information</h5>

                                                <div class="row mb-2">
                                                    <label for="">Prefix</label>
                                                    <div class="form-group">
                                                        <input type="radio" id="Mr" @if($details) {{$details->prefix == "Mr." ? 'checked':'' }} @endif name="prefix" value="Mr.">
                                                        <label for="Mr">Mr.</label>
                                                        <input type="radio" id="Mrs" @if($details) {{$details->prefix == "Mrs." ? 'checked':'' }} @endif name="prefix" value="Mrs.">
                                                        <label for="Mrs">Mrs.</label>
                                                        <input type="radio" id="Miss" @if($details) {{$details->prefix == "Miss" ? 'checked':'' }} @endif name="prefix" value="Miss">
                                                        <label for="Miss">Miss</label>
                                                        <input type="radio" id="other" name="prefix" @if($details) {{$details->prefix == "Miss" ? 'checked':'' }} @endif value="Other">
                                                        <label for="other">Other</label>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">

                                                    <div class="form-group col-6">
                                                        <label for="">First Name</label>
                                                        <input type="text" name="fname" value="<?php echo $fname; ?>" class="form-control">
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label for="">Middle Name</label>
                                                        <input type="text" name="mname" value="<?php echo $mname; ?>" class="form-control">
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label for="">Surname</label>
                                                        <input type="text" name="lname" value="<?php echo $lname; ?>" class="form-control">
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label for="">Maiden Name</label>
                                                        <input type="text" name="maide_name" @if($details)if($details) value="{{ $details->maide_name }}" @endif class="form-control">
                                                    </div>
                                                    <p>
                                                    <small>
                                                    <i>Note:</i>  Please note that name change requests require a
                                                    copy of the legal documents verifying your new name
                                                    change. Acceptable forms of documentation include
                                                    marriage license, divorce decree or court order.
                                                    </small>
                                                    </p>
                                                </div>


                                                <div class="card-footer ">
                                                    <button type="submit" class="btn btn-main float-end"> Save Details</button>
                                                </div>

                                        </div>


                                    </div>
                                    <div class="col-12">
                                        <div class="card p-2">
                                            <h5>Biography Information</h5>


                                                <div class="row mb-2">

                                                    <div class="form-group col-6 mb-2">
                                                        <label for="">Date of Birth</label>
                                                        <input type="date" name="birthdate" value="<?php echo $birthdate; ?>" class="form-control">
                                                    </div>


                                                    <div class="form-group col-6 mb-2">
                                                        <label for="">Place of Birth</label>
                                                        <input type="text" name="birthplace" @if($details) value="{{ $details->birthplace}}" @endif   class="form-control">
                                                    </div>
                                                    <div class="form-group col-6 mb-2">
                                                        <label for="">Country of Birth</label>
                                                        <input type="text" name="birthcountry" @if($details) value="{{ $details->birthcountry}}" @endif   class="form-control">
                                                    </div>
                                                    <div class="form-group col-6 mb-2">
                                                        <label for="">Gender/ Sex</label>
                                                        <br>
                                                        <input type="radio" id="male" name="gender" @foreach($employee as $item) {{$item->gender == "Male" ? 'checked':'' }} @endforeach value="Male"   class="">
                                                        <label for="male">Male</label>
                                                        <input type="radio" id="female" @foreach($employee as $item) {{$item->gender == "Female" ? 'checked':'' }} @endforeach name="gender" value="Female">
                                                        <label for="female">Female</label>
                                                    </div>
                                                    <div class="form-group col-6 mb-3">
                                                        <label for="">Martial Status</label>
                                                       <br>
                                                       <div class="row">
                                                        <div class="col-2 mb-2">
                                                            <input type="radio" id="Single" name="merital" @foreach($employee as $item) {{$item->merital_status == "Single" ? 'checked':'' }} @endforeach value="Single">
                                                            <label for="Single">Single</label>
                                                        </div>
                                                        <div class="col mb-2">

                                                            <input type="radio" id="Married" name="merital" @foreach($employee as $item) {{$item->merital_status == "Married" ? 'checked':'' }} @endforeach value="Married">
                                                            <label for="Married" class="pr-5">Married</label> &nbsp;
                                                            <br>

                                                        </div>
                                                        <div class="col">
                                                            <label for="">Marriage Date</label>
                                                            <input type="date" class="" id="Married" name="marriage_date" @if($details) value="{{ $details->marriage_date}}" @endif><br>

                                                        </div>
                                                        <div class="col-3 mb-2">
                                                            <input type="radio" id="Separated" name="merital"  @foreach($employee as $item) {{$item->merital_status == "Separated" ? 'checked':'' }} @endforeach value="Separated">
                                                            <label for="Separated">Separated</label>
                                                        </div>
                                                        <div class="col-3 mb-2">
                                                            <input type="radio" id="divorced" name="merital" id="Divorced" @foreach($employee as $item) {{$item->merital_status == "Divorced" ? 'checked':'' }} @endforeach value="Divorced">
                                                            <label for="divorced" class="pr-5">Divorced</label> <br>

                                                        </div>
                                                        <div class="col">
                                                            <label>Divorced Date</label><br>
                                                            <input type="date"  name="divorced_date" @if($details) value="{{ $details->divorced_date}}" @endif>
                                                           <br>
                                                        </div>
                                                        <div class="col mb-2">
                                                            <input type="radio" id="widow" name="merital"  @foreach($employee as $item) {{$item->merital_status == "Widow/Widower" ? 'checked':'' }} @endforeach value="Widow/Widower">
                                                            <label for="widow">Widow/Widower</label><br>
                                                        </div>
                                                       </div>



                                                    </div>
                                                    <div class="form-group col-6 mb-2">
                                                        <label for="">Religion</label>
                                                        <input type="text" name="religion" @if($details) value="{{ $details->religion}}" @endif  class="form-control">
                                                    </div>

                                                </div>
                                                <div class="card-footer ">
                                                    <button type="submit" class="btn btn-main float-end"> Save Details</button>
                                                </div>
                                        </div>


                                    </div>



                                </div>


                            </div>
                        </div>

                    </div>

                    {{-- / --}}

                    {{-- page 2 --}}
                    <div role="tabpanel" class="tab-pane " id="page2" aria-labelledby="permission-tab">
                        <div class="card border-0 shadow-none">
                            <div class="card-header">
                                <h5 class="text-main">ADDRESS AND IDENTIFICATION: </h5>

                            </div>

                            <div class="row p-2">

                                <div class="col-md-12">
                                    <div class="card p-2">
                                        <h5>Address Information</h5>
                                        <p>
                                            <small>
                                            <i>
                                            Home address that you currently reside and correspondent address:
                                            </i>
                                            </small>
                                            </p>



                                            <div class="row mb-2">

                                                <div class="form-group col-6">
                                                    <label for="">Physical Address</label>
                                                    <textarea name="physical_address" value="<?php echo $physical_address; ?> " class="form-control" rows="3"><?php echo $physical_address; ?></textarea>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="landmark">Landmark near your home</label>
                                                    <textarea name="landmark" id="landmark" @if($details) value="{{ $details->landmark}}" @endif class="form-control" rows="3">@if($details) {{ $details->landmark}} @endif</textarea>
                                                </div>


                                            </div>
                                            <div class="card-footer ">
                                                <button type="submit" class="btn btn-main float-end"> Save Details</button>
                                            </div>
                                    </div>


                                </div>
                                <div class="col-md-12">
                                    <div class="card p-2">
                                        <h5>Personal Identification Information</h5>



                                            <div class="row mb-2">

                                                <div class="form-group col-6 mb-2">
                                                    <label for="">TIN Number</label>
                                                    <input type="text" name="TIN" value="<?php echo $tin; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-6 mb-2">
                                                    <label for="">NIDA Number</label>
                                                    <input type="text" name="NIDA" value="<?php echo $national_id; ?>"  class="form-control">
                                                </div>
                                                <div class="form-group col-612 mb-2">
                                                    <label for="">Passport Number</label>
                                                    <input type="text" name="passport_number" @if($details) value="{{ $details->passport_number}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6 mb-2">
                                                    <label for="">Pension Fund Number</label>
                                                    <input type="text" name="pension" value="<?php echo $pf_membership_no; ?>" class="form-control">
                                                </div>

                                                <div class="form-group col-6 mb-2">
                                                    <label for="">HELSB Loan Index Number</label>
                                                    <input type="text" name="HELSB" value="<?php echo $HELSB; ?>" class="form-control">
                                                </div>

                                            </div>
                                            <div class="card-footer ">
                                                <button type="submit" class="btn btn-main float-end"> Save Details</button>
                                            </div>
                                    </div>


                                </div>

                            </div>
                          </div>
                     </div>
                    {{-- / --}}

                    {{-- page 3 --}}
                    <div role="tabpanel" class="tab-pane " id="page3" aria-labelledby="asset-tab">

                        <div class="card border-0 shadow-none">
                            <div class="card-header">
                                <h5 class="text-main">EMPLOYMENT HISTORY: </h5>
                            </div>
                            <div class="row p-2">

                                <div class="col-md-12">
                                    <div class="card p-2">
                                        <h5>Emmergency Contact Details</h5>
                                        <p>
                                            <small>
                                            <i>
                                            *
                                            For Emergency Purpose
                                            </i>
                                            </small>
                                            </p>


                                            <div class="row mb-2">

                                                <div class="form-group col-6">
                                                    <label for="">First Name</label>
                                                    <input type="text" name="em_fname" @if($emergency) value="{{ $emergency->em_fname}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Middle Name</label>
                                                    <input type="text" name="em_mname" @if($emergency) value="{{ $emergency->em_mname}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Surname</label>
                                                    <input type="text" name="em_lname" @if($emergency) value="{{ $emergency->em_sname}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Relationship</label>
                                                    <input type="text" name="em_relationship" @if($emergency) value="{{ $emergency->em_relationship}}" @endif id="" class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Occupation</label>
                                                    <input type="text" name="em_occupation" @if($emergency) value="{{ $emergency->em_occupation}}" @endif id="" class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Cellphone Number</label>
                                                    <input type="text" name="em_phone" @if($emergency) value="{{ $emergency->em_phone}}" @endif id="" class="form-control">
                                                </div>


                                            </div>
                                            <div class="card-footer ">
                                                <button type="submit" class="btn btn-main float-end"> Save Details</button>
                                            </div>
                                    </div>


                                </div>
                                <div class="col-md-12">
                                    <div class="card p-2">
                                        <h5>Employment Details</h5>



                                            <div class="row mb-2">

                                                <div class="form-group col-6 mb-2">
                                                    <label for="">Date of Employment</label>
                                                    <input type="text" name="employment_date" value="<?php echo $hire_date; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-6 mb-2">
                                                    <label for="">First Job Title</label>
                                                    <input type="text" name="former_title" @if($details) value="{{ $details->former_title}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6 mb-2">
                                                    <p></p>
                                                    <label for="">Current Job Title: <?php echo $title; ?></label>
                                                    <br>
                                                    <label for="">Department : <?php echo $department; ?></label>
                                                    <br>
                                                    <label for="">Branch : <?php echo $branch; ?></label>
                                                    {{-- <div class="">
                                                        <select class="form-control select1_single select @error('newPosition') is-invalid @enderror" id="current_job" name="current_job">
                                                            <option value="<?php echo $title; ?>"><?php echo $title; ?></option>
                                                            @foreach ($pdrop as $item)
                                                            <option value="{{ $item->name }}">{{ $item->name }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div> --}}
                                                </div>

                                                {{-- <div class="form-group col-12 ">
                                                    <label for="">Branch</label>

                                                    <p>Current Branch:  <?php echo $branch; ?> </p>

                                                    <select class="form-control select1_single select @error('department') is-invalid @enderror" id="docNo" name="line_manager">
                                                        <option value=""> Update Member Branch </option>
                                                        @foreach ($bdrop as $depart)
                                                        <option value="{{ $depart->emp_id }}">{{ $depart->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                {{-- <div class="form-group col-12 mb-2">
                                                    <label for="">Line Manager</label>
                                                    <br>
                                                    <p>Current:  <?php echo $linemanager; ?> </p>
                                                    <label for="">Update Line Manager</label>
                                                    <select class="form-control select @error('department') is-invalid @enderror" id="docNo" name="line_manager">
                                                        <option value=""> Select New Line Manager </option>
                                                        @foreach ($employees as $depart)

                                                        <option value="{{ $depart->emp_id }}" >{{ $depart->fname }}  {{ $depart->lname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                {{-- <div class="form-group col-12 mb-2">
                                                    <label for="">Head Of Department</label>
                                                    <input type="text" name="hod" value="" class="form-control">
                                                </div> --}}



                                            </div>
                                            <div class="card-footer ">
                                                <button type="submit" class="btn btn-main float-end"> Save Details</button>
                                            </div>
                                    </div>


                                </div>

                            </div>

                        </div>

                     </div>
                    {{-- / --}}

                    {{-- Page 4--}}
                    <div role="tabpanel" class="tab-pane " id="page4" aria-labelledby="l-d-tab">
                        <div class="card border-0 shadow-none mb-3">
                            <div class="card-header">
                                <h5 class="text-main">FAMILY DETAILS </h5>
                            </div>
                            <div class="row p-2">

                                <div class="col-md-12">
                                    <div class="card p-2">
                                        <h5>Spouse Details</h5>
                                        <p>
                                            <small>
                                            <i>*(If you are married, please complete the below details and attach your Marriage Certificate)
                                            </i>
                                            </small>
                                            </p>
                                            <div class="row mb-2">

                                                <div class="form-group col-12">
                                                    <label for="">Name as Per NIDA/ Passport</label>
                                                    <input type="text" name="spouse_name" @if($spouse) value="{{ $spouse->spouse_fname}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Place of Birth (City/Region)</label>
                                                    <input type="text" name="spouse_birthplace" @if($spouse) value="{{ $spouse->spouse_birthplace}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Date of Birth</label>
                                                    <input type="date" name="spouse_birthdate" @if($spouse) value="{{ $spouse->spouse_birthdate}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Country of Birth</label>
                                                    <input type="text" name="spouse_birthcountry" @if($spouse) value="{{ $spouse->spouse_birthcountry}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Nationality</label>
                                                    <input type="text" name="spouse_nationality" @if($spouse) value="{{ $spouse->spouse_nationality}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">NIDA Number</label>
                                                    <input type="text" name="spouse_nida" @if($spouse) value="{{ $spouse->spouse_nida}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Passport Number</label>
                                                    <input type="text" name="spouse_passport" @if($spouse) value="{{ $spouse->spouse_passport}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Employer</label>
                                                    <input type="text" name="spouse_employer" @if($spouse) value="{{ $spouse->spouse_employer}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="">Job Title</label>
                                                    <input type="text" name="spouse_job_title" @if($spouse) value="{{ $spouse->spouse_job_title}}" @endif class="form-control">
                                                </div>


                                            </div>
                                            <div class="card-footer ">
                                                <button type="submit" class="btn btn-main float-end"> Save Details</button>
                                            </div>
                                    </div>


                                </div>



                             <div class="col-md-12">


                                </div>

                                <div class="col-md-12">
                                    <div class="card">
                                      <div class="card-header">
                                        Children/Dependants Details:
                                      </div>
                                      <div class="card-body">
                                        <h5>Add Dependant</h5>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6 mb-2">
                                                <label for="">Name (First Two)</label><br>
                                                <input type="text" name="dep_name" placeholder="Enter Dependants First and Second Name" class="form-control" />

                                            </div>
                                            <div class="col-6 mb-2">
                                                <label for="">Surname</label><br>
                                                <input type="text" name="dep_surname" placeholder="Enter Dependants Surname" class="form-control" />

                                            </div>
                                            <div class="col-6 mb-2">
                                                <label for="">Birth Certificate Number</label><br>
                                                <input type="text" name="dep_certificate" placeholder="Enter Birth Certificate Number" class="form-control" />
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label for="">Birhdate</label><br>
                                                <input type="date" name="dep_birthdate" placeholder="Enter Dependants Birthdate" class="form-control" />

                                            </div>
                                            <div class="col-4 mb-2">
                                                <label for="">Gender</label><br>
                                                <input type="radio" id="dep_male" name="dep_gender" value="M"> <label for="dep_male">Male (M)</label>
                                                <input type="radio" id="dep_female" name="dep_gender" value="F"> <label for="dep_female">Female (F)</label>
                                            </div>

                                            <div class="card-footer ">
                                                <button type="submit" class="btn btn-main float-end"> Save Dependant</button>
                                            </div>

                                        </div>
                                        <hr>

                                        <table class="table table-border-none" id="dynamicAddRemove">
                                            <tr>
                                            <th>Names of Children</th>
                                            <th>Surname</th>
                                            <th>Birthdate</th>
                                            <th>Sex: M/F</th>
                                            <th>Birth Certificate #</th>
                                            <th>Action</th>
                                            @forelse ( $children as $item )
                                          <tr>

                                            <td>{{ $item->dep_name}} </td>
                                            <td>{{ $item->dep_surname }} </td>
                                            <td>{{ $item->dep_birthdate }}</td>
                                            <td>{{ $item->dep_gender }}</td>
                                            <td>{{ $item->dep_certificate }} </td>
                                            <td>
                                                <a href="{{ url('flex/delete-child/'.$item->id) }}" class="btn btn-sm btn danger">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            </td>
                                          </tr>

                                          @empty

                                          @endforelse

                                            </table>

                                      </div>
                                    </div>
                                  </div>
                                <div class="col-md-12">
                                    <div class="card">
                                      <div class="card-header">
                                          Parents Details:
                                      </div>
                                      <div class="card-body">
                                        <h5>Add Parent</h5>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6 mb-2">
                                                <label for="">Names (Three Names)</label><br>
                                                <input type="text" name="parent_names" placeholder="Enter Parents Name" class="form-control" />

                                            </div>
                                            <div class="col-6 mb-2">
                                                <label for="">Relationship</label><br>

                                                <select name="parent_relation" id="" class="select custom-select form-control">
                                                    <option value="Father">Father</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Guardian">Guardian</option>
                                                </select>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label for="">Birthdate</label><br>
                                                <input type="date" name="parent_birthdate" placeholder="" class="form-control" />
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label for="">Residence  (City/Region & Country)</label><br>
                                                <input type="text" name="parent_residence" placeholder="Enter Parent's Residence" class="form-control" />

                                            </div>
                                            <div class="col-4 mb-2">
                                                <label for="">Living Status</label><br>
                                                <input type="radio" id="Alive" name="parent_living_status" value="Alive"> <label for="Alive">Alive</label>
                                                <input type="radio" id="Deceased" name="parent_living_status" value="Deceased"> <label for="Deceased">Deceased</label>
                                            </div>
                                            <div class="card-footer ">
                                                <button type="submit" class="btn btn-main float-end"> Save Parent</button>
                                            </div>
                                        </div>
                                        <hr>


                                          <table class="table table-border-none" id="dynamicAddRemoveParent">
                                          <tr>
                                          <th class="text-center">Names (Three Names)</th>
                                          <th>Relationship</th>
                                          <th>Birthdate</th>
                                          <th class="text-center">Residence  (City/Region & Country)</th>
                                          <th>Living Status</th>
                                          <th>Action</th>
                                          </tr>
                                          @forelse ( $parents as $item )
                                          <tr>

                                            <td>{{ $item->parent_names}} </td>
                                            <td>{{ $item->parent_relation }} </td>
                                            <td>{{ $item->parent_birthdate }}</td>
                                            <td>{{ $item->parent_residence }}</td>
                                            <td>{{ $item->parent_living_status }} </td>
                                            <td>
                                                <a href="{{ url('flex/delete-parent/'.$item->id) }}" class="btn btn-sm btn danger">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            </td>
                                          </tr>
                                          @empty

                                          @endforelse


                                          </table>

                                          <script type="text/javascript">
                                            var i = 0;
                                            $("#add-btn").click(function(){
                                            ++i;
                                            $("#dynamicAddRemove").append('<tr><td><input type="text" name="moreFields['+i+'][dep_name]" placeholder="" class="form-control" /><input type="hidden" name="moreFields['+i+'][employeeID]" value="<?php echo $empID; ?>" class="form-control" /></td><td><input type="text" name="moreFields['+i+'][dep_surname]" placeholder="" class="form-control" /></td><td><input type="text" name="moreFields['+i+'][dep_birthdate]" placeholder="" class="form-control" /></td><td><input type="text" name="moreFields['+i+'][dep_gender]" placeholder="" class="form-control" /></td><td><input type="text" name="moreFields['+i+'][dep_certificate]" placeholder="" class="form-control" /></td><td><button type="button" class="btn btn-danger btn-sm  remove-tr">Remove</button></td></tr>');
                                            });
                                            $(document).on('click', '.remove-tr', function(){
                                            $(this).parents('tr').remove();
                                            });

                                            $("#add-btn1").click(function(){
                                            ++i;
                                            $("#dynamicAddRemoveParent").append('<tr><td><input type="text" name="moreParent['+i+'][parent_names]" placeholder="" class="form-control" /><input type="hidden" name="moreParent['+i+'][employeeID]" value="<?php echo $empID; ?>" class="form-control" /></td><td><input type="text" name="moreParent['+i+'][parent_relation]" placeholder="" class="form-control" /></td><td><input type="text" name="moreParent['+i+'][parent_birthdate]" placeholder="" class="form-control" /></td><td><input type="text" name="moreParent['+i+'][parent_residence]" placeholder="" class="form-control" /></td><td><input type="text" name="moreParent['+i+'][parent_living_status]" placeholder="" class="form-control" /></td><td><button type="button" class="btn btn-danger btn-sm  remove-tr">Remove</button></td></tr>');
                                            });
                                            $(document).on('click', '.remove-tr', function(){
                                            $(this).parents('tr').remove();
                                            });
                                            </script>
                                      </div>
                                    </div>
                                  </div>



                            </div>

                        </div>


                    </div>
                    {{-- / --}}

                    {{-- Page 5 --}}
                    <div role="tabpanel" class="tab-pane " id="page5" aria-labelledby="exit-tab">
                        <div class="card border-0 shadow-none">

                            <div class="card-header">
                                <h5 class="text-main">EDUCATIONAL BACKGROUND: </h5>
                            </div>
                            <div class="row p-2">


                                <div class="col-md-12">
                                    <div class="card">
                                      <div class="card-body">
                                        <h5>Add Academic Qualification</h5>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label for="">Name of University</label>
                                                <input type="text" name="institute" id="institute"  placeholder="Enter University Name" class="form-control" >
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Qualification Obtained </label>
                                                <select name="level" id="level" class="select custom-select form-control">
                                                    <option value="Certificate">Certificate </option>
                                                    <option value="Diploma">Diploma </option>
                                                    <option value="Degree">Degree </option>
                                                    <option value="Masters">Masters </option>
                                                    <option value="PhD">PhD </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="">Disciplinary of Study </label>
                                                <input type="text" name="course" id="course"  placeholder="Enter Disciplinary of Study e.g Accounting/Marketing Law/Business etc" class="form-control" >
                                            </div>

                                                <div class="col-md-3 mb-2">
                                                    <label for="">Start Year</label>
                                                    <input type="year" name="start_year" id="start_year"  placeholder="Start Year" class="form-control" >
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="">Finish Year</label>
                                                    <input type="year" name="finish_year"  id="finish_year"  placeholder="Finish Year" class="form-control" >
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="">Location of Study</label>
                                                    <input type="text" name="study_location"  id="study_location"  placeholder="Location of Study" class="form-control" >
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="">Final Score & Grades</label>
                                                    <input type="text" name="final_score"  id="final_score"  placeholder="Final Score & Grades" class="form-control" >
                                                </div>
                                                <div class="card-footer ">
                                                    <button type="submit" class="btn btn-main float-end"> Save Details</button>
                                                </div>
                                        </div>
                                        <hr>

                                        <table class="table table-border-none" id="dynamicAddRemove">
                                            <tr>
                                            <th class="text-center">From /To(Month & Year)</th>
                                            <th class="text-center">University/College/School (From highest level of education)</th>
                                            <th class="text-center">Qualification Obtained </th>
                                            <th class="text-center">Disciplinary of Study </th>
                                            <th class="text-center">Location </th>
                                            <th class="text-center">Final Score & Grades</th>
                                            <th class="text-center">Action</th>
                                            @forelse ( $qualifications as $item )
                                          <tr>

                                            <td class="text-center">{{ $item->start_year}} - {{ $item->end_year}} </td>
                                            <td class="text-center">{{ $item->institute }} </td>
                                            <td class="text-center">{{ $item->level }}</td>
                                            <td class="text-center">{{ $item->course }}</td>
                                            <td class="text-center">{{ $item->study_location }} </td>
                                            <td class="text-center">{{ $item->final_score }} </td>
                                            <td class="text-center">
                                            <a href="{{ url('flex/delete-qualification/'.$item->id) }}" class="btn btn-sm btn danger">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            </td>
                                          </tr>

                                          @empty

                                          @endforelse

                                            </table>

                                      </div>
                                    </div>
                                  </div>
                                <div class="col-md-12">
                                    <div class="card">
                                      <div class="card-body">
                                        <h5>Add Professional Certifications/License</h5>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label for="">Name of Certification/License</label>
                                                <input type="text" name="cert_name" id="institute"  placeholder="Enter Name of Certification/License" class="form-control" >
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Qualification Obtained </label>
                                                <input type="text" name="cert_qualification" id="cert_qualification"  placeholder="Enter Qualification Obtained " class="form-control" >

                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="">Membership Number</label>
                                                <input type="text" name="cert_number" id="cert_number" placeholder="Enter Membership Number" class="form-control" >
                                            </div>

                                                <div class="col-md-3 mb-2">
                                                    <label for="">Start Year</label>
                                                    <input type="year" name="cert_start" id="cert_start"  placeholder="Start Year" class="form-control" >
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="">Finish Year</label>
                                                    <input type="year" name="cert_end"  id="cert_end" placeholder="Finish Year" class="form-control" >
                                                </div>

                                                <div class="col-4 mb-2">
                                                    <label for="">Status </label><br>
                                                    <input type="radio" id="active" name="cert_status" value="Active"> <label for="active">Active</label>
                                                    <input type="radio" id="inactive" name="cert_status" value="Active"> <label for="inactive">Inactive</label>
                                                </div>
                                                <div class="card-footer ">
                                                    <button type="submit" class="btn btn-main float-end"> Save Details</button>
                                                </div>
                                        </div>
                                        <hr>


                                          <table class="table table-border-none" id="dynamicAddRemoveParent">
                                          <tr>
                                          <th class="text-center">From/To (Month & Year)</th>
                                          <th class="text-center">Name of Professional Certification/License If any</th>
                                          <th class="text-center">Qualification Obtained </th>
                                          <th class="text-center">Membership Number</th>
                                          <th class="text-center">Status Active/ Inactive</th>
                                          <th class="text-center">Action</th>
                                          </tr>
                                          @forelse ( $certifications as $item )
                                          <tr>

                                            <td class="text-center" >{{ $item->cert_start}} - {{ $item->cert_end }}</td>
                                            <td class="text-center" >{{ $item->cert_name }} </td>
                                            <td class="text-center">{{ $item->cert_qualification }}</td>
                                            <td class="text-center">{{ $item->cert_number }}</td>
                                            <td class="text-center">{{ $item->cert_status }} </td>
                                            <td>
                                                 <a href="{{ url('flex/delete-certification/'.$item->id) }}" class="btn btn-sm btn danger">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            </td>
                                          </tr>
                                          @empty

                                          @endforelse


                                          </table>


                                      </div>
                                    </div>
                                  </div>



                            </div>

                        </div>
                     </div>
                    {{-- / --}}

                    {{-- Page 6 --}}
                    <div role="tabpanel" class="tab-pane " id="page6" aria-labelledby="exit-tab">
                        <div class="card border-0 shadow-none">

                            <div class="card-header">
                                <h5 class="text-main">EMPLOYMENT HISTORY: </h5>
                            </div>
                            <div class="row p-2">


                                <div class="col-md-12">
                                    <div class="card">
                                      <div class="card-body">
                                        <h5>Add Employment History</h5>
                                        <hr>
                                        <p class="text-muted"><b> Previous Employer(s) Details:</b></p>
                                        <p>
                                           <small><i>
                                            Kindly declare your previous employers
                                            (up to a period of 5 years to the date of joining BancABC)
                                        </i></small>

                                        </p>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label for="">Name of Employer</label>
                                                <input type="text" name="hist_employer" id="hist_employer"  placeholder="Enter Name of Employer" class="form-control" >
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <label for="">Industry</label>
                                                <input type="text" name="hist_industry" id="hist_industry"  placeholder="Enter Industry Auditing/Telecom Financial/Mining etc" class="form-control" >
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <label for="">Position Held at the time of exit</label>
                                                <input type="text" name="hist_position" id="hist_position"  placeholder="Enter Position Held at the time of exit" class="form-control" >
                                            </div>

                                                <div class="col-md-3 mb-2">
                                                    <label for="">Start Year</label>
                                                    <input type="year"  name="hist_start" id="hist_start"   placeholder="Start Year" class="form-control" >
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="">Finish Year</label>
                                                    <input type="year" name="hist_end"  id="hist_end"  placeholder="Finish Year" class="form-control" >
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="">Reason for Leaving</label>
                                                    <textarea name="hist_reason" id="" class="form-control" placeholder="Enter Reason for Leaving Here" rows="4"></textarea>
                                                </div>

                                                <div class="col-6">
                                                    <label for="hist_status">Employment Status</label>
                                                    <select name="hist_status" id="hist_status" class="select form-control">
                                                        <option value="Permanent">Permanent</option>
                                                        <option value="Fixed Term">Fixed Term</option>
                                                        <option value="Internship">Internship</option>
                                                    </select>
                                                </div>
                                                <div class="card-footer mt-2">
                                                    <button type="submit" class="btn btn-main float-end"> Save Details</button>
                                                </div>
                                        </div>
                                        <hr>

                                        <table class="table table-border-none" id="dynamicAddRemove">
                                            <tr>
                                            <th class="text-center">From /To(Month & Year)</th>
                                            <th class="text-center">Employer</th>
                                            <th class="text-center">Industry Auditing/Telecom Financial/Mining etc </th>
                                            <th class="text-center">Position Held at the time of exit</th>
                                            <th class="text-center">Employment Status</th>
                                            <th class="text-center">Reason for Leaving</th>
                                            <th class="text-center">Action</th>
                                            @forelse ( $histories as $item )
                                          <tr>

                                            <td class="text-center">{{ $item->hist_start}} - {{ $item->hist_end}} </td>
                                            <td class="text-center">{{ $item->hist_employer }} </td>
                                            <td class="text-center">{{ $item->hist_industry }} </td>
                                            <td class="text-center">{{ $item->hist_position }}</td>
                                            <td class="text-center">{{ $item->hist_status }}</td>
                                            <td class="text-center">{{ $item->hist_reason }} </td>
                                            <td class="text-center">
                                                <a href="{{ url('flex/delete-history/'.$item->id) }}" class="btn btn-sm btn danger">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            </td>
                                          </tr>

                                          @empty

                                          @endforelse

                                            </table>

                                      </div>
                                    </div>
                                  </div>

                            </div>
                        </div>
                     </div>
                    {{-- / --}}



                </div>
                {{-- <div class="card-footer ">
                    <button type="submit" class="btn btn-main float-end"> Update Employee Detail</button>
                </div> --}}
                </div>


        </div>
      </div>
    </div>




</form>

</div>

{{-- end of user credentials --}}
{{-- user profile image  modal --}}
<div  id="avatar-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-main">
            <button type="button" class="btn-close bg-danger text-light btn-sm" data-bs-dismiss="modal" aria-label="Close">
                X
            </button>

        </div>
        <div class="modal-body">
            <div id="error-div"></div>
            {{-- start of current image --}}
            <div class="row">
              <div class="text-center col-md-2 mx-auto" >
                <img class="profile-user-img  img-circle"
                     src="{{ asset('uploads/userprofile/' . $photo) }}"
                     alt="User passport picture" width="100%" height="100px">
                     <br>
                     <small class="text-gray">
                      Current Image
                     </small>
              </div>
            </div>
            {{--  end of current image --}}
            {{-- start of update image form --}}
            <form method="post" action="{{ url('flex/user-image')}}" enctype="multipart/form-data">
                 @csrf
                {{-- <input type="hidden" name="update_id" id="{{Auth::User()->id;}}"> --}}
                <div class="row">
                <div class="col-lg-12">
                        <label for="file" class="text-secondary font-weight-light">Upload New Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <input type="hidden" name="empID" value="<?php echo $empID; ?>">
                </div>

                <div class="col-md-6"></div>

                <div class="col-md-6 mb-0 ">
                      <label for="" class="text-white">.</label>
                      <button type="submit" class="btn text-light btn-main btn-block col-lg-12" >
                          <i class="fa fa-save"></i>
                          {{ __('Update Image') }}
                      </button>
                </div>

            </div>
          </form>

          {{-- end of edit profile form --}}
        </div>

      </div>
    </div>
  </div>
@endsection

@push('footer-script')

<script>
  function notify(message, from, align, type) {
      $.growl({
          message: message,
          url: ''
      }, {
          element: 'body',
          type: type,
          allow_dismiss: true,
          placement: {
              from: from,
              align: align
          },
          offset: {
              x: 30,
              y: 30
          },
          spacing: 10,
          z_index: 1031,
          delay: 5000,
          timer: 1000,
          animate: {
              enter: 'animated fadeInDown',
              exit: 'animated fadeOutUp'
          },
          url_target: '_blank',
          mouse_over: false,

          icon_type: 'class',
          template: '<div data-growl="container" class="alert" role="alert">' +
              '<button type="button" class="close" data-growl="dismiss">' +
              '<span aria-hidden="true">&times;</span>' +
              '<span class="sr-only">Close</span>' +
              '</button>' +
              '<span data-growl="icon"></span>' +
              '<span data-growl="title"></span>' +
              '<span data-growl="message"></span>' +
              '<a href="#!" data-growl="url"></a>' +
              '</div>'
      });
  }


  function run(){
      alert("hello world");
  }


  $(function() {
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth() + 1; //January is 0!

      var startYear = today.getFullYear()-18;
      var endYear = today.getFullYear()-60;
      if (dd < 10) {
          dd = '0' + dd;
      }
      if (mm < 10) {
          mm = '0' + mm;
      }


      var dateStart = dd + '/' + mm + '/' + startYear;
      var dateEnd = dd + '/' + mm + '/' + endYear;
      $('#exit_date').daterangepicker({
          drops: 'up',
          singleDatePicker: true,
          autoUpdateInput: false,
          showDropdowns: true,
          maxYear: parseInt(moment().format('YYYY'),100),
          minDate:dateEnd,
          startDate: moment(),
          locale: {
              format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_2"
      }, function(start, end, label) {

      });
      $('#exit_date').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('DD/MM/YYYY'));
      });
      $('#exit_date').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
      });
  });


</script>
 @endpush
