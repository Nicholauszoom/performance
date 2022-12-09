<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fléx Performance</title>

    <!-- Bootstrap -->
    <link href="<?php echo url();?>style/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo url();?>style/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo url();?>style/build/css/custom.css" rel="stylesheet">
    <link href="<?php echo url();?>style/build/css/customcheckbox.css" rel="stylesheet">
    <!-- Date Range Picker -->
     <link href="<?php echo url();?>style/date-picker/daterangepicker.css" rel="stylesheet">

     <!-- Select2 -->
    <link href="<?php echo url();?>style/select2/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="<?php echo url();?>style/select2/switchery.min.css" rel="stylesheet">

        <!-- Organization Chart Css files -->
    <link href="<?php echo url();?>includes/organizationChart/organization-chart.css" rel="stylesheet">
    <link href="<?php echo url();?>includes/organizationChart/tree.css" rel="stylesheet">

    <link href="<?php echo url();?>includes/crop/jquery.Jcrop.min.css" rel="stylesheet">


    <!-- Datatables -->
    <script src="<?php echo url();?>style/datatables/css/dataTables.bootstrap.min.css"></script>
    <?php  date_default_timezone_set('Africa/Dar_es_Salaam'); ?>

    <!-- notification -->
    <link href="<?php echo url();?>includes/notification/css/notification.min.css" rel="stylesheet">
    

    <style>

input#crop {
    padding: 5px 25px 5px 25px;
    background: lightseagreen;
    border: #485c61 1px solid;
    color: #FFF;
    visibility: hidden;
}
.tooltip{
    position:absolute;
    z-index:1020;
    display:block;
    visibility:visible;
    padding:5px;
    font-size:13px;
    opacity:0;
    filter:alpha(opacity=0)
}
.tooltip.in{
    opacity:.8;
    filter:alpha(opacity=80)
}


.tooltip-inner{
    width:700px;
    height:50px;
    padding:3px 8px;
    color:#314A5B;
    text-align:center;
    font-weight:900;
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(10%, #5bc0de), to(#FFFFFF));
    background: -moz-linear-gradient(top, #FFFFFF, #5bc0de 1px, #FFFFFF 50px);
    -webkit-border-radius:5px;
    -moz-border-radius:5px;
    border-radius:15px;
    border: 1px solid #314A5B;
}


.tooltip-arrow{
    position:absolute;
    width:0;
    height:0
}


</style>
  </head>


  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
