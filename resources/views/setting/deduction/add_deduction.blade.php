<div id="save_deduction" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deduction Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('flex.addDeduction') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Deduction name</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Amount</label>
                        <div class="col-sm-9">
                            <input type="text" name="amount" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3"> Code</label>
                        <div class="col-sm-9">
                            <input type="text" name="code" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Percent</label>
                        <div class="col-sm-9">
                            <input type="text" name="percent" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Apply_to</label>
                        <div class="col-sm-9">
                            <input type="text" name="apply_to" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3"> Mode</label>
                        <div class="col-sm-9">
                            <input type="text" name="mode" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3"> State</label>
                        <div class="col-sm-9">
                            <input type="text" name="state" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-perfrom">
                            Save bank
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
        </div>
    </div>
