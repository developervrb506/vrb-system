<?php	
	session_start() ;
	$action = $sessionid = $requestid = $sid = "" ;
	$close_window = 0 ;
	$session_chat = $_SESSION['session_chat'] ;
	if ( isset( $_POST['sid'] ) ) { $sid = $_POST['sid'] ; }
	if ( isset( $_GET['sid'] ) ) { $sid = $_GET['sid'] ; }
	if ( isset( $_POST['sessionid'] ) ) { $sessionid = $_POST['sessionid'] ; }
	if ( isset( $_GET['sessionid'] ) ) { $sessionid = $_GET['sessionid'] ; }
	if ( isset( $_POST['action'] ) ) { $action = $_POST['action'] ; }
	if ( isset( $_GET['action'] ) ) { $action = $_GET['action'] ; }
	if ( isset( $_POST['requestid'] ) ) { $requestid = $_POST['requestid'] ; }
	if ( isset( $_GET['requestid'] ) ) { $requestid = $_GET['requestid'] ; }
	
	if ( isset( $_GET['ins'] ) ) { $ins = $_GET['ins'] ; }
	if ( isset( $_GET['agsite'] ) ) { $agsite = $_GET['agsite'] ; }
	if ( isset( $_GET['agsite_desc'] ) ) { $agsite_desc = $_GET['agsite_desc'] ; }
	if ( isset( $_GET['mobile'] ) ) { $mobile = $_GET['mobile'] ; }
			
	if ( isset( $_POST['ins'] ) ) { $ins = $_POST['ins'] ; }
	if ( isset( $_POST['agsite'] ) ) { $agsite = $_POST['agsite'] ; }
	if ( isset( $_POST['agsite_desc'] ) ) { $agsite_desc = $_POST['agsite_desc'] ; }
	if ( isset( $_POST['mobile'] ) ) { $mobile = $_POST['mobile'] ; }
		
	include_once("./livehelp/chat_logos_container.php") ;		
	
	if (isset($mobile) and $mobile == 1) {
		
	  $site_domain = return_domain_name($agsite_desc);	
      header("Location: http://$site_domain");
	  exit;
    }	

	if ( !file_exists( "web/".$session_chat[$sid]['asp_login']."/".$session_chat[$sid]['asp_login']."-conf-init.php" ) || !file_exists( "web/conf-init.php" ) )
	{
		print "<font color=\"#FF0000\">[Configuration Error: config files not found!] Exiting...</font>" ;
		exit ;
	}
	include_once("./web/conf-init.php") ;
	$DOCUMENT_ROOT = realpath( preg_replace( "/http:/", "", $DOCUMENT_ROOT ) ) ;
	include_once("./web/".$session_chat[$sid]['asp_login']."/".$session_chat[$sid]['asp_login']."-conf-init.php") ;
	include_once("$DOCUMENT_ROOT/web/VERSION_KEEP.php") ;
	include_once("$DOCUMENT_ROOT/system.php") ;
	include_once("$DOCUMENT_ROOT/lang_packs/$LANG_PACK.php") ;
	include_once("$DOCUMENT_ROOT/API/sql.php" ) ;
	include_once("$DOCUMENT_ROOT/API/ASP/get.php") ;
	include_once("$DOCUMENT_ROOT/API/Users/get.php") ;

	// initialize
	if ( file_exists( "web/".$session_chat[$sid]['asp_login']."/$LOGO" ) && $LOGO )
		$logo = "web/".$session_chat[$sid]['asp_login']."/$LOGO" ;
	else if ( file_exists( "web/$LOGO_ASP" ) && $LOGO_ASP )
		$logo = "web/$LOGO_ASP" ;
	else if ( file_exists( "themes/$THEME/images/logo.gif" ) )
		$logo = "themes/$THEME/images/logo.gif" ;
	else
		$logo = "images/logo.gif" ;
	
	$aspinfo = AdminASP_get_UserInfo( $dbh, $session_chat[$sid]['aspID'] ) ;
	$admin = AdminUsers_get_UserInfo( $dbh, $session_chat[$sid]['admin_id'], $session_chat[$sid]['aspID'] ) ;
	$department = AdminUsers_get_DeptInfo( $dbh, $session_chat[$sid]['deptid'], $session_chat[$sid]['aspID'] ) ;

	// conditions

	if ( !$admin['rateme'] && !$department['email_trans'] )
		$close_window = 1 ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?
if (isset($mobile) and $mobile == 1) {
include_once("./livehelp/chat_top_header_mobile.php") ;
}
?>
<title> Thank you </title>

<script type="text/javascript" language="JavaScript1.2" src="js/chat_fn.js"></script>

<script type="text/javascript" language="JavaScript1.2">
<!--
	if ( <?php echo $close_window ?> )
	{
		window.close();
	}

	var pullimage ;

	function checkifloaded()
	{
		loaded = pullimage.width ;
		if ( loaded == 1 )
			window.close() ;
		else
			alert( "Error: Transcript did not send.  Please try again." ) ;
	}

	function do_submit()
	{
		if ( document.form.email.value != "" )
		{
			if ( document.form.email.value.indexOf("@") == -1 )
				alert( "<?php echo $LANG['MESSAGE_BOX_JS_A_INVALIDEMAIL'] ?>" ) ;
			else
				doit() ;
		}
		else
			doit() ;
	}

	function doit()
	{
		document.form.submitbutton.disabled = true ;
		document.form.submitbutton.value = "Please hold.  Sending ..." ;

		var email = document.form.email.value ;
		<?php if ( $admin['rateme']  ): ?>
		var rate_index = document.form.rate.selectedIndex ;
		var rate = document.form.rate[rate_index].value ;
		<?php else: ?>
		var rate = 0 ;
		<?php endif ; ?>
		var url = "<?php echo $BASE_URL ?>/admin/view_transcripts.php?action=send&l=<?php echo $session_chat[$sid]['asp_login'] ?>&x=<?php echo $session_chat[$sid]['aspID'] ?>&chat_session=<?php echo $sessionid ?>&sid=<?php echo $sid ?>&requestid=<?php echo $requestid ?>&deptid=<?php echo $session_chat[$sid]['deptid'] ?>&email="+email+"&optmessage=&rate="+rate ;

		pullimage = new Image ;
		pullimage.src = url ;
		pullimage.onload = checkifloaded ;
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
<link href="<?= BASE_URL ?>/livehelp/css/ezpay-chat.css" rel="stylesheet" type="text/css" />
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
<div style="clear:both;"></div>
<form onSubmit="return false;" name="form">
<div id="main">	
	<p>
	<div id="inputarea">
    <div class="wrapper_form_chat" <? if (isset($mobile) and $mobile == 1) { ?> style="width:300px;" <? } ?>>
		<fieldset>
			<?php if ( $admin['rateme']  ): ?>
			<p style="color:#000;">Please take a moment to rate your support experience.</p>
			<dl>
				<dt><label for="rating">Support Rating</label></dt>
				<dd><select name="rate" id="rating" style="width: auto; border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #999999; border-top: 1px solid #999999; background-color:#FFF; <? if (isset($mobile) and $mobile == 1) { ?> width:190px; <? } ?>">
						<option value="0">No Response</option>
						<option value="4">Excellent</option>
						<option value="3">Very Good</option>
						<option value="2">Good</option>
						<option value="1">Needs Improvement</option>
					</select></dd>
			</dl>
			<?php else: ?>
			<input type="hidden" name="rating" value="0">
			<p>&nbsp;</p>
			<?php endif ; ?>
			<?php if ( $department['email_trans'] ): ?>
			<p style="color:#000;"><?php echo stripslashes( $aspinfo['trans_message'] ) ?></p>
			<dl>
				<dt><label for="email">Your Email</label></dt>
				<dd class="textbox"><input style="border-right: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; border-left: 1px solid #999999; border-top: 1px solid #999999; background-color:#FFF; <? if (isset($mobile) and $mobile == 1) { ?> width:190px; <? } ?>" type="text" name="email" id="email" size="40" maxlength="255" value=""></dd>
			</dl>
			<?php else: ?>
			<input type="hidden" name="email" value="">
			<?php endif ; ?>
			<dl></dl>
			<dl>
				<dt>&nbsp;</dt>
				<dd style="text-align:center;"><br><input type="button" value="Submit & Close Window" onclick="do_submit();" name="submitbutton"></dd>
			</dl>						
            <br />
		</fieldset>
		</div>	
		<?php
			// because of tabbed browsers, we want to call a JavaScript window open function
			$branding = preg_replace( "/href=(.*?)( |>)/i", "href=\"JavaScript:opennewwin( \\1 )\"\\2", $LANG['DEFAULT_BRANDING'] ) ;
			$branding = preg_replace( "/target=(.*?)(>| >)/i", " >", $branding ) ;
		?>	
	</div>
</div>
</form>
</div>
</body>
</html>