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
                <h3>Activities </h3>
              </div>
            </div>

            <div class="clearfix"></div>
            <?php if($action == 0 && session('mng_proj')){ ?>
            <div class="row">              
               <div class="col-md-12 col-sm-12 col-xs-12">                            
                    <div class="x_panel">
                      <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Create New Activity</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div id="feedBack"></div>
                        <form autocomplete="off" id="addActivity" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
            
                          <!-- START -->
                          <div class="form-group" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Activity Name</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input required="" class="form-control col-md-7 col-xs-12" name="name" placeholder="Activity Name"  /> 
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Activity Code</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input required="" type="text" class="form-control col-md-7 col-xs-12" name="code" placeholder="Activity Code" /> 
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <textarea required="" class="form-control col-md-7 col-xs-12" name="description" placeholder="Activity Description" rows="3"></textarea> 
                            </div>
                          </div> 

                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Project Name</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            <select required="" name="project" class="select2_project form-control" tabindex="-1">
                            <option></option>
                               <?php
                              foreach ($projects as $row) {
                                 # code... ?>
                              <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?></option> <?php } ?>
                            </select>
                            </div>
                          </div>                         
                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Grant</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            <select required="" name="grant" class="select_grant form-control" tabindex="-1">
                            <option></option>
                               <?php  foreach ($grants as $row) {  ?>
                              <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?></option> <?php } ?>
                            </select>
                            </div>
                          </div> 
                          <!-- END -->
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                               <button class="btn btn-primary" >CREATE</button>
                            </div>
                          </div> 
                          </form> 
                      </div>
                    </div>
                </div>
            </div>

            <?php } if($action==1 && !empty($activity_info)){

              foreach ($activity_info as $row) {
                $code = $row->code;
                $activityID = $row->id;
                $name = $row->name;
                $projectCode = $row->projectCode;
                $description = $row->description;
              }

            ?>

            <!-- UPDATE INFO AND SECTION -->
            <div class="row">
              <!-- Groups -->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Details</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div id ="feedBackAssignment"></div>
                      <h5> Name:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $name; ?></b></h5>
                      <h5> Code:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $code; ?></b></h5>
                    <h5>Description:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $description; ?></b>
                    <h5>Project Reference:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $projectCode; ?></b>
                    <br><br>
                    <h5>Grants Allocated</b>
                    <table class="table table-bordered">
                      <thead>
                        <th><b>S/N</b></th>
                        <th><b>Grant</b></th>
                        <?php if(session('mng_proj')){  ?>
                        <th><b>OPTION</b></th>
                      <?php } ?>
                      </thead>
                      <tbody>
                        <?php $sno = 1;
                         foreach ($activity_grants as $row) { ?>
                          <tr>
                            <td ><?php echo $sno; ?></td>
                            <td ><?php echo $row->grant_code; ?></td>
                            <?php if(session('mng_proj')){  ?>
                            <td>
                              <a href="javascript:void(0)" onclick="deleteAssignment(<?php echo $row->id; ?>)" title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a>
                            </td>
                          <?php } ?>
                          </tr>
                        <?php $sno++; } ?>
                      </tbody>
                    </table>

                    </h5>
                    <br>
                  </div>
                </div>
              </div>
              <!-- Groups -->
              
              <!--UPDATE-->
              <?php if(session('mng_proj')){  ?>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Update</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id ="feedBackSubmission"></div>
                    <form autocomplete="off" id="updateName" class="form-horizontal form-label-left">
                    <div class="form-group">
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input hidden name ="activityID" value="<?php echo $activityID; ?>">
                          <textarea required="" class="form-control col-md-7 col-xs-12" name ="name" placeholder="Project Name" rows="3"><?php echo $name; ?></textarea> 
                           <span class="input-group-btn">
                            <button  class="btn btn-primary">Update Name</button>
                          </span>
                        </div>
                      </div>
                    </div>
                    </form>
                    <?php if($activityID !=1 ){ ?>
                    <form autocomplete="off" id="updateCode" class="form-horizontal form-label-left">
                    <div class="form-group">
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input hidden name ="activityID" value="<?php echo $activityID; ?>">
                            <input required="" type="text" name ="code" value="<?php echo $code; ?>" class="form-control">                           
                            <span class="input-group-btn">
                            <button  class="btn btn-primary">Update Code</button>
                          </span>
                        </div>
                      </div>
                    </div>
                    </form>
                    <?php } ?>
                    <form autocomplete="off" id="updateDescription" class="form-horizontal form-label-left">
                    <div class="form-group">
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input hidden name ="activityID" value="<?php echo $activityID; ?>">
                          <textarea required="" class="form-control col-md-7 col-xs-12" name ="description" placeholder="Project Description" rows="3"><?php echo $description; ?></textarea> 
                           <span class="input-group-btn">
                            <button  class="btn btn-primary">Update Description</button>
                          </span>
                        </div>
                      </div>
                    </div>
                    </form>
                    <form autocomplete="off" id="updateGrant" method="post" class="form-horizontal form-label-left">
                      <label>Allocate Another Grant To this Activity</label>
                    <div class="form-group">
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input hidden name ="activityCode" value="<?php echo $code; ?>">
                          <select required="" name="grantCode" class="select_grant form-control" tabindex="-1">
                               <?php  foreach ($grants as $row) {  ?>
                              <option value="<?php echo $row->code; ?>"><?php echo $row->code; ?></option> <?php } ?>
                            </select>
                           <span class="input-group-btn">
                            <button  class="btn btn-info">Allocate Grant</button>
                          </span>
                        </div>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            <?php } ?>
            </div> 
            <!-- END UPDATE SECTION  -->
          <?php } ?>

          </div>
        </div>

        


        <!-- /page content -->
 

<?php  ?>

<script type="text/javascript">

     $(".select_grant").select2({
      placeholder: "Select Grant",
      allowClear: true
    });

    $(".select2_project").select2({
      placeholder: "Select Project",
      allowClear: true
    }); 
    $('#addActivity').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>index.php/project/addActivity",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBack').fadeOut('fast', function(){
              $('#feedBack').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
          location.reload(); // then reload the page.(3)
      }, 4000); 
      $('#addActivity')[0].reset();
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 


    $('#updateName').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>index.php/project/updateActivityName",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
          location.reload(); // then reload the page.(3)
      }, 4000); 
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 


    $('#updateCode').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>index.php/project/updateActivityCode",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });
        setTimeout(function(){// wait for 2 secs(2)
              location.reload(); // then reload the page.(3)
          }, 4000); 
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 

    $('#updateDescription').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>index.php/project/updateActivityDescription",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
          location.reload(); // then reload the page.(3)
      }, 4000); 
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    });
    $('#updateGrant').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>index.php/project/allocateGrantToActivity",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
          location.reload(); // then reload the page.(3)
      }, 4000); 
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    });  

     function deleteAssignment(id)
    {
        if (confirm("Are You Sure You Want To Delete This Allocation") == true) {
        var id = id;
        $('#row'+id).show();
        $.ajax({
            url:"<?php echo url('index.php/project/deleteActivityGrant');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
                $('#row'+id).hide();              
                $('#feedBackAssignment').fadeOut('fast', function(){
                    $('#feedBackAssignment').fadeIn('fast').html(data.message);
                });                
                setTimeout(function(){
                      location.reload();
                  }, 3000);

              }else{ 
                $('#feedBackAssignment').fadeOut('fast', function(){
                  $('#feedBackAssignment').fadeIn('fast').html(data.message);
                });

              }               
            }
               
            });
        }
    } 

</script>





 @endsection