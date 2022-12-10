@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/pages/user_pages_profile_tabbed.js') }}"></script>

@endpush

@section('content')

<!-- Inner container -->
<div class="d-lg-flex align-items-lg-start">

    <!-- Left sidebar component -->
    <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none me-lg-3">

        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- Navigation -->
            <div class="card">
                <div class="sidebar-section-body text-center">
                    <div class="card-img-actions d-inline-block mb-3">
                        <img class="img-fluid rounded-circle" src="../../../assets/images/demo/users/face11.jpg" width="150" height="150" alt="">
                        <div class="card-img-actions-overlay card-img rounded-circle">
                            <a href="#" class="btn btn-outline-white btn-icon rounded-pill">
                                <i class="ph-pencil"></i>
                            </a>
                        </div>
                    </div>

                    <h6 class="mb-0">Victoria Davidson</h6>
                    <span class="text-muted">Head of UX</span>
                </div>

                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <span class="nav-link" data-bs-toggle="tab">
                            <i class="ph-calendar me-2"></i>
                            Address
                            <span class="fs-sm fw-normal text-muted ms-auto">02:56pm</span>
                        </span>
                    </li>

                    <li class="nav-item">
                        <span class="nav-link" data-bs-toggle="tab">
                            <i class="ph-envelope me-2"></i>
                            Mobile
                            <span class="badge bg-secondary rounded-pill ms-auto">29</span>
                        </span>
                    </li>

                    <li class="nav-item-divider"></li>

                    <li class="nav-item">
                        <a href="login_advanced.html" class="nav-link" data-bs-toggle="tab">
                            <i class="ph-sign-out me-2"></i>
                            Request profile Update
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /left sidebar component -->


    <!-- Right content -->
    <div class="tab-content flex-fill">

        {{-- profile tab --}}
        <div class="tab-pane fade active show" id="profile">

            {{-- Profile info --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Profile information</h5>
                </div>

                <div class="card-body">
                    <form action="#">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" value="Victoria" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Full name</label>
                                    <input type="text" value="Smith" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Address line 1</label>
                                    <input type="text" value="Ring street 12" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Address line 2</label>
                                    <input type="text" value="building D, flat #67" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" value="Munich" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">State/Province</label>
                                    <input type="text" value="Bayern" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">ZIP code</label>
                                    <input type="text" value="1031" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" readonly="readonly" value="victoria@smith.com" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Your country</label>
                                    <select class="form-select">
                                        <option value="germany" selected>Germany</option>
                                        <option value="france">France</option>
                                        <option value="spain">Spain</option>
                                        <option value="netherlands">Netherlands</option>
                                        <option value="other">...</option>
                                        <option value="uk">United Kingdom</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone #</label>
                                    <input type="text" value="+99-99-9999-9999" class="form-control">
                                    <div class="form-text text-muted">+99-99-9999-9999</div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Upload profile image</label>
                                    <input type="file" class="form-control">
                                    <div class="form-text text-muted">Accepted formats: gif, png, jpg. Max file size 2Mb</div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
            {{--  /profile info --}}

        </div>
        {{-- /profile tab --}}


        {{-- work tab --}}
        <div class="tab-pane fade" id="schedule">

            <!-- Schedule -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">My schedule</h5>
                </div>

                <div class="card-body">
                    <div class="my-schedule"></div>
                </div>
            </div>
            <!-- /schedule -->

        </div>
        {{-- /work tab --}}

        {{-- permission --}}
        <div class="tab-pane fade" id="inbox">

            <!-- My inbox -->
            <div class="card">

            </div>
            <!-- /my inbox -->

        </div>
        {{-- /permission --}}

        <div class="tab-pane fade" id="orders">

            <!-- Orders history -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Orders history (static table)</h5>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th colspan="2">Product name</th>
                                <th>Size</th>
                                <th>Colour</th>
                                <th>Article number</th>
                                <th>Units</th>
                                <th>Price</th>
                                <th class="text-center" style="width: 20px;"><i class="ph-dots-three"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-light">
                                <td colspan="7" class="fw-semibold">New orders</td>
                                <td class="text-end">
                                    <span class="badge bg-secondary rounded-pill">24</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0" style="width: 45px;">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/1.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Fathom Backpack</a>
                                    <div class="d-inline-flex align-items-center text-muted fs-sm">
                                        <span class="bg-secondary rounded-pill p-1 me-1"></span>
                                        Processing
                                    </div>
                                </td>
                                <td>34cm x 29cm</td>
                                <td>Orange</td>
                                <td>
                                    <a href="#">1237749</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 79.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/2.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Mystery Air Long Sleeve T Shirt</a>
                                    <div class="d-inline-flex align-items-center text-muted fs-sm">
                                        <span class="bg-secondary rounded-pill p-1 me-1"></span>
                                        Processing
                                    </div>
                                </td>
                                <td>L</td>
                                <td>Process Red</td>
                                <td>
                                    <a href="#">345634</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 38.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/3.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Women’s Prospect Backpack</a>
                                    <div class="d-inline-flex align-items-center text-muted fs-sm">
                                        <span class="bg-secondary rounded-pill p-1 me-1"></span>
                                        Processing
                                    </div>
                                </td>
                                <td>46cm x 28cm</td>
                                <td>Neu Nordic Print</td>
                                <td>
                                    <a href="#">5739584</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 60.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/4.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Overlook Short Sleeve T Shirt</a>
                                    <div class="d-inline-flex align-items-center text-muted fs-sm">
                                        <span class="bg-secondary rounded-pill p-1 me-1"></span>
                                        Processing
                                    </div>
                                </td>
                                <td>M</td>
                                <td>Gray Heather</td>
                                <td>
                                    <a href="#">434450</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 35.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr class="table-light">
                                <td colspan="7" class="fw-semibold">Shipped orders</td>
                                <td class="text-end">
                                    <span class="badge bg-success rounded-pill">42</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/5.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Infinite Ride Liner</a>
                                    <span class="fs-sm text-muted">10.04.2022</span>
                                </td>
                                <td>43</td>
                                <td>Black</td>
                                <td>
                                    <a href="#">34739</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 210.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/6.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Custom Snowboard</a>
                                    <span class="fs-sm text-muted">09.04.2022</span>
                                </td>
                                <td>151</td>
                                <td>Black/Blue</td>
                                <td>
                                    <a href="#">5574832</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 600.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/7.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Kids' Day Hiker 20L Backpack</a>
                                    <span class="fs-sm text-muted">08.04.2022</span>
                                </td>
                                <td>24cm x 29cm</td>
                                <td>Figaro Stripe</td>
                                <td>
                                    <a href="#">6684902</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 55.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/8.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Lunch Sack</a>
                                    <span class="fs-sm text-muted">07.04.2022</span>
                                </td>
                                <td>24cm x 20cm</td>
                                <td>Junk Food Print</td>
                                <td>
                                    <a href="#">5574829</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 20.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/9.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Cambridge Jacket</a>
                                    <span class="fs-sm text-muted">06.04.2022</span>
                                </td>
                                <td>XL</td>
                                <td>Nomad/Railroad</td>
                                <td>
                                    <a href="#">475839</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 175.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/10.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Covert Jacket</a>
                                    <span class="fs-sm text-muted">05.04.2022</span>
                                </td>
                                <td>XXL</td>
                                <td>Mocha/Glacier Sierra</td>
                                <td>
                                    <a href="#">589439</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 126.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr class="table-light">
                                <td colspan="7" class="fw-semibold">Cancelled orders</td>
                                <td class="text-end">
                                    <span class="badge bg-danger rounded-pill">9</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/11.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Day Hiker Pinnacle 31L Backpack</a>
                                    <span class="fs-sm text-muted">04.04.2022</span>
                                </td>
                                <td>42cm x 26.5cm</td>
                                <td>Blotto Ripstop</td>
                                <td>
                                    <a href="#">5849305</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 130.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/12.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Kids' Gromlet Backpack</a>
                                    <span class="fs-sm text-muted">03.04.2022</span>
                                </td>
                                <td>22cm x 20cm</td>
                                <td>Slime Camo Print</td>
                                <td>
                                    <a href="#">4438495</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 35.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/13.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Tinder Backpack</a>
                                    <span class="fs-sm text-muted">02.04.2022</span>
                                </td>
                                <td>42cm x 26cm</td>
                                <td>Dark Tide Twill</td>
                                <td>
                                    <a href="#">4759383</a>
                                </td>
                                <td>2</td>
                                <td>
                                    <h6 class="mb-0">&euro; 180.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="pe-0">
                                    <a href="#">
                                        <img src="../../../assets/images/demo/products/14.jpeg" height="60" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="d-block fw-semibold">Almighty Snowboard Boot</a>
                                    <span class="fs-sm text-muted">01.04.2022</span>
                                </td>
                                <td>45</td>
                                <td>Multiweave</td>
                                <td>
                                    <a href="#">34432</a>
                                </td>
                                <td>1</td>
                                <td>
                                    <h6 class="mb-0">&euro; 370.00</h6>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-truck me-2"></i>
                                                Track parcel
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-file-arrow-down me-2"></i>
                                                Download invoice
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-wallet me-2"></i>
                                                Payment details
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph-warning-circle me-2"></i>
                                                Report problem
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /orders history -->

        </div>
    </div>

</div>



@endsection
