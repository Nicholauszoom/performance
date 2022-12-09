@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')



        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Outcomes </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              

              <!-- START ASSIGNED TO OTHERs -->
              <?php 
                    //if( session('line') != 0){ ?> 
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $tag; ?> </h2>

                    

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <?php

                     echo $this->session->flashdata("note");  ?>
                  <div id="resultfeed"></div>
                    <table  id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th><b>S/N</b></th>
                          <th><b>Outcome Name</b></th>
                          <th><b>Accountable Executive</b></th>
                          <th><b>Duration</b></th>
                          <th><b>RAG Status</b></th>
                          <th><b>Option</b></th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php
                      foreach ($outcomes as $row) { ?>
                          <tr id="record<?php echo $row->id;?>">
                              <td><?php echo $row->SNo; ?></td>
                              <td><p><b><?php echo $row->strategy_ref.".".$row->id.".".$row->title; ?></b></p></p>
                                  <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target=".bs-outcome-modal-lg<?php echo $row->id; ?>">View More...</button>
  
                                  <div class="modal fade bs-outcome-modal-lg<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
  
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                          </button>
                                          <h4 class="modal-title" id="myModalLabel">Outcome Description</h4>
                                        </div>
                                        <div class="modal-body">
                                          <h4><b>Title: &nbsp;</b><?php echo $row->title; ?></h4>
                                          <p><?php echo $row->description; ?></p>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
  
                                      </div>
                                    </div>
                                  </div>
                              </td>
                              <td><?php  if($row->isAssigned == 0){ ?> 
                                  <div class="col-md-12">
                                      <span class="label label-warning"><b>Not Assigned</b></span></div>
                                  <?php  }  else echo $row->executive; ?> 
                              </td>
                              <td><?php 
              
                                  $startd=date_create($row->start);
                                  $endd=date_create($row->end);
                                  $diff=date_diff($startd, $endd);
                                  $DURATION = $diff->format("%a"); ?>
                                  <p><b><font class="green"><?php  echo $DURATION+1; ?>  Days</font></b><br>
                                  From <b><font class="green"><?php echo date('d-m-Y', strtotime($row->start)); ?></font></b> <br>
                                  To <b><font class="green"><?php echo date('d-m-Y', strtotime($row->end)); ?></font></b></p>
                                  
                              </td>
                              
                              <td>
                                <ul class="list-inline prod_color">
                                  <li>
                                      <?php 
                                      $totalTaskProgress = $row->sumProgress;
                                      $taskCount = $row->countOutput;
                                      if($taskCount==0) $progress = 0; else $progress = number_format(($totalTaskProgress/$taskCount),1);
                                      
                                      $todayDate=date('Y-m-d');
                                      $endd=$row->end;
                                        
                                      
                              if($todayDate>$endd) {
                    
                                if($progress==100){ ?>
                                    <p><b>Completed</b></p>
                                        <div class="color bg-green"></div> 
                                        <?php } elseif($progress<100) { ?>
                                        <p><b>Overdue(<?php echo $progress; ?>%)</b></p>
                                        <div class="color bg-red"></div> <?php } 
                                } else { 
                                    if($progress==0){ ?>
                                    <p><b>Not Started</b></p>
                                        <div class="color bg-orange"></div>
                                        <?php } elseif($progress>0 && $progress<100) { ?>
                                    <p><b>
                                        In Progress (<?php echo $progress; ?>%) </b></p>
                                        <div class="color bg-blue-sky"></div>
                                    <?php } elseif($progress==100){ ?>
                                        <p><b>Completed</b></p>
                                        <div class="color bg-green"></div>
                                    <?php }  }  ?> 
                                    </li>
                                </ul>
                              </td>
                              <td class="options-width">
                                  <a href="<?php echo  url('')."flex/performance/outcome_info/?id=".base64_encode($row->strategy_ref."|".$row->id); ?>"   title="Outcome Info and Details" class="icon-2 info-tooltip"><button  class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                  <a href="javascript:void(0)" onclick="deleteOutcome(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                  <!-- <a href = "<?php echo  url('')."flex/performance/output/".$row->id."/".$row->strategy_ref; ?>"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button></a> -->
                                  
                                  </td>
                          </tr> 
                      <?php  }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div> <?php //} ?>
              <!-- END ASSIGNED TO OTHERS -->

            </div>
          </div>
        </div>

        



        <!-- /page content -->
       


 @endsection