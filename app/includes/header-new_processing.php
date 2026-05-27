
<div class="wrapper">
<div class="top">
  <div class="logoVRB"><a href="<?= BASE_URL ?>/"><img src="../images/VRB_logo_processing.png" width="355" height="50" border="0" /></a></div>
  <div class="wrapper_right_top">    
    <div class="login_top" style="margin-top: 25px;">
      <div class="wrapper_box_login">
        <div class="box_login" style="margin-top:10px;">
          <form style="width:394px;" id="f1" name="f1" method="post" action="https://www.ezpay.com/process/login/login-process.php">
            <input name="email" type="text" id="email_login" size="16" value="Your username" onblur="reverse_msg(this, 'Your username');" onfocus="reverse_msg(this, 'Your username');" />
            <input name="pass" type="password" id="pass" size="16" value="passwordXaX" onblur="reverse_msg(this, 'passwordXaX');" onfocus="reverse_msg(this, 'passwordXaX');" />           
            <input name="loginbtn" type="submit" id="loginbtn" value="Login" />
          </form>
        </div>
    </div>
    <div style="color:#F00; font-size:10px; margin-left:40px; margin-bottom:-15px;">
    <? if ( isset($_GET["e"]) and $_GET["e"] != "" ) { echo get_error($_GET["e"]); } ?>
    </div>
  </div>
</div>
