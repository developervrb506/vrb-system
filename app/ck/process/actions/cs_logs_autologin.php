<?php 

if(md5("CSlogsPass") == $_GET["cache"]){
	
}




include(ROOT_PATH . "/ck/db/handler.php");
$clerk = check_clerk_login($email, $original_pass);
if(!is_null($clerk)){
	$clerk_ip = getenv(REMOTE_ADDR);
	$log = new ck_log();
	$log->vars["user"] = $clerk->vars["id"];
	$log->vars["ip"] = $clerk_ip;
	$log->vars["date"] = date("Y-m-d H:i:s");
	$no_ip_levels = array(6,3,1);
	$ips = explode(",",str_replace(" ","",$gsettings["ips_allowed"]->vars["value"]));
	if(in_array($clerk_ip,$ips) || $clerk->vars["admin"]  || in_array($clerk->vars["level"]->vars["id"],$no_ip_levels)){
		session_start();
		session_regenerate_id(true);
		$_SESSION['ckloged'] = "1";
		$_SESSION['logclerk'] = $clerk->vars["id"];
		$_SESSION['ck_ip'] = md5($_SERVER['HTTP_USER_AGENT']);	
		$log->insert();
		$fail = false;
		if(is_mobile() && $clerk->vars["id"] == 1){$extra_url = "/mobile";}
		header("Location: ../../ck".$extra_url);
	}else{
		$log->vars["fail"] = 1;
		$log->insert();	
		$fail = true;
	}
}else{$fail = true;}




if($fail && !$_POST["no_fail"] && !$nomore){header("Location: ../../index.php?e=2");}

?>