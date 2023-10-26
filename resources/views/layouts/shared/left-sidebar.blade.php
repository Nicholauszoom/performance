<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg bg-main-nav">

    <div class="sidebar-content">

        <div class="sidebar-section">
            <div class="p-2 my-2">
                <img src="{{ asset('img/logo.png') }}" class="img-fluid" widht="270px" alt="BancABC atlasmara">
            </div>
            {{-- <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto text-muted"></h5>

                <div>
                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div> --}}
        </div>

        {{-- {{ request()->routeIs('dashboard.index') ? 'active' : null }} --}}

        <div class="sidebar-section">


            <ul class="nav nav-sidebar main-link" data-nav-type="accordion">
                {{-- @can('view-dashboard')/ --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : null }}">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li
                    class="nav-item nav-item-submenu {{ request()->routeIs('flex.my-grievances') || request()->routeIs('flex.biodata') || request()->routeIs('flex.my-pensions') || request()->routeIs('flex.my-overtimes') || request()->routeIs('flex.my-leaves') || request()->routeIs('flex.my-loans') ? 'nav-item-expand nav-item-open' : null }}">
                    <a href="#" class="nav-link">
                        <i class="ph-user"></i>
                        <span>My Services</span>
                    </a>

                    <ul
                        class="nav-group-sub collapse {{ request()->routeIs('flex.download_payslip') || request()->routeIs('flex.my-grievances') || request()->routeIs('flex.biodata') || request()->routeIs('flex.my-pensions') || request()->routeIs('flex.my-overtimes') || request()->routeIs('flex.my-leaves') || request()->routeIs('flex.my-loans') ? 'show' : null }}">


                        {{--  start of suspend employee link --}}

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.my-leaves') ? 'active' : null }}"
                                href="{{ route('flex.my-leaves') }}">My Leaves</a>
                        </li>



                        {{-- / --}}

                        {{-- start of active employee link --}}

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.my-overtimes') ? 'active' : null }}"
                                href="{{ route('flex.my-overtimes') }}">
                                My Overtimes
                            </a>
                        </li>


                        {{--  / --}}
                        {{--  start of overtime link --}}

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.my-pensions') ? 'active' : null }}"
                                href="{{ route('flex.my-pensions') }}"> Pensions </a>
                        </li>


                        {{--  start of employee termination link --}}


                        <li class="nav-item ">
                            <a class="nav-link {{ request()->routeIs('flex.my-loans') ? 'active' : null }}"
                                href="{{ route('flex.my-loans') }}">Loans(HESLB)</a>
                        </li>

                        {{-- / --}}




                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.download_payslip') ? 'active' : null }}"
                                href="{{ route('flex.download_payslip') }}"> Payslip </a>
                        </li>

                        {{-- / --}}

                        {{--  start of Grievances link --}}

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.my-grievances') ? 'active' : null }}"
                                href="{{ route('flex.my-grievances') }}"> Grievances </a>
                        </li>

                        {{-- / --}}

                        {{--  start of biodata link --}}

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.biodata') ? 'active' : null }}"
                                href="{{ route('flex.my-biodata') }}"> Biodata </a>
                        </li>

                        {{-- / --}}


                    </ul>
                </li>
                @if(!Auth::user()->can('view-workforce'))
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-user"></i>
                        <span>Workforce Management</span>
                    </a>

                    <ul class="nav-group-sub collapse ">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.overtime') ? 'active' : null }}"
                                href="{{ route('flex.overtime') }}"> Overtimes </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                                href="{{ route('attendance.leave') }}">Leave Applications</a>
                        </li>

                    </ul>
                </li>
                @endif
                {{-- @endcan --}}

                {{--
                    <li class="nav-item">
                    <a class="nav-link" href="{{ url('/flex/project/') }}">
                        <i class="ph-hard-drives"></i>
                        <span>Projects</span>
                    </a>
                </li>  --}}

                {{-- start of workforce management dropdown --}}
                @can('view-workforce')
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.grievances') || request()->routeIs('flex.addDisciplinary') || request()->routeIs('flex.addPromotion') || request()->routeIs('flex.addIncrement') || request()->routeIs('flex.addTermination') || request()->routeIs('flex.addEmployee') || request()->routeIs('flex.employee') || request()->routeIs('flex.grievancesCompain') || request()->routeIs('flex.promotion') || request()->routeIs('flex.termination') || request()->routeIs('flex.inactive_employee') || request()->routeIs('flex.overtime') || request()->routeIs('flex.termination') || request()->routeIs('imprest.imprest') || request()->routeIs('flex.transfers') ? 'nav-item-expand nav-item-open' : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-users-three"></i>
                            <span>Workforce Management</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.grievances') || request()->routeIs('flex.addDisciplinary') || request()->routeIs('flex.addPromotion') || request()->routeIs('flex.addIncrement') || request()->routeIs('flex.addTermination') || request()->routeIs('flex.addEmployee') || request()->routeIs('flex.employee') || request()->routeIs('flex.grievancesCompain') || request()->routeIs('flex.promotion') || request()->routeIs('flex.termination') || request()->routeIs('flex.inactive_employee') || request()->routeIs('flex.overtime') || request()->routeIs('imprest.imprest') || request()->routeIs('flex.transfers') ? 'show' : null }}">
                            {{-- start of active employee link --}}
                            @can('view-employee')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.addEmployee') || request()->routeIs('flex.employee') ? 'active' : null }}"
                                        href="{{ route('flex.employee') }}">
                                        Active Employees</a>
                                </li>
                            @endcan
                            {{--  / --}}

                            {{--  start of suspend employee link --}}
                            @can('suspend-employee')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.inactive_employee') ? 'active' : null }}"
                                        href="{{ route('flex.inactive_employee') }}">Suspended Employees</a>
                                </li>
                            @endcan
                            {{-- / --}}

                            {{--  start of employee termination link --}}
                            @can('view-termination')
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->routeIs('flex.addTermination') || request()->routeIs('flex.termination') ? 'active' : null }}"
                                        href="{{ route('flex.termination') }}">Employee Termination</a>
                                </li>
                            @endcan
                            {{-- / --}}

                            {{-- start of promotion/increment link --}}
                            @can('view-promotions')
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->routeIs('flex.addPromotion') || request()->routeIs('flex.addIncrement') || request()->routeIs('flex.promotion') ? 'active' : null }}"
                                        href="{{ route('flex.promotion') }}">Promotions/Increments</a>
                                </li>
                            @endcan
                            {{-- / --}}


                            {{--  start of overtime link --}}

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('flex.overtime') ? 'active' : null }}"
                                    href="{{ route('flex.overtime') }}">Overtime </a>
                            </li>

                            {{-- / --}}

                            {{-- start of imprest link --}}
                            @can('view-imprest')
                                {{-- <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('imprest.imprest') ? 'active' : null }}"
                                href="{{ route('imprest.imprest') }}">Imprest</a>
                        </li> --}}
                            @endcan
                            {{-- / --}}

                            {{-- start of transfer employee link --}}
                            @can('transfer-employee')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->routeIs('flex.transfers') ? 'active' : null }}"
                                        href="{{ route('flex.transfers') }}">Employee Approval</a></li>
                            @endcan
                            {{-- / --}}

                            {{-- start of displinary  actions link --}}
                            @can('view-grivance')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.addDisciplinary') || request()->routeIs('flex.grievancesCompain') ? 'active' : null }}"
                                        href="{{ route('flex.grievancesCompain') }}">Disciplinary Actions</a>
                                </li>
                            @endcan
                            {{-- / --}}

                            {{-- start of  Grievances link --}}
                            @can('view-grivance')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.grievances') ? 'active' : null }}"
                                        href="{{ route('flex.grievances') }}"> Employees Grievance</a>
                                </li>
                            @endcan
                            {{-- / --}}

                        </ul>
                    </li>
                    {{-- / --}}
                @endcan
                {{-- / --}}

                {{-- start of view payroll dropdown --}}
                @can('view-payroll-management')
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.submitInputs') || request()->routeIs('pension_receipt.index') || request()->routeIs('flex.financial_group') || request()->routeIs('payroll.payroll') || request()->routeIs('payroll.employee_payslip') || request()->routeIs('payroll.comission_bonus') || request()->routeIs('flex.approved_financial_payments') ? 'nav-item-expand nav-item-open' : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-calculator"></i>
                            <span>Payroll Management</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.submitInputs') || request()->routeIs('pension_receipt.index') || request()->routeIs('flex.financial_group') || request()->routeIs('payroll.employee_payslip') || request()->routeIs('payroll.payroll') || request()->routeIs('payroll.employee_payslip') || request()->routeIs('payroll.comission_bonus') || request()->routeIs('flex.approved_financial_payments') ? 'show' : null }}">
                            {{-- start of payroll link --}}
                            <li class="nav-item"><a
                                class="nav-link {{ request()->routeIs('flex.financial_group') ? 'active' : null }}"
                                href="{{ route('flex.financial_group') }}">Payroll inputs </a></li>
                                @can('view-payslip')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.submitInputs') ? 'active' : null }}"
                                        href="{{ route('flex.submitInputs') }}"> Submit Inputs </a></li>
                            @endcan
                                @can('view-payroll')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('payroll.payroll') ? 'active' : null }}"
                                        href="{{ route('payroll.payroll') }}"> Payroll </a></li>
                            @endcan
                            {{-- / --}}
                            @can('view-pending-payments')
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.approved_financial_payments') ? 'active' : null }}"
                                    href="{{ route('flex.approved_financial_payments') }}">Payroll Approvers </a></li>
                        @endcan

                            {{-- start of payslip link  --}}
                            @can('view-payslip')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('payroll.employee_payslip') ? 'active' : null }}"
                                        href="{{ route('payroll.employee_payslip') }}"> Payslip </a></li>
                            @endcan
                            {{-- / --}}

                            {{-- start of incentives link --}}
                            @can('view-incentives')
                                {{-- <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('payroll.comission_bonus') ? 'active' : null }}"
                                    href="{{ route('payroll.comission_bonus') }}">Incentives</a></li> --}}
                                <!--  <li class="nav-item"><a class="nav-link {{ request()->routeIs('payroll.partial_payment') ? 'active' : null }}" href="{{ route('payroll.partial_payment') }}">Partial Payment</a></li> -->
                            @endcan
                            {{-- / --}}

                            {{--  start of pending payments link --}}

                            @can('view-payslip')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('pension_receipt.index') ? 'active' : null }}"
                                        href="{{ route('pension_receipt.index') }}"> Upload Pension Receipt </a></li>
                            @endcan
                            {{-- / --}}

                        </ul>
                    </li>
                @endcan
                {{-- / --}}

                {{-- start of leave management dropdown --}}
                @can('view-leave')
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('attendance.leave') || request()->routeIs('flex.end_unpaid_leave') || request()->routeIs('flex.save_unpaid_leave') || request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('flex.unpaid_leave') || request()->routeIs('attendance.leavereport') ? 'nav-item-expand nav-item-open' : null }}">

                        <a href="#" class="nav-link">
                            <i class="ph-calendar-check"></i>
                            <span> Leave Management</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('attendance.leave') || request()->routeIs('flex.unpaid_leave') || request()->routeIs('attendance.leavereport') ? 'show' : null }}">
                            @if (session('mng_attend'))
                                {{-- <li class="nav-item"><a class="nav-link" href="{{ url('/flex/attendance/attendees') }}">Attendance</a></li> --}}
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                                    href="{{ route('attendance.leave') }}">Leave Applications</a>
                            </li>



                            {{--  start of unpaid leaves link --}}
                            @can('view-unpaid-leaves')
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('flex.end_unpaid_leave') || request()->routeIs('flex.save_unpaid_leave') || request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('flex.unpaid_leave') ? 'active' : null }}"
                                        href="{{ route('flex.unpaid_leave') }}">Unpaid Leaves</a>
                                </li>
                            @endcan
                            {{-- / --}}
                            @can('view-report')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('attendance.leavereport') ? 'active' : null }}"
                                        href="{{ route('attendance.leavereport') }}">Leave History</a></li>
                            @endcan
                            @can('view-report')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('attendance.leaveforfeiting') ? 'active' : null }}"
                                        href="{{ route('attendance.leaveforfeiting') }}">Leave Forfeiting</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                {{-- / --}}
                @can('view-loan')
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('bank-loans') || request()->routeIs('flex.salary_advance') || request()->routeIs('flex.confirmed_loans') ? 'nav-item-expand nav-item-open' : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-bank"></i>
                            <span>Loan Management</span>
                        </a>
                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('bank-loans') || request()->routeIs('flex.salary_advance') || request()->routeIs('flex.confirmed_loans') ? 'show' : null }}">
                            @can('view-bank-loan')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('bank-loans') ? 'active' : null }}"
                                        href="{{ route('bank-loans') }}">Bank Loans</a></li>
                            @endcan
                            @can('view-loan')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.salary_advance') ? 'active' : null }}"
                                        href="{{ route('flex.salary_advance') }}">Other Loans(HESLB)</a></li>
                            @endcan
                            @can('approve-loan')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.confirmed_loans') ? 'active' : null }}"
                                        href="{{ route('flex.confirmed_loans') }}">Approved Loans</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                {{-- For Performance Management --}}
                @can('view-Performance')
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.employee-list') || request()->routeIs('flex.performance-pillars') || request()->routeIs('flex.projects') || request()->routeIs('flex.tasks') ? 'nav-item-expand nav-item-open' : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-folder"></i>
                            <span>Performance Management</span>
                        </a>
                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.employee-list') || request()->routeIs('flex.performance-pillars') || request()->routeIs('flex.tasks') || request()->routeIs('flex.projects') ? 'show' : null }}">
                            <li class="nav-item">
                                <a href="{{ route('flex.employee-list') }}"
                                    class="nav-link {{ request()->routeIs('flex.employee-list') ? 'active' : null }}">
                                    Employee Performance
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('flex.performance-pillars') }}"
                                    class="nav-link {{ request()->routeIs('flex.performance-pillars') ? 'active' : null }}">
                                    Performance Pillars
                                </a>
                            </li>

                        </ul>
                    </li>
                @endcan
                {{-- <li
                    class="nav-item nav-item-submenu {{ request()->routeIs('flex.performance') || request()->routeIs('flex.performance-report') || request()->routeIs('flex.projects') || request()->routeIs('flex.tasks') ? 'nav-item-expand nav-item-open' : null }}">
                    <a href="#" class="nav-link">
                        <i class="ph-folder"></i>
                        <span>Performance Management</span>
                    </a>
                    <ul
                        class="nav-group-sub collapse {{ request()->routeIs('flex.performance') || request()->routeIs('flex.performance-report') || request()->routeIs('flex.tasks') || request()->routeIs('flex.projects') ? 'show' : null }}">
                        <li class="nav-item">
                            <a href="{{ route('flex.projects') }}"
                                class="nav-link {{ request()->routeIs('flex.projects') ? 'active' : null }}">
                                Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('flex.tasks') }}"
                                class="nav-link {{ request()->routeIs('flex.tasks') ? 'active' : null }}">
                                Adhoc Tasks
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('flex.performance') }}"
                                class="nav-link {{ request()->routeIs('flex.performance') ? 'active' : null }}">
                                Performance Ratios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('flex.performance-report') }}"
                                class="nav-link {{ request()->routeIs('flex.performance-report') ? 'active' : null }} ">
                                Performance Matrix
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item nav-item-submenu {{ request()->routeIs('flex.acceleration') || request()->routeIs('flex.performance') || request()->routeIs('flex.performance-report') || request()->routeIs('flex.projects') || request()->routeIs('flex.tasks') ? 'nav-item-expand nav-item-open' : null }}">
                    <a href="#" class="nav-link">
                        <i class="ph-graph"></i>
                        <span>Performance Acceleration</span>
                    </a>
                    <ul
                        class="nav-group-sub collapse {{ request()->routeIs('flex.acceleration') || request()->routeIs('flex.acceleration-report') || request()->routeIs('flex.tasks') || request()->routeIs('flex.projects') ? 'show' : null }}">
                        <li class="nav-item">
                            <a href="{{ route('flex.acceleration') }}"
                                class="nav-link {{ request()->routeIs('flex.acceleration') ? 'active' : null }}">
                                Acceleration Programme
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('flex.acceleration-report') }}"
                                class="nav-link {{ request()->routeIs('flex.acceleration-report') ? 'active' : null }} ">
                                Acceleration Matrix
                            </a>
                        </li>
                    </ul>
                </li> --}}

                {{-- / --}}

                {{-- For Talent Management --}}
                @can('view-Talent')
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.employee-profiles') || request()->routeIs('flex.talent-ratios') ? 'nav-item-expand nav-item-open' : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-presentation-chart"></i>
                            <span>Talent Management</span>
                        </a>
                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.employee-profiles') || request()->routeIs('flex.talent-ratios') || request()->routeIs('flex.talent-range') ? 'show' : null }}">
                            <li class="nav-item">
                                <a href="{{ route('flex.employee-profiles') }}"
                                    class="nav-link {{ request()->routeIs('flex.employee-profiles') ? 'active' : null }}">
                                    Employees Profiles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('flex.talent-range') }}"
                                    class="nav-link {{ request()->routeIs('flex.talent-range') ? 'active' : null }} ">
                                    Talent Ranges
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('flex.talent-matrix') }}" class="nav-link ">
                                    Talent Matrix
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                        <a href="{{ route('flex.performance') }}" class="nav-link ">
                            Talent Settings
                        </a>
                    </li> --}}
                        </ul>
                    </li>
                @endcan
                {{-- / --}}
                @can('view-organization')
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.department') || request()->routeIs('flex.costCenter') || request()->routeIs('flex.branch') || request()->routeIs('flex.position') || request()->routeIs('flex.contract') || request()->routeIs('flex.organization_level') || request()->routeIs('flex.organization_structure') || request()->routeIs('flex.accounting_coding') ? 'nav-item-expand nav-item-open' : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-buildings"></i>
                            <span>Organisation</span>
                        </a>
                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.department') || request()->routeIs('flex.costCenter') || request()->routeIs('flex.branch') || request()->routeIs('flex.position') || request()->routeIs('flex.contract') || request()->routeIs('flex.organization_level') || request()->routeIs('flex.organization_structure') || request()->routeIs('flex.accounting_coding') ? 'show' : null }}">

                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.department') ? 'active' : null }}"
                                    href="{{ route('flex.department') }}">Departments </a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.costCenter') ? 'active' : null }}"
                                    href="{{ route('flex.costCenter') }}">Cost Center </a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.branch') ? 'active' : null }}"
                                    href="{{ route('flex.branch') }}">Company Branches </a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.position') ? 'active' : null }}"
                                    href="{{ route('flex.position') }}">Positions</a></li>
                            @if (session('mng_emp'))
                                {{-- <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.contract') ? 'active' : null }}"
                                    href="{{ route('flex.contract') }}">Employee Contracts</a></li> --}}
                            @endif
                            {{-- <li  class="nav-item"><a class="nav-link"  href="{{ route('flex.accountCoding') }}">Account Coding</a></li> --}}
                            {{-- <li class="nav-item"><a
                                class="nav-link {{ request()->routeIs('flex.organization_level') ? 'active' : null }}"
                                href="{{ route('flex.organization_level') }}">Organisation Levels </a></li> --}}
                            {{-- <li class="nav-item"><a
                                class="nav-link {{ request()->routeIs('flex.organization_structure') ? 'active' : null }}"
                                href="{{ route('flex.organization_structure') }}">Organisation Structure</a></li> --}}
                            {{-- <li class="nav-item"><a
                                class="nav-link {{ request()->routeIs('flex.accounting_coding') ? 'active' : null }}"
                                href="{{ route('flex.accounting_coding') }}">Accounting Coding</a></li> --}}

                        </ul>
                    </li>
                @endcan




                @can('view-report')
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.financial_reports') || request()->routeIs('flex.organisation_reports') ? 'nav-item-expand nav-item-open' : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-note"></i>
                            <span>Reports</span>
                        </a>
                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.performance-reports') || request()->routeIs('flex.financial_reports') || request()->routeIs('flex.organisation_reports') ? 'show' : null }}">

                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.financial_reports') ? 'active' : null }}"
                                    href="{{ route('flex.financial_reports') }}">Statutory Reports </a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.organisation_reports') ? 'active' : null }}"
                                    href="{{ route('flex.organisation_reports') }}">Organisation Reports </a>
                            </li>
                            {{-- For Performance Reports --}}
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.performance-reports') ? 'active' : null }}"
                                    href="{{ route('flex.performance-reports') }}">Performance Reports </a>
                            </li>
                            {{-- ./ --}}

                        </ul>
                    </li>
                @endcan
                @can('view-setting')
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.companyInfo') || request()->routeIs('bot.botIndex') || request()->routeIs('flex.updatecompanyInfo') || request()->routeIs('flex.leave-approval') || request()->routeIs('flex.approvals') || request()->routeIs('users.index') || request()->routeIs('permissions.index') || request()->routeIs('flex.roles.index') || request()->routeIs('flex.email-notifications') || request()->routeIs('flex.holidays') || request()->routeIs('flex.permissions') || request()->routeIs('role') || request()->routeIs('flex.bank') || request()->routeIs('flex.audit_logs') || request()->routeIs('payroll.mailConfiguration') ? 'nav-item-expand nav-item-open' : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-gear-six"></i>
                            <span>Settings</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.companyInfo') || request()->routeIs('bot.botIndex') || request()->routeIs('flex.companyInfo') || request()->routeIs('flex.updatecompanyInfo') || request()->routeIs('flex.leave-approval') || request()->routeIs('flex.approvals') || request()->routeIs('users.index') || request()->routeIs('permissions.index') || request()->routeIs('roles.index') || request()->routeIs('flex.email-notifications') || request()->routeIs('flex.holidays') || request()->routeIs('flex.financial_group') || request()->routeIs('flex.bank') || request()->routeIs('flex.audit_logs') || request()->routeIs('payroll.mailConfiguration') ? 'show' : null }}">
                            @if (session('mng_roles_grp'))
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.companyInfo') ? 'active' : null }}"
                                        href="{{ route('flex.companyInfo') }}">Company Info</a></li>
                            @endif




                            @if (session('mng_bank_info'))
                                {{-- <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.bank') ? 'active' : null }}"
                                    href="{{ route('flex.bank') }}">Banking Information</a>
                            </li> --}}
                            @endif

                            <li class=" nav-item"><a
                                    class="nav-link {{ request()->routeIs('roles.index') ? 'active' : null }} "
                                    href="{{ url('roles') }}">
                                    Roles</a>
                            </li>



                            <li class=" nav-item {{ request()->routeIs('permissions.index') ? 'active' : null }} "><a
                                    class="nav-link " href="{{ url('permissions') }}">Permission</a>

                            </li>

                            <li class=" nav-item "><a
                                    class="nav-link  {{ request()->routeIs('users.index') ? 'active' : null }}"
                                    href="{{ url('users') }}">{{ __('User') }}
                                    Management</a>
                            </li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.holidays') ? 'active' : null }}"
                                    href="{{ route('flex.holidays') }}">Holidays</a>
                            </li>


                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.email-notifications') ? 'active' : null }}"
                                    href="{{ route('flex.email-notifications') }}">Email Notification</a>
                            </li>

                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.approvals') ? 'active' : null }}"
                                    href="{{ route('flex.approvals') }}">Approvals</a>
                            </li>

                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.leave-approval') ? 'active' : null }}"
                                    href="{{ route('flex.leave-approval') }}">Leave Approvals</a>
                            </li>

                            @if (session('mng_audit'))
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.audit_logs') ? 'active' : null }}"
                                        href="{{ route('flex.audit_logs') }}">Audit Trail</a></li>
                            @endif

                            @if (session('mng_audit'))
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.passwordAutogenerate') ? 'active' : null }}"
                                        href="{{ route('flex.passwordAutogenerate') }}">Password Reset</a></li>
                            @endif
                            @if (session('mng_audit'))
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('bot.botIndex') ? 'active' : null }}"
                                        href="{{ route('bot.botIndex') }}">Post data to BOT</a></li>
                            @endif


                            {{-- <li class="nav-item"><a class="nav-link" href="{{ route('/flex/nationality')}}">Nationality</a></li>  --}}
                            {{-- <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('payroll.mailConfiguration') ? 'active' : null }}"
                                    href="{{ route('payroll.mailConfiguration') }}"></i> Mail Configuration </a></li> --}}
                        </ul>
                    </li>
                @endcan
                {{-- <li class="nav-item">
                    <a href="{{ route('flex.payrollLogs') }}"
                        class="nav-link {{ request()->routeIs('flex.payrollLogs') ? 'active' : null }}">
                        <i class="ph-clipboard-text"></i>
                        <span>Payroll Logs</span>
                    </a>
                </li> --}}




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
