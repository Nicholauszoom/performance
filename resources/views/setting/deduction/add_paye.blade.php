<div id="save_department" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New P .A .Y .E Range</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form
                action="{{ route('flex.addOvertimeCategory') }}"
                method="POST"
                class="form-horizontal"
            >
                @csrf

                <div class="modal-body">
                    <div class="row mb-3">

                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Minimum</label>
                            <input type="text" name="minimum"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Field Name has an error </p>
                            @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Maxmum</label>
                            <input type="number" name="maximum"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Excess added </p>
                            @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Excess added</label>
                            <input type="number" name="excess_added"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Excess added </p>
                            @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Rate to an Amount Excess of Minimum</label>
                            <input type="number" name="rate"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Field Name has an error </p>
                            @enderror
                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom">Save Range</button>
                </div>
            </form>
        </div>
    </div>
</div>
