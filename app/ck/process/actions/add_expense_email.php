<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_main_page")){ ?>
<?

	$name = new _expense_email();
	$name->vars["name"]= $_POST["name"];
	$name->vars["email"] = $_POST["email"];
	$name->insert();


header("Location: " . BASE_URL . "/ck/expense_email_list.php?e=80");
?>
<? }else{echo "Access Denied";} ?>