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
                <h3>Organisation</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Organisation Levels</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                   <div id="feedBackTable"></div>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Minimum Annual Salar</th>
                          <th>Maximum Annual Salar</th>
                          <?php if(session('mng_org')){ ?>
                          <th>Option</th>
                          <?php } ?>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        $SNo = 1;
                          foreach ($level as $row) { ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $SNo; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->minSalary; ?></td>
                            <td><?php echo $row->maxSalary; ?></td>
                            <?php if(session('mng_org')){ ?>
                            <td class="options-width">
                                <a href="<?php echo  url(''); ?>/flex/organization_level_info/?id=".base64_encode($row->id); ?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                            </td>
                            <?php } ?>
                           </tr>
                          <?php $SNo++; } //} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
              <?php if(session('mng_org')){ ?>
               <div id="bottom" class="col-md-12 col-sm-12 col-xs-12">                            
                    <div class="x_panel">
                      <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Add Organization Level</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                      <div id="orgAddFeedBack"></div>            
                        <form autocomplete="off" id="organizationLevelAdd" enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
            
                          <!-- START -->
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Organization Level Name</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <textarea required="" class="form-control col-md-7 col-xs-12" name="name" placeholder="Organization Level Name" rows="2"></textarea> 
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Minimum Annual Basic Salary Range</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input required="" id="minSalary" type="number"  min="100" max="10000000000" step="0.01" class="form-control col-md-7 col-xs-12" name="minSalary" placeholder="Minimum Salary"/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Maximum Annual Basic Salary Range</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <input required="" id="maxSalary" type="number" min="100" max="10000000000" step="0.01" class="form-control col-md-7 col-xs-12" name="maxSalary" placeholder="Maximum Salary"/> 
                            </div>
                          </div>
                          <!-- END -->
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <input type="submit"  value="ADD" name="add" class="btn btn-primary"/>
                            </div>
                          </div> 
                          </form>
            
                      </div>
                    </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

        


        <!-- /page content -->



<script type="text/javascript">
    $('#organizationLevelAdd').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"<?php echo  url(''); ?>/flex/addOrganizationLevel",
             type:"post",
             data:new FormData(this),
             processData:false,
             contentType:false,
             cache:false,
             async:false
         })
          .done(function(data){
            if (data.status == 'OK') {
              $('#orgAddFeedBack').fadeOut('fast', function(){
                $('#orgAddFeedBack').fadeIn('fast').html(data.message);
              });
              setTimeout(function(){// wait for 2 secs(2)
                  location.reload(); // then reload the page.(3)
              }, 2000); 
            }else {
              $('#orgAddFeedBack').fadeOut('fast', function(){
                $('#orgAddFeedBack').fadeIn('fast').html(data.message);
              });
            }
            
          })
          .fail(function(){
            alert('Request Failed!! ...'); 
          });
  }); 
</script>
<script> //For Deleting records without Page Refreshing
      
    function deleteDepartment(id)
    {
        if (confirm("Are You Sure You Want To Delete This Department") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/deleteDepartment');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();

              if(data.status == 'OK'){
              alert("Record Deleted Sussessifully!");
              $('#domain'+id).hide();              
              $('#feedBackTable').fadeOut('fast', function(){
              $('#feedBackTable').fadeIn('fast').html(data.message);
            });
              setTimeout(function() {
                location.reload();
              }, 1000);
              }else if(data.status != 'SUCCESS'){
              alert("Property Not Deleted, Error In Deleting");
               }
           
            
            // document.location.reload();
               
            }
               
            });
        }
    } 
      
    function activateDepartment(id)
    {
        if (confirm("Are You Sure You Want To Activate This Department") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/activateDepartment');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();

              if(data.status == 'OK'){
              alert("Record Deleted Sussessifully!");
              $('#domain'+id).hide();
              $('#feedBackTable2').fadeOut('fast', function(){
              $('#feedBackTable2').fadeIn('fast').html(data.message);
            });
              setTimeout(function() {
                location.reload();
              }, 1000);
              }else if(data.status != 'SUCCESS'){
              alert("Property Not Deleted, Error In Deleting");
               }
           
            // document.location.reload();
               
            }
               
            });
        }
    }        
</script> 
 @endsection