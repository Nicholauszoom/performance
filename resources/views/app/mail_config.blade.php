@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')
<!-- Font Awesome -->
<link href="<?php echo  url(''); ?>style/fstdropdown/fstdropdown.css" rel="stylesheet">
<!--top navigation -->

<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="">

        <?php

            if (isset($mails)){
                foreach ($mails as $mail){
                    $id = $mail->id;
                    $host = $mail->host;
                    $name = $mail->name;
                    $username = $mail->username;
                    $secure = $mail->secure;
                    $port = $mail->port;
                    $password = $mail->password;

                }
            }

        ?>

        <!-- Tabs -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bars"></i> Mail Configuration</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <form autocomplete="off" id="addMail" method="post" class="form-horizontal form-label-left">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Host</label>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <input type="text" required="" name="host" value="<?php if (isset($host)) echo $host; ?>" class="form-control col-xs-12 has-feedback-left">
                            </div>
                        </div>

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <input type="text" required="" name="name" value="<?php if (isset($name)) echo $name; ?>" class="form-control col-xs-12 has-feedback-left">
                            </div>
                        </div>

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <input type="text" required="" name="username" value="<?php if (isset($username)) echo $username; ?>" class="form-control col-xs-12 has-feedback-left">
                            </div>
                        </div>

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Encryption</label>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <input type="text" required="" name="encryption" value="<?php if (isset($secure)) echo $secure; ?>" class="form-control col-xs-12 has-feedback-left">
                            </div>
                        </div>

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Port</label>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <input type="number" required="" name="port" value="<?php if (isset($port)) echo $port; ?>" class="form-control col-xs-12 has-feedback-left">
                            </div>
                        </div>

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <input type="password" required="" name="password" value="<?php if (isset($password)) echo $password; ?>" class="form-control col-xs-12 has-feedback-left">
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?php if (isset($id)) echo $id;?>">

                        <button style="margin-left: 37%" type="submit" class="btn btn-success">Save</button>

                    </form>


                </div>
            </div>
        </div>
        <!-- End Tabs -->


    </div>
</div>
<!-- /page content -->

<?php
 ?>

<!-- fstdropdown -->
<script src="<?php echo  url(''); ?>style/fstdropdown/fstdropdown.js"></script>

<script>
    $(document).ready(function(){
    });
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

<script>
    $('#addMail').submit(function (e) {

        e.preventDefault(); // Prevent Default Submission

        $.ajax({
            url: "<?php echo  url(''); ?>/flex/payroll/saveMail",
            type: 'POST',
            data: $(this).serialize(), // it will serialize the form data
            dataType: 'json'
        })
            .done(function (data) {
                if (data.status == 'OK') {
                    notify('Mail added and connected successfully!', 'top', 'right', 'success');

                    setTimeout(function () {// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                    $('#addFunder')[0].reset();

                } else if (data.status == 'ERRR') {
                    notify('Mail can not be connected , please try again!', 'top', 'right', 'danger');
                }else{
                    notify('Mail add error, please try again!', 'top', 'right', 'danger');
                }
            })
            .fail(function () {
                alert('Mail Not Saved! Please Review Your Network Connection ...');
            });

    });

</script>



 @endsection