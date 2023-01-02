<?php include "header")
<?php include "topnavbar")
<?php include "sidebar")
         

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- SUCCESS FORM -->

            <?php 
            //if ($this->uri->segment(2) == "inserted") { 
              echo session("note"); 
              
            //}  
             ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Basic Form Elements
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            <div class="col-lg-4">
                                    <form  method="post" enctype="multipart/form-data" action="<?php echo  url(''); ?>/flex/main_controller/form_validation" >
                            

                      <div class="form-group">
                        <label  for="first-name">First Name 
                        </label>
                        <div >
                          <input type="text" name="fname" id="fname"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php// echo form_error("fname");?></span>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label  for="last-name">Last Name 
                        </label>
                        <div >
                          <input type="text" id="lname" name="lname" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php// echo form_error("lname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="middle-name" >Middle Name</label>
                        <div >
                          <input id="mname" class="form-control col-md-7 col-xs-12" type="text" name="mname">
                          <span class="text-danger"><?php// echo form_error("mname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label >Gender</label>
                        <div >
                          <div id="gender" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default" data-toggle-class="btn-main" data-toggle-passive-class="btn-default">
                              <input id="gender" type="radio" name="gender" value="M"> &nbsp; Male &nbsp;
                            </label>
                            <label class="btn btn-main" data-toggle-class="btn-main" data-toggle-passive-class="btn-default">
                              <input id="gender"  type="radio" name="gender" value="F"> Female
                            </label>
                          </div>
                          <span class="text-danger"><?php// echo form_error("gender");?></span>
                        </div>
                      </div>

                  </div>
                  <!-- /.col-lg-6 (nested) -->
                  <div class="col-lg-4">

                      <div class="form-group">
                        <label for="middle-name" >Class</label>
                        <div >
                          <input id="class" class="form-control col-md-7 col-xs-12" type="text" name="class">
                          <span class="text-danger"><?php// echo form_error("class");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="stream" >Stream</label>
                        <div >
                          <input id="stream" class="form-control col-md-7 col-xs-12" type="text" name="stream">
                          <span class="text-danger"><?php// echo form_error("stream");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="stream" >Email</label>
                        <div >
                          <input id="email" class="form-control col-md-7 col-xs-12" type="text" name="email">
                          <span class="text-danger"><?php// echo form_error("email");?></span>
                        </div>
                      </div>

                  </div>
                  <!-- /.col-lg-6 (nested) -->
                  <div class="col-lg-4">

                      <div class="form-group">
                        <label for="middle-name" >Password</label>
                        <div >
                          <input id="password" class="form-control col-md-7 col-xs-12" type="text" name="password">
                          <span class="text-danger"><?php// echo form_error("password");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="stream" >Confirm Password</label>
                        <div >
                          <input " class="form-control col-md-7 col-xs-12" type="text" name="passwordconf">
                          <span class="text-danger"><?php// echo form_error("passwordconf");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label >Date Of Birth 
                        </label>
                        <div >
                          <input id="dob" name="dob" class="date-picker form-control col-md-7 col-xs-12" type="text">
                          <span class="text-danger"><?php// echo form_error("dob");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label >Picture 
                        </label>
                      
                        
                        <input type="file" name="image"  />
                      </div><br><br>
                      <!-- <div class="ln_solid"></div> -->
                      <div class="form-group">
                          <button type="reset" class="btn btn-main">Cancel</button>
                          <button type="submit" id="submit" name="register" class="btn btn-success">Submit</button>
                       
                      </div>

                    </form>
                </div>       
                <!-- col-lg-4 nested end -->
                 
                           
            </div>
            <!-- /.row -->
        </div>
        <!-- wraapper -->


              <!-- 
        <script type="text/javascript">
      $(document).ready(function(e){
        $('#submit').click(function(){
          var fname =$('#fname').val();
          var mname =$('#mname').val();
          var lname =$('#lname').val();
          var gender =$('#gender').val();
          var clas =$('#class').val();
          var stm =$('#stream').val();
          var email =$('#email').val();
          var password =$('#password').val();
          var dob =$('#dob').val();
          $.ajax({
            type  :'POST',
            data  :{fname:fname, mname:mname, lname:lname, gender:gender, clas:clas, stm:stm, email:email, password:password, dob:dob },
            url   :"<?php echo  url(''); ?>/flex/main_controller/form_validation",
            success :function(result){
              $('#alert').show();
              $('#show').html(result);
              $('#form')[0].reset();
            }
          })
        });
      });
    </script>

     -->

        <?php include "footer")
 @endsection