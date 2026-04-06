<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?

$camp = get_custom_campaign(clean_str($_POST["cid"]));

if(!is_null($camp)){
	$camp->name = clean_str($_POST["name"]);
	$camp->desc = clean_str($_POST["desc"]);
	
	update_custom_campaign($camp);
}
header("Location: " . BASE_URL . "/dashboard/custom_campaigns.php?e=16");	 

?>