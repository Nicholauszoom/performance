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


    <form action="{{ route('flex.saveDetails') }}" method="post">
        @csrf
        <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body border-0">
                    <ul class="nav nav-tabs nav-tabs-underline nav-justified nav-tabs-filled mb-3" id="tabs-target-right" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#page1" class="nav-link active show" data-bs-toggle="tab" aria-selected="true" role="tab" tabindex="-1">
                                Page 1
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#page2" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                               Page 2
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#page3" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                               Page 3
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#page4" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                               Page 4
                            </a>
                        </li>

                        {{-- <li class="nav-item" role="presentation">
                            <a href="#exit" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                               Submission Page
                            </a>
                        </li> --}}
                    </ul>
                </div>

                <div class="tab-content" id="myTabContent">
                    {{-- page 1 --}}
                    <div role="tabpanel" class="tab-pane fade active show " id="page1" aria-labelledby="work-tab">

                        <div class="card shadow-none">
                            <div class="card-header ">
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

                                @if (session('msg'))
                                <div class="alert alert-success col-md-12 text-center mx-auto" role="alert">
                                {{ session('msg') }}
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

                                        </div>


                                    </div>
                                    <div class="col-12">
                                        <div class="card p-2">
                                            <h5>Biography Information</h5>


                                                <div class="row mb-2">

                                                    <div class="form-group col-12 mb-2">
                                                        <label for="">Date of Birth</label>
                                                        <input type="date" name="birthdate" value="<?php echo $birthdate; ?>" class="form-control">
                                                    </div>


                                                    <div class="form-group col-12 mb-2">
                                                        <label for="">Place of Birth</label>
                                                        <input type="text" name="birthplace" @if($details) value="{{ $details->birthplace}}" @endif   class="form-control">
                                                    </div>
                                                    <div class="form-group col-612 mb-2">
                                                        <label for="">Country of Birth</label>
                                                        <input type="text" name="birthcountry" @if($details) value="{{ $details->birthcountry}}" @endif   class="form-control">
                                                    </div>
                                                    <div class="form-group col-12 mb-2">
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
                                                       <input type="radio" id="Single" name="merital" @foreach($employee as $item) {{$item->merital_status == "Single" ? 'checked':'' }} @endforeach value="Single">
                                                       <label for="Single">Single</label>
                                                       <br>
                                                       <input type="radio" id="Married" name="merital" @foreach($employee as $item) {{$item->merital_status == "Married" ? 'checked':'' }} @endforeach value="Married">
                                                       <label for="Married" class="pr-5">Married</label> &nbsp; <label for="">Date</label> <input type="date" id="Married" name="marriage"><br>
                                                       <input type="radio" id="Separated" name="merital"  @foreach($employee as $item) {{$item->merital_status == "Separated" ? 'checked':'' }} @endforeach value="Separated">
                                                       <label for="Separated">Separated</label><br>
                                                       <input type="radio" id="divorced" name="merital" id="Divorced" @foreach($employee as $item) {{$item->merital_status == "Divorced" ? 'checked':'' }} @endforeach value="Divorced">
                                                       <label for="divorced" class="pr-5">Divorced</label>
                                                       Date</label> <input type="date"  name="divorced_date">
                                                       <br>
                                                       <input type="radio" id="widow" name="merital"  @foreach($employee as $item) {{$item->merital_status == "Widow/Widower" ? 'checked':'' }} @endforeach value="Widow/Widower">
                                                       <label for="widow">Widow/Widower</label><br>

                                                    </div>
                                                    <div class="form-group col-12 mb-2">
                                                        <label for="">Religion</label>
                                                        <input type="text" name="religion" @if($details) value="{{ $details->religion}}" @endif  class="form-control">
                                                    </div>

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
                            {{-- <div class="card-header">
                              <h6 class="text-muted">Permissons</h6>
                            </div> --}}

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

                                                <div class="form-group col-12">
                                                    <label for="">Physical Address</label>
                                                    <textarea name="physical_address" value="<?php echo $physical_address; ?> " class="form-control" rows="3"><?php echo $physical_address; ?></textarea>
                                                </div>
                                                <div class="form-group col-12">
                                                    <label for="landmark">Landmark near your home</label>
                                                    <textarea name="landmark" id="landmark" @if($details) value="{{ $details->landmark}}" @endif class="form-control" rows="3">@if($details) {{ $details->landmark}} @endif</textarea>
                                                </div>


                                            </div>

                                    </div>


                                </div>
                                <div class="col-md-12">
                                    <div class="card p-2">
                                        <h5>Personal Identification Information</h5>



                                            <div class="row mb-2">

                                                <div class="form-group col-12 mb-2">
                                                    <label for="">TIN Number</label>
                                                    <input type="text" name="TIN" value="<?php echo $tin; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-12 mb-2">
                                                    <label for="">NIDA Number</label>
                                                    <input type="text" name="NIDA" value="<?php echo $national_id; ?>"  class="form-control">
                                                </div>
                                                <div class="form-group col-612 mb-2">
                                                    <label for="">Passport Number</label>
                                                    <input type="text" name="passport_number" @if($details) value="{{ $details->passport_number}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-12 mb-2">
                                                    <label for="">Pension Fund Number</label>
                                                    <input type="text" name="pension" value="<?php echo $pf_membership_no; ?>" class="form-control">
                                                </div>

                                                <div class="form-group col-12 mb-2">
                                                    <label for="">HELSB Loan Index Number</label>
                                                    <input type="text" name="HELSB" value="<?php echo $HELSB; ?>" class="form-control">
                                                </div>

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

                                                <div class="form-group col-12">
                                                    <label for="">First Name</label>
                                                    <input type="text" name="em_fname" @if($emergency) value="{{ $emergency->em_fname}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label for="">Middle Name</label>
                                                    <input type="text" name="em_mname" @if($emergency) value="{{ $emergency->em_mname}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label for="">Surname</label>
                                                    <input type="text" name="em_lname" @if($emergency) value="{{ $emergency->em_sname}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label for="">Relationship</label>
                                                    <input type="text" name="em_relationship" @if($emergency) value="{{ $emergency->em_relationship}}" @endif id="" class="form-control">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label for="">Occupation</label>
                                                    <input type="text" name="em_occupation" @if($emergency) value="{{ $emergency->em_occupation}}" @endif id="" class="form-control">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label for="">Cellphone Number</label>
                                                    <input type="text" name="em_phone" @if($emergency) value="{{ $emergency->em_phone}}" @endif id="" class="form-control">
                                                </div>


                                            </div>

                                    </div>


                                </div>
                                <div class="col-md-12">
                                    <div class="card p-2">
                                        <h5>Employment Details</h5>
                                        <form action="" method="post">


                                            <div class="row mb-2">

                                                <div class="form-group col-12 mb-2">
                                                    <label for="">Date of Employment</label>
                                                    <input type="text" name="employment_date" value="<?php echo $hire_date; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-12 mb-2">
                                                    <label for="">First Job Title</label>
                                                    <input type="text" name="former_title" @if($details) value="{{ $details->former_title}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-612 mb-2">
                                                    <label for="">Current Job Title</label>
                                                    <input type="text" name="current_job" value="<?php echo $title; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-12 mb-2">
                                                    <label for="">Department & Branch</label>
                                                    <input type="text" value="<?php echo $department; ?>" class="form-control">
                                                </div>

                                                <div class="form-group col-12 mb-2">
                                                    <label for="">Line Manager</label>
                                                    <input type="text"name="department" value="<?php echo $linemanager; ?>"  class="form-control">
                                                </div>

                                                {{-- <div class="form-group col-12 mb-2">
                                                    <label for="">Head Of Department</label>
                                                    <input type="text" name="hod" value="" class="form-control">
                                                </div> --}}
                                                <div class="form-group col-12 mb-2">
                                                    <label for="">Employment Status</label>
                                                    <input type="text" name="employment_status" value="<?php echo $ctype; ?>"  class="form-control">
                                                </div>

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
                                <h4 class="text-main">FAMILY DETAILS </h4>
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
                                          <tr>
                                            <td>
                                                <input type="text" name="moreFields[0][dep_name]" placeholder="" class="form-control" />
                                                <input type="hidden" name="moreFields[0][employeeID]" value="<?php echo $empID; ?>"  class="form-control" />
                                            </td>
                                            <td><input type="text" name="moreFields[0][dep_surname]" placeholder="" class="form-control" /></td>
                                            <td><input type="text" name="moreFields[0][dep_birthdate]" placeholder="" class="form-control" /></td>
                                            <td><input type="text" name="moreFields[0][dep_gender]" placeholder="" class="form-control" /></td>
                                            <td><input type="text" name="moreFields[0][dep_certificate]" placeholder="" class="form-control" /></td>
                                            <td><button type="button" name="add" id="add-btn" class="btn btn-main btn-sm">+child</button></td>
                                            </tr>
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



                                          <table class="table table-border-none" id="dynamicAddRemoveParent">
                                          <tr>
                                          <th class="text-center">Names <br> (Three Names)</th>
                                          <th>Relationship</th>
                                          <th>Birthdate</th>
                                          <th class="text-center">Residence <br> (City/Region & Country)</th>
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
                                          <tr>
                                            <td>
                                              <input type="text" name="moreParent[0][parent_names]" placeholder="" class="form-control" />
                                              <input type="hidden" name="moreParent[0][employeeID]" value="<?php echo $empID; ?>"  class="form-control" />
                                          </td>
                                            <td><input type="text" name="moreParent[0][parent_relation]" placeholder="" class="form-control" /></td>
                                            <td><input type="text" name="moreParent[0][parent_birthdate]" placeholder="" class="form-control" /></td>
                                            <td><input type="text" name="moreParent[0][parent_residence]" placeholder="" class="form-control" /></td>
                                            <td><input type="text" name="moreParent[0][parent_living_status]" placeholder="" class="form-control" /></td>
                                            <td><button type="button" name="add" id="add-btn1" class="btn btn-main btn-sm">+parent</button></td>
                                            </tr>
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

                    {{-- Exit --}}
                    <div role="tabpanel" class="tab-pane " id="exit" aria-labelledby="exit-tab">
                        <div class="card border-0 shadow-none">


                        </div>
                     </div>
                    {{-- / --}}

                </div>
                <div class="card-footer ">
                    <button type="submit" class="btn btn-main float-end"> Update Employee Detail</button>
                </div>
                </div>


        </div>
      </div>
    </div>




</form>

</div>

{{-- end of user credentials --}}

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
