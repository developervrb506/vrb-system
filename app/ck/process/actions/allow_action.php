<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$lists = get_all_names_list();


foreach($lists as $list){
	$list->vars["allow"] = clean_get("allow_".$list->vars["id"]);
	$list->update(array("allow"));
}

header("Location: ../../list.php?e=16");
?>