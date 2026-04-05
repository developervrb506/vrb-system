<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
if(md5($_POST["fire"]) == "70be2ae2f6278f582cc6bbab369b2f2d"){
	$transaction = get_pph_transaction(clean_str_ck($_POST["tid"]));
	
	if(!is_null($transaction)){
			
			$deposit = new _pph_transaction();
			$agent = get_pph_account($transaction->vars["from_account"] ->vars["id"]);
			
			$deposit->vars["from_account"] = "0";
			$deposit->vars["to_account"] = $transaction->vars["from_account"] ->vars["id"];
			$deposit->vars["amount"] = $transaction->vars["amount"];
			$deposit->vars["tdate"] = date("Y-m-d H:i:s");
			$deposit->vars["note"] = "CANCELED ".$transaction->vars["note"];
			$deposit->insert();
			
			$agent->move_balance($transaction->vars["amount"]);
			
			$result["result"] = "900";
			$result["did"] = $deposit->vars["id"];
	
	}else{
		$result["result"] = "100";
		$result["detail"] = "PPH transaction not found.";
	}
	
	echo json_encode($result);
}
?>