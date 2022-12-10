
        

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
                <h3>Next Kin Information</h3>
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
                    <h2>Add New </h2>
                    <!-- <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul> -->
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> <br>
                  <?php

                     echo session("note");  ?>

                    <form id="demo-form2" enctype="multipart/form-data" action="<?php echo  url(''); ?>/flex/employeeAdd" method="post" data-parsley-validate class="form-horizontal form-label-left">
                    <!-- test -->
                    <!-- <div class="row">
                      EMPLOYEE NAMES<br><br>
                    </div> -->

                    <div class="col-lg-12">
                    <div class="col-lg-4">

                      <div class="form-group">
                        <label for="middle-name" >First Name</label>
                        <div >
                          <input id="class" placeholder="First Name" class="form-control col-md-7 col-xs-12" type="text" name="fname">
                          <span class="text-danger"><?php// echo form_error("fname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label >Gender</label>
                        <div >
                          <div id="gender" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                              <input id="gender" type="radio" name="gender" value="Male"> &nbsp; Male &nbsp;
                            </label>
                            <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                              <input id="gender"  type="radio" name="gender" value="Female"> Female
                            </label>
                          </div>
                          <span class="text-danger"><?php// echo form_error("gender");?></span>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="stream" >Postal Address</label>
                        <div >
                          <input id="email" class="form-control col-md-7 col-xs-12" type="text" name="postaddress">
                          <span class="text-danger"><?php// echo form_error("postaddress");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="stream" >Office No</label>
                        <div >
                          <input id="email" class="form-control col-md-7 col-xs-12" type="text" name="postaddress">
                          <span class="text-danger"><?php// echo form_error("postaddress");?></span>
                        </div>
                      </div>

                  </div>

                  <div class="col-lg-4">

                      <div class="form-group">
                        <label for="middle-name" >Middle Name</label>
                        <div >
                          <input id="class" placeholder="Middle Name" class="form-control col-md-7 col-xs-12" type="text" name="mname">
                          <!-- <span class="text-danger"><?php// echo form_error("mname");?></span> -->
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="middle-name" >Employee Name</label>
                        <select name="role" class="form-control">
                           <?php 
                           $conn = mysqli_connect("localhost", "root", "00001994", 'cipay');
                           $sql = "SELECT * FROM employee"; $result = $conn->query($sql);

                            if ($result->num_rows >0) {
                              while($row = $result->fetch_assoc()) { ?>
                          <option value="<?php echo $row['id']; ?>"><?php echo $row['fname']; ?></option> <?php } } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="stream" >Mobile</label>
                        <div >
                          <input id="email" class="form-control col-md-7 col-xs-12" type="text" name="postaddress">
                          <span class="text-danger"><?php// echo form_error("postaddress");?></span>
                        </div>
                      </div>


                  </div>
                  <div class="col-lg-4">

                      <div class="form-group">
                        <label for="middle-name" >Last Name</label>
                        <div >
                          <input id="class" placeholder="Last Name(Surname)" class="form-control col-md-7 col-xs-12" type="text" name="lname">
                          <span class="text-danger"><?php// echo form_error("lname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="stream" >Relationship</label>
                        <div >
                          <input id="stream" class="form-control col-md-7 col-xs-12" type="text" name="salary">
                          <span class="text-danger"><?php// echo form_error("salary");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="middle-name" >Physical Address</label>
                        <div >
                          <input id="class" class="form-control col-md-7 col-xs-12" type="text" name="phyaddress">
                          <span class="text-danger"><?php// echo form_error("phyaddress");?></span>
                        </div>
                      </div>


                  </div>
                  </div>
                  <!-- test -->
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="reset" class="btn btn-primary">Cancel</button>
                          <button type="submit" name="add" class="btn btn-success">Register</button>
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


 @endsection