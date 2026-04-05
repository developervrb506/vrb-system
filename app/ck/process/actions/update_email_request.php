<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("email_requests")){ ?>
<? 
$req = get_email_request(clean_str_ck($_POST["rid"]));

if(!is_null($req)){

	switch(clean_str_ck($_POST["action"])){
		case "add_note":
			$req->vars["notes"] = clean_str_ck($_POST["notes"]);
			$req->update(array("notes"));
			?><script type="text/javascript">alert("Note has been Updated");</script><?
		break;
		case "complete":
			$req->vars["complete"] = 1;
			$req->update(array("complete"));
		break;
	}

}


?>
<? }else{echo "Access Denied";} ?>