<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("dgs_money_transfers")){ ?>
<?
$account = $_POST["account"];
$method = strtoupper($_POST["method"]);
$mtcn = $_POST["mtcn"];
$amount = $_POST["amount"];
$description = $_POST["description"];

$tid = $_POST["transaction"];

switch($method){
	case "MG":
		$ddesc = "MG REF $mtcn";
	break;
	case "WU":
		$ddesc = "WU MTCN $mtcn";
	break;
	case "PT":
		$ddesc = "$mtcn";
	break;	
	case "MP":
		$ddesc = "Moneypak $mtcn";
	break;	
	case "RE":
		$ddesc = "Reloadit $mtcn";
	break;	
	case "SD":
		$ddesc = "SPECIAL DEPOSIT";
	break;	
	case "BTC":
		$ddesc = "BITCOIN DEPOSIT";
	break;	
	case "GFT":
		$ddesc = "GIFTCARD DEPOSIT";
	break;	
}


$agent = get_pph_account_by_name($account);

if(!is_null($agent)){
	
	$deposit = new _pph_transaction();
	
	$deposit->vars["from_account"] = $agent->vars["id"];
	$deposit->vars["to_account"] = "0";
	$deposit->vars["amount"] = $amount;
	$deposit->vars["tdate"] = date("Y-m-d H:i:s");
	$deposit->vars["note"] = $ddesc;
	$deposit->insert();
	
	$agent->move_balance("-".$amount);
	
	$url = "https://www.ezpay.com/wu/process/actions/mark_transaction_popup.php";
	$url .= "?dgsdID=".$deposit->vars["id"]."&tid=".$tid."&cc=".$current_clerk->vars["id"]."&pm=".$method;
	?><script type="text/javascript">location.href = '<? echo $url ?>';</script><?

}



?>
<? }else{echo "Access Denied";} ?>