<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$vars["title"] = clean_get("title");
$vars["content"] = clean_get("content");
$vars["from"] = $current_clerk;
$vars["send_date"] = date("Y-m-d H:i:s");
$vars["last_date"] = date("Y-m-d H:i:s");

if(clean_get("admin_message")){

	$clerks = get_all_clerks();
	$attached = "";
	foreach($clerks as $ck){
		if(clean_get("clerk_".$ck->vars["id"])){
			$vars["to"] = $ck;
			$message = new ck_message($vars);
			$attached = $message->attach("attachment", "../../attachments/",$attached);
			$message->send();			
		}
		if($_POST["mobile"]){
			header("Location: ../../mobile/messages.php?e=14");
		}else{
			header("Location: ../../messages.php?e=14");
		}
		
	}

}else{
	
	$vars["to"] = get_clerk(clean_get("clerk_list"));
	$message = new ck_message($vars);
	$message->attach("attachment", "../../attachments/");
	$message->send();
	header("Location: ../../index.php?e=14");
	
}

?>