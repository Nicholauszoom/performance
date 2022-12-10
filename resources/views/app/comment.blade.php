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
                <h3>Comment </h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <?php if ($action == 0 && session('mng_proj')) { ?>

        <?php }
        if ($action == 1 && !empty($my_assignments)) {

            foreach ($my_assignments as $row) {
//                $assignID = $row->id;
                $name = $row->name;
                $description = $row->description;
                $project = $row->project;
                $activity = $row->activity;
                $start_date = $row->start_date;
                $end_date = $row->end_date;
                $assignment_employee_id = $row->assignment_employee_id;

            }

            ?>

            <!-- UPDATE INFO AND SECTION -->
            <div class="row">
                <!-- Groups -->
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Assignment Details</b></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="feedBackAssignment"></div>
                                <p>Name:
                                    &nbsp;<b><?php echo $name; ?></b>,  &nbsp&nbsp&nbsp Project: <b><?php echo $project; ?></b>, &nbsp&nbsp&nbsp
                                    Activity:
                                    <b><?php echo $activity; ?></b>, &nbsp&nbsp&nbsp
                                    Description: &nbsp<b><?php echo $description; ?></b>, &nbsp&nbsp&nbsp
                                    Start Date: &nbsp;&nbsp;&nbsp;<b><?php echo $start_date; ?></b>, &nbsp&nbsp&nbsp
                                    End Date: &nbsp;&nbsp;&nbsp;<b><?php echo $end_date; ?></b>
                                </p>
                                <br>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="x_panel">

                            <div class="x_content">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="row">
                                                <div class="col-sm-10">
                                                    <?php
                                                    $task_name = '';
                                                    if (isset($comments)){
                                                        foreach ($comments as $row) {
                                                            if ($row->task_name){
                                                                $task_name = $row->task_name;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <h2><?php echo $task_name;?> comments </h2>
                                                </div>
                                                <div class="col-sm-2">
                                                    <a href="#bottom">
                                                        <button class="btn btn-primary btn-md">New Comment</button>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <table class="table table-striped table-bordered" style="width:100%">
                                                <?php $sn = 1;
                                                foreach ($comments as $row) { ?>
                                                    <tr>
                                                        <td><?php echo $row->name;?><br>
                                                            <b>Time</b>: <?php echo $row->date;?>
                                                        </td>
                                                        <td><?php echo $row->remarks?></td>
                                                        <?php if (session('mng_proj')) { ?>
                                                        <td>
                                                            <a href='javascript:void(0)' onclick='deleteComment(<?php echo json_encode($row); ?>)' title="Delete Assignment" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php $sn++; } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="bottom" class="col-md-12 col-sm-6 col-xs-12">
                                    <!-- PANEL-->

                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>New Comment</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="feedbackResult"></div>
                                            <form id="commentTask" enctype="multipart/form-data" method="post">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                               for="last-name">Comment</label>
                                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                                                    <textarea required type="text" max="150" class="form-control col-md-7 col-xs-12"
                                                                              name="comment" placeholder="Comment"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" id="id" value="<?php echo $assignID; ?>" name="id">

                                                <br>
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-primary" id="save_btn">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Groups -->
                <div class="modal fade" id="edit" role="dialog">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Add Comment</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="panel-body">
                                    <form id="commentTask" enctype="multipart/form-data" method="post">
                                        <div class="row">
                                            <div class="form-group col-md-12 row">
                                                <label for="department"
                                                       class="col-md-4 col-form-label text-md-right">Comment</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" type="text" id="comment" name="comment"
                                                              maxlength="200"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="id" name="id">

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" id="save_btn">Save</button>
                                        </div>
                                    </form>
                                </div>


                            </div>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
            <!-- END UPDATE SECTION  -->
        <?php } ?>

    </div>
</div>


<!-- /page content -->




<script>

    $('#commentTask').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo  url(''); ?>/flex/project/commentTask",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
            .done(function (response) {
                if (response.status == 'OK') {
                    notify('Task comment successfully!', 'top', 'right', 'success');
                    setTimeout(function () {// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                } else {
                    notify('Task error', 'top', 'right', 'danger');
                }
            })
            .fail(function () {
                alert('Request Failed!! ...');
            });
    });

    function deleteComment(row) {
        if (confirm("Are You Sure You Want To Delete This Comment") == true) {
            var row = row;
            var id = row.id;

            $.ajax({
                url: "<?php echo url('flex/project/deleteComment');?>/" + id,
                success: function (data) {

                    if (data.status == 'OK') {
                        notify('Comment deleted successfully!', 'top', 'right', 'success');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    } else {
                        notify('Comment deletion error!', 'top', 'right', 'danger');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);

                    }
                }

            });
        }
    }

</script>

<script>
    function notify(message, from, align, type) {
        $.growl({
            message: message,
            url: ''
        }, {
            element: 'body',
            type: type,
            allow_dismiss: true,
            placement: {
                from: from,
                align: align
            },
            offset: {
                x: 30,
                y: 30
            },
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            url_target: '_blank',
            mouse_over: false,

            icon_type: 'class',
            template: '<div data-growl="container" class="alert" role="alert">' +
                '<button type="button" class="close" data-growl="dismiss">' +
                '<span aria-hidden="true">&times;</span>' +
                '<span class="sr-only">Close</span>' +
                '</button>' +
                '<span data-growl="icon"></span>' +
                '<span data-growl="title"></span>' +
                '<span data-growl="message"></span>' +
                '<a href="#!" data-growl="url"></a>' +
                '</div>'
        });
    }

</script>





 @endsection