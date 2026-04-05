<?php
	/*******************************************************
	* COPYRIGHT OSI CODES - PHP Live!
	*******************************************************/
	session_start() ;
	if ( isset( $_SESSION['session_setup'] ) ) { $session_setup = $_SESSION['session_setup'] ; } else { HEADER( "location: index.php" ) ; exit ; }
	include_once( "../API/Util_Dir.php" ) ;
	if ( !Util_DIR_CheckDir( "..", $session_setup['login'] ) )
	{
		HEADER( "location: index.php" ) ;
		exit ;
	}
	include_once("../web/conf-init.php");
	$DOCUMENT_ROOT = realpath( preg_replace( "/http:/", "", $DOCUMENT_ROOT ) ) ;
	include_once("../web/".$session_setup['login']."/".$session_setup['login']."-conf-init.php") ;
	include_once("../system.php") ;
	include_once("../lang_packs/$LANG_PACK.php") ;
	include_once("../web/VERSION_KEEP.php") ;
	include_once("$DOCUMENT_ROOT/API/sql.php" ) ;
	include_once("$DOCUMENT_ROOT/API/Users/get.php") ;
	include_once("$DOCUMENT_ROOT/API/Users/put.php") ;
	include_once("$DOCUMENT_ROOT/API/Users/remove.php") ;
	include_once("$DOCUMENT_ROOT/API/Users/update.php") ;
	include_once("$DOCUMENT_ROOT/API/ASP/get.php") ;
	$section = 1;			// Section number - see header.php for list of section numbers

	// This is used in footer.php and it places a layer in the menu area when you are in
	// a section > 0 to provide navigation back.
	// This is currently set as a javascript back, but it could be replaced with explicit
	// links as using the javascript back button can cause problems after submitting a form
	// (cause the data to get resubmitted)
	$nav_line = '<a href="options.php" class="nav">:: Home</a>';

	// initialize
	$action = $error = $deptid = $edit_exp_value = $edit_exp_word = "" ;

	if ( preg_match( "/(MSIE)|(Gecko)/", $_SERVER['HTTP_USER_AGENT'] ) )
		$text_width = "20" ;
	else
		$text_width = "10" ;

	$success = $close_window = 0 ;

	$timespan_select = ARRAY( 1=>"Days", 2=>"Months", 3=>"Years" ) ;

	// get variables
	if ( isset( $_POST['action'] ) ) { $action = $_POST['action'] ; }
	if ( isset( $_GET['action'] ) ) { $action = $_GET['action'] ; }
	if ( isset( $_GET['deptid'] ) ) { $deptid = $_GET['deptid'] ; }
	if ( isset( $_POST['deptid'] ) ) { $deptid = $_POST['deptid'] ; }

	// conditions

	if ( $action == "add_dept" )
	{
		$aspinfo = AdminASP_get_UserInfo( $dbh, $session_setup['aspID'] ) ;
		$total_departments = AdminUsers_get_TotalDepartments( $dbh, $session_setup['aspID'] ) ;
		
		// let's make sure they don't exceed their max departments
		if ( $total_departments <= $aspinfo['max_dept'] )
		{
			if ( !$deptid && ( $total_departments == $aspinfo['max_dept'] ) )
				$error = "Your MAX department limit has been reached!  Department COULD NOT be added." ;
			else
			{
				$initiate_chat = ( isset( $_POST['initiate_chat'] ) ) ? $_POST['initiate_chat'] : 0 ;
				$visible = ( isset( $_POST['visible'] ) ) ? $_POST['visible'] : 0 ;
				if ( AdminUsers_put_department( $dbh, $deptid, $_POST['name'], $visible, $_POST['email'], $_POST['save_transcripts'], $_POST['share_transcripts'], $_POST['email_trans'],  $_POST['exp_value'], $_POST['exp_word'], $_POST['show_que'], $session_setup['aspID'], $initiate_chat, $LANG['CHAT_GREETING'], $_POST['use_in_tickets'], $_POST['sort_order'] ) )
				{
					$deptid = "" ;
					$success = 1 ;
				}
				else
					$error = "Error: ".$dbh['error'] ;
			}
		}
		else
			$error = "Your MAX department limit has been reached!  Department COULD NOT be added." ;
	}

	if ( $deptid )
	{
		$edit_dept = AdminUsers_get_DeptInfo( $dbh, $deptid, $session_setup['aspID'] ) ;
		LIST( $edit_exp_value, $edit_exp_word ) = explode( "<:>", $edit_dept['transcript_expire_string'] ) ;
	}

	$departments = AdminUsers_get_AllDepartments( $dbh, $session_setup['aspID'], 1 ) ;
?>
<?php include_once("./header.php"); ?>
<script language="JavaScript">
<!--
	function do_update_dept()
	{
		if ( ( document.dept.name.value == "" ) || ( document.dept.email.value == "" ) )
			alert( "All fields must be supplied." ) ;
		else
			document.dept.submit() ;
	}

	function do_delete( deptid )
	{
		window.open("adddept_rm.php?action=confirm_delete&deptid="+deptid, 'Confirm', 'scrollbars=no,menubar=no,resizable=0,location=no,width=350,height=250') ;
	}

	function do_alert()
	{
		if( <?php echo $success ?> )
			alert( 'Success!' ) ;
		if( <?php echo $close_window ?> )
		{
			opener.window.location.href = "adddept.php?s=1" ;
			window.close() ;
		}
	}

	function open_help( action )
	{
		url = "<?php echo $BASE_URL ?>/help.php?action=" + action ;
		newwin = window.open(url, "help", "scrollbars=yes,menubar=no,resizable=1,location=no,width=350,height=250") ;
		newwin.focus() ;
	}
//-->
</script>
<!-- DO NOT REMOVE THE COPYRIGHT NOTICE OF "&nbsp; OSI Codes Inc." -->
<!-- copyright OSI Codes, http://www.osicodes.com [DO NOT DELETE] -->
<table width="100%" border="0" cellspacing="0" cellpadding="15">
<tr> 
  <td><p><span class="title">Manager: Create/Edit Department</span><br>
	 Create, edit or delete your company departments. <?php echo ( isset( $success ) && $success ) ? "<font color=\"#29C029\"><big><b>Update Success!</b></big></font>" : "" ?></p>
	<ul>
	  <li> The <i>department email</i> is where the messages will delivered 
		on the "Leave a Message Form" when operators are not available. 
	  </li>
	</ul>
	<font color="#FF0000"><?php echo $error ?></font>
	<table width="420" border=0 cellpadding=3 cellspacing=1>
	  <form method="POST" action="adddept.php" name="dept">
		<input type="hidden" name="action" value="add_dept">
		<input type="hidden" name="deptid" value="<?php echo $deptid ?>">
		<tr> 
		  <td width="157">Department name</td>
		  <td width="286"><input type="text" name="name" size="<?php echo $text_width ?>" maxlength="150" value="<?php echo isset( $edit_dept['name'] ) ? stripslashes( $edit_dept['name'] ) : "" ?>"></td>
		</tr>
		<tr> 
		  <td>Department email </td>
		  <td><input type="text" name="email" size="<?php echo $text_width ?>" maxlength="150" value="<?php echo isset( $edit_dept['email'] ) ? $edit_dept['email'] : "" ?>"></td>
		</tr>
		<!-- v2.5.1 forward, transcripts will be saved automatically -->
		<input type="hidden" name="save_transcripts" value="1">
		<?php if ( $INITIATE && file_exists( "$DOCUMENT_ROOT/admin/traffic/admin_puller.php" ) ): ?>
		<tr> 
		  <td>Visible to public </td>
		  <td>
			  <?php echo ( ( isset( $edit_dept['visible'] ) && $edit_dept['visible'] ) || !isset( $edit_dept['visible'] ) ) ? "<input type=radio name=visible value=1 checked> Yes &nbsp; <input type=radio name=visible value=0> No" : "<input type=radio name=visible value=1> Yes &nbsp; <input type=radio name=visible value=0 checked> No" ?> &nbsp; <small>[ <a href="JavaScript:open_help( 'visible' )">? help</a> ]</td>
		</tr>
		<?php else: ?>
		<input type="hidden" name="visible" value="1">
		<?php endif ; ?>
		<tr>
		  <td> Display chat queue</td>
		  <td>
			  <?php echo ( ( isset( $edit_dept['show_que'] ) && $edit_dept['show_que'] ) || !isset( $edit_dept['show_que'] ) ) ? "<input type=radio name=show_que value=1 checked> Yes &nbsp; <input type=radio name=show_que value=0> No" : "<input type=radio name=show_que value=1> Yes &nbsp; <input type=radio name=show_que value=0 checked> No" ?> &nbsp; <small>[ <a href="JavaScript:open_help( 'show_que' )">? help</a> ]</td>
		</tr>
		<tr>
		  <td>Share saved transcripts </td>
		  <td>
			  <?php echo ( ( isset( $edit_dept['transcript_share'] ) && $edit_dept['transcript_share'] ) || !isset( $edit_dept['transcript_share'] ) ) ? "<input type=radio name=share_transcripts value=1 checked> Yes &nbsp; <input type=radio name=share_transcripts value=0> No" : "<input type=radio name=share_transcripts value=1> Yes &nbsp; <input type=radio name=share_transcripts value=0 checked> No" ?> &nbsp; <small>[ <a href="JavaScript:open_help( 'share_transcripts' )">? help</a> ]</td>
		</tr>
		<tr> 
		  <td>Transcripts expire after </td>
		  <td> <input type="text" name="exp_value" size=2 maxlength=3 value="<?php echo $edit_exp_value ?>" onKeyPress="return numbersonly(event)"> 
			<select name="exp_word">
			  <?php
					while ( LIST( $option_value, $option_string ) = EACH( $timespan_select ) )
					{
						$selected = "" ;
						if ( $option_value == $edit_exp_word )
							$selected = "selected" ;

						print "					<option value=\"$option_value\" $selected>$option_string</option>\n" ;
					}

					// reset it so we can use again below
					reset( $timespan_select ) ;
				?>
			</select> </td>
		</tr>
		<tr>
		  <td>Visitor email transcripts </td>
		  <td>
			  <?php echo ( ( isset( $edit_dept['email_trans'] ) && $edit_dept['email_trans'] ) || !isset( $edit_dept['email_trans'] ) ) ? "<input type=radio name=email_trans value=1 checked> Yes &nbsp; <input type=radio name=email_trans value=0> No" : "<input type=radio name=email_trans value=1> Yes &nbsp; <input type=radio name=email_trans value=0 checked> No" ?></select> &nbsp; <small>[ <a href="JavaScript:open_help( 'email_transcripts' )">? help</a> ]
		</tr>
		<?php if ( $INITIATE && file_exists( "$DOCUMENT_ROOT/admin/traffic/admin_puller.php" ) ): ?>
		<tr>
		  <td>Operator traffic monitor </td>
		  <td>
				<?php echo ( ( isset( $edit_dept['initiate_chat'] ) && $edit_dept['initiate_chat'] ) || !isset( $edit_dept['initiate_chat'] ) ) ? "<input type=radio name=initiate_chat value=1 checked> Yes &nbsp; <input type=radio name=initiate_chat value=0> No" : "<input type=radio name=initiate_chat value=1> Yes &nbsp; <input type=radio name=initiate_chat value=0 checked> No" ?> &nbsp; <small>[ <a href="JavaScript:open_help( 'traffic_monitor' )">? help</a> ]</td>
		</tr>
		<?php endif ; ?>
        <tr>
		  <td>Use for Tickets System? </td>
		  <td>
          <select name="use_in_tickets" id="use_in_tickets">
            <option value="0" <? if ( $edit_dept['use_in_tickets'] == 0 ) { ?>selected="selected" <? } ?>>No</option>
            <option value="1" <? if ( $edit_dept['use_in_tickets'] == 1 ) { ?>selected="selected" <? } ?>>Yes</option>
          </select>
		  </td>	
		</tr>
        <tr>
		  <td>Sort Department </td>
		  <td>
          <select name="sort_order" id="sort_order">            
		  <? for ($i = 1; $i <= count($departments); $i++) { ?>
            <option value="<? echo $i ?>" <? if ( $edit_dept['sort_order'] == $i ) { ?>selected="selected" <? } ?>><? echo $i ?></option>
          <? } ?>  
          </select>
		  </td>	
		</tr>
		<tr> 
		  <td>&nbsp; </td>
		  <td><input type="button" class="mainButton" onClick="javaScript:do_update_dept()" value="Submit"></td>
		</tr>
	  </form>
	</table></td>
    
    
    
  <td style="background-image: url(../images/g_manage_big.jpg);background-repeat: no-repeat;"><img src="../images/spacer.gif" width="229" height="1"></td>
</tr>
<tr> 
  <td colspan="2">
  
	<table cellspacing=1 cellpadding=2 border=0 width="100%">
		<?php
			for ( $c = 0; $c < count( $departments ); ++$c )
			{
				$department = $departments[$c] ;
				$dept_name = stripslashes( $department['name'] ) ;

				$transcripts_share = "No" ;
				$transcripts_share_bg = "#FFE8E8" ;
				if ( $department['transcript_share'] )
				{
					$transcripts_share_bg = "#FFFFFF" ;
					$transcripts_share = "Yes" ;
				}
				$initiate_chat = "No" ;
				$initiate_chat_bg = "#FFE8E8" ;
				if ( $department['initiate_chat'] )
				{
					$initiate_chat_bg = "#FFFFFF" ;
					$initiate_chat = "Yes" ;
				}
				$email_trans_string = "No" ;
				$email_trans_bg = "#FFE8E8" ;
				if ( $department['email_trans'] )
				{
					$email_trans_bg = "#FFFFFF" ;
					$email_trans_string = "Yes" ;
				}
				$public_visible = "No" ;
				$public_visible_bg = "#FFE8E8" ;
				if ( $department['visible'] )
				{
					$public_visible_bg = "#FFFFFF" ;
					$public_visible = "Yes" ;
				}
				$show_que = "No" ;
				$show_que_bg = "#FFE8E8" ;
				if ( $department['show_que'] )
				{
					$show_que_bg = "#FFFFFF" ;
					$show_que = "Yes" ;
				}

				$initiate_column = "" ;
				$initiate_option = "" ;
				if ( $INITIATE  )
				{
					$initiate_option = "<th align=\"left\">Traffic Monitor</th>" ;
					$initiate_column = "<td bgColor=\"$initiate_chat_bg\">$initiate_chat</td>" ;
				}
				$visible_column = "" ;
				$visible_option = "" ;
				if ( $INITIATE )
				{
					$visible_option = "<th align=\"left\">Visible</th>" ;
					$visible_column = "<td bgColor=\"$public_visible_bg\">$public_visible</td>" ;
				}

				LIST ( $expire_value, $expire_string ) = explode( "<:>", $department['transcript_expire_string'] ) ;

				$delete_string = "" ;
				if ( count( $departments ) > 1 )
					$delete_string = "| <a href=\"JavaScript:do_delete( ".$department['deptID']." )\">delete</a>" ;

				print "
					<tr>
						<th align=\"left\">Department</th>
						$visible_option
						<th align=\"left\" width=\"150\">Email</th>
						<th align=\"left\">Share Transcripts</th>
						<th align=\"left\">Email Transcripts</th>
						$initiate_option
						<th>Show Queue</th>
					</tr>
					<tr class=\"altcolor1\">
						<td rowspan=\"2\">
							$dept_name<br>
							<a href=\"adddept.php?deptid=$department[deptID]\">edit</a> $delete_string
						</td>
						$visible_column
						<td><a href=\"mailto:$department[email]\">$department[email]</a></td>
						<td bgColor=\"$transcripts_share_bg\">$transcripts_share (expires: $expire_value $timespan_select[$expire_string])</td>
						<td bgColor=\"$email_trans_bg\">$email_trans_string</td>
						$initiate_column
						<td bgColor=\"$show_que_bg\">$show_que</td>
					</tr>
					<tr class=\"altcolor3\">
						<td colspan=8>
							<img src=\"../images/dot.gif\" width=5 height=6> <a href=\"dept_icons.php?deptid=$department[deptID]\" class=\"altLink\">dept chat icons</a> 
							&nbsp;&nbsp;
							<img src=\"../images/dot.gif\" width=5 height=6> <a href=\"dept.php?action=greeting&deptid=$department[deptID]\" class=\"altLink\">greeting</a> 
							&nbsp;&nbsp;
							<img src=\"../images/dot.gif\" width=5 height=6> <a href=\"dept.php?action=offline&deptid=$department[deptID]\" class=\"altLink\">offline message</a> 
							&nbsp;&nbsp;
							<!-- <img src=\"../images/dot.gif\" width=5 height=6> <a href=\"dept.php?action=away&deptid=$department[deptID]\" class=\"altLink\">away message</a> 
							&nbsp;&nbsp; -->
							<img src=\"../images/dot.gif\" width=5 height=6> <a href=\"dept.php?action=canned_responses&deptid=$department[deptID]\" class=\"altLink\">canned responses</a>
							&nbsp;&nbsp;
							<img src=\"../images/dot.gif\" width=5 height=6> <a href=\"dept.php?action=canned_commands&deptid=$department[deptID]\" class=\"altLink\">canned commands</a>
							&nbsp;&nbsp;
						</td>
					</tr>
					<tr> 
						<td height=\"5\" colspan=8 class=\"hdash2\"><img src=\"../images/spacer.gif\" width=\"1\" height=\"5\"></td>
					</tr>
				" ;
			}
		?>
		</table>
	</td>
</tr>
</table>
<?php include_once( "./footer.php" ) ; ?>

