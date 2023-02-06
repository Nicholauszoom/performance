@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
@endpush

@push('head-scriptTwo')
@endpush

@section('content')
    <?php
    foreach ($allowance as $key) {
        $name = $key->name;
        $allowanceID = $key->id;
        // $pensionable = $key->pensionable;
        // $taxable = $key->taxable;
        $amount = $key->amount;
        $percent = $key->percent;
        $mode = $key->mode;
        $apply_to = $key->apply_to;
    }
    ?>


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Allowances </h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0col-md-6">
                    <div class="card-header">
                        <h5 class="mb-0">Details</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table ">
                            <tr>
                                <th>Name</th>
                                <td>{{ $name }}</td>
                            </tr>
                            @if ($mode == 1)
                                <tr>
                                    <th>Amount</th>
                                    <td>{{ number_format($amount, 2) }}</td>
                                </tr>
                            @else
                                <tr>
                                    <th>Amount</th>
                                    <td>{{ 100 * $percent }}% of Salary</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Total Beneficiaries</th>
                                <td>{{ $membersCount }}</td>
                            </tr>

                        </table>
                        <div class="card-body">
                            <h4><i class="ph-plus me-2"></i>Add Members</h4>
                            <form id="applyOvertime" enctype="multipart/form-data" method="post" data-parsley-validate
                                class="form-horizontal form-label-left" autocomplete="off">
                                @csrf

                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <label class="col-form-label col-sm-3">Employee:</label>
                                        <div class="col-sm-9">

                                            <select class="form-control select_category select" name="category">
                                                <option selected disabled> Select </option>
                                                {{-- @foreach ($overtimeCategory as $overtimeCategorie)
                                          <option value="{{ $overtimeCategorie->id }}"> {{ $overtimeCategorie->name }}</option>
                                          @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="middle" align="center">
                                    <button type="submit" class="btn btn-perfrom">Add</button>
                                </div>
                                <br>
                            </form>

                            <form id="applyOvertime" enctype="multipart/form-data" method="post" data-parsley-validate
                                class="form-horizontal form-label-left" autocomplete="off">
                                @csrf

                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <label class="col-form-label col-sm-3">Group</label>
                                        <div class="col-sm-9">

                                            <select class="form-control select_category select" name="category">
                                                <option selected disabled> Select </option>
                                                {{-- @foreach ($overtimeCategory as $overtimeCategorie)
                                          <option value="{{ $overtimeCategorie->id }}"> {{ $overtimeCategorie->name }}</option>
                                          @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="" align="center">
                                    <button type="submit" class="btn btn-perfrom">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-head">
                            <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Details</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <div id="feedBackAssignment"></div>
                            <h5> Name:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $name; ?></b></h5>
                            <h5> Amount: <?php if($mode ==1){ ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($amount, 2); ?> Tsh</b> <?php } else{ ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo 100 * $percent; ?>% Of Salary</b><?php }  ?>
                            </h5>
                            <!--<h5> Beneficiaries(Individual):&nbsp;&nbsp;<b> 2 Employees </b></h5>
                        <h5> Beneficiaries(Groups):&nbsp;&nbsp;<b> 2 Groups (23 Employees) </b></h5>-->
                            <h5> Total Beneficiaries:&nbsp;&nbsp;<b> <?php echo $membersCount; ?> Employees </b></h5>

                            <br><br>
                            <h2><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Add Members</b></h2>
                            <!--<div id="details">-->
                            <form autocomplete="off" id="assignIndividual" enctype="multipart/form-data" method="post"
                                data-parsley-validate class="form-horizontal form-label-left">

                                <div class="form-group">
                                    <label class="control-label col-md-3  col-xs-6"><i class="fa fa-user"></i>&nbsp;
                                        Employee</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select required="" name="empID" class="select4_single form-control"
                                            tabindex="-1">
                                            <option></option>
                                            <?php
                          foreach ($employee as $row) {
                             # code... ?>
                                            <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="text" hidden="hidden" name="allowance" value="<?php echo $allowanceID; ?>">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button class="btn btn-main">ADD</button>
                                    </div>
                                </div>
                            </form>


                            <form autocomplete="off" id="assignGroup" data-parsley-validate
                                class="form-horizontal form-label-left">

                                <div class="form-group">
                                    <label class="control-label col-md-3  col-xs-6"><i class="fa fa-users"></i>Group</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select required="" name="group" class="select_group form-control"
                                            tabindex="-1">

                                            <option></option>
                                            <?php
                          foreach ($group as $row) {
                             # code... ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="text" hidden="hidden" name="allowance" value="<?php echo $allowanceID; ?>">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button class="btn btn-main">ADD</button>
                                    </div>
                                </div>
                            </form>
                            <!--</div><!-- details DIV for Refresh -->
                        </div>
                    </div>
                </div> --}}
                <!-- Groups -->

                <!--UPDATE-->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Update</h6>
                        </div>

                        <div class="card-body">
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                            @endif
                            <form action="{{ route('flex.updateOrganizationLevelName') }}" method="POST"
                                class="form-horizontal">
                                @csrf
                                <div class="mb-3">
                                    <div class="d-md-flex">
                                        <div class="col-sm-8">
                                            <input type="hidden" name='levelID' class="form-control">
                                            <input type="text" value="{{ $name }}" name="name"
                                                class="form-control">
                                        </div>
                                        <div class="btn-group flex-shrink-0 ms-md-3">
                                            <button type="submit" class="btn btn-perfrom multiselect-order-options-button"
                                                id="updateLevelName">Update Name</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ route('flex.updateMinSalary') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="mb-3">
                                    <label for="first-name" for="stream">Is Taxable?</label>
                                    <div class="d-md-flex">
                                        <div class="col-sm-8">

                                            <select class="form-control select_category select" name="category">
                                                <option selected disabled> Select </option>
                                                {{-- @foreach ($overtimeCategory as $overtimeCategorie) --}}
                                                <option value="">YES</option>
                                                <option value="">NO</option>
                                            </select>
                                        </div>
                                        <div class="btn-group flex-shrink-0 ms-md-3">
                                            <button type="submit"
                                                class="btn btn-perfrom multiselect-order-options-button">Update
                                                Name</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ route('flex.updateMinSalary') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="mb-3">
                                    <label for="first-name" for="stream">Is pensionable?</label>
                                    <div class="d-md-flex">
                                        <div class="col-sm-8">

                                            <select class="form-control select_category select" name="category">
                                                <option selected disabled> Select </option>
                                                {{-- @foreach ($overtimeCategory as $overtimeCategorie) --}}
                                                <option value="">YES</option>
                                                <option value="">NO</option>
                                            </select>
                                        </div>
                                        <div class="btn-group flex-shrink-0 ms-md-3">
                                            <button type="submit"
                                                class="btn btn-perfrom multiselect-order-options-button">Update
                                                Name</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ route('flex.updateAllowanceAmount') }}" method="POST"
                                class="form-horizontal">
                                @csrf
                                <div class="mb-3">
                                    <div class="d-md-flex">
                                        <div class="col-sm-8">
                                            <input type="hidden" name='levelID' value="{{ $allowanceID }}"
                                                class="form-control">
                                            <input type="number" name="maxSalary" value="{{ $amount }}"
                                                class="form-control">
                                        </div>
                                        <div class="btn-group flex-shrink-0 ms-md-3">
                                            <button type="submit"
                                                class="btn btn-perfrom multiselect-order-options-button">Update
                                                Amount</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ route('flex.updateAllowanceAmount') }}" method="POST"
                                class="form-horizontal">
                                @csrf
                                <div class="mb-3">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Change
                                        Policy
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="dc_ls_c" name="policy" checked>
                                        <label class="ms-2" for="dc_ls_c">Fixed Amount</label>
                                    </div>

                                    <div class="d-flex align-items-center mb-2">
                                        <input type="radio" id="dc_ls_u" name="policy">
                                        <label class="ms-2" for="dc_ls_u">Percent(From Basic Salary)</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <center><button name="updatename" class="btn btn-perfrom">Update</button></center>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- Updates column old here --}}


                <!--end row-->

                {{--<div class="row">
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-head">
                            <h2><i class="fa fa-list"></i>&nbsp;&nbsp;<b>Allowance Beneficiaries in Details</b>
                            </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-head">
                                        <h2>Groups(s)</h2>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-body">
                                        <div id="feedBackRemoveGroup"></div>
                                        <form autocomplete="off" id="removeGroup" method="post">
                                            <input type="text" hidden="hidden" name="allowanceID"
                                                value="<?php echo $allowanceID; ?>">
                                            <table class="table  table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Mark &nbsp;&nbsp;&nbsp;<a title="Remove Selected"><button
                                                                    type="submit" name="removeSelected"
                                                                    class="btn  btn-danger btn-xs"><i
                                                                        class="ph-trash"></i></button></a></th>
                                                    </tr>
                                                </thead>


                                                <tbody>

                                                    <?php
                              foreach ($groupin as $row) { ?>
                                                    <tr>
                                                        <td><?php echo $row->NAME; ?></td>
                                                        <td>
                                                            <label class="containercheckbox">
                                                                <input type="checkbox" name="option[]"
                                                                    value="<?php echo $row->id; ?>">
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
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-head">
                                        <h2>Individual Employees </h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-body">
                                        <div id="feedBackRemove"></div>
                                        <form autocomplete="off" id="removeIndividual" method="post">
                                            <input type="text" hidden="hidden" name="allowanceID"
                                                value="<?php echo $allowanceID; ?>">

                                            <table id="datatable" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Name</th>
                                                        <th>Mark &nbsp;&nbsp;&nbsp;<a title="Remove Selected"><button
                                                                    type="submit" name="removeSelected"
                                                                    class="btn  btn-danger btn-xs"><i
                                                                        class="ph-trash"></i></button></a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                              foreach ($employeein as $row) { ?>
                                                    <tr>
                                                        <td><?php echo $row->SNo; ?></td>
                                                        <td><?php echo $row->NAME; ?></td>
                                                        <td>
                                                            <label class="containercheckbox">
                                                                <input type="checkbox" name="option[]"
                                                                    value="<?php echo $row->empID; ?>">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <?php }  ?>
                                                </tbody>
                                            </table>
                                    </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </div> --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Allowance Beneficiaries in Details</h5>
                    </div>

                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Groups</h5>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="50%">Name</th>
                                            <th>Mark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            {{-- <td>1</td>
                                            <td>@Kopyov</td> --}}
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Individual Employee</h5>
                            </div>



                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Name</th>
                                            <th>Mark</th>
                                        </tr>
                                    </thead>
                                    @foreach ($employeein as $row)
                                    <tbody>
                                        <tr>
                                            <td>{{$row->SNo}}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->empID}}</td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- /page content -->

    @include('app/includes/update_allowances')
@endsection
