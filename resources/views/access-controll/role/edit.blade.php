<div class="modal fade" id="editRoleModal_{{ $role->id }}" tabindex="-1" aria-labelledby="editRoleModalLabel_{{ $role->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-header p-2 px-2">
                    <h4 class="modal-title">EDIT PERMISSION</h4>
                </div>
                <div class="modal-body p-3">
                    <div class="form-group">
                        <label for="r-slug_" class="control-label">Role Name</label>
                        <input type="text" class="form-control" name="slug" id="r-slug_" value="{{ $role->slug }}">
                    </div>
                    <input type="hidden" name="id" id="r-id_" value="{{ $role->id }}">
                </div>
                <div class="modal-footer p-0">
                    <div class="p-2">
                        <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                        <button class="btn btn-main" type="submit" id="save"><i class="ph-check mr-1"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
