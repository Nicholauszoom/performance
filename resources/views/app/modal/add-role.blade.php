<div id="add-role" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Roles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="post" action="{{ route('flex.role') }}" class="form-horizontal">
               @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Role name</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="type" value="addrole">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom">Save Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
