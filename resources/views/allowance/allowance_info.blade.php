@extends('layouts.vertical', ['title' => 'Allowance Info'])

@push('head-script')
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
<script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    @php
        foreach ($allowance as $key) {
            $name = $key->name;
            $allowanceID = $key->id;
            $pensionable = $key->pensionable;
            $taxable = $key->taxable;

            $Isbik = $key->Isbik;
            $Isrecursive = $key->Isrecursive;

            $amount = $key->amount;
            $percent = $key->percent;
            $mode = $key->mode;
            $apply_to = $key->apply_to;
        }
    @endphp

    <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
        <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/financial_group')}}" class="nav-link" aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Packages
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/allowance_overtime') }}" class="nav-link" aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Overtime
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/allowance') }}" class="nav-link  active show" aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Allowance
                </a>
            </li>


            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/statutory_deductions') }}" class="nav-link " aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Statutory Deductions
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/non_statutory_deductions') }}" class="nav-link " aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Non Statutory Deductions
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                <div class="card-header">
                    <h5 class="mb-0">Details</h5>
                </div>

                <table class="table ">
                    <tr>
                        <th>Name :</th>
                        <td>{{ $name }}</td>
                    </tr>

                    <tr>
                        <th>Total Beneficiaries :</th>
                        <td>{{ $membersCount .' Employees' }}</td>
                    </tr>
                </table>





                <hr class="my-5">

                <div class="card-body">
                    <h4 class="text-muted">Add Employees ( Group )</h4>

                    <form autocomplete="off" id="assignGroup"  data-parsley-validate class="form-horizontal form-label-left">

                        <div class="mb-2">
                            <label class="form-label">Groups :</label>
                            <div class="input-group">
                                <select required name="group" class="select_group form-control select" data-width="1%">
                                    <option selected disabled>Select Group</option>
                                    <?php foreach ($group as $row) { ?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            @if ($mode == 1)
                            <label class="form-label">Amount</label>
                            <div class="input-group">
                                <input required type="number" name="amount" step ="1" min="1" max="10000000"  class="form-control">

                            </div>
                            @else
                            <label class="form-label">Percent</label>
                            <div class="input-group">
                                <input required type="number" name="percent" step ="0.1" min="0" max="100"  class="form-control">

                            </div>
                            @endif
                            <input type="hidden" name="mode" value="{{ $mode }}">
                            <label class="form-label">Currency </label>
                            <div class="input-group">
                                <select required name="currency" class="select_group form-control select" data-width="1%">
                                    <option selected disabled>Select Currency</option>
                                    <?php foreach ($currencies as $row) { ?>
                                        <option value="<?php echo $row->currency; ?>"><?php echo $row->currency; ?></option>
                                        <?php } ?>
                                </select>

                            </div>
                            <div class="input-group py-2">
                                <button type="submit" class="btn btn-main px-3">ADD</button>
                            </div>
                        </div>

                        <input type="text" hidden="hidden" name="allowance" value="<?php echo $allowanceID?>">
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="text-muted">Group(s)</h5>
                </div>
                <form autocomplete="off" id = "removeGroup" method="post"  >
                    <input type="text" hidden="hidden" name="allowanceID" value="<?php echo $allowanceID; ?>">
                    <table class="table  table-bordered" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                {{-- <th>Amount</th>
                                <th>Mode</th>
                                <th>Amount</th>
                                <th>Percent</th> --}}
                                <th>
                                    <a title="Remove Selected" class="me-5">
                                        <button type="submit"  name="removeSelected"  class="btn  btn-danger btn-xs">
                                            <i class="ph-trash"></i>
                                        </button>
                                    </a>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($groupin as $row) { ?>
                            <tr>
                                <td><?php echo $row->NAME; ?></td>
                                {{-- <td><?php echo $row->amount/$row->rate.' '.$row->currency; ?></td>
                                <td>{{ $row->mode == 1?'Fixed Amount':'Percent' }}</td>
                                <td>{{ $row->amount != null?$row->amount/$row->rate.' '.$row->currency:'-' }}</td>
                                <td>{{ $row->percent != null?($row->percent*100)."%" :'-' }}</td> --}}
                                <td>
                                    <label class="containercheckbox">
                                        <input type="checkbox" name="option[]" value="<?php echo $row->id; ?>">
                                        <span class="checkmark"></span>
                                    </label>
                                </td>
                            </tr>
                            <?php } //} ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Update Allowance</h5>
                </div>

                <div class="card-body">
                    <div id ="feedBackSubmission"></div>
                    {{-- <form autocomplete="off" id="updateName" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">
                            <label  for="first-name" for="stream" >Allowance Name</label>
                            <div class="input-group">
                                <input required type="text" name ="name" value="<?php echo $name; ?>" class="form-control">
                                <button  class="btn btn-main">Update Name</button>
                            </div>
                        </div>
                    </form> --}}


                    <form autocomplete="off" id="updateTaxable" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">

                            <label  for="first-name" for="stream" >Taxable</label>
                            <div class="input-group">
                                <select name="taxable" class="select_type form-control" required tabindex="-1" id="Isrecursive">
                                    <option> Select</option>
                                    <option value="YES" <?php if($taxable == 'YES') echo "selected";   ?>>YES</option>
                                    <option value="NO" <?php if($taxable == 'NO') echo "selected";   ?>>NO</option>
                                </select>
                                <button  class="btn btn-main">Update Taxable</button>
                            </div>
                        </div>
                    </form>


                    @isset($pensionable)
                    <form autocomplete="off" id="updatepensionable" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">

                            <label  for="first-name" for="stream" >Pensionable</label>
                            <div class="input-group">
                                <select name="pensionable" class="select_type form-control" required tabindex="-1" id="policy">
                                    <option> Select</option>
                                    <option value="YES" <?php if($pensionable == 'YES') echo "selected";   ?>>YES</option>
                                    <option value="NO" <?php if($pensionable == 'NO') echo "selected";   ?>>NO</option>
                                </select>
                                <button  class="btn btn-main">Update pensionable</button>
                            </div>
                        </div>
                    </form>
                    @endisset
                    <form autocomplete="off" id="updaterecursive" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">

                            <label  for="first-name" for="stream" >Nature</label>
                            <div class="input-group">
                                <select name="Isrecursive" class="select_type form-control" required tabindex="-1" id="policy">
                                    <option> Select</option>
                                    <option value="PERMANENT" <?php if($Isrecursive == 'PERMANENT') echo "selected";   ?>>PERMANENT</option>
                                    <option value="TEMPORARY" <?php if($Isrecursive == 'TEMPORARY') echo "selected";   ?>>TEMPORARY</option>
                                    <option value="ONCE OFF" <?php if($Isrecursive == 'ONCE OFF') echo "selected";   ?>>ONCE OFF</option>
                                </select>

                                <button  class="btn btn-main">Update</button>
                            </div>
                        </div>
                    </form>
                    <form autocomplete="off" id="updatebik" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">

                            <label  for="first-name" for="stream" >Benefit In Kind</label>
                            <div class="input-group">
                                <select name="Isbik" class="select_type form-control" required tabindex="-1" id="Isbik">
                                    <option> Select</option>
                                    <option value="YES" <?php if($Isbik == 'YES') echo "selected";   ?>>YES</option>
                                    <option value="NO" <?php if($Isbik == 'NO') echo "selected";   ?>>NO</option>
                                </select>
                                <button  class="btn btn-main">Update</button>
                            </div>
                        </div>
                    </form>


                    @if ($mode == 1)
                    {{-- <form autocomplete="off"  id="updateAmount" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">

                            <label class="form-label">Amount</label>
                            <div class="input-group">
                                <input required="" type="number" name="amount" step ="any" min="1" max="10000000" value="<?php echo $amount; ?>" class="form-control">
                                <button  class="btn btn-main">Update Amount</button>
                            </div>
                        </div>
                    </form> --}}
                    @elseif ($mode ==2)
                    {{-- <form autocomplete="off" id="updatePercent" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">

                            <label class="form-label">Percent</label>
                            <div class="input-group">
                                <input type="number" name="percent" min="0" max="100" step ="0.1" value="<?php echo 100*$percent; ?>" class="form-control">
                                <button  class="btn btn-main">Update Amount</button>
                            </div>
                        </div>
                    </form> --}}
                    @endif

                    {{-- <form autocomplete="off" id="updatePolicy" method = "post" class="form-horizontal form-label-left">
                        <div class="mb-3">
                             <label class="form-label" for="first-name"> Change Policy </label>
                             <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">

                            <div>
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="policy" value="1" id="dc_li_c" {{ ($mode == 1) ? "checked" : "" }}>
                                    <label class="ms-2" for="dc_li_c">Fixed Amout</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="policy" value="2" id="dc_li_u" {{ ($mode == 2) ? "checked" : "" }}>
                                    <label class="ms-2" for="dc_li_u">Percent(From Basic Salary)</label>
                                </div>
                            </div>

                            <button  name="updatename" class="btn btn-main mt-3">Update</button>
                        </div>
                    </form> --}}
                </div>

                <div class="card-body">
                    <h4 class="text-muted">Add Employees</h4>

                    <form autocomplete="off" id="assignIndividual" enctype="multipart/form-data"   method="post"  data-parsley-validate class="form-horizontal form-label-left">
                        <div class="mb-2">
                            <label class="form-label">Employee :</label>
                            <div class="input-group">
                                <select required name="empID" class="select4_single form-control select" data-width="1%">
                                    <option selected disabled> select Employee</option>
                                    <?php foreach ($employee as $row) { ?>
                                        <option value="<?php echo $row->empID; ?>"><?php echo $row->empID.' - '.$row->NAME; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            @if ($mode == 1)
                            <label class="form-label">Amount</label>
                            <div class="input-group">
                                <input required type="number" name="amount" step ="any" min="1" max="10000000"  class="form-control">

                            </div>
                            @else
                            <label class="form-label">Percent</label>
                            <div class="input-group">
                                <input required type="number" name="percent" step ="0.1" min="0" max="100"  class="form-control">

                            </div>
                            @endif
                            <input type="hidden" name="mode" value="{{ $mode }}">
                            <label class="form-label">Currency </label>
                            <div class="input-group">
                                <select required name="currency" class="select_group form-control select" data-width="1%">
                                    <option selected disabled>Select Currency</option>
                                    <?php foreach ($currencies as $row) { ?>
                                        <option value="<?php echo $row->currency; ?>"><?php echo $row->currency; ?></option>
                                        <?php } ?>

                                </select>

                            </div>
                            <div class="input-group py-2">
                                <button type="submit" class="btn btn-main px-3">ADD</button>
                            </div>
                        </div>

                        <input type="text" hidden="hidden" name="allowance" value="<?php echo $allowanceID?>">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- <div class="col-md-6">

        </div> --}}


        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-muted">Employee(s)</h5>
                </div>
                <form autocomplete="off" id = "removeIndividual" method="post"  >
                    <input type="text" hidden="hidden" name="allowanceID" value="<?php echo $allowanceID; ?>">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Mode</th>
                                <th>Amount</th>
                                <th>Percent</th>
                                <th>
                                    <a title="Remove Selected">
                                        <button type="submit"  name="removeSelected"  class="btn  btn-danger btn-xs">
                                            <i class="ph-trash"></i>
                                        </button>
                                    </a>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($employeein as $row) { ?>
                            <tr>

                                <td><?php echo $row->SNo; ?></td>
                                <td><?php echo $row->NAME; ?></td>
                                <td>{{ $row->mode == 1?'Fixed Amount':'Percent' }}</td>
                                <td>{{ $row->amount != null?$row->amount/$row->rate.' '.$row->currency:'-' }}</td>
                                <td>{{ $row->percent != null?($row->percent*100)."%" :'-' }}</td>
                                <td>
                                    <label class="containercheckbox">
                                    <input type="checkbox" name="option[]" value="<?php echo $row->empID; ?>">
                                    <span class="checkmark"></span>
                                    </label>
                                </td>
                            </tr>
                            <?php }  ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>



@endsection

@push('footer-script')
    @include('app.includes.update_allowances')
@endpush
