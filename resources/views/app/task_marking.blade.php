
        

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
                <h3>Task Settings</h3>
              </div>

            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Quantity and Behaviour</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                        <div id ="feedbackBasics"></div>
                  
                    <!-- <table id="datatable" class="table table-striped table-bordered"> -->
                     <?php
            if (isset($quantity)){
                      foreach ($quantity as $row) {
                        $behaviour=$row->behaviour;
                        $id=$row->id;
                        $quantity=$row->quantity;
                      }}

                          ?>

                    <form id="updateBasics" autocomplete="off"  method="post" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Quantity <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required="" type="number" min="1" max="100"  value="<?php echo $quantity; ?>" name="quantity" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("rate_employer");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Behaviour <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="number" min="1" max="100" required="required" value="<?php echo $behaviour; ?>" name="behaviour"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("rate_employee");?></span>
                        </div>
                      </div>
                      <!-- <div class="ln_solid"></div> -->
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-info">UPDATE</button>
                        </div>
                      </div>

                    </form>
                  </div>

                </div>
                <!-- TASK ELAPSED TIME -->
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Percentage of Time Elapsed<br><small> For Task To Be Marked As Delayed</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form autocomplete="off" id="updateTimeElapse" class="form-horizontal form-label-left"> 
                        <div class="col-sm-9">
                        <div id ="feedbackTime"></div>
                          <div class="form-group">
                            <label for="stream" >Percent</label>
                             <div class="input-group">
                                <input required="" type="number" name ="percent" min="1" max="100" step="1" value="<?php echo $delay_percent; ?>" class="form-control">
                                <span class="input-group-btn">
                                  <button  class="btn btn-primary">UPDATE</button>
                                </span>
                              </div>
                          </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Behaviour Parameters &nbsp;&nbsp;
                    <!-- <button type="button" id="modal" data-toggle="modal" data-target="#parameterModal" class="btn btn-success">ADD NEW</button> -->
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                  
                      <div id ="feedbackAddNew"></div>
                    <table id="clearList"  class="table table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Title</th>
                          <th>Description</th>
                          <th>Percentage(out of 100%)</th>
                        </tr>
                      </thead>
                      <tbody>

                          <tr> <form autocomplete="off" id="newParameter" method="post" >
                            <td width="1px">#</td>
                            <td> 
                            <div class="form-group">
                              <input  name="title" required="" placeholder="Title"   class="form-control">
                            </div>
                            </td> 
                            <td> 
                            <div class="form-group">
                              <input name="description" required="" placeholder="Description" class="form-control">
                            </div>
                            </td>                          
                            <td> 
                            <div class="form-group">
                              <button class="btn btn-primary">ADD NEW</button>
                            </div>
                            </td></form>
                            </tr>
                        <?php
                          foreach($behaviour_info as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->title; ?></td>
                            <td><?php echo $row->description; ?></td>
                            <td><?php echo $row->marks; ?>%<br>
                            <a href="javascript:void(0)" onclick="deleteParameter(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs">DELETE</button> </a>

                            </td>                            
                            <!-- <td class="options-width"> </td> -->
                            </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Update Behaviour Parameters<small><b>Total Marks <?php echo $totalMarks; ?></b/></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">                  
                    <div id ="feedbackUpdates"></div>
                  <form id="updateParameter"  method="post" data-parsley-validate class="form-horizontal form-label-left">
                    <table id="updateList" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Title</th>
                          <th>Percent(100%)</th>
                          <th>Update</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          foreach($behaviour_info as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td> 
                            <div class="form-group">
                              <input  name="title<?php echo $row->id;?>"  placeholder="Title"  value="<?php echo $row->title; ?>" class="form-control">
                            </div>
                            </td> 
                            <td> 
                            <div class="form-group">
                              <input name="description<?php echo $row->id;?>"  placeholder="Description"  value="<?php echo $row->description; ?>" class="form-control">
                            </div>
                            </td>                          
                            <td> 
                            <div class="form-group">
                              <input type="number" step="0.1" name="marks<?php echo $row->id;?>" min="1" max="100" placeholder="Percentage"  value="<?php echo $row->marks; ?>" class="form-control">
                            </div>

                            </td>
                            </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                     <div class="text-center mtop20">
                           <button type="reset" class="btn btn-warning">CANCEL</button>
                          <button   class="btn btn-info">UPDATE</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Ratings</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">  
                  <!-- <input type="text" id="input">  <input id="input2" type="text">  <input id="input3" type="text">                -->
                    <div id ="feedbackRatings"></div>
                  <form id="updateRatings"  method="post" data-parsley-validate class="form-horizontal form-label-left">
                    <table id="updateRatingList" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Lower Bound</th>
                          <th>Upper Bound</th>
                          <th>Behavioural Contributions(%)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          foreach($ratings as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td> 
                            <div class="form-group">
                              <input  name="title<?php echo $row->id;?>" required  placeholder="Title"  value="<?php echo $row->title; ?>" class="form-control">
                            </div>
                            </td> 
                            <td> 
                            <div class="form-group">
                              <input type="number" readonly="readonly" id="lower<?php echo $row->id;?>" name="lower<?php echo $row->id;?>"  placeholder="Lower Bound"  value="<?php echo $row->lower_limit; ?>" class="form-control">
                            </div>
                            </td>                          
                            <td> 
                            <div class="form-group">
                             <?php if($row->upper_limit>=100) { ?>
                              <input readonly="readonly" id="upper<?php echo $row->id;?>"  name="upper<?php echo $row->id;?>" min="0" max="100" placeholder="Upper Bound"  value="<?php echo number_format($row->upper_limit,0); ?>" class="form-control">
                             <?php } else { ?>
                              <input type="number" id="upper<?php echo $row->id;?>"  name="upper<?php echo $row->id;?>" min="0" max="100" placeholder="Upper Bound"  value="<?php echo number_format($row->upper_limit,0); ?>" class="form-control">
                              <?php } ?>
                            </div>

                            </td>
                            <td>
                            <div class="form-group">
                            <?php if($row->contribution>=1) { ?>
                              <input readonly="readonly" type="number" step="1" name="contr<?php echo $row->id;?>" min="0" max="100" placeholder="Contributions"  value="<?php echo $row->contribution*100; ?>" class="form-control">
                              <?php } else { ?>                              
                              <input type="number" step="1" name="contr<?php echo $row->id;?>" min="0" max="100" placeholder="Contributions"  value="<?php echo $row->contribution*100; ?>" class="form-control">
                              <?php }  ?>
                            </div>

                            </td>
                            </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                     <div class="text-center mtop20">
                           <button type="reset" class="btn btn-warning">CANCEL</button>
                          <button name="update" type="submit"  class="btn btn-info">UPDATE</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->


        <!-- Modal -->
        <div class="modal fade" id="parameterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Add New Behaviour Parameter</h4>
                  </div>
                  <div class="modal-body">
                  <!-- Modal Form -->
                  <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/performance/add_behaviour"  data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" name="title" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control col-md-7 col-xs-12"  name="description"  rows="3"></textarea>
                      <span class="text-danger"><?php // echo form_error("fname");?></span>
                    </div>
                  </div>                 
                  <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                      <input type="submit"  value="ADD" name="add" class="btn btn-primary"/>
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





<script type="text/javascript">
  $('#updateBasics').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateTaskMarkingBasics/",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#feedbackBasics').fadeOut('fast', function(){
          $('#feedbackBasics').fadeIn('fast').html(data);
        });

  // $('#taskResources')[0].reset();
    })
    .fail(function(){
 alert('Updation Failed!'); 
    });

});
</script>

<script type="text/javascript">
  $('#updateTimeElapse').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateTaskTimeElapse",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#feedbackTime').fadeOut('fast', function(){
          $('#feedbackTime').fadeIn('fast').html(data);
        });

    })
    .fail(function(){
 alert('Updation Failed!'); 
    });

});
</script>

<script type="text/javascript">
  $('#newParameter').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/add_behaviour",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#feedbackAddNew').fadeOut('fast', function(){
          $('#feedbackAddNew').fadeIn('fast').html(data);
        });
     $("#clearList").load(" #clearList");
     $("#updateList").load(" #updateList");

    })
    .fail(function(){
 alert('Updation Failed!'); 
    });

});
</script>
<script type="text/javascript">

    function deleteParameter(id)
    {
        if (confirm("Do You Want To Select This Strategy as Default") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/performance/deleteBehaviourParameter');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
              alert("Strategy Selected Sussessifully!");
              $('#feedbackAddNew').fadeOut('fast', function(){
                  $('#feedbackAddNew').fadeIn('fast').html(data);
                });
             $("#clearList").load(" #clearList");
             $("#updateList").load(" #updateList");
              }else {
              alert("Strategy Not Seleted, Some Error Occured");
              }
           
               
            }
               
            });
        }
    }
</script>


<script type="text/javascript">
  $('#updateParameter').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/update_task_behaviour/",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#feedbackUpdates').fadeOut('fast', function(){
          $('#feedbackUpdates').fadeIn('fast').html(data);
        });
     $("#clearList").load(" #clearList");
     $("#updateList").load(" #updateList");

    })
    .fail(function(){
 alert('Updation Failed!'); 
    });

});
</script>

<script type="text/javascript">
  
/*$("#input").on("input", function(e) {
  var input = $(this);
  var val = input.val();

  if (input.data("lastval") != val) {
    input.data("lastval", val);

    //your change action goes here 
    alert(val);
    // console.log(val);
  }

});*/

//CATEGORY 1
$(document).ready(function(){
  $("#upper2").change(function(){
    var input = $(this);
  var val = input.val();
  $("#lower1").val(val);
    // alert(val);
  });  
});

//CATEGORY 2
$(document).ready(function(){
  $("#upper3").change(function(){
    var input = $(this);
  var val = input.val();
  $("#lower2").val(val);
    // alert(val);
  });  
});

//CATEGORY 3
$(document).ready(function(){
  $("#upper4").change(function(){
    var input = $(this);
  var val = input.val();
  $("#lower3").val(val);
    // alert(val);
  });  
});

//CATEGORY 4
$(document).ready(function(){
  $("#upper5").change(function(){
    var input = $(this);
  var val = input.val();
  $("#lower4").val(val);
    // alert(val);
  });  
});


</script>


<script type="text/javascript">
  $('#updateRatings').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/update_task_ratings/",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#feedbackRatings').fadeOut('fast', function(){
          $('#feedbackRatings').fadeIn('fast').html(data);
        });
     location.reload();

    })
    .fail(function(){
 alert('Updation Failed!'); 
    });

});
</script>


 @endsection