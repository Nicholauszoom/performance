@php
    $brandSetting = \App\Models\BrandSetting::first();
@endphp


<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg bg-main-nav">
    <div class="sidebar-section">
        <div class="sidebar-logo d-flex justify-content-center align-items-center">
            <a href="{{ url('') }}" class="d-inline-flex align-items-center pt-3 pb-2">


                @if ($brandSetting->company_logo)
                    <img src="{{ asset('storage/' . $brandSetting->company_logo) }}" class="image-fluid" width="200px"
                        alt="BancABC atlasmara">
                @else
                    <img src="{{ asset('img/logo.png') }}" class="image-fluid" width="200px" alt="BancABC atlasmara">
                @endif

            </a>
        </div>
    </div>

    <div class="sidebar-content pb-2">
        <div class="sidebar-section">
            <ul class="nav nav-sidebar main-link" data-nav-type="accordion">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : null }}">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li
                    class="nav-item nav-item-submenu {{ request()->routeIs('flex.my-grievances') || request()->routeIs('flex.my-biodata') || request()->routeIs('flex.my-pensions') || request()->routeIs('flex.my-overtimes') || request()->routeIs('flex.my-leaves') || request()->routeIs('flex.my-loans') ? 'nav-item-expand nav-item-open' : null }}">
                    <a href="#" class="nav-link">
                        <i class="ph-user"></i>
                        <span>My Services</span>
                    </a>

                    <ul
                        class="nav-group-sub collapse {{ request()->routeIs('flex.download_payslip') || request()->routeIs('flex.my-grievances') || request()->routeIs('flex.my-biodata') || request()->routeIs('flex.my-pensions') || request()->routeIs('flex.my-overtimes') || request()->routeIs('flex.my-leaves') || request()->routeIs('flex.my-loans') ? 'show' : null }}">


                        {{--  start of suspend employee link --}}

                        <li class="nav-item">


                            <a class="nav-link {{ request()->routeIs('flex.my-leaves') ? 'active' : null }}"
                                href="{{ route('flex.my-leaves') }}"><i class="ph-user-rectangle me-2"></i>My Leaves</a>
                        </li>



                        {{-- / --}}

                        {{-- start of active employee link --}}

                        <li class="nav-item">


                            <a class="nav-link {{ request()->routeIs('flex.my-overtimes') ? 'active' : null }}"
                                href="{{ route('flex.my-overtimes') }}"><i class="ph-clock me-2"></i>
                                My Overtimes
                            </a>
                        </li>


                        {{--  / --}}
                        {{--  start of overtime link --}}

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.my-pensions') ? 'active' : null }}"
                                href="{{ route('flex.my-pensions') }}"> <i class="ph-bank me-2"></i>Pensions </a>
                        </li>


                        {{--  start of employee termination link --}}


                        <li class="nav-item ">
                            <a class="nav-link {{ request()->routeIs('flex.my-loans') ? 'active' : null }}"
                                href="{{ route('flex.my-loans') }}"><i class="ph-buildings me-2"></i> Loans(HESLB)</a>
                        </li>

                        {{-- / --}}




                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.download_payslip') ? 'active' : null }}"
                                href="{{ route('flex.download_payslip') }}"> <i class="ph-bank me-2"></i>Payslip </a>
                        </li>

                        {{-- / --}}

                        {{--  start of Grievances link --}}

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.my-grievances') ? 'active' : null }}"
                                href="{{ route('flex.my-grievances') }}"><i class="ph-waves me-2"></i> Grievances </a>
                        </li>

                        {{-- / --}}

                        {{--  start of biodata link --}}

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.my-biodata') ? 'active' : null }}"
                                href="{{ route('flex.my-biodata') }}"> <i class="ph-user-circle me-2"></i>Biodata </a>
                        </li>

                        {{-- / --}}


                    </ul>
                </li>
                @if (!Auth::user()->can('view-workforce'))
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
                            class="nav-group-sub collapse {{ request()->routeIs('flex.grievances')
                            || request()->routeIs('flex.addDisciplinary')
                            || request()->routeIs('flex.addPromotion')
                            || request()->routeIs('flex.addIncrement')
                            || request()->routeIs('flex.addTermination')
                            || request()->routeIs('flex.addEmployee')
                            || request()->routeIs('flex.employee')
                            || request()->routeIs('flex.grievancesCompain')
                            || request()->routeIs('flex.promotion')
                            || request()->routeIs('flex.termination')
                            || request()->routeIs('flex.inactive_employee')
                            || request()->routeIs('flex.overtime')
                            || request()->routeIs('imprest.imprest')
                            || request()->routeIs('flex.userprofile')
                            || request()->routeIs('flex.viewProfile')
                            || request()->routeIs('flex.updateEmployee')
                            || request()->routeIs('flex.transfers') ? 'show' : null }}">
                            {{-- start of active employee link --}}
                            @can('view-employee')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.addEmployee') || request()->routeIs('flex.employee') || request()->routeIs('flex.userprofile') || request()->routeIs('flex.viewProfile') || request()->routeIs('flex.updateEmployee') ? 'active' : null }}"
                                        href="{{ route('flex.employee') }}">
                                        <i class="ph-user-circle me-2"></i> Active Employees</a>
                                </li>
                            @endcan
                            {{--  / --}}

                            {{--  start of suspend employee link --}}
                            @can('suspend-employee')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.inactive_employee') ? 'active' : null }}"
                                        href="{{ route('flex.inactive_employee') }}"> <i class="ph-warning-octagon"></i>
                                        Suspended Employees</a>
                                </li>
                            @endcan
                            {{-- / --}}

                            {{--  start of employee termination link --}}
                            @can('view-termination')
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->routeIs('flex.addTermination') || request()->routeIs('flex.termination') ? 'active' : null }}"
                                        href="{{ route('flex.termination') }}"> <i class="ph-user-circle-minus"></i> Employee
                                        Termination</a>
                                </li>
                            @endcan
                            {{-- / --}}

                            {{-- start of promotion/increment link --}}
                            @can('view-promotions')
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->routeIs('flex.addPromotion') || request()->routeIs('flex.addIncrement') || request()->routeIs('flex.promotion') ? 'active' : null }}"
                                        href="{{ route('flex.promotion') }}"><i class="ph-trend-up"></i>
                                        Promotions/Increments</a>
                                </li>
                            @endcan
                            {{-- / --}}


                            {{--  start of overtime link --}}

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('flex.overtime') ? 'active' : null }}"
                                    href="{{ route('flex.overtime') }}"><i class="ph-timer"></i> Overtime </a>
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
                                        href="{{ route('flex.transfers') }}"><i class="ph-note-pencil"></i> Employee
                                        Approval</a></li>
                            @endcan
                            {{-- / --}}

                            {{-- start of displinary  actions link --}}
                            @can('view-grivance')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.addDisciplinary') || request()->routeIs('flex.grievancesCompain') ? 'active' : null }}"
                                        href="{{ route('flex.grievancesCompain') }}"><i class="ph-scales"></i> Disciplinary
                                        Actions</a>
                                </li>
                            @endcan
                            {{-- / --}}

                            {{-- start of  Grievances link --}}
                            @can('view-grivance')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.grievances') ? 'active' : null }}"
                                        href="{{ route('flex.grievances') }}"><i class="ph-smiley-nervous"></i> Employees
                                        Grievance</a>
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
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.submitInputs') ||
                        request()->routeIs('flex.non_statutory_deductions') ||
                        request()->routeIs('flex.statutor   y_deductions') ||
                        request()->routeIs('flex.allowance') ||
                        request()->routeIs('pension_receipt.index') ||
                        request()->routeIs('flex.financial_group') ||
                        request()->routeIs('flex.allowance_overtime') ||
                        request()->routeIs('payroll.payroll') ||
                        request()->routeIs('payroll.employee_payslip') ||
                        request()->routeIs('payroll.comission_bonus') ||
                        request()->routeIs('flex.approved_financial_payments') ||
                        request()->routeIs('payroll.temp_payroll_info') ||
                        request()->routeIs('reports.payrollReconciliationSummary') ||
                        request()->routeIs('reports.payrollReconciliationDetails') ||
                        request()->routeIs('reports.payrolldetails') ||
                        request()->routeIs('reports.payrollReportLogs') ||
                        request()->routeIs('reports.payroll_inputs')
                            ? 'nav-item-expand nav-item-open'
                            : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-calculator"></i>
                            <span>Payroll Management</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.submitInputs') ||
                            request()->routeIs('flex.financial_groups_details') ||
                            request()->routeIs('flex.non_statutory_deductions') ||
                            request()->routeIs('flex.statutory_deductions') ||
                            request()->routeIs('pension_receipt.index') ||
                            request()->routeIs('flex.allowance') ||
                            request()->routeIs('flex.financial_group') ||
                            request()->routeIs('payroll.employee_payslip') ||
                            request()->routeIs('flex.allowance_overtime') ||
                            request()->routeIs('payroll.payroll') ||
                            request()->routeIs('payroll.employee_payslip') ||
                            request()->routeIs('payroll.comission_bonus') ||
                            request()->routeIs('flex.approved_financial_payments') ||
                            request()->routeIs('flex.allowance_category') ||
                            request()->routeIs('payroll.temp_payroll_info') ||
                            request()->routeIs('reports.payrollReconciliationSummary') ||
                            request()->routeIs('reports.payrollReconciliationDetails') ||
                            request()->routeIs('reports.payrolldetails') ||
                            request()->routeIs('reports.payrollReportLogs') ||
                            request()->routeIs('reports.payroll_inputs')
                                ? 'show'
                                : null }}">
                            {{-- start of payroll link --}}
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.financial_group') || request()->routeIs('flex.allowance_overtime') || request()->routeIs('flex.allowance') || request()->routeIs('flex.statutory_deductions') || request()->routeIs('flex.non_statutory_deductions') || request()->routeIs('flex.allowance_category') || request()->routeIs('flex.financial_groups_details') ? 'active' : null }}"
                                    href="{{ route('flex.financial_group') }}"><i class="ph-arrow-circle-right"></i>
                                    Payroll inputs </a></li>
                                    
                            @can('view-payslip')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.submitInputs') ? 'active' : null }}"
                                        href="{{ route('flex.submitInputs') }}"><i class="ph-paper-plane-tilt"></i> Submit Inputs </a></li>
                            @endcan
                            
                            @can('view-payroll')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('payroll.payroll') || request()->routeIs('payroll.temp_payroll_info') || request()->routeIs('reports.payrollReconciliationSummary') || request()->routeIs('reports.payrollReconciliationDetails') || request()->routeIs('reports.payrolldetails') || request()->routeIs('reports.payrollReportLogs') || request()->routeIs('reports.payroll_inputs') ? 'active' : null }}"
                                        href="{{ route('payroll.payroll') }}"><i class="ph-note"></i> Payroll </a></li>
                            @endcan
                            {{-- / --}}
                            @can('view-pending-payments')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.approved_financial_payments') ? 'active' : null }}"
                                        href="{{ route('flex.approved_financial_payments') }}"><i
                                            class="ph-calendar-check"></i>Payroll Approvers </a></li>
                            @endcan

                            {{-- start of payslip link  --}}
                            @can('view-payslip')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('payroll.employee_payslip') ? 'active' : null }}"
                                        href="{{ route('payroll.employee_payslip') }}"><i class="ph-scroll"></i> Payslip </a>
                                </li>
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
                                        href="{{ route('pension_receipt.index') }}"><i class="ph-upload-simple"></i> Upload
                                        Pension Receipt </a></li>
                            @endcan
                            {{-- / --}}

                        </ul>
                    </li>
                @endcan
                {{-- / --}}

                {{-- start of leave management dropdown --}}
                @can('view-leave-management')
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('attendance.leaveforfeiting') || request()->routeIs('attendance.revokeLeave') || request()->routeIs('attendance.leave') || request()->routeIs('flex.end_unpaid_leave') || request()->routeIs('flex.save_unpaid_leave') || request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('flex.unpaid_leave') || request()->routeIs('attendance.leavereport') ? 'nav-item-expand nav-item-open' : null }}">

                        <a href="#" class="nav-link">
                            <i class="ph-calendar-check"></i>
                            <span> Leave Management</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('attendance.leaveforfeiting') || request()->routeIs('attendance.revokeLeave') || request()->routeIs('attendance.leave') || request()->routeIs('flex.unpaid_leave') || request()->routeIs('attendance.leavereport') ? 'show' : null }}">
                            @if (session('mng_attend'))
                                {{-- <li class="nav-item"><a class="nav-link" href="{{ url('/flex/attendance/attendees') }}">Attendance</a></li> --}}
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                                    href="{{ route('attendance.leave') }}"><i class="ph-note-pencil"></i>Leave
                                    Applications</a>
                            </li>



                            {{--  start of unpaid leaves link --}}
                            @can('view-unpaid-leaves')
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('flex.end_unpaid_leave') || request()->routeIs('flex.save_unpaid_leave') || request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('flex.unpaid_leave') ? 'active' : null }}"
                                        href="{{ route('flex.unpaid_leave') }}"><i class="ph-identification-badge"></i>Unpaid
                                        Leaves</a>
                                </li>
                            @endcan
                            {{-- / --}}
                            @can('view-report')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('attendance.leavereport') ? 'active' : null }}"
                                        href="{{ route('attendance.leavereport') }}"><i class="ph-address-book"></i>Leave
                                        History</a></li>
                            @endcan
                            @can('view-forfeitings')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('attendance.leaveforfeiting') ? 'active' : null }}"
                                        href="{{ route('attendance.leaveforfeiting') }}"><i
                                            class="ph-upload-simple"></i>Leave Forfeiting</a></li>
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
                                        href="{{ route('bank-loans') }}"><i class="ph-money"></i>Bank Loans</a></li>
                            @endcan
                            @can('view-loan')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.salary_advance') ? 'active' : null }}"
                                        href="{{ route('flex.salary_advance') }}"><i class="ph-newspaper-clipping"></i> Other
                                        Loans(HESLB)</a></li>
                            @endcan
                            @can('approve-loan')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.confirmed_loans') ? 'active' : null }}"
                                        href="{{ route('flex.confirmed_loans') }}"><i class="ph-check-square"></i> Approved
                                        Loans</a></li>
                            @endcan
                            @can('view-loan-types')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.loan_types') ? 'active' : null }}"
                                        href="{{ route('flex.loan_types') }}"><i class="ph-bag-simple"></i> Loan Types</a>
                                </li>
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
                                    <i class="ph-chalkboard-teacher"></i> Employee Performance
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('flex.performance-pillars') }}"
                                    class="nav-link {{ request()->routeIs('flex.performance-pillars') ? 'active' : null }}">
                                    <i class="ph-pause"></i>Performance Pillars
                                </a>
                            </li>

                        </ul>
                    </li>
                @endcan
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
                                    <i class="ph-users"></i> Employees Profiles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('flex.talent-range') }}"
                                    class="nav-link {{ request()->routeIs('flex.talent-range') ? 'active' : null }} ">
                                    <i class="ph-arrows-horizontal"></i> Talent Ranges
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('flex.talent-matrix') }}" class="nav-link ">
                                    <i class="ph-circles-four"></i> Talent Matrix
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
                                    href="{{ route('flex.department') }}"><i class="ph-browsers"></i>Departments </a>
                            </li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.costCenter') ? 'active' : null }}"
                                    href="{{ route('flex.costCenter') }}"><i class="ph-buildings"></i>Cost Center </a>
                            </li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.branch') ? 'active' : null }}"
                                    href="{{ route('flex.branch') }}"><i class="ph-git-branch"></i>Company Branches </a>
                            </li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.position') ? 'active' : null }}"
                                    href="{{ route('flex.position') }}"><i class="ph-briefcase-metal"></i>Positions</a>
                            </li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.organization_level') ? 'active' : null }}"
                                    href="{{ route('flex.organization_level') }}"><i
                                        class="ph-arrow-fat-lines-up"></i>Organisation Levels </a></li>
                            @if (session('mng_emp'))
                                {{-- <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.contract') ? 'active' : null }}"
                                    href="{{ route('flex.contract') }}">Employee Contracts</a></li> --}}
                            @endif
                            {{-- <li  class="nav-item"><a class="nav-link"  href="{{ route('flex.accountCoding') }}">Account Coding</a></li> --}}

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
                                    href="{{ route('flex.financial_reports') }}"><i class="ph-table"></i>Statutory
                                    Reports </a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.organisation_reports') ? 'active' : null }}"
                                    href="{{ route('flex.organisation_reports') }}"><i
                                        class="ph-chart-line-up"></i>Organisation Reports </a>
                            </li>
                            {{-- For Performance Reports --}}
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.performance-reports') ? 'active' : null }}"
                                    href="{{ route('flex.performance-reports') }}"><i
                                        class="ph-chart-bar"></i>Performance Reports </a>
                            </li>
                            {{-- ./ --}}

                        </ul>
                    </li>
                @endcan
                @can('view-setting')
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.companyInfo')
                        || request()->routeIs('bot.botIndex')
                        || request()->routeIs('flex.updatecompanyInfo')
                        || request()->routeIs('flex.leave-approval')
                        || request()->routeIs('flex.approvals')
                        || request()->routeIs('users.index')
                        || request()->routeIs('permissions.index')
                        || request()->routeIs('flex.roles.index')
                        || request()->routeIs('flex.email-notifications')
                        || request()->routeIs('flex.holidays')
                        || request()->routeIs('flex.permissions')
                        || request()->routeIs('role')
                        || request()->routeIs('flex.bank')
                        || request()->routeIs('flex.audit_logs')
                        || request()->routeIs('flex.passwordAutogenerate')
                        || request()->routeIs('payroll.mailConfiguration') ? 'nav-item-expand nav-item-open' : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-gear-six"></i>
                            <span>Settings</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.companyInfo')
                            || request()->routeIs('bot.botIndex')
                            || request()->routeIs('flex.companyInfo')
                            || request()->routeIs('flex.updatecompanyInfo')
                            || request()->routeIs('flex.leave-approval')
                            || request()->routeIs('flex.approvals')
                            || request()->routeIs('users.index')
                            || request()->routeIs('permissions.index')
                            || request()->routeIs('roles.index')
                            || request()->routeIs('flex.email-notifications')
                            || request()->routeIs('flex.holidays')
                            || request()->routeIs('flex.financial_group')
                            || request()->routeIs('flex.bank')
                            || request()->routeIs('flex.audit_logs')
                            || request()->routeIs('flex.passwordAutogenerate')
                            || request()->routeIs('payroll.mailConfiguration') ? 'show' : null }}">
                            @if (session('mng_roles_grp'))
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.companyInfo') ? 'active' : null }}"
                                        href="{{ route('flex.companyInfo') }}"><i class="ph-house-line"></i>Company
                                        Info</a></li>
                            @endif
                            @if (session('mng_bank_info'))
                                {{-- <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.bank') ? 'active' : null }}"
                                    href="{{ route('flex.bank') }}">Banking Information</a>
                            </li> --}}
                            @endif


                            @can('view-roles')

                            <li class=" nav-item"><a
                                    class="nav-link {{ request()->routeIs('roles.index') ? 'active' : null }} "
                                    href="{{ url('roles') }}">
                                    <i class="ph-person-simple"></i> Roles</a>
                            </li>
                            @endcan



                            <li class=" nav-item"> <a class="nav-link  {{ request()->routeIs('permissions.index') ? 'active' : null }}" href="{{ url('permissions') }}">
                                    <i
                                        class="ph-check-square-offset"></i>Permission</a>

                            </li>

                            <li class=" nav-item "><a
                                    class="nav-link  {{ request()->routeIs('users.index') ? 'active' : null }}"
                                    href="{{ url('users') }}"><i class="ph-user-gear"></i> {{ __('User') }}
                                    Management</a>
                            </li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.holidays') ? 'active' : null }}"
                                    href="{{ route('flex.holidays') }}"><i class="ph-calendar"></i>Holidays</a>
                            </li>


                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.email-notifications') ? 'active' : null }}"
                                    href="{{ route('flex.email-notifications') }}"><i class="ph-envelope-open"></i>Email
                                    Notification</a>
                            </li>

                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.approvals') ? 'active' : null }}"
                                    href="{{ route('flex.approvals') }}"><i class="ph-list-checks"></i>Approvals</a>
                            </li>

                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('flex.leave-approval') ? 'active' : null }}"
                                    href="{{ route('flex.leave-approval') }}"><i class="ph-circle-wavy-check"></i>Leave
                                    Approvals</a>
                            </li>

                            @if (session('mng_audit'))
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.audit_logs') ? 'active' : null }}"
                                        href="{{ route('flex.audit_logs') }}"><i class="ph-path"></i>Audit Trail</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a
                                    class="nav-link {{ request()->routeIs('flex.brand_settings') ? 'active' : null }}"
                                    href="{{ route('flex.brand_settings') }}"><i class="ph-paint-brush-household"></i>Brand Settings</a>
                            </li>



                            @if (session('mng_audit'))
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.passwordAutogenerate') ? 'active' : null }}"
                                        href="{{ route('flex.passwordAutogenerate') }}"><i
                                            class="ph-password"></i>Password Reset</a></li>
                            @endif
                            @if (session('mng_audit'))
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('bot.botIndex') ? 'active' : null }}"
                                        href="{{ route('bot.botIndex') }}"><i class="ph-paper-plane-tilt"></i>Post data
                                        to BOT</a></li>
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
