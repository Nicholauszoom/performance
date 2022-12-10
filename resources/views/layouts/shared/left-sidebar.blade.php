<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg bg-main-nav">

    <div class="sidebar-content">

        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto text-muted"></h5>

                <div>
                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>


        <div class="sidebar-section">
            <ul class="nav nav-sidebar main-link" data-nav-type="accordion">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : null }}">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/flex/project/') }}">
                        <i class="ph-hard-drives"></i>
                        <span>Projects</span>
                    </a>
                </li>


                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-users-three"></i>
                        <span>Workforce Management</span>
                    </a>

                    <ul class="nav-group-sub collapse">
                        @if (session('mng_emp') || session('vw_emp') || session('appr_emp') || session('mng_roles_grp'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/flex/employee') }}">Active Employees</a>
                            </li>
                        @endif

                        @if (session('mng_emp') || session('appr_emp'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/flex/inactive_employee') }}">Suspended Employees</a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/flex/overtime') }}">Overtime </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/flex/imprest/imprest') }}">Imprest</a>
                        </li>

                        @if (session('mng_emp'))
                            <li class="nav-item"><a class="nav-link" href="{{ url('/flex/transfers') }}">Employee Approval</a></li>
                        @endif
                    </ul>
                </li>


                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-calendar-check"></i>
                        <span> Leave and Attendance</span>
                    </a>

                    <ul class="nav-group-sub collapse">
                        @if (session('mng_attend'))
                            <li class="nav-item"><a class="nav-link" href="{{ url('/flex/attendance/attendees') }}">Attendance</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/attendance/leave') }}">Leave Applications</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/attendance/leavereport') }}">Leave Reports</a></li>
                    </ul>
                </li>


                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-bank"></i>
                        <span> Salary Advance</span>
                    </a>

                    <ul class="nav-group-sub collapse">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/salary_advance') }}">Applications</a></li>
                    </ul>
                </li>


                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-calculator"></i>
                        <span>Payroll Management</span>
                    </a>

                    <ul class="nav-group-sub collapse">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/payroll/payroll') }}"> Payroll </a></li>
                        @if (session('mng_paym'))
                            <li class="nav-item"><a class="nav-link" href="{{ url('/flex/payroll/employee_payslip') }}"> Payslip </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/flex/payroll/comission_bonus') }}">Incentives</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/flex/payroll/partial_payment') }}">Partial Payment</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/approved_financial_payments') }}">Pending Payments </a></li>
                        @if (session('mng_stat_rpt'))
                            <li class="nav-item"><a class="nav-link" href="{{ url('/flex/financial_reports') }}">Statutory Reports </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('/flex/organisation_reports') }}">Organisation Reports </a></li>
                        @endif
                        @if (session('mng_paym'))
                            <li class="nav-item"><a class="nav-link" href="{{ url('/flex/payroll/salary_calculator') }}"> Salary Calculator </a></li>
                        @endif
                    </ul>
                </li>


                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-buildings"></i>
                        <span>Organisation</span>
                    </a>
                    <ul class="nav-group-sub collapse">

                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/costCenter') }}">Cost Center </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/department') }}">Departments </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/branch') }}">Company Branches </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/position') }}">Positions</a></li>
                        @if (session('mng_emp'))
                            <li class="nav-item"><a class="nav-link" href="/flex/contract">Employee Contracts</a></li>
                        @endif
                        {{-- <li  class="nav-item"><a class="nav-link"  href="{{ url('/flex/accountCoding') }}">Account Coding</a></li> --}}
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/organization_level') }}">Organisation Levels </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/organization_structure') }}">Organisation Structure</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/accounting_coding') }}">Accounting Coding</a></li>

                    </ul>
                </li>


                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-note"></i>
                        <span>Reports</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                        {{-- <li class="nav-item">
                            <a href="{{ route('cipay.financial_reports') }}" class="nav-link {{ request()->routeIs('cipay.financial_reports') ? 'active' : null  }}">
                                Statutory Reports
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('cipay.organisation_reports') }}" class="nav-link {{ request()->routeIs('cipay.organisation_reports') ? 'active' : null  }}">
                                Organisation Reports
                            </a>
                        </li> --}}
                    </ul>
                </li>


                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-gear-six"></i>
                        <span>Settings</span>
                    </a>

                    <ul class="nav-group-sub collapse">
                        @if (session('mng_roles_grp'))
                            <li class="nav-item"><a class="nav-link" href="{{ url('/flex/role') }}">Roles and Groups</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/allowance') }}">Allowances</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/allowance_overtime') }}">Overtime</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/statutory_deductions') }}">Statutory Deductions</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/non_statutory_deductions') }}">Non-Statutory Deductions</a></li>

                        @if (session('mng_bank_info'))
                            <li class="nav-item"><a class="nav-link" href="{{ url('/flex/bank') }}">Banking Information</a></li>
                        @endif

                        @if (session('mng_audit'))
                            <li class="nav-item"><a class="nav-link" href="{{ url('/flex/audit_logs') }}">Audit Trail</a></li>
                        @endif

                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/performance/funder') }}"></i> Funders </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/nationality') }}">Nationality</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/flex/payroll/mailConfiguration') }}"></i> Mail Configuration </a></li>
                    </ul>
                </li>






                {{-- routes Pending Model --}}
                {{-- <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-briefcase"></i>
                        <span>Recruitment Management</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                            <a href="{{ route('system.index') }}" class="nav-link {{ request()->routeIs('system.index') ? 'active' : null }}">
                                Job Post Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('system.index') }}" class="nav-link {{ request()->routeIs('system.index') ? 'active' : null }}">
                                Job Application Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('system.index') }}" class="nav-link {{ request()->routeIs('system.index') ? 'active' : null }}">
                                Interview Schedule Management
                            </a>
                        </li>
                    </ul>
                </li> --}}

            </ul>
        </div>
        {{-- /main navigation --}}

    </div>
</div>
{{-- /main sidebar --}}
