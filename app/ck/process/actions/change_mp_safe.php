<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<?
$trans = get_moneypak_transaction($_GET["id"]);
if(!is_null($trans)){	
	
	if($trans->vars["safe"]){
		$trans->vars["safe"] = 0;
	}else{
		$trans->vars["safe"] = 1;
	}
	$trans->update(array("safe"));
	
}

header("Location: http://localhost:8080/ck/moneypak_transactions.php?safe=".$_GET["safe"]."&e=76");

?>
<? }else{echo "Access Denied";} ?>