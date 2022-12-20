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
                <h3>Account Coding </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2> Account Codes</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                  <div id="feedBackDelete"></div>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Code</th>
                          <th>Name</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($accountCodes as $row) { ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><b><?php echo $row->code; ?> </b> </td>
                            <td><b><?php echo $row->name; ?> </b> </td>

                            <td class="options-width">
                              <!-- <a  href="<?php echo  url(''); ?>/flex/account_code_info/?id=".base64_encode($row->id); ?>" title="Info" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
 -->
                                <a href="javascript:void(0)" onclick="deleteAccountCode(<?php echo $row->id; ?>)" title="Info" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="ph-trash-o"></i></button> </a>

                            </td>
                           </tr>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

               <div id="bottom" class="col-md-4 col-sm-6 col-xs-6">
                    <div class="card">
                      <div class="card-head">
                        <h2><i class="fa fa-tasks"></i> Add New Account Code</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="card-body">
                        <div id="feedBackAddCode"></div>
                        <form autocomplete="off" id="addAccountCode" enctype="multipart/form-data"  method="post" data-parsley-validate class="form-horizontal form-label-left">

                          <!-- START -->

                           <div id ="percent" class="form-group">
                            <label  for="first-name">Name
                            </label>
                            <div >
                              <input required=""  type="text" name="name" placeholder="Name" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                           <div id ="amount" class="form-group">
                            <label  for="first-name">Code
                            </label>
                            <div>
                              <input required=""  type="text" placeholder="Code" name="code" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <!-- END -->
                          <div class="form-group">
                               <button type="reset" class="btn btn-warning" >CANCEL</button>
                               <button class="btn btn-main" >ADD</button>
                          </div>
                          </form>

                      </div>
                    </div>
                </div>

            </div>
          </div>
        </div>




        <!-- /page content -->





<script type="text/javascript">
    $('#addAccountCode').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/addAccountCode",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackAddCode').fadeOut('fast', function(){
              $('#feedBackAddCode').fadeIn('fast').html(data);
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

function deleteAccountCode(id)
    {
        if (confirm("Are You Sure You Want To Delete This Account Code") == true) {
        var id = id;
        $.ajax({
            url:"<?php echo url('flex/deleteAccountCode');?>/"+id,
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
