
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php


  if($category==1){
    foreach ($bank_info as $row) {
      $bankID = $row->id;
      $bankName = $row->name;
      $abbrev = $row->abbr;
      $bankCode = $row->bank_code;
    } 

  }else{
    foreach ($branch_info as $row) {
      $branchID = $row->id;
      $branchName = $row->name;
      $street = $row->street;
      $region = $row->region;
      $country = $row->country;
      $branchCode = $row->branch_code;
      $swiftcode = $row->swiftcode;
    }     
  }
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Update Bank Info Banks </h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">              
              <div class="col-md-12 col-sm-12 col-xs-12">                          
                    <div class="x_panel">
                      <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Add Branch</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                      <div class="col-lg-12">

                          <div class="col-lg-6">

                          <?php if($category==1){ ?> 

                              
                            <!--First Name-->
                            <form autocomplete="off" id="updateBankName" class="form-horizontal form-label-left"> 
                                <div class="col-sm-9">
                                <div id ="feedbackBankName"></div>
                                  <div class="form-group">
                                    <label for="stream" >Bank Name</label>
                                     <div class="input-group">
                                        <input hidden name ="bankID" value="<?php echo $bankID; ?>">
                                        <input required="" type="text" name ="name" value="<?php echo $bankName; ?>" class="form-control">
                                        <span class="input-group-btn">
                                          <button  class="btn btn-primary">UPDATE</button>
                                        </span>
                                      </div>
                                  </div>
                                </div>
                            </form> 
                              
                            <!--First Name-->
                            <form autocomplete="off" id="updateAbbrev" class="form-horizontal form-label-left"> 
                                <div class="col-sm-9">
                                <div id ="feedbackAbbrev"></div>
                                  <div class="form-group">
                                    <label for="stream" >Abbreviation</label>
                                     <div class="input-group">
                                        <input hidden name ="bankID" value="<?php echo $bankID; ?>">
                                        <input type="text" name ="abbrev" value="<?php echo $abbrev; ?>" class="form-control">
                                        <span class="input-group-btn">
                                          <button  class="btn btn-primary">UPDATE</button>
                                        </span>
                                      </div>
                                  </div>
                                </div>
                            </form> 
                            <?php } if($category==2){ ?>  

                            <!--First Name-->
                            <form autocomplete="off" id="updateBranchName" class="form-horizontal form-label-left"> 
                                <div class="col-sm-9">
                                <div id ="feedbackBranchName"></div>
                                  <div class="form-group">
                                    <label for="stream" >Branch Name</label>
                                     <div class="input-group">
                                        <input hidden name ="branchID" value="<?php echo $branchID; ?>">
                                        <input required="" type="text" name ="name" value="<?php echo $branchName; ?>" class="form-control">
                                        <span class="input-group-btn">
                                          <button  class="btn btn-primary">UPDATE</button>
                                        </span>
                                      </div>
                                  </div>
                                </div>
                            </form>   
                            
                            <!--First Name-->
                            <form autocomplete="off" id="updateBranchCode" class="form-horizontal form-label-left"> 
                                <div class="col-sm-9">
                                <div id ="feedbackBranchCode"></div>
                                  <div class="form-group">
                                    <label for="stream" >Branch Code</label>
                                     <div class="input-group">
                                        <input hidden name ="branchID" value="<?php echo $branchID; ?>">
                                        <input required="" type="text" name ="branch_code" value="<?php echo $branchCode; ?>" class="form-control">
                                        <span class="input-group-btn">
                                          <button  class="btn btn-primary">UPDATE</button>
                                        </span>
                                      </div>
                                  </div>
                                </div>
                            </form>   
                            
                            <!--First Name-->
                            <form autocomplete="off" id="updateBranchSwiftcode" class="form-horizontal form-label-left"> 
                                <div class="col-sm-9">
                                <div id ="feedbackBranchSwiftcode"></div>
                                  <div class="form-group">
                                    <label for="stream" >Branch Swiftcode</label>
                                     <div class="input-group">
                                        <input hidden name ="branchID" value="<?php echo $branchID; ?>">
                                        <input required="" type="text" name ="swiftcode" value="<?php echo $swiftcode; ?>" class="form-control">
                                        <span class="input-group-btn">
                                          <button  class="btn btn-primary">UPDATE</button>
                                        </span>
                                      </div>
                                  </div>
                                </div>
                            </form> 
                              
                            
                            <?php } ?>

                          </div>

                          <div class="col-lg-6">
                          <?php if($category==1){ ?>
                              
                            <!--First Name-->
                            <form autocomplete="off" id="updateBankCode" class="form-horizontal form-label-left"> 
                                <div class="col-sm-9">
                                <div id ="feedbackBankCode"></div>
                                  <div class="form-group">
                                    <label for="stream" >Bank Code</label>
                                     <div class="input-group">
                                        <input hidden name ="bankID" value="<?php echo $bankID; ?>">
                                        <input required="" type="text" name ="bank_code" value="<?php echo $bankCode; ?>" class="form-control">
                                        <span class="input-group-btn">
                                          <button  class="btn btn-primary">UPDATE</button>
                                        </span>
                                      </div>
                                  </div>
                                </div>
                            </form>  
                              <?php } if($category==2){ ?>

                             <!--First Name-->
                            <form autocomplete="off" id="updateBranchStreet" class="form-horizontal form-label-left"> 
                                <div class="col-sm-9">
                                <div id ="feedbackBranchStreet"></div>
                                  <div class="form-group">
                                    <label for="stream" >Branch Street</label>
                                     <div class="input-group">
                                        <input hidden name ="branchID" value="<?php echo $branchID; ?>">
                                        <input required="" type="text" name ="street" value="<?php echo $street; ?>" class="form-control">
                                        <span class="input-group-btn">
                                          <button  class="btn btn-primary">UPDATE</button>
                                        </span>
                                      </div>
                                  </div>
                                </div>
                            </form>  <!--First Name-->
                            <form autocomplete="off" id="updateBranchRegion" class="form-horizontal form-label-left"> 
                                <div class="col-sm-9">
                                <div id ="feedbackBranchRegion"></div>
                                  <div class="form-group">
                                    <label for="stream" >Region</label>
                                     <div class="input-group">
                                        <input hidden name ="branchID" value="<?php echo $branchID; ?>">
                                        <input required="" type="text" name ="region" value="<?php echo $region; ?>" class="form-control">
                                        <span class="input-group-btn">
                                          <button  class="btn btn-primary">UPDATE</button>
                                        </span>
                                      </div>
                                  </div>
                                </div>
                            </form> 
                             <!--First Name-->
                            <form autocomplete="off" id="updateBranchCountry" class="form-horizontal form-label-left"> 
                                <div class="col-sm-9">
                                <div id ="feedbackBranchCountry"></div>
                                  <div class="form-group">
                                    <label for="stream" >Branch Code</label>
                                     <div class="input-group">
                                        <input hidden name ="branchID" value="<?php echo $branchID; ?>">
                                        <input required="" type="text" name ="country" value="<?php echo $country; ?>" class="form-control">
                                        <span class="input-group-btn">
                                          <button  class="btn btn-primary">UPDATE</button>
                                        </span>
                                      </div>
                                  </div>
                                </div>
                            </form> 
                            <?php } ?>

                          </div>

                        </div>         
                        
            
                      </div>
                    </div>
                </div>

            </div>
          </div>
        </div>
          <!-- /.modal -->

        


        <!-- /page content -->
 

@include   ("app/includes/update_bank")


 @endsection