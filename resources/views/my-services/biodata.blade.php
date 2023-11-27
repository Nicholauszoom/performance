
@extends('layouts.vertical', ['title' => 'Leave'])

@push('head-script')
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

{{-- {{ dd($employee)  }} --}}


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
    $position = $row->pName;
    $ctype = $row->CONTRACT;
    $linemanager = $row->LINEMANAGER;
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
        $position = $row->pName;
        $bankName = $row->bankName;
        // $bankBranch = $row->bankBranch;
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

        // dd("I am here");
  }

  foreach($active_properties as $rowActive) {
    $numActive = $rowActive->ACTIVE_PROPERTIES;
  }

  $delimeter = "|";
?>

<div class=" mx-auto">
    <div class="row bg-white mx-auto mb-2" style="border-bottom: 8px solid #00204e !important; " >
        <div class="col-4">
            <a href="{{ route('flex.viewProfile', base64_encode($empID)) }}" class="btn btn-main btn-sm mt-2">
                <i class="ph-note-pencil me-2"></i>
                Update Biodata
            </a>
        </div>
        <div class="col-md-4 col-4">
                <div class="row">
                <div class="col-6 mx-auto">
                    <img src="https://www.bancabc.co.tz/images/banc_abc_logo.png" alt="logo here" width="100%">

                </div>
                <div class="col-12">
                    <h5 class="text-center">
                      YOUR  EMPLOYEE PERSONAL DETAILS :
                    <br>
                    </h5>
                </div>
            </div>

        </div>
        <div class="col-md-4 col-4">

            <div class="card-img-actions d-inline-block float-end my-3">
                {{-- rounded-circle --}}
                  <img class=" " src="{{ ($photo == 'user.png') ? 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=00204e&color=fff' : asset('storage/profile/' . $photo) }}" width="140px" height="140px" alt="">
              </div>

        </div>




    </div>


        {{-- Start of employee Bio data --}}
        <div class="row " style="border-bottom: 8px solid #00204e !important; ">
            <div class="col-md-12 ">
                <div class="card border-top border-top-width-3 p-2 border-top-main  rounded-0 border-0 shadow-none">



                        {{-- start of basic information details --}}

                                {{-- <div class="card-header d-flex justify-content-between">


                                </div> --}}

                                <div class="row">
                                    {{-- start of name information --}}
                                    <div class="col-md-6 col-md-6 col-lg-6 col-6">
                                        <h5 class="text-center bg-main" style="border: 1px solid #00204e !important;">Name Information</h5>
                                       <div class="row mb-1">
                                        <div class="col-6 col-md-6 col-lg-6 col-6">
                                            <h6 class="text-main">  Prefix</h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-6 col-6">
                                            <p class="text-muted"> @if($details) {{$details->prefix}} @endif</p>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-6 col-6">
                                            <h6 class="text-main"> First Name</h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-6 col-6">
                                            <p class="text-muted"> @if($profile) {{$profile->fname}} @endif </p>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-6 col-6">
                                            <h6 class="text-main"> Middle Name</h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-6 col-6">
                                            <p class="text-muted"> @if($profile) {{$profile->mname}} @endif</p>
                                        </div>

                                        <div class="col-6 col-md-6 col-lg-6 col-6">
                                            <h6 class="text-main"> Surname</h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-6 col-6">
                                            <p class="text-muted"> @if($profile) {{$profile->lname}} @endif </p>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-6 col-6">
                                            <h6 class="text-main"> Maiden Name</h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-6 col-6">
                                            <p class="text-muted">  @if($details) {{$details->maide_name}} @endif</p>
                                        </div>
                                       </div>
                                    </div>
                                    {{-- end of name information --}}

                                    {{-- start of biography information --}}
                                    <div class="col-md-6 col-md-6 col-lg-6 col-6">
                                        <h5 class="text-center bg-main" style="border: 1px solid #00204e !important;"> Biography Information</h5>
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

                        {{-- / --}}

                        {{-- start of address and identification details --}}


                                <div class="row">
                                    {{-- start of address information --}}
                                    <div class="col-md-6 col-md-6 col-6 col-lg-6">
                                        <h5 class="text-center bg-main" style="border: 1px solid #00204e !important;">Address Information</h5>
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
                                    <div class="col-md-6 col-md-6 col-6 col-lg-6">
                                        <h5 class="text-center bg-main" style="border: 1px solid #00204e !important;"> Personal Identification Information</h5>
                                        <div class="row mb-1">
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main">TIN Number : </h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted">  @if($profile) {{$profile->tin}} @endif</p>s
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main"> NIDA Number </h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted"> {{ isset($national_id) ? $national_id : "Variable 'national_id' is not set." }}
</p>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main">Passport Number:</h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted"> @if($details) {{$details->passport_number}} @endif</p>
                                         </div>

                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main"> Pension Fund Number:</h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             {{-- <p class="text-muted"><?php echo $pf_membership_no; ?> </p> --}}
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main"> HELSB <small> (Loan Fund Index) </small>Number:</h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             {{-- <p class="text-muted"><?php echo $HELSB; ?></p> --}}
                                         </div>

                                         </div>
                                    </div>
                                    {{-- end of personal identification information --}}


                        {{-- / --}}

                        {{-- start of employment informations --}}


                                <div class="row">
                                    {{-- start of emergency contacts --}}
                                    <div class="col-md-6 col-md-6 col-6 col-lg-6">
                                        <h5 class="text-center bg-main" style="border: 1px solid #00204e !important;">Emergency Contact Details</h5>
                                       <div class="row mb-1">
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <h6 class="text-main">  First Name</h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <p class="text-muted">@if($emergency) {{ $emergency->em_fname}} @endif</p>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <h6 class="text-main"> Middle Name </h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <p class="text-muted">@if($emergency) {{ $emergency->em_mname}} @endif</p>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <h6 class="text-main"> Surname </h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <p class="text-muted"> @if($emergency) {{ $emergency->em_sname}} @endif </p>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <h6 class="text-main"> Relationship </h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <p class="text-muted"> @if($emergency) {{ $emergency->em_relationship}} @endif </p>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <h6 class="text-main"> Occupation </h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <p class="text-muted"> @if($emergency) {{ $emergency->em_occupation}} @endif </p>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <h6 class="text-main"> Cellphone Number </h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <p class="text-muted"> @if($emergency) {{ $emergency->em_phone}} @endif </p>
                                        </div>

                                       </div>
                                    </div>
                                    {{-- end of emergency contacts --}}

                                    {{-- start of employment details --}}
                                    <div class="col-md-6 col-md-6 col-6 col-lg-6 ">
                                        <h5 class="text-center bg-main" style="border: 1px solid #00204e !important;"> Employment Details</h5>
                                        <div class="row mb-1">
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main">Date of Employment :</h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted"> <?php echo $hire_date; ?></p>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main"> First Job Title </h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted"> @if($details) {{ $details->former_title}} @endif</p>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main">Current Job Title:</h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted"> <?php echo $title; ?> </p>
                                         </div>

                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main"> Department & Branch:</h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted"><?php echo $department; ?> ,<?php echo $branch; ?> </p>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main"> Line Manager:</h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted"> <?php echo $linemanager; ?></p>
                                         </div>
                                         {{-- <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <h6 class="text-main"> Head of Department:</h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <p class="text-muted"> Name Here </p>
                                        </div>

                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <h6 class="text-main">Employment Status:</h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <p class="text-muted"> <?php echo $ctype; ?> </p>
                                        </div> --}}


                                         </div>
                                    </div>
                                    {{-- end of employment details --}}

                                </div>

                        {{-- / --}}

                        {{-- Start of Family Informations --}}


                                <div class="row">
                                    @if($spouse || $children->count() >0)
                                    <h5 style="border-bottom:4px solid #00204e !important;">FAMILY DETAILS</h5>
                                    @endif
                                    {{-- start of spouse details --}}
                                    @if($spouse)
                                    <div class="col-md-12">

                                        <small class=""> <h6>Spouse Details:</h6></small>
                                        <hr>
                                        <div class="row mb-1">
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
                                            <h6 class="text-main">  Name as per NIDA/Passport</h6>
                                        </div>
                                        <div class="col-6 col-md-6 col-6 col-lg-6">
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
                                    @endif
                                    {{-- end of spouse details --}}

                                    {{-- start of children details --}}
                                    @if($children->count() >0)
                                    <div class="col-md-12">
                                        <hr>
                                        <h5 > Children/ Details</h5>
                                        <div class="row mb-1">
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main">Number of children :</h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted"> @if($childs) {{ $childs }} @endif </p>
                                         </div>
                                         <div class="col-12">

                                            @if($childs)
                                            <small><i>* (Birth Certificate/Adoption certificate stating you are the legal guardian must be attached)</i></small>
                                            <table class="table table-bordered " type="border" >
                                                <tr>
                                                <th>Names of Children
                                                    (First two names)
                                                    </th>
                                                <th>Surname</th>
                                                <th>Birthdate</th>
                                                <th>Sex: M/F</th>
                                                <th>Birth Certificate #</th>
                                                <tr>
                                                @foreach ( $children as $item )
                                              <tr>

                                                <td>{{ $item->dep_name}} </td>
                                                <td>{{ $item->dep_surname }} </td>
                                                <td>{{ $item->dep_birthdate }}</td>
                                                <td>{{ $item->dep_gender }}</td>
                                                <td>{{ $item->dep_certificate }} </td>

                                              </tr>

                                             @endforeach
                                            </table>
                                             @endif
                                         </div>
                                        </div>
                                    </div>
                                         @endif

                                         {{-- start of Parents details --}}

                                         @if($parents->count() >0)
                                         <hr>
                                        <h5 class=""> Parent's Details :</h5>

                                         <div class="col-12">
                                            <table class="table table-bordered" id="dynamicAddRemoveParent">
                                              <tr>
                                              <th class="text-center">Names (Three Names)</th>
                                              <th>Relationship</th>
                                              <th>Birthdate</th>
                                              <th class="text-center">Residence  (City/Region & Country)</th>
                                              <th>Living Status</th>
                                              </tr>
                                              @foreach ( $parents as $item )
                                              <tr>

                                                <td>{{ $item->parent_names}} </td>
                                                <td>{{ $item->parent_relation }} </td>
                                                <td>{{ $item->parent_birthdate }}</td>
                                                <td>{{ $item->parent_residence }}</td>
                                                <td>{{ $item->parent_living_status }} </td>

                                              </tr>
                                              @endforeach


                                              </table>

                                         </div>
                                         @endif
                                        {{-- end of parents details --}}



                                    {{-- end of children details --}}

                                </div>



                        {{-- / --}}

                        {{-- Start of Education --}}

                        @if($qualifications->count() > 0 || $certifications->count() > 0)
                                <div class="row">


                                    {{-- start of Academic Qualifications details --}}
                                    <div class="col-md-12">

                                        <h5 class="" style="border-bottom:4px solid #00204e !important;">EDUCATIONAL BACKGROUND: </h5>

                                        <div class="row mb-1">
                                         <div class="col-12">

                                            <table class="table table-bordered" id="dynamicAddRemove">
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
                                            </table>



                                         </div>
                                        {{-- start of Proffessional Certification details --}}
                                        <h6 class=""> Professional Certification/License</h6>

                                         <div class="col-12">
                                            <table class="table table-bordered" id="dynamicAddRemoveParent">
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
                        @endif
                        {{-- / --}}

                        {{-- start of Employment History --}}
                        @if($histories->count() >0)
                                <div class="row">


                                    {{-- start of previous employment details --}}
                                    <div class="col-md-12">
                                        <h5 class=""> EMPLOYMENT HISTORY:</h5>
                                        <div class="row mb-1">
                                         <div class="col-12">

                                            <table class="table table-bordered" id="dynamicAddRemove">
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
                        @endif
                        {{-- / --}}

                    </div>
                </div>
            </div>



        {{-- / --}}
          </div>







      </div>
</div>








@endsection





