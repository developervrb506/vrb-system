<?
require_once(ROOT_PATH . "/db/handler.php");
require_once(ROOT_PATH . '/process/classes.php');
require_once(ROOT_PATH . '/reports/classes.php');
require_once(ROOT_PATH . "/includes/mail/class-phpmailer.php");

/*Global Variables*/
//$url_headlines_vrb = 'http://jobs.inspin.com/images/vrb/headlines/';
$url_headlines_vrb = BASE_URL . '/images/headlines/';

function affiliates_db() {
  global $mysqli;
  $dbhost = "db"; 
  $dbuser = "vrbmarketing_admin"; 
  $dbpass = "AKFtgOX29FTgbWlVf"; 
  $dbname = "vrbmarketing_affiliates";  
  $mysqli = @mysqli_connect('p:'.$dbhost, $dbuser, $dbpass, $dbname);  
  mysqli_select_db($mysqli,"$dbname"); 
  if (mysqli_errno($mysqli)) {
     printf("Connect failed. %s\n", mysqli_errno($mysqli));
     exit();
  }
}
function num_text_encription($str, $desc = false){
	if($desc){
		$str = str_replace("VRBENC","",$str);
		$str = sbo_two_way($str, true);
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
		$str = sbo_two_way($str)."VRBENC";	
	}
	
	return $str;
}
function num_two_way_encript($str, $desc = false, $spliter = "/"){
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
			if(contains($str,"VRBENC")){$str = num_text_encription($str,true);}
			$parts = explode(".",($str));
			$x=0;
			foreach($randkey[0] as $rk){if($rk == $parts[2]){$rand2 = $x; break;}$x++;}
			$x=0;
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
			return strrev($str);
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
			return num_text_encription($str.".".$randkey[$rand2][$rand].".".$randkey[0][$rand2]);
		}	
	}
}

function encript_data($pass){
	$original = md5($pass);
	$original = str_replace("7","v5c8",$original);
	$original = str_replace("c","m9f1",$original);
	$original = str_replace("f","xj3",$original);
	$l = strlen($original);
	$key = str_replace("0","wr2",substr($original,0,$l -20));
	$key2 = str_replace("b","prlat7",substr($original,2,$l -15));
	$original = $key2.$key;
	return md5($original);
}
function send_email_partners($email, $sub, $content, $html = false, $from = "support@vrbmarketing.com"){
		$headers = 'From: VRB_Marketing <support@vrbmarketing.com>' . "\r\n" .
		'Reply-To: support@vrbmarketing.com' . "\r\n";
		if($html){$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";}
		if (@mail($email, $sub, $content, $headers)) {} else {}
		
		/*$mail = new PHPMailer();	
        $mail->From     = $from;
        $mail->FromName = 'VRB Marketing';
        $mail->AddAddress($email, '');
        $mail->Username = 'andyh@inspin.com'; 
        $mail->Password = 'sbomike160412';
        $mail->Host     = '192.168.1.8';
        $mail->Mailer   = 'smtp';
        $mail->IsHTML($html);
			
        if($mail->Mailer == 'smtp') {
          $mail->SMTPAuth = true;
        }
					
        $mail->Subject = $sub;  			
        $mail->Body = stripslashes($content);
        $mail->Send();*/
}
function upload_image_partners($id, $path, $name = ""){
	if (!empty($_FILES[$id]['name'])) {
		  if($name != ""){$filename = $name . strrchr(basename($_FILES[$id]['name']),'.');}else{$filename = basename($_FILES[$id]['name']);}
		  $filefull = $path.$filename; 
			 
		  if (!move_uploaded_file($_FILES[$id]['tmp_name'], $filefull))
		  echo '<strong>An error occurred uploading the product image... please check the file name and its extension and try again.</strong>';
	}
	return $filename;
}
function clean_str($str) {
	
  //affiliates_db();

  $str = xss_clean($str); 
  return $str;
  
}
function xss_clean($data)
{
	// Fix &entity\n;
	$data = str_replace("'","",$data);
	$data = str_replace('"',"",$data);
	$data = str_replace('--',"",$data);
	$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
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

function get_error($id){
  $error_messages[0] = "Thanks for join to our Partners program";
  $error_messages[1] = "This email address already exists in our system. Please try another one";
  $error_messages[2] = "Your Email / Id or Password is Incorrect";
  $error_messages[3] = "The partner's information was saved successfully<br /><br />";
  $error_messages[4] = "The partner was approved successfully<br /><br />";
  $error_messages[5] = "Your Endorsement was saved successfully<br /><br />";
  $error_messages[6] = "Your Widget request was sended successfully<br /><br />";
  $error_messages[7] = "Your Mailer Copy was sended successfully";
  $error_messages[8] = "The Text Link was saved successfully. You can get the Code Below";
  $error_messages[9] = "Message Deleted";
  $error_messages[10] = "Your Wagerweb User or Password is Incorrect";
  $error_messages[11] = "Sorry, the Security Code you entered is incorrect. Please try it again.";
  $error_messages[12] = "Your Profile Details have been Saved";
  $error_messages[13] = "Your Old Password is Incorrect. Your password could not be updated";
  $error_messages[14] = "Your Payout Request has been Sent";
  $error_messages[15] = "There is a Problem with the Payout Amount";
  $error_messages[16] = "Your Campaign has been stored";
  $error_messages[17] = "Your Campaign has been Deleted";
    
  return $error_messages[$id];
}
function clean_extension($value){
	$value = str_replace(".gif","",$value);
	$value = str_replace(".GIF","",$value);
	$value = str_replace(".jpg","",$value);
	$value = str_replace(".JPG","",$value);
	$value = str_replace(".png","",$value);
	$value = str_replace(".PNG","",$value);
	return $value;
}
function get_path(){
		return BASE_URL;
}
function unique_count($list){
	$unique = 0;
	$ips = array();
	foreach($list as $report){
		if(!in_array($report->ip,$ips)){
			$ips[] = $report->ip;
			$unique++;	
		}
	}
	return $unique;
}
function contains($full,$search){
	$found = false;
	if(strlen(strstr($full,$search))>0){
		$found = true;	
	}
	return $found;	
}
function sort_DESC($al, $bl){
	$al = strtolower($al);
	$bl = strtolower($bl);
	if ($al == $bl) {
		return 0;
	}
	return ($al < $bl) ? +1 : -1;
}
function sort_ASC($al, $bl){
	$al = strtolower($al);
	$bl = strtolower($bl);
	if ($al == $bl) {
		return 0;
	}
	return ($al > $bl) ? +1 : -1;
}
function check_wagerweb_customer($username, $password) {
	
	/*Parameters: 
	
	  Customer's Username
	  Customer's Password
	  
	  Return:
	  
	  1 = The customer exist in WagerWeb
	  0 = The customer doesn't exist in WagerWeb
	*/
	
   $response = file_get_contents('http://lb.playblackjack.com/check_customer.asp?username='.$username.'&password='.$password);
   return $response;
   
}
function get_wagerweb_customer_balance($username) {
	
	/*Parameters: 
	
	  Customer's Username
		  
	  Return:
	  
	  The current customer's balance or 0 if he doesn't have one
	  
	*/
	
   $current_balance = @file_get_contents('http://lb.wagerweb.com/WW_getcustomerbalance.asp?user='.$username);
   $pos  = strpos($current_balance,"$");
   $current_balance = substr($current_balance,$pos);
   $pos  = strpos($current_balance,"<");
   $current_balance = substr($current_balance,0,$pos);
   
   if ( is_null($current_balance) or $current_balance == "" ) {
	  $current_balance = '$0.00'; 
   }
   
   return $current_balance;   
}

function get_ww_comission_data($affiliate, $from, $to){
	$all_count = 0;
	$new_count = 0;
	$new_dep_count = 0;
	
	$html = file_get_contents("http://lb.playblackjack.com/ag_agentcustomerlistvrb-new2.asp?agent=$affiliate");
	$DOM = new DOMDocument;
	@$DOM->loadHTML($html);
	$items = $DOM->getElementsByTagName('td');	
	$tfrom = strtotime($from);
	$tto = strtotime($to);
	$tto_extra = $tto + 97200;
	for ($i = 0; $i < $items->length; $i++){
		$clean_value = trim($items->item($i)->nodeValue);	
		if($clean_value == "Active"){$all_count++;}
		if(contains($clean_value," PM") || contains($clean_value," AM")){
			$time = strtotime($clean_value);
			if($time >= $tfrom && $time <= $tto_extra){
				$new_count++;
			}
		}
	}
	
	if($new_count > 0){
	
		$data = array("CustomerID"=>"$affiliate","flag"=>"1","date1"=>date("m/d/Y",$tfrom),"date2"=>date("m/d/Y",$tto));
		$html = make_post_request("http://lb.playblackjack.com/ag_cashtransactionsvrb.asp", $data);
		
		$DOM = new DOMDocument;
		@$DOM->loadHTML($html);
		$items = $DOM->getElementsByTagName('td');	
		$total_lines = 0;
		for ($i = 0; $i < $items->length; $i++){
			$clean_value = trim($items->item($i)->nodeValue);	
			if(contains($clean_value," PM") || contains($clean_value," AM")){
				$total_lines++;
				$time = strtotime($clean_value);
				if($time >= $tfrom && $time <= $tto_extra){
					$new_dep_count++;
				}
			}
		}
		$total_lines /= 2;
		$new_dep_count -= $total_lines;
	
	}
	
	return array("active"=>$all_count,"new"=>$new_count,"new_deposits"=>$new_dep_count);
}

function get_ww_affiliate_comm_level($username) {
	
	/*Parameters: 
	
	  Affiliate's Username
		  
	  Return:
	  
	  The current affiliate's commission level
	  
	*/
	
   $commission_level = @file_get_contents('http://lb.wagerweb.com/ag_CommReportvrb.asp?customerID='.$username);
      
   if ( is_null($commission_level) or $commission_level == "" ) {
	  $commission_level = '0.00%'; 
   }
   
   return $commission_level;   
}
function clean_url($url, $enc){
	if($enc){
		$url = str_replace("?","/_qs_/",$url);
		$url = str_replace("&","/_as_/",$url);
	}else{
		$url = str_replace("/_qs_/","?",$url);
		$url = str_replace("/_as_/","&",$url);
	}
	return $url;	
}

function get_campaigns_by_size($campaigns, $size, $id, $onchange, $default){
	$items = 0;
	$code = '<select name="'.$id.'" id="'.$id.'" onchange="'.$onchange.'">';
	if($default){ $code .= '<option value="np" selected="selected">-- Select --</option>'; }
	 foreach($campaigns as $camp){
			foreach($camp->promos as $promo){
				if(contains($promo->name, $size)){
					$code .= '<option value="'.$promo->id.'">'. $camp->name .'</option>';
					$items++;
				}
			}
	}
	if($items == 0){$code .= '<option value="">No Capaigns Available.</option>';}
	$code .= '</select>';	
	return $code;
}
function get_campaigns_list_by_size($campaigns, $size){
	$list = array();
	 foreach($campaigns as $camp){
			foreach($camp->promos as $promo){
				if(contains($promo->name, $size)){
					$list[] = array($camp, $promo);
					break;
				}
			}
	}
	return $list;
}


function check_affiliate_website($aff_id, $web_id){
	$ok = false;
	if($aff_id == $web_id){
		$ok = true;
	}else{
		$ok = is_affiliate_website($aff_id, $web_id);
	}
	return $ok;
}
function get_default_campaign($book){
	$book = strtolower($book);
	$def = -1;
	switch ($book) {
    case "wagerweb":
        $def = 7;
        break;
    case "horizon":
        $def = 16;
        break;
	case "bet online":
        $def = 24;
        break;
	}
	return $def;
}
function clean_register_cookies(){
	setcookie("firstname", "",0,"/",".vrbmarketing.com");
	setcookie("lastname", "",0,"/",".vrbmarketing.com");
	setcookie("address", "",0,"/",".vrbmarketing.com");
	setcookie("city", "",0,"/",".vrbmarketing.com");
	setcookie("state", "",0,"/",".vrbmarketing.com");
	setcookie("country", "",0,"/",".vrbmarketing.com");
	setcookie("zipcode", "",0,"/",".vrbmarketing.com");
	setcookie("email", "",0,"/",".vrbmarketing.com");
	setcookie("phone", "",0,"/",".vrbmarketing.com");
	setcookie("websitename", "",0,"/",".vrbmarketing.com");
	setcookie("websiteurl", "",0,"/",".vrbmarketing.com");	
}
function email_to_clercks($subject, $body, $html){
	send_email_partners("katvrbmarketing@gmail.com", $subject, $body, $html, "support@vrbmarketing.com");
	send_email_partners("wendyvrbmarketing@gmail.com", $subject, $body, $html, "support@vrbmarketing.com");
	send_email_partners("mfajardo@vrbmarketing.com", $subject, $body, $html, "support@vrbmarketing.com");
	send_email_partners("dzamzack@vrbmarketing.com", $subject, $body, $html, "support@vrbmarketing.com");
	send_email_partners("baileyvrbmarketing@gmail.com", $subject, $body, $html, "support@vrbmarketing.com");			
}
function f_start_end_current_week($format = "m/d/Y") {

	$Drange = array();
	
	//monday is the first date of the week
	$sun = 7; //sunday = end of week
	$current_day=date('w');
	$days_remaining_until_sun = $sun - $current_day;
	
	$ts_start = strtotime("-$current_day days");
	$ts_start = date($format, strtotime('+1 day', $ts_start)); 
	$ts_end   = strtotime("+$days_remaining_until_sun days");
	$ts_end   = date($format,$ts_end);
	
	$Drange[0] = $ts_start; 
	$Drange[1] = $ts_end;
	
	return $Drange;

}
function commission_net_weekly($username) {
	
	/*Parameters: 
	
	  Affiliate's Username
	  		  
	  Return:
	  
	  The weekly affiliate's total commission and net figures
	  
	*/
	
	$Drange = f_start_end_current_week();
	
	$start_date = $Drange[0];
	$end_date   = $Drange[1];
	
    $commission_net_weekly = @file_get_contents('http://lb.playblackjack.com/ag_commission_net_weekly.asp?CustomerID='.$username.'&start_date='.$start_date.'&end_date='.$end_date);
	
	if ( is_null($commission_net_weekly) or $commission_net_weekly == "" ) {
	   $commission_net_weekly = '$0.00/$0.00'; 
    }
	        
    return $commission_net_weekly;   
}

function weekly_signups($username) {
	
	/*Parameters: 
	
	  Affiliate's Username
	  		  
	  Return:
	  
	  The weekly signups x affiliate
	  
	*/
	
	$Drange = f_start_end_current_week();
	
	$start_date = $Drange[0];
	$end_date   = $Drange[1];
	
    $weekly_signups = @file_get_contents('http://lb.playblackjack.com/agAffiliatesSignupsByDate_Total.asp?CustomerID='.$username.'&start_date='.$start_date.'&end_date='.$end_date);
	
	if ( is_null($weekly_signups) or $weekly_signups == "" ) {
	   $weekly_signups = '0'; 
    }
	        
    return $weekly_signups;   
}
function current_URL() {
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
function redir_www(){
	if(!contains(current_URL(),"www.")){
		header("Location: " . BASE_URL);
	}
}
function strcontains($full,$search){
	$found = false;
	if(strlen(strstr($full,$search))>0){
		$found = true;	
	}
	return $found;	
}
function sbo_two_way($str, $desc = false){
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
		$result = hextostr($str);
	}
	return $result;
}
function two_way_encript($str, $desc = false){
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
		$result = hextostr($str);
	}
	return $result;
}
function hextostr($hex){
	$str='';
	for ($i=0; $i < strlen($hex)-1; $i+=2){
		$str .= chr(hexdec($hex[$i].$hex[$i+1]));
	}
	return $str;
}

function get_marketing_table($date){
	$diff = time()-strtotime($date);
	$diff = $diff/24/60/60;
	if($diff <= 8){
		$table = "_week";
	}else if($diff <= 37){
		$table = "_month";
	}else{
		$table = "_month";//delete month
	}
	return $table;
}

function make_post_request($url, $data){
	$postdata = http_build_query($data);
	$opts = array('http'=>array('method'=>'POST','header'  => 'Content-type: application/x-www-form-urlencoded','content' => $postdata));
	$context  = stream_context_create($opts);
	return file_get_contents($url, false, $context);
}


function get_week_monday($date, $format = "Y-m-d", $next = false){
	$days = (date("N",strtotime($date)))-1;
	$monday = date($format,strtotime($date . "- $days days"));
	if($next){$monday = date($format,strtotime($monday . "+ 7 days"));}
	return $monday;
}

function str_center_string($first, $second, $string){
	$exnum = strlen($first);
	$pos = strpos($string,$first);
	$pos2 = strpos($string,$second);
	$extra = substr($string,$pos2);	
	return str_replace($extra,"",substr($string,$pos+$exnum));
}

function multisort($array, $sort_by, $key1, $key2=NULL, $key3=NULL, $key4=NULL, $key5=NULL, $key6=NULL,$key7=NULL,$key8=NULL){
    
    foreach ($array as $pos =>  $val)
        $tmp_array[$pos] = $val[$sort_by];
    asort($tmp_array);
    
    
    foreach ($tmp_array as $pos =>  $val){
        $return_array[$pos][$sort_by] = $array[$pos][$sort_by];
        $return_array[$pos][$key1] = $array[$pos][$key1];
        if (isset($key2)){
            $return_array[$pos][$key2] = $array[$pos][$key2];
            }
        if (isset($key3)){
            $return_array[$pos][$key3] = $array[$pos][$key3];
            }
        if (isset($key4)){
            $return_array[$pos][$key4] = $array[$pos][$key4];
            }
        if (isset($key5)){
            $return_array[$pos][$key5] = $array[$pos][$key5];
            }
        if (isset($key6)){
            $return_array[$pos][$key6] = $array[$pos][$key6];
            }
  	   if (isset($key7)){
            $return_array[$pos][$key7] = $array[$pos][$key7];
            }
			
	   if (isset($key8)){
            $return_array[$pos][$key8] = $array[$pos][$key8];
            }		
			
        }
    return $return_array;
}

if(!function_exists('myStrstrTrue')) {

	function myStrstrTrue($haystack,$needle,$true = false){  //strstr() 3rd parameter is php5.3 
		$haystack = (string)$haystack;
		$haystack = explode($needle,$haystack); //remove text after end tag and tag
		$haystack =  (string)$haystack[0];
		return $haystack;
	}

}

?>