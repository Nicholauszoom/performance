<div id="add-contract" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form {{-- action="{{ route('departments.store') }}" --}} method="POST" class="form-horizontal">
                @csrf

                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Add New Contract</label>
                        <div class="col-sm-9">

                            <select class="form-control select" name="nationality">
                                <option selected disabled> Select </option>
                                {{-- @foreach ($overtimeCategories as $overtimeCategorie)
                                <option value="{{ $overtimeCategorie->id }}"> {{ $overtimeCategorie->name }}</option>
                                @endforeach --}}
                            </select>

                            @error('name')
                                <p class="text-danger mt-1"> Input field Error </p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Duratio (Years)</label>
                        <div class="col-sm-9">
                            <input id="minSalary" type="number" min="100" max="10000000000" name=""
                                class="form-control" id="minSalary" name="minSalary" placeholder="Minimum Salary">

                            @error('name')
                                <p class="text-danger mt-1"> Input field Error </p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Notify Me (Months before Contract Expiration)</label>
                        <div class="col-sm-9">
                            <input id="maxSalary" type="number" min="100" max="10000000000" step="0.01"
                                name="maxSalary" placeholder="Maximum Salary" class="form-control" id="">

                            @error('name')
                                <p class="text-danger mt-1"> Input field Error </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
