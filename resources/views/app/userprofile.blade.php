@extends('layouts.vertical', ['title' => 'Dashboard'])

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
  }

  foreach($active_properties as $rowActive) {
    $numActive = $rowActive->ACTIVE_PROPERTIES;
  }

  $delimeter = "|";
?>

  <div class="mb-3">
    <h5 class="text-muted">User Profile</h5>
  </div>

  <div class="row">
    <div class="col-md-4 mt-1">
        <div class="card border-0 shadow-none">
          <div class="sidebar-section-body text-center">
              <div class="card-img-actions d-inline-block my-3">
                  <img class="img-fluid rounded-circle" src="../../../assets/images/demo/users/face11.jpg" width="150" height="150" alt="">
              </div>

              <h6 class="mb-0">{{ $name }}</h6>
              <span class="text-muted">{{ $position }}</span>
          </div>

          <ul class="nav nav-sidebar mt-3">
              @if (session('mng_emp'))
              <li class="nav-item-divider"></li>

              <li class="nav-item d-flex justify-content-center align-items-center my-3">
                  <a href="{{ url('/flex/updateEmployee/?id=').$empID.'|'.$departmentID; }}" class="btn btn-main" data-bs-toggle="tab">
                      <i class="ph-note-pencil me-2"></i>
                      Request Profile Update
                  </a>
              </li>
              @endif

          </ul>
        </div>

        <div class="card border-0 shadow-none">
          <div class="card-header border-0 shadow-none">
            <h6 class="text-muted">Basic Details</h6>
          </div>

          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>Gender:</td>
                <td>{{ $gender}} </td>
              </tr>
              <tr>
                <td>Email:</td>
                <td>{{ $email }}</td>
              </tr>
              <tr>
                <td>Merital Status:</td>
                <td>{{ $merital_status }}</td>
              </tr>

              @if (session('mng_emp') || session('emp_id') == $empID)
              <tr>
                <td>Date of Birth:</td>
                <td>{{  $birthdate[2]."-".$birthdate[1]."-".$birthdate[0]  }}</td>
              </tr>
              @endif

              <tr>
                <td>Nationality:</td>
                <td>{{ $nationality }}</td>
              </tr>
              <tr>
                <td>Physical Address:</td>
                <td>{{ $physical_address }}</td>
              </tr>
              <tr>
                <td>Last Updated:</td>
                <td>{{ $hire_date[2]."-".$hire_date[1]."-".$hire_date[0] }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="card border-0 shadow-none">
          <div class="card-header">
            <h6 class="text-muted">Work Details</h6>
          </div>

          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>Employee ID:</td>
                <td>{{ $empID }}</td>
              </tr>
              <tr>
                <td>Department:</td>
                <td>{{ $department }}</td>
              </tr>
              <tr>
                <td>Position:</td>
                <td>{{ $position }}</td>
              </tr>
              <tr>
                <td>Branch:</td>
                <td>{{ $branch }}</td>
              </tr>
              <tr>
              <tr>
                <td>Line Manager:</td>
                <td>{{ $linemanager }}</td>
              </tr>
              <tr>
                <td>Contract Type:</td>
                <td>{{ $ctype }}</td>
              </tr>
              <tr>
                <td>Account No:</td>
                <td>{{ $account_no }}</td>
              </tr>
              @if( session('mng_emp') || session('appr_paym') || session('mng_paym') || session('emp_id') == $empID )
              <tr>
                <td>Salary:</td>
                <td>{{ $salary }}</td>
              </tr>
              @endif
              <tr>
                <td>Fund Membership No.:</td>
                <td>{{ $pf_membership_no }}</td>
              </tr>
              <tr>
                <td>Member Since:</td>
                <td>{{ $hire_date[2]."-".$hire_date[1]."-".$hire_date[0] }}</td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>

    {{-- datails --}}
    <div class="col-md-8">
      @if (session('mng_emp') || session('emp_id') == $empID)
      <form method="post" action="{{ url('/flex/reports/payslip') }}" target="_blank" class="form-horizontal form-label-left">
        <div class="row">
          <div class="card">
            <div class="col-md-12">
              <div class="m-3">
                <label for="stream" >Pay Slip</label>
                <div class="row mt-2">
                  <div class="col-md-8">
                    <input hidden name ="employee" value="{{ $empID }}">
                    <input hidden name ="profile" value="1">
                    <div class="input-group">
                      <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                        <option>Select Month</option>
                        @foreach ($month_list as $row)
                        <option value="{{ $row->payroll_date }}"> {{ date('F, Y', strtotime($row->payroll_date)) }}</option>
                        @endforeach
                      </select>
                      <button type="submit" class="btn btn-main" type="button"><i class="ph-printer me-2"></i> Print</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      @endif

      @if (session('mng_roles_grp') || session('emp_id') == $empID)
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h6 class="text-muted">Permissons</h6>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="card border-0 shadow-none">
                  <div class="card-header border-0">
                    <h6 class="text-muted">Roles Granted</h6>
                  </div>

                  <div class="card-body">
                    <form action="{{ url('/flex/revokerole') }}" method="post">
                      <input type="text" hidden="hidden" name="empID" value="<?php echo $empID; ?>" />
                      <table  class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <?php if(session('mng_roles_grp')) { ?>
                            <th>Option</th>
                            <?php } ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php  foreach ($role as $row) {   ?>
                            <tr >
                              <td><?php echo $row->SNo; ?></td>
                              <td><?php echo $row->NAME; ?></td>
                              <?php if(session('mng_roles_grp'))  { ?>
                              <td class="options-width">
                                <label class="containercheckbox">
                                  <input type="checkbox" name="option[]" value="<?php echo $row->role; ?>">
                                  <span class="checkmark"></span>
                                </label>
                                <input type="text" hidden="hidden" name="roleid" value="<?php echo $row->id; ?>" />
                              </td><?php } ?>
                            </tr>
                          <?php }  ?>
                        </tbody>
                      </table>
                      <?php if(session('mng_roles_grp'))  { ?>
                      <div class="form-group mt-3">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  type="submit"  name="revoke" class="btn btn-main">REVOKE</button>
                        </div>
                      </div>
                      <?php } ?>
                      </form>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card border-0 shadow-none">
                  <div class="card-header border-0">
                    <h6 class="text-muted">Roles Not Granted</h6>
                  </div>

                  <div class="card-body">
                    <form action="{{ url('/flex/assignrole/') }}" method="post">
                      <input type="text" hidden="hidden" name="empID" value="<?php echo $empID; ?>" />
                      <table  class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Option</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($allrole as $row) {  ?>
                            <tr >
                              <td><?php echo $row->SNo; ?></td>
                              <td><?php echo $row->name; ?></td>

                              <td class="options-width">

                              <label class="containercheckbox">
                              <input type="checkbox" name="option[]" value="<?php echo $row->id; ?>">
                              <span class="checkmark"></span>
                              </label>

                              </td>
                            </tr>
                          <?php }   ?>
                        </tbody>
                      </table>
                      <?php if($rolecount > 0) { ?>
                        <div class="form-group mt-3">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button  type="submit"  name="assign" class="btn btn-main">GRANT</button>
                          </div>
                        </div>
                      <?php } ?>
                      </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <h6 class="text-muted">Next of Kin</h6>
                @if (session('mng_emp'))
                <button class="btn btn-main" id="modal" data-toggle="modal" data-target="#nextkinModal">
                  <i class="ph-plus me-2"></i> Add Next of kin
                </button>
                @endif
              </div>
            </div>

            <table  class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Relationship</th>
                  <th>Mobile</th>
                  <th>Postal Address</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kin as $row) { ?>
                <tr>
                  <td width="1px"><?php echo $row->id; ?></td></td>
                  <td><?php echo $row->fname." ".$row->mname." ".$row->lname; ?></td>
                  <td><?php echo $row->relationship; ?></td>
                  <td><?php echo $row->mobile; ?></td>
                  <td><?php echo $row->postal_address; ?></td>
                  <td class="options-width">
                    <a href="<?php echo  url('') .'/flex/deletekin/?id='.$row->id; ?>" title="Delete" class="icon-2 info-tooltip">
                      <font color="red"> <i class="ph-trash"></i></font>
                    </a>
                  </td>
                </tr>
                <?php }  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header"></div>
          </div>
        </div>
      </div>

    </div>
  </div>


 @endsection


 @section('modal')
      <!-- START NEXT OF KIN MODAL -->
      <div class="modal fade" id="nextkinModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add Next of Kin to <?php echo $name; ?></h4>
                </div>
                <div class="modal-body">
                <!-- Modal Form -->
                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/addkin/?id=<?php echo $empID; ?>"  data-parsley-validate class="form-horizontal form-label-left">
              <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="fname" id="fname"  class="form-control col-md-7 col-xs-12">
                <span class="text-danger"><?php // echo form_error("fname");?></span>
              </div>
            </div>
              <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Middle Name
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="mname" id="fname"  class="form-control col-md-7 col-xs-12">
                <span class="text-danger"><?php // echo form_error("fname");?></span>
              </div>
            </div>
              <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Last Name
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="lname"  class="form-control col-md-7 col-xs-12">
                <span class="text-danger"><?php // echo form_error("fname");?></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name" for="stream" >Relationships</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="relationship" class="form-control">
                 <option value="Son/Doughter">Son/Doughter</option>
                  <option value="Uncle/Aunt">Uncle/Aunt</option>
                  <option value="Brother/Sister">Brother/Sister</option>
                  <option value="Father/Mother">Father/Mother</option>
                  <option value="Grandfather/GrandMother">Grandfather/GrandMother</option>
                  <option value="Wife/Husband">Wife/Husband</option>
              </select>
              </div>
            </div>
              <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mobile
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="mobile" id="fname"  class="form-control col-md-7 col-xs-12">
                <span class="text-danger"><?php // echo form_error("fname");?></span>
              </div>
            </div>
              <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Postal Address
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="postal_address" id="fname"  class="form-control col-md-7 col-xs-12">
                <span class="text-danger"><?php // echo form_error("fname");?></span>
              </div>
            </div>
              <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Physical Address
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="physical_address" id="fname"  class="form-control col-md-7 col-xs-12">
                <span class="text-danger"><?php // echo form_error("fname");?></span>
              </div>
            </div>
              <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Office Mobile No
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="office_no" id="fname"  class="form-control col-md-7 col-xs-12">
                <span class="text-danger"><?php // echo form_error("fname");?></span>
              </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit"  value="Add" name="add" class="btn btn-primary"/>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- Modal Form -->
</div>
<!-- /.modal -->
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
