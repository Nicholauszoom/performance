@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php

//$CI_Model = get_instance();
//$CI_Model = $this->load->model('flexperformance_model');
?>


<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Employee Report </h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Employee Profile
                        </h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/reports/employeeReport" target="_blank"  data-parsley-validate class="form-horizontal form-label-left">

                            <div class="form-group">
                                <label class="control-label col-md-3  col-xs-6" >Employee Name</label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <select required="" name="employee" class="select4_single form-control" tabindex="-1">
                                        <option></option>
                                        <?php
                                        foreach ($employees as $row) {
                                            # code... ?>
                                            <option value="<?php echo $row->emp_id; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="reset" class="btn btn-success">Cancel</button>
                                    <input type="submit"  value="PRINT" name="print" class="btn btn-primary"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /page content -->






<script>
    function approveDeptPosTransfer(id){
        if (confirm("Are You Sure You Want To Approve This Transfer(The Action may be Irreversible) ?Requirement") == true) {
            var id = id;
            $.ajax({
                url:"<?php echo url('flex/approveDeptPosTransfer');?>/"+id,
                success:function(data)
                {
                    $('#resultFeedback').fadeOut('fast', function(){
                        $('#resultFeedback').fadeIn('fast').html(data);
                    });
                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);


                }

            });
        }
    }
    function approveSalaryTransfer(id){
        if (confirm("Are You Sure You Want To Approve This Transfer(The Action may be Irreversible) ?Requirement") == true) {
            var id = id;
            $.ajax({
                url:"<?php echo url('flex/approveSalaryTransfer');?>/"+id,
                success:function(data)
                {
                    $('#resultFeedback').fadeOut('fast', function(){
                        $('#resultFeedback').fadeIn('fast').html(data);
                    });
                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);


                }

            });
        }
    }
    function approvePositionTransfer(id){
        if (confirm("Are You Sure You Want To Approve This Transfer(The Action may be Irreversible) ?Requirement") == true) {
            var id = id;
            $.ajax({
                url:"<?php echo url('flex/approvePositionTransfer');?>/"+id,
                success:function(data)
                {
                    $('#resultFeedback').fadeOut('fast', function(){
                        $('#resultFeedback').fadeIn('fast').html(data);
                    });
                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);


                }

            });
        }
    }
    function disapproveRequest(id){
        if (confirm("Are You Sure You Want To CANCEL/DELETE This Transfer(The Action may be Irreversible) ?Requirement") == true) {
            var id = id;
            $.ajax({
                url:"<?php echo url('flex/cancelTransfer');?>/"+id,
                success:function(data)
                {
                    $('#resultFeedback').fadeOut('fast', function(){
                        $('#resultFeedback').fadeIn('fast').html(data);
                    });
                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);


                }

            });
        }
    }
</script>
 @endsection