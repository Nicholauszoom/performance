@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')
    <?php
    ?>


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Roles and Permission </h3>
                </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-head">
                            <h2>Role Info</h2>


                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">

                            @if (Session::has('note'))
                                {{ session('note') }}
                            @endif

                            <!-- <table id="datatable" class="table table-striped table-bordered"> -->
                            <?php
            if (isset($role)){
                      foreach ($role as $row) {
                        $roleID=$row->id; 
                        $permissionTag=$row->permissions;                        
                          ?>


                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="card">
                                        <div class="card-head">
                                            <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Change Role Name</b></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body">
                                            <form align="center" enctype="multipart/form-data" method="post"
                                                action="<?php echo url(''); ?>/flex/updaterole/?id=<?php echo $roleID; ?>" 
                                                data-parsley-validate class="form-horizontal form-label-left"
                                                autocomplete="off">

                                                @csrf
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                        for="last-name">Role Name
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required="" value="<?php echo $row->name; ?>" name="name"
                                                            class="form-control col-md-7 col-xs-12">
                                                        <span class="text-danger"><?php // echo form_error("lname");
                                                        ?></span>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="display: none">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                        for="last-name">Permission Tag
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input disabled="disabled" value="<?php echo $row->permissions; ?>"
                                                            class="form-control col-md-7 col-xs-12">
                                                        <span class="text-danger"><?php // echo form_error("lname");
                                                        ?></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 py-3">
                                                        <button type="submit" name="updatename"
                                                            class="btn btn-main">Update</button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>




                                <!-- Groups -->
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="card">
                                        <div class="card-head">
                                            <h2><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Add Members</b></h2>


                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="card-body">


                                            <form id="demo-form2" enctype="multipart/form-data" method="post"
                                                action="<?php echo url(''); ?>/flex/assignrole2" data-parsley-validate
                                                class="form-horizontal form-label-left">
                                                @csrf


                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6"><i
                                                            class="fa fa-user"></i>&nbsp; Employee</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="" name="empID"
                                                            class="select4_single form-control" tabindex="-1">
                                                            <option></option>
                                                            <?php
                                                                    foreach ($employeesnot as $row) {
                                                              # code... ?>
                                                            <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?>
                                                            </option> <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="text" hidden="hidden" name="roleID"
                                                    value="<?php echo $roleID; ?>">
                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 py-3">
                                                        <input type="submit" value="ADD" name="assign"
                                                            class="btn btn-main" />
                                                    </div>
                                                </div>
                                            </form>



                                            <!-- <h4><b>OR</b></h4> <br> -->


                                            <form id="demo-form2" enctype="multipart/form-data" method="post"
                                                action="<?php echo url(''); ?>/flex/assignrole2" data-parsley-validate
                                                class="form-horizontal form-label-left">
                                                @csrf

                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6"><i
                                                            class="fa fa-users"></i> &nbsp;Group</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="" name="groupID"
                                                            class="select_group form-control" tabindex="-1">
                                                            <option></option>
                                                            <?php
                                                        foreach ($groupsnot as $row) {
                             # code... ?>
                                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?>
                                                            </option> <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="text" hidden="hidden" name="roleID"
                                                    value="<?php echo $roleID; ?>">
                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 py-3">
                                                        <input type="submit" value="ADD" name="addgroup"
                                                            class="btn btn-main" />
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-lg-6 (nested) -->
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="card">
                                    <div class="card-head px-3">
                                        <h2><i class="ph-lock"></i> Permissions In This Role</h2>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-body">

                                        <div class="col-xs-3">
                                            <!-- required for floating -->
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3"
                                                id="tabs-target-right" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a href="#generalTab" class="nav-link active show"
                                                        data-bs-toggle="tab" aria-selected="false" role="tab"
                                                        tabindex="-1">
                                                        <i class="ph-list me-2"></i>
                                                        General Permission
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a href="#linemanagerTab" class="nav-link " data-bs-toggle="tab"
                                                        aria-selected="false" role="tab" tabindex="-1">
                                                        <i class="ph-list me-2"></i>
                                                        Line Manager Permission
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a href="#hrTab" class="nav-link" data-bs-toggle="tab"
                                                        aria-selected="false" role="tab" tabindex="-1">
                                                        <i class="ph-list me-2"></i>
                                                        HR Permission
                                                    </a>
                                                </li>


                                                <li class="nav-item" role="presentation">
                                                    <a href="#financeTab" class="nav-link " data-bs-toggle="tab"
                                                        aria-selected="false" role="tab" tabindex="-1">
                                                        <i class="ph-list me-2"></i>
                                                        Finance Permission
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a href="#directorTab" class="nav-link " data-bs-toggle="tab"
                                                        aria-selected="false" role="tab" tabindex="-1">
                                                        <i class="ph-list me-2"></i>
                                                        Director Permission
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>

                                        <div class="col-xs-9">
                                            <!-- Tab panes -->
                                            <form action="<?php echo url(''); ?>/flex/updaterole/" method="post">
                                                <input type="hidden" name="roleID" value="<?php echo $roleID; ?>">
                                                @csrf
                                                <div class="tab-content" id="myTabContent">


                                                    <div role="tabpanel" role="tabpanel" class="tab-pane active "
                                                        id="generalTab" aria-labelledby="home-tab">

                                                        <p class="lead">General Permissions &nbsp;&nbsp;&nbsp;<button
                                                                type="submit" name="assign"
                                                                class="btn btn-main">update</button></p>
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>S/N</th>
                                                                    <th>Name</th>
                                                                    <th>code</th>
                                                                    <th>Option</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php foreach ($general_permissions as $row) { ?>
                                                                <tr>
                                                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                                                    </td>
                                                                    <td><?php echo $row->name; ?></td>
                                                                    <td><?php echo $row->code; ?></td>

                                                                    <td class="options-width">
                                                                        <label class="containercheckbox">
                                                                            <input <?php if (strpos($permissionTag, $row->code) !== false) { ?> checked=""
                                                                                <?php } ?> type="checkbox"
                                                                                name="option[]"
                                                                                value="<?php echo $row->code; ?>">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                                <?php }  ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div role="tabpanel" role="tabpanel" class="tab-pane fade "
                                                        id="hrTab" aria-labelledby="home-tab">

                                                        <p class="lead">Human Resource Permissions
                                                            &nbsp;&nbsp;&nbsp;<button type="submit" name="assign"
                                                                class="btn btn-main">update</button></p>
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>S/N</th>
                                                                    <th>Name</th>
                                                                    <th>code</th>
                                                                    <th>Option</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php foreach ($hr_permissions as $row) { ?>
                                                                <tr>
                                                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                                                    </td>
                                                                    <td><?php echo $row->name; ?></td>
                                                                    <td><?php echo $row->code; ?></td>

                                                                    <td class="options-width">
                                                                        <label class="containercheckbox">
                                                                            <input <?php if (strpos($permissionTag, $row->code) !== false) { ?> checked=""
                                                                                <?php } ?> type="checkbox"
                                                                                name="option[]"
                                                                                value="<?php echo $row->code; ?>">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                                <?php }  ?>
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                    <div role="tabpanel" role="tabpanel" class="tab-pane fade "
                                                        id="performanceTab" aria-labelledby="home-tab">

                                                        <p class="lead">Performance Permissions&nbsp;&nbsp;&nbsp;<button
                                                                type="submit" name="assign"
                                                                class="btn btn-main">update</button></p>
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>S/N</th>
                                                                    <th>Name</th>
                                                                    <th>Option</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php foreach ($perf_permissions as $row) { ?>
                                                                <tr>
                                                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                                                    </td>
                                                                    <td><?php echo $row->name; ?></td>

                                                                    <td class="options-width">
                                                                        <label class="containercheckbox">
                                                                            <input <?php if (strpos($permissionTag, $row->code) !== false) { ?> checked=""
                                                                                <?php } ?> type="checkbox"
                                                                                name="option[]"
                                                                                value="<?php echo $row->code; ?>">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                                <?php }  ?>
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                    <div role="tabpanel" role="tabpanel" class="tab-pane fade "
                                                        id="directorTab" aria-labelledby="home-tab">

                                                        <p class="lead">Country Director
                                                            Permissions&nbsp;&nbsp;&nbsp;<button type="submit"
                                                                name="assign" class="btn btn-main">update</button></p>
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>S/N</th>
                                                                    <th>Name</th>
                                                                    <th>Option</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php foreach ($cdir_permissions as $row) { ?>
                                                                <tr>
                                                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                                                    </td>
                                                                    <td><?php echo $row->name; ?></td>

                                                                    <td class="options-width">
                                                                        <label class="containercheckbox">
                                                                            <input <?php if (strpos($permissionTag, $row->code) !== false) { ?> checked=""
                                                                                <?php } ?> type="checkbox"
                                                                                name="option[]"
                                                                                value="<?php echo $row->code; ?>">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                                <?php }  ?>
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                    <div role="tabpanel" role="tabpanel" class="tab-pane fade "
                                                        id="linemanagerTab" aria-labelledby="home-tab">

                                                        <p class="lead">Line Manager Permissions&nbsp;&nbsp;&nbsp;<button
                                                                type="submit" name="assign"
                                                                class="btn btn-main">update</button></p>
                                                        <!-- <div class="clearfix"></div> -->
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>S/N</th>
                                                                    <th>Name</th>
                                                                    <th>Option</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php foreach ($line_permissions as $row) { ?>
                                                                <tr>
                                                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                                                    </td>
                                                                    <td><?php echo $row->name; ?></td>

                                                                    <td class="options-width">
                                                                        <label class="containercheckbox">
                                                                            <input <?php if (strpos($permissionTag, $row->code) !== false) { ?> checked=""
                                                                                <?php } ?> type="checkbox"
                                                                                name="option[]"
                                                                                value="<?php echo $row->code; ?>">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                                <?php }  ?>
                                                            </tbody>
                                                        </table>
                                                    </div>




                                                    <div role="tabpanel" role="tabpanel" class="tab-pane fade "
                                                        id="financeTab" aria-labelledby="home-tab">

                                                        <p class="lead">Financial Permissions&nbsp;&nbsp;&nbsp;<button
                                                                type="submit" name="assign"
                                                                class="btn btn-main">update</button></p>
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>S/N</th>
                                                                    <!-- <th>Value</th> -->
                                                                    <th>Name</th>
                                                                    <th>Option</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php foreach ($fin_permissions as $row) { ?>
                                                                <tr>
                                                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                                                    </td>
                                                                    <!-- <td><?php echo $row->code; ?></td> -->
                                                                    <td><?php echo $row->name; ?></td>

                                                                    <td class="options-width">
                                                                        <label class="containercheckbox">
                                                                            <input <?php if (strpos($permissionTag, $row->code) !== false) { ?> checked=""
                                                                                <?php } ?> type="checkbox"
                                                                                name="option[]"
                                                                                value="<?php echo $row->code; ?>">
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                                <?php }  ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>

                                        <div class="clearfix"></div>



                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                @if (Session::has('note'))
                                    {{ session('note') }}
                                @endif
                                <div id="feedBackRemove"></div>
                                <form id="removeFromRole" method="post">
                                    @csrf
                                    <!-- </div> -->
                                    <table id="datatable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Groups</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                       
                                            foreach ($members as $row) { ?>
                                            <tr>
                                                <td width="1px"><?php echo $row->SNo; ?></td>
                                                <td><?php echo $row->NAME; ?></td>
                                                <td><?php echo '<b>Department: </b>' . $row->DEPARTMENT . '<br><b>Position: </b>' . $row->POSITION; ?></td>
                                                <td>
                                                    <?php
                                                    if (sizeof($group[$row->userID]) > 0) {
                                                        echo $group[$row->userID][0]->name;
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="options-width">
                                                    <label class="containercheckbox">
                                                        <input type="checkbox" name="option[]"
                                                            value="<?php echo $row->roleID . '|' . $row->userID; ?>">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <?php }  ?>
                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button class="btn btn-warning">Remove Selected</button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- </table> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- /.modal -->


    <?php } }    ?>

    <!-- /page content -->


    <script type="text/javascript">
        $('#removeFromRole').submit(function(e) {
            if (confirm("Are You Sure You Want To Remove The Selected Employee(s) From  This Role?") == true) {
                e.preventDefault();
                $.ajax({
                        url: "<?php echo url(''); ?>/flex/removeEmployeeFromRole",
                        type: "post",
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        async: false
                    })
                    .done(function(data) {
                        $('#feedBackRemove').fadeOut('fast', function() {
                            $('#feedBackRemove').fadeIn('fast').html(data);
                        });

                        setTimeout(function() { // wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 2000);
                    })
                    .fail(function() {
                        alert('Update Failed!! ...');
                    });
            }
        });
    </script>
@endsection
