<div id="modal_form_horizontal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Department Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form
                action="#"
                class="form-horizontal"
            >
                @csrf

                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Department Name :</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Eugene" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom">Save Department</button>
                </div>
            </form>
        </div>
    </div>
</div>
