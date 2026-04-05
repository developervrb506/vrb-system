<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("insert_dgs_payout")){ ?>
<?

$payment_method = strtoupper($_POST["methods_list"]);
$fees = $_POST["fees"];
if($fees < 0){$fees * -1;}
$account = $_POST["account"];
$method = $_POST["method"];
$amount = $_POST["amount"];

$tid = $_POST["transaction"];

switch($method){
	case "MG":
		$ddesc = "MG PAYOUT";
		$fdesc = "MG PAYOUT FEES";
	break;
	case "WU":
		$ddesc = "WU PAYOUT";
		$fdesc = "WU PAYOUT FEES";
	break;
	case "MO":
		$ddesc = "MONEY ORDER PAYOUT";
		$fdesc = "MONEY ORDER PAYOUT FEES";
	break;	
	case "SP":
		$ddesc = "SPECIAL PAYOUT";
		$fdesc = "SPECIAL PAYOUT FEES";
	break;	
	case "MP":
		$mp = get_moneypak_transaction(str_replace("MP","",$tid));
		$ddesc = "MONEYPAK PAYOUT";
		
		$deposits = explode(",",$mp->vars["deposit"]);
		$nnumber = "";
		foreach($deposits as $depid){
			$deposit = get_moneypak_transaction($depid);
			if(!is_null($deposit)){
				if($nnumber != ""){$del = " / ";}
				$nnumber .= $del . "##########" .substr($deposit->vars["number"],-4);
			}	
		}
		
		$dref = "NUMBER: " . $nnumber;
		
		$fdesc = "MONEYPAK PAYOUT FEES";
	break;
	case "RE":
		$mp = get_reloadit_transaction(str_replace("RE","",$tid));
		$ddesc = "RELOADIT PAYOUT";
		$dref = "NUMBER: " . "##########" .substr($mp->vars["number"],-4);
		$fdesc = "RELOADIT PAYOUT FEES";
	break;	
	case "CP":
		$ddesc = "CHECK PAYOUT";
		$fdesc = "CHECK PAYOUT FEES";
	break;	
	case "VCC":
		$ddesc = "VIRTUAL CC PAYOUT";
		$fdesc = "VIRTUAL CC PAYOUT FEES";
	break;
	case "BTP":
		$ddesc = "BITCOINS PAYOUT";
		$fdesc = "BITCOINS PAYOUT FEES";
	break;
	case "PTP":
		$ddesc = "PREPAID GIFTCARD PAYOUT";
		$fdesc = "PREPAID GIFTCARD PAYOUT FEES";
	break;
	case "PPP":
		$ddesc = "PAYPAL PAYOUT";
		$fdesc = "PAYPAL PAYOUT FEES";
	break;	
}

//Deposit
$ddata = array();
$ddata["player"] = $account;
$ddata["amount"] = $amount;
$ddata["description"] = $ddesc;
$ddata["payment_method"] = $payment_method;
$ddata["type"] = "D";
$ddata["reference"] = $dref;

//fees
if($fees > 0){
	$fdata = array();
	$fdata["amount"] = $fees;
	$fdata["description"] = $fdesc;
	$fdata["payment_method"] = "2";
	$fdata["type"] = "A";
	$fkey = implode("_*_",$fdata);
}


$ukey = $current_clerk->vars["id"]."_*_".$tid;
$dkey = implode("_*_",$ddata);

$data = array("transaction"=>two_way_enc(mt_rand()),
				"d"=>two_way_enc($dkey),
				"f"=>two_way_enc($fkey),
				"u"=>two_way_enc($ukey),
				"status"=>two_way_enc(mt_rand()));
				
$cash_url = "cash.ezpay.com";
if(@file_get_contents("http://cash.ezpay.com/checker.php") != 'OK'){$cash_url = "www.sportsbettingonline.ag";}
				
echo do_post_request("http://$cash_url/utilities/process/reports/process_dgs_payout.php",$data);

?>
<? }else{echo "Access Denied";} ?>