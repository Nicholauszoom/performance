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
            $pentionable = $key->pentionable;
            $taxable = $key->taxable;
            $amount = $key->amount;
            $percent = $key->percent;
            $mode = $key->mode;
            $apply_to = $key->apply_to;
        }
    @endphp

    <div class="mb-3">
        <h5 class="text-muted">Allowance Info</h5>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Details</h5>
                </div>

                <table class="table ">
                    <tr>
                        <th>Name :</th>
                        <td>{{ $name }}</td>
                    </tr>
                    @if ($mode == 1)
                    <tr>
                        <th>Amount :</th>
                        <td>{{ number_format($amount, 2) .' Tsh' }}</td>
                    </tr>
                    @else
                    <tr>
                        <th>Amount :</th>
                        <td>{{ 100 * $percent .'% of Salary'}}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Total Beneficiaries :</th>
                        <td>{{ $membersCount .' Employees' }}</td>
                    </tr>
                </table>

                <hr>
 
                <div class="card-body">
                    <h4 class="text-muted">Add Members</h4>

                    <form autocomplete="off" id="assignIndividual" enctype="multipart/form-data"   method="post"  data-parsley-validate class="form-horizontal form-label-left">
                        <div class="mb-2">
                            <label class="form-label">Employee :</label>
                            <div class="input-group">
                                <select required name="empID" class="select4_single form-control select" data-width="1%">
                                    <option selected disabled> select Employee</option>
                                    <?php foreach ($employee as $row) { ?>
                                    <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" class="btn btn-main px-3">ADD</button>
                            </div>
                        </div>

                        <input type="text" hidden="hidden" name="allowance" value="<?php echo $allowanceID?>">
                    </form>
                </div>

                <hr class="my-3">

                <div class="card-body">
                    <h4 class="text-muted">Add Members ( Group )</h4>

                    <form autocomplete="off" id="assignGroup"  data-parsley-validate class="form-horizontal form-label-left">

                        <div class="mb-2">
                            <label class="form-label">Employee :</label>
                            <div class="input-group">
                                <select required="" name="group" class="select_group form-control select" data-width="1%">
                                    <option selected disabled>Select Group</option>
                                    <?php foreach ($group as $row) { ?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" class="btn btn-main px-3">ADD</button>
                            </div>
                        </div>

                        <input type="text" hidden="hidden" name="allowance" value="<?php echo $allowanceID?>">
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Update Allowance</h5>
                </div>

                <div class="card-body">
                    <div id ="feedBackSubmission"></div>
                    <form autocomplete="off" id="updateName" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">
                            <label  for="first-name" for="stream" >Allowance Name</label>
                            <div class="input-group">
                                <input required type="text" name ="name" value="<?php echo $name; ?>" class="form-control">
                                <button  class="btn btn-main">Update Name</button>
                            </div>
                        </div>
                    </form>

                    @isset($taxable)
                    <form autocomplete="off" id="updateTaxable" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">

                            <label  for="first-name" for="stream" >Is Taxable?</label>
                            <div class="input-group">
                                <select name="taxable" class="select_type form-control" required tabindex="-1" id="policy">
                                    <option> Select</option>
                                    <option value="YES" <?php if($taxable == 'YES') echo "selected";   ?>>YES</option>
                                    <option value="NO" <?php if($taxable == 'NO') echo "selected";   ?>>NO</option>
                                </select>
                                <button  class="btn btn-primary">Update Taxable</button>
                            </div>
                        </div>
                    </form>
                    @endisset

                    @isset($pentionable)
                    <form autocomplete="off" id="updatePentionable" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">

                            <label  for="first-name" for="stream" >Is Pentionable?</label>
                            <div class="input-group">
                                <select name="pentionable" class="select_type form-control" required tabindex="-1" id="policy">
                                    <option> Select</option>
                                    <option value="YES" <?php if($pentionable == 'YES') echo "selected";   ?>>YES</option>
                                    <option value="NO" <?php if($pentionable == 'NO') echo "selected";   ?>>NO</option>
                                </select>
                                <button  class="btn btn-primary">Update pentionable</button>
                            </div>
                        </div>
                    </form>
                    @endisset


                    @if ($mode == 1)
                    <form autocomplete="off"  id="updateAmount" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">

                            <label class="form-label">Amount</label>
                            <div class="input-group">
                                <input required="" type="number" name="amount" step ="1" min="1" max="10000000" value="<?php echo $amount; ?>" class="form-control">
                                <button  class="btn btn-main">Update Amount</button>
                            </div>
                        </div>
                    </form>
                    @elseif ($mode ==2)
                    <form autocomplete="off" id="updatePercent" class="form-horizontal form-label-left">
                        <div class="mb-3">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">

                            <label class="form-label">Percent</label>
                            <div class="input-group">
                                <input type="number" name="percent" min="0" max="99" step ="0.1" value="<?php echo 100*$percent; ?>" class="form-control">
                                <button  class="btn btn-main">Update Amount</button>
                            </div>
                        </div>
                    </form>
                    @endif

                    <form autocomplete="off" id="updatePolicy" method = "post" class="form-horizontal form-label-left">
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
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-muted">Groups(s)</h5>
                </div>
                <form autocomplete="off" id = "removeGroup" method="post"  >
                    <input type="text" hidden="hidden" name="allowanceID" value="<?php echo $allowanceID; ?>">
                    <table class="table  table-bordered" >
                        <thead>
                            <tr>
                                <th>Name</th>
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
                    <h5 class="text-muted">Groups(s)</h5>
                </div>
                <form autocomplete="off" id = "removeGroup" method="post"  >
                    <input type="text" hidden="hidden" name="allowanceID" value="<?php echo $allowanceID; ?>">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
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


    {{-- @include('app/includes/update_allowances') --}}
@endsection

@push('footer-script')
    @include('app.includes.update_allowances')
@endpush
