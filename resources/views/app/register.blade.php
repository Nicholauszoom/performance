<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title; ?></title>

		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Zalongwa Saris Login Form"/>
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <link rel="stylesheet" type="text/css" href="<?php echo  url(''); ?>includes/css/demo.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo  url(''); ?>includes/css/style.css" />
</he    ad>
<style type="text/css">
   
span.logo {
display: block;
position: relative;
margin: 0 auto;
top: -10px;
height: 128px;
width: 128px;
background: url('<?php echo  url(''); ?>uploads/img/cits.png') center center no-repeat, #FFF;
border-radius: 50%;
-ms-filter: "progid:DXImageTransform.Microsoft.Shadow(Strength=5, Direction=0, Color=#000000)";/*IE 8*/
-moz-box-shadow: 0 0 5px 2px rgba(0,0,0,0.3);/*FF 3.5+*/
-webkit-box-shadow: 0 0 5px 2px rgba(0,0,0,0.3);/*Saf3-4, Chrome, iOS 4.0.2-4.2, Android 2.3+*/
box-shadow: 0 0 5px 2px rgba(0,0,0,0.3);/* FF3.5+, Opera 9+, Saf1+, Chrome, IE10 */
filter: progid:DXImageTransform.Microsoft.Shadow(Strength=5, Direction=135, Color=#000000); /*IE 5.5-7*/
}
</style>
    <body>
        <div class="container" style="padding-top: 40px;">
            <section >

                <div id="container_demo" >
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">                                    		
                                    <form action="<?php echo  url('');?>/flex/base_controller/register_submit" method="post"  name="idpform"> 
    								<a href="#""><span bac class="logo"></span></a>
                                    <h1>Flex Performance</br>Register</h1> 
                                    <p> 
                                        <label for="username" class="uname" data-icon="u" > Your User ID </label>
                                        <input id="username" name="userID"  type="text"  placeholder="UserID"/>
                                        <span><font color="red"><?php// echo form_error("userID");?></font></span>
                                    </p>
                                    <p> 
                                        <label for="username" class="uname" data-icon="u">Your username</label>
                                        <input id="username" name=username type="text" placeholder="Username"/>
                                        <span><font color="red"><?php// echo form_error("username");?></font></span>
                                    </p>
                                    <p> 
                                        <label for="password" class="youpasswd" data-icon="p"> Your password </label>
                                        <input id=textpassword name=password  type="password" placeholder="eg. Zv43?#90Em" /> 
                                        <span><font color="red"><?php// echo form_error("password");?></font></span>
                                    </p>
                                    <p> 
                                        <label for="password" class="youpasswd" data-icon="p"> Confirm Your Password </label>
                                        <input id=textpassword name="password_conf"  type="password" placeholder="eg. Zv43?#90Em" /> 
                                        <span><font color="red"><?php// echo form_error("password_conf");?></font></span>
                                    </p>
                                    <p><font color="red">
                                        <?php echo $this->session->flashdata("error");  ?>
                                        </font>
                                    </p>

                                    <p class="login button"> 
                                        <input type="submit" value="Register" name="register" id="btnLogin"/> 
                                    </p>

                                <div class="change_link">
                                	
                                	<span style="float: right;">Already Have an Account?
                                	<a href="<?php echo  url('');?>/flex/base_controller/login" class="to_register">Sign In</a>
                                	</span>
                                </div>
                            </form>
                		</div>		
					</div>
                </div>  
            </section>
        </div>
    </body>
</html>

 @endsection