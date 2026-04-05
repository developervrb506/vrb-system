<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$vars["name"] = clean_get("name");
$vars["note"] = clean_get("notes");
$vars["bonus_note"] = clean_get("bonus_note");
$vars["script_call"] = clean_get("sc1");
$vars["script_message"] = clean_get("sc2");
$vars["script_email"] = $_POST["sc3"];

if (isset($_POST["agent_list"])){
 $vars["agent_list"] = $_POST["agent_list"];	
} 
else{
 $vars["agent_list"] = 0;		
}

if (isset($_POST["mailing_system"])){
 $vars["mailing_system"] = $_POST["mailing_system"];	
} 
else{
 $vars["mailing_system"] = 0;		
}




if(isset($_POST["update_id"])){
	$vars["id"] = clean_get("update_id");
	$list = new names_list($vars);
	$list->update();
	header("Location: ../../list.php?e=4");
}else{
	$vars["admin"] = $current_clerk->vars["id"];
	$vars["position"] = count(get_all_names_list()) + 1;
	$list = new names_list($vars);
	$list->insert();
	header("Location: ../../upload_names.php?list=".$list->vars["id"]."&e=0");
}
?>