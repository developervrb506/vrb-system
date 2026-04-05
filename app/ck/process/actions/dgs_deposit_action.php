<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("dgs_money_transfers")){ ?>
<?

$payment_method = $_POST["methods_list"];
$fees = $_POST["fees"];
$fees_method = $_POST["fees_method"];
$bonus = $_POST["bonus"];
$bonus_method = $_POST["bonus_method"];
$rollover = $_POST["rollover"];
$casino_bonus = $_POST["cbonus"];
$account = str_replace(" ","__",$_POST["account"]);
$method = strtoupper($_POST["method"]);
$mtcn = $_POST["mtcn"];
$amount = $_POST["amount"];
$amount_for_bonus = $_POST["amount"];
$description = $_POST["description"];

$tid = $_POST["transaction"];

switch($method){
	case "MG":
		$ddesc = "MG REF $mtcn";
		$fdesc = "MG FEES REF $mtcn";
	break;
	case "WU":
		$ddesc = "WU MTCN $mtcn";
		$fdesc = "WU FEES MTCN $mtcn";
	break;
	case "PT":
		$parts = explode(" ",$mtcn);
		$ddesc = "Prepaid " . "###########" .substr($parts[1],-4);
		$fdesc = "FEES " . "###########" .substr($parts[1],-4);
	break;	
	case "MP":
		$ddesc = "Moneypak " . "##########" .substr($mtcn,-4);
		$fdesc = "FEES Moneypak ". "##########" .substr($mtcn,-4);
	break;	
	case "BWD":
		$ddesc = "BANK WIRE DEPOSIT";
		$fdesc = "FEES BANK WIRE DEPOSIT";
	break;	
	case "RE":
		$ddesc = "Reloadit " . "##########" .substr($mtcn,-4);
		$fdesc = "FEES Reloadit " . "##########" .substr($mtcn,-4);
	break;	
	case "SD":
		$ddesc = "SPECIAL DEPOSIT";
		$fdesc = "FEES SPECIAL DEPOSIT";
	break;	
	case "BTC":
		$ddesc = "BITCOIN DEPOSIT";
		$fdesc = "FEES BITCOIN DEPOSIT";
	break;	
	case "GFT":
		$ddesc = "GIFTCARD DEPOSIT";
		$fdesc = "FEES GIFTCARD DEPOSIT";
	break;	
	case "CC":
		$ddesc = "";
		$fdesc = "CREDITCARD FEES";
		$amount = '0'; // This is used for Credit cards Bonus. Only.
	break;
	case "VCC":
		$ddesc = "PAYPAL DEPOSIT";
		$fdesc = "PAYPAL DEPOSIT FEES";
	break;	
}

//Deposit
$ddata = array();
$ddata["player"] = $account;
$ddata["amount"] = $amount;
$ddata["description"] = $ddesc;
$ddata["payment_method"] = $payment_method;
$ddata["type"] = "R";

//fees
if($fees > 0){
	$fdata = array();
	$fdata["amount"] = $fees;
	$fdata["description"] = $fdesc;
	$fdata["payment_method"] = "2";
	$fdata["type"] = $fees_method;
	$fkey = implode("_*_",$fdata);
}

//bonus
if($bonus > 0){
	$bamount = $amount_for_bonus * ($bonus / 100);
	$bdata = array();
	$bdata["amount"] = $bamount;
	$bdata["description"] = $bonus."% EXTRA BONUS ".$rollover."XRO";
	$bdata["payment_method"] = "2";
	$bdata["type"] = $bonus_method;
	$bdata["percentage"] = $bonus;
	$bdata["rollover"] = $rollover;
	$bkey = implode("_*_",$bdata);
}

//casino bonus
if($casino_bonus > 0){
	$cbdata = array();
	$cbdata["amount"] = $casino_bonus;
	$cbkey = implode("_*_",$cbdata);
}

$ukey = $current_clerk->vars["id"]."_*_".$tid;
$dkey = implode("_*_",$ddata);

$data = array("transaction"=>two_way_enc(mt_rand()),
				"d"=>two_way_enc($dkey),
				"f"=>two_way_enc($fkey),
				"b"=>two_way_enc($bkey),
				"cb"=>two_way_enc($cbkey),
				"u"=>two_way_enc($ukey),
				"status"=>two_way_enc(mt_rand()));
				
$cash_url = "cash.ezpay.com";
if(@file_get_contents("http://cash.ezpay.com/checker.php") != 'OK'){$cash_url = "www.sportsbettingonline.ag";}
				
echo do_post_request("http://$cash_url/utilities/process/reports/process_dgs_transaction.php",$data);

//$id_player, $amount, $desc, $payment_method, $type

?>
<? }else{echo "Access Denied";} ?>