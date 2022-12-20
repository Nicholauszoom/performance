
        


@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php

  foreach ($info as $row) {
    $username=$row->username;
    $password=base64_decode($row->password);
  }
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Login Info</h3>
                <h6> <p   <?php if(session('pass_age')>80){?> style="color:red" <?php } ?> >   <?php if(session('pass_age')<90) { ?>  Password Expires in <?php echo (90 - session('pass_age')); ?> Days <?php } ?> 
                          <?php if(session('pass_age')>89) { ?>  Password Expired <?php } ?> 
              </p> </h6>
                
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2>Update Login Info</h2>

               <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                  <div id="feedback"></div>

                  @if(Session::has('note'))      {{ session('note') }}  @endif  ?>

                    <form id="updateLoginInfo" method="post" autocomplete="off" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Username<span class="required">*</span>
                        </label>
                        
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input  type="text" required="" value="<?php echo $username; ?>" name="username" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php// echo form_error("username");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Password<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="password" required placeholder="Enter Your New Password" name="password" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php// echo form_error("password");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Confirm Password <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input  type="password" required placeholder="Confirm Your New Password Password"   name="conf_password"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php// echo form_error("conf_password");?></span>
                        </div>
                      </div>
                      <!-- <div class="ln_solid"></div> -->
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-success">Update</button>
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




<script type="text/javascript">
  $('#updateLoginInfo').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission


      $.ajax({
          url: "<?php echo  url(''); ?>/flex/update_login_info",
          type: 'POST',
          data: $(this).serialize(), // it will serialize the form data
          // dataType: 'json',
          success:function(data)
          {
              let jq_json_obj = $.parseJSON(data);
              let jq_obj = eval (jq_json_obj);

              if(jq_obj.status == 'OK'){

                  notify('Password changed successfully!', 'top', 'right', 'success');
                  setTimeout(function() {
                      location.reload();
                  }, 2000);

              } else if(jq_obj.status == 'ERR'){

                    notify('Password fields do not match!', 'top', 'right', 'danger');

              }else if(jq_obj.status == 'ERR_P'){

              notify('Password must contain the mixture of numbers,special character, small and capital leters and not less than 8 characters!', 'top', 'right', 'danger');

              }else{

                  notify('Password must contain the mixture of numbers,special character, small and capital leters and not less than 8 characters', 'top', 'right', 'danger');

              }

          },
          error: function(jqXHR, textStatus, errorThrown) {
              notify('System error!', 'top', 'right', 'danger');

          }

      });


 //   $.ajax({
 //url: "<?php //echo  url(''); ?>/flex/update_login_info",
 //type: 'POST',
 //data: $(this).serialize(), // it will serialize the form data
 //       dataType: 'json'
 //   })
 //   .done(function(data){
 //
 //       var regex = /(<([^>]+)>)/ig
 //       var body = data.message;
 //       var result = body.replace(regex, "");
 //
 //     if(data.status == 'OK'){
 //       alert(result);
 //               $('#feedback').fadeOut('fast', function(){
 //                 $('#feedback').fadeIn('fast').html(data.message);
 //               });
 //
 //             } else{
 //               alert(result);
 //               $('#feedback').fadeOut('fast', function(){
 //                 $('#feedback').fadeIn('fast').html(data.message);
 //               });
 //             }
 //   })
 //   .fail(function(){
 //alert('FAILED Update, Review Your Network Connection...');
 //   });

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


 @endsection