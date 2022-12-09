@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php 
  $CI_Model = get_instance();
  $CI_Model->load->model('flexperformance_model'); 
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Employee Nationality </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Countries</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <div id="feedBackDelete"></div>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Country Code</th>
                          <?php if(session('mng_org')){ ?>
                          <th>Option</th>
                          <?php } ?>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($nationality as $row) { ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><b><?php echo $row->name; ?> </b> </td>
                            <td><b>+<?php echo $row->code; ?> </b> </td>

                            <?php if(session('mng_org')){ ?>
                            <td class="options-width">
                            <?php
                            $checkEmployee = $CI_Model->flexperformance_model->checkEmployeeNationality($row->code); 
                            if($checkEmployee>0){ ?>
                                <a title="Country Can Not Be Deleted, Some Employee Have Nationality From This Country" class="icon-2 info-tooltip"><button disabled="" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                            <?php } else { ?>

                                <a href="javascript:void(0)" onclick="deleteCounty(<?php echo $row->code; ?>)" title="Delete Country" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                            <?php } ?>

                            </td>
                            <?php } ?>
                           </tr>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
              <?php if(session('mng_org')){ ?>
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
                        <div id="feedBack"></div>
                        <form autocomplete="off" id="addNationality" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">
            
                          <!-- START -->
                          <div class="form-group" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Country Name</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input required="" class="form-control col-md-7 col-xs-12" name="name" placeholder="Country eg. Tanzania"  /> 
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Code(Mobile Code)</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input required="" type="number" min="1" max="9999" class="form-control col-md-7 col-xs-12" name="code" placeholder="Code eg 255" /> 
                            </div>
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
              <?php } ?>
                </div>

            </div>
          </div>
        </div>

        


        <!-- /page content -->
 




<script type="text/javascript">
    $('#addNationality').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/addEmployeeNationality",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBack').fadeOut('fast', function(){
              $('#feedBack').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
          location.reload(); // then reload the page.(3)
      }, 1000); 
      $('#addNationality')[0].reset();
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 

function deleteCounty(id)
    {
        if (confirm("Are You Sure You Want To Delete This Country") == true) {
        var id = id;
        $.ajax({
            url:"<?php echo url('flex/deleteCountry');?>/"+id,
            success:function(data)
            {
              alert("SUCCESS");
           $('#feedBackDelete').fadeOut('fast', function(){
          $('#feedBackDelete').fadeIn('fast').html(data);
        });
            setTimeout(function() {
              location.reload();
            }, 1000);
               
            }
               
            });
        }
    }
</script>





 @endsection