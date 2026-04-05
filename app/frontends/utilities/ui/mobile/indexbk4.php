<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><? echo $site_name ?></title>
<link rel="stylesheet" href="https://sportsbettingonline.ag/utilities/css/mobile.css?v=6" type="text/css" media="screen"/>
</head>
<body>
<style>
.wrapper-med{
	width:100% !important;
}
</style>
<?
if(!isset($site_id) or empty($site_id)){
   $site_id = 1195;
}

if(!isset($bs_url) or empty($bs_url)){
   $bs_url = "//betslip.fullhousepc.com";
}

if(!isset($action_url_mobile) or empty($action_url_mobile)){
   $action_url_mobile = "mobile.fullhousepc.com";
}

$site_url_chat = substr($action_url_mobile,7);  
?>

<div class="main_wrapper">
<?php /*?>  <div class="top_container_header">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td><div class="topnav" id="myTopnav"> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/">Home</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/promotions.php">Casino Promotions</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/contact.php">Contact Us</a> <a style="color:#FFFFFF !important;" href="https://www.commissionpartners.com/">Affiliate Program</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/aboutus.php">About us</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/faq.php">FAQ</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/terms.php">Terms</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/privacy-policy.php">Privacy Policy</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/cashier-payment-methods.php">Cashier</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/limits.php">Sportsbook Bet Types Limits</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/tracks-offered.php">Racebook Tracks Offered - Limits</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/racebook-limits.php">Racebook Bet Types Limits</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/casino-games-limits.php">Casino Limits</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/mission-statement.php">Mission Statement</a> <a style="color:#FFFFFF !important;" href="http://press-releases.sbo.ag/">Press Releases</a> <a style="color:#FFFFFF !important;" href="http://sports-news.sbo.ag/">Sports News</a> <a style="color:#FFFFFF !important;" href="http://infographics.sbo.ag/">Info Graphics</a> <a style="color:#FFFFFF !important;" href="https://www.betowi.com/m/sports-leagues.php">Sports - Leagues</a> <a style="color:#FFFFFF !important;" id="icon" href="javascript:void(0);" class="icon" onclick="f_menu();">&#9776;</a> </div></td>
        <td><div id="logo_wrapper"> <a href="https://www.betowi.com.com/m/"><img src="images/mobile-logo.png"/></a> </div></td>
      </tr>
    </table>
  </div><?php */?>
  <div class="login_wrapper"> <br/>
  
  	<div align="center"><a href="/"><img src="https://fullhousepc.com/utilities/imgs/logos/<? echo $site_logo ?>?v=2" width="290" height="73" border="0" /></a><br><br></div>
  
  
    <div class="login_top_title">Welcome Back!</div>
    <br/>
    <form name="LoginForm" action="javascript:void(0)" onsubmit="BackEndLogin(this); return false" id="betslip_login_form"> 
      <input name="username" class="login_input" type="text" id="username" placeholder="Username"/>
      <br/>
      <input name="password" class="login_input" type="password" id="password" placeholder="Password"/>
      <div class="text-center mt-2" align="center">
           <div name="msj_error_lg" id="msj_error_lg" class="text-danger" style="color:red; font-size:13px;"></div>
      </div>
      
      Backend Version:<br>
      <select name="sversion" id="sversion" style="padding:5px 10px; font-size:15px;">
          <option value="cl">Classic</option>
          <option value="bs">Betslip</option>                                 
      </select>
      
      <br><br>
      
      <img src="https://fullhousepc.com/utilities/imgs/mobile/login-small.png?v=2" width="120" height="50" style="cursor:pointer;margin-top:4px;" onclick="sislogin();" />
      
      <input type="hidden" name="BackEndUrl" value="<? echo $bs_url ?>">      
      
      <br/><br>
      <div class="forgot_details"> <a href="https://agents.fullhousepc.com/AgentSiteV2/" target="_blank"><h2>AGENT LOGIN</h2></a> </div>
      
      <div class="forgot_details"> <a href="javascript:;" onClick="open_billing();"><h2>AGENT BILLING</h2></a> </div>
	  
	  <div class="forgot_details"> <a href="?page=terms"><h2>TERMS & CONDITIONS</h2></a></div>
	  
	  
      <script type="text/javascript">
		  function open_billing(){
			   var user = prompt("Agent:");
			   if (user === null) return; // 
			   var pass = prompt("Enter password:");
			   if (pass === null) return; // 
			   window.location.href = "https://vrbmarketing.com/ck/pph_external_balance_detail_report.php?acc="+user;
		  }
	  </script>
    
    </form>
    
     <form name="LoginForm" id="classic_form" action="https://<? echo $action_url_mobile ?>/DefaultLogin.aspx"  method="post">
        <input type="hidden" name="siteID" id="siteID" value="<? echo $site_id ?>">
        <input type="hidden" name="errorURL" value="<? echo $site_url ?>?le=1">
        <input type="hidden" name="account" id="classic_account">
        <input type="hidden" name="password" id="classic_password">
    </form>
    
    <script type="text/javascript">
    function sislogin(){
        
        var version = document.getElementById('sversion').value;
        
        if(version == "bs"){
            BackEndLogin(document.getElementById('betslip_login_form'));
        }else{
            document.getElementById('classic_account').value = document.getElementById('username').value;
            document.getElementById('classic_password').value = document.getElementById('password').value;
            document.getElementById('classic_form').submit();
        }
        
    }
    
    <? if($_GET["le"]){ ?>
	alert("Invalid username or password");
    <? } ?>
    
    </script>
    
    
    <br/>
    <? if($use_register){ ?>
    <div class="join_top_title">IF YOU'RE NOT A MEMBER YET</div>
    <br/>
    <br/>
    <a href="https://signup.isppro.net/signup?domain=fullhousepc.com&lang=en"><img style="padding-bottom:8px; margin-top:-10px;" src="https://fullhousepc.com/utilities/imgs/mobile/join.png?v=2" border="0"></a> <br/>
    <? } ?>
    <? if ($page == "terms.php") { ?>
    <div align="left">
      <? include($_SERVER['DOCUMENT_ROOT']."/frontends/utilities/ui/$page");  ?>
    </div>
    <? }else{ ?>
    <div align="center" style="padding-bottom:10px;"> <br/>
      <br/>
      <div class="headlines" align="center"> <img src="https://sportsbettingonline.ag/utilities/imgs/headlines/headline_mobile.jpg?v=<? echo mt_rand(); ?>" border="0"> 
	  <br>
	  
	   <br>
        <div class="center-box">
          <div class="phone-top-alert-system">
            <div align="center"><a style="color:#0236a6; cursor:pointer;" href="javascript:;" onclick="Javascript:window.open('https://livechat.vrbmarketing.com/content/live_chat.php?site=<? echo $site_url_chat ?>&withaccount=1','livehelp','width=380,height=500,menubar=no,location=no,resizable=no,scrollbars=no,status=no');return(false);" title="LIVE HELP"><img style="max-height:150px; max-width:150px;" src="https://sportsbettingonline.ag/utilities/imgs/mobile/livechat-mobile.jpg?v=4" border="0"></a></div>
            <br>
            Customer Service:<br>
            1-877-238-3665<br>
            <br>
            Agents CS:<br>
            1-866-968-7946<br /><br /> 
            Wagering:<br>
            1-877-512-5844<br>
            1-877-623-8638 </div>
        </div>
	  
	  </div>
	  
      <?php /*?><br/>
      <br/>
      <a style="text-decoration:underline; color:#F00;" href="javascript:;" onclick="document.cookie='full_site=1; path=/'; location.href = '/'">FULL SIZE SITE</a><?php */?> </div>
       <? } ?>
  </div>
</div>
</body>
</html>