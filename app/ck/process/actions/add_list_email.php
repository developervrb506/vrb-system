<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?

	$name = new _list_email();
	$name->vars["name"]= $_POST["name"];
	$name->vars["email"] = $_POST["email"];
	$name->vars["list"] = $_POST["list"];
	$name->insert();

header("Location: " . BASE_URL . "/ck/".$_POST["url"]."?e=80");
?>