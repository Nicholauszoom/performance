<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Biodata</title>
        <link rel="stylesheet" href="{{ public_path('assets/bootstrap/css/bootstrap.min.css') }}">

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ public_path('assets/bootstrap/css/bootstrap.min.css') }}">
</head>

<body>



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

  foreach($active_properties as $rowActive) {
    $numActive = $rowActive->ACTIVE_PROPERTIES;
  }

  $delimeter = "|";
?>

  {{-- <div class="mb-3">
    <h5 class="text-muted">Employee Biodata</h5>
  </div> --}}
<div class="container">
    <div class="row" style="border-bottom: 8px solid black !important; " >
        <div class="col-4"></div>
        <div class="col-md-4 col-4">
                <div class="row">
                <div class="col-6 mx-auto">
                    {{-- <img src="https://www.bancabc.co.tz/images/banc_abc_logo.png" alt="logo here" width="100%"> --}}

                </div>
                <div class="col-12">
                    <h5 class="text-center">
                        EMPLOYEE PERSONAL DETAILS FORM:
                    <br>
                    </h5>
                </div>
            </div>

        </div>
        <div class="col-md-4 col-4">

            <div class="card-img-actions d-inline-block float-end my-3">
                {{-- rounded-circle --}}
                  {{-- <img class=" " src="{{ ($photo == 'user.png') ? 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=00204e&color=fff' : public_path('storage/profile/' . $photo) }}" width="150px" height="150px" alt=""> --}}
              </div>

        </div>


  

    </div>

 
        {{-- Start of employee Bio data --}}
        <div class="row " style="border-bottom: 8px solid black !important; ">
            <div class="col-md-12 ">
                <div class="card border-top border-top-width-3 p-2 border-top-main  rounded-0 border-0 shadow-none">
                   
    
                   
                        {{-- start of basic information details --}}
                
                                {{-- <div class="card-header d-flex justify-content-between">
    
    
                                </div> --}}
    
                                <div class="row">
                                    {{-- start of name information --}}
                                    <div class="col-md-6 col-md-6 col-lg-6 col-6">
                                        <h5 class="text-center bg-secondary" style="border: 1px solid black !important;">Name Information</h5>
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
                                        <h5 class="text-center bg-secondary" style="border: 1px solid black !important;"> Biography Information</h5>
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
                                        <h5 class="text-center bg-secondary" style="border: 1px solid black !important;">Address Information</h5>
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
                                        <h5 class="text-center bg-secondary" style="border: 1px solid black !important;"> Personal Identification Information</h5>
                                        <div class="row mb-1">
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main">TIN Number : </h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted">  @if($profile) {{$profile->tin}} @endif</p>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main"> NIDA Number </h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted"> <?php echo $national_id; ?></p>
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
                                             <p class="text-muted"><?php echo $pf_membership_no; ?> </p>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 class="text-main"> HELSB <small> (Loan Fund Index) </small>Number:</h6>
                                         </div>
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <p class="text-muted"><?php echo $HELSB; ?></p>
                                         </div>
    
                                         </div>
                                    </div>
                                    {{-- end of personal identification information --}}
    
                        
                        {{-- / --}}
    
                        {{-- start of employment informations --}}
                    
    
                                <div class="row">
                                    {{-- start of emergency contacts --}}
                                    <div class="col-md-6 col-md-6 col-6 col-lg-6">
                                        <h5 class="text-center bg-secondary" style="border: 1px solid black !important;">Emergency Contact Details</h5>
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
                                        <h5 class="text-center bg-secondary" style="border: 1px solid black !important;"> Employment Details</h5>
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

                                    <h5 style="border-bottom:4px solid black !important;">FAMILY DETAILS</h5>

                                    {{-- start of spouse details --}}
                                    @if($spouse)
                                    <div class="col-md-12">
                                        
                                        <h5 class="">Spouse Details:</h5>
                                        <br>
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
                                      
                                        <h5 class="" style="border-bottom:4px solid black !important;">EDUCATIONAL BACKGROUND: </h5>
                                     
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
                   {{-- start of disclosure statement --}}
        <div class="row mt-2">
            <h5 style="border-bottom:4px solid black !important;">DISCLOSURE STATEMENT</h5>
            <p>
                I declare that all information furnished is true. I authorise and consent the bank to obtain anu other information form any
                other sources and by whatever means considered appropriate. 
            </p>
            <p>
                I understand that any misrepresentation/ false declaration and omission of facts made in this form will be sufficient cause
                for my termination at any time during my employment with African Banking Corporation Tanzania Limited also trading as BancABC. 
            </p>

            <p>

                Employee’s Name: ………………………………………………... <br>
                Signature: …………………………………………………………. <br>
                Date :……………………………………………………………… <br>
            </p>
        </div>


        {{-- / --}}
          </div>
    
    
        {{-- end of employee bio data --}}

 

        <div class="row p-2" style="border-top:1px solid black !important;margin-top:2px !important; ">
        <div class="col-6 col-md-6 col-6 col-lg-6 text-danger">
            <i>
                H i g h l y C o n f i d e n t i a l
            </i>
        </div>
        <div class="col-6 col-md-6 col-6 col-lg-6 text-secondary">
            <i>
                E m p l o y e e s I n i t i a l : _ _ _ _ _ _ _ _ _ _ _ _ _ _ 
            </i>
           
        </div>
        </div>
    
      </div>
</div>




<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>


<script>

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
</body>

</html>
