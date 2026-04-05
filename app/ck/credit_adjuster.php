<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("credit_accounting")){ ?>
<?
$from = "1900-01-01";
$to = "7000-01-01";
$agents = get_all_credit_accounts();
foreach($agents as $acc){
	echo $acc->vars["name"] . " : ";
	$balance = 0;
	
	$trans = search_credit_adjustments($from, $to, $acc->vars["id"]);
	foreach($trans as $tr){$balance += $tr->vars["amount"];}
	
	$trans = search_credit_transaction($from, $to, $acc->vars["id"]);
	foreach($trans as $tr){
		if(){
			
		}else{
			
		}
	}
}


}
?>