<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if(!$current_clerk->im_allow("users")) {
 include(ROOT_PATH . "/ck/process/admin_security.php");
} 
?>
<?
//echo "<pre>";
$vars["name"] = clean_get("name");
$vars["manager"] = clean_get("manager");
$vars["schedule"] = clean_get("schedule");

if(isset($_POST["update_id"])){
	$vars["id"] = clean_get("update_id");
	$group = new user_group($vars);
	$group->update();	
	header("Location: ../../user_groups.php?e=21");	
}else{
	$group = new user_group($vars);
	$group->insert();
	header("Location: ../../user_groups.php?e=20");
}
?>