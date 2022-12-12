@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
@endpush

@push('head-scriptTwo')
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

              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Pension Funds</h2>
                     <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <?php echo session("notepack");  ?>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Employee Amount</th>
                          <th>Employer Amount</th>
                          <th>Deduction From</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($pension as $row) {
                            //if($row->id==0) continue; // Skip the default group
                            ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td ><?php echo $row->name."(".$row->abbrv.")"; ?></td>
                            <td><?php echo 100*($row->amount_employee); ?>%</td>
                            <td><?php echo 100*($row->amount_employer); ?>%</td>
                            <td> <?php if($row->deduction_from==1){ ?>
                                <span class="label label-success">Basic Salary</span>
                                <?php } else { ?>
                                <span class="label label-success">Gross</span>
                                <?php  } ?>

                            </td>
                            <td class="options-width">
                                <a href="<?php echo  url(''); ?>/flex/deduction_info/?pattern=<?php echo $row->id; ?>|1" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                            </td>
                            </tr>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Deduction</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                     @if(Session::has('note'))      {{ session('note') }}  @endif  ?>

                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Name</th>
                          <th>Employee Amount(in %)</th>
                          <th>Employer Amonut(in %)</th>
                          <?php if($pendingPayroll==0){ ?>
                          <th>Option</th>
                          <?php } ?>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        //if ($employee->num_rows() > 0){
                          foreach ($deduction as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo 100*($row->rate_employee)."%"; ?></td>
                            <td><?php echo 100*($row->rate_employer)."%"; ?></td>

                            <?php if($pendingPayroll==0){ ?>
                            <td class="options-width">
                                <a href="<?php echo  url(''); ?>/flex/common_deductions_info/?id=".$row->id; ?>"  title="More Info" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info"></i></button> </a>

                            </td>
                            <?php } ?>

                          </tr>
                          <?php } //} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>






            <div class="row">
            <div class="col-md-6 col-xs-12">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>P.A.Y.E Ranges &nbsp;&nbsp;&nbsp;</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                     @if(Session::has('note'))      {{ session('note') }}  @endif  ?>

                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Minimum Amount</th>
                          <th>Maximum Amount</th>
                          <th>Excess Added as </th>
                          <th>Rate to an Amount Excess of Minimum </th>
                          <?php if($pendingPayroll==0){ ?>
                          <th>Option</th>
                          <?php } ?>
                        </tr>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($paye as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo number_format($row->minimum,2); ?></td>
                            <td><?php echo number_format($row->maximum,2); ?></td>
                            <td><?php echo number_format($row->excess_added,2); ?></td>
                            <td><?php echo 100*($row->rate)."%"; ?></td>
                            <?php if($pendingPayroll==0){ ?>
                            <td class="options-width">
                           <!-- <a class="tooltip-demo" data-toggle="tooltip" href="<?php echo  url(''); ?>/flex/deletepaye/?id=".$row->id; ?>" title="Delete" class="icon-2 info-tooltip" ><button type="button" class="btn btn-danger btn-xs" ><i class='fa fa-trash'></i></button></a>&nbsp;&nbsp; -->

                           <a class="tooltip-demo" data-toggle="tooltip" data-placement="top" title="Edit"  href="<?php echo  url(''); ?>/flex/paye_info/?id=".$row->id; ?>"><button type="button" class="btn btn-info btn-xs" ><i class='fa fa-edit'></i></button></a>

                            </td>
                            <?php } ?>
                            </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-xs-12">
              <div id="insertPaye" class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add New P.A.Y.E Range </h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <div id="feedBackSubmission"></div>
                    <form autocomplete="off" id="addPAYE" enctype="multipart/form-data"  method="post"    data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Minimum Amount
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="" type="number" min="0" max="100000000" step="1" name="minimum" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Maximum Amount
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="" type="number" min="0" max="100000000" step="1" name="maximum" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Excess Added To an Amount Exceeding the Minimum Amount
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="" type="number" min="0" max="100000000" step="1" name="excess" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Percentage Contribution to Amount that Exceed the Minimum Amount
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="" type="number" min="0" max="99" step="1" name="rate" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div>
                      <!-- END -->
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  class="btn btn-success">ADD</button>
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



<!-- /page content -->
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

    $(document).ready(function(){
        $('.hide').hide();
           $('.myTable').DataTable();
        });
    function deleteDomain(id)
    {
        if (confirm("Are You Sure You Want To delete This Record") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('/flex/deleteemployee');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();

            $('#domain'+id).hide();

            }

            });
        }
    }

    function cancel()
    {
        alert("hello");
        Location.reload();
    }
</script>





<script type="text/javascript">
  $('#addPAYE').submit(function(e){

    e.preventDefault(); // Prevent Default Submission

    $.ajax({
 url: "<?php echo  url(''); ?>/flex/addpaye",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){
        alert(data.title);

      if(data.status == 'OK'){
        // alert(data.title);
                $('#feedBackSubmission').fadeOut('fast', function(){
                  $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });
              setTimeout(function(){// wait for 5 secs(2)
             location.reload()// then reload the page.(3)
          }, 2000);

              } else{
                // alert(data.title);
                $('#feedBackSubmission').fadeOut('fast', function(){
                  $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('Registration Failed, Review Your Network Connection...');
    });

});


$("#newPaye").click(function() {
    $('html,body').animate({
        scrollTop: $("#insertPaye").offset().top},
        'slow');
});
</script>

 @endsection
