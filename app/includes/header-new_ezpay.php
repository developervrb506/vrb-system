<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ezpay.com</title>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
<link href="css/ezpay_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="wrapper">
<div class="live_support_top">Call Us: <span>(+506) 2228-<span style="display:none;">**</span>9034</span>&nbsp;&nbsp;&nbsp;
<?php /*?><a style="color:#FFF; text-decoration: none;" href="" onclick="Javascript:window.open('http://localhost:8080/livehelp/request_email.php?l=admtop&amp;x=1&amp;deptid=5&amp;agsite=ezpay','livehelp','width=530,height=410,menubar=no,location=no,resizable=yes,scrollbars=yes,status=no');return(false);" target="_top">LIVE SUPPORT&gt;&gt;</a><?php */?></div>
	<div class="wrapper_top">
    	<div class="logo"><img src="images/ezpay/ezpay.jpg" width="253" height="96" /></div>
        <div class="error_box"><? if ( isset($_GET["e"]) and $_GET["e"] != "" ) { echo get_error($_GET["e"]); } ?></div>
		<div class="right-top">
        	<div class="side-righttop"><img src="images/ezpay/side-gray-login.jpg" width="11" height="40" /></div>
            <form id="f1" name="f1" method="post" action="https://www.ezpay.com/process/login/login-process.php">
            <div class="content-user-pass">
            <input class="login-top" name="email" type="text" id="email_login" size="16" value="Your username" onblur="reverse_msg(this, 'Your username');" onfocus="reverse_msg(this, 'Your username');" />
            </div>
            <div class="content-user-pass">
              <input class="login-top" name="pass" type="password" id="pass" size="16" value="passwordXaX" onblur="reverse_msg(this, 'passwordXaX');" onfocus="reverse_msg(this, 'passwordXaX');" />  
            </div>
            <div class="content-btn-login"><input type="image" src="images/ezpay/login-btn.png" /></div>
        	</form>
        </div>
    </div>
    
    <div class="banner_logos">
   	  <div class="logos-finance"><img src="images/ezpay/moneygram-logo.jpg" width="294" height="67" border="0" /></div>
        <div class="logos-finance" style="margin-top:80px;"><img src="images/ezpay/westernunion-logo.jpg" width="161" height="61" border="0" /></div>
        <div class="logos-finance" style="margin-top:60px;"><img src="images/ezpay/ria-logo.jpg" width="154" height="82" border="0" /></div>
        <div class="text-finance">Trusted, Reliable, Secure &gt;&gt;</div>
  </div>
    <div class="wrapper-moreinfo-skype">
    	<div class="text-top-moreinfo">For more information, how to get started or for general inquires please contact any of our team  members below:</div>
        <div class="box-userskype">
        	<div class="name_userskype"><span style="font-size:20px; font-weight:bold; text-transform:uppercase; color:#000;">John Marin</span><br/>
       	    <a style="font-size:14px; color:#666; text-decoration:none;" href="mailto: john@ezpay.com">john@ezpay.com</a><br />
(+506) 2228-9034<br />
<div class="account_userskype">johnezpay</div></div>
       	  <div class="linedotted"></div>
          <div class="picture_userskype"><img src="images/ezpay/pic-guy-skype.png" width="118" height="129" /></div>
            <div class="btn_skype_status"><a href="skype:johnezpay?call"><img src="http://mystatus.skype.com/bigclassic/johnezpay?<?php echo mt_rand(); ?>" style="border: none;" width="182" height="44" alt="My status" /></a></div>
        </div>
      <div class="box-userskype">
          <div class="name_userskype"><span style="font-size:20px; font-weight:bold; text-transform:uppercase; color:#000;">sandy Moore</span><br/>
            <a style="font-size:14px; color:#666; text-decoration:none;" href="mailto: john@ezpay.com">sandy@ezpay.com</a><br />
            (+506) 2228-9034<br />
            <div class="account_userskype">sandyezpay</div>
          </div>
          <div class="linedotted"></div>
          <div class="picture_userskype"><img src="images/ezpay/pic-girl-skype.png" width="118" height="129" /></div>
          <div class="btn_skype_status"><a href="skype:sandyezpay?call"><img src="http://mystatus.skype.com/bigclassic/sandyezpay?<?php echo mt_rand(); ?>" style="border: none;" width="182" height="44" alt="My status" /></a></div>
        </div>
        <div class="box-userskype">
          <div class="name_userskype"><span style="font-size:20px; font-weight:bold; text-transform:uppercase; color:#000;">Jessica siles</span><br/>
            <a style="font-size:14px; color:#666; text-decoration:none;" href="mailto: john@ezpay.com">jess@ezpay.com</a><br />
            (+506) 2228-9034<br />
            <div class="account_userskype">jessezpay</div>
          </div>
          <div class="linedotted"></div>
          <div class="picture_userskype"><img src="images/ezpay/pic-girl-skype.png" width="118" height="129" /></div>
          <div class="btn_skype_status"><a href="skype:jessezpay?call"><img src="http://mystatus.skype.com/bigclassic/jessezpay?<?php echo mt_rand(); ?>" style="border: none;" width="182" height="44" alt="My status" /></a></div>
        </div>
    </div>
    
  <div class="wrapper-choose">
  <div class="tit_whychooseus">Why choose us</div>
        <div class="arrow_chooseus"><img src="images/ezpay/arrow_chooseus.jpg" width="14" height="205" /></div>
        <div class="box_text_chooseus"><div class="tit_chooseus2">Proven experience</div><br />
          <br />
          <br />
          We've processed thousands of transactions for clients all over the world. And wev'e been doing so for several years. That means we know the ins and outs of the payment-processing world, and we can ensure the best possible service in the shortest amount of time.
        </div>
    <div class="box_text_chooseus">
          <div class="tit_chooseus2">Trusted network</div>
          <br />
      <br />
          <br />
      We've developed strong relationships with several trusted agencies around the world to build one of the most solid payment-processing networks.<br />
      We manage everything from our central office in San Jose, Costa Rica, ensuring a hassle-free transaction flow from end to end.
        </div>
    </div>
    
</div>

<div class="bottom">
	<div class="content_bottom">
   	  <div class="logo_bottom"><img src="images/ezpay/ezpay_white.png" width="146" height="55" /></div>
        <div class="text_right_bottom">
       	  <span class="13boldwhiteuppercase" style="color:#FFF; text-transform:uppercase; font-weight:bold;">Hours of service:</span>
        	<br />
        	<br />
          Monday - Saturday <br />
			<strong>10:00 a.m. EST – 9:00 p.m. EST</strong><br />

<br />
			Sunday <br />
      <strong>10:00 a.m. EST – 7:00 p.m. EST </strong></div>
    </div>
</div>
</body>
</html>
