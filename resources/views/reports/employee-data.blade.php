<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Biodata</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ public_path('assets/bootstrap/css/bootstrap.min.css') }}">


    <style>
        /* .productsTable , th, td {
  border: 1px solid;
} */
    </style>
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

<div class="container">
    <div class="row" style="border-bottom: 8px solid black !important; " >
        <div class="col-4"></div>
        <div class="col-md-4 col-4">
                <div class="row">
                <div class="col-6 mx-auto" style="width:10%;margin:auto">
                    <img src="" alt="Img Here">
                    {{-- <img src="https://www.bancabc.co.tz/images/banc_abc_logo.png" alt="logo here" width="150px" height="150px"> --}}

                </div>
                <div class="col-12">
                    <h5 class="text-center"style="font-size:14px !important;" >
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


        <table style="border:none" width="100%;border-bottom:5px;">
                    <tr>
                        <td style="width:50%">
           {{-- start of name information --}}
           <div class="col-md-12 col-md-12 col-lg-12 col-12">
            <h5 class="text-center bg-secondary" style="border: 1px solid black !important;font-size:14px;">Name Information</h5>
           <div class="row mb-1 p-1" >
            <div class="row">
                    <h6 style="font-size:12px;font-weight:normal">  Prefix
                        <span class="text-muted float-end float-right"> @if($details) {{$details->prefix}} @endif</span>
                    </h6>
                    <h6 style="font-size:12px;font-weight:normal">   First Name
                        <span class="text-muted float-end float-right"> @if($profile) {{$profile->fname}} @endif </span>
                    </h6>
                    <h6 style="font-size:12px;font-weight:normal">   Middle Name
                        <span class="text-muted float-end float-right"> @if($profile) {{$profile->mname}} @endif </span>
                    </h6>
                    <h6 style="font-size:12px;font-weight:normal">   Surname
                        <span class="text-muted float-end float-right"> @if($profile) {{$profile->lname}} @endif </span>
                    </h6>
                    <h6 style="font-size:12px;font-weight:normal">   Maiden Name
                        <span class="text-muted float-end float-right"> @if($details) {{$details->maide_name}} @endif</span>
                    </h6>
                    <h6 style="font-size:12px;font-weight:normal;color:white;">   Maiden Name
                        <span class="text-muted float-end float-right"> @if($details) {{$details->maide_name}} @endif</span>
                    </h6>



            </div>


           </div>
        </div>
        {{-- end of name information --}}
                        </td>

                        <td style="width:50%">
        {{-- start of biography information --}}
        <div class="col-md-12 col-md-12 col-lg-12 col-12">
            <h5 class="text-center bg-secondary" style="border: 1px solid black !important;font-size:14px;">Biography Information</h5>
           <div class="row mb-1 p-1">
            <div class="row">
                <h6 style="font-size:12px;font-weight:normal">  Date of Birth
                    <span class="text-muted float-end float-right"> @if($profile) {{$profile->birthdate}} @endif</span>
                </h6>
                <h6 style="font-size:12px;font-weight:normal">   Place of Birth (City/Region):
                    <span class="text-muted float-end float-right"> @if($details) {{$details->birthplace}} @endif  </span>
                </h6>
                <h6 style="font-size:12px;font-weight:normal">   Country of Birth:
                    <span class="text-muted float-end float-right"> @if($details) {{$details->birthcountry}} @endif </span>
                </h6>
                <h6 style="font-size:12px;font-weight:normal">   Gender/Sex:
                    <span class="text-muted float-end float-right"> @if($profile) {{$profile->gender}} @endif  </span>
                </h6>
                <h6 style="font-size:12px;font-weight:normal">   Marital Status:
                    <span class="text-muted float-end float-right"> @if($profile) {{$profile->merital_status}} @endif </span>
                </h6>
                <h6 style="font-size:12px;font-weight:normal">   Religion:
                    <span class="text-muted float-end float-right">  @if($details) {{$details->religion}} @endif  </span>
                </h6>

            </div>


           </div>
        </div>
        {{-- end of biography information --}}
                        </td>
                    </tr>

                    </table>

                        {{-- start of address and identification details --}}

                    <div class="row">
                            <table style="border:none" width="100%;border-bottom:5px;">
                                <tr>
                                    <td style="width:50%">
                       {{-- start of Address information --}}
                       <div class="col-md-12 col-md-12 col-lg-12 col-12">
                        <h5 class="text-center bg-secondary" style="border: 1px solid black !important;font-size:14px;">Address Information</h5>
                       <div class="row mb-1 p-1" >
                        <div class="row">
                                <h6 style="font-size:12px;font-weight:normal">  Physical Address
                                    <br>
                                    <span class="text-muted ">  @if($profile) {{$profile->physical_address}} @endif</span>
                                </h6>
                                <h6 style="font-size:12px;font-weight:normal"> Landmark near your home
                                    <span class="text-muted "> <br> @if($details) {{$details->landmark}} @endif</span>
                                </h6>
                                <h6 style="font-size:12px;font-weight:normal;color:white;">   Middle Name
                                    {{-- <span class="text-muted float-end float-right"> @if($profile) {{$profile->mname}} @endif </span> --}}
                                </h6>
                                <h6 style="font-size:12px;font-weight:normal;color:white;">   Surname
                                    {{-- <span class="text-muted float-end float-right"> @if($profile) {{$profile->lname}} @endif </span> --}}
                                </h6>
                                <h6 style="font-size:12px;font-weight:normal;color:white;">   Maiden Name
                                    {{-- <span class="text-muted float-end float-right"> @if($details) {{$details->maide_name}} @endif</span> --}}
                                </h6>



                        </div>


                       </div>
                    </div>
                    {{-- end of name information --}}
                                    </td>
            
                    <td style="width:50%;height:300px;">
                    {{-- start of biography information --}}
                    <div class="col-md-12 col-md-12 col-lg-12 col-12">
                        <h5 class="text-center bg-secondary" style="border: 1px solid black !important;font-size:14px;">Identification Information</h5>
                       <div class="row mb-1 p-1">
                        <div class="row">
                            <h6 style="font-size:12px;font-weight:normal">  TIN  :
                                <span class="text-muted float-end float-right"> <small> @if($profile) {{$profile->tin}} @endif</small></span>
                            </h6>
                            <h6 style="font-size:12px;font-weight:normal">    NIDA Number
                                <span class="text-muted float-end float-right"><small><?php echo $national_id; ?></small>   </span>
                            </h6>
                            <h6 style="font-size:12px;font-weight:normal">   Passport Number:
                                <span class="text-muted float-end float-right"> @if($details) {{$details->passport_number}} @endif </span>
                            </h6>
                            <h6 style="font-size:12px;font-weight:normal">   Pension Fund Number:
                                <span class="text-muted float-end float-right"><small><?php echo $pf_membership_no; ?> </small>  </span>
                            </h6>
                            <h6 style="font-size:12px;font-weight:normal">    HELSB Number:
                                <span class="text-muted float-end float-right"><small><?php echo $HELSB; ?></small> </span>
                            </h6>
                            <h6 style="font-size:17px;font-weight:normal;color:white;">   Maiden Name
                                <br>
                                {{-- <span class="text-muted float-end float-right"> @if($details) {{$details->maide_name}} @endif</span> --}}
                            </h6>


                        </div>


                       </div>
                    </div>
                    {{-- end of biography information --}}
                                    </td>
                                </tr>

                                </table>

                        </div>


                        {{-- start of employee details --}}

                    <div class="row">
                        <table style="border:none" width="100%;border-bottom:5px;">
                                <tr>
                                    <td style="width:50%">
                       {{-- start of Emergency information --}}
                       <div class="col-md-12 col-md-12 col-lg-12 col-12">
                        <h5 class="text-center bg-secondary" style="border: 1px solid black !important;font-size:14px;">Emergency Contact Details</h5>
                       <div class="row mb-1 p-1" >
                        <div class="row">
                                <h6 style="font-size:12px;font-weight:normal">   First Name
                                    <span class="text-muted float-end float-right">  @if($emergency) {{ $emergency->em_fname}} @endif</span>
                                </h6>
                                <h6 style="font-size:12px;font-weight:normal"> Middle Name
                                    <span class="text-muted float-end float-right "> @if($emergency) {{ $emergency->em_mname}} @endif@endif</span>
                                </h6>
                                <h6 style="font-size:12px;font-weight:normal;">  Surname
                                    <span class="text-muted float-end float-right"> @if($emergency) {{ $emergency->em_sname}} @endif </span>
                                </h6>
                                <h6 style="font-size:12px;font-weight:normal;">   Relationship
                                    <span class="text-muted float-end float-right">  @if($emergency) {{ $emergency->em_relationship}} @endif </span>
                                </h6>
                                <h6 style="font-size:12px;font-weight:normal;">   Occupation
                                    <span class="text-muted float-end float-right">  @if($emergency) {{ $emergency->em_occupation}} @endif </span>
                                </h6>
                                <h6 style="font-size:12px;font-weight:normal;">    Cellphone Number
                                    <span class="text-muted float-end float-right"> @if($emergency) {{ $emergency->em_phone}} @endif </span>
                                </h6>


                        </div>


                       </div>
                    </div>
                    {{-- end of name information --}}
                                    </td>

                                    <td style="width:50%">
                    {{-- start of biography information --}}
                    <div class="col-md-12 col-md-12 col-lg-12 col-12">
                        <h5 class="text-center bg-secondary" style="border: 1px solid black !important;font-size:14px;">Employment Details</h5>
                       <div class="row mb-1 p-1">
                        <div class="row">
                            <h6 style="font-size:12px;font-weight:normal">  Date of Employment :
                                <span class="text-muted float-end float-right"> <small> <?php echo $hire_date; ?></small></span>
                            </h6>
                            <h6 style="font-size:12px;font-weight:normal">   First Job Title
                                <span class="text-muted float-end float-right"><small> @if($details) {{ $details->former_title}} @endif</small>   </span>
                            </h6>
                            <h6 style="font-size:12px;font-weight:normal">   Current Job Title:
                                <span class="text-muted float-end float-right"> <?php echo $title; ?> </span>
                            </h6>
                            <h6 style="font-size:12px;font-weight:normal">   Department & Branch:
                                {{-- <span class="text-muted float-end float-right"><small><?php echo $department; ?> ,<?php echo $branch; ?></small>  </span> --}}
                            </h6>
                            <h6 style="font-size:12px;font-weight:normal">   Line Manager:
                                <span class="text-muted float-end float-right"><small> <?php echo $linemanager; ?></small> </span>
                            </h6>
                            <h6 style="font-size:12px;font-weight:normal;color:white;">   Maiden Name
                                <br>
                                {{-- <span class="text-muted float-end float-right"> @if($details) {{$details->maide_name}} @endif</span> --}}
                            </h6>


                        </div>


                       </div>
                    </div>
                    {{-- end of biography information --}}
                                    </td>
                                </tr>

                                </table>

                        </div>
                        {{-- / --}}
                                <div class="row">



                        {{-- Start of Family Informations --}}


                                <div class="row">

                                    <h5 style="border-bottom:4px solid black !important;font-size:14px;">FAMILY DETAILS</h5>

                                    {{-- start of spouse details --}}
                                    @if($spouse)
                                    <div class="col-md-12">

                                        <h5 style="font-size:13px">Spouse Details:</h5>
                                        <div class="row mb-1">
                                        <table style="border:none" width="100%">
                                        <tr>
                                           <td width="50%" style="width: 50%">
                                                <h6 style="font-size:12px;font-weight:normal">   Names
                                                    <span class="text-muted float-end float-right"> <small> @if($spouse) {{ $spouse->spouse_fname}} @endif</small></span>
                                                </h6>
                                                <h6 style="font-size:12px;font-weight:normal">  Country of Birth
                                                    <span class="text-muted float-end float-right"> <small> @if($spouse) {{ $spouse->spouse_birthcountry}} @endif</small></span>
                                                </h6>
                                                <h6 style="font-size:12px;font-weight:normal">  NIDA Number
                                                    <span class="text-muted float-end float-right"> <small> @if($spouse) {{ $spouse->spouse_nida}} @endif </small></span>
                                                </h6>
                                                <h6 style="font-size:12px;font-weight:normal">  Employer:
                                                    <span class="text-muted float-end float-right"> <small>@if($spouse) {{ $spouse->spouse_employer}} @endif </small></span>
                                                </h6>
                                            </td>
                                            <td width="50%" style="width:50%">
                                                <h6 style="font-size:12px;font-weight:normal">  Place of Birth (City/Region):
                                                    <span class="text-muted float-end float-right"> <small>  @if($spouse) {{ $spouse->spouse_birthplace}} @endif</small></span>
                                                </h6>
                                                <h6 style="font-size:12px;font-weight:normal">  Nationality
                                                    <span class="text-muted float-end float-right"> <small>@if($spouse) {{ $spouse->spouse_nationality}} @endif</small></span>
                                                </h6>
                                                <h6 style="font-size:12px;font-weight:normal">  Passport Number:
                                                    <span class="text-muted float-end float-right"> <small> @if($spouse) {{ $spouse->spouse_passport}} @endif</small></span>
                                                </h6>
                                                <h6 style="font-size:12px;font-weight:normal">  Job Title:
                                                    <span class="text-muted float-end float-right"> <small> @if($spouse) {{ $spouse->spouse_job_title}} @endif</small></span>
                                                </h6>
                                            </td>

                                        </tr>

                                        </table>
                                        </div>



                                    </div>
                                    @endif
                                    {{-- end of spouse details --}}

                                    {{-- start of children details --}}
                                    @if($children->count() >0)
                                    <div class="col-md-12">
                                        <hr>
                                        <h5 style="font-size:13px" > Children/ Details</h5>
                                        <div class="row mb-1">
                                         <div class="col-6 col-md-6 col-6 col-lg-6">
                                             <h6 style="font-size:12px;">Number of children :
                                                <p class="text-muted float-end float-right"> @if($childs) {{ $childs }} @endif </p>
                                            </h6>
                                         </div>
                                         <div class="col-12">

                                            @if($childs)
                                            <small><i>* (Birth Certificate/Adoption certificate stating you are the legal guardian must be attached)</i></small>
                                            <table class=""  style="font-size: 10px;border:0.5px solid black;" width="100%" >
                                                <tr style="border:1px solid black">
                                                <td  style="font-size: 10px;border:0.5px solid black;">Names of Children
                                                    (First two names)
                                                    </td>
                                                <td  style="font-size: 10px;border:0.5px solid black;">Surname</td>
                                                <td  style="font-size: 10px;border:0.5px solid black;">Birthdate</td>
                                                <td  style="font-size: 10px;border:0.5px solid black;">Sex: M/F</td>
                                                <td  style="font-size: 10px;border:0.5px solid black;">Birth Certificate #</td>
                                                <tr>
                                                @foreach ( $children as $item )
                                              <tr>

                                                <td  style="font-size: 10px;border:0.5px solid black;">{{ $item->dep_name}} </td>
                                                <td  style="font-size: 10px;border:0.5px solid black;">{{ $item->dep_surname }} </td>
                                                <td  style="font-size: 10px;border:0.5px solid black;">{{ $item->dep_birthdate }}</td>
                                                <td  style="font-size: 10px;border:0.5px solid black;">{{ $item->dep_gender }}</td>
                                                <td  style="font-size: 10px;border:0.5px solid black;">{{ $item->dep_certificate }} </td>

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
                                        <h5 style="font-size:14px;"> Parent's Details :</h5>

                                         <div class="col-12">
                                           <table class="table table-responsive productsTable "  style="font-size: 10px;border:0.5px solid black;" width="100%" >
                                              <tr style="border:1px solid black;">
                                              <td  style="font-size: 10px;border:0.5px solid black;" class="text-center">Names (Three Names)</td  style="font-size: 10px;border:0.5px solid black;">
                                              <td  style="font-size: 10px;border:0.5px solid black;">Relationship</td  style="font-size: 10px;border:0.5px solid black;">
                                              <td  style="font-size: 10px;border:0.5px solid black;">Birthdate</td  style="font-size: 10px;border:0.5px solid black;">
                                              <td  style="font-size: 10px;border:0.5px solid black;" class="text-center">Residence  (City/Region & Country)</td  style="font-size: 10px;border:0.5px solid black;">
                                              <td  style="font-size: 10px;border:0.5px solid black;">Living Status</td>
                                              </tr>
                                              @foreach ( $parents as $item )
                                              <tr>

                                                <td  style="font-size: 10px;border:0.5px solid black;">{{ $item->parent_names}} </td>
                                                <td style="font-size: 10px;border:0.5px solid black;">{{ $item->parent_relation }} </td>
                                                <td  style="font-size: 10px;border:0.5px solid black;">{{ $item->parent_birthdate }}</td>
                                                <td  style="font-size: 10px;border:0.5px solid black;">{{ $item->parent_residence }}</td>
                                                <td  style="font-size: 10px;border:0.5px solid black;">{{ $item->parent_living_status }} </td>

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

                                        <h5 class="" style="border-bottom:4px solid black !important; font-size:14px;">EDUCATIONAL BACKGROUND: </h5>

                                        <div class="row mb-1">
                                         <div class="col-12">

                                            <table class="table table-responsive table-bordered" id="dynamicAddRemove"  style="font-size: 10px;border:0.5px solid black;">
                                                <tr>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">From /To(Month & Year)</td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">University/College/School (From highest level of education)</td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">Qualification Obtained </td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">Disciplinary of Study </td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">Location </td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">Final Score & Grades</td>

                                                </tr>
                                                @forelse ( $qualifications as $item )
                                              <tr>

                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">{{ $item->start_year}} - {{ $item->end_year}} </td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">{{ $item->institute }} </td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">{{ $item->level }}</td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">{{ $item->course }}</td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">{{ $item->study_location }} </td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">{{ $item->final_score }} </td>

                                              </tr>

                                              @empty

                                              @endforelse
                                            </table>



                                         </div>
                                        {{-- start of Proffessional Certification details --}}
                                        <h6 class=""> Professional Certification/License</h6>

                                         <div class="col-12">
                                            <table class="table table-responsive table-bordered" width="100%"  style="font-size: 10px;border:0.5px solid black;">
                                                <tr>
                                                <td class="text-center" style="font-size: 10px;border:0.5px solid black;">From/To (Month & Year)</td>
                                                <td class="text-center" style="font-size: 10px;border:0.5px solid black;">Name of Professional Certification/License If any</td>
                                                <td class="text-center" style="font-size: 10px;border:0.5px solid black;">Qualification Obtained </td>
                                                <td class="text-center" style="font-size: 10px;border:0.5px solid black;">Membership Number</td>
                                                <td class="text-center" style="font-size: 10px;border:0.5px solid black;">Status Active/ Inactive</td>

                                                </tr>
                                                @forelse ( $certifications as $item )
                                                <tr>

                                                  <td class="text-center" style="font-size: 10px;border:0.5px solid black;" >{{ $item->cert_start}} - {{ $item->cert_end }}</td>
                                                  <td class="text-center" style="font-size: 10px;border:0.5px solid black;" >{{ $item->cert_name }} </td>
                                                  <td class="text-center" style="font-size: 10px;border:0.5px solid black;">{{ $item->cert_qualification }}</td>
                                                  <td class="text-center" style="font-size: 10px;border:0.5px solid black;">{{ $item->cert_number }}</td>
                                                  <td class="text-center" style="font-size: 10px;border:0.5px solid black;">{{ $item->cert_status }} </td>

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
                                        <h5 style="font-size:14px;"> EMPLOYMENT HISTORY:</h5>
                                        <div class="row mb-1">
                                         <div class="col-12">

                                            <table class="table table-response table-bordered cell-border" id="dynamicAddRemove" width="100%" style="font-size:10px; border:0.5 px solid black;">
                                                <tr>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">From /To(Month & Year)</td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">Employer</td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">Industry Auditing/Telecom Financial/Mining etc </td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">Position Held at the time of exit</td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">Employment Status</td>
                                                <td class="text-center"  style="font-size: 10px;border:0.5px solid black;">Reason for Leaving</td>
                                                @forelse ( $histories as $item )
                                              <tr>

                                                <td class="text-center" style="font-size: 10px;border:0.5px solid black;">{{ $item->hist_start}} - {{ $item->hist_end}} </td>
                                                <td class="text-center" style="font-size: 10px;border:0.5px solid black;">{{ $item->hist_employer }} </td>
                                                <td class="text-center" style="font-size: 10px;border:0.5px solid black;">{{ $item->hist_industry }} </td>
                                                <td class="text-center" style="font-size: 10px;border:0.5px solid black;">{{ $item->hist_position }}</td>
                                                <td class="text-center" style="font-size: 10px;border:0.5px solid black;">{{ $item->hist_status }}</td>
                                                <td class="text-center" style="font-size: 10px;border:0.5px solid black;">{{ $item->hist_reason }} </td>

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
            <h5 style="border-bottom:4px solid black !important;font-size:14px;">DISCLOSURE STATEMENT</h5>
            <p style="font-size:10px">
                I declare that all information furnished is true. I authorise and consent the bank to obtain anu other information form any
                other sources and by whatever means considered appropriate.
            </p>
            <p style="font-size:10px">
                I understand that any misrepresentation/ false declaration and omission of facts made in this form will be sufficient cause
                for my termination at any time during my employment with African Banking Corporation Tanzania Limited also trading as BancABC.
            </p>

            <p style="font-size:10px">

                Employee’s Name: ………………………………………………... <br>
                Signature: …………………………………………………………. <br>
                Date :……………………………………………………………… <br>
            </p>
        </div>


        {{-- / --}}
          </div>


        {{-- end of employee bio data --}}



        <div class="row p-2" style="border-top:1px solid black !important;margin-top:2px !important; ">
        <table style="border:none;">
            <tr>
                <td width="50%" style="width:50%">
                    <div class="col-12 col-md-12 col-12 col-lg-12 text-danger" style="font-size:10px;">
                        <i>
                            H i g h l y C o n f i d e n t i a l
                        </i>
                    </div>
                </td>
                <td width="50%" style="width:50%">
    
                    <div class="col-12 col-md-12 col-12 col-lg-12 text-secondary" style="font-size:10px;">
                        <i>
                            E m p l o y e e s I n i t i a l : _ _ _ _ _ _ _ _ _ _ _ _ _ _
                        </i>

                    </div>
                </td>

            </tr>
        </table>

        </div>

      </div>
</div>




<script src="{{ public_path('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>


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
