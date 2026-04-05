<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("external_pph_billing")){ ?>
<?
$account = get_pph_account_external(clean_get("ac",true));
if(!is_null($account)){
	
	if($account->vars["deleted"]){$account->vars["deleted"] = "0";}else{$account->vars["deleted"] = "1";}
	
	$account->update(array("deleted"));
}
header("Location: http://localhost:8080/ck/pph_external.php?e=94");
?>
<? }else{echo "Access Denied";} ?>