<?php 
//   include_once "app/includes/login_header.php"; 
  ?>
  
        <div class="container" style="padding-top: 40px;">
            <section >

                <div id="container_demo" >
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                                    <?php echo form_open('base_controller/login'); ?>
                                    <INPUT type=hidden value=1 name=validate> 
                                    <a href="#""><img class = "logo" height="100" width="200" src = "<?php  echo url(); ?>uploads/logo/organization_logos.jpeg"></a>
                                    <h1>Fléx Performance</h1>
                                    <p> 
                                        <label for="username"   >Username </label>
                                        <input style="width:300px" name=username  type="text"  placeholder="Username"/>
                                        <span><font color="red"><?php echo form_error("username");?></font></span>
                                    </p>
                                    <p> 
                                        <label for="password"  > Password </label>
                                        <input style="width:300px"  name=password  type="password" placeholder="eg. Zv43?#90Em" /> 
                                        <span><font color="red"><?php echo form_error("password");?></font></span>
                                    </p>
                                    <p><font color="red">
                                        @if(Session::has('note'))      {{ session('note') }}  @endif
                                        echo $this->session->flashdata("error"); ?>
                                        </font>
                                    </p>

                                    <p style="width:300px;"> 
                                        <input style="width:300px; margin-left:70px" class="btn-login center" type="submit" value="Login" name=login id="btnLogin"/> 
                                    </p>

                                    <span style="float: center; margin-left:70px">
                                    <a href="<?php echo url();?>flex/base_controller/forgot_password" class="to_register">Forgot password?</a>
                                    </span>

                               <!--  <div class="change_link">
                                	
                                    <span style="float: left;">
                                    <a href="<?php echo url();?>flex/base_controller/forgot_password" class="to_register">Forgot password?</a>
                                    </span>
                                	
                                	<span style="float: right;">New?
                                	<a href="<?php echo url();?>flex/base_controller/register"" class="to_register">Sign Up</a>
                                	</span>
                                </div> -->
                             <?php echo form_close(); ?>

                		</div>		
					</div>
                </div>  
            </section>
        </div>
    </body>
</html>

 @endsection