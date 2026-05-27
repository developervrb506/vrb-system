<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?
$trans = get_moneypak_transaction($_GET["id"]);
if(!is_null($trans)){	
	
	if($trans->vars["active"]){
		$trans->vars["archived"] = 1;
		$trans->vars["active"] = 0;
	}else{
		$trans->vars["archived"] = 0;
		$trans->vars["active"] = 1;
	}
	$trans->update(array("archived","active"));
	
}

header("Location: " . BASE_URL . "/ck/moneypak_transactions.php?e=76");

?>
<? }else{echo "Access Denied";} ?>