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
                <h3>Employees </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Employees  About to Retire   
                    </h2>

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
                          <th>Position</th>
                          <th>Date Hired</th>
                          <th>Birth Date</th>
                          <th>Age</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($retire as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><a title="More Details"  href="<?php echo url(); ?>flex/userprofile/?id=".$row->empID; ?>"><font color="blue"><?php echo $row->empName; ?></font></a></td>
                            <td><?php echo $row->department; ?></td>
                            <td><?php echo $row->position; ?></td>
                            <td><?php echo $row->date_hired;?></td>
                            <td><?php echo $row->birthdate;?></td>
                            <td><?php echo $row->age;?></td>    


                            <td class="options-width">
                           <a href="<?php echo url(); ?>flex/deleteemployee/?id=".$row->empID; ?>"   title="Terminate Contract" class="icon-2 info-tooltip"><font color="red"> <i class="fa fa-times"></i></font></a></td>
                            </tr>
                          <?php }  ?>
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