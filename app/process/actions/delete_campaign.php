<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
	delete_custom_campaign($_GET["cam"]);

header("Location: http://localhost:8080/dashboard/custom_campaigns.php?e=17");	

?>