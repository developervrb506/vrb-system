<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?
$trans = get_moneypak_transaction($_GET["id"]);
if(!is_null($trans)){	
	
	$trans->vars["confirmed"] = $_GET["con"];		
	$trans->update(array("confirmed"));
	
	echo "Done";
}
?>
<? }else{echo "Access Denied";} ?>