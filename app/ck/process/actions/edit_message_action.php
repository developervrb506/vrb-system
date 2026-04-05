<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<?
$edit_msg = get_ck_message(clean_get("edit"));
$edit_msg->vars["content"] = clean_get("content");

if(!clean_get("clerk_".$edit_msg->vars["to"]->vars["id"])){$edit_msg->delete();}else{$edit_msg->resend($current_clerk);}


if(clean_get("rec")){	
	
	$vars["title"] = $edit_msg->vars["title"];
	$vars["content"] = $edit_msg->vars["content"];
	$vars["from"] = $edit_msg->vars["from"];
	$vars["complete"] = $edit_msg->vars["complete"];
	$vars["important"] = $edit_msg->vars["important"];
	$vars["send_date"] = date("Y-m-d H:i:s");
	$vars["last_date"] = date("Y-m-d H:i:s");
	
	$clerks = get_all_clerks();
	foreach($clerks as $ck){
		if(clean_get("clerk_".$ck->vars["id"]) && $ck->vars["id"] != $edit_msg->vars["to"]->vars["id"]){
			$vars["to"] = $ck;
			$message = new ck_message($vars);
			$attachments = get_attachments_by_message($edit_msg->vars["id"]);
			
			foreach($attachments as $att){
				$message->copy_attach("../../attachments/", $att->vars["file"]);
			}
			
			$message->send();			
		}
	}
}


header("Location: ../../messages.php?open=".$edit_msg->vars["id"]."#message_".$edit_msg->vars["id"]);
?>