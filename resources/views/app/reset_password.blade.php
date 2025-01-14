<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fléx Performance</title>
    <link href="<?php echo  url('');?>style/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo  url('');?>style/login_page/style.css" rel="stylesheet">
    <style type="text/css">
        .center-box{
            position:absolute;
            top:0;
            right:0;
            bottom:0;
            left:0;
            z-index:99;
            margin:auto;
            text-align:center;
        }
    </style>
</head>
<body>
    <div class="registration-form center-box">
        <?php echo form_open('base_controller/resetPassword'); ?>            
            <img  src="<?php echo  url(''); ?>uploads/logo/logo.png" class="form-icon">
            <div class="form-group">
                <input required type="email" class="form-control item" name="email"  placeholder="Enter your email to register/reset password">
            </div>
            <div class="form-group" align="center">
                <p>
                    <font color="red">
                    @if(Session::has('note'))      {{ session('note') }}  @endif
                    echo session("error"); ?>
                    </font>
                </p>
                <button type="submit" value="Login" name="login" class="btn btn-block create-account">Submit</button>
                <h5><a href="<?php echo  url('');?>/flex/base_controller/login" >Back to Login </a></h5>
            </div>
        <?php echo form_close(); ?>
        <div class="social-media">
            <h5>Fléx Performance Software by <a href="http://www.cits.co.tz/">CITS</a></h5>
                <h5> @<?php echo date('Y') ?></h5>
        </div>
    </div>
    <script src="<?php echo  url('');?>style/jquery/jquery.min.js"></script>
    <link href="<?php echo  url('');?>style/login_page/script.js" rel="stylesheet">
</body>
</html>
 @endsection