
<div id="addRoleModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ADD ROLE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{ Form::open(['route' => 'roles.store']) }}
            @method('POST')
            <div class="modal-header py-2 px-2">
                <h4 class="modal-title">ADD ROLE</h4>
            </div>
            <div class="modal-body p-3">
                <div class="form-group">
                    <label class="control-label">Role Name</label>
                    <input type="text" class="form-control" name="slug" id="p-slug_">
                </div>
            </div>
            <div class="modal-footer">
                <div class="p-2">
                     {{-- <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button> --}}
                   <button class="btn btn-main"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
