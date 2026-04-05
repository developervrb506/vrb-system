<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<link rel="stylesheet" href="https://fullhousepc.com/utilities/css/style.css?ck=2" type="text/css" media="screen" />

<meta http-equiv="Content-sType" content="text/html; charset=utf-8" />

<title><? echo $site_name ?></title>

<script>
var isMobile = /Mobile|Android|iP(hone|od|ad)|BlackBerry|IEMobile/i.test(navigator.userAgent);
</script>

<body>

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
?>

<div class="wrapper1" id="desk_version" style="display:none;">

  <div class="wrapper-med">

    

    <div class="logo">    

       

    <a href="/"><img src="https://fullhousepc.com/utilities/imgs/logos/<? echo $site_logo ?>" width="290" height="73" border="0" /></a> 

    

    <br />    

    </div>    

    

	

	<div class="top_right">

	  <div class="top_info1">

		<div class="container_top_login_section">

		  <div class="ticker-envelope-top-login"><img src="https://fullhousepc.com/utilities/imgs/ticker-envelope-top-login.png<? echo $cache_val ?>" width="25" height="21" border="0" /> </div> 

		  <div class="ticket-alert-system-text">TICKET ALERT SYSTEM</div>

		  <div class="login-below-alert-system-text">LOGIN BELOW TO SEND AN ALERT</div>

		  <div class="arrow-down-alert-system"><img src="https://fullhousepc.com/utilities/imgs/arrow-down-top-login.png<? echo $cache_val ?>" width="10" height="5" border="0" /></div>

		  <div class="phone-top-alert-system" style="margin-left:-20px; font-size:20px; margin-bottom:-10px;">

          	Customer Service: 1-877-238-3665<br />
            Agents Customer Service: 1-866-968-7946<br />          
            Wagering:&nbsp;&nbsp;1-877-512-5844&nbsp;&nbsp;|&nbsp;&nbsp;1-877-623-8638

          </div>

		  <div class="clear"></div>

		  <div class="container_top_login_box">

			<form name="LoginForm" action="javascript:void(0)" onsubmit="BackEndLogin(this); return false" id="betslip_login_form"> 

			  <table width="360" border="0" cellspacing="0" cellpadding="4">

				<tr>

				  <td><input class="bk_top_login_field" name="username" type="text" id="username" placeholder="Username" /></td>

				  <td align="right">

                  <input class="bk_top_login_field" name="password" type="password" id="password" placeholder="Password" />

                  

                  </td>

				</tr>

                <tr>

				  <td colspan="2">

                  	<div class="text-center mt-2">

                        <div name="msj_error_lg" id="msj_error_lg" class="text-danger" style="color:red; font-size:13px;"></div>

                    </div>

                  </td>

				</tr> 



				

				<tr>

				  <td colspan="2" align="left"><div class="join_promo_top_container">
					 <div class="join_promo_top_container">
                          <div class="join_button_top">
                          	<a href="https://agents.fullhousepc.com/AgentSiteV2/" target="_blank">
                            	<img src="https://fullhousepc.com/utilities/imgs/agent_login_btnS.png" border="0" width="109" height="25" />
                            </a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="javascript:;" onclick="open_billing();">
                            	
                                <img src="https://fullhousepc.com/utilities/imgs/billing.png" border="0" width="109" height="25" />
                            </a>
                            <? if($use_register){ ?>
                            &nbsp;&nbsp;&nbsp;
                            <a href="https://signup.isppro.net/signup?domain=fullhousepc.com&lang=en">
                            	<img src="https://fullhousepc.com/utilities/imgs/join_btnS.png" border="0" width="109" height="25" />
                            </a>
                            <? } ?>
                            
                            <script type="text/javascript">
                            	function open_billing(){
									 var user = prompt("Agent:");
									 if (user === null) return; // 
									 var pass = prompt("Enter password:");
									 if (pass === null) return; // 
									 window.location.href = "https://vrbmarketing.com/ck/pph_external_balance_detail_report.php?acc="+user;
								}
                            </script>
                          </div>
					  </div>
				  </td>

				</tr>

                

                

				<tr>

				  <td><div class="forgot-login-top-link"></div>

						  

				  <br />

				  

				  

				  </td>

				  <td align="right">
                  	<div class="login-top-button">
                    	
                        <div style=" float:left;margin-top: 4px;">
                            Backend Version:&nbsp;
                        	<select name="sversion" id="sversion">
                                <option value="cl">Classic</option>
                                <option value="bs">Betslip</option>                                 
                            </select>
                        </div>
                        
                        <img src="https://fullhousepc.com/utilities/imgs/login-button-top-pph.png" width="109" height="25" style="cursor:pointer;" onclick="sislogin();" />
                        <br /><br />
                    </div>
                  </td>
				  

				</tr>

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

		  </div>

		</div>

	  </div>

	</div>

  </div>

  