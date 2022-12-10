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
                <h3>Attendance </h3>
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
                    <form id="printAttendance" method ="post" action="<?php echo  url(''); ?>/flex/reports/attendance" target="_blank" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3  col-xs-6" >Employee Attendance ON</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <!--<div class="col-sm-6">-->
                          <div class="input-group">
                            <input type="text" name="start" class="form-control col-xs-12 has-feedback-left" id="single_cal3"  aria-describedby="inputSuccess2Status">
                            <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                            <span class="input-group-btn">
                              <button name="print"  class="btn btn-primary">PRINT</button>
                            </span>
                          </div>
                          <!--</div>-->
                        </div>
                      </div>
                      </form>
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
                  <div class="x_content" id = "result">

                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th><b>S/N</b></th>
                          <th><b>Name</b></th>
                          <th><b>Department</b></th>
                          <th><b>Sign IN</b></th>
                          <th><b>Sign OUT</b></th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php

                          foreach ($attendee as $row) { ?>
                          <tr >
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
                            <td><?php echo $row->time_in; ?></td>
                            <td><?php  echo  $row->time_out; ?></td>
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



<?php 
      @include("app/includes/dropdown")

      <script>

      function testing() {
        console.log('adfsd');
        // notify('Sale list empty', 'top', 'right', 'success');

      }

      function notify(message, from, align, type) {
        $.growl({
            message: message,
            url: ''
        }, {
            element: 'body',
            type: type,
            allow_dismiss: true,
            placement: {
                from: from,
                align: align
            },
            offset: {
                x: 30,
                y: 30
            },
            spacing: 10,
            z_index: 999999,
            delay: 2500,
            timer: 1000,
            url_target: '_blank',
            mouse_over: false,

            icon_type: 'class',
            template: '<div data-growl="container" class="alert" role="alert">' +
                '<button type="button" class="close" data-growl="dismiss">' +
                '<span aria-hidden="true">&times;</span>' +
                '<span class="sr-only">Close</span>' +
                '</button>' +
                '<span data-growl="icon"></span>' +
                '<span data-growl="title"></span>' +
                '<span data-growl="message"></span>' +
                '<a href="#!" data-growl="url"></a>' +
                '</div>'
        });
      }



      </script>

 @endsection