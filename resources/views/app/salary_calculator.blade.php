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
                      <!-- PANEL-->
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Salary Calculator</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">  
                      <form id="salaryCalculator" enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Basic Salary</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input required="" id="maxSalary" type="number" min="10" max="1000000000" step="0.01" class="form-control col-md-7 col-xs-12" name="basic_salary" placeholder="Basic Salary"/> 
                            </div>
                          </div>                         

                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Allowances</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <select required="" id='allowances' name="allowances[]" class="select_multiple_allowances form-control" multiple="multiple">
                                 <?php foreach ($allowances as $row){ ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                              </select>
                              <input hidden type="radio" checked name="pensionFund" value="2">
                            </div>
                          </div>

                          <div class="form-group">
                              <label class="control-label col-md-3  col-xs-6" >Pension</label>
                              <div class="col-md-4 col-sm-6 col-xs-12">
                                  <select name="pension" class="select_type form-control" required tabindex="-1" id="pension">
                                      <option value="" selected disabled>Select Pension</option>
                                      <?php foreach ($pensions as $row){ ?>
                                          <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                  </select>
                              </div>
                          </div>

                          <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"/>COMPUTE</button>
                          </div>
                        </div> 
                      </form>
                      <form id="takehomeResult" data-parsley-validate class="form-horizontal form-label-left">
                        <div class="form-group">
                          <div id="amountTakeHome" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> </div>
                        </div> 
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <input onclick="cancel();"  value="OK" class="btn btn-primary"/>
                          </div>
                        </div> 
                      </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <!-- /page content -->


<script> 

  $('#takehomeResult').hide();
  $(".select_multiple_allowances").select2({
    maximumSelectionLength: 5,
    placeholder: "Select Allowances",
    allowClear: true
  }); 
</script>

<script>
    $('#salaryCalculator').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/payroll/calculateSalary",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
          $('#amountTakeHome').fadeOut('fast', function(){
              $('#amountTakeHome').fadeIn('fast').html(data);
            });
    
          $('#salaryCalculator').hide();
          $('#takehomeResult').show();
        })
        .fail(function(){
     alert('Failed To Calculate Salary, Check Your Network Connection and Try Again! ...'); 
        });
    }); 

    function cancel()
    {
      
      $('#salaryCalculator')[0].reset();
      $(".select_multiple_allowances").val("");
      $(".select_multiple_allowances").trigger("change");
      $('#takehomeResult').hide();
      $('#salaryCalculator').show();
    }
</script>


 @endsection