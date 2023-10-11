<div role="tabpanel" class="tab-pane fade show " id="page1" aria-labelledby="work-tab">

    <div class="card    rounded-0 shadow-none">
        <div class="card-header">
            <h5 class="text-main">BASIC DETAILS: </h5>
        </div>
        <div class="card-body ">

               {{--displaying all the errors  --}}

            <div class="row">

                <div class="col-12">
                    <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">

                        <form action="{{ route('flex.saveBasicDetails') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">
                             <h5 class="text-warning">Name Information</h5>

                            <div class="row mb-2">
                                <label for="">Prefix</label>
                                <div class="form-group">
                                    <input type="radio" id="Mr" @if($details) {{$details->prefix == "Mr." ? 'checked':'' }} @endif name="prefix" value="Mr.">
                                    <label for="Mr">Mr.</label>
                                    <input type="radio" id="Mrs" @if($details) {{$details->prefix == "Mrs." ? 'checked':'' }} @endif name="prefix" value="Mrs.">
                                    <label for="Mrs">Mrs.</label>
                                    <input type="radio" id="Miss" @if($details) {{$details->prefix == "Miss" ? 'checked':'' }} @endif name="prefix" value="Miss">
                                    <label for="Miss">Miss</label>
                                    <input type="radio" id="other" name="prefix" @if($details) {{$details->prefix == "Miss" ? 'checked':'' }} @endif value="Other">
                                    <label for="other">Other</label>
                                </div>
                            </div>
                            <div class="row mb-2">

                                <div class="form-group col-6">
                                    <label for="">First Name</label>
                                    <input type="text" name="fname" value="<?php echo $fname; ?>" class="form-control" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Middle Name</label>
                                    <input type="text" name="mname" value="<?php echo $mname; ?>" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Surname</label>
                                    <input type="text" name="lname" value="<?php echo $lname; ?>" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Maiden Name</label>
                                    <input type="text" name="maide_name" @if($details) value="{{ $details->maide_name }}" @endif class="form-control">
                                </div>
                                <p>
                                <small>
                                <i>Note:</i>  Please note that name change requests require a
                                copy of the legal documents verifying your new name
                                change. Acceptable forms of documentation include
                                marriage license, divorce decree or court order.
                                </small>
                                </p>
                            </div>


                            <div class="card-footer ">
                                <button type="submit" class="btn btn-main float-end"  > Save Details</button>
                            </div>
                        </form>

                    </div>


                </div>
                <div class="col-12">
                    <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                        <form action="{{ route('flex.saveBioDetails') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">
                        <h5 class="text-warning">Biography Information</h5>


                            <div class="row mb-2">

                                <div class="form-group col-6 mb-2">
                                    <label for="">Date of Birth</label>
                                    <input type="date" name="birthdate" value="<?php echo $birthdate; ?>" class="form-control">
                                </div>


                                <div class="form-group col-6 mb-2">
                                    <label for="">Place of Birth</label>
                                    <input type="text" name="birthplace" @if($details) value="{{ $details->birthplace}}" @endif   class="form-control">
                                </div>
                                <div class="form-group col-6 mb-2">
                                    <label for="">Country of Birth</label>
                                    <input type="text" name="birthcountry" @if($details) value="{{ $details->birthcountry}}" @endif   class="form-control">
                                </div>
                                <div class="form-group col-6 mb-2">
                                    <label for="">Religion</label>
                                    <input type="text" name="religion" @if($details) value="{{ $details->religion}}" @endif  class="form-control">
                                </div>
                                <div class="form-group col-12 mb-2">
                                    <label for="">Gender/ Sex</label>
                                    <hr>
                                    <input type="radio" id="male" name="gender" @foreach($employee as $item) {{$item->gender == "Male" ? 'checked':'' }} @endforeach value="Male"   class="">
                                    <label for="male">Male</label>
                                    <input type="radio" id="female" @foreach($employee as $item) {{$item->gender == "Female" ? 'checked':'' }} @endforeach name="gender" value="Female">
                                    <label for="female">Female</label>
                                </div>
                                <div class="form-group col-12 mb-3">
                                    <label for="">Martial Status</label>
                                    <hr>
                                   <div class="row">
                                    <div class="col mb-2">
                                        <input type="radio" id="Single" name="merital" @foreach($employee as $item) {{$item->merital_status == "Single" ? 'checked':'' }} @endforeach value="Single">
                                        <label for="Single">Single</label>
                                    </div>
                                    <div class="col mb-2">

                                        <input type="radio" id="Married" name="merital" @foreach($employee as $item) {{$item->merital_status == "Married" ? 'checked':'' }} @endforeach value="Married">
                                        <label for="Married" class="pr-5">Married</label> &nbsp;
                                        <br>

                                    </div>
                                    <div class="col">
                                        <label for="">Marriage Date</label>
                                        <input type="date" class="form-control" id="Married" name="marriage_date" @if($details) value="{{ $details->marriage_date}}" @endif><br>

                                    </div>
                                    <div class="col mb-2">
                                        <input type="radio" id="Separated" name="merital"  @foreach($employee as $item) {{$item->merital_status == "Separated" ? 'checked':'' }} @endforeach value="Separated">
                                        <label for="Separated">Separated</label>
                                    </div>
                                    <div class="col mb-2">
                                        <input type="radio" id="divorced" name="merital" id="Divorced" @foreach($employee as $item) {{$item->merital_status == "Divorced" ? 'checked':'' }} @endforeach value="Divorced">
                                        <label for="divorced" class="pr-5">Divorced</label> <br>

                                    </div>
                                    <div class="col">
                                        <label>Divorced Date</label><br>
                                        <input type="date" class="form-control" name="divorced_date" @if($details) value="{{ $details->divorced_date}}" @endif>
                                       <br>
                                    </div>
                                    <div class="col mb-2">
                                        <input type="radio" id="widow" name="merital"  @foreach($employee as $item) {{$item->merital_status == "Widow/Widower" ? 'checked':'' }} @endforeach value="Widow/Widower">
                                        <label for="widow">Widow/Widower</label><br>
                                    </div>
                                   </div>



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

</div>
