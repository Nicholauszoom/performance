<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg bg-main-nav">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto text-muted"> BANK ABC</h5>

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
            </div>
        </div>
        <!-- /sidebar header -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar main-link" data-nav-type="accordion">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : null  }}">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                {{-- /Dashboard --}}

                {{-- Projects --}}
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="ph-hard-drives"></i>
                        <span>Projects</span>
                    </a>
                </li> -->
                {{-- /projects --}}


                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-users-three"></i>
                        <span>workforce management</span>
                    </a>

                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                            <a href="{{ route('employee.active') }}"
                                class="nav-link {{ request()->routeIs('employee.active') ? 'active' : null  }}">
                                Active Employee
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('employee.suspended') }}"
                                class="nav-link {{ request()->routeIs('employee.suspended') ? 'active' : null  }}">
                                Suspended Employee
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('overtime') }}"
                                class="nav-link {{ request()->routeIs('overtime') ? 'active' : null  }}"
                            >
                                Overtime
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="{{ route('imprest.index') }}"
                                class="nav-link {{ request()->routeIs('imprest.index') ? 'active' : null  }}"
                            >
                                Imprest
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="{{ route('approve.changes') }}"
                                class="nav-link {{ request()->routeIs('approve.changes') ? 'active' : null  }}"
                            >
                                Employee Aproval
                            </a>
                        </li>
                    </ul>
                </li>

            {{-- Payroll management --}}
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph-calculator"></i>
                    <span>Payroll Management</span>
                </a>

                <ul class="nav-group-sub collapse">
                    <li class="nav-item">
                        <a href="{{ route('payroll') }}"
                            class="nav-link {{ request()->routeIs('payroll') ? 'active' : null  }}">
                            Payroll
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('employee_payslip') }}"
                            class="nav-link {{ request()->routeIs('employee_payslip') ? 'active' : null  }}">
                            Payslip
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('comission_bonus') }}"
                            class="nav-link {{ request()->routeIs('comission_bonus') ? 'active' : null  }}">
                            Incentives
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('partial_payment') }}"
                            class="nav-link {{ request()->routeIs('partial_payment') ? 'active' : null  }}">
                            Partial Payment
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                            <a
                                href="{{ route('approved_financial_payments') }}"
                    class="nav-link {{ request()->routeIs('approved_financial_payments') ? 'active' : null  }}">
                    Pending Payments
                    </a>
            </li> --}}



            <!-- <li class="nav-item">
                <a href="{{ route('payroll') }}"
                    class="nav-link {{ request()->routeIs('payroll') ? 'active' : null  }}">
                    Salary Calculator
                </a>
            </li> -->
            </ul>
            </li>
            {{-- /Payroll management --}}


            {{-- <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-stack"></i>
                        <span>Learning & Development</span>
                    </a>

                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                            <a
                                href="{{ route('members.active') }}"
            class="nav-link {{ request()->routeIs('members.active') ? 'active' : null  }}">
            Training Budgeting
            </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('members.active') }}"
                    class="nav-link {{ request()->routeIs('members.active') ? 'active' : null  }}">
                    Training Application
                </a>
            </li>
            </ul>
            </li> --}}



            {{-- <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-trophy"></i>
                        <span>Talent Management</span>
                    </a>

                    <ul class="nav-group-sub collapse">

                        <li class="nav-item">
                            <a
                                href="{{ route('members.active') }}"
            class="nav-link {{ request()->routeIs('members.active') ? 'active' : null  }}">
            Talent Management
            </a>
            </li>
            </ul>
            </li> --}}

            {{-- /workforce management --}}



            {{--
                    Leave & Attendance
                        -   Attendance
                --}}



            {{--
                    Organisation
                        -   Cost center
                        -   Departments
                        -   Company brancehs
                        -   Position
                        -   Employee contracts
                        -   Organisation levels
                        -   Accounting coding
                --}}

                {{-- Organisation --}}
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-buildings"></i>
                        <span>Organisation</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                                <a
                                    href="{{ route('departments.index') }}"
                                    class="nav-link {{ request()->routeIs('departments.index') ? 'active' : null  }}"
                                >
                                Company Registration
                                </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('departments.index') }}"
                                class="nav-link {{ request()->routeIs('departments.index') ? 'active' : null  }}"
                            >
                            Organization structure Registration
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('departments.index') }}"
                                class="nav-link {{ request()->routeIs('departments.index') ? 'active' : null  }}"
                            >
                                Departments
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('departments.index') }}"
                                class="nav-link {{ request()->routeIs('departments.index') ? 'active' : null  }}"
                            >
                                Position
                            </a>
                        </li>

                    <li class="nav-item">
                        <a href="{{ route('designations.index') }}"
                            class="nav-link {{ request()->routeIs('designations.index') ? 'active' : null  }}">
                            Role Profile Registration(Position)
                        </a>
                    </li>


                </ul>
            </li>

            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph-buildings"></i>
                    <span>Reports</span>
                </a>
                <ul class="nav-group-sub collapse">
                    <li class="nav-item">
                        <a href="{{ route('cipay.financial_reports') }}"
                            class="nav-link {{ request()->routeIs('cipay.financial_reports') ? 'active' : null  }}">
                            Statutory Reports
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('cipay.organisation_reports') }}"
                            class="nav-link {{ request()->routeIs('cipay.organisation_reports') ? 'active' : null  }}">
                            Organisation Reports
                        </a>
                    </li>

                </ul>
            </li>


            {{-- /organisation --}}

            {{--
                    Settings
                        - Roles
                        - Alloances
                        - Overtime
                        - Statutory deductions
                        - Audit trails
                        - Funders
                        - Nationality
                        - Mail configaration
                --}}

            {{-- settings --}}
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph-gear-six"></i>
                    <span>Settings</span>
                </a>
                <ul class="nav-group-sub collapse">
                    <li class="nav-item">
                        <a href="{{ route('system.index') }}"
                            class="nav-link {{ request()->routeIs('system.index') ? 'active' : null  }}">
                            Company Setting
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('roles.index') }}"
                            class="nav-link {{ request()->routeIs('roles.index') ? 'active' : null  }}">
                            Roles
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('permissions.index') }}"
                            class="nav-link {{ request()->routeIs('permissions.index') ? 'active' : null  }}">
                            Permissions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ request()->routeIs('users.index') ? 'active' : null  }}">
                            User Management
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('audit') }}"
                            class="nav-link {{ request()->routeIs('audit') ? 'active' : null  }}">
                            Audit Trail
                        </a>
                    </li>

                </ul>
            </li>
            {{-- /settings --}}




            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
