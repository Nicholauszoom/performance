<div id="add-branch" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bank Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form
            action="{{ route('flex.addBank') }}"
            method="POST"
            class="form-horizontal"
        >
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Bank name</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3"> Abbr</label>
                        <div class="col-sm-9">
                            <input type="text" name="brach_code" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3"> Code</label>
                        <div class="col-sm-9">
                            <input type="text" name="swiftcode" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Bank name</label>
                        <div class="col-sm-9">
                            <input type="text" name="bank" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3"> Abbr</label>
                        <div class="col-sm-9">
                            <input type="text" name="street" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3"> Code</label>
                        <div class="col-sm-9">
                            <input type="text" name="region" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3"> Code</label>
                        <div class="col-sm-9">
                            <input type="text" name="country" class="form-control">
                        </div>
                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom"  >
                     Save bank
                    </button>
                </div>
                {!! Form::close() !!}
        </div>
    </div>
</div>
