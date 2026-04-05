<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<link rel="stylesheet" href="https://sportsbettingonline.ag/utilities/css/style.css?ck=6" type="text/css" media="screen" />

<meta http-equiv="Content-sType" content="text/html; charset=utf-8" />

<title><? echo $site_name ?></title>

<script>
var isMobile = /Mobile|Android|iP(hone|od|ad)|BlackBerry|IEMobile/i.test(navigator.userAgent);
</script>

<body onload="agent_autologin('<? echo $tbph_report_demo ?>')">

<?
if(!isset($site_id) or empty($site_id)){
   $site_id = 1195;
}

if(!isset($bs_url) or empty($bs_url)){
   $bs_url = "//betslip.fullhousepc.com";
}

if(!isset($action_url_web) or empty($action_url_web)){
   $action_url_web = "wager.fullhousepc.com";
}

$site_url_chat = substr($action_url_web,6);  
?>

<div class="wrapper1" id="desk_version" style="display:none;">

  <div class="wrapper-med">

    

    <div class="logo">    

       

    <a href="/"><img src="https://fullhousepc.com/utilities/imgs/logos/<? echo $site_logo ?>" width="290" height="73" border="0" /></a> 

    

    <br /> 
    
    <div><a style="color:#0236a6; cursor:pointer;" href="javascript:;" onclick="Javascript:window.open('https://livechat.vrbmarketing.com/content/live_chat.php?site=<? echo $site_url_chat ?>&amp;withaccount=1','livehelp','width=380,height=500,menubar=no,location=no,resizable=no,scrollbars=no,status=no');return(false);" title="LIVE HELP"><img src="https://sportsbettingonline.ag/utilities/imgs/live-chat3.png" width="84" height="78" /></a></div>   

    </div>    

    

	

	<div class="top_right">

	  <div class="top_info1">

		<div class="container_top_login_section">

		<?php /*?> <div class="ticker-envelope-top-login"><img src="https://sportsbettingonline.ag/utilities/imgs/ticker-envelope-top-login.png<? echo $cache_val ?>" width="25" height="21" border="0" /> </div><?php */?>
        <?php /*?> <div class="ticket-alert-system-text">TICKET ALERT SYSTEM</div><?php */?>
        <?php /*?>  <div class="login-below-alert-system-text">LOGIN BELOW TO SEND AN ALERT</div><?php */?>
        <?php /*?><div class="arrow-down-alert-system"><img src="https://sportsbettingonline.ag/utilities/imgs/arrow-down-top-login.png<? echo $cache_val ?>" width="10" height="5" border="0" /></div><?php */?>
        <?php /*?><div class="phone-top-alert-system" style="margin-left:-20px; font-size:20px; margin-bottom:-10px;">

          	
            Customer Service: 1-877-238-3665<br />
            Agents Customer Service: 1-866-968-7946<br />          
            Wagering:&nbsp;&nbsp;1-877-512-5844&nbsp;&nbsp;|&nbsp;&nbsp;1-877-623-8638

          </div><?php */?>

		  <div class="clear"></div>

		  <div class="container_top_login_box" align="right">

			<form name="LoginForm" action="javascript:void(0)" onsubmit="BackEndLogin(this); return false" id="betslip_login_form"> 

			  <table width="360" border="0" cellspacing="0" cellpadding="4">
                <tbody>
                  <tr>
                    <td align="right"><input tabindex="1" class="bk_top_login_field bk_top_login_field_username" name="username" type="text" id="username" placeholder="Username"></td>
                    <td align="right"><input tabindex="2" class="bk_top_login_field <? if(!$use_register){ ?>bk_top_login_field_password <? } ?>"  name="password" type="password" id="password" placeholder="Password"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><div class="text-center mt-2">
                        <div name="msj_error_lg" id="msj_error_lg" class="text-danger"></div>
                      </div></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td align="right"><table class="table-buttons-top" cellspacing="0" cellpadding="3">
                        <?php if($agent_options) { ?>
                        <tr>
                          <td><a href="javascript:;" tabindex="3" class="customer-login" onClick="sislogin();">CUSTOMER LOGIN</a></td>
                          <td align="right">
                          <!-- AGENT LOGIN now triggers SSO with current username/password -->
                          <a class="agent-login"
                             id="agent_login_btn"
                             tabindex="4"
                             href="javascript:;"
                             onclick="return agentLoginSSO();">
                            AGENT LOGIN
                          </a>
                        </td>
                          <td rowspan="2" valign="top" align="right">
						             <? if($use_register){ ?>
                          <a class="join-now" tabindex="8" href="https://signup.isppro.net/signup?domain=fullhousepc.com&amp;lang=en">JOIN NOW</a>
                          <? } ?>
                          </td>
                        </tr>
                        <tr>
                          <td><div style="margin-top:15px;">Backend Version:<br />
                              <select tabindex="5" name="sversion" id="sversion" class="select-backend-version">
                                <option value="cl" selected="selected">Classic</option>
                                <option value="bs">Betslip</option>
                              </select>
                            </div></td>
                          <td align="right"><div style="margin-top:10px;">
                            <a class="agent-billing" tabindex="6" href="javascript:;" onClick="open_billing();"> AGENT BILLING</a>
                            <div>
                            </a> 
                          </td>

                        </tr>
                      <? }  else { ?>
                       <tr>
                          <td><a href="javascript:;" tabindex="3" class="customer-login" onClick="sislogin();">CUSTOMER LOGIN</a></td>
                          <td align="right">
                          <!-- AGENT LOGIN now triggers SSO with current username/password -->
                          <a class="agent-login"
                             id="agent_login_btn"
                             tabindex="4"
                             href="javascript:;"
                             onclick="return agentLoginOLD();">
                            AGENT LOGIN
                          </a>
                        </td>
                          <td rowspan="2" valign="top" align="right">
                        
                        <a class="agent-billing" tabindex="6" href="javascript:;" onClick="open_billing();"> AGENT BILLING</a>
                        
                          </td>
                        </tr>
                        <tr>
                          <td><div style="margin-top:15px;">Backend Version:<br />
                              <select tabindex="5" name="sversion" id="sversion" class="select-backend-version">
                                <option value="cl" selected="selected">Classic</option>
                                <option value="bs">Betslip</option>
                              </select>
                            </div></td>
                          <td><div style="margin-top:15px;">Agent Version:<br />
                              <select tabindex="5" name="aversion" id="aversion" class="select-backend-version"  onchange="change_version(this)">
                                <option value="oldv" selected="selected">Old Version</option>
                                <option value="newv">New Version</option>
                              </select>
                            </div></td>

                        </tr> <?       


                      }?>
                        <tr>
                          <td colspan="3"></td>
                        </tr>
                      </table></td>
                  </tr>
                </tbody>
              </table>   

              <input type="hidden" name="BackEndUrl" value="<? echo $bs_url ?>">

			</form>
            
            <form name="LoginForm" id="classic_form" action="https://<? echo $action_url_web ?>/DefaultLogin.aspx" method="post">
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
			document.getElementById('msj_error_lg').innerHTML = 'Invalid username or password';
			document.getElementById('msj_error_lg').style.display = 'block';
			<? } ?>
			
			</script>

      <script>
/* ===== Agent SSO for desktop header =====
 * Uses the same username/password inputs in the existing form.
 * Builds auth as: BASE64( BASE64(agent) + "%=%" + BASE64(password) )
 * Redirects to:  https://adm.<current-host>/login?auth=<token>
 */

// Safe Base64 for UTF-8 credentials (avoid issues with accents/symbols)
function safeBtoa(str){ return btoa(unescape(encodeURIComponent(str))); }

// BASE64( BASE64(agent) + "%=%" + BASE64(password) )
function buildAgentAuth(agent, password){
  const a = safeBtoa(agent);
  const p = safeBtoa(password);
  return btoa(a + '%=%' + p);
}

// Resolve https://adm.<current-host> (strip www., keep current scheme)
function resolveAdmOrigin(){
  var scheme = window.location.protocol;                 // e.g., "https:"
  var host   = window.location.hostname.toLowerCase();   // e.g., "mysite.com"
  host = host.replace(/^www\./,'');
  if (host.indexOf('adm.') === 0) return scheme + '//' + host;
  return scheme + '//adm.' + host;
}

// Show inline error in the same div the form already uses
function showInlineError(msg){
  var el = document.getElementById('msj_error_lg');
  if (el){ el.textContent = msg; el.style.display = 'block'; }
}

// Main action: called by the AGENT LOGIN button
function agentLoginSSO(){
  try{
    var userEl = document.getElementById('username');
    var passEl = document.getElementById('password');
    var user = (userEl && userEl.value || '').trim();
    var pass =  passEl && passEl.value || '';

    if(!user || !pass){
      showInlineError('Please type your Agent username and password');
      return false;
    }

    var auth      = buildAgentAuth(user, pass);
    var admOrigin = resolveAdmOrigin();
    var url       = admOrigin + '/login?auth=' + encodeURIComponent(auth);

    // Redirect in same tab
    window.location.href = url;
    return false;
  }catch(e){
    showInlineError('Unexpected error. Please try again.');
    return false;
  }
}

// Optional: allow ENTER on password to trigger Customer Login (keeps current UX)
(function(){
  var pwd = document.getElementById('password');
  if (!pwd) return;
  pwd.addEventListener('keydown', function(ev){
    if (ev.key === 'Enter' && typeof sislogin === 'function'){ ev.preventDefault(); sislogin(); }
  });
})();

function agent_autologin(tbph_report_demo){
	
	if(tbph_report_demo){		
		document.getElementById("username").value = "betowitest";
		document.getElementById("password").value = "test2016";
        agentLoginSSO();		 			
	}
}



  function open_billing(){
     var user = prompt("Agent:");
     if (user === null) return; // 
     var pass = prompt("Enter password:");
     if (pass === null) return; // 
     window.location.href = "https://vrbmarketing.com/ck/pph_external_balance_detail_report.php?acc="+user;
 }


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


 // Tryng login directly
 function getLegacyCreds() {
  var u = (document.getElementById('username')?.value || '').trim();
  var p =  document.getElementById('password')?.value || '';
  return { u, p };
}

// Create and submit a throwaway form to another origin
function postTo(url, fields, target) {
  var f = document.createElement('form');
  f.method = 'POST';
  f.action = url;
  if (target) f.target = target; // e.g., _self or _blank
  for (var name in fields) {
    if (!fields.hasOwnProperty(name)) continue;
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = fields[name];
    f.appendChild(input);
  }
  document.body.appendChild(f);
  f.submit();
  setTimeout(function(){ try{ document.body.removeChild(f); }catch(_){} }, 10000);
}

// Try multiple common field names (ASP.NET changes control IDs)
function agentLoginOLD() {
  var creds = getLegacyCreds();
  if (!creds.u || !creds.p) {
    var el = document.getElementById('msj_error_lg');
    if (el) { el.textContent = 'Please type your Agent username and password'; el.style.display='block'; }
    return false;
  }

  // Old site base
  var base = 'https://agents.fullhousepc.com/AgentSiteV2';

  // Probable login endpoint (en la captura el form apunta a "processlogin.aspx")
  var action = base + '/processlogin.aspx';

  // Candidate field maps (enviamos varias llaves con el mismo valor; el server ignorará las que no use)
  var data = {
    // username candidates
    'user': creds.u,
    'username': creds.u,
    'account': creds.u,
    'acc': creds.u,
    'accField': creds.u,
    'txtUser': creds.u,
    'ctl00$MainContent$txtUser': creds.u,

    // password candidates
    'pass': creds.p,
    'password': creds.p,
    'pwd': creds.p,
    'passField': creds.p,
    'txtPass': creds.p,
    'ctl00$MainContent$txtPass': creds.p,

    // If server expects image button coordinates (name guessed from screenshot)
    'CrlLoginSct100.x': 40,
    'CrlLoginSct100.y': 10
  };

  try {
    // Open in same tab so cookies queden en el dominio agents.*
    postTo(action, data, '_self');
  } catch (e) {
    // Fallback: abre el login viejo (manual)
    window.open(base + '/', '_blank');
  }
  return false;
}

</script>


		  </div>

		</div>

	  </div>

	</div>

  </div>

  