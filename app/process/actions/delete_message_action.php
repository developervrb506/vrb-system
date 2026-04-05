<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
	delete_message($current_affiliate, $_GET["mid"]);

header("Location: ../../dashboard/messages.php?e=9");

?>