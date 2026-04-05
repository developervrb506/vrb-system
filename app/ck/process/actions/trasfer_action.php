<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?

if(isset($_POST["start"])){
	$name = get_open_call($current_clerk->vars["id"]);
	$vars["from"] = $current_clerk->vars["id"];
	$vars["to"] = clean_get("clerk_list");
	$vars["call"] = $name->vars["current_call"];
	if(is_null(get_open_call($vars["to"]))){
		$transfer = new transfer_relation($vars);
		$transfer->insert();
		header("Location: ../../transfering.php");
	}else{
		header("Location: ../../call.php?e=22");	
	}
}else if(isset($_POST["accepted"])){
	$transfer = get_transfer_relation($current_clerk->vars["id"]);
	if(!is_null($transfer)){
		if($_POST["accepted"]){
			$transfer->vars["call"]->vars["clerk"] = $current_clerk->vars["id"];
			$transfer->vars["call"]->update(array("clerk"));
			$name = get_ckname($transfer->vars["call"]->vars["name"]);
			$name->vars["clerk"] = $current_clerk->vars["id"];
			$name->update(array("clerk"));
			
			$transfer->vars["pending"] = "0";
			$transfer->update(array("pending"));
			$transfer->insert_log("ac");
			header("Location: ../../call.php");
		}else{
			$transfer->insert_log("de");
			$transfer->delete();	
			header("Location: ../../index.php?e=25");
		}
	}else{
		header("Location: ../../index.php?e=27");	
	}
}else{
	header("Location: ../../index.php");	
}

?>