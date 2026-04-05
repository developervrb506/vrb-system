<?
include(ROOT_PATH . "/ck/db/handler.php");

$account = get_pph_account_by_name(clean_str_ck($_GET["acc"]));

if(!is_null($account)){
	if($_GET["simple"]){echo $account->vars["balance"];}
	else if($_GET["simple_alert"]){
	
		$balance = $account->vars["balance"];
		if($balance > $account ->vars["balance_alert"] && $account ->vars["balance_alert"] > 0){
			$alert = 1;
		}else{
			$alert = 0;	
		}
		
		echo json_encode(array("balance"=>$balance,"alert"=>$alert));
		
	}else{
		?>
		<div class="titulo_black_banking">
			Your Balance:
			<a href="report.php" class="normal_link">$<? echo $account->vars["balance"] ?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="report.php" class="normal_link">View Report</a>
		</div>
		<?
	}
}else{
	if($_GET["simple"]){echo "N/D";}
}
?>