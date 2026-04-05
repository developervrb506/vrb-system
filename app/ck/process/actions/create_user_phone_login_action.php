<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?
$clerk = clean_get("clerk");
$vars["login"] = clean_get("login");
$vars["comment"] = clean_get("comment");
$vars["agent"] = $clerk;


	$phone_login = new _phone_login();
	$phone_login->vars["login"] = clean_get("login");
    $phone_login->vars["comment"] = clean_get("comment");
    $phone_login->vars["agent"] = $clerk;
	
	$phone_login->insert();
    header("Location: http://localhost:8080/ck/create_user.php?uid=".$clerk."");

?>
