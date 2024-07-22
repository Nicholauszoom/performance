@extends('layouts.vertical', ['title' => 'Employee Biodata'])

@push('head-script')
<script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')



<?php
  foreach ($employee as $row) {
    $name = $row->fname." ".$row->mname." ".$row->lname;
    $state = $row->state;
    $department = $row->deptname;
    $empID = $row->emp_id;
    $gender = $row->gender;
    $merital_status = $row->merital_status;
    $birthdate = explode("-",$row->birthdate);
    $hire_date = explode("-",$row->hire_date);
    $position = $row->pname;
    $ctype = $row->contract;
    $linemanager = $row->linemanager;
    $pf_membership_no = $row->pf_membership_no;
    $account_no = $row->account_no;
    $mobile = $row->mobile;
    $salary = $row->salary;
    $nationality = $row->country;
    $email = $row->email;
    $departmentID = $row->department;
    $nhif = $row->pf_membership_no;
    $photo = $row->photo;
    $branch = $row->branch;
    // $leave_days = $row->leave_days;
    $postal_address = $row->postal_address;
    $postal_city = $row->postal_city;
    $physical_address = $row->physical_address;
    $home_address = $row->home;
    $retired = $row->retired;
    $login_user = $row->login_user;
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
        $position = $row->pname;
        $bankName = $row->bankname;
        $bankBranch = $row->bankbranch;
        $positionID = $row->position;
        $ctype = $row->contract_type;
        $emp_shift = $row->shift;
        $line_managerID = $row->line_manager;
        $linemanager = $row->linemanager;
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

  foreach($active_properties as $rowActive) {
    $numActive = $rowActive->ACTIVE_PROPERTIES;
  }

  $delimeter = "|";
?>

  <div class="mb-3">
    <h5 class="text-warning">Employee Biodata</h5>
  </div>

  <div class="row">

    <div class="col-12 mx-auto mt-1">
        <div class="card border-top border-top-width-3 border-top-main  rounded-0 border-0 shadow-none pb-4">
          <div class="sidebar-section-body text-center">
              <div class="card-img-actions d-inline-block my-3">
                {{-- rounded-circle --}}
                @error('image')
    <div class="error">{{ $message }}</div>
          @enderror
                  <img class="img " src="{{ ($photo == 'user.png') ? asset('img/user.png') : asset('storage/profile/' . $photo) }}" width="200px" height="200px" alt="">
              </div>

              <h6 class="mb-0">{{ $name }}</h6>
              <span class="text-muted mb-3">{{ $position }}</span>
          </div>

          <ul class="nav nav-sidebar mt-3">
            <li class="nav-item-divider"></li>

            <li class="nav-item mx-auto my-3">

                <button type="button" class="btn btn-main" data-bs-toggle="modal" data-bs-target="#avatar-modal">
                    <i class="ph-image me-2"></i>
                    Change Image
                </button>

                @if (session('mng_emp'))
                <a href="{{ route('flex.viewProfile', base64_encode($empID)) }}" class="btn btn-main">
                    <i class="ph-note-pencil me-2"></i>
                    Update Biodata
                </a>
                @endif
            </li>
          </ul>
        </div>

    </div>

    </div>

    {{-- Start of employee Bio data --}}
    <div class="row mx-auto">
        <div class="col-md-12 ">
            <div class="card border-top border-top-width-3 border-top-main  rounded-0 border-0 shadow-none">
                <div class="card-body border-0">
                    <ul class="nav nav-tabs nav-tabs-underline nav-justified nav-tabs-filled mb-3" id="tabs-target-right" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#basic" class="nav-link active show" data-bs-toggle="tab" aria-selected="true" role="tab" tabindex="-1">
                                Basic Details
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#address" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                Address|Identification
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#asset" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                Employment Info
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#l-d" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                Family Details
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a href="#exit" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                Education Info
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#history" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                               Employment Hist
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="myTabContent">
                    {{-- start of basic information details --}}
                    <div role="tabpanel" class="tab-pane fade active show " id="basic" aria-labelledby="work-tab">

                        <div class="card rounded-0 m-2 shadow-none">
                            {{-- <div class="card-header d-flex justify-content-between">


                            </div> --}}

                            <div class="row">
                                {{-- start of name information --}}
                                <div class="col-md-6">
                                    <h5 class="text-center bg-light">Name Information</h5>
                                   <div class="row mb-1">
                                    <div class="col-6">
                                        <h6 class="text-main">  Prefix</h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted"> @if($details) {{$details->prefix}} @endif</p>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-main"> First Name</h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted"> @if($profile) {{$profile->fname}} @endif </p>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-main"> Middle Name</h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted"> @if($profile) {{$profile->mname}} @endif</p>
                                    </div>

                                    <div class="col-6">
                                        <h6 class="text-main"> Surname</h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted"> @if($profile) {{$profile->lname}} @endif </p>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-main"> Maiden Name</h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted">  @if($details) {{$details->maide_name}} @endif</p>
                                    </div>
                                   </div>
                                </div>
                                {{-- end of name information --}}

                                {{-- start of biography information --}}
                                <div class="col-md-6">
                                    <h5 class="text-center bg-light"> Biography Information</h5>
                                    <div class="row mb-1">
                                     <div class="col-6">
                                         <h6 class="text-main"> Date of Birth</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted">  @if($profile) {{$profile->birthdate}} @endif </p>
                                     </div>
                                     <div class="col-6">
                                         <h6 class="text-main"> Place of Birth (City/Region):</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted">  @if($details) {{$details->birthplace}} @endif </p>
                                     </div>
                                     <div class="col-6">
                                         <h6 class="text-main">Country of Birth:</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"> @if($details) {{$details->birthcountry}} @endif </p>
                                     </div>

                                     <div class="col-6">
                                         <h6 class="text-main"> Gender/Sex:</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted">  @if($profile) {{$profile->gender}} @endif </p>
                                     </div>
                                     <div class="col-6">
                                         <h6 class="text-main"> Marital Status:</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"> @if($profile) {{$profile->merital_status}} @endif </p>
                                     </div>
                                     <div class="col-6">
                                        <h6 class="text-main"> Religion:</h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted">  @if($details) {{$details->religion}} @endif </p>
                                    </div>
                                    </div>
                                </div>
                                {{-- end of biography information --}}
                            </div>
                        </div>

                    </div>
                    {{-- / --}}

                    {{-- start of address and identification details --}}
                    <div role="tabpanel" class="tab-pane fade show " id="address" aria-labelledby="permission-tab">
                        <div class="card rounded-0 m-2 shadow-none">
                            {{-- <div class="card-header d-flex justify-content-between">

                            </div> --}}

                            <div class="row">
                                {{-- start of address information --}}
                                <div class="col-md-6">
                                    <h5 class="text-center bg-light">Address Information</h5>
                                   <div class="row mb-1">
                                    <div class="col-12">
                                        <h6 class="text-main">  Physical Address</h6>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-muted">  @if($profile) {{$profile->physical_address}} @endif </p>
                                    </div>
                                    <div class="col-12">
                                        <h6 class="text-main"> Landmark near your home </h6>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-muted">  @if($details) {{$details->landmark}} @endif </p>
                                    </div>

                                   </div>
                                </div>
                                {{-- end of address information --}}

                                {{-- start of personal identification information --}}
                                <div class="col-md-6">
                                    <h5 class="text-center bg-light"> Personal Identification Information</h5>
                                    <div class="row mb-1">
                                     <div class="col-6">
                                         <h6 class="text-main">TIN Number : </h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted">  @if($profile) {{$profile->tin}} @endif</p>
                                     </div>
                                     <div class="col-6">
                                         <h6 class="text-main"> NIDA Number </h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"> <?php echo $national_id; ?></p>
                                     </div>
                                     <div class="col-6">
                                         <h6 class="text-main">Passport Number:</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"> @if($details) {{$details->passport_number}} @endif</p>
                                     </div>

                                     <div class="col-6">
                                         <h6 class="text-main"> Pension Fund Number:</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"><?php echo $pf_membership_no; ?> </p>
                                     </div>
                                     <div class="col-6">
                                         <h6 class="text-main"> HELSB <small> (Loan Fund Index) </small>Number:</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"><?php echo $HELSB; ?></p>
                                     </div>

                                     </div>
                                </div>
                                {{-- end of personal identification information --}}

                            </div>
                        </div>
                    </div>
                    {{-- / --}}

                    {{-- start of employment informations --}}
                    <div role="tabpanel" class="tab-pane  fade show " id="asset" aria-labelledby="asset-tab">
                        <div class="card rounded-0 m-2 shadow-none">
                            {{-- <div class="card-header d-flex justify-content-between">

                            </div> --}}

                            <div class="row">
                                {{-- start of emergency contacts --}}
                                <div class="col-md-6">
                                    <h5 class="text-center bg-light">Emergency Contact Details</h5>
                                   <div class="row mb-1">
                                    <div class="col-6">
                                        <h6 class="text-main">  First Name</h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted">@if($emergency) {{ $emergency->em_fname}} @endif</p>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-main"> Middle Name </h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted">@if($emergency) {{ $emergency->em_mname}} @endif</p>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-main"> Surname </h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted"> @if($emergency) {{ $emergency->em_sname}} @endif </p>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-main"> Relationship </h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted"> @if($emergency) {{ $emergency->em_relationship}} @endif </p>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-main"> Occupation </h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted"> @if($emergency) {{ $emergency->em_occupation}} @endif </p>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-main"> Cellphone Number </h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted"> @if($emergency) {{ $emergency->em_phone}} @endif </p>
                                    </div>

                                   </div>
                                </div>
                                {{-- end of emergency contacts --}}

                                {{-- start of employment details --}}
                                <div class="col-md-6">
                                    <h5 class="text-center bg-light"> Employment Details</h5>
                                    <div class="row mb-1">
                                     <div class="col-6">
                                         <h6 class="text-main">Date of Employment :</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"> <?php echo $hire_date; ?></p>
                                     </div>
                                     <div class="col-6">
                                         <h6 class="text-main"> First Job Title </h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"> @if($details) {{ $details->former_title}} @endif</p>
                                     </div>
                                     <div class="col-6">
                                         <h6 class="text-main">Current Job Title:</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"> <?php echo $title; ?> </p>
                                     </div>

                                     <div class="col-6">
                                         <h6 class="text-main"> Department & Branch:</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"><?php echo $department; ?> ,<?php echo $branch; ?> </p>
                                     </div>
                                     <div class="col-6">
                                         <h6 class="text-main"> Line Manager:</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"> <?php echo $linemanager; ?></p>
                                     </div>
                                     {{-- <div class="col-6">
                                        <h6 class="text-main"> Head of Department:</h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted"> Name Here </p>
                                    </div>

                                    <div class="col-6">
                                        <h6 class="text-main">Employment Status:</h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted"> <?php echo $ctype; ?> </p>
                                    </div> --}}


                                     </div>
                                </div>
                                {{-- end of employment details --}}

                            </div>
                        </div>

                     </div>
                    {{-- / --}}

                    {{-- Start of Family Informations --}}
                    <div role="tabpanel" class="tab-pane fade show" id="l-d" aria-labelledby="l-d-tab">

                        <div class="card  rounded-0 m-2 shadow-none">
                            {{-- <div class="card-header d-flex justify-content-between">

                            </div> --}}

                            <div class="row">
                                {{-- start of spouse details --}}
                                <div class="col-md-12">
                                    <h5 class=" bg-light">Spouse Details</h5>
                                    <div class="row mb-1">
                                    <div class="col-6">
                                        <h6 class="text-main">  Name as per NIDA/Passport</h6>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted"> @if($spouse) {{ $spouse->spouse_fname}} @endif </p>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-main"> Place of Birth (City/Region): </h6>
                                    </div>
                                    <div class="col-3">
                                        <p class="text-muted"> @if($spouse) {{ $spouse->spouse_birthplace}} @endif </p>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-main"> Date of Birth </h6>
                                    </div>
                                    <div class="col-3">
                                        <p class="text-muted"> @if($spouse) {{ $spouse->spouse_birthdate}} @endif </p>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-main"> Country of Birth </h6>
                                    </div>
                                    <div class="col-3">
                                        <p class="text-muted"> @if($spouse) {{ $spouse->spouse_birthcountry}} @endif </p>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-main"> Nationality </h6>
                                    </div>
                                    <div class="col-3">
                                        <p class="text-muted"> @if($spouse) {{ $spouse->spouse_nationality}} @endif </p>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-main"> NIDA Number </h6>
                                    </div>
                                    <div class="col-3">
                                        <p class="text-muted"> @if($spouse) {{ $spouse->spouse_nida}} @endif </p>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-main"> Passport Number: </h6>
                                    </div>
                                    <div class="col-3">
                                        <p class="text-muted"> @if($spouse) {{ $spouse->spouse_passport}} @endif </p>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-main"> Employer: </h6>
                                    </div>
                                    <div class="col-3">
                                        <p class="text-muted"> @if($spouse) {{ $spouse->spouse_employer}} @endif </p>
                                    </div>

                                    <div class="col-3">
                                        <h6 class="text-main"> Job Title: </h6>
                                    </div>
                                    <div class="col-3">
                                        <p class="text-muted"> @if($spouse) {{ $spouse->spouse_job_title}} @endif </p>
                                    </div>


                                   </div>


                                </div>
                                {{-- end of spouse details --}}

                                {{-- start of children details --}}
                                <div class="col-md-12">
                                    <h5 class="bg-light"> Children's Details</h5>
                                    <div class="row mb-1">
                                     <div class="col-6">
                                         <h6 class="text-main">Number of children :</h6>
                                     </div>
                                     <div class="col-6">
                                         <p class="text-muted"> @if($childs) {{ $childs }} @endif </p>
                                     </div>
                                     <div class="col-12">

                                        <hr>

                                        <table class="table table-border-none" id="dynamicAddRemove">
                                            <tr>
                                            <th>Names of Children</th>
                                            <th>Surname</th>
                                            <th>Birthdate</th>
                                            <th>Sex: M/F</th>
                                            <th>Birth Certificate #</th>
                                            <tr>
                                            @forelse ( $children as $item )
                                          <tr>

                                            <td>{{ $item->dep_name}} </td>
                                            <td>{{ $item->dep_surname }} </td>
                                            <td>{{ $item->dep_birthdate }}</td>
                                            <td>{{ $item->dep_gender }}</td>
                                            <td>{{ $item->dep_certificate }} </td>

                                          </tr>

                                         @empty
                                          <p class="text-center text-muted">Sorry, You have not added any Dependant/Child !</p>
                                          @endforelse
                                        </table>


                                     </div>
                                    {{-- start of Parents details --}}
                                    <h5 class="bg-light"> Parent's Details</h5>

                                     <div class="col-12">
                                        <table class="table table-border-none" id="dynamicAddRemoveParent">
                                          <tr>
                                          <th class="text-center">Names (Three Names)</th>
                                          <th>Relationship</th>
                                          <th>Birthdate</th>
                                          <th class="text-center">Residence  (City/Region & Country)</th>
                                          <th>Living Status</th>
                                          </tr>
                                          @forelse ( $parents as $item )
                                          <tr>

                                            <td>{{ $item->parent_names}} </td>
                                            <td>{{ $item->parent_relation }} </td>
                                            <td>{{ $item->parent_birthdate }}</td>
                                            <td>{{ $item->parent_residence }}</td>
                                            <td>{{ $item->parent_living_status }} </td>

                                          </tr>
                                          @empty
                                          <p class="text-center">
                                            Sorry,You have not added any Parent or Guardian!
                                          </p>
                                          @endforelse


                                          </table>

                                     </div>

                                    {{-- end of parents details --}}
                                     </div>



                                    </div>
                                {{-- end of children details --}}

                            </div>
                        </div>

                    </div>
                    {{-- / --}}

                    {{-- Start of Education --}}
                    <div role="tabpanel" class="tab-pane " id="exit" aria-labelledby="exit-tab">
                        <div class="card rounded-0 m-2 shadow-none">
                            {{-- <div class="card-header d-flex justify-content-between">

                            </div> --}}

                            <div class="row">


                                {{-- start of Academic Qualifications details --}}
                                <div class="col-md-12">
                                    <h5 class="bg-light"> Academic Qualification</h5>
                                    <div class="row mb-1">
                                     <div class="col-12">

                                        <table class="table table-border-none" id="dynamicAddRemove">
                                            <tr>
                                            <th class="text-center">From /To(Month & Year)</th>
                                            <th class="text-center">University/College/School (From highest level of education)</th>
                                            <th class="text-center">Qualification Obtained </th>
                                            <th class="text-center">Disciplinary of Study </th>
                                            <th class="text-center">Location </th>
                                            <th class="text-center">Final Score & Grades</th>

                                            </tr>
                                            @forelse ( $qualifications as $item )
                                          <tr>

                                            <td class="text-center">{{ $item->start_year}} - {{ $item->end_year}} </td>
                                            <td class="text-center">{{ $item->institute }} </td>
                                            <td class="text-center">{{ $item->level }}</td>
                                            <td class="text-center">{{ $item->course }}</td>
                                            <td class="text-center">{{ $item->study_location }} </td>
                                            <td class="text-center">{{ $item->final_score }} </td>

                                          </tr>

                                          @empty

                                          @endforelse
                                        </table>                                       </table>


                                     </div>
                                    {{-- start of Proffessional Certification details --}}
                                    <h5 class="bg-light"> Professional Certification/License</h5>

                                     <div class="col-12">
                                        <table class="table table-border-none" id="dynamicAddRemoveParent">
                                            <tr>
                                            <th class="text-center">From/To (Month & Year)</th>
                                            <th class="text-center">Name of Professional Certification/License If any</th>
                                            <th class="text-center">Qualification Obtained </th>
                                            <th class="text-center">Membership Number</th>
                                            <th class="text-center">Status Active/ Inactive</th>

                                            </tr>
                                            @forelse ( $certifications as $item )
                                            <tr>

                                              <td class="text-center" >{{ $item->cert_start}} - {{ $item->cert_end }}</td>
                                              <td class="text-center" >{{ $item->cert_name }} </td>
                                              <td class="text-center">{{ $item->cert_qualification }}</td>
                                              <td class="text-center">{{ $item->cert_number }}</td>
                                              <td class="text-center">{{ $item->cert_status }} </td>

                                            </tr>
                                            @empty

                                            @endforelse


                                            </table>



                                     </div>

                                    {{-- end of parents details --}}
                                     </div>



                                    </div>
                                {{-- end of children details --}}

                            </div>
                        </div>
                     </div>
                    {{-- / --}}

                    {{-- start of Employment History --}}
                    <div role="tabpanel" class="tab-pane " id="history" aria-labelledby="exit-tab">
                        <div class="card rounded-0 m-2 shadow-none">
                            {{-- <div class="card-header d-flex justify-content-between">

                            </div> --}}

                            <div class="row">


                                {{-- start of previous employment details --}}
                                <div class="col-md-12">
                                    <h5 class="bg-light"> Employment History</h5>
                                    <div class="row mb-1">
                                     <div class="col-12">

                                        <table class="table table-border-none" id="dynamicAddRemove">
                                            <tr>
                                            <th class="text-center">From /To(Month & Year)</th>
                                            <th class="text-center">Employer</th>
                                            <th class="text-center">Industry Auditing/Telecom Financial/Mining etc </th>
                                            <th class="text-center">Position Held at the time of exit</th>
                                            <th class="text-center">Employment Status</th>
                                            <th class="text-center">Reason for Leaving</th>
                                            @forelse ( $histories as $item )
                                          <tr>

                                            <td class="text-center">{{ $item->hist_start}} - {{ $item->hist_end}} </td>
                                            <td class="text-center">{{ $item->hist_employer }} </td>
                                            <td class="text-center">{{ $item->hist_industry }} </td>
                                            <td class="text-center">{{ $item->hist_position }}</td>
                                            <td class="text-center">{{ $item->hist_status }}</td>
                                            <td class="text-center">{{ $item->hist_reason }} </td>

                                          </tr>

                                          @empty

                                          @endforelse

                                            </table>



                                     </div>


                                    {{-- end of parents details --}}
                                     </div>



                                    </div>
                                {{-- end of children details --}}

                            </div>
                        </div>
                     </div>
                    {{-- / --}}

                </div>
            </div>
        </div>
      </div>


    {{-- end of employee bio data --}}

  </div>


 @endsection


@section('modal')

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
                     src="{{ asset('storage/profile/' . $photo) }}"
                     alt="" width="100%" height="100px">
                     <br>
                     <small class="text-gray">
                      Current Image
                     </small>
              </div>
            </div>
            {{--  end of current image --}}
            {{-- start of update image form --}}
            <form method="post" action="{{ route('flex.userimage')}}" enctype="multipart/form-data">
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
<div id="nextkinModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-main">Add Next of Kin to <?php echo $name; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form
                    id="demo-form2"
                    enctype="multipart/form-data"
                    method="post"
                    action="{{ route('flex.addkin', $empID) }}"
                    {{-- action="<?php echo  url(''); ?>/flex/addkin/<?php echo $empID; ?>" --}}
                    data-parsley-validate
                >
                @csrf
                    <div class="mb-3">
                        <label class="form-label" for="first-name">First Name</label>
                        <input type="text" name="fname" id="fname"  class="form-control" placeholder="First Name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="first-name">Middle Name</label>
                        <input type="text" name="mname" id="fname"  class="form-control" placeholder="Middle Name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="first-name">Last Name</label>
                        <input type="text" name="lname"  class="form-control" placeholder="Last Name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="first-name" for="stream" >Relationships</label>
                        <select name="relationship" class="form-control">
                            <option value="Son/Doughter">Son/Doughter</option>
                            <option value="Uncle/Aunt">Uncle/Aunt</option>
                            <option value="Brother/Sister">Brother/Sister</option>
                            <option value="Father/Mother">Father/Mother</option>
                            <option value="Grandfather/GrandMother">Grandfather/GrandMother</option>
                            <option value="Wife/Husband">Wife/Husband</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="first-name">Mobile</label>
                        <input type="text" name="mobile" id="fname"  class="form-control" placeholder="Mobile">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="first-name">Postal Address</label>
                        <input type="text" name="postal_address" id="fname"  class="form-control" placeholder="Postal Address">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="first-name">Physical Address</label>
                        <input type="text" name="physical_address" id="fname"  class="form-control" placeholder="Physical Address">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="first-name">Office Mobile No</label>
                        <input type="text" name="office_no" id="fname"  class="form-control" placeholder="Office Mobile No">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit"  value="Add" name="add" class="btn btn-main"/>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<div id="propertyModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-main">Assign a Property to <?php echo $name; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form
                    id="demo-form2"
                    enctype="multipart/form-data"
                    method="post"
                    action="{{ route('flex.addproperty') }}"
                    data-parsley-validate
                >
                @csrf

                    <div class="mb-3">
                        <label class="form-label" for="first-name" for="stream" >Property Type</label>
                        <select name="type" class="form-control">
                            <option value="">Select Property</option>
                            <option value="Computer">Computer</option>
                            <option value="Printer">Printer</option>
                            <option value="Vehicle">Vehicle</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="others">(Specify if Others)</label>
                        <input type="text" name="type2" id="fname"  class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="first-name">Property Name</label>
                        <input type="text" name="name"  class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="first-name">Serial Number</label>
                        <input type="text" name="serial"   class="form-control">
                    </div>

                    <div class="modal-footer">
                        <input hidden="hidden"  name="employee" value="<?php echo $empID; ?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit"  value="Add"  name="add" class="btn btn-main"/>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-script')

<script type="text/javascript">

       /*
                check if form submitted is for creating or updating
            */
            $("#save-qualification-btn").click(function(event ){
                event.preventDefault();
                if($("#update_id").val() == null || $("#update_id").val() == "")
                {
                    storQualification();
                } else {
                    updateQualification();
                }
            })

            /*
                show modal for creating a record and
                empty the values of form and remove existing alerts
            */
            function createQualification()
            {
                $("#alert-div").html("");
                $("#error-div").html("");
                $("#update_id").val("");
                $("#employeeID").val("");
                $("#institute").val("");
                $("#course").val("");
                $("#level").val("");
                $("#start_year").val("");
                $("#end_year").val("");
                $("#qualification-modal").modal('show');
            }

            /*
                submit the form and will be stored to the database
            */
            function storeQualification()
            {
                $("#save-qualification-btn").prop('disabled', true);
                let url = $('meta[name=app-url]').attr("content") + "/flex/qualifications";
                let data = {
                    employeeID: $("#employeeID").val(),
                    level: $("#level").val(),
                    institute: $("#institute").val(),
                    course: $("#course").val(),
                    start_year: $("#start_year").val(),
                    institute: $("#end_year").val(),

                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "POST",
                    data: data,
                    success: function(response) {
                        $("#save-community-btn").prop('disabled', false);
                        let successHtml = '<div class="alert alert-success " role="alert"> Community Was Added Successfully !</div>';
                        $("#alert-div").html(successHtml);
                        $("#name").val("");
                        $("#abbreviation").val("");
                        $("#location").val("");
                        showAllCommunities();
                        $("#form-modal").modal('hide');
                    },
                    error: function(response) {
                        $("#save-community-btn").prop('disabled', false);

                        /*
            show validation error
                        */
                        if (typeof response.responseJSON.errors !== 'undefined')
                        {
            let errors = response.responseJSON.errors;
            let abbreviationValidation = "";
            if (typeof errors.abbreviation !== 'undefined')
                            {
                                abbreviationValidation = '<li>' + errors.abbreviation[0] + '</li>';
                            }
            let locationValidation = "";
            if (typeof errors.location !== 'undefined')
                            {
                                locationValidation = '<li>' + errors.location[0] + '</li>';
                            }
            let nameValidation = "";
            if (typeof errors.name !== 'undefined')
                            {
                                nameValidation = '<li>' + errors.name[0] + '</li>';
                            }

            let errorHtml = '<div class="alert alert-danger" role="alert">' +
                '<b>Validation Error!</b>' +
                '<ul>' + nameValidation + abbreviationValidation +locationValidation + '</ul>' +
            '</div>';
            $("#error-div").html(errorHtml);
        }
                    }
                });
            }




    </script>
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
