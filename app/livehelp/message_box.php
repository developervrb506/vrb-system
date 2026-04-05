<?php
include(ROOT_PATH . "/ck/process/functions.php");

$web     = strtolower($_GET['agsite']);
$web     = explode(" ",$web);
$web     = $web[0];
$mobile  = $_GET['mobile'];
$ip_chat_agents = $_GET['ip_chat_agents'];
$account = asp_encryption($ip_chat_agents);
$account = two_way_enc($account);

header("Location: http://vrbmarketing.com/tickets/list.php?cat=agents&web=".$web."&wpx=".$account."&mobile=".$mobile);
exit;

/*	session_start() ;
	$action = $deptid = $l = $x = $requestid = $success = $question = $sid = "" ;
	if ( isset( $_POST['l'] ) ) { $l = $_POST['l'] ; }
	if ( isset( $_GET['l'] ) ) { $l = $_GET['l'] ; }
	if ( isset( $_POST['x'] ) ) { $x = $_POST['x'] ; }
	if ( isset( $_GET['x'] ) ) { $x = $_GET['x'] ; }
	if ( isset( $_POST['action'] ) ) { $action = $_POST['action'] ; }
	if ( isset( $_GET['action'] ) ) { $action = $_GET['action'] ; }
	if ( isset( $_GET['deptid'] ) ) { $deptid = $_GET['deptid'] ; }
	if ( isset( $_POST['deptid'] ) ) { $deptid = $_POST['deptid'] ; }
	if ( isset( $_GET['requestid'] ) ) { $requestid = $_GET['requestid'] ; }
	if ( isset( $_GET['sid'] ) ) { $sid = $_GET['sid'] ; }
	
	if ( isset( $_GET['ins'] ) ) { $ins = $_GET['ins'] ; }
	
	if ( isset( $_GET['agsite_desc'] ) ) { $agsite_desc = $_GET['agsite_desc'] ; }			
	if ( isset( $_POST['agsite_desc'] ) ) { $agsite_desc = $_POST['agsite_desc'] ; }
	
	if ( isset( $_GET['mobile'] ) ) { $mobile = $_GET['mobile'] ; }			
	if ( isset( $_POST['mobile'] ) ) { $mobile = $_POST['mobile'] ; }
				
	include_once("./livehelp/chat_logos_container.php") ;	

	include_once( "./API/Util_Dir.php" ) ;
	if ( !Util_DIR_CheckDir( ".", $l ) )
	{
		print "<font color=\"#FF0000\">[Configuration Error: config files not found!] Exiting...</font>" ;
		exit ;
	}
	include_once("./web/conf-init.php") ;
	$DOCUMENT_ROOT = realpath( preg_replace( "/http:/", "", $DOCUMENT_ROOT ) ) ;
	include_once("./web/$l/$l-conf-init.php") ;
	include_once("$DOCUMENT_ROOT/web/VERSION_KEEP.php") ;
	include_once("$DOCUMENT_ROOT/system.php") ;
	include_once("$DOCUMENT_ROOT/lang_packs/$LANG_PACK.php") ;
	include_once("$DOCUMENT_ROOT/API/sql.php" ) ;
	include_once("$DOCUMENT_ROOT/API/Users/get.php") ;
	include_once("$DOCUMENT_ROOT/API/ASP/get.php") ;
	include_once("$DOCUMENT_ROOT/API/Chat/get.php") ;
	include_once("$DOCUMENT_ROOT/API/Chat/remove.php") ;

	$THEME = ( isset( $_GET['theme'] ) && $_GET['theme'] ) ? $_GET['theme'] : $THEME ;
	

	$aspinfo = AdminASP_get_UserInfo( $dbh, $x ) ;
	$deptinfo = AdminUsers_get_DeptInfo( $dbh, $deptid, $x ) ;	

	// conditions

	if ( $action == "submit" )
	{
		if ( $deptinfo['email'] )
		{
			$cookie_lifespan = time() + 60*60*24*180 ;
			setcookie( "COOKIE_PHPLIVE_VEMAIL", stripslashes( $_POST['email'] ), $cookie_lifespan ) ;

			if ( isset($_POST['phone'] ) and $_POST['phone'] != "" and !is_null($_POST['phone'])){
				$message = "Live Support Message Delivery:\r\n-------------------------------------------\r\n\r\n" . stripslashes( $_POST['message'] )."\r\n\r\n"."Phone Number: ".$_POST['phone'] ;
			}
			else {
				$message = "Live Support Message Delivery:\r\n-------------------------------------------\r\n\r\n" . stripslashes( $_POST['message'] )."\r\n\r\n";
			}		
			
			$subject = "(LIVE HELP EMAIL) " .$agsite." ". stripslashes( $_POST['subject'] ) ;
			if ( mail( $deptinfo['email'], $subject, $message, "From: $_POST[name] <$_POST[email]>") )
			$success = 1 ;			
		
		}
	}
	else if ( $action == "exit" )
	{
		ServiceChat_remove_ChatRequest( $dbh, $requestid ) ;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?
if (isset($mobile) and $mobile == 1) {
include_once("./livehelp/chat_top_header_mobile.php") ;
}
?>
<title><?php echo $LANG['TITLE_LEAVEMESSAGE'] ?></title>
<script type="text/javascript" language="JavaScript1.2" src="js/chat_fn.js"></script>
<script type="text/javascript" language="JavaScript1.2">
<!--
	function init(){
		// Check for browser support
		if( !document.createElement && !document.createElementNS ) self.location.href = "http://www.osicodes.com/demos/phplive/browser.php";
	}

	window.onload = init;

	function do_submit()
	{
		if ( ( document.form.name.value == "" ) || ( document.form.email.value == "" )
			|| ( document.form.subject.value == "" ) || ( document.form.message.value == "" ) )
			//alert( "<?php echo $LANG['MESSAGE_BOX_JS_A_ALLFIELDSSUP'] ?>" ) ;
			alert( "Your name, email address, subject and message are required fields." ) ;
		else if ( document.form.email.value.indexOf("@") == -1 )
			alert( "<?php echo $LANG['MESSAGE_BOX_JS_A_INVALIDEMAIL'] ?>" ) ;
		else
			document.form.submit() ;
	}

	function opennewwin(url)
	{
		window.open(url, "newwin", "scrollbars=yes,menubar=yes,resizable=1,location=yes,toolbar=yes") ;
	}

//-->
</script>
<link href="css/layout.css?<? echo mt_rand(); ?>" rel="stylesheet" type="text/css" />
<link href="themes/<?php echo $THEME ?>/style.css?<? echo mt_rand(); ?>" rel="stylesheet" type="text/css" />
<?php if ($agsite_desc == 'ezpay') { ?>
<link href="http://localhost:8080/livehelp/css/ezpay-chat.css" rel="stylesheet" type="text/css" />
<?php } else { ?>
<link href="http://www.sportsbettingonline.ag/utilities/css/style.css?<? echo mt_rand(); ?>" rel="stylesheet" type="text/css" />
<?php } ?>
</head>
<body style="background:#000;">
<div class="wrapper_chat">
<div class="top_chat">

    <? if ($mobile != 1) { ?>
    
        <div class="title_chat">
        <?php if (isset($logo_chat_title)) { ?>
           <img src="http://www.sportsbettingonline.ag/utilities/images/frontend/chat/<?php echo $logo_chat_title ?>" width="318" height="47" />
        <?php } ?>   
        </div>    
        <div class="logo_sbo_chat">
        <?php if (isset($logo_chat)) { ?>
           <img src="http://www.sportsbettingonline.ag/utilities/images/frontend/chat/<?php echo $logo_chat ?>" width="209" height="47" />	
        <?php } ?>
        </div>
        
    <? } else { ?>
    
       <div class="logo_sbo_chat_mobile">
        <?php if (isset($logo_chat)) { ?>
           <img src="http://www.sportsbettingonline.ag/utilities/images/frontend/chat/<?php echo $logo_chat ?>" width="209" height="47" />	
        <?php } ?>
       </div>     
    
    <? } ?>        
    
</div>
<form method="post" action="message_box.php" name="form" id="form">
  <input type="hidden" name="action" value="submit">
  <input type="hidden" name="deptid" value="<?php echo $deptid ?>">
  <input type="hidden" name="x" value="<?php echo $x ?>">
  <input type="hidden" name="l" value="<?php echo $l ?>">
  <input type="hidden" name="requestid" value="<?php echo $requestid ?>">
  <input type="hidden" name="agsite_desc" value="<?php echo $agsite_desc ?>">
  <input type="hidden" name="mobile" value="<?php echo $mobile ?>"> 
  <div id="main">  
    <div id="logo">
    <div class="texto1_chat">
      <?php echo ( $deptinfo['message'] ) ? stripslashes( $deptinfo['message'] ) : $LANG['MESSAGE_BOX_MESSAGE'] ?>
      </div>
    </div>
    <?php if ( $action == "submit" ): ?>
    <div id="formchat">
    <div id="inputarea">
    <div class="wrapper_form_chat" <? if (isset($mobile) and $mobile == 1) { ?> style="width:300px;" <? } ?>>
      <fieldset>
        <dl>
          <?php if ( $success ): ?>
          <big><b style="color:#000;"><?php echo $LANG['MESSAGE_BOX_SENT'] ?> <?php echo $deptinfo['name'] ?> Department</b></big> <br>
          <br>          
          <? if (isset($mobile) and $mobile == 1) { ?>          
          <a class="goback" href="http://<? echo return_domain_name($agsite_desc); ?>/">Go back to website</a>
<? } else { ?>
          <input type="image" src="http://www.sportsbettingonline.ag/utilities/images/frontend/chat/<?php echo $btn_close_window ?>" OnClick="parent.window.close()">
          <? } ?>          
          <?php endif ; ?>
          <?php if ( file_exists( "$DOCUMENT_ROOT/admin/traffic/knowledge_search.php" ) && $aspinfo['knowledgebase'] ) : ?>
          <br>
          <br>
          <a href="<?php echo $BASE_URL ?>/admin/traffic/knowledge_search.php?l=<?php echo $l ?>&x=<?php echo $x ?>&deptid=<?php echo $deptid ?>&"><b><?php echo $LANG['CLICK_HERE'] ?></b></a> <?php echo $LANG['KB_SEARCH'] ?></a>
          <?php endif ; ?>
        </dl>
      </fieldset>
    </div>
    </div>
    </div>
    <?php else: ?>
    <div id="formchat">    
    <div id="inputarea">
    <div class="wrapper_form_chat" <? if (isset($mobile) and $mobile == 1) { ?> style="width:300px;" <? } ?>>
      <fieldset>
        <dl>
          <dt>
            <label for="name"><?php echo $LANG['WORD_NAME'] ?>:</label>
          </dt>
          <dd class="textbox">
            <input style="border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #999999; border-top: 1px solid #999999; background-color:#FFF; <? if (isset($mobile) and $mobile == 1) { ?> width:190px; <? } ?>" type="text" name="name" id="name" size="40" maxlength="255" value="<?php echo isset( $_COOKIE['COOKIE_PHPLIVE_VLOGIN'] ) ? stripslashes( $_COOKIE['COOKIE_PHPLIVE_VLOGIN'] ) : "" ?>">
          </dd>
        </dl>
        <dl>
          <dt>
            <label for="email"><?php echo $LANG['WORD_EMAIL'] ?>:</label>
          </dt>
          <dd class="textbox">
            <input style="border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #999999; border-top: 1px solid #999999; background-color:#FFF; <? if (isset($mobile) and $mobile == 1) { ?> width:190px; <? } ?>" type="text" name="email" id="email" size="40" maxlength="255" value="<?php echo ( isset( $_COOKIE['COOKIE_PHPLIVE_VEMAIL'] ) && ( $_COOKIE['COOKIE_PHPLIVE_VEMAIL'] != "-@-.com" ) ) ? $_COOKIE['COOKIE_PHPLIVE_VEMAIL'] : "" ?>">
          </dd>
        </dl>
        <dl>
          <dt>
            <label for="phone">Phone Number:</label>
          </dt>
          <dd class="textbox">
            <input style="border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #999999; border-top: 1px solid #999999; background-color:#FFF; <? if (isset($mobile) and $mobile == 1) { ?> width:190px; <? } ?>" type="text" name="phone" id="phone" size="40" maxlength="255" value="">
          </dd>
        </dl>
        <dl>
          <dt>
            <label for="subject"><?php echo $LANG['WORD_SUBJECT'] ?>:</label>
          </dt>
          <dd class="textbox">
            <input style="border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #999999; border-top: 1px solid #999999; background-color:#FFF; <? if (isset($mobile) and $mobile == 1) { ?> width:190px; <? } ?>" type="text" name="subject" id="subject" size="40" maxlength="255" value="">
          </dd>
        </dl>
        <dl>
          <dt>
            <label for="message"><?php echo $LANG['WORD_MESSAGE'] ?>:</label>
          </dt>
          <dd class="textbox">
            <textarea style="margin-bottom:4px; <? if (isset($mobile) and $mobile == 1) { ?> width:188px; <? } ?>" name="message" cols="25" rows="2" id="message" class="message2"><?php echo ( isset( $_SESSION['session_chat'][$sid]['question'] ) ) ? stripslashes( $_SESSION['session_chat'][$sid]['question'] ) : "" ; ?></textarea>
          </dd>
          <dd><br>
            <div class="btn_sendemail_chat"><input type="image" src="http://www.sportsbettingonline.ag/utilities/images/frontend/chat/ezpay-btn_send_email_chat.png" class="button" name="send" value="<?php echo "$LANG[WORD_SEND] $LANG[WORD_EMAIL]" ?>" onclick="do_submit();" />
          
          </div></dd>
        </dl>
        <dl>
        </dl>
        <dl>
          <?php if ( file_exists( "$DOCUMENT_ROOT/admin/traffic/knowledge_search.php" ) && $aspinfo['knowledgebase'] ) : ?>
          <dt></dt>
          <dd><a href="<?php echo $BASE_URL ?>/admin/traffic/knowledge_search.php?l=<?php echo $l ?>&x=<?php echo $x ?>&deptid=<?php echo $deptid ?>&"><b><?php echo $LANG['CLICK_HERE'] ?></b></a> <?php echo $LANG['KB_SEARCH'] ?></a>
            <?php endif ; ?>
        </dl>
      </fieldset>
      </div>
</form>                  
      </div>           
    </div>        
    <?php endif ; ?>   
    <?php
		// because of tabbed browsers, we want to call a JavaScript window open function
		$branding = preg_replace( "/href=(.*?)( |>)/i", "href=\"JavaScript:opennewwin( \\1 )\"\\2", $LANG['DEFAULT_BRANDING'] ) ;
		$branding = preg_replace( "/target=(.*?)(>| >)/i", " >", $branding ) ;
	?>
  </div>  
</div>
</body>
</html>
*/

?>