@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section

<?php   
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3> Organization Level Info</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            
            
            <?php 

            foreach($category as $row){
                $levelID = $row->id;
                $name = $row->name;
                $minSalary = $row->minSalary;
                $maxSalary = $row->maxSalary;
                //$state = $row->state;
            }
            
            ?>            
            <!--START Overtimes-->
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
                    <h5>Minimum Annual Salary:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $minSalary; ?> Tsh</b>
                    <h5>Maximum Annual Salary:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $maxSalary; ?> Tsh</b>
                    </h5>
                    <br>
                  </div>
                </div>
              </div>
              <!-- Groups -->
              
              <!--UPDATE-->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Update</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div id ="feedBackSubmission"></div>
                      <form autocomplete="off" id="updateLevelName" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                            <input hidden name ="levelID" value="<?php echo $levelID; ?>">
                            <input required="" type="text" name ="name" value="<?php echo $name; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Name</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <form autocomplete="off"  id="updateMinSalary" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="levelID" value="<?php echo $levelID; ?>">
                            <input required="" type="number" step="0.01" name="minSalary" step ="1" min="1" max="1000000000" value="<?php echo $minSalary; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">UPDATE MIN SALARY</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <form autocomplete="off"  id="updateMaxSalary" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="levelID" value="<?php echo $levelID; ?>">
                            <input required="" type="number" step="1" name="maxSalary" step ="1" min="1" max="1000000000" value="<?php echo $maxSalary; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">UPDATE MAX SALARY</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                  </div>
                </div>
              </div>
              <!--UPDATE-->
            </div> <!--end row Overtimes -->

            <!--END DEDUCTION-->            
            <?php  //} ?>
            
            
          </div>
        </div>


        <!-- /page content -->   

<?php 
//include_once "app/includes/update_deductions")

<script type="text/javascript">
    $('#updateLevelName').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/updateOrganizationLevelName",
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
    
    
        setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000); 
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    }); 
</script>
<script type="text/javascript">
    $('#updateMinSalary').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/updateMinSalary",
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
    
    
        setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000); 
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    }); 
</script>
<script type="text/javascript">
    $('#updateMaxSalary').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/updateMaxSalary",
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
    
    
        setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000); 
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    }); 
</script>
 @endsection