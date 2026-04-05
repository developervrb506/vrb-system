<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("users")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?
$clerk = clean_get("clerk");

	$agent_aff = new _affiliate_by_clerk();
	$agent_aff->vars["clerk"]= $clerk;
	$agent_aff->vars["aff"] =  clean_get("aff_code");
	$agent_aff->insert();
	
    header("Location: http://localhost:8080/ck/create_user.php?uid=".$clerk."");

?>
