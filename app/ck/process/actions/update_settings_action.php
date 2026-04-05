<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<?


foreach($gsettings as $set){
	$set->vars["value"]	 = clean_get($set->vars["id"]);
	$set->update();
}

header("Location: ../../settings.php?e=19");

?>