<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.shared.title-meta', ['title' => $title])
        @include('layouts.shared.head-css')

        <script src="{{ asset('assets/notification/js/bootstrap-growl.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('assets/notification/css/notification.min.css') }}">
        <script src="{{ asset('assets/loader.js') }}"></script>

        <style>
            .request__spinner {
                /* background: red; */
                /* position: absolute;
                z-index: 99999;
                left: 50%;
                top: 50%;
                display: none;
                width: 50px;
                height: 50px;
                margin: 20px auto;
                border: 5px solid rgba(0, 0, 0, 0.1);
                border-left: 5px solid #003366;
                border-right: 5px solid #003366;
                animation: request__spinner 1s linear infinite forwards;
                -webkit-border-radius: 50%;
                -moz-border-radius: 50%;
                -o-border-radius: 50%;
                -ms-border-radius: 50%;
                border-radius: 50%; */

                position: absolute;
                top: calc(50% - 15px);
                left: calc(50% - 15px);
                width: 40px;
                height: 40px;
                border: 4px solid #a9a9a9;
                border-top-color: #000;
                border-radius: 30px;
                animation: spin 1s linear infinite;
                display: none;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            body {
                background-image: url('{{ asset('img/bg2.png') }}');
                /* background-color: #f1f1f1; */
                background-color: #ffff;
                /* background: cover; */
                background-position:center;
                background-repeat: no-repeat;
            }

            .card {
                background-color: transparent !important;
            }


            .loader {
                height: 100vh;
                width: 100vw;
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
                background: #ffffff;
                z-index: 99;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .removed{
                opacity: 0;
                transition: opacity 0.5s ease;
            }

            .loader--dot {
                animation-name: loader;
                animation-timing-function: ease-in-out;
                animation-duration: 3s;
                animation-iteration-count: infinite;
                height: 20px;
                width: 20px;
                border-radius: 100%;
                background-color: black;
                position: absolute;
                border: 2px solid white;
            }

            .loader--dot:first-child {
                background-color: #8cc759;
                animation-delay: 0.5s;
            }

            .loader--dot:nth-child(2) {
                background-color: #8c6daf;
                animation-delay: 0.4s;
            }

            .loader--dot:nth-child(3) {
                background-color: #ef5d74;
                animation-delay: 0.3s;
            }

            .loader--dot:nth-child(4) {
                background-color: #f9a74b;
                animation-delay: 0.2s;
            }

            .loader--dot:nth-child(5) {
                background-color: #60beeb;
                animation-delay: 0.1s;
            }

            .loader--dot:nth-child(6) {
                background-color: #fbef5a;
                animation-delay: 0s;
            }

            .loader--text {
                position: absolute;
                top: 200%;
                left: 0;
                right: 0;
                width: 10rem;
                margin: auto;
            }

            .loader--text:after {
                content: "Loading ...";
                font-weight: bold;
                animation-name: loading-text;
                animation-duration: 3s;
                animation-iteration-count: infinite;
            }

            @keyframes loader {
                15% {
                    transform: translateX(0);
                }
                45% {
                    transform: translateX(230px);
                }
                65% {
                    transform: translateX(230px);
                }
                95% {
                    transform: translateX(0);
                }
            }

            @keyframes loading-text {
                0% {
                    content: "Loading";
                }
                25% {
                    content: "Loading .";
                }
                50% {
                    content: "Loading  ..";
                }
                75% {
                    content: "Loading  ...";
                }
            }
        </style>
    </head>

    <body>
        <div class="request__spinner"></div>

        <div class="page-content">
            {{-- page loader --}}
            <div id="loadingOverlay" class="loading-overlay">
                <div class='loader' id="element-to-remove">
                        <div class='loader--dot'></div>
                        <div class='loader--dot'></div>
                        <div class='loader--dot'></div>
                        <div class='loader--dot'></div>
                        <div class='loader--dot'></div>
                        <div class='loader--dot'></div>
                        <div class='loader--text'></div>
                    </div>
            </div>
            {{-- / Page loader --}}

            {{-- Left sidebar --}}
            @include('layouts.shared.left-sidebar')
            {{-- /Left sidebar --}}

            {{-- main content --}}
            <div class="content-wrapper">

                @include('layouts.shared.topbar')


                {{-- Inner content --}}
                <div class="content-inner">
                    {{-- Page header --}}
                    <div class="page-header page-header-light shadow">
                        @include('layouts.shared.page-header')
                    </div>
                    {{-- /Page header --}}

                    {{-- Content area --}}
                    <div class="content">
                        @include('layouts.alerts.message')

                        @if ($errors->any())
                        <div class="btn disabled btn-danger ">
                            <div class="col-12">
                                @foreach ($errors->all() as $error)
                                <p>{{$error}}</p>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @yield('content')
                    </div>
                    {{-- /Content area --}}

                    @include('layouts.shared.footer')

                </div>
                {{-- /Inner content --}}

            </div>
            {{-- /Main content --}}

        </div>

        <!-- Notifications -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="notifications">
            <div class="offcanvas-header py-0">
                <h5 class="offcanvas-title py-3">Activity</h5>
                <button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill" data-bs-dismiss="offcanvas">
                    <i class="ph-x"></i>
                </button>
            </div>

            <div class="offcanvas-body p-0">
                <div class="bg-light fw-medium py-2 px-3">New notifications</div>
                <div class="p-3">
                    <div class="d-flex align-items-start mb-3">
                        <a href="#" class="status-indicator-container me-3">
                            <img src="../../../assets/images/demo/users/face1.jpg" class="w-40px h-40px rounded-pill" alt="">
                            <span class="status-indicator bg-success"></span>
                        </a>
                        <div class="flex-fill">
                            <a href="#" class="fw-semibold">James</a> has completed the task <a href="#">Submit documents</a> from <a href="#">Onboarding</a> list

                            <div class="bg-light rounded p-2 my-2">
                                <label class="form-check ms-1">
                                    <input type="checkbox" class="form-check-input" checked disabled>
                                    <del class="form-check-label">Submit personal documents</del>
                                </label>
                            </div>

                            <div class="fs-sm text-muted mt-1">2 hours ago</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <a href="#" class="status-indicator-container me-3">
                            <img src="../../../assets/images/demo/users/face3.jpg" class="w-40px h-40px rounded-pill" alt="">
                            <span class="status-indicator bg-warning"></span>
                        </a>
                        <div class="flex-fill">
                            <a href="#" class="fw-semibold">Margo</a> has added 4 users to <span class="fw-semibold">Customer enablement</span> channel

                            <div class="d-flex my-2">
                                <a href="#" class="status-indicator-container me-1">
                                    <img src="../../../assets/images/demo/users/face10.jpg" class="w-32px h-32px rounded-pill" alt="">
                                    <span class="status-indicator bg-danger"></span>
                                </a>
                                <a href="#" class="status-indicator-container me-1">
                                    <img src="../../../assets/images/demo/users/face11.jpg" class="w-32px h-32px rounded-pill" alt="">
                                    <span class="status-indicator bg-success"></span>
                                </a>
                                <a href="#" class="status-indicator-container me-1">
                                    <img src="../../../assets/images/demo/users/face12.jpg" class="w-32px h-32px rounded-pill" alt="">
                                    <span class="status-indicator bg-success"></span>
                                </a>
                                <a href="#" class="status-indicator-container me-1">
                                    <img src="../../../assets/images/demo/users/face13.jpg" class="w-32px h-32px rounded-pill" alt="">
                                    <span class="status-indicator bg-success"></span>
                                </a>
                                <button type="button" class="btn btn-light btn-icon d-inline-flex align-items-center justify-content-center w-32px h-32px rounded-pill p-0">
                                    <i class="ph-plus ph-sm"></i>
                                </button>
                            </div>

                            <div class="fs-sm text-muted mt-1">3 hours ago</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="me-3">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-pill">
                                <i class="ph-warning p-2"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            Subscription <a href="#">#466573</a> from 10.12.2021 has been cancelled. Refund case <a href="#">#4492</a> created
                            <div class="fs-sm text-muted mt-1">4 hours ago</div>
                        </div>
                    </div>
                </div>

                <div class="bg-light fw-medium py-2 px-3">Older notifications</div>
                <div class="p-3">
                    <div class="d-flex align-items-start mb-3">
                        <a href="#" class="status-indicator-container me-3">
                            <img src="../../../assets/images/demo/users/face25.jpg" class="w-40px h-40px rounded-pill" alt="">
                            <span class="status-indicator bg-success"></span>
                        </a>
                        <div class="flex-fill">
                            <a href="#" class="fw-semibold">Nick</a> requested your feedback and approval in support request <a href="#">#458</a>

                            <div class="my-2">
                                <a href="#" class="btn btn-success btn-sm me-1">
                                    <i class="ph-checks ph-sm me-1"></i>
                                    Approve
                                </a>
                                <a href="#" class="btn btn-light btn-sm">
                                    Review
                                </a>
                            </div>

                            <div class="fs-sm text-muted mt-1">3 days ago</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <a href="#" class="status-indicator-container me-3">
                            <img src="../../../assets/images/demo/users/face24.jpg" class="w-40px h-40px rounded-pill" alt="">
                            <span class="status-indicator bg-grey"></span>
                        </a>
                        <div class="flex-fill">
                            <a href="#" class="fw-semibold">Mike</a> added 1 new file(s) to <a href="#">Product management</a> project

                            <div class="bg-light rounded p-2 my-2">
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <img src="../../../assets/images/icons/pdf.svg" width="34" height="34" alt="">
                                    </div>
                                    <div class="flex-fill">
                                        new_contract.pdf
                                        <div class="fs-sm text-muted">112KB</div>
                                    </div>
                                    <div class="ms-2">
                                        <button type="button" class="btn btn-flat-dark text-body btn-icon btn-sm border-transparent rounded-pill">
                                            <i class="ph-arrow-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="fs-sm text-muted mt-1">1 day ago</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <div class="me-3">
                            <div class="bg-success bg-opacity-10 text-success rounded-pill">
                                <i class="ph-calendar-plus p-2"></i>
                            </div>
                        </div>
                        <div class="flex-fill">
                            All hands meeting will take place coming Thursday at 13:45.

                            <div class="my-2">
                                <a href="#" class="btn btn-primary btn-sm">
                                    <i class="ph-calendar-plus ph-sm me-1"></i>
                                    Add to calendar
                                </a>
                            </div>

                            <div class="fs-sm text-muted mt-1">2 days ago</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <a href="#" class="status-indicator-container me-3">
                            <img src="../../../assets/images/demo/users/face4.jpg" class="w-40px h-40px rounded-pill" alt="">


                            <span class="status-indicator bg-danger"></span>
                        </a>
                        <div class="flex-fill">
                            <a href="#" class="fw-semibold">Christine</a> commented on your community <a href="#">post</a> from 10.12.2021

                            <div class="fs-sm text-muted mt-1">2 days ago</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <div class="me-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-pill">
                                <i class="ph-users-four p-2"></i>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <span class="fw-semibold">HR department</span> requested you to complete internal survey by Friday

                            <div class="fs-sm text-muted mt-1">3 days ago</div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /notifications -->

        @yield('modal')

        @stack('footer-script')
    </body>

</html>
