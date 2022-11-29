<div class="sidebar sidebar-light sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-section">
            <div class="sidebar-user-material">
                <div class="sidebar-section-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <button type="button"
                                class="btn btn-outline-light border-transparent btn-icon btn-sm rounded-pill">
                                <i class="icon-wrench"></i>
                            </button>
                        </div>
                        <a href="#" class="flex-1 text-center"><img src="{{asset('login-assets/images/main-logo.png')}}"
                                class="img-fluid rounded-circle shadow-sm" height="150" width="200" alt=""></a>
                        <div class="flex-1 text-right">
                            <button type="button"
                                class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="icon-transmission"></i>
                            </button>

                            <button type="button"
                                class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                                <i class="icon-cross2"></i>
                            </button>
                        </div>
                    </div>

                    <?php
                        $system = App\Models\AccessControll\System::first();
                    ?>

                    <div class="text-center">
                        <h6 class="mb-0 text-white text-shadow-dark mt-3">
                            {{ !empty($system)? $system->name : 'sytem name not set'}}</h6>
                        <span class="font-size-sm text-white text-shadow-dark"></span>
                    </div>
                </div>

                <div class="sidebar-user-material-footer">
                    <a href="#user-nav"
                        class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle"
                        data-toggle="collapse"><span>My account</span></a>
                </div>
            </div>

            <div class="collapse border-bottom" id="user-nav">
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-user-plus"></i>
                            <span>My profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-coins"></i>
                            <span>My balance</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-comment-discussion"></i>
                            <span>Messages</span>
                            <span class="badge badge-teal badge-pill align-self-center ml-auto">58</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="icon-cog5"></i>
                            <span>Account settings</span>
                        </a>
                    </li>
                    <li class="nav-item">

                        <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                {{-- Main --}}
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs mt-1">Main</div>
                    <i class="icon-menu" title="Main"></i>
                </li>

                <li class="nav-item">
                    <a href=" {{ url('dashboard') }}"
                        class="nav-link  {{ (request()->is('dashboard')) ? 'active' : ''  }}">
                        <i class="icon-home"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href=" {{ route('audit') }}"
                        class="nav-link  {{ (request()->is('audit')) ? 'active' : ''  }}">
                        <i class="icon-home"></i>
                        <span> Audit </span>
                    </a>
                </li>








                @can('manage-payroll')
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link {{ (request()->is('payroll/*')) ? 'active' : ''  }}"><i
                            class="icon-calculator"></i> <span> Payroll Management</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('view-salary_template')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('payroll/salary_template*')) ? 'active' : ''  }}"
                                href="{{url('payroll/salary_template')}}"> Salary
                                Template</a></li>
                        @endcan
                        @can('view-manage_salary')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('payroll/manage_salary*')) ? 'active' : ''  }}"
                                href="{{url('payroll/manage_salary')}}"> Manage
                                Salary</a></li>
                        @endcan
                        @can('view-employee_salary_list')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('payroll/employee_salary_list*')) ? 'active' : ''  }}"
                                href="{{ url('payroll/employee_salary_list') }}">
                                Employee Salary List</a>
                        </li>
                        @endcan
                        @can('view-make_payment')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('payroll/make_payment*')) ? 'active' : ''  }}"
                                href="{{url('payroll/make_payment')}}">Make Payment</a>
                        </li>
                        @endcan
                        @can('view-make_payment')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('payroll/multiple_payment*')) ? 'active' : ''  }}"
                                href="{{url('payroll/multiple_payment')}}">Make Multiple Payment</a>
                        </li>
                        @endcan
                        @can('view-generate_payslip')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('payroll/generate_payslip*')) ? 'active' : ''  }}"
                                href="{{url('payroll/generate_payslip')}}">Generate
                                Payslip</a></li>
                        @endcan
                        @can('view-payroll_summary')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('payroll/payroll_summary*')) ? 'active' : ''  }}"
                                href="{{url('payroll/payroll_summary')}}">Payroll
                                Summary</a></li>
                        @endcan
                        @can('view-advance_salary')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('payroll/advance_salary*')) ? 'active' : ''  }}"
                                href="{{url('payroll/advance_salary')}}">Advance
                                Salary</a></li>
                        @endcan
                        @can('view-employee_loan')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('payroll/employee_loan*')) ? 'active' : ''  }}"
                                href="{{url('payroll/employee_loan')}}">Employee
                                Loan</a></li>
                        @endcan
                        @can('view-overtime')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('payroll/overtime*')) ? 'active' : ''  }}"
                                href="{{url('payroll/overtime')}}">Overtime</a></li>
                        @endcan
                        @can('view-nssf')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('payroll/nssf*')) ? 'active' : ''  }}"
                                href="{{url('payroll/nssf')}}">Social Security (NSSF)
                            </a></li>
                        @endcan
                        @can('view-tax')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('payroll/tax*')) ? 'active' : ''  }}"
                                href="{{url('payroll/tax')}}">Tax </a></li>
                        @endcan
                        @can('view-nhif')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('payroll/nhif*')) ? 'active' : ''  }}"
                                href="{{url('payroll/nhif')}}">Health Contribution</a>
                        </li>
                        @endcan
                        @can('view-wcf')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('payroll/wcf*')) ? 'active' : ''  }}"
                                href="{{url('payroll/wcf')}}">WCF Contribution</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan




























                @can('view-leave')
                <li class="nav-item ">
                    <a class="nav-link {{ (request()->is('leave/leave*')) ? 'active' : ''  }}" href="{{ url('leave') }}"
                        aria-expanded="false" class="dropdown-toggle">

                        <i class="icon-bus"></i>
                        <span> {{__('Leave Management')}}</span>

                    </a>
                </li>
                @endcan
                @can('view-training')
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('training/training*')) ? 'active' : ''  }}"
                        href="{{ url('training') }}" aria-expanded="false" class="dropdown-toggle">

                        <i class="icon-cog5"></i>
                        <span> {{__('Training')}}</span>

                    </a>
                </li>
                @endcan




                @can('manage-gl-setup')
                <li class="nav-item nav-item-submenu">
                    <a href="#glSetup" class="nav-link {{ (request()->is('inventory/*')) ? 'active' : ''  }}"
                        data-toggle="collapse" class="dropdown-toggle">

                        <i class="icon-wrench3"></i><span>GL SETUP</span>


                    </a>

                    <ul class="nav nav-group-sub" id="glSetup" data-parent="#accordionExample">
                        <li class="nav-item  ">
                            @can('view-class_account')
                            <a class="nav-link {{ (request()->is('class_account/*')) ? 'active' : ''  }}"
                                href="{{ url('class_account') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Class Account')}}</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-group_account')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('group_account/*')) ? 'active' : ''  }}"
                                href="{{ url('group_account') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Group Account')}}</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-account_codes')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('account_codes/*')) ? 'active' : ''  }}"
                                href="{{ url('account_codes') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Account Codes')}}</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-chart_of_account')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('chart_of_account/*')) ? 'active' : ''  }}"
                                href="{{ url('chart_of_account') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Chart of Accounts')}}</span>

                            </a>
                        </li>
                        @endcan


                    </ul>
                </li>
                @endcan

                @can('manage-accounting')
                <li class="nav-item nav-item-submenu">
                    <a href="#accounting" class="nav-link" data-toggle="collapse" class="dropdown-toggle">

                        <i class="icon-stats-growth"></i><span>Accounting</span>


                    </a>
                    <ul class="nav nav-group-sub" id="accounting" data-parent="#accordionExample">
                        @can('view-manual_entry')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('accounting/manual_entry/*')) ? 'active' : ''  }}"
                                href="{{ url('accounting/manual_entry') }}" aria-expanded="false"
                                class="dropdown-toggle">

                                <span> Journal Entry</span>

                            </a>
                        </li>

                        @endcan
                        @can('view-journal')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('accounting/journal*')) ? 'active' : ''  }}"
                                href="{{ url('accounting/journal') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> Journal Entry Report</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-ledger')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('accounting/ledger*')) ? 'active' : ''  }}"
                                href="{{ url('accounting/ledger') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> Ledger</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-trial_balance')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('financial_report/trial_balance')) ? 'active' : ''  }}"
                                href="{{ url('financial_report/trial_balance') }}" aria-expanded="false"
                                class="dropdown-toggle">

                                <span> Trial Balance</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-trial_balance')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('financial_report/trial_balance_summary*')) ? 'active' : ''  }}"
                                href="{{ url('financial_report/trial_balance_summary') }}" aria-expanded="false"
                                class="dropdown-toggle">

                                <span> Trial Balance Summary</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-income_statement')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('financial_report/income_statement')) ? 'active' : ''  }}"
                                href="{{ url('financial_report/income_statement') }}" aria-expanded="false"
                                class="dropdown-toggle">

                                Income Statement

                            </a>
                        </li>
                        @endcan
                        @can('view-income_statement')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('financial_report/income_statement_summary')) ? 'active' : ''  }}"
                                href="{{ url('financial_report/income_statement_summary') }}" aria-expanded="false"
                                class="dropdown-toggle">
                                Income Statement Summary

                            </a>
                        </li>
                        @endcan
                        @can('view-balance_sheet')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('financial_report/balance_sheet')) ? 'active' : ''  }}"
                                href="{{ url('financial_report/balance_sheet') }}" aria-expanded="false"
                                class="dropdown-toggle">

                                <span> Balance Sheet</span>

                            </a>
                        </li>
                </li>
                @endcan
                @can('view-balance_sheet')
                <li class="nav-item ">
                    <a class="nav-link {{ (request()->is('financial_report/balance_sheet_summary')) ? 'active' : ''  }}"
                        href="{{ url('financial_report/balance_sheet_summary') }}" aria-expanded="false"
                        class="dropdown-toggle">

                        <span> {{__('Balance Sheet Summary')}}</span>

                    </a>
                </li>
                @endcan

            </ul>
            </li>
            @endcan

            @can('manage-report')
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link {{ (request()->is('reports/*')) ? 'active' : ''  }} "><i
                        class="icon-grid6"></i> <span>
                        Reports</span></a>

                <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                    @can('view-payroll_summary')
                    <li class="nav-item"><a
                            class="nav-link {{ (request()->is('payroll/payroll_summary*')) ? 'active' : ''  }}"
                            href="{{url('payroll/payroll_summary')}}">Payroll
                            Summary</a></li>
                    @endcan









                    @can('view-journal')
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('accounting/journal*')) ? 'active' : ''  }}"
                            href="{{ url('accounting/journal') }}" aria-expanded="false" class="dropdown-toggle">

                            <span> Journal Entry Report</span>

                        </a>
                    </li>
                    @endcan


                </ul>
            </li>

            @endcan



            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link" data-toggle="collapse">

                    <i class="icon-cog7"></i>

                    <span>{{__('Acess Controll')}}</span>

                </a>

                <ul class="nav nav-group-sub">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ url('roles') }}"> {{__('Roles')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('permissions') }}"> {{__('Permissions')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('system') }}"> {{__('System Settings')}}</a>
                    </li>

                    <li class=""><a class="nav-link" href="{{url('departments')}}">Departments
                        </a></li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('designations') }}"> {{__('Designations')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('users') ? 'active' : '' }}" href="{{ url('users') }}">User
                            Management </a>
                    </li>

                </ul>
            </li>


            </ul>
        </div>
        <!-- /main navigation -->


    </div>

    <!-- /sidebar content -->

</div>
