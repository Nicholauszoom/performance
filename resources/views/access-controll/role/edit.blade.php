<div class="modal fade" role="dialog" id="editRoleModal" aria-labelledby="editRoleModal"
     data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal-content">
            {{ Form::open(['route' => ['roles.update', 1]])}}
            @method('PUT')
            <div class="modal-header p-2 px-2">
                <h4 class="modal-title">EDIT PERMISSION</h4>
            </div>
            <div class="modal-body p-3">
                <div class="form-group">
                    <label class="control-label">Role Name </label>
                    <input type="text" class="form-control" name="slug" id="r-slug_">
                </div>
                <input type="hidden" name="id" id="r-id_">
            </div>
            <div class="modal-footer p-0">
                <div class="p-2">
                   <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                   <button class="btn btn-main"  type="submit" id="save" ><i class="ph-check mr-1"></i> Save</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
