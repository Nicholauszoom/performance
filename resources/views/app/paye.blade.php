
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
                <h3>P.A.Y.E</h3>
              </div>
              <!-- <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div> -->

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>P.A.Y.E Ranges &nbsp;&nbsp;&nbsp;<a><button type="button" id="newPaye" data-toggle="modal"  class="btn btn-primary">Add New</button></a></h2>

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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Excess Added To an Amount Exceedint the Minimum Amount
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
                           <button type="reset" class="btn btn-warning" data-dismiss="modal">CANCEL</button>                          
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

        <!-- /page content -->

        <script>
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