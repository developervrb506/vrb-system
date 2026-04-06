<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
	delete_custom_campaign($_GET["cam"]);

header("Location: " . BASE_URL . "/dashboard/custom_campaigns.php?e=17");	

?>