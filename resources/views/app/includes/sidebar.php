<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo  url(''); ?>/flex/home" class="site_title">

              <!-- <i class=""> -->
              <!--<img height="100px" width="100px" src = "<?php echo  url('').session('logo'); ?>"/><!-- </i> -->
              <!--<span><i></i></span>-->
              </a>
            </div>

            <div class="clearfix"></div>

            <br />
    <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>MENU</h3>
                <ul class="nav side-menu"> 
                  <li><a href="<?php echo  url(''); ?>/flex/home" ><i class="fa fa-home"></i> Dashboard </a>
                  </li>
                  <?php if(session('password_set') =="0" && session("pass_age")<90){ ?>

                    
                    <li> <a href="<?php echo  url(''); ?>/flex/project/" ><i class="fa fa-tasks"></i> Projects </a> </li>


                    <?php if(session('mng_paym')|| session('recom_paym')||session('appr_paym')){ ?>
                  <li><a><i class="fa fa-calendar"></i> Payroll Management
                  <span class="fa fa-chevron-down">
                  </a>
                  <ul class="nav child_menu">
                      <li><a href="<?php echo  url(''); ?>/flex/payroll/payroll" > Payroll </a></li>
                      <?php if(session('mng_paym')){ ?>
                      <li><a href="<?php echo  url(''); ?>/flex/payroll/employee_payslip" > Payslip </a></li>
                          <li><a href="<?php echo  url(''); ?>/flex/payroll/comission_bonus" >Incentives</a></li>
                          <li><a href="<?php echo  url(''); ?>/flex/payroll/partial_payment" >Partial Payment</a></li>
                      <?php } ?>
                      <li><a href="<?php echo  url(''); ?>/flex/approved_financial_payments" >Pending Payments </a></li>
                      <?php if(session('mng_stat_rpt')){ ?>
                          <li><a href="<?php echo  url(''); ?>/flex/financial_reports" >Statutory Reports </a></li>
                          <li><a href="<?php echo  url(''); ?>/flex/organisation_reports" >Organisation Reports </a></li>
                      <?php } ?>
                      <?php if(session('mng_paym')){ ?>
                          <li><a href="<?php echo  url(''); ?>/flex/payroll/salary_calculator" > Salary Calculator </a></li>
                      <?php } ?>
                  </ul>
                  </li>
                <?php } ?>




                  <li><a ><i class="fa fa-users"></i> Workforce Management <span class="fa fa-chevron-down">
                  </a>
                  <ul class="nav child_menu">

                      <?php if(session('mng_emp') || session('vw_emp') || session('appr_emp') || session('mng_roles_grp')){  ?> 
                        <li><a href="<?php echo  url(''); ?>/flex/employee">Active Employees</a></li>
                        <?php if(session('mng_emp') || session('appr_emp')){  ?>
                      <li><a href="<?php echo  url(''); ?>/flex/inactive_employee">Suspended Employees</a></li>
                      <?php } } ?>
                      <li><a href="<?php echo  url(''); ?>/flex/overtime">Overtime </a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/imprest/imprest">Imprest</a></li>
                      <!-- <li><a href="<?php echo  url(''); ?>/flex/grievances"> Grievances </a></li>  -->
                      <!-- <li><a href="<?php echo  url(''); ?>/flex/training_application">Learning &amp; Devlopment</a></li> -->
                      <?php if(session('mng_emp')){ ?>
                          <li><a href="<?php echo  url(''); ?>/flex/transfers">Employee Approval</a></li>
<!--                          <li><a href="--><?php //echo  url(''); ?><!--flex/employeeReport">Employee Report</a></li>-->
                      <?php } ?>
                    </ul>
                  </li>

                 

                  </li>
                   <li><a><i  class="fa fa-calendar"></i> Leave and Attendance
                  <span class="fa fa-chevron-down">
                  </a>
                  <ul class="nav child_menu">
                  <?php if( session('mng_attend')){ ?>
                      <li><a href="<?php echo  url(''); ?>/flex/attendance/attendees">Attendance</a></li> 
                  <?php } ?>
                      <li><a href="<?php echo  url(''); ?>/flex/attendance/leave">Leave Applications</a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/attendance/leavereport">Leave Reports</a></li>
                    </ul>
                  </li>   
                   <li><a><i  class="fa fa-money"></i> Salary Advance
                  <span class="fa fa-chevron-down">
                  </a>
                  <ul class="nav child_menu">
                      <li><a href="<?php echo  url(''); ?>/flex/salary_advance">Applications</a></li> 
                      <!-- <li><a href="<?php echo  url(''); ?>/flex/confirmed_loans">Approved Applications</a></li> -->
                    </ul>
                  </li> 
                   <li><a><i  class="fa fa-cubes"></i> Organisation
                  <span class="fa fa-chevron-down">
                  </a>
                  <ul class="nav child_menu">
                  <li><a href="<?php echo  url(''); ?>/flex/costCenter">Cost Center </a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/department">Departments </a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/branch">Company Branches </a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/position">Positions</a></li> 
                      <?php if( session('mng_emp')){ ?>
                      <li><a href="<?php echo  url(''); ?>/flex/contract">Employee Contracts</a></li>
                      <?php } ?>
                      <!-- <li><a href="<?php echo  url(''); ?>/flex/accountCoding">Account Coding</a></li> -->
                      <li><a href="<?php echo  url(''); ?>/flex/organization_level">Organisation Levels </a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/organization_structure">Organisation Structure</a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/accounting_coding">Accounting Coding</a></li>

                  </ul>
                  </li>
                  
                
                  
                  <!-- <li><a><i class="fa fa-dashboard"></i> Performance M&E
                  <span class="fa fa-chevron-down">
                  </a>
                  <ul class="nav child_menu">
                       <?php if( session('manage_strat') != ''){ ?>
                      <li><a href="<?php echo  url(''); ?>/flex/performance/strategy_dashboard"> Dashboard </a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/performance/strategy"> Strategies </a></li>                      
                      <li><a href="<?php echo  url(''); ?>/flex/performance/outcome"></i> Outcomes </a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/performance/output"></i> Outputs </a></li>
                      <?php } ?>
                      <li><a href="<?php echo  url(''); ?>/flex/performance/task"></i> Tasks </a></li>
                        
                      <li><a href="<?php echo  url(''); ?>/flex/performance/paused_task"></i> Paused Tasks </a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/performance/adhoc_task"></i> Adhoc Tasks </a></li> 
                      <li><a href="<?php echo  url(''); ?>/flex/performance/funder"></i> Funders  </a></li> 
                     <?php if( session('manage_strat') != ''){ ?>
                      <li><a href="<?php echo  url(''); ?>/flex/performance/productivity"> Performance Reports </a></li>
                      <?php } ?>
                    </ul>
                  </li> -->
                  <?php if( session('vw_settings')){ ?>
                  <li><a><i class="fa fa-gears"></i> Settings <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php if( session('mng_roles_grp')){ ?>
                      <li><a href="<?php echo  url(''); ?>/flex/role">Roles and Groups</a></li>
                      <?php } ?>
                      <li><a href="<?php echo  url(''); ?>/flex/allowance">Allowances</a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/allowance_overtime">Overtime</a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/statutory_deductions">Statutory Deductions</a></li>
                      <li><a href="<?php echo  url(''); ?>/flex/non_statutory_deductions">Non-Statutory Deductions</a></li>
                 
                      <?php if( session('mng_bank_info')){ ?>
                      <li><a href="<?php echo  url(''); ?>/flex/bank">Banking Information</a></li>
                      
                      <?php } if( session('mng_audit')){ ?>
                        <li><a href="<?php echo  url(''); ?>/flex/audit_logs">Audit Trail</a></li>
                      <?php } ?>
                      <!-- <li><a href="<?php echo  url(''); ?>/flex/performance/tasksettings">Task Settings</a></li> 
                       <?php //} ?>-->
                        <li><a href="<?php echo  url(''); ?>/flex/performance/funder"></i> Funders  </a></li>
                        <li><a href="<?php echo  url(''); ?>/flex/nationality">Nationality</a></li>
                        <li><a href="<?php echo  url(''); ?>/flex/payroll/mailConfiguration"></i> Mail Configuration  </a></li>

                    </ul>
                  </li> 
                  <?php } ?>
                     <?php } ?> <!-- pass set -->
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->
          </div>
        </div>
