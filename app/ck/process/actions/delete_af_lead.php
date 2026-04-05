<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("affiliate_leads")){ ?>
<? include(ROOT_PATH . "/ck/balances/api/insert_transaction.php"); ?>
<?
$lead = get_affiliate_lead(clean_get("af",true));
if(!is_null($lead)){
	$lead->vars["deleted"] = "1";
	$lead->update(array("deleted"));
}
header("Location: http://localhost:8080/ck/affiliates_leads.php?e=83");
?>
<? }else{echo "Access Denied";} ?>