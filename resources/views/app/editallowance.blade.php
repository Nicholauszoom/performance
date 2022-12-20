@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')


<?php
                      foreach ($employee as $row) {
                        $name=$row->fname." ".$row->mname." ".$row->lname;}
                          ?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Allowances </h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2>Update <?php echo $label; ?> Allowance For <font color="blue"> <?php echo $name; ?> </font></h2>


                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                  
                   <?php //echo session("note");  ?>

                     <?php
            if (isset($allowance)){
                      foreach ($allowance as $row) {
                        $id=$row->ID;
                        $ammount = $row->type;
                          ?>
            <div class="col-lg-6">
                    <form id="upload_form" align="center" enctype="multipart/form-data" method="post" action="<?php echo  url(''); ?>/flex/editallowance/?id=<?php echo $id; ?> && type=<?php echo $category; ?>"  data-parsley-validate class="form-horizontal form-label-left">
                            

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Department ID
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input disabled="disabled" value="<?php echo $id; ?>" name="fname" id="first-name"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Ammount
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input  value="<?php echo $ammount; ?>" name="ammount" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <input type="hidden" name="sid" value="<?php //echo $data[0]->id; ?>">
                          <button  type="submit"  name="update" class="btn btn-success">Update</button>
                        </div>
                      </div>

                    </form>
                  </div>

                  
                
                    <!-- </table> -->
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>


         


            <?php } }    ?>

        <!-- /page content -->



 @endsection