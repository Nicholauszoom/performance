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
                <h3>Activities</h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <?php 
        if ($action == 1) {

  

            ?>

        <!-- UPDATE INFO AND SECTION -->
        <div class="row">
            <!-- Groups -->

            <!-- Groups -->

            <!--UPDATE-->
            <?php if (session('mng_proj')) { ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Activities</b></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#overtimeTab" id="home-tab" role="tab"
                                        data-toggle="tab" aria-expanded="true">Add results</a>
                                </li>

                                <!--     <li role="presentation" class=""><a href="#imprestTab" role="tab" id="profile-tab"
                                        data-toggle="tab" aria-expanded="false">New Activity</a>
                                </li> -->

                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="overtimeTab"
                                    aria-labelledby="home-tab">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <div class="row">
                                                    <div class="col-sm-9">
                                                        <h2>Add Results</h2>
                                                    </div>
                                                    <div class="col-sm-3">

                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <form autocomplete="off" id="saveActivityResult" enctype="multipart/form-data"
                                                    method="post" data-parsley-validate
                                                    class="form-horizontal form-label-left">

                                                    <!-- START -->
                                                
                                                  
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">
                                                            result based on target</label>
                                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12"
                                                                name="result" value=""
                                                                placeholder="result based on target" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">
                                                             Cost (if Apply)</label>
                                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12"
                                                                name="exactly_cost" value=""
                                                                placeholder="Cost (if Apply)" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">Description
                                                        </label>
                                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                                            <textarea required=""
                                                                class="form-control col-md-7 col-xs-12"
                                                                name="description" placeholder="Description"
                                                                rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">
                                                            Any Document if Exist</label>
                                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                                            <input type="file" class="form-control col-md-7 col-xs-12"
                                                                name="file" placeholder="Select file" />
                                                        </div>
                                                    </div>
                                                 
                                     
                                                    
                                                    <input type="hidden" name="empID"
                                                        value="<?php echo $empID; ?>">
                                                        <input type="hidden" name="activity_id"
                                                        value="<?php echo $activity_id; ?>">
                                                    <!-- END -->
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                            <button class="btn btn-primary">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="imprestTab"
                                    aria-labelledby="profile-tab">
                                    <div id="resultfeedImprest"></div>
                                
                                </div>




                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <!-- END UPDATE SECTION  -->
        <?php } ?>

    </div>
</div>


<!-- /page content -->




<script type="text/javascript">
$('#saveActivityResult').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/saveActivityResult",
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
                alert('Result Saved successfully!! ...');
                //window.location.href = "<?php echo url('flex/project/evaluateEmployee/?id=');?>"+data.empID+"|"+data.department; // then reload the page.(3)
               location.reload(); // then reload the page.(3)
            }, 1000);
            // $('#addProject')[0].reset();
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});

$('#addProject').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/addProject",
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
            }, 1000);
            $('#addProject')[0].reset();
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});

$('#updateName').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/updateProjectName",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(data) {
            $('#feedBackSubmission').fadeOut('fast', function() {
                $('#feedBackSubmission').fadeIn('fast').html(data);
            });
            setTimeout(function() { // wait for 2 secs(2)
                location.reload(); // then reload the page.(3)
            }, 1000);
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});


$('#updateCode').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/updateProjectCode",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(data) {
            $('#feedBackSubmission').fadeOut('fast', function() {
                $('#feedBackSubmission').fadeIn('fast').html(data);
            });
            setTimeout(function() { // wait for 2 secs(2)
                location.reload(); // then reload the page.(3)
            }, 1000);
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});

$('#updateDescription').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/updateProjectDescription",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(data) {
            $('#feedBackSubmission').fadeOut('fast', function() {
                $('#feedBackSubmission').fadeIn('fast').html(data);
            });
            setTimeout(function() { // wait for 2 secs(2)
                location.reload(); // then reload the page.(3)
            }, 1000);
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});
</script>

<script>
$(function() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var startYear = today.getFullYear() - 18;
    var endYear = today.getFullYear() - 60;
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }


    var dateStart = dd + '/' + mm + '/' + startYear;
    var dateEnd = dd + '/' + mm + '/' + endYear;
    $('#end_date').daterangepicker({
        drops: 'up',
        singleDatePicker: true,
        autoUpdateInput: false,
        showDropdowns: true,
        maxYear: parseInt(moment().format('YYYY'), 100),
        minDate: dateEnd,
        startDate: moment(),
        locale: {
            format: 'DD/MM/YYYY'
        },
        singleClasses: "picker_2"
    }, function(start, end, label) {

    });
    $('#end_date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    $('#end_date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});

$(function() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var startYear = today.getFullYear() - 18;
    var endYear = today.getFullYear() - 60;
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }


    var dateStart = dd + '/' + mm + '/' + startYear;
    var dateEnd = dd + '/' + mm + '/' + endYear;
    $('#start_date').daterangepicker({
        drops: 'up',
        singleDatePicker: true,
        autoUpdateInput: false,
        showDropdowns: true,
        maxYear: parseInt(moment().format('YYYY'), 100),
        minDate: dateEnd,
        startDate: moment(),
        locale: {
            format: 'DD/MM/YYYY'
        },
        singleClasses: "picker_2"
    }, function(start, end, label) {

    });
    $('#start_date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    $('#start_date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
</script>
 @endsection