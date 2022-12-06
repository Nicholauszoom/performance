@extends('layouts.vertical', ['title' => 'Suspended Employees'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
	<script src="{{ asset('assets/js/components/tables/datatables/extensions/responsive.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_extension_responsive.js') }}"></script>
@endpush


@section('content')

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Deactivated Employees</h5>
    </div>

    <div class="card-body">
        <table class="table datatable-responsive-column-controlled">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Gender</th>
                    {{-- <th hidden>empID</th> --}}
                    <th>Position</th>
                    <th>Linemanager</th>
                    <th>Contacts</th>
                    <th>Inactive Since</th>
                    <th>Options</th>
                  </tr>
            </thead>

            <tbody>
                <?php
                  foreach ($employee1 as $row) {
                    $empid= $row->emp_id; ?>
                  <tr id="emp<?php echo $empid; ?>">
                    <td width="1px"><?php echo $row->SNo; ?></td>
                    <td><a title="More Details"  href="<?php echo base_url()."index.php/cipay/userprofile/?id=".$row->emp_id; ?>">
                    <font color="blue"><?php echo $row->NAME; ?></font></a></td>
                    <td ><?php echo $row->gender; ?></td>
                      <td hidden><?php echo $row->emp_id; ?></td>
                      <td><?php echo "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
                    <td><?php echo $row->LINEMANAGER; ?></td>
                    <td><?php echo "<b>Email: </b>".$row->email."<br><b>Mobile: </b>".$row->mobile; ?></td>
                    <td ><?php echo $row->dated;  ?></td>


                    <td class="options-width">
                    <?php if($row->isRequested==0){
                      if( $this->session->userdata('mng_emp')){ ?>
                          <a href="javascript:void(0)" title="Request Activation" class="icon-2 info-tooltip" id="reactivate"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>
                    <?php } } else { ?>
                    <div class="col-md-12">
                        <span class="label label-primary"> ACTIVATION&nbsp;<br>&nbsp;REQUESTED
                        </span></div>
                    <?php } ?>

                    </td>
                    </tr>
                  <?php } //} ?>
              </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Exit Employee List</h5>
    </div>

    <div class="card-body">
        <table class="table datatable-responsive-column-controlled">
            <thead>
                <tr>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Position</th>
                        <th>Linemanager</th>
                        <th>Contacts</th>
                        <th>Status</th>
                        <th>Options</th>
                      </tr>
                </tr>
            </thead>

            <tbody>
                <?php
                //if ($employee->num_rows() > 0){
                  foreach ($employee2 as $row) {
                    $empid= $row->emp_id; ?>
                  <tr id="activeRecord<?php echo $row->logID; ?>">
                    <td width="1px"><?php echo $row->SNo; ?></td>
                    <td><a title="More Details"  href="<?php echo base_url()."index.php/cipay/userprofile/?id=".$row->emp_id; ?>">
                    <font color="blue"><?php echo $row->NAME; ?></font></a></td>
                    <td ><?php echo $row->gender; ?></td>
                    <td><?php echo "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
                    <td><?php echo $row->LINEMANAGER; ?></td>
                    <td><?php echo "<b>Email: </b>".$row->email."<br><b>Mobile: </b>".$row->mobile; ?></td>
                    <td >
                    <?php if ($row->current_state==1 && $row->log_state==1){  ?>
                    <div class="col-md-12">
                        <span class="label label-success">ACTIVE
                        </span></div>
                      <?php } elseif($row->current_state==1 && $row->log_state==0){ ?>
                    <div class="col-md-12">
                        <span class="label label-danger">INACTIVE
                        </span></div>

                      <?php }  if ($row->log_state==2){ ?>
                        <div class="col-md-12">
                        <span class="label label-danger">INACTIVE
                        </span></div>
                        <?php  } if ($row->log_state=="3"){ ?>
                        <div class="col-md-12">
                        <span class="label label-danger">Exit
                        </span></div><?php  } if ($row->log_state=="4"){   } ?>
                    </td>


                    <td class="options-width">


                    <?php if ($row->current_state==0){

                    if( $this->session->userdata('appr_emp')){

                    if ($row->log_state==2){  ?>
                    <a href="javascript:void(0)" onclick="activateEmployee(<?php echo $row->logID.','.$row->emp_id; ?>)"  title="Confirm and Activate Employee" class="icon-2 info-tooltip">
                        <div class="col-md-12">
                        <span class="label label-success">ACTIVATE
                        </span></div></a> <?php }

                        if ($row->log_state==3 && ($row->initiator != $this->session->userdata('emp_id'))){ ?>
                    <a href="javascript:void(0)" onclick="deactivateEmployee(<?php echo $row->logID; ?>,'<?php echo $row->emp_id; ?>')"  title="Confirm exit employee" class="icon-2 info-tooltip">
                        <button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                    </a> <?php } }

                        if( $this->session->userdata('mng_emp')){ ?>
                    <a href="javascript:void(0)" onclick="cancelRequest(<?php echo $row->logID; ?>,'<?php echo $row->emp_id; ?>')"  title="Cancel exit" class="icon-2 info-tooltip">
                        <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                    </a>
                    <?php } }  else { ?>
                    <div class="col-md-12">
                    <span class="label label-primary">comitted
                    </span></div><?php  } ?>

                        </td>
                    </tr>
                  <?php } //} ?>
              </tbody>
        </table>
    </div>
</div>

@endsection



