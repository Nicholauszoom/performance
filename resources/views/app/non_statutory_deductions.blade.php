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
                <h3><?php echo($title) ?></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Deductions</h2>

                     <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   <?php echo $this->session->flashdata("notepack");  ?>
                    <table  class="table ">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Amount</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($deduction as $row) { 
                            //if($row->id==0) continue; // Skip the default group
                            ?> 
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td> <?php if($row->mode==1){ ?>
                                <span class="label label-success">Fixed Amount</span><br>
                                <?php echo $row->amount; } else { ?>
                                <span class="label label-success">Salary dependent</span><br>
                                <?php echo 100*($row->percent)."%"; } ?>
                                
                            </td>
                            <td class="options-width">
                                <a  href="<?php echo url(); ?>flex/deduction_info/?pattern=<?php echo $row->id; ?>|2" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                <a href="javascript:void(0)" onclick="deletededuction(<?php echo $row->id; ?>)" title="Delete Deduction" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                            </td>
                            </tr>
                          <?php } //} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                </div>

              <div class="col-md-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Deduction</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="resultSubmissionDeduction"></div>
                    <form id="addDeduction" method="post" autocomplete="off" class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label  for="first-name">Deduction Name 
                        </label>
                        <div >
                          <textarea required="" type="text" name="name" class="form-control col-md-7 col-xs-12"></textarea> 
                          <span class="text-danger"><?php //echo form_error("fname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label  for="first-name" for="stream" >Deduction Policy</label>
                        <div >
                        <select name="policy" class="select_type form-control" required tabindex="-1" id="deduction_policy">
                            <option></option>
                            <option value=1>Fixed Amount</option>
                           <option value=2>Percent From Basic Salary</option>
                           <option value=3>Percent From Gross</option>
                        </select>
                        </div>
                      </div>

                       <div id ="percent" class="form-group">
                        <label  for="first-name">Percent
                        </label>
                        <div >
                          <input required="" id ="deduction_percentf" type="number" name="rate" min="0" max="99" step="0.1" placeholder="Percent (Less Than 100)" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
                       <div id ="amount" class="form-group">
                        <label  for="first-name">Amount
                        </label>
                        <div >
                          <input required="" id ="deduction_amountf" type="number" step="1" placeholder="Fixed Amount" name="amount" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php //echo form_error("fname");?></span>
                        </div>
                      </div> 
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="reset" class="btn btn-warning">Cancel</button>
                          <button  class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>              

          </div>
        </div>
        


        <!-- /page content -->   

@include( "app/includes/update_allowances")
<script>

jQuery(document).ready(function($){
  
    $('#policy').change(function () {
        
    $("#policy option:selected").each(function () {
        var value = $(this).val();
        if(value == "1") {
            // $('#amount').show();
            // $('#percent').hide();
            $("#percentf").attr("disabled", "disabled");
            $("#amountf").removeAttr("disabled");
           
        } else if(value == "2") {
            // $('#percent').show();
            // $('#amount').hide();
            $("#amountf").attr("disabled", "disabled");
            $("#percentf").removeAttr("disabled");
           
        }

    });
  }); 


});
</script>
<script>

jQuery(document).ready(function($){
  
    $('#deduction_policy').change(function () {
        
    $("#deduction_policy option:selected").each(function () {
        var value = $(this).val();
        if(value == "1") {
            $("#deduction_percentf").attr("disabled", "disabled");
            $("#deduction_amountf").removeAttr("disabled");
           
        } else if(value == "2") {
            $("#deduction_amountf").attr("disabled", "disabled");
            $("#deduction_percentf").removeAttr("disabled");
           
        }else if(value == "3") {
            $("#deduction_amountf").attr("disabled", "disabled");
            $("#deduction_percentf").removeAttr("disabled");
           
        }

    });
  }); 


});
</script>
<script>
    $('#addAllowance').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/addAllowance",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultSubmission').fadeOut('fast', function(){
              $('#resultSubmission').fadeIn('fast').html(data);
            });
    
      $('#addAllowance')[0].reset();
        })
        .fail(function(){
     alert('FAILED, Check Your Network Connection and Try Again! ...'); 
        });
    }); 
</script>

<script>
    $('#addOvertime').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/addOvertimeCategory",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
          $('#resultOvertimeSubmission').fadeOut('fast', function(){
              $('#resultOvertimeSubmission').fadeIn('fast').html(data);
            });
    
          $('#addOvertime')[0].reset();
        })
        .fail(function(){
     alert('FAILED, Check Your Network Connection and Try Again! ...'); 
        });
    }); 
</script>
<script>
    $('#addDeduction').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/addDeduction",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultSubmissionDeduction').fadeOut('fast', function(){
              $('#resultSubmissionDeduction').fadeIn('fast').html(data);
            });
    
      $('#addDeduction')[0].reset();
        })
        .fail(function(){
     alert('FAILED, Check Your Network Connection and Try Again! ...'); 
        });
    }); 
</script>


 @endsection