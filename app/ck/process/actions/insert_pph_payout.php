<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
if(md5($_POST["fire"]) == "70be2ae2f6278f582cc6bbab369b2f2d"){
	$account = clean_str_ck($_POST["account"]);
	$amount = clean_str_ck($_POST["amount"]);
	$description = clean_str_ck($_POST["notes"]);
	$external_id = clean_str_ck($_POST["exid"]);
	
	$agent = get_pph_account_by_name($account);
	$duplicate = get_pph_transaction_by_exid($external_id);
	
	if(!is_null($agent)){
		
		if(is_null($duplicate)){
			
			$deposit = new _pph_transaction();
			
			$deposit->vars["from_account"] = "0";
			$deposit->vars["to_account"] = $agent->vars["id"];
			$deposit->vars["amount"] = $amount;
			$deposit->vars["tdate"] = date("Y-m-d H:i:s");
			$deposit->vars["note"] = $description;
			$deposit->vars["external_id"] = $external_id;
			$deposit->insert();
			
			$agent->move_balance($amount);
			
			$result["result"] = "900";
			$result["did"] = $deposit->vars["id"];

		}else{
			$result["result"] = "101";
			$result["detail"] = "Duplicate transaction. Transaction is already in PPH system.";
		}
	
	}else{
		$result["result"] = "100";
		$result["detail"] = "PPH account not found.";
	}
	
	echo json_encode($result);
}
?>