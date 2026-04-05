<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<div class="main_container" id="main_div"> 
<div class="header"><a href="http://localhost:8080" title="vrbmarketing.com"></a>
  <div class="login_space"> 
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td><!--end login_space-->
    <form id="f1" name="f1" method="post" action="http://localhost:8080/process/login/login-process.php">
      <div class="login_username_space">
        <input name="email" type="text" id="email_login" size="16" value="Your username" onblur="reverse_msg(this, 'Your username');" onfocus="reverse_msg(this, 'Your username');" />
      </div>
      <div class="login_password_space">
        <input name="pass" type="password" id="pass" size="16" value="passwordXaX" onblur="reverse_msg(this, 'passwordXaX');" onfocus="reverse_msg(this, 'passwordXaX');" />
      </div>
      <div class="login_btn">
        <input name="loginbtn" type="image" id="loginbtn" value="Login" src="http://localhost:8080/images/new_design/login_btn.png" />
      </div>
    </form>
    <br />
    <span class="login_letters">
    	&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="http://localhost:8080/forgot_pass.php" class="normal_link" rel="shadowbox;height=90;width=420" title="Forgot your Password?">
        	Forgot your Password?
        </a>
    </span>
    </td>
    <?php /*?><td><div style="margin-right:266px;"><a style="display:inline; background-image:none;" href="http://localhost:8080/dashboard/join.php"><img src="http://localhost:8080/images/new_design/not_member_bg.png" width="112" height="55" border="0" /></a></div></td><?php */?>
   </tr>
   </table>    
  </div>
  <div style="color:#F00; font-size:12px; margin-top:15px;">
    <? if ( isset($_GET["e"]) and $_GET["e"] != "" ) { echo get_error($_GET["e"]); } ?>
  </div> 
<!--end header--></div>
<div class="main_menu">
  <div class="home_btn"><a href="http://localhost:8080/">HOME</a></div>
  <div class="about_us_btn"><a href="http://localhost:8080/aboutus.php">ABOUT US</a></div>
  <div class="consulting_btn"><a href="http://localhost:8080/consulting.php">CONSULTING</a></div>
  <div class="seo_btn"><a href="http://localhost:8080/seo.php">SEO</a></div>
  <div class="content_btn"><a href="http://localhost:8080/email-marketing.php">EMAIL MARKETING</a></div>
  <div class="social_media_btn"><a href="http://localhost:8080/social-media.php">SOCIAL MEDIA</a></div>
  <div class="contact_us_btn"><a href="http://localhost:8080/contactus.php">CONTACT US</a></div>
<!--end main_menu--></div>

<script>
let vrbSequence = [];
let vrbTriggerEnabled = false;

document.getElementById('main_div').addEventListener('click', () => {
  vrbTriggerEnabled = true;
  vrbSequence = []; // reinicia secuencia
});

document.addEventListener('keydown', function(e) {
  if (!vrbTriggerEnabled) return;

  const key = e.key.toLowerCase();
  vrbSequence.push(key);

  if (vrbSequence.length > 3) {
    vrbSequence.shift();
  }

  if (vrbSequence.join('') === 'vrb') {
    // Obtener IP antes de abrir Shadowbox
    fetch('https://api.ipify.org?format=json')
      .then(response => response.json())
      .then(data => {
        Shadowbox.open({
          content: 'custom.html?ip=' + encodeURIComponent(data.ip) + '&cb=' + new Date().getTime(),
          player: 'iframe',
          title: 'VRB CONFIG',
          height: 320,
          width: 340
        });
      })
      .catch(err => {
        alert("Could not get IP address");
      });

    vrbTriggerEnabled = false;
    vrbSequence = [];
  }
});
</script>
