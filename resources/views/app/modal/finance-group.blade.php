<div id="add-finance-group" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Finencial Based-Group of Employees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route("flex.financial_group") }}" method="POST" class="form-horizontal">
               @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Group name</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Group By</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="grouped_by">
                                <option value="1">Employee</option>
                                <option value="2">Role</option>
                            </select>
                           
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom">
                     Save group
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
