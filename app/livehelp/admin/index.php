<?php
	session_start() ;
	$sid = $action = $deptid = $order_by = $sort_by = $page = $error = $chat_session = $search_string = $ave_rating_string = "" ;
	$success = $winapp = $x = 0 ;
	if ( isset( $_POST['winapp'] ) ) { $winapp = $_POST['winapp'] ; }
	if ( isset( $_GET['winapp'] ) ) { $winapp = $_GET['winapp'] ; }
	if ( isset( $_POST['action'] ) ) { $action = $_POST['action'] ; }
	if ( isset( $_GET['action'] ) ) { $action = $_GET['action'] ; }
	if ( isset( $_POST['deptid'] ) ) { $deptid = $_POST['deptid'] ; }
	if ( isset( $_GET['deptid'] ) ) { $deptid = $_GET['deptid'] ; }
	if ( isset( $_POST['order_by'] ) ) { $order_by = $_POST['order_by'] ; }
	if ( isset( $_GET['sort_by'] ) ) { $sort_by = $_GET['sort_by'] ; }
	if ( isset( $_POST['page'] ) ) { $page = $_POST['page'] ; }
	if ( isset( $_GET['page'] ) ) { $page = $_GET['page'] ; }
	if ( isset( $_POST['chat_session'] ) ) { $chat_session = $_POST['chat_session'] ; }
	if ( isset( $_GET['chat_session'] ) ) { $chat_session = $_GET['chat_session'] ; }
	if ( isset( $_POST['search_string'] ) ) { $search_string = $_POST['search_string'] ; }
	if ( isset( $_GET['search_string'] ) ) { $search_string = $_GET['search_string'] ; }
	if ( isset( $_POST['sid'] ) ) { $sid = $_POST['sid'] ; }
	if ( isset( $_GET['sid'] ) ) { $sid = $_GET['sid'] ; }
	if ( isset( $_POST['x'] ) ) { $x = $_POST['x'] ; }
	if ( isset( $_GET['x'] ) ) { $x = $_GET['x'] ; }

	if( !$sid )
	{
		HEADER( "location: ../index.php?winapp=$winapp&e=2" ) ;
		exit ;
	}

	include_once("../web/conf-init.php") ;
	$DOCUMENT_ROOT = realpath( preg_replace( "/http:/", "", $DOCUMENT_ROOT ) ) ;
	include_once("$DOCUMENT_ROOT/lang_packs/$LANG_PACK.php") ;
	include_once("$DOCUMENT_ROOT/web/VERSION_KEEP.php") ;
	include_once("$DOCUMENT_ROOT/API/sql.php" ) ;
	include_once("$DOCUMENT_ROOT/API/Util.php") ;
	include_once("$DOCUMENT_ROOT/API/Util_Page.php") ;
	include_once("$DOCUMENT_ROOT/API/Users/get.php") ;
	include_once("$DOCUMENT_ROOT/API/Chat/remove.php") ;
	include_once("$DOCUMENT_ROOT/API/Users/update.php") ;
	include_once("$DOCUMENT_ROOT/API/Transcripts/get.php") ;
	include_once("$DOCUMENT_ROOT/API/Logs/get.php") ;
	include_once("$DOCUMENT_ROOT/API/Logs/remove.php") ;
	include_once("$DOCUMENT_ROOT/API/ASP/get.php") ;
	include_once("$DOCUMENT_ROOT/API/Spam/get.php") ;
	include_once("$DOCUMENT_ROOT/API/Spam/put.php") ;
	include_once("$DOCUMENT_ROOT/API/Spam/remove.php") ;

	if ( !isset( $_SESSION['session_admin'] ) || !isset( $_SESSION['session_admin'][$sid]['asp_login'] ) || !file_exists( "../web/".$_SESSION['session_admin'][$sid]['asp_login']."/".$_SESSION['session_admin'][$sid]['asp_login']."-conf-init.php" ) || !file_exists( "../web/conf-init.php" ) )
	{
		// called from WinApp - since it won't register the session, read from cookie and reset
		if ( $action == "set" )
		{
			if ( !isset( $_SESSION['session_admin'] ) )
			{
				//session_register( "session_admin" ) ;
				$_SESSION['session_admin'] = "session_admin";
				$session_admin = ARRAY() ;
				$_SESSION['session_admin'] = ARRAY() ;
			}

			$aspinfo = AdminASP_get_UserInfo( $dbh, $x ) ;
			$admin = AdminUsers_get_UserInfoBySession( $dbh, $x, $sid ) ;
			
			$departments = AdminUsers_get_UserDepartments( $dbh, $admin['userID'] ) ;
			$dept_string = "" ;
			for ( $c = 0; $c < count( $departments ); ++$c )
			{
				$the_department = $departments[$c] ;
				$dept_string .= "deptID = $the_department[deptID] AND" ;
			}
			$dept_string .= "deptID = 0" ;

			// reset $sid so it registered online if launched admin console again
			$sid  = time() ;
			$_SESSION['session_admin'][$sid] = ARRAY() ;
			$_SESSION['session_admin'][$sid]['dept_string'] = $dept_string ;
			$_SESSION['session_admin'][$sid]['admin_id'] = $admin['userID'] ;
			$_SESSION['session_admin'][$sid]['requests'] = 0 ;
			$_SESSION['session_admin'][$sid]['aspID'] = $aspinfo['aspID'] ;
			$_SESSION['session_admin'][$sid]['asp_login'] = $aspinfo['login'] ;
			$_SESSION['session_admin'][$sid]['active_footprints'] = 0 ;
			$_SESSION['session_admin'][$sid]['winapp'] = 0 ;
			$_SESSION['session_admin'][$sid]['close_timer'] = 0 ;
			$_SESSION['session_admin'][$sid]['traffic_monitor'] = 0 ;
			$_SESSION['session_admin'][$sid]['available_status'] = 1 ;
			$_SESSION['session_admin'][$sid]['sound'] = "on" ;
			$_SESSION['session_admin'][$sid]['request_ids'] = "" ;
			$_SESSION['session_admin'][$sid]['traffic_timer'] = $admin['console_refresh'] ;

			$url = "jump.php?sid=$sid&page=$page" ;
			if ( isset( $_GET['ip'] ) )
			{
				// set $action to set again for flag on condition below
				$url = "jump.php?sid=$sid&action=set&ip=$_GET[ip]" ;
			}
			HEADER( "location: $url" ) ;
			exit ;
		}
		else
		{
			HEADER( "location: ../index.php?winapp=$winapp&e=3" ) ;
			exit ;
		}
	}
	else if ( $page == "initiate" )
	{
		HEADER( "location: canned.php?sid=$sid&action=canned_initiate" ) ;
		exit ;
	}
	
	include_once("../web/".$_SESSION['session_admin'][$sid]['asp_login']."/".$_SESSION['session_admin'][$sid]['asp_login']."-conf-init.php") ;
	include_once("$DOCUMENT_ROOT/system.php") ;

	// initialize
	if ( preg_match( "/(MSIE)|(Gecko)/", $_SERVER['HTTP_USER_AGENT'] ) )
	{
		$text_width = "20" ;
		$text_width_long = "60" ;
		$textbox_width = "80" ;
	}
	else
	{
		$text_width = "10" ;
		$text_width_long = "30" ;
		$textbox_width = "40" ;
	}

	// check to make sure session is set.  if not, user is not authenticated.
	// send them back to login
	if ( !$_SESSION['session_admin'][$sid]['admin_id'] )
	{
		HEADER( "location: ../index.php?winapp=$winapp&e=4" ) ;
		exit ;
	}
	$now = time() ;

	// update all admins status to not available if they have been idle
	AdminUsers_update_IdleAdminStatus( $dbh, $admin_idle ) ;
	ServiceChat_remove_CleanChatSessions( $dbh ) ;

	if ( $action == "edit_password" )
		$section = 3 ;
	else if ( $action == "spam" )
		$section = 6 ;
	else
		$section = 5 ;

	// This is used in footer.php and it places a layer in the menu area when you are in
	// a section > 0 to provide navigation back.
	// This is currently set as a javascript back, but it could be replaced with explicit
	// links as using the javascript back button can cause problems after submitting a form
	// (cause the data to get resubmitted)

	$nav_line = "&nbsp;";

	// functions

	// conditions
	if ( $action == "update_password" )
	{
		$admin = AdminUsers_get_UserInfo( $dbh, $_SESSION['session_admin'][$sid]['admin_id'], $_SESSION['session_admin'][$sid]['aspID'] ) ;

		if ( md5( $_POST['curpassword'] ) == $admin['password'] )
		{
			AdminUsers_update_Password( $dbh, $_SESSION['session_admin'][$sid]['admin_id'], $_POST['newpassword'] ) ;
			$success = 1 ;
		}
		else
		{
			$action = $_POST['prev_action'] ;
			$error = "Your current password is invalid." ;
		}
		$action = "edit_password" ;
	}
	else if ( $action == "update_poll" )
	{
		AdminUsers_update_UserValue( $dbh, $_SESSION['session_admin'][$sid]['admin_id'], "console_close_min", $_POST['console_close_min'] ) ;
		$action = "edit_password" ;
		$success = 1 ;
	}
	else if ( ( $action == "exclude_ip" ) || ( ( $action == "set" ) && ( isset( $_GET['ip'] ) ) ) )
	{
		$action = "spam" ;
		if ( isset( $_GET['ip'] ) )
			$new_ip = $_GET['ip'] ;
		else
			$new_ip = $_POST['ip1'].".".$_POST['ip2'].".".$_POST['ip3'].".".$_POST['ip4']." " ;
		ServiceSpam_put_IP( $dbh, $new_ip, $_SESSION['session_admin'][$sid]['aspID'] ) ;
		$success = 1 ;
	}
	else if ( $action == "remove_excluded_ip" )
	{
		$action = "spam" ;
		ServiceSpam_remove_IP( $dbh, $_SESSION['session_admin'][$sid]['aspID'], $_POST['excluded_ips'] ) ;
	}
	else if ( $action == "update_theme" )
	{
		AdminUsers_update_UserValue( $dbh, $_SESSION['session_admin'][$sid]['admin_id'], "theme", $_GET['theme'] ) ;
		$action = "edit_password" ;
		$success = 1 ;
	}

	$admin = AdminUsers_get_UserInfo( $dbh, $_SESSION['session_admin'][$sid]['admin_id'], $_SESSION['session_admin'][$sid]['aspID'] ) ;
	$deptinfo = AdminUsers_get_DeptInfo( $dbh, $deptid, $_SESSION['session_admin'][$sid]['aspID'] ) ;
	$can_initiate = AdminUsers_get_CanUserInitiate( $dbh, $_SESSION['session_admin'][$sid]['admin_id'] ) ;
	$console_window_height = 175 ;
	if ( $can_initiate && $INITIATE )
		$console_window_height = 310 ;

	$rating_hash = Array() ;
	$rating_hash[4] = "Excellent" ;
	$rating_hash[3] = "Very Good" ;
	$rating_hash[2] = "Good" ;
	$rating_hash[1] = "Needs Improvement" ;
	$rating_hash[0] = "no rating yet" ;

	$ave_rating_string = $rating_hash[$admin['rate_ave']] ;
	// revert to blank for transcript
	$rating_hash[0] = "&nbsp;" ;
?>
<?php include(ROOT_PATH . "/header.php") ; ?>
<script language="JavaScript">
<!--
	// do everything here before it loads
	<?php
		if ( $_SESSION['session_admin'][$sid]['winapp'] == 1 )
			print "		winapp() ;\n" ;
	?>
	
	function open_admin()
	{
		var date = new Date() ;
		var winname = date.getTime() ;
		url = "admin_consol.php?sid=<?php echo $sid ?>" ;
		newwin = window.open(url, "operator_<?php echo $sid ?>", "scrollbars=yes,menubar=no,resizable=1,location=no,width=580,status=0,height=<?php echo $console_window_height ?>") ;
		newwin.focus() ;
		//location.href = "index.php?sid=<?php echo $sid ?>&deptid=<?php echo $deptid ?>" ;
	}

	function do_search()
	{
		string = replace( document.form.search_string.value, " ", "" ) ;
		if ( string.length < 3 )
			alert( "Search string must be AT LEAST 3 characters." )
		else
			document.form.submit() ;
	}

	function do_submit_poll()
	{
		document.form_poll.submit() ;
	}

	function check_console_value( minutes )
	{
		if ( minutes == "" )
			document.form_poll.console_close_min.value = 0 ;
	}

	function do_submit_pass()
	{
		if ( ( document.form.newpassword.value == "" ) || ( document.form.curpassword.value == "" ) )
			alert( "All fields must be supplied." ) ;
		else if ( document.form.newpassword.value != document.form.vnewpassword.value )
			alert( "Passwords do not match." ) ;
		else
			document.form.submit() ;
	}

	function winapp()
	{
		url = "admin_consol.php?sid=<?php echo $sid ?>" ;
		location.href = url ;
	}

	function view_transcript( chat_session )
	{
		url = "<?php echo $BASE_URL ?>/admin/view_transcript.php?chat_session="+chat_session+"&x=<?php echo $_SESSION['session_admin'][$sid]['aspID'] ?>&l=<?php echo $_SESSION['session_admin'][$sid]['asp_login'] ?>&sid=<?php echo $sid ?>&theme_admin=<?php echo $admin['theme'] ?>" ;
		newwin = window.open(url, "transcript", "scrollbars=0,menubar=no,resizable=1,location=no,width=450,height=360") ;
		newwin.focus() ;

	}

	function add_ip()
	{
		if ( ( document.ip.ip1.value == "" ) || ( document.ip.ip2.value == "" )
			|| ( document.ip.ip3.value == "" ) || ( document.ip.ip4.value == "" ) )
			alert( "IP is Invalid." ) ;
		else if ( ( document.ip.ip1.value > 255 ) || ( document.ip.ip2.value > 255 )
			|| ( document.ip.ip3.value > 255 ) || ( document.ip.ip4.value > 255 ) )
			alert( "Each IP value cannot be greater then 255." ) ;
		else
		{
			if ( confirm( "Block this IP from using the Live Support system?" ) )
				document.ip.submit() ;
		}
	}

	function do_remove_ip( index )
	{
		if ( index < 0 )
			alert( "Please select an IP to remove from list." ) ;
		else
		{
			if ( confirm( "Remove this IP from Spam Block list?" ) )
				document.ip_excluded.submit() ;
		}
	}

	function view_theme(theme)
	{
		var url = "../request.php?l=<?php echo $_SESSION['session_admin'][$sid]['asp_login'] ?>&x=<?php echo $_SESSION['session_admin'][$sid]['aspID'] ?>&deptid=0&pagex=setup&theme="+theme ;
		var newwin = window.open( url, "newwin", 'status=no,scrollbars=yes,menubar=no,resizable=yes,location=no,screenX=50,screenY=100,width=450,height=360' ) ;
		newwin.focus() ;
	}

	function select_theme(theme)
	{
		if ( confirm( "Use this theme?" ) )
			location.href = "index.php?sid=<?php echo $sid ?>&deptid=<?php echo $deptid ?>&action=update_theme&theme="+theme ;
		else
			document.form.elements[theme].checked = false ;
	}
//-->
</script>

<?php
	if ( $action == "edit_password" ):
	if ( !isset ( $THEME ) ) { $THEME = "default" ; }
	$themes = Array() ;
	if ( $dir = @opendir("$DOCUMENT_ROOT/themes/") )
	{
		while ( ( $file = readdir( $dir ) ) != false )
		{
			if ( !preg_match( "/\.|(cvs)/i", $file ) && file_exists( "$DOCUMENT_ROOT/themes/$file/style.css" ) )
				array_push( $themes, $file ) ;
		}
		closedir( $dir ) ; 
	}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="15">
  <tr> 
	<td width="100%" height="350" valign="top"> <p><span class="title">Preferences</span><br>
		Setup PHP Live! operator preferences.  <?php echo ( isset( $success ) && $success ) ? "<font color=\"#29C029\"><big><b>Update Success!</b></big></font>" : "" ?></p>
		<p><strong>Console timeout:</strong></p>
		<ul>
		<li> When you set your admin request console to Offline, the window will 
		automatically close (for security and to limit system usage).</li>
		<li> Switching to <i>Offline</i> status is helpful when you step away 
		from your computer for a short time. </li>
		</ul>
	  
		
		<table cellspacing=1 cellpadding=1 border=0>
		<form method="POST" action="index.php" name="form_poll">
		<input type="hidden" name="action" value="update_poll">
		<input type="hidden" name="sid" value="<?php echo $sid ?>">
		<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
		<tr> 
			<td>Time to wait until the <i>Offline</i> console automatically closes:</td>
			<td> <font size=2> 
			<input type="text" name="console_close_min" size="3" maxlength="3" value="<?php echo ( $admin['console_close_min'] ) ? $admin['console_close_min'] : $_POST['console_close_min'] ?>" OnBlur="check_console_value(this.value)" onKeyPress="return numbersonly(event)">
			</font> minutes </td>
		</tr>
		<tr> 
			<td>&nbsp; </td>
			<td><input type="button" value="Update Auto-close Time" class="mainButton" OnClick="do_submit_poll()"></td>
		</tr></form>
		</table>
		<br>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr> 
			<td class="hdash">&nbsp;</td>
		</tr>
		</table>

		<strong>Admin Chat Theme:</strong><br>
		Select your preferred chat theme for your operator chat window.  This does not effect the visitor's chat window theme (set in the setup area).
		<p>
		<form>
		<table cellspacing=1 cellpadding=0 border=0>
		<?php
			$cols = 6 ;
			for ( $c = 0; $c < count( $themes ); ++$c )
			{
				$selected = "" ;
				if ( $admin['theme'] && ( $themes[$c] == $admin['theme'] ) ) $selected = "checked" ;
				else if ( !$admin['theme'] && ( $themes[$c] == $THEME ) ) $selected = "checked" ;

				$output = "" ;
				$col = $c + 1 ;
				if ( ( $col == 1 ) || is_int( ( $col - 1 )/$cols ) )
					$output = "<tr>" ;

				$output .= "<td class=\"altcolor2\"><a href=\"JavaScript:view_theme('$themes[$c]')\">$themes[$c]</a></td><td class=\"altcolor2\"><input type=checkbox name=\"$themes[$c]\" value=\"$themes[$c]\" $selected OnClick=\"select_theme( '$themes[$c]' )\"></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>" ;

				if ( is_int( $col/$cols ) )
					$output .= "</tr>\n" ;
				print $output ;
			}
		?>
		</table>
		</form>

		<br>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr> 
			<td class="hdash">&nbsp;</td>
		</tr>
		</table>
		<p><strong>Change Your Password: <font color="#FF0000"><?php echo $error ?></font></strong>
		<table cellspacing=1 cellpadding=1 border=0>
		<form method="POST" action="index.php" name="form">
		<input type="hidden" name="action" value="update_password">
		<input type="hidden" name="prev_action" value="<?php echo $action ?>">
		<input type="hidden" name="sid" value="<?php echo $sid ?>">
		<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
		<tr> 
			<td align="right">Current Password</td>
			<td><input type="password" style="width:120px" name="curpassword" size="<?php echo $text_width ?>" maxlength="15"></td>
		</tr>
		<tr> 
			<td align="right">New Password</td>
			<td><input type="password" style="width:120px" name="newpassword" size="<?php echo $text_width ?>" maxlength="15"></td>
		</tr>
		<tr> 
			<td align="right">Verify New Password</td>
			<td><input type="password" style="width:120px" name="vnewpassword" size="<?php echo $text_width ?>" maxlength="15"></td>
		</tr>
		<tr> 
			<td>&nbsp;</td>
			<?php if ( md5( "demo" ) == $admin['password'] ) : ?>
			<td><big><b>Password change has been disabled for Demo operator.</b></big></td>
			<?php else: ?>
			<td><input type="button" value="Update Password" class="mainButton" OnClick="do_submit_pass()"></td>
			<?php endif ; ?>
		</tr>
		</form>
		</table>
		</p>
	</td>
	<td style="background-image: url(../images/g_prefs_big.jpg);background-repeat: no-repeat;"><img src="../images/spacer.gif" width="229" height="1"></td>
</tr>
</table>













<?php
	elseif ( $action == "spam" ):
	ServiceSpam_remove_CleanOldIPs( $dbh ) ;
	$ips = ServiceSpam_get_IPs( $dbh, $_SESSION['session_admin'][$sid]['aspID'] ) ;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="15">
  <tr> 
	<td width="100%" height="350" valign="top"> <p><span class="title">Spam Blocking</span><br>
		Block spammers from requesting Live Support.</p>
	  <ul>
		<li> Block IPs from requesting Live Support to limit abuse of system.  Blocked IPs will be automatically cleared (unblocked) after 3 days.</li>
		<li> Blocked IPs are shared and active throughout all departments and operators.</li>
		<li> <span class="hilight">Visitors from blocked IPs will always see an Offline status.<span></li>
	  </ul>
	  
		
	<table border="0" cellpadding="1" cellspacing="2">
	  <form method="POST" action="index.php" name="ip_excluded">
		<tr>
		  <td colspan="4" valign="top"><strong>Block IP from System</strong> </td>
		  <input type="hidden" name="action" value="remove_excluded_ip">
		  <input type="hidden" name="sid" value="<?php echo $sid ?>">
		  <input type="hidden" name="deptid" value="<?php echo $deptid ?>">
		  <td width="300" rowspan="3" align="center" valign="top">
			<select name="excluded_ips" size=5 style="width:200;font-size:12px" width="200">
			<?php
				for( $c = 0; $c < count( $ips ); ++$c )
				{
					$ip = $ips[$c] ;
					print "<option value=\"$ip[ip]\">$ip[ip]</option>" ;
				}
			?>
			</select> <br>
			[<a href="JavaScript:do_remove_ip(document.ip_excluded.excluded_ips.selectedIndex)">remove 
			SELECTED ip from list</a>]</td>
		</tr>
	  </form>
	  <form method="POST" action="index.php" name="ip">
		<input type="hidden" name="action" value="exclude_ip">
		<input type="hidden" name="sid" value="<?php echo $sid ?>">
		<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
		<tr> 
		  <td valign="top"> <input type="text" name="ip1" size=3 maxlength=3 style="width:30px;" onKeyPress="return numbersonly(event)"></td>
		  <td valign="top"><input type="text" name="ip2" size=3 maxlength=3 style="width:30px;" onKeyPress="return numbersonly(event)"></td>
		  <td valign="top"><input type="text" name="ip3" size=3 maxlength=3 style="width:30px;" onKeyPress="return numbersonly(event)"></td>
		  <td valign="top"><input type="text" name="ip4" size=3 maxlength=3 style="width:30px;" onKeyPress="return numbersonly(event)"></td>
		</tr>
		<tr> 
		  <td colspan="4" valign="top"> 
			<input type="button" class="mainButton" value="Block IP Address" OnClick="add_ip()">
		  </td>
		</tr>
	  </form>
	</table>

</p></td>
  <td style="background-image: url(../images/g_prefs_big.jpg);background-repeat: no-repeat;"><img src="../images/spacer.gif" width="229" height="1"></td>
</tr>
 </table>



















<?php else: ?>
<table width="100%" border="0" cellspacing="15" cellpadding="0">
  <tr>

    <td width="100%" rowspan="3" valign="top">
	<p>
	<table cellspacing=0 cellpadding=2 border=0><tr><td valign="top"><span class="title"><font color="#29C029">Go ONLINE &raquo; </font></span></td><td valign="top"> <a href="JavaScript:void(0)" OnClick="open_admin()"><img src="../images/extra/btn_launch.gif" width="275" height="28" border="0" alt=""></a></td></tr></table>
	<p>
	  From here you can administrate your operator settings and 
	  review previous session transcripts.
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr> 
		<td class="hdash">&nbsp;</td>
	  </tr>
	</table>

	<form name=dept_select><p>
		To view saved transcripts, please <span class="basicTitle">select your department</span>: 
	<?php
			$select_dept = $searched_string = $page_string = "" ;
			$total_transcripts = 0 ;
			$transcripts = ARRAY() ;
			if ( $deptid )
			{
				ServiceLogs_remove_DeptExpireTranscripts( $dbh, $deptid, $_SESSION['session_admin'][$sid]['aspID'] ) ;
				$department = AdminUsers_get_DeptInfo( $dbh, $deptid, $_SESSION['session_admin'][$sid]['aspID'] ) ;
				if ( AdminUsers_get_IsUserInDept( $dbh, $_SESSION['session_admin'][$sid]['admin_id'], $department['deptID'] ) )
				{
					if ( $department['transcript_share'] )
					{
						$transcripts = ServiceTranscripts_get_DeptTranscripts( $dbh, $_SESSION['session_admin'][$sid]['aspID'], $department['deptID'], $order_by, $sort_by, $page, 20, $search_string ) ;
						$total_transcripts = ServiceTranscripts_get_TotalDeptTranscripts( $dbh, $department['deptID'], $search_string ) ;
					}
					else
					{
						$transcripts = ServiceTranscripts_get_UserDeptTranscripts( $dbh, $_SESSION['session_admin'][$sid]['aspID'], $admin['userID'], $department['deptID'], $order_by, $sort_by, $page, 20, $search_string ) ;
						$total_transcripts = ServiceTranscripts_get_TotalUserDeptTranscripts( $dbh, $admin['userID'], $department['deptID'], $search_string ) ;
					}
					$page_string = Page_util_CreatePageString( $dbh, $page, "index.php?sid=$sid&deptid=$deptid&search_string=$search_string", 20, $total_transcripts ) ;
				}
			}
			
			$admin_departments = AdminUsers_get_UserDepartments( $dbh, $_SESSION['session_admin'][$sid]['admin_id'] ) ;
			for ( $c = 0; $c < count( $admin_departments ); ++$c )
			{
				$department = $admin_departments[$c] ;
				$dept_name = stripslashes( $department['name'] ) ;
				$selected = "" ;
				if ( $department['deptID'] == $deptid )
					$selected = "selected" ;

				$select_dept .= "<option value=\"$department[deptID]\" $selected>$dept_name</option>" ;
			}
			print "<select name=\"department\" class=\"select\" OnChange=\"index=this.selectedIndex;if(index>0){location.href='index.php?sid=$sid&deptid='+document.dept_select.department[index].value}\"><option value=\"-- select department --\">&nbsp;</option>$select_dept</select></form>" ;

			if ( $search_string )
				$searched_string = "Searched: \"$search_string\" &nbsp;|&nbsp; Transcripts Found: $total_transcripts &nbsp;|&nbsp; [ <a href=\"index.php?sid=$sid&deptid=$deptid\">reset</a> ]<br>" ;
		?>

	<?php echo $searched_string ?><br>
	Page: <?php echo $page_string ?> </font><br>
	<table cellspacing=1 cellpadding=3 border=0 width="100%">
	  <tr> 
		<th align="center">&nbsp;</th>
		<th align="left">Operator</th>
		<th align="left">Visitor</th>
		<th align="left">Rating</th>
		<th align="left">Created</th>
		<th align="left" nowrap>Visitor Question</td>
		<th align="left">Duration</th>
		<th align="left">Size</th>
	  </tr>
	  <?php
			for ( $c = 0; $c < count( $transcripts ); ++$c )
			{
				$transcript = $transcripts[$c] ;
				$userinfo = AdminUsers_get_UserInfo( $dbh, $transcript['userID'], $_SESSION['session_admin'][$sid]['aspID'] ) ;
				$date = date( "D m/d/y $TIMEZONE_FORMAT:i$TIMEZONE_AMPM", ( $transcript['created'] + $TIMEZONE ) ) ;

				// take out the tags to make it more accurate size. (gets rid of all
				// the javascript tags and all that
				$size = Util_Format_Bytes( strlen( strip_tags( $transcript['plain'] ) ) ) ;
				$rating = ( isset( $transcript['rating'] ) ) ? $transcript['rating'] : 0 ;
				$rating = $rating_hash[$rating] ;

				$class = "altcolor1" ;
				if ( $c % 2 )
					$class = "altcolor2" ;

				$duration = $transcript['created'] - $transcript['chat_session'] ;
				if ( $duration <= 0 ) { $duration = 1 ; }
				if ( $duration > 60 )
					$duration = round( $duration/60 ) . " min" ;
				else
					$duration = $duration . " sec" ;

				if ( preg_match( "/<question>(.*)<\/question>/s", $transcript['formatted'], $matches ) )
					$question = ( isset( $matches[0] ) ) ? $matches[0] : "&nbsp;" ;
				else
					$question = "&nbsp;" ;

				if ( preg_match( "/<initiated>/", $transcript['formatted'] ) )
					$question = "[ Operator Initiated Chat ]" ; // initiated chat

				print "
				<tr class=\"$class\">
					<td><a href=\"JavaScript:view_transcript( $transcript[chat_session] )\"><img src=\"../images/view.gif\" border=0 width=28 height=16></a></td>
					<td nowrap>$userinfo[name]</td>
					<td nowrap>$transcript[from_screen_name]</td>
					<td>$rating</td>
					<td nowrap>$date</td>
					<td><i>$question</i></td>
					<td nowrap>$duration</td>
					<td nowrap>$size</td>
				</tr>
				" ;
			}
		?>
	</table>
	</p>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr> 
		<td class="hdash">&nbsp;</td>
	  </tr>
	</table> 

	  
	 <p>System generated messages, such as party left and greeting messages, 
		are ignored during search.</p> 
	<table cellspacing=1 cellpadding=1 border=0>
	<form method="GET" action="index.php" name="form">
	  <input type="hidden" name="sid" value="<?php echo $sid ?>">
	  <input type="hidden" name="deptid" value="<?php echo $deptid ?>">
		<tr> 
		  <td><strong>Search:</strong></td>
		  <td><input type="text" name="search_string" value="<?php echo $search_string ?>" size="25" maxlength="50" style="width:200px"></td>
		  <td><input type="button" OnClick="do_search()" class="mainButton" value="Search"></td>
		</tr></form>
	  </table>
		<!-- end search area -->
	  </p>
	  </td>
	</tr>
 </table>

<?php endif ; ?>

<?php include_once( "../setup/footer.php" ); ?>

