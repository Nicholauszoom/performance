@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Company Branch </h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Branchs
                            <?php if(session('mng_org')){ ?><a href="#bottom"><button type="button"
                                    id="modal" data-toggle="modal" data-target="#departmentModal"
                                    class="btn btn-primary">ADD NEW</button></a> <?php } ?></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                        <table id="" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Location</th>
                                    <?php if(session('mng_org')){ ?>
                                    <th>Option</th>
                                    <?php } ?>
                                </tr>
                            </thead>


                            <tbody>
                                <?php
                          foreach ($branch as $row) { ?>
                                <tr id="domain<?php echo $row->id;?>">
                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->department_name; ?></td>
                                    <td><b>Country:</b> <?php echo $row->country; ?><br>
                                        <b>Region:</b> <?php echo $row->region; ?><br>
                                        <b>Street:</b> <?php echo $row->street; ?><br>
                                    </td>

                                    <?php if(session('mng_org')){ ?>
                                    <td class="options-width">
                                        <a title="Update" class="icon-2 info-tooltip"><button type="button" id="modal"
                                                data-toggle="modal" data-target="#updateModal<?php echo $row->id; ?>"
                                                class="btn btn-info btn-xs"> <i class="fa fa-edit"></i></button></a>

                                        <a href="<?php echo url(); ?>flex/company_branch_info/?id=".base64_encode($row->id); ?>"
                                            title="Info and Details" class="icon-2 info-tooltip"><button type="button"
                                                class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button>
                                        </a>
                                        <a href="javascript:void(0)" onclick="closeBranch(<?php echo $row->id; ?>)"
                                            title="Delete Deduction" class="icon-2 info-tooltip"><button type="button"
                                                class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                        </a>


                                        <!--update Modal -->
                                        <div class="modal fade" id="updateModal<?php echo $row->id; ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Update Branch</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Modal Form -->
                                                        <form id="demo-form2" enctype="multipart/form-data"
                                                            method="post"
                                                            action="<?php echo url(); ?>flex/updateCompanyBranch"
                                                            data-parsley-validate
                                                            class="form-horizontal form-label-left">

                                                            <input type="text" name="branchID" hidden=""
                                                                value="<?php echo $row->id;?>">

                                                            <div class="form-group">
                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                                    for="last-name">Name
                                                                </label>
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <textarea class="form-control col-md-7 col-xs-12"
                                                                        required name="name" placeholder="Name"
                                                                        rows="3"> <?php   echo $row->name; ?></textarea>
                                                                </div>
                                                            </div>


                                                            <div class="form-group">
                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                                    for="last-name">Department
                                                                </label>
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <select class="form-control col-md-7 col-xs-12"
                                                                        required name="department_id"><?php  foreach ($department as $data) {
                                 # code... ?>
                                                                        <option value="<?php echo $data->id; ?>">
                                                                            <?php echo $data->name; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                         

                                                            <div class="form-group">
                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                                    for="last-name">Region
                                                                </label>
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <input required type="text" name="region"
                                                                        value="<?php echo $row->region; ?>"
                                                                        class="form-control col-md-7 col-xs-12">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                                    for="last-name">Street
                                                                </label>
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <input required type="text" name="street"
                                                                        value="<?php echo $row->street; ?>"
                                                                        class="form-control col-md-7 col-xs-12">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close</button>
                                                                <input type="submit" value="UPDATE" name="update"
                                                                    class="btn btn-primary" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- Modal Form -->
                                        </div>
                                        <!-- /.modal -->
                                        <!-- Update Modal-->
                                        <!--ACTIONS-->
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php } //} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <?php if(session('mng_org')){ ?>
            <div id="bottom" class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Add Company Branch</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="feedBack"></div>
                        <form autocomplete="off" id="addBranch" enctype="multipart/form-data" method="post"
                            data-parsley-validate class="form-horizontal form-label-left">

                            <!-- START -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Branch
                                    Name</label>
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <textarea required="" class="form-control col-md-7 col-xs-12" name="name"
                                        placeholder="Branch Name" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3  col-xs-6">Department
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <select required="" name="department_id" class="select4_single form-control"
                                        tabindex="-1">
                                        <option>select Department</option>
                                        <?php  foreach ($department as $row) {
                                 # code... ?>
                                        <option value="<?php echo $row->id; ?>">
                                            <?php echo $row->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3  col-xs-6">Country</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <select required name="country" class="select_country form-control" tabindex="-1">
                                        <option></option>
                                        <?php foreach ($countrydrop as $row){ ?>
                                        <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Region</label>
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input required="" class="form-control col-md-7 col-xs-12" name="region"
                                        placeholder="Branch Region" rows="2" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Street</label>
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input required="" class="form-control col-md-7 col-xs-12" name="street"
                                        placeholder="Branch Street" rows="2" />
                                </div>
                            </div>
                    </div>
                    <!-- END -->
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary">ADD</button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
            <?php } ?>

        </div>

    </div>
</div>
</div>




<!-- /page content -->




<script type="text/javascript">
$('#addBranch').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/addCompanyBranch",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(data) {
            $('#feedBack').fadeOut('fast', function() {
                $('#feedBack').fadeIn('fast').html(data);
            });
            setTimeout(function() { // wait for 2 secs(2)
                location.reload(); // then reload the page.(3)
            }, 2000);
            //   $('#updateMiddleName')[0].reset();
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});
</script>
 @endsection