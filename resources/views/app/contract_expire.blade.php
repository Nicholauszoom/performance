@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section



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
                    <h2>Employees Whose Contracts are About to Expire   
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
                          <th>Contract Type</th>
                          <th>Contract Duration</th>
                          <th>Last Renew Date</th>
                          <th>Contract AGE</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($contract_expire as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><a title="More Details"  href="<?php echo url(); ?>flex/userprofile/?id=".$row->emp_id; ?>"><font color="blue"><?php echo $row->NAME; ?></font></a></td>
                            <td><?php echo $row->DEPARTMENT; ?></td>
                            <td><?php echo $row->POSITION; ?></td>
                            <td><?php echo $row->DATE_HIRED;?></td>
                            <td><?php echo $row->LAST_RENEW_DATE;?></td>
                            <td><?php echo $row->Contract_TYPE;?></td>
                            <td><?php echo $row->CONTRACT_DURATION;?></td>
                            <td><?php echo $row->CONTRACT_AGE;?></td>


                            <td class="options-width">
                           <?php if(session('managedept')!=0){ ?>
                           <a href="<?php echo url(); ?>flex/deleteemployee/?id=".$row->emp_id; ?>"   title="Terminate Contract" class="icon-2 info-tooltip"><font color="red"> <i class="fa fa-times"></i></font></a>&nbsp;&nbsp; <?php } ?>

                            <a class="tooltip-demo" data-placement="top" title="Edit Contract"  href="<?php echo url(); ?>flex/editemployee/?id=".$row->emp_id; ?>"><font color="#5cb85c"> <i class="fa fa-edit"></i></font></a></td>
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