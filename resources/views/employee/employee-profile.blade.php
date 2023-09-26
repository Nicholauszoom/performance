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

<div class="row">
        <div class="col-md-12">

    <form action="{{ route('flex.saveDetails') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">
            <div class="card border-top  rounded-0 border-0 shadow-none">
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

                            <div class="card rounded-0 shadow-none">
                                <div class="card-header mb-2">
                                    <h5 class="text-main">PROFILE PICTURE: </h5>
                                </div>
                                @if (session('msg'))
                                <div class="alert alert-success col-md-10 mx-auto text-center mx-auto" role="alert">
                                {{ session('msg') }}
                                </div>
                                @endif

                                    <div class="col-md-12 mt-1">
                                        <div class="card rounded-0 border-0 shadow-none pb-4">
                                        <div class="sidebar-section-body text-center">
                                            <div class="card-img-actions d-inline-block my-3">
                                                <img class="" src="{{ ($photo == 'user.png') ? 'https://ui-avatars.com/api/?name='.$name.'&background=00204e&color=fff' : asset('storage/profile/' . $photo) }}" width="150" height="150" alt="">
                                            </div>

                                            <h6 class="mb-0">{{ $name }}</h6>
                                            <span class="text-muted mb-3">{{ $position }}</span>
                                        </div>
                                        <div class="row mx-auto">
                                            <div class="col-md-7 mx-auto">
                                                <label for="image" class="text-secondary font-weight-light">Upload a New Passport Image</label>
                                                <input type="file" name="image" id="image" class="form-control" required>
                                                <input type="hidden" name="empID" value="{{ $empID }}">
                                            </div>

                                            <div class="col-md-4 mx-auto">
                                                <div class="mt-3"> <!-- Added margin top for separation -->
                                                    <button type="submit" class="btn btn-main btn-block"> <!-- Simplified button styling -->
                                                        <i class="fa fa-save"></i> Update Image
                                                    </button>
                                                </div>
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

                        <div class="card    rounded-0 shadow-none">
                            <div class="card-header">
                                <h5 class="text-main">BASIC DETAILS: </h5>
                            </div>
                            <div class="card-body ">

                                   {{--displaying all the errors  --}}

                                <div class="row">

                                    <div class="col-12">
                                        <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                                            <h5 class="text-warning">Name Information</h5>

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
                                                        <input type="text" name="fname" value="<?php echo $fname; ?>" class="form-control" required>
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
                                                        <input type="text" name="maide_name" @if($details) value="{{ $details->maide_name }}" @endif class="form-control">
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
                                        <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                                            <h5 class="text-warning">Biography Information</h5>


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
                                                        <label for="">Religion</label>
                                                        <input type="text" name="religion" @if($details) value="{{ $details->religion}}" @endif  class="form-control">
                                                    </div>
                                                    <div class="form-group col-12 mb-2">
                                                        <label for="">Gender/ Sex</label>
                                                        <hr>
                                                        <input type="radio" id="male" name="gender" @foreach($employee as $item) {{$item->gender == "Male" ? 'checked':'' }} @endforeach value="Male"   class="">
                                                        <label for="male">Male</label>
                                                        <input type="radio" id="female" @foreach($employee as $item) {{$item->gender == "Female" ? 'checked':'' }} @endforeach name="gender" value="Female">
                                                        <label for="female">Female</label>
                                                    </div>
                                                    <div class="form-group col-12 mb-3">
                                                        <label for="">Martial Status</label>
                                                        <hr>
                                                       <div class="row">
                                                        <div class="col mb-2">
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
                                                            <input type="date" class="form-control" id="Married" name="marriage_date" @if($details) value="{{ $details->marriage_date}}" @endif><br>

                                                        </div>
                                                        <div class="col mb-2">
                                                            <input type="radio" id="Separated" name="merital"  @foreach($employee as $item) {{$item->merital_status == "Separated" ? 'checked':'' }} @endforeach value="Separated">
                                                            <label for="Separated">Separated</label>
                                                        </div>
                                                        <div class="col mb-2">
                                                            <input type="radio" id="divorced" name="merital" id="Divorced" @foreach($employee as $item) {{$item->merital_status == "Divorced" ? 'checked':'' }} @endforeach value="Divorced">
                                                            <label for="divorced" class="pr-5">Divorced</label> <br>

                                                        </div>
                                                        <div class="col">
                                                            <label>Divorced Date</label><br>
                                                            <input type="date" class="form-control" name="divorced_date" @if($details) value="{{ $details->divorced_date}}" @endif>
                                                           <br>
                                                        </div>
                                                        <div class="col mb-2">
                                                            <input type="radio" id="widow" name="merital"  @foreach($employee as $item) {{$item->merital_status == "Widow/Widower" ? 'checked':'' }} @endforeach value="Widow/Widower">
                                                            <label for="widow">Widow/Widower</label><br>
                                                        </div>
                                                       </div>



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
                        <div class="card  rounded-0 border-0 shadow-none">
                            <div class="card-header">
                                <h5 class="text-main">ADDRESS AND IDENTIFICATION: </h5>

                            </div>

                            <div class="row p-2">

                                <div class="col-md-12">
                                    <div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                                        <h5 class="text-warning">Address Information</h5>
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

                                                <div class="form-group col-6 mb-2">
                                                    <label for="">Phone Number</label>
                                                    <input type="text" name="mobile" @if($employee)  value="<?php echo $mobile; ?>" @endif class="form-control">
                                                </div>
                                            </div>
                                            <div class="card-footer ">
                                                <button type="submit" class="btn btn-main float-end"> Save Details</button>
                                            </div>
                                    </div>


                                </div>
                                <div class="col-md-12">
                                    <div class="card border-top border-top-width-3 border-top-main rounded-0 p-2">
                                        <h5 class="text-warning">Personal Identification Information</h5>



                                            <div class="row mb-2">

                                                <div class="form-group col-6 mb-2">
                                                    <label for="">TIN Number</label>
                                                    <input type="text" name="TIN" value="<?php echo $tin; ?>" class="form-control" required>
                                                </div>
                                                <div class="form-group col-6 mb-2">
                                                    <label for="">NIDA Number</label>
                                                    <input type="text" name="NIDA" value="<?php echo $national_id; ?>"  class="form-control" required>
                                                </div>
                                                <div class="form-group col-6 mb-2">
                                                    <label for="">Passport Number</label>
                                                    <input type="text" name="passport_number" @if($details) value="{{ $details->passport_number}}" @endif class="form-control">
                                                </div>
                                                <div class="form-group col-6 mb-2">
                                                    <label for="">Pension Fund Number</label>
                                                    <input type="text" name="pension" value="<?php echo $pf_membership_no; ?>" class="form-control" required>
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
                    </form>
                    {{-- / --}}

                    {{-- page 3 --}}
                    @include('employee.employment-details')


                    {{-- Page 4--}}

                    @include('employee.family-details')
                    {{-- / --}}

                    {{-- Page 5 --}}

                    @include('employee.education-professional')

                    {{-- Page 6 --}}
                    @include('employee.employee-history')




                    </div>
                        {{-- <div class="card-footer ">
                            <button type="submit" class="btn btn-main float-end"> Update Employee Detail</button>
                        </div> --}}
                </div>


          </div>
        </div>

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
