<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg bg-main-nav">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto text-muted">HR & Payroll System</h5>

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
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : null  }}">
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
                    <a href="#" class="nav-link">workforce management
                    </a>

                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                            <a
                                href="{{ route('members.active') }}"
                                class="nav-link {{ request()->routeIs('members.active') ? 'active' : null  }}"
                            >
                                Active Employees
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- /workforce management --}}


                {{--
                    Leave & Attendance
                        -   Attendance
                --}}

                {{-- Salary MOdel
                        -   Application
                --}}
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"> Payroll Management
                    </a>

                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                            <a
                                href="{{ route('payroll') }}"
                                class="nav-link {{ request()->routeIs('payroll') ? 'active' : null  }}">
                                Payroll
                            </a>
                        </li>
                    </ul>
                </li>

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
                                Departments
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('designations.index') }}"
                                class="nav-link {{ request()->routeIs('designations.index') ? 'active' : null  }}"
                            >
                                Position
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('users.index') }}"
                                class="nav-link {{ request()->routeIs('users.index') ? 'active' : null  }}"
                            >
                                Management
                            </a>
                        </li>
                        {{-- <li class="nav-item"><a href="form_checkboxes_radios.html" class="nav-link">Checkboxes &amp; radios</a></li> --}}

                    </ul>
                </li>
                {{-- /organisation --}}


{{-- Learning & development --}}
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-buildings"></i>
                        <span>Learning & development</span>
                    </a>
                    <ul class="nav-group-sub collapse">

                        <li class="nav-item">
                            <a
                                href="{{ route('employee.index') }}"
                                class="nav-link {{ request()->routeIs('employee.index') ? 'active' : null  }}"
                            >
                                Employee
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('designations.index') }}"
                                class="nav-link {{ request()->routeIs('designations.index') ? 'active' : null  }}"
                            >
                              Skills
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('users.index') }}"
                                class="nav-link {{ request()->routeIs('users.index') ? 'active' : null  }}"
                            >
                                Training Application
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="{{ route('designations.index') }}"
                                class="nav-link {{ request()->routeIs('designations.index') ? 'active' : null  }}"
                            >
                              Training Budget
                            </a>
                        </li>
                        {{-- <li class="nav-item"><a href="form_checkboxes_radios.html" class="nav-link">Checkboxes &amp; radios</a></li> --}}

                    </ul>
                </li>
                {{-- /Learning & development --}}


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
                            <a
                                href="{{ route('system.index') }}"
                                class="nav-link {{ request()->routeIs('system.index') ? 'active' : null  }}"
                            >
                                Company Setting
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('roles.index') }}"
                                class="nav-link {{ request()->routeIs('roles.index') ? 'active' : null  }}"
                            >
                                Roles
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('permissions.index') }}"
                                class="nav-link {{ request()->routeIs('permissions.index') ? 'active' : null  }}"
                            >
                                Permissions
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('audit') }}"
                                class="nav-link {{ request()->routeIs('audit') ? 'active' : null  }}"
                            >
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
