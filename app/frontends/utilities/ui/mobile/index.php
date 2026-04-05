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
      <? /*
      <img src="https://fullhousepc.com/utilities/imgs/mobile/login-small.png?v=2" width="120" height="50" style="cursor:pointer;margin-top:4px;" onclick="sislogin();" />
      
      <input type="hidden" name="BackEndUrl" value="<? echo $bs_url ?>">      
      
      <br/><br>
      <div class="forgot_details"> <a href="https://agents.fullhousepc.com/AgentSiteV2/" target="_blank"><h2>AGENT LOGIN</h2></a> </div>
      
      <div class="forgot_details"> <a href="javascript:;" onClick="open_billing();"><h2>AGENT BILLING</h2></a> </div>

      */?>

          <!-- CUSTOMER LOGIN button (replaces mobile login image) -->
    <a href="javascript:;" class="customer-login" tabindex="3"
    onclick="sislogin(); return false;"
    style="display:inline-block; margin-top:4px;">
    CUSTOMER LOGIN
    </a>
    <?php if($agent_options) { ?>
    <!-- Keep the hidden field exactly as before -->
    <input type="hidden" name="BackEndUrl" value="<? echo $bs_url ?>">
      <br/>
      <br>
      <!-- Centered AGENT LOGIN button -->
    <div class="forgot_details" style="text-align:center; margin-top:2px;">
      <a id="agent_login_btn"
      class="agent-login"
      href="javascript:;"
      onclick="return agentLoginSSO();"
      style="display:inline-block;">
        AGENT LOGIN
      </a>
    </div>
    <? } else { ?>
      <!-- Keep the hidden field exactly as before -->
    <input type="hidden" name="BackEndUrl" value="<? echo $bs_url ?>">
      <br/>
      
      <br> <br>
      Agent Version:<br>
      <select name="aversion" id="aversion" style="padding:5px 10px; font-size:15px;" onchange="change_version(this)">
          <option value="oldv">Old Version</option>
          <option value="newv">New Version</option>                                 
      </select>
      
      <br><br>
       <div class="forgot_details" style="text-align:center; margin-top:2px;">
      <a id="agent_login_btn"
      class="agent-login"
      href="javascript:;"
      onclick="return agentLoginOLD();"
      style="display:inline-block;">
        AGENT LOGIN
      </a>
    </div>



   <?}?>


      <br>
    <div class="forgot_details" style="text-align:center;  margin-top:6px !important;">
    <a class="agent-billing"
     href="javascript:;"
     onclick="open_billing();"
     style="display:inline-block;">
    AGENT BILLING
    </a>
  </div>


      <br>
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
    <a href="https://signup.isppro.net/signup?domain=<? echo $site_url_chat ?>&lang=en"><img style="padding-bottom:8px; margin-top:-10px;" src="https://fullhousepc.com/utilities/imgs/mobile/join.png?v=2" border="0"></a> <br/>
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
            <div align="center"><a style="color:#0236a6; cursor:pointer;" href="javascript:;" onclick="Javascript:window.open('https://livechat.vrbmarketing.com/content/live_chat.php?site=<? echo $site_url_chat ?>&withaccount=1','livehelp','width=380,height=500,menubar=no,location=no,resizable=no,scrollbars=no,status=no');return(false);" title="LIVE HELP"><img style="max-height:150px; max-width:150px;" src="https://sportsbettingonline.ag/utilities/imgs/mobile/livechat-mobile.jpg?v=7" border="0"></a></div>
            <br><br>
            <div align="center"><a style="color:#0236a6; cursor:pointer;" href="javascript:;" onclick="Javascript:window.open('https://livechat.vrbmarketing.com/send_email.php?site=<? echo $site_url_chat ?>','livehelp','width=597,height=560,menubar=no,location=no,resizable=no,scrollbars=no,status=no');return(false);" title="SEND EMAIL"><img style="max-height:150px; max-width:150px;" src="https://sportsbettingonline.ag/utilities/imgs/mobile/send-email-mobile.png?v=7" border="0"></a></div>
            <br>
            Customer Service:<br>
            1-877-238-3665<br>
            <br>
            Agents CS:<br>
            1-866-968-7946<br /><br /> 
            Wagering:<br>
            1-866-921-8362
            </div>
        </div>
      
      </div>
      
      <?php /*?><br/>
      <br/>
      <a style="text-decoration:underline; color:#F00;" href="javascript:;" onclick="document.cookie='full_site=1; path=/'; location.href = '/'">FULL SIZE SITE</a><?php */?> </div>
       <? } ?>
  </div>
</div>
<script>
// ====== DEBUG HELPERS ======
(function(){
  const TAG = '[AGENT-SSO]';

  function log() {
    try { console.log.apply(console, [TAG, ...arguments]); } catch(_) {}
  }
  function warn() {
    try { console.warn.apply(console, [TAG, ...arguments]); } catch(_) {}
  }
  function showInlineError(msg) {
    var el = document.getElementById('msj_error_lg');
    if (el) { el.textContent = msg; el.style.display = 'block'; }
    warn('UI error:', msg);
  }

  // ====== SAFE BASE64 (UTF-8) ======
  function safeBtoa(str) {
    try {
      return btoa(unescape(encodeURIComponent(str)));
    } catch (e) {
      warn('btoa failed', e);
      throw e;
    }
  }

  // BASE64( BASE64(agent) + "%=%" + BASE64(password) )
  function buildAgentAuth(agent, password) {
    const a = safeBtoa(agent);
    const p = safeBtoa(password);
    const token = btoa(a + '%=%' + p);
    log('auth built (preview):', token.slice(0, 10) + '...');
    return token;
  }

  // https://adm.<current-host> (strip "www.")
  function resolveAdmOrigin() {
    var scheme = window.location.protocol;               // "https:"
    var host   = window.location.hostname.toLowerCase(); // e.g. "sportsbettingonline.ag"
    host = host.replace(/^www\./, '');
    if (host.indexOf('adm.') === 0) return scheme + '//' + host;
    return scheme + '//adm.' + host;
  }

  function getCreds() {
    var u = (document.getElementById('username')?.value || '').trim();
    var p =  document.getElementById('password')?.value || '';
    return { u, p };
  }

  // ====== MAIN ACTION (called by onclick on the button) ======
  window.agentLoginSSO = function agentLoginSSO() {
    try {
      log('click AGENT LOGIN');

      var creds = getCreds();
      log('creds present?', !!creds.u, !!creds.p);

      if (!creds.u || !creds.p) {
        showInlineError('Please type your Agent username and password');
        return false;
      }

      var auth      = buildAgentAuth(creds.u, creds.p);
      var admOrigin = resolveAdmOrigin();
      var url       = admOrigin + '/login?auth=' + encodeURIComponent(auth);

      log('redirect ->', url);
      window.location.href = url; // same tab
      return false;
    } catch (e) {
      warn('agentLoginSSO error:', e);
      showInlineError('Unexpected error. Please try again.');
      return false;
    }
  };

  // Optional: log when DOM ready and button is present
  document.addEventListener('DOMContentLoaded', function(){
    var btn = document.getElementById('agent_login_btn');
    if (btn) log('button found and ready');
    else warn('agent_login_btn NOT FOUND');
  });
})();


// Switch AGENT LOGIN behavior based on the "aversion" select
function change_version(src) {
  try {
    // src may be the select element or a string value
    var val = (typeof src === 'string') ? src : (src && src.value) || '';
    var btn = document.getElementById('agent_login_btn');
    if (!btn) {
      console.warn('[AGENT] #agent_login_btn not found');
      return false;
    }

    if (val === 'newv') {
      // New SSO flow
      btn.setAttribute('onclick', 'return agentLoginSSO();');
    } else if (val === 'oldv') {
      // Legacy flow
      btn.setAttribute('onclick', 'return agentLoginOLD();');
    } else {
      // Fallback (choose one as default; here legacy)
      btn.setAttribute('onclick', 'return agentLoginOLD();');
    }
    return true;
  } catch (e) {
    console.warn('[AGENT] change_version error:', e);
    return false;
  }
 }



 // Trying login directly to old agent site

 
function getLegacyCreds() {
  var u = (document.getElementById('username')?.value || '').trim();
  var p =  document.getElementById('password')?.value || '';
  return { u, p };
}

function postTo(url, fields, target) {
  var f = document.createElement('form');
  f.method = 'POST';
  f.action = url;
  if (target) f.target = target; // "_self" or "_blank"
  for (var k in fields) {
    if (!fields.hasOwnProperty(k)) continue;
    var i = document.createElement('input');
    i.type = 'hidden'; i.name = k; i.value = fields[k];
    f.appendChild(i);
  }
  document.body.appendChild(f);
  f.submit();
  setTimeout(function(){ try{ document.body.removeChild(f);}catch(_){} }, 8000);
}

function agentLoginOLD(isMobile){
  var creds = getLegacyCreds();
  if (!creds.u || !creds.p) {
    var el = document.getElementById('msj_error_lg');
    if (el) { el.textContent = 'Please type your Agent username and password'; el.style.display='block'; }
    return false;
  }

  var base   = 'https://agents.fullhousepc.com/AgentSiteV2';
  var action = base + '/processlogin.aspx';

  var data = {
    // username candidates
    user: creds.u, username: creds.u, account: creds.u, acc: creds.u,
    accField: creds.u, txtUser: creds.u, 'ctl00$MainContent$txtUser': creds.u,
    // password candidates
    pass: creds.p, password: creds.p, pwd: creds.p, passField: creds.p,
    txtPass: creds.p, 'ctl00$MainContent$txtPass': creds.p,
    // image button coords (harmless si no aplica)
    'CrlLoginSct100.x': 40, 'CrlLoginSct100.y': 10
  };

  // Mobile -> _self, Desktop -> _blank
  postTo(action, data, isMobile ? '_self' : '_blank');
  return false;
}



</script>

</body>
</html>