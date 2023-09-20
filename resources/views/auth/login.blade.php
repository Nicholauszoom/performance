<form action="{{ route('login') }}" method="POST" class="" autocomplete="off">
    @csrf

    <div class=" border-bottom-main mb-0 pt-4">
        <div class="">
            {{-- <div class="text-center  mb-2 mt-1"> --}}
                {{-- <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                    <img src="{{ asset('img/performance.png') }}" class="img-fluid" style="height: 13.2em" alt="logo">
                </div> --}}
            {{-- </div> --}}

            {{-- @if (Session::has('password_set'))
                <div class="alert alert-success" role="alert">
                    <p>{{ Session::get('password_set') }}</p>
                </div>
                @endif --}}
            {{-- @if (session()->has('password_set'))
            <div
                class="alert alert-success border-0 alert-dismissible fade show mb-3">
                <span class="fw-semibold">Success!!!</span>
                {{ session('password_set') }}.

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if (session()->has('status'))
            <div
                class="alert alert-danger border-0 alert-dismissible fade show mb-3">
                <span class="fw-semibold">Oh snap!</span>
                {{ session('status') }}.

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @else --}}

            @if ($errors->any())
            <div
                class="alert alert-danger border-0 alert-dismissible fade show mb-3">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li> {{ $error }}</li>
                    @endforeach
                </ul>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            {{-- @endif --}}
            @if ($next)
                <input name="next" type="hidden" value="{{ $next }}">
            @endif
            <div class="mb-3">
                <label class="form-label text-main font-weight-bold">Payroll Number</label>

                <div class="form-control-feedback form-control-feedback-start">
                    <input
                        class="form-control @if ($errors->has('emp_id')) is-invalid @endif"
                        name="emp_id" type="text" id="emp-id1" required
                        placeholder="username" autocomplete="off">

                    <div class="form-control-feedback-icon">
                        <i class="ph-user-circle text-muted"></i>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-main">Password</label>

                <div class="form-control-feedback form-control-feedback-start">
                    <input type="password" id="password1"
                        class="form-control @if ($errors->has('password')) is-invalid @endif"
                        placeholder="password" name="password" required
                        autocomplete="off">

                    <div class="form-control-feedback-icon">
                        <i class="ph-lock text-muted"></i>
                    </div>
                </div>
            </div>

            <div class="mb-1 mt-3">
                <button type="submit" class="btn btn-main  w-100 border-0" style="background: #00204e">Log In</button>
            </div>

            <div class="text-center mt-2">
                <a href="{{ url('forgot-password') }}" class="ms-auto text-main">Forgot password?</a>
            </div>

            <div class="">
                <div class="d-flex justify-content-end"><img src="{{ asset('assets/images/hc-hub-logo3.png') }}" alt="HC-HUB logo" height="100px" width="100px" class="img-fluid"></div>
            </div>
        </div>
    </div>
</form>
