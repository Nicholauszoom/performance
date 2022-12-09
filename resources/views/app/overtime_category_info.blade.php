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
                <h3> Category Info </h3>
              </div>
            </div>
            <div class="clearfix"></div>
            
            
            <?php 

            foreach($category as $row){
                $categoryID = $row->id;
                $name = $row->name;
                $day_percent = $row->day_percent;
                $night_percent = $row->night_percent;
                $state = $row->state;
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
                    <h5>Day Hours Rate:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo (100*$day_percent); ?> Tsh</b>
                    <h5>Night Hours Rate:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo (100*$night_percent); ?> Tsh</b>
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
                      <form autocomplete="off" id="updateOvertimeName" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                            <input hidden name ="categoryID" value="<?php echo $categoryID; ?>">
                            <input required="" type="text" name ="name" value="<?php echo $name; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Name</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <form autocomplete="off"  id="updateRateDay" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="categoryID" value="<?php echo $categoryID; ?>">
                            <input required="" type="number" step="0.01" name="day_percent" step ="1" min="0.01" max="300" value="<?php echo (100*$day_percent); ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">UPDATE DAY RATE</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <form autocomplete="off"  id="updateRateNight" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="categoryID" value="<?php echo $categoryID; ?>">
                            <input required="" type="number" step="0.01" name="night_percent" step ="1" min="0.01" max="300" value="<?php echo (100*$night_percent); ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">UPDATE NIGHT RATE</button>
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
    $('#updateOvertimeName').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/updateOvertimeName",
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
    $('#updateRateDay').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/updateOvertimeRateDay",
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
    $('#updateRateNight').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/updateOvertimeRateNight",
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