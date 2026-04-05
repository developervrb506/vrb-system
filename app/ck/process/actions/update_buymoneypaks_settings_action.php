<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<?
$bmsettings = _get_buy_moneypaks_settings();
foreach($bmsettings as $set){
	$set->vars["value"]	 = clean_get($set->vars["id"]);
	$set->update();
}

header("Location: ../../buymoneypak_settings.php?e=19");

?>