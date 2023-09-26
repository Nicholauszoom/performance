<div role="tabpanel" class="tab-pane " id="page4" aria-labelledby="l-d-tab">
    <div class="card rounded-0  border-0 shadow-none mb-3">
        <div class="card-header">
            <h5 class="text-main">FAMILY DETAILS </h5>
        </div>
        <div class="row p-2">

             <div class="col-md-12">
                 <form action="{{ route('flex.saveEmployeeSpouse') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">

                    <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                      <h5 class="text-warning">Spouse Details</h5>
                      <p>
                        <small>
                        <i>*(If you are married, please complete the below details and attach your Marriage Certificate)
                        </i>
                        </small>
                        </p>
                        <div class="row mb-2">

                            <div class="form-group col-12">
                                <label for="">Name as Per NIDA/ Passport</label>
                                <input type="text" name="spouse_name" @if($spouse) value="{{ $spouse->spouse_fname}}" @endif class="form-control" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="">Place of Birth (City/Region)</label>
                                <input type="text" name="spouse_birthplace" @if($spouse) value="{{ $spouse->spouse_birthplace}}" @endif class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label for="">Date of Birth</label>
                                <input type="date" name="spouse_birthdate" @if($spouse) value="{{ $spouse->spouse_birthdate}}" @endif class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label for="">Country of Birth</label>
                                <input type="text" name="spouse_birthcountry" @if($spouse) value="{{ $spouse->spouse_birthcountry}}" @endif class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label for="">Nationality</label>
                                <input type="text" name="spouse_nationality" @if($spouse) value="{{ $spouse->spouse_nationality}}" @endif class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label for="">NIDA Number</label>
                                <input type="text" name="spouse_nida" @if($spouse) value="{{ $spouse->spouse_nida}}" @endif class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label for="">Passport Number</label>
                                <input type="text" name="spouse_passport" @if($spouse) value="{{ $spouse->spouse_passport}}" @endif class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label for="">Employer</label>
                                <input type="text" name="spouse_employer" @if($spouse) value="{{ $spouse->spouse_employer}}" @endif class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label for="">Job Title</label>
                                <input type="text" name="spouse_job_title" @if($spouse) value="{{ $spouse->spouse_job_title}}" @endif class="form-control">
                            </div>


                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-main float-end"> Save Details</button>
                        </div>

                </div>
                 </form>


            </div>



         <div class="col-md-12">


            </div>

            <div class="col-md-12">
                <div class="card  border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                  <div class="card-header text-warning">
                    Children/Dependants Details:
                  </div>

                  <div class="card-body">
                    <h5>Add Dependant</h5>
                    <hr>
                    <form action="{{ route('flex.saveEmployeeDependant') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">

                    <div class="row">
                        <div class="col-6 mb-2">
                            <label for="">Name (First Two)</label><br>
                            <input type="text" name="dep_name" placeholder="Enter Dependants First and Second Name" class="form-control" required />

                        </div>
                        <div class="col-6 mb-2">
                            <label for="">Surname</label><br>
                            <input type="text" name="dep_surname" placeholder="Enter Dependants Surname" class="form-control" />

                        </div>
                        <div class="col-6 mb-2">
                            <label for="">Birth Certificate Number</label><br>
                            <input type="text" name="dep_certificate" placeholder="Enter Birth Certificate Number" class="form-control" />
                        </div>
                        <div class="col-6 mb-2">
                            <label for="">Birhdate</label><br>
                            <input type="date" name="dep_birthdate" placeholder="Enter Dependants Birthdate" class="form-control" />

                        </div>
                        <div class="col-4 mb-2">
                            <label for="">Gender</label><br>
                            <input type="radio" id="dep_male" name="dep_gender" value="M"> <label for="dep_male">Male (M)</label>
                            <input type="radio" id="dep_female" name="dep_gender" value="F"> <label for="dep_female">Female (F)</label>
                        </div>

                        <div class="card-footer ">
                            <button type="submit" class="btn btn-main float-end"> Save Dependant</button>
                        </div>
                    </form>

                    </div>
                    <hr>

                    <table class="table table-border-none" id="dynamicAddRemove">
                        <tr>
                        <th>Names of Children</th>
                        <th>Surname</th>
                        <th>Birthdate</th>
                        <th>Sex: M/F</th>
                        <th>Birth Certificate #</th>
                        <th>Action</th>
                        @forelse ( $children as $item )
                      <tr>

                        <td>{{ $item->dep_name}} </td>
                        <td>{{ $item->dep_surname }} </td>
                        <td>{{ $item->dep_birthdate }}</td>
                        <td>{{ $item->dep_gender }}</td>
                        <td>{{ $item->dep_certificate }} </td>
                        <td>
                            <a href="{{ url('flex/delete-child/'.$item->id) }}" class="btn btn-sm btn danger">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                      </tr>

                      @empty

                      @endforelse

                        </table>

                  </div>
                </div>
              </div>
            <div class="col-md-12">
                <div class="card  border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                  <div class="card-header">
                      Parents Details:
                  </div>
                  <div class="card-body">
                    <h5>Add Parent</h5>
                    <hr>
                    <form action="{{ route('flex.saveEmployeeParent') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">


                    <div class="row">

                        <div class="col-6 mb-2">
                            <label for="">Names (Three Names)</label><br>
                            <input type="text" name="parent_names" placeholder="Enter Parents Name" class="form-control" required/>

                        </div>
                        <div class="col-6 mb-2">
                            <label for="">Relationship</label><br>

                            <select name="parent_relation" id="" class="select custom-select form-control">
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                                <option value="Guardian">Guardian</option>
                            </select>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="">Birthdate</label><br>
                            <input type="date" name="parent_birthdate" placeholder="" class="form-control" />
                        </div>
                        <div class="col-6 mb-2">
                            <label for="">Residence  (City/Region & Country)</label><br>
                            <input type="text" name="parent_residence" placeholder="Enter Parent's Residence" class="form-control" />

                        </div>
                        <div class="col-4 mb-2">
                            <label for="">Living Status</label><br>
                            <input type="radio" id="Alive" name="parent_living_status" value="Alive"> <label for="Alive">Alive</label>
                            <input type="radio" id="Deceased" name="parent_living_status" value="Deceased"> <label for="Deceased">Deceased</label>
                        </div>
                        <div class="card-footer ">
                            <button type="submit" class="btn btn-main float-end"> Save Parent</button>
                        </div>
                    </div>
                </form>


                    <hr>


                      <table class="table table-border-none" id="dynamicAddRemoveParent">
                      <tr>
                      <th class="text-center">Names (Three Names)</th>
                      <th>Relationship</th>
                      <th>Birthdate</th>
                      <th class="text-center">Residence  (City/Region & Country)</th>
                      <th>Living Status</th>
                      <th>Action</th>
                      </tr>
                      @forelse ( $parents as $item )
                      <tr>

                        <td class="text-center">{{ $item->parent_names}} </td>
                        <td>{{ $item->parent_relation }} </td>
                        <td>{{ $item->parent_birthdate }}</td>
                        <td class="text-center">{{ $item->parent_residence }}</td>
                        <td>{{ $item->parent_living_status }} </td>
                        <td>
                            <a href="{{ url('flex/delete-parent/'.$item->id) }}" class="btn btn-sm btn danger">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                      </tr>
                      @empty

                      @endforelse


                      </table>

                      <script type="text/javascript">
                        var i = 0;
                        $("#add-btn").click(function(){
                        ++i;
                        $("#dynamicAddRemove").append('<tr><td><input type="text" name="moreFields['+i+'][dep_name]" placeholder="" class="form-control" /><input type="hidden" name="moreFields['+i+'][employeeID]" value="<?php echo $empID; ?>" class="form-control" /></td><td><input type="text" name="moreFields['+i+'][dep_surname]" placeholder="" class="form-control" /></td><td><input type="text" name="moreFields['+i+'][dep_birthdate]" placeholder="" class="form-control" /></td><td><input type="text" name="moreFields['+i+'][dep_gender]" placeholder="" class="form-control" /></td><td><input type="text" name="moreFields['+i+'][dep_certificate]" placeholder="" class="form-control" /></td><td><button type="button" class="btn btn-danger btn-sm  remove-tr">Remove</button></td></tr>');
                        });
                        $(document).on('click', '.remove-tr', function(){
                        $(this).parents('tr').remove();
                        });

                        $("#add-btn1").click(function(){
                        ++i;
                        $("#dynamicAddRemoveParent").append('<tr><td><input type="text" name="moreParent['+i+'][parent_names]" placeholder="" class="form-control" /><input type="hidden" name="moreParent['+i+'][employeeID]" value="<?php echo $empID; ?>" class="form-control" /></td><td><input type="text" name="moreParent['+i+'][parent_relation]" placeholder="" class="form-control" /></td><td><input type="text" name="moreParent['+i+'][parent_birthdate]" placeholder="" class="form-control" /></td><td><input type="text" name="moreParent['+i+'][parent_residence]" placeholder="" class="form-control" /></td><td><input type="text" name="moreParent['+i+'][parent_living_status]" placeholder="" class="form-control" /></td><td><button type="button" class="btn btn-danger btn-sm  remove-tr">Remove</button></td></tr>');
                        });
                        $(document).on('click', '.remove-tr', function(){
                        $(this).parents('tr').remove();
                        });
                        </script>
                  </div>
                </div>
              </div>



        </div>

    </div>


</div>
