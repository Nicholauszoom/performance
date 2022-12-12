
    <div id="bottom" class="col-md-12 col-sm-12 col-xs-12">

        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-tasks"></i> Add Branch</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <form id="addBankBranch" autocomplete="off" enctype="multipart/form-data" method="post"
                    data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">

                    <!-- START -->
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Branch Name</label>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <textarea required="" class="form-control col-md-7 col-xs-12" name="name" placeholder="Branch Name"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3  col-xs-6">Bank Name</label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <select required="" name="bank" class="select4_single form-control" tabindex="-1">
                                <option></option>
                                <?php  foreach ($banks as $row) {
                                 # code... ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Country</label>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input required class="form-control col-md-7 col-xs-12" type="text" maxlength="15"
                                placeholder="Country" name="country">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Region</label>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input required class="form-control col-md-7 col-xs-12" type="text" maxlength="15"
                                placeholder="Region" name="region">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Street</label>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input required class="form-control col-md-7 col-xs-12" type="text" maxlength="15"
                                placeholder="Street" name="street">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Branch Code</label>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input required class="form-control col-md-7 col-xs-12" type="text" maxlength="15"
                                placeholder="Branch Code" name="code">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Swift Code</label>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" type="text" maxlength="15"
                                placeholder="Swift Code" name="swiftcode">
                        </div>
                    </div>
                    <!-- END -->
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="reset" class="btn btn-warning" data-dismiss="modal">CANCEL</button>
                            <button class="btn btn-primary">ADD</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    </div>
    </div>
    </div>




    <?php if( session('mng_bank_info')){ ?>
    <!-- Modal -->
    <div class="modal fade" id="addBankModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add Bank</h4>
                </div>
                <div class="modal-body">
                    <!-- Modal Form -->
                    <form id="demo-form2" autocomplete="off" enctype="multipart/form-data" method="post"
                        action="<?php echo url(''); ?>/flex/addBank" data-parsley-validate
                        class="form-horizontal form-label-left" autocomplete="off">


                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bank Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="has-feedback">
                                    <input required="" type="text" name="name" class="form-control col-xs-12"
                                        aria-describedby="inputSuccess2Status">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bank Abbrev
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="has-feedback">
                                    <input type="text" name="abbrv" class="form-control col-xs-12"
                                        aria-describedby="inputSuccess2Status">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Bank Code
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="has-feedback">
                                    <input required="" type="text" name="bank_code" class="form-control col-xs-12"
                                        aria-describedby="inputSuccess2Status">
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <input type="submit" value="ADD" name="add" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Modal Form -->
    </div>
    <?php } ?>
