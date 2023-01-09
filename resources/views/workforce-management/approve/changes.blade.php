@extends('layouts.vertical', ['title' => 'Employee Approval'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Pending Approval</h5>
    </div>

    <div class="card-body">
        <!-- Highlighted tabs -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card card-primary card-outline card-outline-tabs border-0 shadow-none">

                    <div class="card-header border-0 shadow-none">
                        <ul class="nav nav-tabs nav-tabs-highlight">
                            @include('workforce-management.approve.inc.tab')
                        </ul>
                    </div>

                    <div class="card-body border-0 shadow-none">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="{{ route('approve.changes') }}" role="tabpanel" aria-labelledby="custom-tabs-four-ivr-tab">

                                <div class="card border-0 shadow-none">
                                    <div class="card-header border-0 shadow-none">
                                        <h5 class="text-muted">Current Employee Transfer</h5>
                                    </div>
                                </div>

                                <table class="table datatable-basic">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Transfer Attribute</th>
                                            <th>Destination</th>
                                            <th>Status</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($transfers as $row) {
                                            if($row->status==1 || $row->status>=5) continue; ?>
                                            <tr>
                                                <td width="1px"><?php echo $row->SNo; ?></td>
                                                <td><?php  echo $row->empName; ?></td>
                                                <td><?php echo "<b>DEPARTMENT:</b> ".$row->department_name."<br><b>POSITION: </b>".$row->position_name; ?></td>

                                                <td><?php echo $row->parameter; ?></td>

                                                <td> <?php
                                                    if($row->parameterID==1){
                                                        if(session('mng_paym') ){
                                                            echo "<b>FROM: </b> ".number_format($row->old,2)."/=<br><b>TO: </b>".number_format($row->new,2)."/=";
                                                        }
                                                    }elseif ($row->parameterID==2) {
                                                        echo $this->flexperformance_model->newPositionTransfer($row->new);
                                                    }elseif ($row->parameterID==3) {
                                                        echo "<b>DEPARTMENT:</b> ".$this->flexperformance_model->newDepartmentTransfer($row->new)."<br><b>POSITION: </b>".$this->flexperformance_model->newPositionTransfer($row->new_position);
                                                    }elseif ($row->parameterID==4) {
                                                        echo "<b>BRANCH:</b> ".$this->flexperformance_model->newBranchTransfer($row->new_department)."<br><b>DEPARTMENT:</b> ".$this->flexperformance_model->newDepartmentTransfer($row->new_department)."<br><b>POSITION: </b>".$this->flexperformance_model->newPositionTransfer($row->new_position);
                                                    } ?>

                                                </td>
                                                <td>

                                                    <div id ="status<?php echo $row->id; ?>">
                                                        <?php if($row->status==0){ ?> <div class="col-md-12"><span class="label label-default">WAITING</span></div><?php }
                                                        elseif($row->status==1){ ?><div class="col-md-12"><span class="label label-success">ACCEPTED</span></div><?php }
                                                        elseif($row->status==2){ ?><div class="col-md-12"><span class="label label-danger">REJECTED</span></div><?php } ?>
                                                    </div>

                                                </td>

                                                <td class="options-width">
                                                    <a href="<?php echo base_url()."index.php/cipay/userprofile/".$row->empID; ?>" title="Employee Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>

                                                    <?php if($row->status==0){ ?>

                                                        <a href="javascript:void(0)" onclick="disapproveRequest(<?php echo $row->id; ?>)" title="Reject" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a>

                                                        <?php if($row->parameterID==1){
                                                            if(session('mng_paym')){  ?>
                                                                <a href="javascript:void(0)" onclick="approveSalaryTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>

                                                            <?php } } elseif($row->parameterID==2){ ?>
                                                            <a href="javascript:void(0)" onclick="approvePositionTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>

                                                        <?php }elseif($row->parameterID==3){ ?>
                                                            <a href="javascript:void(0)" onclick="approveDeptPosTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>

                                                        <?php }elseif($row->parameterID==4){ ?>
                                                            <a href="javascript:void(0)" onclick="approveBranchTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>
                                                        <?php } } ?>
                                                </td>

                                            </tr>

                                        <?php } //} ?>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /highlighted tabs -->
    </div>

</div>

@endsection


