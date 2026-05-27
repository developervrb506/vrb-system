<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?
$trans = get_moneypak_transaction($_GET["id"]);
if(!is_null($trans)){	
	
	if($trans->vars["authorized"]){
		$trans->vars["authorized"] = 0;
	}else{
		$trans->vars["authorized"] = 1;
	}
	$trans->update(array("authorized"));
	
}

header("Location: " . BASE_URL . "/ck/moneypak_transactions.php?e=76");

?>
<? }else{echo "Access Denied";} ?>