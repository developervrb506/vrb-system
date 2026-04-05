<?php /*?><script type="text/javascript">
var validations = new Array();
validations.push({id:"email",type:"null", msg:"Please provide a valid Username or Email Address"});
validations.push({id:"pass",type:"null", msg:"Please provide your Password"});
</script><?php */?>
<div class="wrapper">
<div class="top">
  <div class="logoVRB"><a href="http://localhost:8080/"><img src="../images/VRB_logo.png" width="355" height="50" border="0" /></a></div>
  <div class="wrapper_right_top">    
    <div class="login_top">
      <div class="wrapper_box_login">
        <div class="box_login">
          <form style="width:266px;" id="f1" name="f1" method="post" action="http://localhost:8080/process/login/login-process.php">
            <input name="email" type="text" id="email_login" size="16" value="Your username" onblur="reverse_msg(this, 'Your username');" onfocus="reverse_msg(this, 'Your username');" />
            <input name="pass" type="password" id="pass" size="16" value="passwordXaX" onblur="reverse_msg(this, 'passwordXaX');" onfocus="reverse_msg(this, 'passwordXaX');" />           
            <input name="loginbtn" type="submit" id="loginbtn" value="Login" />
          </form>
        </div>
        <?php /*?><div class="joinmember"><a href="http://localhost:8080/dashboard/join.php"><img src="../images/joinmember.png" alt="Not  a member yet? Join us NOW!" width="114" height="39" border="0" /></a></div><?php */?>
      </div>
    </div>
    <div style="color:#F00; font-size:10px; margin-left:40px; margin-bottom:-15px;">
    <? if ( isset($_GET["e"]) and $_GET["e"] != "" ) { echo get_error($_GET["e"]); } ?>
    </div>
    <div class="btn_top"> <?php /*?><a class="btntop" href="http://localhost:8080/contactus.php">CONTACT US</a><?php */?> <?php /*?><a class="btntop" href="http://localhost:8080/whyvrb.php">Why VRB</a><?php */?> <?php /*?><a class="btntop" href="http://localhost:8080/aboutus.php">About Us</a><?php */?> <?php /*?><a class="btntop" href="http://localhost:8080/">Home</a><?php */?> </div>
  </div>
</div>
