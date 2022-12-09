@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')


      <?php if($data){
        foreach ($data as $row) {
          $id = $row->id;
          $name = $row->name;
          $code = $row->code;
        }
       ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Account Coding </h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
               <div id="bottom" class="col-md-12 col-sm-12 col-xs-12">                            
                    <div class="x_panel">
                      <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Add Country</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div id="feedBackUpdate"></div>
                        <form autocomplete="off" id="updateAccountingCode" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
                          <input required="" hidden="" value="<?php echo $id; ?>" class="form-control col-md-7 col-xs-12" name="accountingId"  /> 

                          <!-- START -->
                          <div class="form-group" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Accounting Name</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input required="" value="<?php echo $name; ?>" class="form-control col-md-7 col-xs-12" name="name" placeholder="Name"  /> 
                            </div>
                          </div>
                          <div class="form-group" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Code</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input required="" value="<?php echo $code; ?>" class="form-control col-md-7 col-xs-12" name="code" placeholder="Code"  /> 
                            </div>
                          </div>
                          <!-- END -->
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                               <button type="reset" class="btn btn-warning" >CANCEL</button>
                               <button class="btn btn-primary" >ADD</button>
                            </div>
                          </div> 
                          </form>
            
                      </div>
                    </div>
                </div>

            </div>
          </div>
        </div>
      <?php } ?>

        <!-- /page content -->
        



<script type="text/javascript">
    $('#updateAccountingCode').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/updateAccountCode",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
          $('#feedBackUpdate').fadeOut('fast', function(){
              $('#feedBackUpdate').fadeIn('fast').html(data);
            });
          setTimeout(function(){// wait for 2 secs(2)
                location.reload(); // then reload the page.(3)
            }, 2000); 
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 
</script>
 @endsection