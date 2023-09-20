<form action="{{ route('login') }}" method="POST" class="" autocomplete="off">
    @csrf

    <div class=" border-bottom-main mb-0 pt-4">

            <div class="mb-3">
                <label class="form-label text-main font-weight-bold">Payroll Number</label>

                    <input
                        class="form-control"
                        name="emp_id" type="text"  required
                        placeholder="username" autocomplete="off">

                    <div class="form-control-feedback-icon">
                        <i class="ph-user-circle text-muted"></i>
                    </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-main">Password</label>

                    <input type="password"
                        placeholder="password" name="password" required
                        autocomplete="off">

                    <div class="form-control-feedback-icon">
                        <i class="ph-lock text-muted"></i>
                    </div>
            </div>

            <div class="mb-1 mt-3">
                <button type="submit" class="btn btn-main  w-100 border-0" style="background: #00204e">Log In</button>
            </div>

    </div>
</form>
