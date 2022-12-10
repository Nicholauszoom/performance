@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')
<!-- /top navigation -->


<!--TABBED VIEW STAART-->

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Company/Organization</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
         <!--Start Tabs Content-->
          <div class="col-md-12 col-sm-6 col-xs-12">
            <div class="x_panel">
              <!-- <div class="x_title">
                  
                  <h3 class="green"></h3>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Settings 1</a>
                      </li>
                      <li><a href="#">Settings 2</a>
                      </li>
                    </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div> -->
              <div class="x_content">
                  
                
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>List of Positions   </h2> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php if(session('mng_org')){ ?>
            <a  href="#bottom"><button type="button"  class="btn btn-primary">ADD POSITION</button></a>
            <?php } ?>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
             @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
             <div id="feedBackTable"></div>
            <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Name</th>
                  <th>Reports To</th>
                  <th>Department</th>
                  <!--<th>Created By</th>-->
                  <!--<th>Date Created</th>-->
                  <?php if(session('mng_org')){ ?>
                  <th>Options</th>
                  <?php } ?>
                </tr>
              </thead>


              <tbody>
                <?php
                //if ($employee->num_rows() > 0){
                  foreach ($position as $row) { ?>
                  <tr id="record<?php echo $row->id;?>">
                    <td width="1px"><?php echo $row->SNo; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td>
                        <?php if($row->id == 6) echo "Top Position"; else echo $row->parent; ?>
                    </td>
                    <td><b> <?php echo $row->department; ?></b></td>

                    <?php if(session('mng_org')){ ?>
                    <td class="options-width">
                        <a  href="<?php echo  url(''); ?>/flex/position_info/?id=".$row->id; ?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                        <?php if($row->id!=1){ ?>
                        <a href="javascript:void(0)" onclick="deletePosition(<?php echo $row->id; ?>)" title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                        <?php } ?>
                    </td>
                        <?php } ?>
                    </tr>
                  <?php } //} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div> 
      
    <!-- <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Inactive Positions   </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          <div id="feedBackTable2"></div>
            <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Name</th>
                  <th>Reports To</th>
                  <th>Department</th>
                  <th>Options</th>
                </tr>
              </thead>


              <tbody>
                <?php
                //if ($employee->num_rows() > 0){
                  foreach ($inactive_position as $row) { ?>
                  <tr id="record<?php echo $row->id;?>">
                    <td width="1px"><?php echo $row->SNo; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->parent; ?></td>
                    <td><b> <?php echo $row->department; ?></b></td>

                    <td class="options-width">
                        <a  href="<?php echo  url(''); ?>/flex/position_info/?id=".$row->id; ?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                        <a href="javascript:void(0)" onclick="activatePosition(<?php echo $row->id; ?>)" title="ACTIVATE" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>
                    </td>
                    </tr>
                  <?php } //} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>    -->

      <?php if(session('mng_org')){ ?>
                <div id="bottom" class="col-md-12 col-sm-12 col-xs-12">
                            
                    <div class="x_panel">
                      <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Add Position</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                    <div id="positionAddFeedBack"></div>
            
                        <form id="addPosition" enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
            
                          <!-- START -->
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Position Name</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <textarea required="" class="form-control col-md-7 col-xs-12" name="name" placeholder="Name" rows="2"></textarea> 
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Organization Level</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                    <select required="" id='org' name="organization_level" class="select_level form-control">
                                    <option></option>
                                       <?php foreach ($levels as $row){ ?>
                                      <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                    </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Position Code</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input type="text" maxlength="10" class="form-control col-md-7 col-xs-12" name="code" placeholder="Position Code"/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Minimum Qualification</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <textarea  class="form-control col-md-7 col-xs-12" name="qualification" placeholder="Minimum Qualification" rows="2"></textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Department</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                    <select required="" id='dept' name="department" class="select3_single form-control">
                                    <option></option>
                                       <?php foreach ($ddrop as $row){ ?>
                                      <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                    </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6">Reports To</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="input-group">
                                <select required="" id="pos" name="parent" class="select1_single form-control" tabindex="-1">
                                <option></option>
                                                
                                       <?php foreach ($all_position as $row){ 
                                      if(isset($parent)){ if ($row->name == $parent) continue; }?>
                                    <option value="<?php echo $row->position_code."|".$row->level; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                </select>
                                </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Purpose of This Position</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <textarea class="form-control col-md-7 col-xs-12" name="purpose" placeholder="Purpose" rows="3"></textarea> 
                            </div>
                          </div> <br>
                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <label class="containercheckbox"> Need a Driving Licence (Tick if True) 
                               <input type="checkbox" name="driving_licence" value="1">
                                <span class="checkmark"></span>
                              </label>
                            </div>
                          </div>  <br>
                          <!-- END -->
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <input type="submit" class="btn btn-primary"/>
                            </div>
                          </div> 
                          </form>
            
                      </div>
                    </div>
                </div>
                <?php } ?>
    <!--END EDIT TAB-->      
                    
              </div>
            </div>

          </div>
        </div>
    </div>

    


  </div>
</div>
        <!-- /page content -->
                      
<!--TABBED VIEW END-->

<?php   ?>


<script type="text/javascript">

  $(".select_level").select2({
          placeholder: "Select Organization Level",
          allowClear: true
        });
    $('#addPosition').submit(function(e){
        e.preventDefault();
        var maxSalary = $('#maxSalary').val();
        var minSalary = $('#minSalary').val();
        if (minSalary > maxSalary) {
          alert("Maximum Salary should be Greater Than Minimum salary");
        }else{
          $.ajax({
               url:"<?php echo  url(''); ?>/flex/addPosition",
               type:"post",
               data:new FormData(this),
               processData:false,
               contentType:false,
               cache:false,
               async:false
           })
            .done(function(data){
              $('#positionAddFeedBack').fadeOut('fast', function(){
                  $('#positionAddFeedBack').fadeIn('fast').html(data.message);
                });
              setTimeout(function(){// wait for 2 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 2000); 
            })
            .fail(function(){
              alert('Request Failed!! ...'); 
            });
        }
    }); 
</script>
<script> //For Deleting records without Page Refreshing
      
    function deletePosition(id)
    {
        if (confirm("Are You Sure You Want To Delete This Position") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/deletePosition');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();

              if(data.status == 'OK'){
              alert("Deleted Sussessifully!");
              $('#domain'+id).hide();              
              $('#feedBackTable').fadeOut('fast', function(){
              $('#feedBackTable').fadeIn('fast').html(data.message);
            });
              setTimeout(function() {
                location.reload();
              }, 1000);
              }else if(data.status != 'SUCCESS'){
              alert("Position Not Deleted, Error In Deleting");
               }
           
            
            // document.location.reload();
               
            }
               
            });
        }
    } 
      
    function activatePosition(id)
    {
        if (confirm("Are You Sure You Want To Activate This Department") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/activatePosition');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();

              if(data.status == 'OK'){
              alert("SUCCESS!");
              $('#domain'+id).hide();
              $('#feedBackTable2').fadeOut('fast', function(){
              $('#feedBackTable2').fadeIn('fast').html(data.message);
            });
              setTimeout(function() {
                location.reload();
              }, 1000);
              }else if(data.status != 'SUCCESS'){
              alert("Property Not Activated, Error In Activation");
               }
           
               
            }
               
            });
        }
    }        
</script> 
       
       
 @endsection