<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliate_leads")){ ?>
<? include(ROOT_PATH . "/ck/balances/api/insert_transaction.php"); ?>
<?
$account = get_pph_account(clean_get("ac",true));
if(!is_null($account)){
	
	if($account->vars["deleted"]){$account->vars["deleted"] = "0";}else{$account->vars["deleted"] = "1";}
	
	$account->update(array("deleted"));
}
header("Location: " . BASE_URL . "/ck/pph.php?e=94");
?>
<? }else{echo "Access Denied";} ?>