
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php  
  ?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Leaves </h3>
              </div>
            </div>

            <!-- INDIVIDUAL  -->
             <!-- Tabs -->  
        <?php 
        // $showbox = 3;
        if($showbox!=1){ ?>            

            <div class="clearfix"></div>

            <div class="">
              <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-user"></i> Individual Leave Report </h2>
                    <ul class="nav navbar-right panel_toolbox">
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
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/attendance/customleavereport"  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" >
                        
                      
                      <div class="form-group">
                        <label class="control-label col-md-3  col-xs-6" >Employee</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                        <select required="" name="employee" class="select4_single form-control" tabindex="-1">
                        <option></option>
                           <?php
                          foreach ($customleave as $row) {
                             # code... ?>
                          <option value="<?php echo $row->empID; ?>"><?php echo $row->name; ?></option> <?php } ?>
                        </select>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <!-- <input type="submit"  value="SHOW" name="viewindividual" class="btn btn-primary"/> -->
                          <input type="submit"  value="PRINT" name="printindividual" class="btn btn-success"/>
                        </div>
                      </div> 
                      </form>

                  </div>
                </div>
              </div>
              </div>
              <!-- Tabs -->
              <?php } ?>
            <!--  INDIVIDUAL-->

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Leaves Already Accepted
                    <a></a></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                  
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Department</th> 
                          <th>Nature</th>  
                          <th>Duration</th>
                          <th>From</th>
                          <th>To</th>
                          
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        // if ($leave->num_rows() > 0){
                          foreach ($leave as $row) {
                            // $date1=date_create($row->start);
                            // $date2=date_create($row->end);
                            // $diff=date_diff($date1,$date2);
                            // $final = $diff->format("%R%a Days");
                            // $final2 = $diff->format("%R%a");
                           ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php  echo $row->NAME; ?></td>
                            <td><?php echo "<B>DEPARTMENT:</B> ".$row->DEPARTMENT."<br><B>POSITION</B>: ".$row->POSITION; ?></td>
                            <td><?php echo $row->TYPE; ?></td>
                            <td><?php echo $row->days; ?></td>
                            <td><?php echo $row->start; ?></td>
                            <td><?php echo $row->end; ?></td>

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


          
        <!-- /page content -->



           


 @endsection