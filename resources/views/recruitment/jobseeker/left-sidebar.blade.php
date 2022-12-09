<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg bg-main-nav">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto text-muted">Job Search Portal</h5>

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
                    <a href=""
                    {{-- <a href="{{ route('dashboard.index') }}" --}}
                        class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : null }}">
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
                        <span>Personal Information</span>
                    </a>

                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                            <a href=""
                            {{-- <a href="{{ route('employee.active') }}" --}}
                                class="nav-link {{ request()->routeIs('employee.active') ? 'active' : null }}">
                                Personal Details
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                            {{-- <a href="{{ route('employee.suspended') }}" --}}
                                class="nav-link {{ request()->routeIs('employee.suspended') ? 'active' : null }}">
                                Contact Details
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a
                                href="{{ route('members.active') }}"
                                class="nav-link {{ request()->routeIs('members.active') ? 'active' : null  }}"
                            >
                                Transfers  Management
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a
                                href="{{ route('members.active') }}"
                                class="nav-link {{ request()->routeIs('members.active') ? 'active' : null  }}"
                            >
                            Attendance
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a
                                href="{{ route('members.active') }}"
                                class="nav-link {{ request()->routeIs('members.active') ? 'active' : null  }}"
                            >
                            Overtime management
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a
                                href="{{ route('members.active') }}"
                                class="nav-link {{ request()->routeIs('members.active') ? 'active' : null  }}"
                            >
                            Grievances and Disciplinary Management
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a
                                href="{{ route('members.active') }}"
                                class="nav-link {{ request()->routeIs('members.active') ? 'active' : null  }}"
                            >
                            Performance & Productiviy Management
                            </a>
                        </li> --}}
                    </ul>
                </li>

                {{-- Payroll management --}}
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-graduation-cap"></i>
                        <span>Education</span>
                    </a>

                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->routeIs('payroll') ? 'active' : null }}">
                                Formal Education 
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->routeIs('payslip') ? 'active' : null }}">
                                Professional Certifications
                            </a>
                        </li>

                        <li class="nav-item">
                            {{-- <a href="{{ route('incentives') }}" --}}
                            <a href=""
                                class="nav-link {{ request()->routeIs('incentives') ? 'active' : null }}">
                                Workshop and training
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a
                                href="{{ route('payroll') }}"
                                class="nav-link {{ request()->routeIs('payroll') ? 'active' : null  }}">
                                Pending Payments
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a
                                href="{{ route('payroll') }}"
                                class="nav-link {{ request()->routeIs('payroll') ? 'active' : null  }}">
                                Statutory Reports
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a
                                href="{{ route('payroll') }}"
                                class="nav-link {{ request()->routeIs('payroll') ? 'active' : null  }}">
                                Organisation Reports
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a
                                href="{{ route('payroll') }}"
                                class="nav-link {{ request()->routeIs('payroll') ? 'active' : null  }}">
                                Salary Calculator
                            </a>
                        </li> --}}
                    </ul>
                </li>
               
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="ph-buildings"></i>
                        <span>Language Proficiency</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="ph-clipboard-text"></i>
                        <span>Experience</span>
                    </a>
                </li>
                {{-- settings --}}
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">
                        <i class="ph-book-bookmark"></i>
                        <span>Other Informations</span>
                    </a>
                    <ul class="nav-group-sub collapse">
                        <li class="nav-item">
                            <a href=""
                            {{-- <a href="{{ route('system.index') }}" --}}
                                class="nav-link {{ request()->routeIs('system.index') ? 'active' : null }}">
                                Referees
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                            {{-- <a href="{{ route('roles.index') }}" --}}
                                class="nav-link {{ request()->routeIs('roles.index') ? 'active' : null }}">
                                Declaration 
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href=""
                            {{-- <a href="{{ route('permissions.index') }}" --}}
                                class="nav-link {{ request()->routeIs('permissions.index') ? 'active' : null }}">
                                Other Attachments
                            </a>
                        </li>

                    </ul>
                </li>
                {{-- /settings --}}




            </ul>
        </div>
        <!-- /main navigation -->

    </div>
</div>
<!-- /main sidebar -->
