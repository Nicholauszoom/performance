<div id="save_department" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New P .A .Y .E Range</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form
                action="{{ route('departments.store') }}"
                method="POST"
                class="form-horizontal"
            >
                @csrf

                <div class="modal-body">
                    <div class="row mb-3">
                        
                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Minimum Amount</label>
                            <input type="number" name="name"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Field Name has an error </p>
                            @enderror
                    </div>
                   
                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Maximum Amount</label>
                            <input type="number" name="name"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Field Name has an error </p>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Excess Added To an Amount Exceeding the Minimum Amount</label>
                            <input type="number" name="name"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Field Name has an error </p>
                            @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Percentage Contribution to Amount that Exceed the Minimum Amount</label>
                            <input type="number" name="name"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Field Name has an error </p>
                            @enderror
                    </div>
                   
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom">Save Range</button>
                </div>
            </form>
        </div>
    </div>
</div>
