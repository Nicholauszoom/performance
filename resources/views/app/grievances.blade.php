@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')
<!-- /top navigation -->

      
        <!-- page content -->
        <div class="right_col" role="main">

                 

            <div class="clearfix"></div>

            <div class="">
              <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-user"></i> Complaints </h2>
                    <!--<h2><i class="fa fa-user"></i> Grievances and Discplinary </h2>-->
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>

                    <form id="demo-form2" autocomplete="off" enctype="multipart/form-data" action="<?php echo  url(''); ?>/flex/grievances/" method="post" data-parsley-validate class="form-horizontal form-label-left">

                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                        <textarea placeholder="Title" cols="10" required="" class="form-control col-md-7 col-xs-12"  name="title"  rows="2"></textarea>
                        </div>
                      </div> <br>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description(Body)
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                        <textarea placeholder="Description" cols="10" class="form-control col-md-7 col-xs-12"  name="description" required="" rows="5"></textarea>
                        </div>
                      </div> <br>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Proof  If Any<br> ( eg. Document, Picture etc..) 
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                        <input type='file' name='userfile'  />
                        </div>
                      </div> <br>
                      
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <label class="containercheckbox">Report as Ananymous
                           <input type="checkbox" name="anonymous" value="1">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                      </div> 
                      
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" name="submit" class="btn btn-warning">SUBMIT</button>
                        </div>
                      </div>
                      
                      
                      </form><br><br> 

                      <!-- Whole View -->
               <div class="col-md-12 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!--<h2>All Grievances </h2>-->
                    <h2>My  Complaints </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <!--Table Grievances HR-->
                    
                    <table  class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Evidence</th> 
                          <th>Title</th> 
                          <th>Description</th>
                          <th>Date</th>
                          <th>Status</th>
                          <th>Option</th> 
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        // if ($department->num_rows() > 0){
                          foreach ($my_grievances as $row) {  ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php if($row->attachment != NULL) echo "<a download= '' href ='". url('').$row->attachment."'>"."<div class='col-md-12'>
                                <span class='label label-info'>DOWNLOAD</span></div>"."</a>"; else echo "NIL"; ?></td>
                            <td><?php echo $row->title; ?></td>
                            <td><?php echo $row->description; ?></td>
                            <td><?php $datesValue = str_replace('-', '/', $row->DATED);
                                  echo date('d-m-Y', strtotime($datesValue));  ?></td>

                            <td>
                            
                            <?php if( $row->status==0 ) 
                            echo '<div class="col-md-12">
                                <span class="label label-danger">ON PROGRESS</span></div>'; 
                                else
                                echo '<div class="col-md-12">
                                <span class="label label-success">SOLVED</span></div>'; ?></td>
                            
                            <td class="options-width">
                            <a title="Info and Details" href="<?php echo  url(''); ?>/flex/grievance_details/?id=".$row->id; ?>">
                                  <button  class="btn btn-info btn-xs">INFO</button></a>
                               
                            </td> 
                            </tr>
                          <?php } //} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
                    <!--End Table Grievances HR-->
                    
                    <!--Table Grievances Board-->
                    
              <?php if(session('griev_board')!='' || session('griev_hr')!='') { ?>

              <div class="col-md-12 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!--<h2>All Grievances </h2>-->
                    <h2>All Complaints </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> 
                  <div id ="feedBack" ></div>    
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Department</th>
                          <th>Evidence</th> 
                          <th>Title</th> 
                          <th>Description</th>
                          <th>Date</th>
                          <th>Status</th>
                          <th>Option</th> 
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($other_grievances as $row) {
                          //if($row->forwarded != 1 ) continue; ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php if($row->anonymous == 1) echo "ANONYMOUS"; else echo $row->NAME; ?></td>
                            <td><?php if($row->anonymous == 1) echo "ANONYMOUS"; else  echo "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
                            <td><?php if($row->attachment != NULL) echo "<a download= '' href ='". url('').$row->attachment."'>"."<div class='col-md-12'>
                                <span class='label label-info'>DOWNLOAD</span></div>"."</a>"; else echo "NIL"; ?></td>
                            <td><?php if($row->anonymous == 1) echo "ANONYMOUS"; else echo $row->title; ?></td>
                            <td><?php echo $row->description; ?></td>
                            <td><?php $datesValue = str_replace('-', '/', $row->DATED);
                                  echo date('d-m-Y', strtotime($datesValue));  ?></td>

                            <td>
                            
                            <?php if( $row->status==0 ){ 
                            echo '<div class="col-md-12">
                                <span class="label label-danger">ON PROGRESS</span></div>'; }
                                else {
                                echo '<div class="col-md-12">
                                <span class="label label-success">SOLVED</span></div>'; } ?></td>
                            
                            <td class="options-width">
                            <a title="Info and Details" href="<?php echo  url(''); ?>/flex/grievance_details/?id=".$row->id; ?>">
                                  <button  class="btn btn-info btn-xs">INFO</button></a>&nbsp;&nbsp;
                                
                              <?php if( $row->status==0 ){ ?>
                              <a href="javascript:void(0)" onclick="markSolved(<?php echo $row->id;?>)" title="Mark as Resolved" >
                                  <button  class="btn btn-success btn-xs">MARK SOLVED</button></a>

                            <?php }  else { ?>


                              <a href="javascript:void(0)" onclick="markUnsolved(<?php echo $row->id;?>)" title="Mark as Not Resolved" >
                                  <button  class="btn btn-danger btn-xs">MARK UNSOLVED</button></a>
                            <?php } ?> 
                            
                            </td> 
                            </tr>
                          <?php } //} ?>
                      </tbody>
                    </table>
                    <?php //} ?>
                    <!--End Table Grievances Board-->
                    
                    
                  </div>
                </div>
              </div> <?php } ?>
              <!-- Whole View -->

                  </div>
                </div>
              </div>
          </div>
        </div>
        <!-- /page content -->

       @include("app/includes/customtask")
        ?>

<script type="text/javascript">

    function markSolved(id)
    {
        if (confirm("Are You Sure You Want to Mark This as Solved") == true) {
        // var loanid = id;
  
            $.ajax({
                url: "<?php echo url('flex/resolve_grievance');?>/"+id
            })
            .done(function(data){
              alert('SUCCESS'); 
             $('#feedBack').fadeOut('fast', function(){
                  $('#feedBack').fadeIn('fast').html(data);
                });
             // $("#loanList").load(" #loanList");
             setTimeout(function() {
              location.reload();
             }, 2000);
             /*$('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>');
                });*/
                })
            .fail(function(){
             alert('Request Failed Failed!! ...'); 
                });
        }
    }


    

    function markUnsolved(id)
    {
        if (confirm("Are You Sure You Want Mark This as Not Solved") == true) {
        // var loanid = id;
  
            $.ajax({
                url: "<?php echo url('flex/unresolve_grievance');?>/"+id
            })
            .done(function(data){
              alert('SUCCESS'); 
             $('#feedBack').fadeOut('fast', function(){
                  $('#feedBack').fadeIn('fast').html(data);
                });

             setTimeout(function() {
              location.reload();
             }, 2000);
             
                })
            .fail(function(){
             alert('Loan Disapproval Failed!! ...'); 
                });
        }
    }
</script>


 @endsection