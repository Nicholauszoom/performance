@extends('layouts.vertical', ['title' => 'Overtime'])

@push('head-script')
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>

@endpush

@push('head-scriptTwo')

<script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>

@endpush

@section('content')
<div class="right_col" role="main">
    <div class="card">
        <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/financial_group')}}" class="nav-link "
                    aria-selected="false" role="tab" tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Packages
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/allowance_overtime')}}" class="nav-link active show" aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Overtime
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/allowance')}}" class="nav-link" 
                    aria-selected="false" role="tab" tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Allowance
                </a>
            </li>
        
          
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/statutory_deductions')}}" class="nav-link "
                    aria-selected="false" role="tab" tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Statutory Deductions
                </a>
            </li>
            <li class="nav-item" role="presentation">
              <a href="{{ url('/flex/non_statutory_deductions')}}" class="nav-link "
                  aria-selected="false" role="tab" tabindex="-1">
                  <i class="ph-list me-2"></i>
                  Non Statutory Deductions
              </a>
          </li>
         
        </ul>

      <div class="clearfix"></div>

      <div class="row">
          <!-- Overtimes -->
          <div class="col-md-8 col-xs-12">
          <div class="card">
            <div class="card-head px-3">
              <h2>Overtime </h2>

              <div class="clearfix"></div>
            </div>
            <div id="allowanceList" class="card-body">
             <div id="deleteFeedback"></div>
             <div id="resultSubmission"></div>
             <?php //echo $this->session->flashdata("note");  ?>
              <table  class="table table-bordered">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Percent Amount(Day)</th>
                    <th>Percent Amount(Night)</th>
                    <?php if($pendingPayroll==0){ ?>
                    <th>Option</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $SNo = 1;
                    foreach ($overtimess as $row) { ?>
                    <tr id="record<?php echo $row->id;?>">
                      <td width="1px"><?php echo $SNo; ?></td>
                      <td><?php echo $row->name; ?></td>
                      <td><?php echo number_format((100*$row->day_percent), 2); ?>%</td>
                      <td><?php echo number_format((100*$row->night_percent),2); ?>%</td>

                      <?php if($pendingPayroll==0){ ?>
                      <td class="options-width">
                          <a href="{{ route('flex.overtime_category_info',base64_encode($row->id)) }}" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-main btn-xs"><i class="ph-circle"></i></button> </a>

                      </td>
                      <?php  } ?>
                      </tr>

                    <?php $SNo++;  } ?>
                </tbody>
              </table>
            </div>
          </div>
          </div>
        


         
          <!-- Add Overtime Category -->
          <div class="col-md-4 col-xs-12">
          <div class="card">
            <div class="card-head px-3">
              <h2>Add Overtime</h2>
              
              <div class="clearfix"></div>
            </div>
            <div class="card-body">
              <div id="resultOvertimeSubmission"></div>
              <form id="addOvertime" autocomplete="off" class="form-horizontal form-label-left">
              <div class="form-group">
                  <label  for="first-name">Overtime Name 
                  </label>
                  <div >
                    <textarea required="" type="text" name="name" class="form-control col-md-7 col-xs-12"></textarea> 
                    <span class="text-danger"><?php //echo form_error("fname");?></span>
                  </div>
                </div>
                <div id ="percent" class="form-group">
                  <label  for="first-name">Day Payment Per Hour(In Percent)
                  </label>
                  <div >
                    <input required="" type="number" name="day_percent" min="0" max="300" step="0.01" placeholder="Percent Per Hour(Day)" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div id ="percent" class="form-group">
                  <label  for="first-name">Night Payment Per Hour(In Percent)
                  </label>
                  <div >
                    <input required="" type="number" name="night_percent" min="0" max="300" step="0.01" placeholder="Percent Per Hour(Night)" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                    <button type="reset" class="btn btn-warning">Cancel</button>
                    <button  class="btn btn-main">Submit</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
          </div>

        </div>       

      </div>
    </div>
  </div>
  @include("app.includes.update_allowances")
@endsection
@push('footer-script')
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
                     url:"{{ route('flex.addAllowance') }}",
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
                     url:"{{ route('flex.addOvertimeCategory') }}",
                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
                     url:"{{ route('flex.addDeduction') }}",
                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
@endpush
