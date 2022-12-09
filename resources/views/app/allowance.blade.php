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
                    <h2>Allowances </h2>

                    <div class="clearfix"></div>
                  </div>
                  <div id="allowanceList" class="x_content">
                   <div id="deleteFeedback"></div>
                   <div id="resultSubmission"></div>
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <table  class="table table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Amount</th>
                          <th>Taxable</th>
                          <th>Pentionable</th>
                          <!-- <th>Apply To</th> -->
                          <?php if($pendingPayroll==0){ ?>
                          <th>Option</th>
                          <?php } ?>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($allowance as $row) { ?>
                          <tr <?php if($row->state ==0){ ?> bgcolor="#FADBD8" <?php  } ?> id="record<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->name; ?></td>
                            
                            <td> <?php if($row->mode==1){ ?>
                                <span class="label label-success">Fixed Amount</span><br>
                                <?php echo $row->amount; } else { ?>
                                <span class="label label-success">Salary dependent</span><br>
                                <?php echo 100*($row->percent)."%"; } ?>
                                
                            </td>
                            <td><?php echo $row->taxable; ?></td>
                            <td><?php echo $row->pentionable; ?></td>


                            <?php if($pendingPayroll==0){ ?> 
                            <td class="options-width">
                                <a href="<?php echo  url(''); ?>/flex/allowance_info/?id=".base64_encode($row->id); ?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                <?php if($row->state ==1){ ?>
                                <a href="javascript:void(0)" onclick="deleteAllowance(<?php echo $row->id; ?>)" title="Delete Allowance" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                <?php } else{ ?>

                                <a href="javascript:void(0)" onclick="activateAllowance(<?php echo $row->id; ?>)" title="Activate Allowance" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a><?php } ?>
                            </td><?php } ?> 
                            </tr>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


              <div class="col-md-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Allowance</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="resultSubmission"></div>
                    <form id="addAllowance" method="post" autocomplete="off" class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label  for="first-name">Allowance Name 
                        </label>
                        <div >
                          <textarea required="" type="text" name="name" class="form-control col-md-7 col-xs-12"></textarea> 
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label  for="first-name" for="stream" >Payment Policy</label>
                        <div >
                        <select name="policy" class="select_type form-control" required tabindex="-1" id="policy">
                            <option></option>
                            <option value=1>Fixed Amount</option>
                           <option value=2>Percent From Basic Salary</option>
                        </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label  for="first-name" for="stream" >Is Taxable?</label>
                        <div >
                        <select name="taxable" class="select_type form-control" required tabindex="-1" id="policy">
                            <option></option>
                            <option value="YES">YES</option>
                           <option value="NO">NO</option>
                        </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label  for="first-name" for="stream" >Is Pentionable?</label>
                        <div >
                        <select name="pentionable" class="select_type form-control" required tabindex="-1" id="policy">
                            <option></option>
                            <option value="YES">YES</option>
                           <option value="NO">NO</option>
                        </select>
                        </div>
                      </div>

                       <div id ="percent" class="form-group">
                        <label  for="first-name">Percent
                        </label>
                        <div >
                          <input required="" id ="percentf" type="number" name="rate" min="0" max="99" step="0.1" placeholder="Percent (Less Than 100)" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
                       <div id ="amount" class="form-group">
                        <label  for="first-name">Amount
                        </label>
                        <div >
                          <input required="" id ="amountf" type="number" step="1" placeholder="Fixed Amount" name="amount" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
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
        


  
@include("app/includes/update_allowances")
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
                 url:"<?php echo  url(''); ?>/flex/addAllowance",
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
                 url:"<?php echo  url(''); ?>/flex/addOvertimeCategory",
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
                 url:"<?php echo  url(''); ?>/flex/addDeduction",
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