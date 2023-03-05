@extends('layouts.vertical', ['title' => 'Grievances'])

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
                <div class="card">
                  <div class="card-head">
                    <h2 class="m-2"><i class="fa fa-user"></i> Grievance </h2>
                    <hr>
                    <!--<h2><i class="fa fa-user"></i> Grievances and Discplinary </h2>-->
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                @if(Session::has('note'))      {{ session('note') }}  @endif  

                    <form id="demo-form2" autocomplete="off" enctype="multipart/form-data" action="{{ route('flex.save-grievances') }}" method="post" data-parsley-validate class="form-horizontal form-label-left">
                      @csrf
                      <div class="row">
                      
                      <div class="form-group mb-1">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="text" name="title" placeholder="Title" required class="form-control">
                        </div>
                      </div> <br>
                      
                      <div class="form-group col-12 mb-2">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name">Description(Body)
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <textarea placeholder="Description" cols="10" class="form-control col-md-7 col-xs-12"  name="description" required="" rows="5"></textarea>
                        </div>
                      </div> 
                      
                      <div class="form-group col-6 mb-2">
                        <label class="" for="first-name"> Proof  If Any <small class="text-danger">( eg. Document, Picture etc..)</small>  
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type='file' name='attachment'  class="form-control" />
                        </div>
                      </div> 
                      
                        <div class="form-group col-6 mb-2">
                        <label class="mb-4" for="first-name">
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <label class="containercheckbox">Report as Ananymous
                           <input type="checkbox" name="anonymous" value="1">
                            <span class="checkmark"></span>
                          </label>
                        </div>
                      </div> 
                      <hr>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-1 ">
                          <button type="submit" name="submit" class="btn btn-main float-end">Submit Grievance</button>
                        </div>
                      </div>
                      <hr class="mt-2">
                    </div>
                      
                      </form><br><br> 
                 
                      <!-- Whole View -->
               <div class="col-md-12 col-sm-4 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <!--<h2>All Grievances </h2>-->
                    <h2 class="m-2">My  Grievances </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                    
                    <!--Table Grievances HR-->
                    
                    <table  class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Evidence</th> 
                          <th>Title</th> 
                          <th>Description</th>
                          <th>Date</th>
                          <th>Status</th>
                          <th>Option</th> 
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        // if ($department->num_rows() > 0){
                          foreach ($my_grievances as $row) {  ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td><?php if($row->attachment != NULL) echo "<a download= 'attachment' href ='". asset('storage/grievances-attachment').$row->attachment."'>"."<div class='col-md-12'>
                                <span class='btn btn-sm bg-main'>DOWNLOAD</span></div>"."</a>"; else echo "NIL"; ?></td>
                            <td><?php echo $row->title; ?></td>
                            <td><?php echo $row->description; ?></td>
                            <td><?php $datesValue = str_replace('-', '/', $row->DATED);
                                  echo date('d-m-Y', strtotime($datesValue));  ?></td>

                            <td>
                            
                            <?php if( $row->status==0 ) 
                            echo '<div class="col-md-12">
                                <span class="badge bg-pending">ON PROGRESS</span></div>'; 
                                else
                                echo '<div class="col-md-12">
                                <span class="label label-success">SOLVED</span></div>'; ?></td>
                            
                            <td class="options-width">
                            <a title="Info and Details" href="<?php echo  url(''); ?>/flex/grievance_details/<?php echo $row->id; ?>">
                                  <button  class="btn btn-info btn-sm">INFO</button></a>
                               
                            </td> 
                            </tr>
                          <?php } //} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            

                  </div>
                </div>
              </div>
          </div>
        </div>
        <!-- /page content -->

<script type="text/javascript">

    function markSolved(id)
    {
        if (confirm("Are You Sure You Want to Mark This as Solved") == true) {
        // var loanid = id;
  
            $.ajax({
                url: "<?php echo url('flex/resolve_grievance');?>/"+id
            })
            .done(function(data){
              alert('SUCCESS'); 
             $('#feedBack').fadeOut('fast', function(){
                  $('#feedBack').fadeIn('fast').html(data);
                });
             // $("#loanList").load(" #loanList");
             setTimeout(function() {
              location.reload();
             }, 2000);
             /*$('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>');
                });*/
                })
            .fail(function(){
             alert('Request Failed Failed!! ...'); 
                });
        }
    }


    

    function markUnsolved(id)
    {
        if (confirm("Are You Sure You Want Mark This as Not Solved") == true) {
        // var loanid = id;
  
            $.ajax({
                url: "<?php echo url('flex/unresolve_grievance');?>/"+id
            })
            .done(function(data){
              alert('SUCCESS'); 
             $('#feedBack').fadeOut('fast', function(){
                  $('#feedBack').fadeIn('fast').html(data);
                });

             setTimeout(function() {
              location.reload();
             }, 2000);
             
                })
            .fail(function(){
             alert('Loan Disapproval Failed!! ...'); 
                });
        }
    }
</script>


 @endsection