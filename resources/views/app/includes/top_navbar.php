

<?php 

    $CI_Model = get_instance();
    $CI_Model->load->model('attendance_model');
    $attendanceState = $CI_Model->attendance_model->checkAttendanceState(session('emp_id'), date('Y-m-d'));
    if($attendanceState){
      foreach($attendanceState as $value){ $state = 1; $duestate = $value->state; }
  }
  else $state = 0;

?>

<?php 
  if(session('appr_leave') || session('mng_emp') || session('recom_paym') || session('appr_paym')){

  $CI_Model = get_instance();
  $CI_Model->load->model('payroll_model');
  $CI_Model->load->model('flexperformance_model');
  $CI_Model->load->model('imprest_model');

  

  if(session('recom_paym')){
    $incs = $CI_Model->payroll_model->waitingbonusesRecom();
  }
  if(session('appr_paym')){
    $incs = $CI_Model->payroll_model->waitingbonusesAppr();
  }
  if(!isset($incs)){
    $incs = [];
  }
  

  if(session('mng_emp')){
    $salary = $CI_Model->flexperformance_model->waitingsalary_advance_hr();
  }
  if(session('recom_paym')){
    $salary = $CI_Model->flexperformance_model->waitingsalary_advance_fin();
  }
  if(session('appr_paym')){
    $salary = $CI_Model->flexperformance_model->waitingsalary_advance_appr();
  }
  if(!isset($salary)){
    $salary = [];
  }


  if(session('mng_emp')){
    $imprest = $CI_Model->imprest_model->waitingImprests_hr(session('emp_id'));
  }
  if(session('recom_paym')){
    $imprest = $CI_Model->imprest_model->waitingImprests_fin(session('emp_id'));
  }
  if(session('appr_paym')){
    $imprest = $CI_Model->imprest_model->waitingImprests_appr(session('emp_id'));
  }
  if(!isset($imprest)){
    $imprest = [];
  }


  if(session('appr_leave')){
    $overtimes = $CI_Model->flexperformance_model->waitingOvertimes_line(session('emp_id'));
  }
  if(session('mng_emp')){
    $overtimes = $CI_Model->flexperformance_model->waitingOvertimes_hr();
  }
  if(session('recom_paym')){
    $overtimes = $CI_Model->flexperformance_model->waitingOvertimes_fin();
  }
  if(session('appr_paym')){
    $overtimes = $CI_Model->flexperformance_model->waitingOvertimes_appr();
  }
  if(!isset($overtimes)){
    $overtimes= [];
  }
 

  if(session('recom_paym')){
    $notifications = $CI_Model->payroll_model->waitingpayroll_fin();
  }
  if(session('appr_paym')){
    $notifications = $CI_Model->payroll_model->waitingpayroll_appr();
  }
  if(!isset($notifications)){
    $notifications = [];
  }

  

}
  ?>
    <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              
              <?php //echo $state;  ?>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url('uploads/userprofile/').session('photo'); ?>" alt=""><?php echo session('fname')." ".session('lname'); ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo url(); ?>flex/userprofile/?id=".session('emp_id'); ?>"> Profile</a></li>
                    <li>
                      <a href="<?php echo url(); ?>flex/login_info"; ?>">
                        <span>Account Setting</span>
                      </a>
                    </li> 
                    <li>
                        <a>
                          <?php  if ($state==1 && $duestate == 1 ){ ?>

                        <span id = "resultAttendance" ><form method ="post"  id = "attendance" > <input type = "text" hidden name ="state" value ="due_out">  <button class="btn btn-round btn-default">Attended <span class="badge bg-green"><i class="fa fa-check-square-o"></i></span></button></form></span>

                        <?php } elseif ($state==0){ ?>

                        <span id = "resultAttendance" ><form method ="post"  id = "attendance" > <input type="text" hidden name ='state' value ="due_in"> <button class="btn btn-round btn-default"> Not Attended <span class="badge bg-orange"><i class="fa fa-times"></i></span></button></form></span>

                         <?php } elseif ($state==1 && $duestate == 2){ ?>

                        <span><button class="btn btn-round btn-default">Attended Out <span class="badge bg-grey"><i class="fa fa-check"></i></span></button></span>

                      <?php } ?>
                      </a>
                    </li> 
                    <li><a href="<?php echo url(); ?>flex/base_controller/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>

                  </ul>
                </li>

                
<!--                 
               <?php  if (session('mng_emp')){ ?>
                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-suitcase"></i>
                    <span class="badge bg-red">*</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                   <?php  if (session('mng_emp')){ ?>
                    <li>
                      <a href="<?php echo url(); ?>flex/contract_expire">
                        <span class="image">
                    <i class="fa fa-suitcase"></i></span>
                        <span>
                          <span><b>Contracts</b></span>
                        </span>
                        <span class="message">
                        <div id = "expire_contracts"> </div>
                          Contracts About to Expire
                        </span>
                      </a>
                    </li>

                    <li>
                      <a href="<?php echo url(); ?>flex/retire">
                        <span class="image">
                    <i class="fa fa-calendar"></i></span>
                        <span>
                          <span><b>Retire</b></span>
                        </span>
                        <span class="message">
                        <div id = "retire"> </div>
                          Employee About to Retire
                        </span>
                      </a>
                    </li>
                    <?php } if(session('mng_emp')){ ?>
                    <li>
                      <a href="<?php echo url(); ?>flex/inactive_employee">
                        <span class="image">
                    <i class="fa fa-calendar"></i></span>
                        <span>
                          <span><b>Activation & Deactivation</b></span>
                        </span>
                        <span class="message">
                        <div id = "emp_activation"> </div>
                          Employee to be Activated or Deactivated
                        </span>
                      </a>
                    </li>
                    <?php } ?>
                  </ul>
                </li>
                <?php } ?>
 -->

                    
            <!--All Alerts-->
                <?php   if(session('appr_leave') || session('mng_emp') || session('recom_paym') || session('appr_paym')){ ?>
    
                <li role="presentation" class="dropdown">
                  <a  href="javascript:;" class="dropdown-toggle info-number" title="Notifications" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <div id = "allnotifications"> </div>
                    <?php if(!(count($notifications)+count($incs)+count($overtimes)+count($imprest)+count($salary))==0) {?>
                    <span class="badge bg-red"><?php echo (count($notifications)+count($incs)+count($salary)+count($overtimes)+count($imprest)) ?></span>
                    <?php } ?>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">


                    <?php
                        if(count($imprest)>0) { ?>
                    <li>
                      <a href="<?php echo url(); ?>flex/approved_financial_payments">
                        <span class="image">
                      <i class="fa fa-money"></i></span>
                        <span>
                          <span><b><?php echo(count($imprest)." Imprest"); ?></b></span>
                        </span>
                        <span class="message">             
                        <div id = "loan_notification"> </div>
                          <?php echo "You have pending  imprest to approve" ?>
                        </span>
                      </a>
                    </li> 
                    <?php } ?>

                    <?php
                        if(count($notifications)>0) { ?>
                    <li>
                      <a href="<?php echo url(); ?>flex/approved_financial_payments">
                        <span class="image">
                      <i class="fa fa-money"></i></span>
                        <span>
                          <span><b><?php echo(count($notifications)." Payroll"); ?></b></span>
                        </span>
                        <span class="message">             
                        <div id = "loan_notification"> </div>
                          <?php echo "You have pending  Payroll to approve" ?>
                        </span>
                      </a>
                    </li> 
                    <?php } ?>
                    <?php
                        if(count($overtimes)>0) { ?>
                    <li>
                    <?php   if(session('appr_leave') && !session('appr_leave') || !session('mng_emp')){ ?>
                      <a href="<?php echo url(); ?>flex/overtime">
                      <?php }else{ ?>
                      <a href="<?php echo url(); ?>flex/approved_financial_payments">
                      <?php } ?>
                        <span class="image">
                      <i class="fa fa-money"></i></span>
                        <span>
                          <span><b><?php echo(count($overtimes)." Overtime"); ?></b></span>
                        </span>
                        <span class="message">             
                        <div id = "loan_notification"> </div>
                          <?php echo "You have pending  overtime to approve" ?>
                        </span>
                      </a>
                    </li> 
                    <?php } ?>

                    <?php
                        if(count($incs)>0) { ?>
                    <li>
                      <a href="<?php echo url(); ?>flex/approved_financial_payments">
                        <span class="image">
                      <i class="fa fa-money"></i></span>
                        <span>
                          <span><b><?php echo(count($incs)." Incentive"); ?></b></span>
                        </span>
                        <span class="message">             
                        <div id = "loan_notification"> </div>
                          <?php echo "You have pending  incentives to approve" ?>
                        </span>
                      </a>
                    </li> 
                    <?php } ?>

                    <?php
                        if(count($salary)>0) { ?>
                    <li>
                      <a href="<?php echo url(); ?>flex/approved_financial_payments">
                        <span class="image">
                      <i class="fa fa-money"></i></span>
                        <span>
                          <span><b><?php echo(count($salary)." Salary Advance"); ?></b></span>
                        </span>
                        <span class="message">             
                        <div id = "loan_notification"> </div>
                          <?php echo "You have pending  salary advance to approve" ?>
                        </span>
                      </a>
                    </li> 
                    <?php } ?>




                  </ul>
                </li>
                <?php } ?>
              </ul>
            </nav>
          </div>
        </div>
  <!-- /top navigation -->
      