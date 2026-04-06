<?
//Debbuger
require_once(ROOT_PATH . '/ck/process/debugger.php');
$dbug = new debugger();
//

require_once(ROOT_PATH . '/ck/process/classes.php');
require_once(ROOT_PATH . "/includes/mail/class-phpmailer.php");

function db_connect($db_name){
	global $conn_db;
	$conn_db->connect($db_name);	
}

function insert_error_log($type, $error){
	//echo $type . $error;
}

function mail_db() {
	db_connect('mail_db');
	/*
  global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_mails";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }
  */
}

function phone_db() {
  global $mysqli;
  $dbhost = "192.168.10.50"; 
  $dbuser = "dBUsEr"; 
  $dbpass = "xbjR2LCaPSReUY92"; 
  $dbname = "qstats";
  $mysqli = @mysql_pconnect($dbhost,$dbuser,$dbpass); 
   @mysql_select_db("$dbname",$mysqli); 
  if (mysql_errno()) {
     printf("Connect failed DB. %s\n", mysql_errno());
     exit();
   } 
   
}
//lines server
	
function sbolines_db() {
	
  db_connect('sbolines_db');	
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_live_odds";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/   
}

function qstats_db() {
  global $mysqli;
   $dbhost = "192.168.10.50"; 
  $dbuser = "dBUsEr"; 
  $dbpass = "xbjR2LCaPSReUY92"; 
  $dbname = "qstats";
  $mysqli = @mysql_pconnect($dbhost,$dbuser,$dbpass); 
   @mysql_select_db("$dbname",$mysqli); 
  if (mysql_errno()) {
     printf("Connect failed. %s\n", mysql_errno());
     exit();
   }
   
}

function processing_db() {
  
  db_connect('processing_db');
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_wu";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}
function clerk_db() {     

db_connect('clerk_db');
/*
  global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_clerks";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }
  
  */
}


function betting_db() {   
  
  db_connect('betting_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_betting";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/   
}

function tickets_db() {  
  
  db_connect('tickets_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_tickets";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/   
}

function accounting_db() {
	
  db_connect('accounting_db');	
	
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_accounting";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/ 
}
function livehelp_db() {
  
  db_connect('livehelp_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_livehelp";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}

function baseball_db() {
  
  db_connect('baseball_db');
  /*
  global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_baseball_file";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}

function mlb_db() {
  
  db_connect('mlb_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_mlb";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}

function nba_db() {
  
  db_connect('nba_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_nba";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}

function nhl_db() {
  
  db_connect('nhl_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_nhl";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}

function nfl_db() {
	
  db_connect('nfl_db');
  	
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_nfl";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}

function props_db() {
	
  db_connect('props_db');
  	
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_props";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}

function tweets_db() {
  
  db_connect('tweets_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_tweet";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}


function sbo_sports_db() {
  
  db_connect('sbo_sports_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_sports";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}

function sbo_seo_db() {
  
  db_connect('sbo_seo_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_seo";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}

function sbo_liveodds_db() {
 
  db_connect('sbo_liveodds_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_live_odds";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
   
}

function sbo_posting() {
 
 db_connect('sbo_posting');
 
 /*
  global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_posting";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
   
}

function inspinc_statsdb1() {
  
  db_connect('inspinc_statsdb1');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_inspinc_statsdb1";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}


function inspinc_tweetdb1() {
  
  db_connect('inspinc_tweetdb1');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_inspinc_tweetdb1";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}


function inspinc_insider() {
  global $mysqli;
  $dbhost = "192.168.10.130"; 
  $dbuser = "inspinc_inpadm1"; 
  $dbpass = "10sd14ft04"; 
  $dbname = "inspinc_myinspin";
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);
  mysqli_select_db($mysqli,"$dbname");  
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
   }
}

function affiliate_db() {  
  
  db_connect('affiliate_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_affiliates";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}

function sbo_book_db() {
  
  db_connect('sbo_book_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_book";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}	
function sbo_breaket_db() {
  
  db_connect('sbo_breaket_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_marchmadness";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
  
  
}

function tabs_db() {
  
  db_connect('tabs_db');
  
  /*global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_tabs";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }*/
}

function contains_ck($full,$search){
	$found = false;
	if(strlen(strstr($full,$search))>0){
		$found = true;	
	}
	return $found;	
}

function send_email_ck($email, $sub, $content, $html = false, $from = "support@vrbmarketing.com", $from_name = "VRB"){				
		$headers = 'From: '. $from_name . "<".$from."> \r\n" .
		'Reply-To: '. $from . "\r\n";
		if($html){$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";}
		$headers .= 'X-Mailer: PHP/' . phpversion();
		if (@mail($email, $sub, $content, $headers)) {} else {}						
}
function send_email_ck_auth($email, $sub, $content, $html = false, $from = "support@vrbmarketing.com", $from_name = "VRB"){				
				
		$mail = new PHPMailer();	
        $mail->From     = $from;
        $mail->FromName = $from_name;
        $mail->AddAddress($email, '');
        /*$mail->Username = 'support@vrbmarketing.com'; 
        $mail->Password = 'C=IlCEhNc.5)';
        $mail->Host     = 'cpanel02.vrbmarketing.com';*/
		$mail->Username = 'vrb.emailalert@gmail.com';
        $mail->Password = 'buwl qxyf iocm lzqw';
        $mail->Host     = 'smtp.gmail.com';		
        $mail->Mailer   = 'smtp';
        $mail->IsHTML($html);
			
        if($mail->Mailer == 'smtp') {
          $mail->SMTPAuth = true;
        }
					
        $mail->Subject = $sub;  			
        $mail->Body = stripslashes($content);
        $mail->Send();				
}
function clean_str_ck($str) {	
  clerk_db();
  $str = xss($str);
  $str = escapeString($str);

  return $str;  
}

//
function escapeString($string) { 
    $escapedString = addslashes($string);
    return $escapedString;
}

function xss($data){
	// Fix &entity\n;
	$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data );
	$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');	
	
	// Remove any attribute starting with "on" or xmlns
	$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
	
	// Remove javascript: and vbscript: protocols
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
	
	// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
	
	// Remove namespaced elements (we do not need them)
	$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
	
	do
	{
			// Remove really unwanted tags
			$old_data = $data;
			$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	}
	while ($old_data !== $data);
	
	// we are done...
	return $data;
}
function get_error_ck($id){
	$error_messages[0] = "The list has been created. You can Upload names now.";
	$error_messages[1] = "There was a problem with the CSV File, Please try it again.";
	$error_messages[2] = "The Names has been Updated.";
	$error_messages[3] = "Status Updated.";
	$error_messages[4] = "The list has been Updated.";
	$error_messages[5] = "You don't have permission to edit this user.";
	$error_messages[6] = "The User has been Updated.";
	$error_messages[7] = "The User has been created.";
	$error_messages[8] = "The Name has been Updated.";
	$error_messages[9] = "You are not allowed to call this person.";
	$error_messages[10] = "The call has been finished and has been successfully stored.";
	$error_messages[11] = "Rule Deleted.";
	$error_messages[12] = "The Rule has been Updated.";
	$error_messages[13] = "The Rule has been Saved.";
	$error_messages[14] = "The Message has been sent.";
	$error_messages[15] = "No Names Available, Please Contact Admin.";
	$error_messages[16] = "Lists Updated.";
	$error_messages[17] = "The Websites has been Uploaded.";
	$error_messages[18] = "The Website has been Updated.";
	$error_messages[19] = "The Settings has been Updated.";
	$error_messages[20] = "Group has been Created.";
	$error_messages[21] = "Group has been Updated.";
	$error_messages[22] = "The Clerk you're trying to transfer the call is busy in this moment.";
	$error_messages[23] = "The transfer has been denied.";
	$error_messages[24] = "The transfer was successful.";
	$error_messages[25] = "Transfer Denied.";
	$error_messages[26] = "The Clerk you're trying to transfer the call didn't reply.";
	$error_messages[27] = "Transfer is not longer available.";
	$error_messages[28] = "Deposit Sent.";
	$error_messages[29] = "Transaction Added.";
	$error_messages[30] = "Transaction Updated.";
	$error_messages[31] = "There are no Lead Names Available at this moment.";
	$error_messages[32] = "Lead Name Updated.";
	$error_messages[33] = "Lead Name has been moved to Limbo.";
	$error_messages[34] = "Lead Name has been moved to Fronters.";
	$error_messages[35] = "Clerk Updated.";
	$error_messages[36] = "Lead Names Updated.";
	$error_messages[37] = "Message Restored.";
	$error_messages[38] = "Logouts Updated.";
	$error_messages[39] = "The Account has been Saved";
	$error_messages[40] = "The Identifier has been Saved";
	$error_messages[41] = "The Agent has been Saved";
	$error_messages[42] = "Games has been Graded";
	$error_messages[43] = "Transaction has been Stored";
	$error_messages[44] = "Bet has been Stored";
	$error_messages[45] = "Commission has beed Stored";
	$error_messages[46] = "The Category has been Saved";
	$error_messages[47] = "The Expense has been Saved";
	$error_messages[48] = "Fees has been Saved";
	$error_messages[49] = "Player Inserted";
	$error_messages[50] = "Percentages Inserted";
	$error_messages[51] = "Bank Account Inserted";
	$error_messages[52] = "The Comment has been Saved";
	$error_messages[53] = "The Transaction has been Accepted";
	$error_messages[54] = "The Transaction has been Canceled";
	$error_messages[55] = "The Bill has been Inserted";
	$error_messages[56] = "The FreePlay Amount has been Inserted";
	$error_messages[57] = "The Adjustment has been Inserted";
	$error_messages[58] = "The Goal has been Saved";
	$error_messages[59] = "Player has been Saved";
	$error_messages[60] = "Picks has been Saved";
	$error_messages[61] = "Error! Account already exist on the System";
	$error_messages[62] = "Ticket has been saved";
	$error_messages[63] = "Picks has been Deleted";
	$error_messages[64] = "The Deposit has been Saved";
	$error_messages[65] = "Picks has been graded";
	$error_messages[66] = "File has been uploaded";
	$error_messages[67] = "Settings has been Updated";
	$error_messages[68] = "Payout has been inserted";
	$error_messages[69] = "Player do not exist";
	$error_messages[70] = "Expense Inserted";
	$error_messages[71] = "There was a problem updating the information<br />";
	$error_messages[72] = "Information Updated";
	$error_messages[73] = "Name was Added to the Durango List";
	$error_messages[74] = "Lead has been updated";
	$error_messages[75] = "Lead has been created";
	$error_messages[76] = "Moneypak has been changed";
	$error_messages[77] = "Payout is ready to be processed";
	$error_messages[78] = "Method type has been changed";
	$error_messages[79] = "The account has been removed from the list";
	$error_messages[80] = "The account has been added to the list";
	$error_messages[81] = "Payout has been rejected.";
	$error_messages[82] = "Entry was inserted.";
	$error_messages[83] = "Lead has been deleted.";
	$error_messages[84] = "Payout Question has been created.";
	$error_messages[85] = "Payout Question has been deleted.";
	$error_messages[86] = "Schedule was updated.";
	$error_messages[87] = "Keyword has been Updated.";
	$error_messages[88] = "Keyword has been Added.";
	$error_messages[89] = "This User is not a valid Twiter User.";
	$error_messages[90] = "The information was copy successfully";
	$error_messages[91] = "Your Password has been Updated";
	$error_messages[92] = "Wrong Authorization Code";
	$error_messages[93] = "Bonuses has been updated";
	$error_messages[94] = "Account has been deleted";
	$error_messages[95] = "Access has been updated";
	$error_messages[96] = "Ticket was inserted";
	$error_messages[97] = "Group has been deleted.";
	$error_messages[98] = "Group has been paid.";
	$error_messages[99] = "Group has been unpaid.";
	$error_messages[100] = "Account has been added.";
	$error_messages[101] = "Account has been deleted.";
	$error_messages[102] = "Manual Payment inserted successfully";	
	$error_messages[103] = "The twitter member has been added.";
	$error_messages[104] = "The twitter member has been updated.";
	$error_messages[105] = "The twitter member already exist in the system.";
	
	return $error_messages[$id];
}
function clean_get($name, $is_get = false){
	$result = "";
	if($is_get){
		$result = clean_str_ck($_GET[$name]);
	}else{
		$result = clean_str_ck($_POST[$name]);
	}
	return $result;
}
function post_get($name, $def = ""){
	$res = $_POST[$name];
	if($res==""){$res = $_GET[$name];}
	if($res==""){$res = $def;}
	return $res;
}
function upload_file($id, $path, $name = ""){
	if (!empty($_FILES[$id]['name'])) {
		if($name != ""){$filename = $name . strrchr(basename($_FILES[$id]['name']),'.');}else{$filename = basename($_FILES[$id]['name']);}		  
		$filepath = $path;
		$filefull = $filepath.$filename; 
		if (!move_uploaded_file($_FILES[$id]['tmp_name'], $filefull))
		echo '<strong>An error occurred uploading the File... please check the file name and its extension and try again.</strong>';
	}
	
	return $filename;
}
function clean_chars($str){
	$str = str_replace("'","",$str);
	$str = str_replace('"',"",$str);
	return $str;
}
function no_skype($number){
	$middle = '<span style="display:none">no_skype</span>';
	$half = (int) ( (strlen($number) / 2) );
	$left = substr($number, 0, $half);
	$right = substr($number, $half);
	return $left.$middle.$right;
}
function text_preview($text, $num, $tags = ''){
	$text = strip_tags($text,$tags);
	if(strlen($text) > $num){
		$text = substr($text,0,$num) . "...";
	}
	return $text;
}
function sort_object($al, $bl, $type = "ASC"){	
	$al = strtolower($al);
	$bl = strtolower($bl);
	if ($al == $bl) {
		return 0;
	}	
	if($type == "DESC"){$result = ($al < $bl) ? +1 : -1;}
	else{$result = ($al > $bl) ? +1 : -1;}
	
	return $result;
}

function get_all_week_days(){
	return array("mon","tue","wed","thu","fri","sat","sun");
}
function get_all_hours(){
	return array("01","02","03","04","05","06","07","08","09","10","11","12");
}
function get_all_minutes(){
	return array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15",
	             "16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31",
				 "32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47", 
	             "48","49","50","51","52","53","54","55","56","57","58","59");
}


function time_diff($s){ 
    $m=0;$hr=0;$d=0;$td=$s." sec"; 
    if($s>59) { 
        $m = (int)($s/60); 
        $s = $s-($m*60); // sec left over 
        $td = "$m min"; 
    } 
    if($m>59){ 
        $hr = (int)($m/60); 
        $m = $m-($hr*60); // min left over 
        $td = "$hr hr"; if($hr>1) $td .= "s"; 
        if($m>0) $td .= ", $m min"; 
    } 
    if($hr>23){ 
        $d = (int)($hr/24); 
        $hr = $hr-($d*24); // hr left over 
        $td = "$d day"; if($d>1) $td .= "s"; 
        if($d<3){ 
            if($hr>0) $td .= ", $hr hr"; if($hr>1) $td .= "s"; 
        } 
    } 
    return $td; 
}
function format_phone($number){
	if(strlen($number)>8){
		$fisrt = substr($number,0,3);
		$second = 	substr($number,3,3);
		$third = substr($number,6);
		$result = "($fisrt) $second-$third";
	}else{
		$result = $number;	
	}
	return $result;
}
function clean_phone($number){
	$number  = str_replace(" ","",$number);
	$number  = str_replace(".","",$number);
	$number  = str_replace("+","",$number);
	$number  = str_replace("-","",$number);
	$number  = str_replace("-","",$number);
	$number  = str_replace("(","",$number);
	$number  = str_replace(")","",$number);
	return $number;
}
function null_date($date){
	if($date == "0000-00-00 00:00:00"){$date = "";}
	return $date;
}
function get_week_day($fecha){
    $fecha=str_replace("/","-",$fecha);
    list($dia,$mes,$anio)=explode("-",$fecha);
    return (((mktime ( 0, 0, 0, $mes, $dia, $anio) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
}
function user_log($out = false){
	global $current_clerk;
	$log = new time_log();
	$log->vars["user"] = $current_clerk->vars["id"];
	$log->vars["ip"] = $_SERVER['REMOTE_ADDR'];
	$log->vars["computer"] = md5($_SERVER['HTTP_USER_AGENT']);
	$log->vars["date"] = gmdate("Y-m-d H:i:s",time()-(6*60*60));
	if($out){
		$log->vars["out"] = 1;
		$log->insert();
	}else{
		if(!$log->already_in()){$log->insert();}
	}
}
function sec2hms ($sec, $padHours = false, $text = false) {
	if($text){
		$htext = " hours, ";
		$mtext = " minutes and ";
		$stext = " seconds";	
	}else{
		$htext = ":";
		$mtext = ":";
		$stext = "";
	}
    $hms = "";
    $hours = intval(intval($sec) / 3600); 
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
          : $hours. "$htext";
    $minutes = intval(($sec / 60) % 60); 
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). "$mtext";
    $seconds = intval($sec % 60); 
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT). "$stext";
    return $hms;
    
}
function biencript($str, $desc = false){
	if(!$desc){
		$result = bin2hex($str);
		$result = str_replace("d","y",$result);
		$result = str_replace("1","X",$result);
		$result = str_replace("7","p",$result);
		$result = str_replace("3","S",$result);
	}
	else{
		$str = str_replace("y","d",$str);
		$str = str_replace("X","1",$str);
		$str = str_replace("p","7",$str);
		$str = str_replace("S","3",$str);
		$result = hex_to_str($str);
	}
	return $result;
}
function hex_to_str($hex){
	$str='';
	for ($i=0; $i < strlen($hex)-1; $i+=2){
		$str .= chr(hexdec($hex[$i].$hex[$i+1]));
	}
	return $str;
}
function split_line($line){
	$line = strtolower(trim($line));
	$line = str_replace("ev","-100",$line);	
	$first = substr($line,0,1);
	$rest = substr($line,1);
	
	if(contains_ck($rest,"-")){
		$parts = explode("-",$rest);
		$parts[0] = $first.$parts[0];
		$parts[1] = "-".$parts[1];
	}else if(contains_ck($rest,"+")){
		$parts = explode("+",$rest);
		$parts[0] = $first.$parts[0];
		$parts[1] = "+".$parts[1];
	}else{
		$parts = array($first.$rest);
	}
	return $parts;
}
function prepare_line($line){
	$line = strtolower($line);
	$line = str_replace("under","",$line);
	$line = str_replace("over","",$line);
	$line = str_replace("un","",$line);
	$line = str_replace("ov","",$line);
	$line = str_replace("u","",$line);
	$line = str_replace("o","",$line);
	$line = trim($line);
	$parts = split_line($line);
	$line = $parts[0];
	$juice = $parts[1];
	if(count($parts)==1){$juice = $line; $line = "";}
	return array("line"=>$line,"juice"=>$juice);
}
function ck_curl() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


function get_day_diff($date1,$date2){
	
   $dStart = new DateTime($date1);
   $dEnd  = new DateTime($date2);
   $dDiff = $dStart->diff($dEnd);
 
   return $dDiff->days;
}



function get_monday($date, $format = "Y-m-d", $next = false){
	$days = (date("N",strtotime($date)))-1;
	$monday = date($format,strtotime($date . "- $days days"));
	if($next){$monday = date($format,strtotime($monday . "+ 7 days"));}
	return $monday;
}

function basic_number_format($number){
	if(is_numeric($number)){
		if($number<0){$color = "900";
		}else{$color = "000";}
		return '<span style="color:#'.$color.'">'.number_format($number,2,"."," ").'</span>';
	}else{
		return $number;	
	}
}

function echo_report_number($number, $link = false, $url = "", $w = "", $h = ""){
	if($number<0){
		$color = "900";		
	}else if($number>0){
		$color = "069";	
	}else{
		$color = "000";
		$link = false;	
	}
	if($link){
		echo '<a style="color:#'.$color.'; text-decoration:underline;" href="'.$url.'" rel="shadowbox;height='.$h.';width='.$w.'">'.$number.'</a>';
	}else{
		echo '<span style="color:#'.$color.'">'.$number.'</span>';	
	}
}

function cut_text($text, $num){
	if(strlen($text) > $num){
		$text = substr($text,0,$num) . "...";
	}
	return $text;
}

function get_city_time($city, $state){
	
  if ($city!="" && $state !="" ){
	  $city = str_replace(" ","_",trim($city));
	  $state = trim($state);
	  $data = str_replace(" ","",@file_get_contents("http://www.worldtimeserver.com/current_time_in_US-$state.aspx?city=$city"));
	  $pos = strpos($data,'font7">');
	  $time = substr($data,$pos+9,6);
	if(!contains_ck($time,":")/* && !contains_ck($time,"AM")*/){
		$time = "N/A";
	}
	}
	return $time;
	
}

function get_str_states_by_list($lid){
	$sts = get_states_by_geo_list($lid);
	$states = array();
	foreach($sts as $st){$states[] = $st["state"];}
	$str = "";
	if(count($states)>0){
		$str = "'".implode("','",$states)."'";
	}
	return $str;
}

function get_CRM_available_states($string = false){
	$day = date("N");
	if($day == "6" || $day == "7"){
		$from = strtotime("9:00 AM");
		$to = strtotime("8:00 PM");
	}else{
		$from = strtotime("11:59 AM");
		$to = strtotime("8:00 PM");
	}
	
	$times = array();
	$states = array();
	$available = array();
	$zones = array("ET","CT","MT","MST","PT","AKT","HT");	
	
	date_default_timezone_set('America/New_York');
	$times["ET"] = (date("h:i:s A"));
	
	date_default_timezone_set('America/Chicago');
	$times["CT"] = (date("h:i:s A"));
	
	date_default_timezone_set('America/Denver');
	$times["MT"] = (date("h:i:s A"));
	
	date_default_timezone_set('America/Phoenix');
	$times["MST"] = (date("h:i:s A"));
	
	date_default_timezone_set('America/Los_Angeles');
	$times["PT"] = (date("h:i:s A"));
	
	date_default_timezone_set('America/Juneau');
	$times["AKT"] = (date("h:i:s A"));
	
	date_default_timezone_set('Pacific/Honolulu');
	$times["HT"] = (date("h:i:s A"));
	
	$states["ET"] = array("ME","NH","VT","MA","RI","CT","NY","NJ","PA","MD","DE","DC","VA","WV","OH","MI","SC","GA","FL","IN");
	$states["CT"] = array("TX","LA","AL","MS","AR","TN","KY","OK","MO","KS","IL","IA","NE","SD","ND","MN","WI");
	$states["MT"] = array("MT","WY","ID","UT","CO","NM");
	$states["MST"] = array("AZ");
	$states["PT"] = array("WA","OR","NV","CA");
	$states["AKT"] = array("AK");
	$states["HT"] = array("HI");
	
	date_default_timezone_set('America/New_York');
	
	foreach($zones as $zn){
		$ztime = strtotime($times[$zn]);
		if(($ztime >= $from && $ztime <= $to) || !is_numeric($ztime)){
			$available = array_merge($available, $states[$zn]);
		}
	}
	
	if($string){
		return array(
				"available"=>"'".implode("','",$available)."'",
				"all"=>"'".implode("','",array_merge($states["ET"],
							$states["CT"],
							$states["MT"],
							$states["MST"],
							$states["PT"],
							$states["AKT"],
							$states["HT"]
						))."'"
			);
	}else{
		return array(
				"available"=>$available,
				"all"=>array_merge($states["ET"],
							$states["CT"],
							$states["MT"],
							$states["MST"],
							$states["PT"],
							$states["AKT"],
							$states["HT"]
						)
			);
	}
	
	
	
}


function string_to_ascii($string)
{
    $ascii = NULL;
 
    for ($i = 0; $i < strlen($string); $i++) 
    { 
    	$ascii += ord($string[$i]); 
    }
	 
    return($ascii);
}

function get_ticket_id($pass){
	$parts = explode("O",biencript($pass,true));
	return $parts[1];
}

function small_text($text, $num){
	if(strlen($text) > $num){
		$text = substr($text,0,$num) . "...";
	}
	return $text;
}

function get_alternative_period($period){
	$period = strtolower($period);
	if(contains_ck($period,"1st") || contains_ck($period,"2nd") || contains_ck($period,"3rd") || contains_ck($period,"4th")){
		$period = str_replace("1st","1",$period);
		$period = str_replace("2nd","2",$period);
		$period = str_replace("3rd","3",$period);
		$period = str_replace("4th","4",$period);
	}else{
		$period = str_replace("1","1st",$period);
		$period = str_replace("2","2nd",$period);
		$period = str_replace("3","3rd",$period);
		$period = str_replace("4","4th",$period);
	}
	return $period;
}
function two_way_enc($str, $desc = false){
	if(!$desc){
		$result = bin2hex($str);
		$result = str_replace("d","y",$result);
		$result = str_replace("1","X",$result);
		$result = str_replace("7","p",$result);
		$result = str_replace("3","S",$result);
	}
	else{
		$str = str_replace("y","d",$str);
		$str = str_replace("X","1",$str);
		$str = str_replace("p","7",$str);
		$str = str_replace("S","3",$str);
		$result = hextostr2($str);
	}
	return $result;
}
function super_encript($str){
	$result = bin2hex($str);
	$result = str_replace("1","!",$result);
	$result = str_replace("2","@",$result);
	$result = str_replace("3","*",$result);
	$result = str_replace("4","Y",$result);
	$result = str_replace("5","X",$result);
	$result = str_replace("6","S",$result);
	$result = str_replace("7","p",$result);
	$result = str_replace("8","_",$result);
	$result = str_replace("9","-",$result);
	$result = str_replace("0","$",$result);
	$result = str_replace("a","7",$result);
	$result = str_replace("b","1",$result);
	$result = str_replace("c","4",$result);
	$result = str_replace("d","2",$result);
	$result = str_replace("e","9",$result);
	$result = str_replace("f","8",$result);	
	return  md5($result);
}
function aff_two_way_encript($str, $desc = false){
	if(!$desc){
		$result = bin2hex($str);
		$result = str_replace("d","yxAx",$result);
		$result = str_replace("1","XxAx",$result);
		$result = str_replace("7","pxAx",$result);
		$result = str_replace("3","SxAx",$result);
	}
	else{
		$str = str_replace("yxAx","d",$str);
		$str = str_replace("XxAx","1",$str);
		$str = str_replace("pxAx","7",$str);
		$str = str_replace("SxAx","3",$str);
		$result = hextostr2($str);
	}
	return $result;
}
function hextostr2($hex){
	$str='';
	for ($i=0; $i < strlen($hex)-1; $i+=2){
		$str .= chr(hexdec($hex[$i].$hex[$i+1]));
	}
	return $str;
}
function do_post_request($url, $data){
	$postdata = http_build_query($data);
	$opts = array('http'=>array('method'=>'POST',
								'user_agent '  => "Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2) Gecko/20100301 Ubuntu/9.10 (karmic) Firefox/3.6",
								'header' => array(
													'Accept: text/html,application/xhtml+xml,application/x-www-form-urlencoded,application/xml;q=0.9,*\/*;q=0.8'
												), 
								'content' => $postdata));
	$context  = stream_context_create($opts);
	return @file_get_contents($url, false, $context);
}

function do_post_reques_utf($url, $data) {
    $postdata = http_build_query($data);
    $opts = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => array(
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'User-Agent: Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2) Gecko/20100301 Ubuntu/9.10 (karmic) Firefox/3.6'
            ),
            'content' => $postdata
        )
    );
    $context  = stream_context_create($opts);
    return @file_get_contents($url, false, $context);
}



//Threads
function open_thread($server, $url, $port=80,$conn_timeout=30, $rw_timeout=86400)
{
	$errno = '';
	$errstr = '';
	
	set_time_limit(0);
	
	$fp = fsockopen($server, $port, $errno, $errstr, $conn_timeout);
	if (!$fp) {
	   //echo "$errstr ($errno)<br />\n";
	   return false;
	}
	$out = "GET $url HTTP/1.1\r\n";
	$out .= "Host: $server\r\n";
	$out .= "Connection: Close\r\n\r\n";
	
	stream_set_blocking($fp, false);
	stream_set_timeout($fp, $rw_timeout);
	fwrite($fp, $out);
	
	return $fp;
}
function read_thread(&$fp) 
{
	if ($fp === false) return false;
	
	if (feof($fp)) {
		fclose($fp);
		$fp = false;
		return false;
	}
	
	return fread($fp, 10000);
}

function is_better_juice($bet, $book){
	if(is_numeric($bet) && is_numeric($book)){
		if($bet < 0){
			if(($book*-1) <= ($bet*-1) ){$better = true;}
			else{$better = false;}
		}else if($bet > 0){
			if($book >= $bet){$better = true;}
			else{$better = false;}
		}
	}
	return $better;
}
function send_pick_sms($pick, $gamestr){	
	
	if($pick!=""){
		
		$data = "?pick=$pick&gamestr=$gamestr";

		$result = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/bronto/send_pick_sms.php".$data);
		
		
		//$brt = new _bronto();	
		$content  = '3 Star Premium Pick: (';
		$content .= $gamestr.') ';
		$content .= $pick;
		//$result = $brt->send_sms('0bb904200000000000000000000000000052', $content);
		
		
		
		
		$message = $content . "<br /><br />" .$result;		
		
		/*send_email_ck("scott@vrbmarketing.com", "SMS sent", $message, true,"support@inspin.com", "Inspin.com");
    	send_email_ck("amcphail@vrbmarketing.com", "SMS sent", $message, true,"support@inspin.com", "Inspin.com");
		send_email_ck("skoot73@hotmail.com", "SMS sent", $message, true,"support@inspin.com", "Inspin.com");*/	
		send_email_ck("rarce@inspin.com", "SMS sent", $message, true,"support@inspin.com", "Inspin.com");
		send_email_ck("alexis.andrade@gmail.com", "SMS sent", $message, true,"support@inspin.com", "Inspin.com");			
	}
}

function is_mobile(){
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
		return true;
	}else{
		return false;
	}	
}

function str_boolean($data){
	if($data){
		$str = "True";
	}else{
		$str = "False";
	}
	return $str;
}

function yesno_boolean($data){
	if($data){
		$str = "Yes";
	}else{
		$str = "No";
	}
	return $str;
}

function f_download_files_to_server($path,$url,$arch) {
  // file handler
  $file = fopen($path.$arch, 'w');
  // cURL
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url.$arch);
  // set cURL options
  curl_setopt($ch, CURLOPT_FAILONERROR, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // set file handler option
  curl_setopt($ch, CURLOPT_FILE, $file);
  // execute cURL
  curl_exec($ch);
  // close cURL
  curl_close($ch);
  // close file
  fclose($file);    
}

function create_list($name, $id, $data, $selected = NULL, $onchange = "", $style = "", $default_name = ""){
	?>
	<select name="<? echo $name ?>" id="<? echo $id ?>" onchange="<? echo $onchange ?>" style=" <? echo $style ?> ">
    <? if($default_name != ""){ ?><option value=""><? echo $default_name ?></option><? } ?>
    	<? foreach($data as $item){ ?>
        	<option value="<? echo $item["id"] ?>" <? if($item["id"] == $selected){echo 'selected="selected"';} ?>><? echo $item["label"] ?></option>
        <? } ?>
    </select>
    <?
}
function create_objects_list($name, $id, $data, $idvar, $labvar, $default_name = "", $selected = NULL, $onchange = "", $class = ""){
	?>
	<select name="<? echo $name ?>" id="<? echo $id ?>" onchange="<? echo $onchange ?>" class="<? echo $class ?>">
    	<? if($default_name != ""){ ?><option value=""><? echo $default_name ?></option><? } ?>
    	<? foreach($data as $item){ ?>
        	<option value="<? echo $item->vars[$idvar] ?>" <? if($item->vars[$idvar] == $selected){echo 'selected="selected"';} ?>><? echo $item->vars[$labvar]?></option>
        <? } ?>
    </select>
    <?
}


function str_center($first, $second, $string){
	$exnum = strlen($first);
	$pos = strpos($string,$first);
	$pos2 = strpos($string,$second);
	$extra = substr($string,$pos2);	
	return str_replace($extra,"",substr($string,$pos+$exnum));
}

// Baseball_file //
function check_999_null($number){
	if($number == -999 || $number == -9999 || !is_numeric($number)){
		$number = 0;
	}
	return $number;
}

function clean_mysql_phone($name){
	return "REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE($name,')',''),'(',''),'/',''),'_',''),'.',''),' ',''),'-','')";
}

function get_zip_adrress($zip){
	$data = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$zip&sensor=false&language=en"));
	$address = array();
	$count = count($data->results[0]->address_components);
	$address["city"] = $data->results[0]->address_components[1]->short_name;
	$address["state"] = $data->results[0]->address_components[$count-2]->long_name;
	$address["state_short"] = $data->results[0]->address_components[$count-2]->short_name;
	$address["country"] = $data->results[0]->address_components[$count-1]->long_name;
	$address["country_short"] = $data->results[0]->address_components[$count-1]->short_name;
	return $address;
}

function get_minute_direfence($date,$minutes,$action){

if ($action == "+"){
$date = date( "Y-m-d H:i:s", strtotime( "+".$minutes." minutes", strtotime($date))); 
}
if ($action == "-"){
$date = date( "Y-m-d H:i:s", strtotime( "-".$minutes." minutes", strtotime($date))); 
}

return $date;

}

function ftp_audio_conecction(){
   /*$ftp_server = "192.168.10.50";
   $ftp_user = "monitor";
   $ftp_pass = "Gravaci0nes";
   //$ftp_user = "root";
   //$ftp_pass = "qazWSX!@#";

  
   $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server"); 
   $login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);
   ftp_pasv($conn_id, true);
   return $conn_id;*/
   
   $ftp_server = "192.168.10.50";
   $ftp_user = "appreccalls";
   $ftp_pass = "5cZs7Uh)Fw.rwN<h";
   $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server"); 
   $login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);
   return $conn_id;
   
}

function ftp_audio_close($conn_id){
  ftp_close($conn_id);	
}


function check_ftp_audio_exist($audio,$conn_id){

	$audio .= ".gsm";
	$res=0;
	$res = ftp_size($conn_id, $audio);
	
	if ($res >= 1) {
		return true;
	} else {
	    return false;
	}

}

function rec_page_log($code=3){
	
	global $current_clerk;
	$log = new ck_log();
	$log->vars["user"] = $current_clerk->vars["id"];
	$log->vars["ip"] =  $_SERVER['REMOTE_ADDR']; //  get_ip();//$_SERVER['REMOTE_ADDR'];
	$log->vars["date"] = date("Y-m-d H:i:s");
	$log->vars["fail"] = $code;
	$log->vars["data"] = str_replace("vrbmarketing.com","",ck_curl());
	$log->vars["data"] = str_replace(":443","",$log->vars["data"]);
	$log->vars["data"] = str_replace("www.","",$log->vars["data"]);
	$log->vars["data"] = str_replace("http://","",$log->vars["data"]);
	$log->vars["data"] = str_replace("https://","",$log->vars["data"]);
	$log->insert();
	
	
}

function rec_moneypak_log($data){ // Code 7
	global $current_clerk;
	$log = new ck_log();
	$log->vars["user"] = $current_clerk->vars["id"];
	$log->vars["ip"] = $_SERVER['REMOTE_ADDR'];;
	$log->vars["date"] = date("Y-m-d H:i:s");
	$log->vars["fail"] = 7;
	$log->vars["data"] = str_replace("vrbmarketing.com","",ck_curl());
	$log->vars["data"] = str_replace("www.","",$log->vars["data"]);
	$log->vars["data"] = str_replace("http://","",$log->vars["data"]);
	$log->vars["data"] .= "_".$data;
	$log->insert();
}





function num_text_encript($str, $desc = false){
	if($desc){
		$str = str_replace("VRBENC","",$str);
		$str = two_way_enc($str, true);
		$str = str_replace("!","P",$str);
		$str = str_replace("*","i",$str);
		$str = str_replace("_","y",$str);
		$str = str_replace(")","T",$str);
		$str = str_replace("$","r",$str);
		$str = str_replace("?","q",$str);
		$str = str_replace("%","a",$str);
		$str = str_replace("&","s",$str);
		$str = str_replace(":","V",$str);
		$str = str_replace(",","m",$str);
	}else{
		$str = str_replace("P","!",$str);
		$str = str_replace("i","*",$str);
		$str = str_replace("y","_",$str);
		$str = str_replace("T",")",$str);
		$str = str_replace("r","$",$str);
		$str = str_replace("q","?",$str);
		$str = str_replace("a","%",$str);
		$str = str_replace("s","&",$str);
		$str = str_replace("V",":",$str);
		$str = str_replace("m",",",$str);
		$str = two_way_enc($str)."VRBENC";	
	}
	
	return $str;
}

function num_two_way($str, $desc = false, $spliter = "/"){
	if($str != ""){
		$key = array();
		$key[0] = str_split("qETUoadgjl");
		$key[1] = str_split("plIJgyRDaw");
		$key[2] = str_split("MNbqwEASdL");
		$key[3] = str_split("PQOWieuryt");
		$key[4] = str_split("PLMOKIJnub");
		$key[5] = str_split("xcvbnMKJHG");
		$key[6] = str_split("oDGHJKqwua");
		$key[7] = str_split("hajskdLFOp");
		$key[8] = str_split("qmhdGTYUIO");
		$key[9] = str_split("ZOiuaSDFYe");
		$randkey[0] = str_split("PiyTrqasVm");
		$randkey[1] = str_split("SDFuytQWEm");
		$randkey[2] = str_split("HgFdIOPqwA");
		$randkey[3] = str_split("YHNujmKIOb");
		$randkey[4] = str_split("CVDFERtyui");
		$randkey[5] = str_split("WDCwsxQAZg");
		$randkey[6] = str_split("Aokmijngtr");
		$randkey[7] = str_split("adlkQWPOtr");
		$randkey[8] = str_split("BVCXZnmlOP");
		$randkey[9] = str_split("SFHKLWbnUI");
		if($desc){
			if(contains_ck($str,"VRBENC")){$str = num_text_encript($str,true);}
			$parts = explode(".",($str));
			$x=0;
			foreach($randkey[0] as $rk){if($rk == $parts[2]){$rand2 = $x; break;}$x++;}
			$x=0;
			if(count($randkey[$rand2])>0){
				foreach($randkey[$rand2] as $rk){if($rk == $parts[1]){$rand = $x; break;}$x++;}
				$str = $parts[0];
				$str = str_replace($key[$rand][0],"1",$str);	
				$str = str_replace($key[$rand][1],"2",$str);	
				$str = str_replace($key[$rand][2],"3",$str);	
				$str = str_replace($key[$rand][3],"4",$str);	
				$str = str_replace($key[$rand][4],"5",$str);	
				$str = str_replace($key[$rand][5],"6",$str);	
				$str = str_replace($key[$rand][6],"7",$str);	
				$str = str_replace($key[$rand][7],"8",$str);	
				$str = str_replace($key[$rand][8],"9",$str);	
				$str = str_replace($key[$rand][9],"0",$str);
				$str = strrev($str);
			}
			return $str;
		}else{
			$rand = mt_rand(0,9);
			$rand2 = mt_rand(0,9);
			$str = strrev($str);
			$str = str_replace("1",$key[$rand][0],$str);	
			$str = str_replace("2",$key[$rand][1],$str);	
			$str = str_replace("3",$key[$rand][2],$str);	
			$str = str_replace("4",$key[$rand][3],$str);	
			$str = str_replace("5",$key[$rand][4],$str);	
			$str = str_replace("6",$key[$rand][5],$str);	
			$str = str_replace("7",$key[$rand][6],$str);	
			$str = str_replace("8",$key[$rand][7],$str);	
			$str = str_replace("9",$key[$rand][8],$str);	
			$str = str_replace("0",$key[$rand][9],$str);		
			return num_text_encript($str.".".$randkey[$rand2][$rand].".".$randkey[0][$rand2]);
		}	
	}
}

//bronto
function get_bronto_conection($site="INSPIN"){

	$client = new SoapClient('https://api.bronto.com/v4?wsdl', array('trace' => 1,'features' => SOAP_SINGLE_ELEMENT_ARRAYS)); 
	try {

	 if ($site=="INSPIN"){ 
        echo "IN<br>";
		$sessionId = $client->login(array('apiToken' => "9449A993-AD3E-4A6D-A5F0-507DBB1A5310"))->return;			 
	}

	$session_header = new SoapHeader("http://api.bronto.com/v4",'sessionHeader',array('sessionId' => $sessionId));
	$client->__setSoapHeaders(array($session_header));			 
	}catch (Exception $e) {print_r($e);}	
	return $client;
}
// Bonus
function get_all_bonus_programs(){
	$types = array();
	$types[] = array("id"=>"r","name"=>"Rewards","postup"=>false);
	$types[] = array("id"=>"c","name"=>"10% signup bonus (No rollover) + 10% Reload Bonus (No rollover) + 10% cashback weekly on your Win or Loss (No rollover)","postup"=>true);
	//$types[] = array("id"=>"c","name"=>"10% Cashback","postup"=>true);
	//$types[] = array("id"=>"c","name"=>"25% + 10% cashback + $100 chips","postup"=>true);
	//$types[] = array("id"=>"b","name"=>"50% Bonus + 5% Cashback","postup"=>true);
	//$types[] = array("id"=>"b","name"=>"100% + 5% cashback + $50 chips","postup"=>true);	
	return $types;	
}

function return_domain_name($url){
	
	if ($url == 'sbo') {
		$url = 'sportsbettingonline.ag';
	}elseif ($url == 'completeaction'){
	    $url = 'completeaction.ag';
    }elseif ($url == 'vrb'){
	    $url = 'vrbmarketing.com';
    }elseif ($url == 'partysports'){
	    $url = 'partysports.ag';
    }elseif ($url == 'partysportsbook'){
	    $url = 'partysportsbook.ag';
    } 	
	else {
		$url = $url.'com'; 
	}		
	return $url;
}

function rec_process($tid, $mth, $type, $plyr, $amn, $psta, $nstat, $clerk, $reason){
	if($type == "pa"){$type = "Payout";}
	if($type == "de"){$type = "Deposit";}
	$mth = strtolower(str_replace(" ","",$mth));
	$data = array(
			  "pass"=>"Fr021334HkasdUUUqwe1qa81LLa",
			  "transaction"=>$tid,
			  "method"=>$mth,
			  "type"=>$type,
			  "player"=>$plyr,
			  "amount"=>$amn,
			  "prev_status"=>$psta,
			  "new_status"=>$nstat,
			  "clerk"=>$clerk,
			  "reason"=>$reason
	);
	
	do_post_request(BASE_URL . "/ck/process/ws/process_transaction.php", $data);
}

function ezpay_methods(){

	$methods = array();
	$methods[0] = "bitcoins";	
	$methods[1] = "cashtransfers";	
	$methods[2] = "creditcard";	
	$methods[3] = "localcash";	
	$methods[4] = "moneypak";	
	$methods[5] = "moneyorder";	
	$methods[6] = "paypal";	
	$methods[7] = "prepaid";
	$methods[8] = "special";	
	$methods[9] = "reloadit";
	$methods[10] = "vanilla_reload";
	$methods[11] = "paypal_cashcard";
	$methods[12] = "bankwire";			
	$methods[13] = "cashier_check";
	
	return $methods;	
}

// with the $all_players as true the return = array(player,balance)
function get_vrb_prepaid_balance($payment_method,$player = "",$all_players = false) {
  $player_mode = false;
 if ($player != "" ){ $player_mode = true; } 
 
 if ($all_players){
		 processing_db();
		 $sql = "SELECT DISTINCT player FROM prepaid_transaction WHERE payment_method = '$payment_method' AND status != 'de' AND processor_status != 'de' AND cmarked = 1 ";
		 $players =  get_str($sql);
		 
		foreach ($players as $player){
			 $player_balance[$player["player"]]["player"] = $player["player"]; 
			 $balance = get_vrb_prepaid_balance_test($payment_method,$player["player"],false);
			 $player_balance[$player["player"]]["balance"] = $balance;
		 }
		  return $player_balance;
		 
	 
	}
 
 //1) Ezpay - prepaid_transactions (cmarked,ac,processor_status = ac)	
    processing_db();
	if ($player_mode){
	  $sql_player = " AND PLAYER LIKE '%".$player."%' ";
	}
	
	$sql = "SELECT SUM(amount) as total FROM prepaid_transaction WHERE payment_method = '$payment_method' AND status != 'de' AND processor_status != 'de' AND cmarked = 1 $sql_player ";
	
	//echo $sql;
	
	$total_1 = get_str($sql,true);
    	 
	 	
	 processing_db();
	 $sql = "SELECT dgs_dID,amount FROM prepaid_transaction WHERE payment_method = '$payment_method' AND status != 'de' AND processor_status != 'de' AND cmarked = 1 AND dgs_dID > 0 $sql_player";
     $dgs_dID = get_str($sql,false,"dgs_dID");
    	 
   //2)  Book - banking_transaction  /-
     if ($player_mode){ 
	   $total_2["total"] = 0;
	 }
	 else{
	  sbo_book_db();
      $sql = "SELECT SUM(amount) as total FROM banking_transaction WHERE method = '$payment_method'";
	  $total_2 = get_str($sql,true);
	 }
	  
   	 	
	//3) Book - fee_by_transaction ( All the fees within the $dgs_dID )
     if ($player_mode){ 
	   $total_3["total"] = 0;
	   $total_4["total"] = 0;
	 }
	 else{	  	  
		   $str_dgs = "''";
			if (!is_null($dgs_dID)){
			  $str_dgs = "";
			  foreach ($dgs_dID as $id){ 
				 $str_dgs .= "'".$id["dgs_dID"]."',";
			  }
			  $str_dgs = substr($str_dgs,0,-1);
			}
			  
			sbo_book_db();
			$sql = "SELECT SUM(fee) as total FROM fee_by_transaction WHERE method = '$payment_method'
			AND transaction IN ($str_dgs)";
			$total_3 = get_str($sql,true);
		 
			  
		   sbo_book_db();
		  $sql = "SELECT transaction, percentage FROM fee_by_transaction WHERE method = '$payment_method'
		   AND transaction IN ($str_dgs)";
		   
		   $transactions = get_str($sql,false);
		   
		   $total_4["total"] = 0;
		   foreach ($transactions as $trans){
		   
			  $value = 0;
			  if ($trans["percentage"] > 0){ 
				$value = ($dgs_dID[$trans["transaction"]]["amount"] * $trans["percentage"])/100;
				$total_4["total"] = $total_4["total"] + $value;
			  }	   
			}
	 }
	   
	  //4) VRB-Accounting - special_deposits (inserted = 1,status = ac , Not AF)
	  accounting_db();
	   $sql = "SELECT  sum(Amount) as total FROM special_deposit s, special_method m WHERE s.method =       m.id and dgs_id = '$payment_method' and player not like '%AF%' and inserted = 1 and status =  'ac' $sql_player";
   	   $total_5 = get_str($sql,true);
	 	  
	   //5) VRB-Accounting - special_deposits (inserted = 1,status = ac , Not AF / Rest Payouts)
	 
	   accounting_db();
	   $sql = "SELECT  sum(Amount) as total FROM special_payouts s, special_method m WHERE s.method =   m.id and dgs_id = '$payment_method' and player not like '%AF%' and inserted = 1 and status = 'ac' $sql_player";
   	   
	   $total_6 = get_str($sql,true);
	   
	  
	   //6)  EZPAY - direct_paypal_transaction (ac, marked , NOT AF)
	    processing_db();
		 //deposits
		 $sql = "SELECT  sum(Amount) as total FROM  direct_paypal_transaction WHERE payment_method =  '$payment_method' and player not like '%AF%' and cmarked = 1 and status = 'ac' and type = 'd' $sql_player";
       $total_7 = get_str($sql,true);

		 //payouts
		 processing_db();
		 $sql = "SELECT  sum(Amount) as total FROM  direct_paypal_transaction WHERE payment_method =  '$payment_method' and player not like '%AF%' and cmarked = 1 and status = 'ac' and type = 'p' $sql_player";
	     $total_8 = get_str($sql,true);
		
		 //not used temporaly
		 /*//7)  Book - balance_adjustment
		 sbo_book_db();
		 $sql = "SELECT SUM(amount) as total FROM balance_adjustment WHERE method = '$payment_method'";
		 $total_9 = get_str($sql,true);*/
			
	  
	  $deposits = $total_1["total"] +  $total_2["total"]  + $total_5["total"] + $total_7["total"] + $total_9["total"]; 
	  
	  $payouts =  $total_3["total"] + $total_4["total"] + $total_6["total"] + $total_8["total"];
	  
	   //TOTAL
	   $total = $deposits - $payouts;
	  
	  return $total; 	 
	
}

//phone
function check_phone_online_login($idclerk){
	$logins = get_all_clerk_phone_logins($idclerk);
		
	if (!is_null($logins)){
		foreach($logins as $login){
		$test = is_agent_online_loged_at_phone($login->vars["login"]);
		if ($test) { return true; }
		}
	}
	return false;
}

if(!function_exists('myStrstrTrue')) {
	
	function myStrstrTrue($haystack,$needle,$true = false){  //strstr() 3rd parameter is php5.3 
		$haystack = (string)$haystack;
		$haystack = explode($needle,$haystack); //remove text after end tag and tag
		$haystack =  (string)$haystack[0];
		return $haystack;
	}

}

function f_backup_dbs($host,$user,$pass,$name,$dir,$tables = '*') {   

     //This function backups a mysql database in the specified directory.
	 	 	 	 
	 $link = @mysql_pconnect($host,$user,$pass);
     mysql_select_db($name,$link);	 	 

     //get all of the tables
     if($tables == '*') {
 
       $tables = array();
       $result = mysql_query('SHOW TABLES');
	   
       while($row = mysql_fetch_row($result)) {       
         $tables[] = $row[0];	 		 
       }
	   
     }
	 
     else { 
       $tables = is_array($tables) ? $tables : explode(',',$tables);
     }

     //cycle through
     foreach($tables as $table) {
 
       //$result = mysql_query('SELECT * FROM '.$table);
	   $result = mysql_query('SELECT * FROM '.'`'.$table.'`');
	    
       $num_fields = mysql_num_fields($result);
       //$return.= 'DROP TABLE '.$table.';';
	   $return.= 'DROP TABLE '.'`'.$table.'`;';
       $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.'`'.$table.'`'));
       $return.= "\n\n".$row2[1].";\n\n";

       for ($i = 0; $i < $num_fields; $i++) {
 
           while($row = mysql_fetch_row($result)) {
 
             //$return.= 'INSERT INTO '.$table.' VALUES(';
			 $return.= 'INSERT INTO '.'`'.$table.'`'.' VALUES(';
													  
             for($j=0; $j<$num_fields; $j++) {

               $row[$j] = addslashes($row[$j]);
              //$row[$j] = preg_replace("\n","\\n",$row[$j]);
			  $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
			   
               if (isset($row[$j])) {
			     $return.= '"'.$row[$j].'"' ;
			   }
			   
			   else {
			      $return.= '""'; 
			   }  
				  
               if ($j<($num_fields-1)) {
			     $return.= ',';
			   }
			   
             }
			 
             $return.= ");\n";
           }
         }
       $return.="\n\n\n";
    }		  
   
   //$dbname = $dir.$name.'-'.date('Y-m-d_Hi').'.sql';
   $dbname = $dir.$name.'-'.date('Y-m-d_Hi');
   $dbname_sql_current = $dbname;
   
   $handle = fopen($dbname,'w+');
   fwrite($handle,$return);
      
   $file = $dbname;
   $gzfile = $dir.$name.'-'.date('Y-m-d_Hi').'.gz';
   $fp = gzopen ($gzfile, 'w9'); // w9 == highest compression
   gzwrite ($fp, file_get_contents($file));
   gzclose($fp);  
   
   fclose($handle);
   
   //removes the current sql file in order to save hard drive's space
   @unlink($dbname_sql_current);             
}

function get_affiliate_banner_size_by_name($name){
	$ps1 = explode("_",$name);
	$ps2 = explode(".",$ps1[1]);
	return $ps2[0];
}

function get_ip(){
	$ip = $_SERVER["REMOTE_ADDR"];
	if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	return $ip;	
}

//Affiliates
function change_campaing_promotypes_default ($defid,$newid) {
	
	$list = array("975x45","728x90","600x100","545x60","486x60","468x60","300x600","336x280","300x250","293x25","250x250","240x400","235x90","234x60","200x200","180x150","160x600","125x125","120x600","120x240","120x60","116x18","90x90","88x31","610x100","230x150","468x90","200x200");
	
	$mailers = 0;
	$def_promo = get_promos_by_campaigne_affiliate($defid);
	
	if (!is_null($def_promo)){
		foreach($def_promo as $def_promo){
		
		  if($def_promo->vars["type"] == 'b'){			
			  
			$parts = explode("_",$def_promo->vars["name"]);
			
			
			if(in_array(str_replace(".gif","",$parts[count($parts)-1]),$list)){	
			
			   $type_b = get_promo_type_by_campaing_name("b",$newid,$parts[1]);
				
				foreach($type_b as $promo){
					$def_promo->vars["name"] = $promo->vars["name"];
					$def_promo->update(array("name"));
				  
				}
			 }
		
			}else if($def_promo->vars["type"] == 'm'){
				$type_m = get_promo_type_by_campaing_name("b",$newid,"" ,$mailers);
				$mailers++;
				 foreach($type_m as $mailer){
					$def_promo->vars["name"] = $mailer->vars["name"];
					$def_promo->update(array("name"));
				
				 }
			}
	   }//foreach
	}//if
}
	
//posting

//Pagination
function getPagination($total_regs,$num_results_x_page)
{
    $paginationCount= floor($total_regs / $num_results_x_page);
    $paginationModCount= $total_regs % $num_results_x_page;
    if(!empty($paginationModCount))
    {
        $paginationCount++;
    }
    return $paginationCount;
}

//
function print_json_results($resultArray) {
    $callback = isset($_GET['callback']);
    header('Content-Type: application/javascript');
    if ($callback) {
        echo "{$_GET['callback']}(";
    }
    echo json_encode($resultArray);
    if ($callback) {
        echo ")";
    }
    exit();
}

function param($name, $secured = true){
	$val = "";
	if(isset($_GET[$name])){$val = $_GET[$name];}
	else if(isset($_POST[$name])){$val = $_POST[$name];}
	if($secured){$val = hsecure_input($val);}
	return $val;
}

function param_soft($name, $secured = true, $int = false){
	$val = "";
	if(isset($_GET[$name])){$val = $_GET[$name];}
	else if(isset($_POST[$name])){$val = $_POST[$name];}
	if($secured){$val = soft_clean($val,$int);}
	return $val;
}

function soft_clean($str, $int = false) {	
		$str = str_replace("--","",$str);
		$str = str_replace("'","",$str);
		$str = str_replace('"',"",$str);
		
	return $str;  
}



function hsecure_input($str) {
	$str = str_replace("--","",$str);
	$str = preg_replace("/[^A-Za-z0-9,.@ ]/", "", $str);
	return trim($str); 
}

function asp_encryption($encrypted_code){
	
  $encrypted_account = str_replace(".1.","Z",$encrypted_code);
  $encrypted_account = str_replace(".23.","Y",$encrypted_account);
  $encrypted_account = str_replace(".26.","X",$encrypted_account);
  $encrypted_account = str_replace(".31.","W",$encrypted_account);
  $encrypted_account = str_replace(".35.","V",$encrypted_account);
  $encrypted_account = str_replace(".49.","U",$encrypted_account);
  $encrypted_account = str_replace(".56.","T",$encrypted_account);
  $encrypted_account = str_replace(".58.","S",$encrypted_account);
  $encrypted_account = str_replace(".60.","R",$encrypted_account);
  $encrypted_account = str_replace(".63.","Q",$encrypted_account);
  $encrypted_account = str_replace(".68.","P",$encrypted_account);
  $encrypted_account = str_replace(".70.","O",$encrypted_account);
  $encrypted_account = str_replace(".75.","N",$encrypted_account);
  $encrypted_account = str_replace(".81.","M",$encrypted_account);
  $encrypted_account = str_replace(".86.","L",$encrypted_account);
  $encrypted_account = str_replace(".88.","K",$encrypted_account);
  $encrypted_account = str_replace(".94.","J",$encrypted_account);
  $encrypted_account = str_replace(".99.","I",$encrypted_account);
  $encrypted_account = str_replace(".100.","H",$encrypted_account);
  $encrypted_account = str_replace(".123.","G",$encrypted_account);
  $encrypted_account = str_replace(".125.","F",$encrypted_account);
  $encrypted_account = str_replace(".127.","E",$encrypted_account);
  $encrypted_account = str_replace(".130.","D",$encrypted_account);
  $encrypted_account = str_replace(".144.","C",$encrypted_account);
  $encrypted_account = str_replace(".149.","B",$encrypted_account);
  $encrypted_account = str_replace(".162.","A",$encrypted_account);
  $encrypted_account = str_replace(",","0",$encrypted_account);
  $encrypted_account = str_replace(".","9",$encrypted_account);
  $encrypted_account = str_replace("_","8",$encrypted_account);
  $encrypted_account = str_replace("*","7",$encrypted_account);
  $encrypted_account = str_replace(")","6",$encrypted_account);
  $encrypted_account = str_replace("(","5",$encrypted_account);
  $encrypted_account = str_replace("%","4",$encrypted_account);
  $encrypted_account = str_replace("$","3",$encrypted_account);
  $encrypted_account = str_replace("-","2",$encrypted_account);  
  $encrypted_account = str_replace("!","1",$encrypted_account); 
  
  return $encrypted_account;
  
}
// Intersystem

function intersystem_formula($to,$from,$amount,$type){
  
    if((!$from) && ($to) ){
	  $amount = $amount * -1;   
	}  
	else if(($from) && (!$to) ) {
	  $amount = $amount;	
	} 
	else if ((($from) && ($to) ) || ((!$from) && (!$to) ) ){  
		
		if ($type == 'from') {
			$amount = $amount * -1;
		}
		if ($type == 'to') {
			$amount = $amount ;
		}
   }
  return $amount;	
}

function rand_str($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = [];
        foreach ($data as $key => $value)
        {
            $result[$key] = (is_array($data) || is_object($data)) ? object_to_array($value) : $value;
        }
        return $result;
    }
    return $data;
}

function sportsbooks_to_promote(){
	
	$sportsbooks = get_all_sportsbooks_partner();
    $books_not_included = array(1,4,5,7,10,12);
    $books = array();
	
    foreach($sportsbooks as $book) {
      if (!in_array($book["id"],$books_not_included)){
	    $books[]=$book["id"];	   
      }
    }
	
	return $books;
}


function date_convert($time, $oldTZ, $newTZ, $format) {
    // create old time
    $d = new \DateTime($time, new \DateTimeZone($oldTZ));
    // convert to new tz
    $d->setTimezone(new \DateTimeZone($newTZ));

    // output with new format
    return $d->format($format);
}


function ftp_transfer_headlines_files($file_path,$filename,$new_name,$type){  

  $ftp_host = "storage.bunnycdn.com"; 
   
  $ftp_user_name = 'sbodata'; /* username */
  $ftp_user_pass = '203275c1-3c2d-4ff8-bc508230fea8-357c-4d06'; /* password */ 
   
  /* Connect using basic FTP */
  $connect_it = ftp_connect($ftp_host);
  
  if($connect_it){
    
    /* Login to FTP */
      
    $login_result = ftp_login( $connect_it, $ftp_user_name, $ftp_user_pass );
    
    if($login_result){
      
      switch ($type) {
        
      case "pph":
        $remote_path = "/sbodata/headlines/pph/";
        break;
      case "sbo":
        $remote_path = "/sbodata/headlines/";
        break;
      case "owi":
        $remote_path = "/sbodata/headlines/";
        break;  
      case "mobile":
        $remote_path = "/sbodata/mobile_headlines/";
        break;
          }
      
      //turn passive mode on
          ftp_pasv($connect_it, true);      
        
      /* Remote File Name and Path */
      $remote_file = $remote_path.$new_name;
        
      /* File and path to send to remote FTP server */
      $local_file  = $file_path.$filename;
          // echo $remote_file." -- ".$local_file;   exit;        
      /* Send $local_file to FTP */
      if ( ftp_put( $connect_it, $remote_file, $local_file, FTP_BINARY ) ) {
        // ftp_rename($ftp_conn, $old_file, $new_file)

       echo "Successfully transfer $local_file\n";
      }else {
       echo "There was a problem\n";
      }
      
      /* Close the connection */
      ftp_close( $connect_it );
      
    }else{
      echo "There was a problem trying to log in to the ftp server.\n";
    }
    
  }else{
     echo "There was a problem trying to connect to the ftp server.\n";
  }
  
}

function DebugLogTxt($texto, $array = null) {
    // Obtiene la fecha y hora actual
    $fechaHora = date('Y-m-d H:i:s');
    
    // Abre el archivo LogVRB.txt en modo de escritura/lectura; si no existe, lo crea
    $archivo = fopen('./LogVRB.txt', 'a');
    
    // Escribe la fecha y hora en el archivo
    fwrite($archivo, $fechaHora . "\n");
    
    // Escribe el texto recibido en el archivo
    fwrite($archivo, $texto . "\n");
    
    // Si se proporciona un array, se formatea y se escribe en el archivo
    if ($array !== null && is_array($array)) {
        fwrite($archivo, "<pre>" . print_r($array, true) . "</pre>\n");
    }
    
    // Cierra el archivo
    fclose($archivo);
}



?>