@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php

<?php 
  


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Grants </h3>
              </div>
            </div>

            <div class="clearfix"></div>
            <?php if($action == 0 && session('mng_proj')){ ?>
            <div class="row">              
               <div class="col-md-12 col-sm-12 col-xs-12">                            
                    <div class="x_panel">
                      <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Create New Grant</h2>
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
                        <form autocomplete="off" id="addGrant" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
            
                          <!-- START -->
                          <div class="form-group" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Grant Name</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input required="" class="form-control col-md-7 col-xs-12" name="name" placeholder="Grant Name"  /> 
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Grant Code</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input required="" type="text" class="form-control col-md-7 col-xs-12" name="code" placeholder="Grant Code" /> 
                            </div>
                          </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                       for="last-name">Funder</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <select required name="funder" class="select_funder form-control" tabindex="-1">
                                        <option></option>
                                        <?php foreach ($funders as $row) { ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Grant Amount</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input required="" type="number" class="form-control col-md-7 col-xs-12" name="amount" placeholder="Grant Amount" />
                                </div>
                            </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <textarea required="" class="form-control col-md-7 col-xs-12" name="description" placeholder="Grant Description" rows="3"></textarea> 
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

            <?php } if($action==1 && !empty($grant_info)){

              foreach ($grant_info as $row) {
                $code = $row->code;
                $grantID = $row->id;
                $name = $row->name;
                $description = $row->description;
                $amount = $row->amount;
                $funder = null;
                foreach ($funders as $item){
                    if ($row->funder == $item->id){
                        $funder = $item->name;
                    }
                }

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
                      <?php if ($funder) { ?>
                          <h5> Funder:
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $funder; ?></b></h5>
                      <?php } ?>
                      <?php if ($amount) { ?>
                          <h5> Amount:
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($amount,2); ?></b></h5>
                      <?php } ?>
                    <h5>Description:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $description; ?></b>
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
                          <input hidden name ="grantID" value="<?php echo $grantID; ?>">
                          <textarea required="" class="form-control col-md-7 col-xs-12" name ="name" placeholder="Project Name" rows="3"><?php echo $name; ?></textarea> 
                           <span class="input-group-btn">
                            <button  class="btn btn-primary">Update Name</button>
                          </span>
                        </div>
                      </div>
                    </div>
                    </form>
                    <?php if($grantID !=1 ){ ?>
                    <form autocomplete="off" id="updateCode" class="form-horizontal form-label-left">
                    <div class="form-group">
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input hidden name ="grantID" value="<?php echo $grantID; ?>">
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
                          <input hidden name ="grantID" value="<?php echo $grantID; ?>">
                          <textarea required="" class="form-control col-md-7 col-xs-12" name ="description" placeholder="Project Description" rows="3"><?php echo $description; ?></textarea> 
                           <span class="input-group-btn">
                            <button  class="btn btn-primary">Update Description</button>
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
 



<script type="text/javascript">

    $(".select_grant").select2({
      placeholder: "Select Grant",
      allowClear: true
    });
    $('#addGrant').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/project/addGrant",
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
      }, 1000); 
      $('#addGrant')[0].reset();
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 


    $('#updateName').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/project/updateGrantName",
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
      }, 1000); 
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 


    $('#updateCode').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/project/updateGrantCode",
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
          }, 1000); 
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 

    $('#updateDescription').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/project/updateGrantDescription",
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
      }, 1000); 
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 

</script>





 @endsection