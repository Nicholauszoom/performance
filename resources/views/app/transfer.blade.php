@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

<div class="mb-3">
    <h4 class="text-muted">Approvals</h4>
</div>

<div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-body border-0">
        <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
            {{-- <li class="nav-item" role="presentation">
                <a href="#employee-transfer" class="nav-link active show" data-bs-toggle="tab" aria-selected="true" role="tab" tabindex="-1">
                    Employee Transfer
                </a>
            </li> --}}
            <li class="nav-item" role="presentation">
                <a href="#register-approve" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                    Employee Registered
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="myTabContent">
        {{-- transfered employee --}}
        <div role="tabpanel" class="tab-pane fade  " id="employee-transfer" aria-labelledby="transfer-tab">

            <h6 class="text-muted mb-3 mx-3">Current Employee Tranfer</h6>

            <?php echo session("note");  ?>
            <div id="resultFeedback" class="my-3"></div>

            <table id="datatable" class="table table-striped table-bordered datatable-basic">
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
                    @foreach ($transfers as $row)
                        @if ($row->status == 1 || $row->status >= 5)
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
                                    <div id="{{ 'status'.$row->id }}">
                                        @if ($row->status == 0)
                                            <span class="badge bg-secondary">WAITING</span>
                                        @elseif($row->status == 1)
                                            <span class="badge bg-success">ACCEPTED</span>
                                        @elseif ( $row->status==2 )
                                            <span class="badge bg-danger">REJECTED</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="options-width">
                                    <a href="<?php echo  url('') .'/flex/userprofile/'.$row->empID; ?>" title="Employee Info and Details" class="icon-2 info-tooltip">
                                        <button type="button" class="btn btn-info btn-xs"><i class="ph-info"></i></button>
                                    </a>

                                    <?php if($row->status==0){ ?>
                                        <a href="javascript:void(0)" onclick="disapproveRequest(<?php echo $row->id; ?>)" title="Reject" class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-danger btn-xs"><i class="ph-x"></i></button>
                                        </a>

                                    <?php if($row->parameterID==1){
                                        if(session('mng_paym')){  ?>
                                            <a href="javascript:void(0)" onclick="approveSalaryTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip">
                                                <button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                            </a>

                                        <?php } } elseif($row->parameterID==2){ ?>
                                            <a href="javascript:void(0)" onclick="approvePositionTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip">
                                                <button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                            </a>

                                        <?php }elseif($row->parameterID==3){ ?>
                                            <a href="javascript:void(0)" onclick="approveDeptPosTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip">
                                                <button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                            </a>

                                        <?php }elseif($row->parameterID==4){ ?>
                                            <a href="javascript:void(0)" onclick="approveBranchTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip">
                                                <button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                            </a>
                                    <?php } } ?>
                                </td>

                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

        </div>
        {{-- / --}}

        {{-- Approve registered employee --}}
        <div role="tabpanel" class="tab-pane active show " id="register-approve" aria-labelledby="approve-tab">

            <h6 class="text-muted mb-3 mx-3">Current Employee Registered</h6>

            <?php echo session("note");  ?>
            <div id="resultFeedback"></div>

            <table id="datatable1" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transfers as $row) {
                        if($row->status<5 || $row->status > 5) continue; ?>
                            <tr>
                                <td width="1px"><?php echo $row->SNo; ?></td>
                                <td><?php  echo $row->empName; ?></td>
                                <td><?php echo "<b>DEPARTMENT:</b> ".$row->department_name."<br><b>POSITION: </b>".$row->position_name; ?></td>
                                <td><?php echo $row->parameter; ?></td>
                                <td>
                                    <div id ="status<?php echo $row->id; ?>">
                                        <?php if($row->status==5){ ?> <div class="col-md-12"><span class="badge bg-secondary">WAITING</span></div><?php }
                                        elseif($row->status==6){ ?><div class="col-md-12"><span class="badge bg-success">ACCEPTED</span></div><?php }
                                        elseif($row->status==7){ ?><div class="col-md-12"><span class="badge bg-danger">REJECTED</span></div><?php } ?>
                                    </div>
                                </td>
                                <td class="options-width">
                                    <div class="d-flex">
                                        <a href="<?php echo  url('').'/flex/userprofile/'.$row->empID; ?>" title="Employee Info and Details" class="icon-2 info-tooltip ms-2">
                                            <button type="button" class="btn btn-info btn-xs"><i class="ph-info"></i></button>
                                        </a>
                                        <?php if($row->status==5){ ?>
                                        <a href="javascript:void(0)" onclick="disapproveRegistration(<?php echo $row->id; ?>)" title="Reject" class="icon-2 info-tooltip ms-2">
                                            <button type="button" class="btn btn-danger btn-xs"><i class="ph-x"></i></button>
                                        </a>
                                        <?php if($row->parameterID==5){
                                            if(session('mng_paym')){  ?>
                                                <a href="javascript:void(0)" onclick="approveRegistration(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip ms-2">
                                                    <button type="button" class="btn btn-success btn-xs"><i class="ph-check"></i></button>
                                                </a>
                                        <?php } } }?>
                                    </div>
                                </td>
                            </tr>
                     <?php } //} ?>
                </tbody>
            </table>

        </div>
        {{-- / --}}
    </div>
</div>
@endsection





@push('footer-script')

<script>
    // $('#datatable1').DataTable();

    function approveDeptPosTransfer(id)
    {
        if (confirm("Are You Sure You Want To Approve This Transfer(The Action may be Irreversible) ?Requirement") == true)
        {
            var id = id;

            $.ajax({
                url:'{{ url("flex/approveDeptPosTransfer") }}/'+id,
                success:function(data)
                {
                    $('#resultFeedback').fadeOut('fast', function(){
                        $('#resultFeedback').fadeIn('fast').html(data);
                    });

                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                }
            });
        }
    }

    function approveSalaryTransfer(id)
    {
        if (confirm("Are You Sure You Want To Approve This Transfer(The Action may be Irreversible) ?Requirement") == true)
        {
            var id = id;

            $.ajax({
                url:'{{ url("flex/approveSalaryTransfer") }}/'+id,
                success:function(data)
                {
                    $('#resultFeedback').fadeOut('fast', function(){
                        $('#resultFeedback').fadeIn('fast').html(data);
                    });

                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                }
            });
        }
    }

    function approvePositionTransfer(id)
    {
        if (confirm("Are You Sure You Want To Approve This Transfer(The Action may be Irreversible) ?Requirement") == true)
        {
            var id = id;
        $.ajax({
            url:'{{ url("flex/approvePositionTransfer") }}/'+id,
            success:function(data)
            {
        $('#resultFeedback').fadeOut('fast', function(){
            $('#resultFeedback').fadeIn('fast').html(data);
            });
        setTimeout(function(){// wait for 5 secs(2)
            location.reload(); // then reload the page.(3)
            }, 1000);


            }

            });
        }
    }

  function disapproveRequest(id){
    if (confirm("Are You Sure You Want To CANCEL/DELETE This Transfer(The Action may be Irreversible) ?Requirement") == true) {
    var id = id;
    $.ajax({
        url:'{{ url("flex/cancelTransfer") }}/'+id,
        success:function(data)
        {
       $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data);
        });
       setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 1000);


        }

        });
    }
  }

  function disapproveRegistration(id) {
      if (confirm("Are you sure you want to disapprove this registration ") == true) {
          var id = id;
          $.ajax({
              url:'{{ url("flex/disapproveRegistration") }}/'+id,
              success:function(data)
              {
                  $('#resultFeedback').fadeOut('fast', function(){
                      $('#resultFeedback').fadeIn('fast').html(data);
                  });
                  setTimeout(function(){// wait for 5 secs(2)
                      location.reload(); // then reload the page.(3)
                  }, 1000);


              }

          });
      }

  }

  function approveRegistration(id) {
      if (confirm("Are you sure you want to confirm this registration ") == true) {
          var id = id;
          $.ajax({
              url:'{{ url("flex/approveRegistration") }}/'+id,

              success:function(data)
              {
                  $('#resultFeedback').fadeOut('fast', function(){
                      $('#resultFeedback').fadeIn('fast').html(data);
                  });
                  setTimeout(function(){// wait for 5 secs(2)
                      location.reload(); // then reload the page.(3)
                  }, 1000);
              }

          });
      }
  }

</script>
@endpush
