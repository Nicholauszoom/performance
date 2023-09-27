<div role="tabpanel" class="tab-pane " id="page2" aria-labelledby="permission-tab">
    <div class="card  rounded-0 border-0 shadow-none">
        <div class="card-header">
            <h5 class="text-main">ADDRESS AND IDENTIFICATION: </h5>

        </div>

        <div class="row p-2">

            <div class="col-md-12">
                <div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                    <form action="{{ route('flex.saveAddressDetails') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">
                    <h5 class="text-warning">Address Information</h5>
                    <p>
                        <small>
                        <i>
                        Home address that you currently reside and correspondent address:
                        </i>
                        </small>
                        </p>



                        <div class="row mb-2">

                            <div class="form-group col-6">
                                <label for="">Physical Address</label>
                                <textarea name="physical_address" value="<?php echo $physical_address; ?> " class="form-control" rows="3"><?php echo $physical_address; ?></textarea>
                            </div>
                            <div class="form-group col-6">
                                <label for="landmark">Landmark near your home</label>
                                <textarea name="landmark" id="landmark" @if($details) value="{{ $details->landmark}}" @endif class="form-control" rows="3">@if($details) {{ $details->landmark}} @endif</textarea>
                            </div>

                            <div class="form-group col-6 mb-2">
                                <label for="">Phone Number</label>
                                <input type="text" name="mobile" @if($employee)  value="<?php echo $mobile; ?>" @endif class="form-control">
                            </div>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-main float-end"> Save Details</button>
                        </div>
                    </form>
                </div>


            </div>
            <div class="col-md-12">
                <div class="card border-top border-top-width-3 border-top-main rounded-0 p-2">
                    <form action="{{ route('flex.savePersonDetails') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">
                        <h5 class="text-warning">Personal Identification Information</h5>



                            <div class="row mb-2">

                                <div class="form-group col-6 mb-2">
                                    <label for="">TIN Number</label>
                                    <input type="text" name="TIN" value="<?php echo $tin; ?>" class="form-control" required>
                                </div>
                                <div class="form-group col-6 mb-2">
                                    <label for="">NIDA Number</label>
                                    <input type="text" name="NIDA" value="<?php echo $national_id; ?>"  class="form-control" required>
                                </div>
                                <div class="form-group col-6 mb-2">
                                    <label for="">Passport Number</label>
                                    <input type="text" name="passport_number" @if($details) value="{{ $details->passport_number}}" @endif class="form-control">
                                </div>
                                <div class="form-group col-6 mb-2">
                                    <label for="">Pension Fund Number</label>
                                    <input type="text" name="pension" value="<?php echo $pf_membership_no; ?>" class="form-control" required>
                                </div>

                                <div class="form-group col-6 mb-2">
                                    <label for="">HESLB Loan Index Number</label>
                                    <input type="text" name="HESLB" value="<?php echo $HESLB; ?>" class="form-control">
                                </div>

                            </div>
                            <div class="card-footer ">
                                <button type="submit" class="btn btn-main float-end"> Save Details</button>
                            </div>
                    </form>
                </div>


            </div>

        </div>
      </div>
 </div>
{{-- / --}}
