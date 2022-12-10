@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php 

    if (isset($position)){
        foreach ($position as $row) {
            $positionId=$row->id; 
            $positionName=$row->name; 
            $positionCode=$row->code; 
            $parent=$row->parent_code; 
            $organization_level_name=$row->organization_level_name; 
            $organization_level_id=$row->organization_level; 
            $parent_code =$row->parent_code; 
                    }
            }  

    if ($parent_code){
        $parent_name = $CI_Model->flexperformance_model->getParentPositionName($parent_code);

    }else{
        $parent_name = '';

    }
    $CI_Model = get_instance();
    $CI_Model->load->model('flexperformance_model');

    
    
    
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Position Info: &nbsp;&nbsp;&nbsp;<b><?php echo $positionName; ?></b> </h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                  
                    
                  <div class="col-lg-12"> 
                  <div id="updateFeedBack"></div>                     
                      <!--POSITION NAME-->
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                      <form autocomplete="off" id="updatePositionName" align="center" enctype="multipart/form-data" method="post"   data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        
                        <input hidden="" type="text" name="positionID" id="positionID" value="<?php echo $positionId; ?>">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Position Name 
                        </label>
                        <!--<div class="col-md-6 col-sm-6 col-xs-12">-->
                            <div class="input-group">
                                <input required="" type="text" name="name" value="<?php echo $positionName; ?>" class="form-control col-md-7 col-xs-12">
                                <span class="input-group-btn">
                                  <button  type="submit"  name="updatename" class="btn btn-success"><small>UPDATE</small></button>
                                </span>
                              </div>
                        <!--</div>-->
                      </div>
                      </form>
                      
                      <!--POSITION CODE-->
                      <form autocomplete="off" id="updatePositionCode" align="center" enctype="multipart/form-data" method="post" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <input hidden="" type="text" name="positionID" id="positionID" value="<?php echo $positionId; ?>">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Position Code 
                        </label>
                            <div class="input-group">
                                <input required="" type="text" name="code" value="<?php echo $positionCode; ?>" class="form-control col-md-7 col-xs-12">
                                <span class="input-group-btn">
                                  <button  type="submit"  name="updatecode" class="btn btn-success"><small>UPDATE</small></button>
                                </span>
                              </div>
                        <!--</div>-->
                      </div>
                      </form>
                      <?php  if ($positionId!=1){ ?>
                      <form autocomplete="off" id="updateParent" align="center" enctype="multipart/form-data" method="post" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group"><b><?php echo $parent_name; ?></b>
                        <input hidden="" type="text" name="positionID" id="positionID" value="<?php echo $positionId; ?>">
                      <input type = "text" hidden name = "parent" value = "<?php echo $parent_code; ?>" />
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reports To 
                        </label>
                            <div class="input-group">
                            <select required="" id="pos" name="parent" class="select1_single form-control" tabindex="-1">
                                <option></option>
                           <?php foreach ($all_position as $row){ 
                           if ($row->position_code == $parent|| $row->id == $positionId) continue;?>
                          <option value="<?php echo $row->position_code."|".$row->level; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                </select>
                                <span class="input-group-btn">
                                  <button  type="submit"  name="updateparent" class="btn btn-success"><small>UPDATE</small></button>
                                </span>
                              </div>
                        <!--</div>-->
                        </div>
                      </form>

                      <form autocomplete="off" id="updateOrganizationLevel" align="center" enctype="multipart/form-data" method="post" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group"><b><?php echo $organization_level_name; ?></b>
                        <input hidden="" type="text" name="positionID" id="positionID" value="<?php echo $positionId; ?>">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Organization Level 
                        </label>
                            <div class="input-group">
                            <select required="" id="pos" name="organization_level" class="select_level form-control" tabindex="-1">
                                <option></option>
                           <?php foreach ($organization_levels as $row){ 
                           if ($row->id == $organization_level_id) continue;?>
                          <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                </select>
                                <span class="input-group-btn">
                                  <button  type="submit"  name="updatelevel" class="btn btn-success"><small>UPDATE</small></button>
                                </span>
                              </div>
                        <!--</div>-->
                        </div>
                      </form>
                       <?php  } ?>
                    </div>


                    <br><br>
                  </div>
                  <!-- /.col-lg-6 (nested) -->
                <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Requirement and Qualification For This position</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      
                      <li>
                      <button type="button" id="modal" data-toggle="modal" data-target="#positionModal" class="btn btn-primary">Add New Skills Requirement </button>
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table class="table table-bordered" >
                      <thead>
                        <tr>`
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Cost(Amount)</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($skills as $row) { ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->amount; ?></td>
                            <td>
                           <button type="button" id="modal" data-toggle="modal" data-target="#updateskillsModal<?php echo $row->id; ?>" class="btn btn-info btn-xs">Update </button>


                                  
                        <!-- Update SKILLS Modal -->
                            <div class="modal fade" id="updateskillsModal<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h4 class="modal-title" id="myModalLabel">Update This Requirement</h4>
                                      </div>
                                      <div class = "modal-body">
                                        <form autocomplete="off"  enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/updateskills/"  data-parsley-validate class="form-horizontal form-label-left">
                                            <input type ="text" hidden name = "skillsID" value = "<?php echo $row->id; ?>">
                                            <input type ="text" hidden name = "positionref" value = "<?php echo $row->position_ref; ?>">
                                            
                                              <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Requirement Title 
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea required="" class="form-control col-md-7 col-xs-12" name="name"  rows="2"><?php echo $row->name; ?></textarea> 
                                                </div>
                                              </div> 
                                              <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description 
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea required="" class="form-control col-md-7 col-xs-12" name="description" placeholder="Description" rows="2"><?php echo $row->description; ?></textarea> 
                                                </div>
                                              </div> 
                                                <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cost Implication(Amount) 
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input required="" type="number" minimum="0" maximum="100000009" step="1" name="amount" value = "<?php echo $row->amount; ?>" class="form-control col-md-7 col-xs-12">
                                                  <span class="text-danger"><?php // echo form_error("fname");?></span>
                                                </div>
                                              </div> 
                                                <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Type Requirement (Qualification)
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <select required="" id="pos" class= "form-control" name="type">
                                                        <option></option>
                                                        <option value = "IND">Industrial Certification</option>
                                                        <option value = "LANG">Language</option>
                                                        <option value = "SKL">Knowledge and Skills</option>
                                                        <option value = "EXP">Experience</option>
                                                    </select>
                                                </div>
                                              </div> 
                                                <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                   <label class="containercheckbox">Non Mandatory<br>(Tick if Non Mandatory) 
                                                   <input type="checkbox"  <?php if($row->mandatory==1){ ?> checked <?php } ?>  name="mandatory" value = "1">
                                                    <span class="checkmark"></span>
                                                  </label>
                                                </div>
                                              </div>
                                        
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              
                                              <input type="submit"  value="UPDATE" name="update" class="btn btn-info"/>
                                          </div>
                                          </form>
                                      </div>
                                  
                                 </div>
                          <!-- /.modal-dialog -->
                             </div>
                        <!-- Modal Form -->          
                            </div>           
                        <!-- /.modal -->
                 <!-- Update Skills Modal -->
                            
                            
                           </td>
                           </tr>
                          <?php }  ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
                   <!-- /.col-lg-6 (nested) -->
                <!-- /.col-lg-6 (nested) -->
                <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Accountabilities For This position</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li>
                      <button type="button" id="modal" data-toggle="modal" data-target="#accountabilityModal" class="btn btn-primary">Add New Accountability In This Position </button>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Weighting</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($accountability as $row) { ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->weighting; ?></td></td>
                           </tr>
                          <?php }  ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
            <!-- /.col-lg-6 (nested) -->

                  
                
                    <!-- </table> -->
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>


          <!-- Modal -->
                <div class="modal fade" id="positionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Add New Requirement For this Position</h4>
                          </div>
                          <div class="modal-body">
                          <!-- Modal Form -->
                          <form autocomplete="off"  id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/addskills"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Requirement Title 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea  required="" class="form-control col-md-7 col-xs-12" name="name" placeholder="Skills Title" rows="1"></textarea> 
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                      <input type = "text" hidden name = "positionID" value="<?php echo $positionId; ?>" >
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea required="" class="form-control col-md-7 col-xs-12" name="description" placeholder="Description" rows="2"></textarea> 
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cost Implication(Amount) 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="" type="integer" minimum="0" maximum="100000009" step="1" name="amount" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Type Requirement (Qualification)
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select required="" id="pos" class= "form-control" name="type">
                                <option></option>
                                <option value = "IND">Industrial Certification</option>
                                <option value = "LANG">Language</option>
                                <option value = "SKL">Knowledge and Skills</option>
                                <option value = "EXP">Experience</option>
                            </select>
                        </div>
                      </div> 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <label class="containercheckbox">Non Mandatory<br>(Tick if Non Mandatory) 
                           <input type="checkbox" name="mandatory" value = "1">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                      </div> 
                      
                      
                          <!-- <label class="containercheckbox">-->
                          <!-- <input type="checkbox" name="option[]" value="<?php //echo $row->EGID; ?>">-->
                          <!--  <span class="checkmark"></span>-->
                          <!--</label>-->
                      
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <!--<button  class="btn btn-primary">REGISTER</button>-->
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
          
          
          

        <!-- ACCOUNTABILITY Modal -->
                <div class="modal fade" id="accountabilityModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Add New Accountability</h4>
                          </div>
                          <div class="modal-body">
                          <!-- Modal Form -->
                          <form autocomplete="off" id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/addAccountability"  data-parsley-validate class="form-horizontal form-label-left">
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Accountability Title 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="" type="text" name="title" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div>
                      
                      <input type = "text" hidden name = "positionID" value="<?php echo $positionId; ?>" >
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Weighting (in % ) 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="" type="number" min="0" maximum = "99"  name="weighting" class="form-control col-md-7 col-xs-12">
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
          
          
          
        <!-- /page content -->




<script type="text/javascript">
  $(".select_level").select2({
          placeholder: "Select Organization Level",
          allowClear: true
        });
    $('#updatePositionName').submit(function(e){
        e.preventDefault();
        var name = $('#name').val();
        var positionID = $('#positionID').val();
        if (positionID == '') {
          alert("Position ID Should not be Null");
        }else{
          $.ajax({
               url:"<?php echo  url(''); ?>/flex/updatePositionName",
               type:"post",
               data:new FormData(this),
               processData:false,
               contentType:false,
               cache:false,
               async:false
           })
            .done(function(data){
              $('#updateFeedBack').fadeOut('fast', function(){
                  $('#updateFeedBack').fadeIn('fast').html(data.message);
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

<script type="text/javascript">
    $('#updateParent').submit(function(e){
        e.preventDefault();
        var name = $('#name').val();
        var positionID = $('#positionID').val();
        if (positionID == '') {
          alert("Position ID Should not be Null");
        }else{
          $.ajax({
               url:"<?php echo  url(''); ?>/flex/updatePositionReportsTo",
               type:"post",
               data:new FormData(this),
               processData:false,
               contentType:false,
               cache:false,
               async:false
           })
            .done(function(data){
              $('#updateFeedBack').fadeOut('fast', function(){
                  $('#updateFeedBack').fadeIn('fast').html(data.message);
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
<script type="text/javascript">
    $('#updatePositionCode').submit(function(e){
        e.preventDefault();
        var name = $('#code').val();
        var positionID = $('#positionID').val();
        if (positionID == '') {
          alert("Position ID Should not be Null");
        }else{
          $.ajax({
               url:"<?php echo  url(''); ?>/flex/updatePositionCode",
               type:"post",
               data:new FormData(this),
               processData:false,
               contentType:false,
               cache:false,
               async:false
           })
            .done(function(data){
              $('#updateFeedBack').fadeOut('fast', function(){
                  $('#updateFeedBack').fadeIn('fast').html(data.message);
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
<script type="text/javascript">
    $('#updateOrganizationLevel').submit(function(e){
        e.preventDefault();
          var positionID = $('#positionID').val();
          if (positionID == '') {
            alert("Position ID Should not be Null");
          }else{
            $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updatePositionOrganizationLevel",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
              .done(function(data){
                $('#updateFeedBack').fadeOut('fast', function(){
                    $('#updateFeedBack').fadeIn('fast').html(data.message);
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
 @endsection