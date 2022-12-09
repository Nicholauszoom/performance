@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
  <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
  <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php

  foreach ($appreciated as $row) {
    $name = $row->NAME;
    $id = $row->empID;
    $position = $row->POSITION;
    $department = $row->DEPARTMENT;
    $description = $row->description;
    $date = $row->date_apprd;
    $photo = $row->photo;
  }

  foreach ($overview as $row) {
    $employees = $row->emp_count;
    $males = $row->males;
    $females = $row->females;
    $inactive = $row->inactive;
    $expatriate = $row->expatriate;
    $local_employee = $row->local_employee;
  }

  foreach ($taskline as $row) {
    $all = $row->ALL_TASKS;
    $completed = $row->COMPLETED;
  }


  foreach ($taskstaff as $row) {
    $allstaff = $row->ALL_TASKSTAFF;
    $allstaff_completed = $row->COMPLETEDSTAFF;
  }

  foreach ($payroll_totals as $row) {
    $salary = $row->salary;
    $net_less = $row->takehome_less;
    $pension_employee = $row->pension_employee;
    $pension_employer = $row->pension_employer;

    $medical_employee = $row->medical_employee;
    $medical_employer = $row->medical_employer;
    $sdl = $row->sdl;
    $wcf = $row->wcf;
    $allowances = $row->allowances;
    $taxdue = $row->taxdue;
    $meals = $row->meals;
  }
  foreach ($total_loans as $key) {
    $paid = $key->paid;
    $remained = $key->remained;
  }

  foreach ($take_home as $row) {
    $net = $row->takehome - $arrears;
  }


if(session('pass_age')>89 || 90-session('pass_age')==0 || 90-session('pass_age') < 0){
  redirect('cipay/login_info');
}


?>

        <!-- page content -->
        <div class="right_col" role="main">

            <div class="row top_tiles">
              <div class="page-title">
                <div class="title_right" >
                  <h4>HOME
                      <!-- <?php if( session('manage_strat') != ''){ ?>
                        <a href ="<?php echo  url(''); ?>/flex/performance/strategy_dashboard" style="float: right;"><button type="button" class="btn btn-primary btn-xs">
                        Switch to Performance Dasshboard
                        </button></a> <?php } ?> -->
                  </h4>
                      <h6> <p   <?php if(session('pass_age')>84){?> style="color:red" <?php } ?>>Password Expires in <?php echo (90 - session('pass_age')); ?> Days</p> </h6>
                </div>
              </div>
            </div>

            <div class="row top_tiles">
            {{-- <!-- Appreciation  -->
                      <!-- <div class="col-md-5 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Current Employee Of the Month</i></h4>
                            <div class="right col-xs-5 text-center">
                              <img src="<?php echo url('uploads/userprofile/').$photo; ?>" alt="" class="img-circle img-responsive">
                            </div>
                            <div class="left col-xs-7">
                              <h2><?php echo $name; ?></h2>
                              <p><strong>Appreciated On: </strong><?php
                              $datewell = explode("-",$date);
                                  $mm = $datewell[1];
                                  $dd = $datewell[2];
                                  $yyyy = $datewell[0];
                                  $clear_date = $dd."-".$mm."-".$yyyy;
                                  echo $clear_date; ?> </p>
                              <p><strong>Position: </strong><?php echo $position; ?> </p>
                              <p><strong>Department: </strong><?php echo $department; ?> </p>
                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                              <a href="<?php echo  url(''); ?>/flex/appreciation"><button type="button" class="btn btn-primary btn-xs">
                                <i class="fa fa-tasks"> </i> View Task Description
                              </button></a>
                          </div>
                        </div>
                      </div> -->
                      <!-- Appreciation --> --}}

                 <div class="<?php if(session('vw_emp_sum')) { ?> col-md-8 <?php }else{ ?> col-md-12 <?php }?>">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Welcome to Fléx Performance!  <b><?php echo session('fname')." ".session('lname'); ?> </b> </h3>
                    <div class="clearfix"></div>
                  </div>
                  <div class="row x_content">
                        <p>To navigate through the system use the menu on left. To logout check the menu on top right.</p>
                        <p>For further help,  contact the system Vendor.</p>
                  </div>
                </div>
              </div>

              <?php if(session('vw_emp_sum')) { ?>

              <div class="animated flipInY col-lg-4 col-md-3 col-sm-6 col-xs-12">
              {{-- <?php //if(session('regemp')!='' || session('line')!='' ){ ?><a href="<?php echo  url(''); ?>/flex/employee"><?php //} ?> --}}
                <div class="tile-stats">
<!--                  <div class="icon"><i class="fa fa-users"></i></div>-->
                  <div class="count"><?php echo $employees; ?></div>

                  <h2 style="margin-left: 3%">Active Employees</h2>
                  <p><b>Male</b> <?php echo $males; ?></p>
                  <p><b>Female</b> <?php echo $females; ?>.</p>
                  <p><b>Local Employees</b> <?php echo $local_employee; ?></p>
                  <p><b>Expatriates</b> <?php echo $expatriate; ?></p>
                </div></a>
              </div>



              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Current Payroll Summary(<?php echo date("F, Y", strtotime($payroll_date)); ?>)</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="row x_content">

                    <h5><?php echo number_format($salary,2); ?>
                      <b class="col-md-4">Basic Salaries:</b></h5>
                      <?php if($allowances > 0 ){ ?> <b class="col-md-4">Allowances:</b>
                          <h5><?php echo number_format($allowances,2); ?></h5> <?php } ?>

<!--                      <h5>--><?php //echo number_format($allowances,2); ?>
<!--                    <b class="col-md-4">Allowances:</b></h5>-->

                      <h5><?php echo number_format(($salary+$allowances),2); ?>
                          <b class="col-md-4">Gross Salaries (Total):</b></h5>

                      <h5><?php echo number_format($net_total,2); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="col-md-4">Net Salary:</b> &nbsp;&nbsp;&nbsp;
                    <?php if($arrears > 0 ){ ?> Arrears:&nbsp;&nbsp;&nbsp; <b><?php echo number_format($arrears,2); ?></b> <?php } ?>
                      </h5>
                      <h5> <?php echo number_format(($pension_employer+$pension_employee),2); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="col-md-4">Total Pension:</b></h5>

                      <?php if($medical_employer+$medical_employee > 0 ){ ?> <b class="col-md-4">Total Medical:</b>
                          <h5><?php echo number_format(($medical_employer+$medical_employee),2); ?></h5> <?php } ?>

<!--                      <h5>--><?php //echo number_format(($medical_employer+$medical_employee),2); ?>
<!--                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="col-md-4"> Total Medical:</b></h5>-->

                      <h5> <?php echo number_format($taxdue,2); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="col-md-4">Taxdue (PAYE):</b></h5>
                      <h5><?php echo number_format(($salary+$allowances)*0.01,2); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="col-md-4"> WCF: </b></h5>
                      <h5><?php echo number_format($sdl,2); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="col-md-4"> SDL:</b></h5>

                      <?php if($total_heslb > 0 ){ ?> <b class="col-md-4">HESLB:</b>
                          <h5><?php echo number_format($total_heslb,2); ?></h5> <?php } ?>

                      <b class="col-md-4">Total Employees Cost:</b>
                          <h5><?php echo number_format(($salary+$allowances) + $sdl
                                  +(($salary+$allowances)*0.01) + $pension_employer + $medical_employer,
                                  2); ?></h5>

<!--                      <h5> --><?php //echo number_format($total_heslb,2); ?>
<!--                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="col-md-4"> HESLB:</b></h5>                 -->

                  </div>
                  <!-- <div class="x_content">
                    <article class="media event">
                      <div class="media-body">
                        <h4><b>TOTAL Cost: </b><span class="btn btn-info">999,345,500,349.00</span>/=</h4>
                        <h4><b>Gross Pay: </b>21,145,000,500.00/=</h4>
                        <h4><b>Pension: </b>999,345,500,349.00/=</h4>
                        <h4><b>PAYE: </b>999,345,500,349.00/=</h4>
                        <h4><b>SDL: </b>999,345,500,349.00/=</h4>
                        <h4><b>WCF: </b>999,345,500,349.00/=</h4>
                        <h4><b>Health Insurance: </b>999,345,500,349.00/=</h4>
                        <h4><b>Others: </b>999,345,500,349.00/=</h4>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Three Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                  </div> -->
                </div>
              </div>

                  <div class="col-md-12">
                      <div class="x_panel">
                          <div class="x_title">
                              <h2>Payroll Reconciliation Summary (Current & Previous)</h2>
                              <div class="clearfix"></div>
                          </div>
                          <div class="row x_content">
                              <?php
                              foreach ($s_net_c as $c){
                                  $s_net_c_ = $c->takehome;
                              }

                              foreach ($s_net_p as $p){
                                  $s_net_p_ = $p->takehome;
                              }

                              foreach ($v_net_c as $vc){
                                  $v_net_c_ = $vc->takehome;
                              }

                              foreach ($v_net_p as $vp){
                                  $v_net_p_ = $vp->takehome;
                              }

                              ?>

                              <?php
                              $staff = 0;
                              $volunteer = 0;

                              $staff_p = 0;
                              $volunteer_p = 0;

                              foreach ($s_staff as $s){
                                  $staff++;
                              }

                              foreach ($s_staff_p as $sp){
                                  $staff_p++;
                              }

                              foreach ($v_staff as $v){
                                  $volunteer++;
                              }

                              foreach ($v_staff_p as $vp){
                                  $volunteer_p++;
                              }

                              ?>

                              <table class="table table-striped table-bordered" style="width:100%">
                                  <tr>
                                      <th></th>
                                      <th><b>Contract type</b></th>
                                      <th class="text-right"><b>Current</b></th>
                                      <th class="text-right"><b>Previous</b></th>
                                      <th class="text-right"><b>Movement</b></th>
                                  </tr>
                                  <tr>
                                      <td rowspan="2"><b>Gross Salary</b></td>
                                      <td><b>Staff</b></td>
                                      <td align="right"><?php echo number_format($s_gross_c,2); ?></td>
                                      <td align="right"><?php echo number_format($s_gross_p,2); ?></td>
                                      <td align="right"><?php echo number_format($s_gross_c-$s_gross_p,2) ?></td>
                                  </tr>
                                  <tr>
                                      <td><b>Volunteer</b></td>
                                      <td align="right"><?php echo number_format($v_gross_c,2); ?></td>
                                      <td align="right"><?php echo number_format($v_gross_p,2); ?></td>
                                      <td align="right"><?php echo number_format($v_gross_c-$v_gross_p,2)?></td>
                                  </tr>
                                  <tr>
                                      <td rowspan="2"><b>Net Salary</b></td>
                                      <td><b>Staff</b></td>
                                      <td align="right"><?php echo number_format($s_net_c_,2); ?></td>
                                      <td align="right"><?php echo number_format($s_net_p_,2); ?></td>
                                      <td align="right"><?php echo number_format($s_net_c_-$s_net_p_,2)?></td>
                                  </tr>
                                  <tr>
                                      <td><b>Volunteer</b></td>
                                      <td align="right"><?php echo number_format($v_net_c_,2); ?></td>
                                      <td align="right"><?php echo number_format($v_net_p_,2); ?></td>
                                      <td align="right"><?php echo number_format($v_net_c_-$v_net_p_,2)?></td>
                                  </tr>
                                  <tr>
                                      <td rowspan="2"><b>Head Count</b></td>
                                      <td><b>Staff</b></td>
                                      <td align="right"><?php echo $staff; ?></td>
                                      <td align="right"><?php echo $staff_p; ?></td>
                                      <td align="right"><?php echo $staff-$staff_p?></td>
                                  </tr>
                                  <tr>
                                      <td><b>Volunteer</b></td>
                                      <td align="right"><?php echo $volunteer; ?></td>
                                      <td align="right"><?php echo $volunteer_p; ?></td>
                                      <td align="right"><?php echo $volunteer-$volunteer_p?></td>
                                  </tr>
                              </table>

                          </div>
                      </div>
                  </div>

              <?php } ?>



              <!-- <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Notification Panel</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <article class="media event">
                      <div class="media-body">
                        <a class="title" href="#">Task <span class="badge bg-red">1 </span></a>
                      </div>
                    </article>
                    <article class="media event">
                      <div class="media-body">
                        <a class="title" href="#">Leave <span class="badge bg-red">1 </span></a>
                      </div>
                    </article>
                    <article class="media event">
                      <div class="media-body">
                        <a class="title" href="#">Salary Advance (Loans) <span class="badge bg-red">1 </span></a>
                      </div>
                    </article>
                    <article class="media event">
                      <div class="media-body">
                        <a class="title" href="#">Imprest <span class="badge bg-red">1 </span></a>
                      </div>
                    </article>
                    <article class="media event">
                      <div class="media-body">
                        <a class="title" href="#">Activation and Deactivation <span class="badge bg-red">1 </span></a>
                      </div>
                    </article>s
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Three Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                  </div>
                </div>
              </div> -->

              <?php if( session('manage_strat') != ''){ ?>
              <!-- <div class="col-md-3 col-xs-12 widget widget_tally_box">
                <div class="x_panel ui-ribbon-container">
                  <div class="ui-ribbon-wrapper">
                    <div class="ui-ribbon">
                      <small><?php echo $monthly;?>% Monthly </small>
                    </div>
                  </div>
                  <div class="x_title">
                    <h2>Strategic Plans</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div style="text-align: center; margin-bottom: 17px">
                      <span class="chart" data-percent="<?php echo number_format($strategyProgress,0);?>">
                                          <span class="percent"></span>
                      </span>
                    </div>

                    <h3 class="name_title">Performance</h3>
                    <!-- <article class="media event">
                      <a class="pull-left date">
                        <p style="font-size: 18px" class="day">23%</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Outcomes Completed</a>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p style="font-size: 18px" class="day">23%</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Outputs Completed</a>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p style="font-size: 18px" class="day">23%</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Tasks Completed</a>
                      </div>
                    </article> -->
<!--
                  </div>
                </div>
              </div>  -->
              <?php } ?>


            </div>

            <div class="row">


              <!-- <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Outputs and Outcomes</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Outcomes</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.<span class="badge bg-red">1 </span></p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Outputs</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                  </div>
                </div>
              </div> -->

            </div>

          </div>
        </div>
        <!-- /page content -->

       <?php
        ?>


 @endsection

 @push('footer-script')

{{-- <script src="<?php echo  url('');?>style/jquery/jquery.easypiechart.min.js"></script> --}}

<script>
  $(function() {
    $('.chart').easyPieChart({
      easing: 'easeOutElastic',
      delay: 3000,
      barColor: '#26B99A',
      trackColor: '#fff',
      scaleColor: false,
      lineWidth: 20,
      trackWidth: 16,
      lineCap: 'butt',
      onStep: function(from, to, percent) {
        $(this.el).find('.percent').text(Math.round(percent));
      }
    });
  });
</script>
 @endpush
