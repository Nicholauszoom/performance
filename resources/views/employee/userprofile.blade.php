@extends('layouts.vertical', ['title' => 'Employee Profile'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')

    <?php
    foreach ($employee as $row) {
        $name = $row->fname . ' ' . $row->mname . ' ' . $row->lname;
        $state = $row->state;
        $department = $row->deptname;
        $empID = $row->emp_id;
        $gender = $row->gender;
        $merital_status = $row->merital_status;
        $birthdate = explode('-', $row->birthdate);
        $hire_date = explode('-', $row->hire_date);
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

    foreach ($active_properties as $rowActive) {
        $numActive = $rowActive->ACTIVE_PROPERTIES;
    }

    $delimeter = '|';
    ?>

    <div class="mb-3">
        <h5 class="text-muted">Employee Profile</h5>
    </div>

    <div class="row">
        <div class="col-md-4 mt-1">
            <div class="card rounded-0 border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0border-0 shadow-none pb-4">
                <div class="sidebar-section-body text-center">
                    <div class="card-img-actions d-inline-block my-3">
                        {{-- rounded-circle --}}
                        <img class="img-fluid "
                            src="{{ $photo == 'user.png' ? 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=00204e&color=fff' : asset('storage/profile/' . $photo) }}"
                            width="150" height="150" alt="">
                    </div>

                    <h6 class="mb-0">{{ $name }}</h6>
                    <span class="text-muted mb-3">{{ $position }}</span>
                </div>

                <ul class="nav nav-sidebar mt-3">
                    <li class="nav-item-divider"></li>

                    <li class="nav-item d-flex justify-content-around align-items-center my-3">
                        <a href="{{ route('password.employee') }}" class="btn btn-main">
                            <i class="ph-note-pencil me-2"></i>
                            Change Password
                        </a>

                        @if (session('mng_emp'))
                            {{-- <a href="{{ url('/flex/updateEmployee/').$empID.'|'.$departmentID; }}" class="btn btn-main"> --}}
                            <a href="{{ route('flex.userdata', base64_encode($row->emp_id)) }}" class="btn btn-main">
                                <i class="ph-user me-2"></i>
                                View Biodata
                            </a>
                        @endif
                    </li>
                </ul>
            </div>

            <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0border-0 shadow-none">
                <div class="card-header border-0 shadow-none">
                    {{-- text-muted --}}
                    <h6 class=" text-warning">Basic Details</h6>
                </div>

                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>Gender:</td>
                            <td>{{ $gender }} </td>
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
                                <td>{{ $birthdate[2] . '-' . $birthdate[1] . '-' . $birthdate[0] }}</td>
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
                            <td>{{ $hire_date[2] . '-' . $hire_date[1] . '-' . $hire_date[0] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
                <div class="card-header">
                    <h6 class="text-warning">Work Details</h6>
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
                        @if (session('mng_emp') || session('appr_paym') || session('mng_paym') || session('emp_id') == $empID)
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
                            <td>{{ $hire_date[2] . '-' . $hire_date[1] . '-' . $hire_date[0] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- datails --}}
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    @if (session('mng_emp') || session('emp_id') == $empID)
                        <form method="post" action="{{ route('reports.payslip') }}" target="_blank">
                            @csrf
                            <div class="card border-0 rounded-0">
                                <div class="m-3">
                                    <label class="form-label text-warning" for="stream">Pay Slip</label>

                                    <input hidden name="employee" value="{{ $empID }}">
                                    <input hidden name="profile" value="1">

                                    <div class="input-group">
                                        <select required name="payrolldate" class="select_payroll_month form-control select"
                                            data-width="1%">
                                            <option>Select Month</option>
                                            @foreach ($month_list as $row)
                                                <option value="{{ $row->payroll_date }}">
                                                    {{ date('F, Y', strtotime($row->payroll_date)) }}</option>
                                            @endforeach
                                        </select>

                                        <button type="submit" class="btn btn-main" type="button"><i
                                                class="ph-printer me-2"></i> Print</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>


            @if (session('mng_roles_grp') || session('emp_id') == $empID)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card rounded-0 ">
                            <div class="card-body border-0">
                                <ul class="nav nav-tabs nav-tabs-underline nav-justified nav-tabs-filled mb-3"
                                    id="tabs-target-right" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="#work" class="nav-link active show" data-bs-toggle="tab"
                                            aria-selected="true" role="tab" tabindex="-1">
                                            Work
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#permission" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                            role="tab" tabindex="-1">
                                            Permission
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#asset" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                            role="tab" tabindex="-1">
                                            Asset
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#l-d" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                            role="tab" tabindex="-1">
                                            L & D
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a href="#pension" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                            role="tab" tabindex="-1">
                                            Pension History
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a href="#exit" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                            role="tab" tabindex="-1">
                                            Exit
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content " id="myTabContent">
                                {{-- work --}}
                                <div role="tabpanel" class="tab-pane fade active show " id="work"
                                    aria-labelledby="work-tab">

                                    <div class="card border-top  border-top-width-3 border-top-main rounded-0 m-2 shadow-none">
                                        <div class="card-header d-flex justify-content-between">
                                            <h5 class="text-main">Next of Kin(s)</h5>

                                            @if (session('mng_emp'))
                                                <button type="button" class="btn btn-main" data-bs-toggle="modal"
                                                    data-bs-target="#nextkinModal">
                                                    <i class="ph-plus me-2"></i> Add Next of kin
                                                </button>
                                            @endif
                                        </div>

                                        <table class="table table-striped table-bordered">
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
                                                @foreach ($kin as $row)
                                                    <tr>
                                                        <td width="1px"> {{ $loop->iteration }}</td>
                                                        </td>
                                                        <td><?php echo $row->fname . ' ' . $row->mname . ' ' . $row->lname; ?></td>
                                                        <td><?php echo $row->relationship; ?></td>
                                                        <td><?php echo $row->mobile; ?></td>
                                                        <td><?php echo $row->postal_address; ?></td>

                                                        <td class="options-width">
                                                            <form method="POST"
                                                                action="{{ route('flex.deletekin', ['empID' => $empID, 'id' => $row->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-xs">
                                                                    <i class="ph-trash"></i>
                                                                </button>
                                                            </form>
                                                            {{-- <a href="<?php echo url('') . 'flex/deletekin/' . $row->id; ?>" title="Delete" class="btn btn-danger btn-sm">
                                        </a> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                {{-- / --}}

                                {{-- Permission --}}
                                <div role="tabpanel" class="tab-pane " id="permission" aria-labelledby="permission-tab">
                                    <div class="card rounded-0  shadow-none">
                                        <div class="card-header">
                                            <h6 class="text-muted">Permissons</h6>
                                            <hr>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card border-top border-top-width-3 border-top-main rounded-0 border-0 shadow-none">
                                                    <div class="card-header border-0">
                                                        <h6 class="text-muted">Roles Granted</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <form action="{{ route('flex.revokerole') }}" method="post">
                                                            @csrf

                                                            <input type="text" hidden="hidden" name="empID"
                                                                value="<?php echo $empID; ?>" />

                                                            <table class="table table-striped table-bordered">
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
                                                                    <tr>
                                                                        <td><?php echo $row->SNo; ?></td>
                                                                        <td><?php echo $row->NAME; ?></td>
                                                                        <?php if(session('mng_roles_grp'))  { ?>
                                                                        <td class="options-width">
                                                                            <label class="containercheckbox">
                                                                                <input type="checkbox" name="option[]"
                                                                                    value="<?php echo $row->role; ?>">
                                                                                <span class="checkmark"></span>
                                                                            </label>
                                                                            <input type="text" hidden="hidden"
                                                                                name="roleid"
                                                                                value="<?php echo $row->id; ?>" />
                                                                        </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                    <?php }  ?>
                                                                </tbody>
                                                            </table>

                                                            <?php if(session('mng_roles_grp'))  { ?>
                                                            <div class="form-group mt-3">
                                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                                    <button type="submit" name="revoke"
                                                                        class="btn btn-main">REVOKE</button>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0  shadow-none">
                                                    <div class="card-header border-0">
                                                        <h6 class="text-muted">Roles Not Granted</h6>
                                                    </div>

                                                    <div class="card-body">
                                                        <form action="{{ route('flex.assignrole') }}" method="post">
                                                            @csrf

                                                            <input type="text" hidden="hidden" name="empID"
                                                                value="<?php echo $empID; ?>" />

                                                            <table class="table table-striped table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S/N</th>
                                                                        <th>Name</th>
                                                                        <th>Option</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <?php foreach ($allrole as $row) {  ?>
                                                                    <tr>
                                                                        <td><?php echo $row->SNo; ?></td>
                                                                        <td><?php echo $row->name; ?></td>
                                                                        <td class="options-width">
                                                                            <label class="containercheckbox">
                                                                                <input type="checkbox" name="option[]"
                                                                                    value="<?php echo $row->id; ?>">
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
                                                                    <button type="submit" name="assign"
                                                                        class="btn btn-main">GRANT</button>
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
                                {{-- / --}}

                                {{-- asset --}}
                                <div role="tabpanel" class="tab-pane " id="asset" aria-labelledby="asset-tab">


                                    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                                        <div class="card-header d-flex justify-content-between">
                                            <h5 class="text-main">Company Proprty(ies)</h5>

                                            @if (session('mng_emp'))
                                                <button type="button" class="btn btn-main" data-bs-toggle="modal"
                                                    data-bs-target="#propertyModal">
                                                    <i class="ph-plus me-2"></i> Assign More Property
                                                </button>
                                            @endif
                                        </div>

                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Type</th>
                                                    <th>Name</th>
                                                    <th>Serial No</th>
                                                    <th>Assigned By</th>
                                                    <th>Date</th>
                                                    <?php if(session('mng_emp'))  { ?>
                                                    <th>Option</th><?php }  ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($property as $row) { ?>
                                                <tr id="domain<?php echo $row->id; ?>">
                                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                                    </td>
                                                    <td><?php echo $row->prop_type; ?></td>
                                                    <td><?php echo $row->prop_name; ?></td>
                                                    <td><?php echo $row->serial_no; ?></td>
                                                    <td><?php echo $row->PROVIDER; ?></td>
                                                    <td><?php echo $row->dated_on; ?></td>
                                                    <?php if(session('mng_emp'))  { ?>
                                                    <td class="options-width">
                                                        <a href="javascript:void(0)"
                                                            onclick="deleteDomain(<?php echo $row->id; ?>)" title="Delete"
                                                            class="icon-2 info-tooltip">
                                                            <font color="red"> <i class="fa fa-trash-o"></i></font>
                                                        </a>&nbsp;&nbsp;
                                                    </td><?php }  ?>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                {{-- / --}}

                                {{-- L & D --}}
                                <div role="tabpanel" class="tab-pane " id="l-d" aria-labelledby="l-d-tab">
                                    <div class="card border-top  border-top-width-3 border-top-main  rounded-0  shadow-none mb-3">
                                        <div class="card-header">
                                            <h4 class="text-main">Skills Acquired </h4>
                                        </div>

                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($skills_have as $row) {  ?>
                                                <tr>
                                                    <td><?php echo $row->SNo; ?></td>
                                                    <td><?php echo $row->NAME; ?></td>
                                                </tr>
                                                <?php }  ?>
                                            </tbody>
                                        </table>
                                    </div>


                                    <?php if(session('mng_emp')) { ?>
                                    <hr class="my-4">

                                    <div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
                                        <div class="card-header">
                                            <h5 class="text-main">Skills Not Acquired (To be Trained)</h5>
                                        </div>

                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                    <th>Mandatory</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php

                                        foreach ($skills_missing as $row) {  ?>
                                                <tr id="recordSkills<?php echo $row->id; ?>">
                                                    <td><?php echo $row->SNo; ?></td>
                                                    <td><?php echo $row->name; ?></td>
                                                    <td>
                                                        <?php if($row->mandatory == 1){ ?>
                                                        <span class="badge bg-success">YES</span><?php }
                                                else{ ?>
                                                        <span class="badge bg-warning">NO</span><?php }
                                                ?>
                                                    </td>

                                                    <td class="options-width">
                                                        <?php if($row->status==9 ){ ?>
                                                        <a
                                                            href="<?php echo url(''); ?>flex/employeeCertification/?val=<?php echo $empID . '|' . $row->id; ?>">
                                                            <button class="btn btn-success btn-xs">ASSIGN SKILL</button>
                                                        </a>
                                                        <?php } else{ ?>
                                                        <span class="badge bg-default">REQUESTED</span>

                                                        <?php if($row->status==0){ ?> <div class="col-md-12"><span
                                                                class="badge bg-default">WAITING FOR APPROVAL</span></div>
                                                        <?php }
                                          elseif($row->status==1){ ?><div class="col-md-12"><span
                                                                class="badge bg-primary">RECOMMENDED</span></div>
                                                        <?php }
                                          elseif($row->status==2){ ?><div class="col-md-12"><span
                                                                class="badge bg-info">APPROVED</span></div>
                                                        <?php }
                                          elseif($row->status==3){ ?><div class="col-md-12"><span
                                                                class="badge bg-success">CONFIRMED</span></div>
                                                        <?php }
                                          elseif($row->status==4){ ?><div class="col-md-12"><span
                                                                class="badge bg-warning">SUSPENDED</span></div>
                                                        <?php }
                                          elseif($row->status==5){ ?><div class="col-md-12"><span
                                                                class="badge bg-danger">DISAPPROVED</span></div>
                                                        <?php }
                                          elseif($row->status==6){ ?><div class="col-md-12"><span
                                                                class="badge bg-danger">UNCONFIRMED</span></div>
                                                        <?php } ?>


                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php }  ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php }  ?>

                                    <hr class="my-4">

                                    <div class="card border-top border-top-width-3 border-top-main rounded-0 border-0 shadow-none">
                                        <div class="card-header">
                                            <h4 class="text-main">Skills Requested For Training</h4>
                                        </div>
                                        <table id="skillsTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                    <th>Mandatory</th>
                                                    <th>State</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php

                                    foreach ($requested_skills as $row) {  ?>
                                                <tr>
                                                    <td><?php echo $row->SNo; ?></td>
                                                    <td><?php echo $row->name; ?></td>
                                                    <td><?php if($row->mandatory == 1){ ?>

                                                        <div class="col-md-12">
                                                            <span class="badge bg-success">YES</span>
                                                        </div><?php }
                                      else{ ?>
                                                        <div class="col-md-12">
                                                            <span class="badge bg-warning">NO</span>
                                                        </div><?php } ?>
                                                    </td>
                                                    <td>

                                                        <div id="status<?php echo $row->id; ?>">
                                                            <?php if($row->status==0){ ?> <div class="col-md-12"><span
                                                                    class="badge bg-default">WAITING</span></div>
                                                            <?php }
                                        elseif($row->status==1){ ?><div class="col-md-12"><span
                                                                    class="badge bg-primary">RECOMMENDED</span></div>
                                                            <?php }
                                        elseif($row->status==2){ ?><div class="col-md-12"><span
                                                                    class="badge bg-info">APPROVED</span></div>
                                                            <?php }
                                        elseif($row->status==3){ ?><div class="col-md-12"><span
                                                                    class="badge bg-success">CONFIRMED</span></div>
                                                            <?php }
                                        elseif($row->status==4){ ?><div class="col-md-12"><span
                                                                    class="badge bg-warning">SUSPENDED</span></div>
                                                            <?php }
                                        elseif($row->status==5){ ?><div class="col-md-12"><span
                                                                    class="badge bg-danger">DISAPPROVED</span></div>
                                                            <?php }
                                        elseif($row->status==6){ ?><div class="col-md-12"><span
                                                                    class="badge bg-danger">UNCONFIRMED</span></div>
                                                            <?php } ?>
                                                        </div>

                                                    </td>

                                                </tr>
                                                <?php }  ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- / --}}

                                {{-- Pension --}}
                                <div role="tabpanel" class="tab-pane " id="pension" aria-labelledby="permission-tab">
                                    <div class="card rounded-0 border-0 shadow-none">
                                        <div class="card-header">
                                            <h6 class="text-muted">Pension History</h6>
                                            <hr>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 col-lg-12 col-sm-12">
                                                <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
                                                    <div class="card-header border-0">
                                                        <h6 class="text-muted">Summary</h6>
                                                        <hr>
                                                    </div>

                                                    @php
                                                    $total = 0;
                                                      foreach ($employee_pension as $row) {

                                                      $total +=$row->pension_employee;
                                                      }

                                                    @endphp

                                                    <div class="card-body">
                                                        <form action="{{ route('flex.revokerole') }}" method="post">
                                                            @csrf

                                                            <input type="text" hidden="hidden" name="empID"
                                                                value="<?php echo $empID; ?>" />

                                                            <table class="table table-striped table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th> Total Pension Employee</th>
                                                                        <th>Total Pension Employer</th>

                                                                    </tr>
                                                                </thead>

                                                                <tbody>

                                                                    <tr>
                                                                        <td>{{ number_format($total,2 ) }}</td>
                                                                        <td>{{ number_format($total,2 ) }}</td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">Total : {{ number_format($total*2,2) }}</td>


                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-12 col-sm-12">
                                                <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 border-1 col-md-12">
                                                    <div class="card-header border-0">
                                                        <h6 class="text-muted">Detailed</h6>
                                                        <hr>
                                                    </div>

                                                    <div class="card-body">


                                                        <input type="text" hidden="hidden" name="empID"
                                                            value="<?php echo $empID; ?>" />

                                                        <table id="datatable"
                                                            class="table table-striped table-bordered datatable-basic">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Pension Employee</th>
                                                                    <th>Pension Employer</th>
                                                                    <th hidden></th>
                                                                    <th hidden></th>
                                                                    <th hidden></th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php foreach ($employee_pension as $row) {  ?>
                                                                <tr>
                                                                    <td><?php echo $row->payment_date; ?></td>
                                                                    <td><?php echo number_format($row->pension_employee,2); ?></td>
                                                                    <td><?php echo number_format($row->pension_employer,2); ?></td>
                                                                    <td hidden></td>
                                                                    <td hidden></td>
                                                                    <td hidden></td>
                                                                </tr>
                                                                <?php }   ?>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- / --}}

                                {{-- Exit --}}
                                <div role="tabpanel" class="tab-pane " id="exit" aria-labelledby="exit-tab">
                                    <div class="card border-top border-top-width-3 border-top-main  rounded-0 border-0 shadow-none">

                                        <div class="card-body">
                                            <form id="upload_form" method="post" enctype="multipart/form-data"
                                                action="{{ route('flex.employeeDeactivationRequest') }}"
                                                data-parsley-validate>
                                                @csrf

                                                <!--   index.php/cipay/employee_exit-->
                                                <?php if ($state != 3): ?>
                                                <div class="mb-3" align="center">
                                                    <label class="form-label"></label>

                                                    <div class="">
                                                        <div class="d-inline-flex align-items-center me-3">
                                                            <input type="radio" name="initiator" value="Employee"
                                                                id="dc_li_c">
                                                            <label class="ms-2" for="dc_li_c">Employee
                                                                Initiated</label>
                                                        </div>

                                                        <div class="d-inline-flex align-items-center">
                                                            <input type="radio" name="initiator" value="Employer"
                                                                id="dc_li_u">
                                                            <label class="ms-2" for="dc_li_u">Employer
                                                                Initiated</label>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="stream">Exit Date</label>
                                                            <input type="date" required name="exit_date"
                                                                autocomplete="off" placeholder="Exit Date"
                                                                class="form-control" id="exit_date"
                                                                aria-describedby="inputSuccess2Status">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="last-name">Interview
                                                                Notes</label>
                                                            <textarea placeholder="Message or Reason  For Exit" cols="10" class="form-control" name="reason"
                                                                rows="5"></textarea>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="mt-3">
                                                    <input type="text" hidden name="empID"
                                                        value="<?php echo $empID; ?>" />
                                                    <input type="text" hidden name="state" value="disable" />
                                                    <button type="submit" name="exit" value="exit"
                                                        class="btn btn-main">Confirm Exit</button>
                                                    <?php else: ?>
                                                    <input type="text" hidden name="empID"
                                                        value="<?php echo $empID; ?>" />
                                                    <input type="text" hidden name="state" value="enable" />
                                                    <button type="submit" name="exit" disabled value="exit"
                                                        class="btn btn-main">Confirm Exit</button>
                                                    <?php endif; ?>
                                                    <!-- <?php if($state = 0 ){ ?>
                                                <h5><?php echo number_format($allowances, 2); ?></h5> <?php } ?>
                                                <button  type="submit" <?php if($state == 1 || $numActive > 0) { ?> disabled <?php } ?> name="exit" value = "exit" class="btn btn-warning">CONFIRM EXIT</button> -->

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- / --}}

                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- <div class="row">
        <div class="col-md-">
            <div class="card">
                <div class="card-header">
                    <h6>
                        <i class="ph ph-book"></i>
                        Academic Qualifications
                    </h6>
                </div>

                <div class="card-body">
                <div class="col-md-12 m-2">
                    <div class="">
                        @forelse ($qualifications as $item )
                        <div class="row">
                            <div class="col-md-4">Institute</div>
                            <div class="col-md-8 text-end">{{ $item->institute}}</div>

                            <div class="col-md-4">Course</div>
                            <div class="col-md-8 text-end">{{ $item->course }}</div>

                            <div class="col-md-4">Level</div>
                            <div class="col-md-8 text-end"> {{ $item->level }}</div>

                            <div class="col-md-3">Start Year</div>
                            <div class="col-md-3 text-end">{{ $item->start_year }}</div>

                            <div class="col-md-3">Finish Year</div>
                            <div class="col-md-3 text-end">{{ $item->end_year }}</div>

                            <div class="col-md-8"></div>
                            <div class="col-md-4 text-end">
                             <a href="" class="btn btn-sm btn-main text-end">
                                <i class="ph ph-file-pdf"></i>
                                View Certificate
                             </a>
                            </div>

                        </div>

                        <hr>
                        @empty
                        <p class="text-center"> There isn't any Academic Qualification</p>
                        @endforelse

                    </div>


                </div>


                </div>
            </div>
        </div>
      </div> --}}

        </div>
    </div>


@endsection


@section('modal')
    <div id="nextkinModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-main">Add Next of Kin to <?php echo $name; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <form id="demo-form2" enctype="multipart/form-data" method="post"
                        action="{{ route('flex.addkin', $empID) }}" {{-- action="<?php echo url(''); ?>/flex/addkin/<?php echo $empID; ?>" --}} data-parsley-validate>
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="first-name">First Name</label>
                            <input type="text" name="fname" id="fname" class="form-control"
                                placeholder="First Name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="first-name">Middle Name</label>
                            <input type="text" name="mname" id="fname" class="form-control"
                                placeholder="Middle Name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="first-name">Last Name</label>
                            <input type="text" name="lname" class="form-control" placeholder="Last Name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="first-name" for="stream">Relationships</label>
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
                            <input type="text" name="mobile" id="fname" class="form-control"
                                placeholder="Mobile">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="first-name">Postal Address</label>
                            <input type="text" name="postal_address" id="fname" class="form-control"
                                placeholder="Postal Address">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="first-name">Physical Address</label>
                            <input type="text" name="physical_address" id="fname" class="form-control"
                                placeholder="Physical Address">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="first-name">Office Mobile No</label>
                            <input type="text" name="office_no" id="fname" class="form-control"
                                placeholder="Office Mobile No">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" value="Add" name="add" class="btn btn-main" />
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

                    <form id="demo-form2" enctype="multipart/form-data" method="post"
                        action="{{ route('flex.addproperty') }}" data-parsley-validate>
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="first-name" for="stream">Property Type</label>
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
                            <input type="text" name="type2" id="fname" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="first-name">Property Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="first-name">Serial Number</label>
                            <input type="text" name="serial" class="form-control">
                        </div>

                        <div class="modal-footer">
                            <input hidden="hidden" name="employee" value="<?php echo $empID; ?>">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" value="Add" name="add" class="btn btn-main" />
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
        $("#save-qualification-btn").click(function(event) {
            event.preventDefault();
            if ($("#update_id").val() == null || $("#update_id").val() == "") {
                storQualification();
            } else {
                updateQualification();
            }
        })

        /*
            show modal for creating a record and
            empty the values of form and remove existing alerts
        */
        function createQualification() {
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
        function storeQualification() {
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
                    let successHtml =
                        '<div class="alert alert-success " role="alert"> Community Was Added Successfully !</div>';
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
                    if (typeof response.responseJSON.errors !== 'undefined') {
                        let errors = response.responseJSON.errors;
                        let abbreviationValidation = "";
                        if (typeof errors.abbreviation !== 'undefined') {
                            abbreviationValidation = '<li>' + errors.abbreviation[0] + '</li>';
                        }
                        let locationValidation = "";
                        if (typeof errors.location !== 'undefined') {
                            locationValidation = '<li>' + errors.location[0] + '</li>';
                        }
                        let nameValidation = "";
                        if (typeof errors.name !== 'undefined') {
                            nameValidation = '<li>' + errors.name[0] + '</li>';
                        }

                        let errorHtml = '<div class="alert alert-danger" role="alert">' +
                            '<b>Validation Error!</b>' +
                            '<ul>' + nameValidation + abbreviationValidation + locationValidation + '</ul>' +
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


        function run() {
            alert("hello world");
        }


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
            $('#exit_date').daterangepicker({
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
            $('#exit_date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY'));
            });
            $('#exit_date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endpush
