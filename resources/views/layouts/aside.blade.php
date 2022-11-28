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
                    <a href = " {{ url('dashboard') }}" class="nav-link  {{ (request()->is('dashboard')) ? 'active' : ''  }}">
                        <i class="icon-home"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>

                @can('view-cargo-list')
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link "><i class="icon-package"></i> <span>Cargo Management</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('view-cargo-list')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('pacel_name.*')) ? 'active' : ''  }}"
                                href="{{url('pacel_name')}}">Pacel Name List</a></li>
                        @endcan
                        @can('view-cargo-client-list')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('client.*')) ? 'active' : ''  }}"
                                href="{{url('client')}}">Client List</a></li>
                        @endcan
                        @can('view-cargo-quotation')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('pacel_quotation.*')) ? 'active' : ''  }}"
                                href="{{url('pacel_quotation')}}">Quotation</a></li>
                        @endcan
                        @can('view-cargo-invoice')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('pacel_invoice.*')) ? 'active' : ''  }}"
                                href="{{url('pacel_invoice')}}">Invoice</a></li>
                        @endcan
                        @can('view-cargo-mileage')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('mileage.*')) ? 'active' : ''  }}"
                                href="{{url('mileage')}}">Mileage List</a></li>
                        @endcan
                        @can('view-cargo-permit')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('permit.*')) ? 'active' : ''  }}"
                                href="{{url('permit')}}">Border Permit List</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('manage-orders')
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link "><i class="icon-cart"></i> <span>Cargo Tracking</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('view-cargo-collection')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('collection.*')) ? 'active' : ''  }}"
                                href="{{url('collection')}}"> Cargo List</a></li>
                        @endcan
                        @can('view-cargo-loading')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('loading.*')) ? 'active' : ''  }}"
                                href="{{url('loading')}}"> Loading</a></li>
                        @endcan
                        @can('view-cargo-offloading')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('offloading.*')) ? 'active' : ''  }}"
                                href="{{url('offloading')}}"> Offloading</a></li>
                        @endcan
                        @can('view-cargo-delivering')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('delivering.*')) ? 'active' : ''  }}"
                                href="{{url('delivering')}}">Delivery</a></li>
                        @endcan
                        @can('view-cargo-wb')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('wb.*')) ? 'active' : ''  }}"
                                href="{{url('wb')}}">Create WB</a></li>
                        @endcan
                        @can('view-cargo-activity')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('activity.*')) ? 'active' : ''  }}"
                                href="{{url('activity')}}">Track Logistic Activity</a>
                        </li>
                        @endcan
                        @can('view-cargo-order_report')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('order_report.*')) ? 'active' : ''  }}"
                                href="{{url('order_report')}}">Uplift Report</a></li>
                        @endcan
                        @can('view-cargo-truck_mileage')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('truck_mileage.*')) ? 'active' : ''  }}"
                                href="{{url('truck_mileage')}}">Return Truck Fuel &
                                Mileage</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan





                @can('manage-payroll')
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link {{ (request()->is('payroll/*')) ? 'active' : ''  }}"><i
                            class="icon-calculator"></i> <span>Payroll</span></a>

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








                @can('manage-courier')
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link "><i class="icon-copy"></i> <span>Courier Management</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('view-courier_list')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('courier_list.*')) ? 'active' : ''  }}"
                                href="{{url('courier_list')}}">Item List</a></li>
                        @endcan
                        @can('view-courier_client')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('courier_client.*')) ? 'active' : ''  }}"
                                href="{{url('courier_client')}}">Client List</a></li>
                        @endcan
                        @can('view-courier_quotation')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('courier_quotation.*')) ? 'active' : ''  }}"
                                href="{{url('courier_quotation')}}">Quotation</a></li>
                        @endcan
                        @can('view-courier_invoice')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('courier_invoice.*')) ? 'active' : ''  }}"
                                href="{{url('courier_invoice')}}">Invoice</a></li>
                        @endcan

                        @can('view-courier_collection')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('courier_collection.*')) ? 'active' : ''  }}"
                                href="{{url('courier_collection')}}"> Courier
                                Collection</a></li>
                        @endcan
                        @can('view-courier_loading')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('courier_loading.*')) ? 'active' : ''  }}"
                                href="{{url('courier_loading')}}"> Courier Loading</a>
                        </li>
                        @endcan
                        @can('view-courier_offloading')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('courier_offloading.*')) ? 'active' : ''  }}"
                                href="{{url('courier_offloading')}}"> Courier
                                Offloading</a></li>
                        @endcan
                        @can('view-courier_delivering')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('courier_delivering.*')) ? 'active' : ''  }}"
                                href="{{url('courier_delivering')}}"> Courier
                                Delivery</a></li>
                        @endcan
                        @can('view-courier_activity')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('courier_activity.*')) ? 'active' : ''  }}"
                                href="{{url('courier_activity')}}">Track Courier
                                Activity</a></li>
                        @endcan
                        @can('view-courier_activity')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('courier_activity.*')) ? 'active' : ''  }}"
                                href="{{url('courier_activity')}}"> Courier Uplift
                                Report</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan



                @can('manage-logistic')
                <li class="nav-item"><a class="nav-link {{ (request()->is('routes.*')) ? 'active' : ''  }}"
                        href="{{url('routes')}}"><i data-feather="command" class="icon-road"></i><span>Routes</span></a>
                </li>
                @endcan

                @can('view-supplier')
                <li class="nav-item"><a class="nav-link {{ (request()->is('supplier.*')) ? 'active' : ''  }}"
                        href="{{url('supplier')}}"><i data-feather="command"
                            class="icon-cart"></i><span>Suppliers</span></a>
                </li>
                @endcan

                @can('manage-inventory')
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link "><i class="icon-car"></i> <span>Tire
                            Management</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('view-tyre_brand')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('tyre_brand.*')) ? 'active' : ''  }}"
                                href="{{url('tyre_brand')}}">Tire Brand</a></li>
                        @endcan
                        @can('view-purchase_tyre')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('purchase_tyre.*')) ? 'active' : ''  }}"
                                href="{{url('purchase_tyre')}}">Purchase Tire</a></li>
                        @endcan
                        @can('view-tyre_list')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('tyre_list.*')) ? 'active' : ''  }}"
                                href="{{url('tyre_list')}}">Tire List</a></li>
                        @endcan
                        @can('view-assign_truck')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('assign_truck.*')) ? 'active' : ''  }}"
                                href="{{url('assign_truck')}}">Assign Truck</a></li>
                        @endcan
                        @can('view-tyre_return')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('tyre_return.*')) ? 'active' : ''  }}"
                                href="{{url('tyre_return')}}">Tire Return</a></li>
                        @endcan
                        @can('view-tyre_reallocation')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('tyre_reallocation.*')) ? 'active' : ''  }}"
                                href="{{url('tyre_reallocation')}}">Tire
                                Reallocation</a></li>
                        @endcan
                        @can('view-tyre_disposal')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('tyre_disposal.*')) ? 'active' : ''  }}"
                                href="{{url('tyre_disposal')}}">Tire Disposal</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan


                @can('manage-inventory')
                <li class="nav-item nav-item-submenu">
                    <a href="#inventory" class="nav-link {{ (request()->is('inventory/*')) ? 'active' : ''  }}"
                        data-toggle="collapse" class="dropdown-toggle">

                        <i class="icon-hammer2"></i><span>Inventory</span>


                    </a>
                    <ul class="nav nav-group-sub" id="inventory" data-parent="#accordionExample">

                        @can('view-location')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('location/*')) ? 'active' : ''  }}"
                                href="{{ url('location') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Location')}}</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-inventory')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('inventory/*')) ? 'active' : ''  }}"
                                href="{{ url('inventory') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Inventory Items')}}</span>

                            </a>
                        </li>

                        @endcan
                        @can('view-fieldstaff')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('fieldstaff/*')) ? 'active' : ''  }}"
                                href="{{ url('fieldstaff') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Field Staff')}}</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-purchase_inventory')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('purchase_inventory/*')) ? 'active' : ''  }}"
                                href="{{ url('purchase_inventory') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Purchase Inventory')}}</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-inventory_list')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('inventory_list/*')) ? 'active' : ''  }}"
                                href="{{ url('inventory_list') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Inventory List')}}</span>

                            </a>
                        </li>
                        @endcan

                        @can('view-inventory_list')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('service_type/*')) ? 'active' : ''  }}"
                                href="{{ url('service_type') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> Service Type</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-maintainance')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('maintainance/*')) ? 'active' : ''  }}"
                                href="{{ url('maintainance') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> Maintainance</span>

                            </a>
                        </li>
                        @endcan

                        @can('view-service')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('service/*')) ? 'active' : ''  }}"
                                href="{{ url('service') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> Service</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-service')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('good_issue/*')) ? 'active' : ''  }}"
                                href="{{ url('good_issue') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Good Issue')}}</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-good_return')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('good_return/*')) ? 'active' : ''  }}"
                                href="{{ url('good_return') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Good Return')}}</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-good_return')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('good_movement/*')) ? 'active' : ''  }}"
                                href="{{ url('good_movement') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Good Movement')}}</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-good_reallocation')
                        <li class="nav-item  ">
                            <a class="nav-link {{ (request()->is('good_reallocation/*')) ? 'active' : ''  }}"
                                href="{{ url('good_reallocation') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Good Reallocation')}}</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-good_disposal')
                        <li class="nav-item ">
                            <a class="nav-link {{ (request()->is('good_disposal/*')) ? 'active' : ''  }}"
                                href="{{ url('good_disposal') }}" aria-expanded="false" class="dropdown-toggle">

                                <span> {{__('Good Disposal')}}</span>

                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
                @endcan






                @can('manage-logistic')
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link {{ (request()->is('truck/*')) ? 'active' : ''  }} "><i
                            class="icon-truck"></i> <span>
                            Truck & Driver</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                        @can('view-truck')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('truck.*')) ? 'active' : ''  }}"
                                href="{{url('truck')}}">Truck Management</a></li>
                        @endcan
                        @can('view-driver')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('driver.*')) ? 'active' : ''  }}"
                                href="{{url('driver')}}">Driver Management</a></li>
                        @endcan
                        @can('view-fuel')
                        <li class="nav-item"><a class="nav-link {{ (request()->is('fuel.*')) ? 'active' : ''  }}"
                                href="{{url('fuel')}}">Fuel Control</a></li>
                        <li class="nav-item"><a class="nav-link {{ (request()->is('return_fuel*')) ? 'active' : ''  }}"
                                href="{{url('return_fuel')}}">Return Fuel </a></li>
                        <li class="nav-item"><a class="nav-link {{ (request()->is('refill_list')) ? 'active' : ''  }}"
                                href="{{url('refill_list')}}">Refill List</a></li>
                        <li class="nav-item"><a class="nav-link {{ (request()->is('fuel_report')) ? 'active' : ''  }}"
                                href="{{url('fuel_report')}}">Fuel Report</a></li>

                        @endcan
                        @can('view-connect')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('connect_driver.*')) ? 'active' : ''  }}"
                                href="{{url('connect_driver')}}">Assign & Remove
                                Driver</a></li>
                        @endcan

                        @can('view-connect')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('connect_trailer.*')) ? 'active' : ''  }}"
                                href="{{url('connect_trailer')}}">Connect & Disconnect
                                Trailer</a></li>
                        @endcan
                        @can('view-connect')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('assign_driver.*')) ? 'active' : ''  }}"
                                href="{{url('assign_driver')}}">Assign Equipment to
                                Truck</a></li>
                        @endcan
                        @can('view-connect')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('reverse_assign_driver.*')) ? 'active' : ''  }}"
                                href="{{url('reverse_assign_driver')}}">Reversed Truck
                                Equipment</a>
                        </li>
                        @can('view-connect')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('truck_report.*')) ? 'active' : ''  }}"
                                href="{{url('truck_report')}}">Truck Report</a></li>
                        @endcan
                        @can('view-connect')
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('truck_summary.*')) ? 'active' : ''  }}"
                                href="{{url('truck_summary')}}">Truck Summary</a></li>
                        @endcan
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

                @can('manage-transaction')
                <li class="nav-item nav-item-submenu">
                    <a href="#transaction" class="nav-link" data-toggle="collapse" class="dropdown-toggle">

                        <i class="icon-diamond"></i><span>Transaction</span>



                    </a>
                    <ul class="nav nav-group-sub" id="transaction" data-parent="#accordionExample">
                        @can('view-deposit')
                        <li class="nav-item ">
                            <a class="nav-link " href="{{ url('deposit') }}" aria-expanded="false"
                                class="dropdown-toggle">

                                <span>Deposit</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-expenses')
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('expenses') }}" aria-expanded="false"
                                class="dropdown-toggle">

                                <span>Payments</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-expenses')
                        <li class="nav-item ">
                            <a class="nav-link " href="{{ url('transfer2') }}" aria-expanded="false"
                                class="dropdown-toggle">

                                <span> Transfer</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-expenses')
                        <li class="nav-item ">
                            <a class="nav-link " href="{{ url('account') }}" aria-expanded="false"
                                class="dropdown-toggle">

                                <span> Bank & Cash</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-bank_statement')
                        <li class="nav-item ">
                            <a class="nav-link " href="{{ url('accounting/bank_statement') }}" aria-expanded="false"
                                class="dropdown-toggle">

                                <span> Bank Statement</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-bank_reconciliation')
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('accounting/bank_reconciliation') }}" aria-expanded="false"
                                class="dropdown-toggle">

                                <span> Bank Reconciliation</span>

                            </a>
                        </li>
                        @endcan
                        @can('view-reconciliation_report')
                        <li class="nav-item ">
                            <a class="nav-link " href="{{ url('accounting/reconciliation_report') }}"
                                aria-expanded="false" class="dropdown-toggle">

                                <span> Bank Reconciliation Report</span>

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



                    @can('view-debtor-report')
                    <li class="nav-item"><a
                            class="nav-link {{ (request()->is('reports/debtors_report.*')) ? 'active' : ''  }}"
                            href="{{url('reports/debtors_report')}}"> Debtors
                            Report</a></li>
                    @endcan

                    @can('view-debtor-report')
                    <li class="nav-item"><a
                            class="nav-link {{ (request()->is('reports/debtors_summary_report.*')) ? 'active' : ''  }}"
                            href="{{url('reports/debtors_summary_report')}}"> Debtors Summary
                            Report</a></li>
                    @endcan

                    @can('view-debtor-report')
                    <li class="nav-item"><a
                            class="nav-link {{ (request()->is('reports/deposit_report.*')) ? 'active' : ''  }}"
                            href="{{url('reports/deposit_report')}}">Deposit
                            Report</a></li>
                    @endcan

                    @can('view-debtor-report')
                    <li class="nav-item"><a
                            class="nav-link {{ (request()->is('reports/client_summary.*')) ? 'active' : ''  }}"
                            href="{{url('reports/client_summary')}}"> Client Summary
                            Report</a></li>
                    @endcan

                    @can('view-creditor-report')
                    <li class="nav-item"><a
                            class="nav-link {{ (request()->is('reports/creditors_report*')) ? 'active' : ''  }}"
                            href="{{url('reports/creditors_report')}}"> Creditors Report</a></li>
                    @endcan

                    @can('view-cargo-activity')
                    <li class="nav-item"><a class="nav-link {{ (request()->is('activity.*')) ? 'active' : ''  }}"
                            href="{{url('activity')}}">Track Logistic Activity</a>
                    </li>
                    @endcan
                    @can('view-cargo-order_report')
                    <li class="nav-item"><a class="nav-link {{ (request()->is('order_report.*')) ? 'active' : ''  }}"
                            href="{{url('order_report')}}">Uplift Report</a></li>
                    @endcan
                    @can('view-payroll_summary')
                    <li class="nav-item"><a
                            class="nav-link {{ (request()->is('payroll/payroll_summary*')) ? 'active' : ''  }}"
                            href="{{url('payroll/payroll_summary')}}">Payroll
                            Summary</a></li>
                    @endcan

                    @can('view-tyre_list')
                    <li class="nav-item"><a
                            class="nav-link {{ (request()->is('reports/tyre_report.*')) ? 'active' : ''  }}"
                            href="{{url('reports/tyre_report')}}">Tire Report</a></li>
                    @endcan

                    @can('view-tyre_list')
                    <li class="nav-item"><a class="nav-link {{ (request()->is('tyre_list.*')) ? 'active' : ''  }}"
                            href="{{url('tyre_list')}}">Tire List</a></li>
                    @endcan
                    @can('view-inventory_list')
                    <li class="nav-item ">
                        <a class="nav-link {{ (request()->is('inventory_list/*')) ? 'active' : ''  }}"
                            href="{{ url('inventory_list') }}" aria-expanded="false" class="dropdown-toggle">

                            <span> {{__('Inventory List')}}</span>
                            @endcan

                            @can('view-inventory_list')
                    <li class="nav-item"><a
                            class="nav-link {{ (request()->is('reports/inventory_report.*')) ? 'active' : ''  }}"
                            href="{{url('reports/inventory_report')}}">Inventory Report</a></li>
                    @endcan
                    @can('view-connect')
                    <li class="nav-item"><a class="nav-link {{ (request()->is('truck_report.*')) ? 'active' : ''  }}"
                            href="{{url('truck_report')}}">Truck Report</a></li>
                    </a>
            </li>
            @endcan

            @can('view-connect')
            <li class="nav-item"><a class="nav-link {{ (request()->is('truck_summary.*')) ? 'active' : ''  }}"
                    href="{{url('truck_summary')}}">Truck Summary</a></li>
            @endcan

            @can('view-fuel')
            <li class="nav-item"><a class="nav-link {{ (request()->is('fuel_report')) ? 'active' : ''  }}"
                    href="{{url('fuel_report')}}">Fuel Report</a></li>

            @endcan

            @can('view-journal')
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('accounting/journal*')) ? 'active' : ''  }}"
                    href="{{ url('accounting/journal') }}" aria-expanded="false" class="dropdown-toggle">

                    <span> Journal Entry Report</span>

                </a>
            </li>
            @endcan

            @can('view-bank_statement')
            <li class="nav-item ">
                <a class="nav-link " href="{{ url('accounting/bank_statement') }}" aria-expanded="false"
                    class="dropdown-toggle">

                    <span> Bank Statement</span>

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
                        <a class="nav-link " href="{{ route('auditTrail.index') }}"> {{__('Audit Trail')}}</a>
                    </li>

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
                        <a class="nav-link {{ request()->is('users') ? 'active' : '' }}"
                            href="{{ url('users') }}">User Management </a>
                    </li>

                </ul>
            </li>


            </ul>
        </div>
        <!-- /main navigation -->


    </div>

    <!-- /sidebar content -->

</div>
