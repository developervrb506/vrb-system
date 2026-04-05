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
			
			$deposit->vars["from_account"] = $agent->vars["id"];
			$deposit->vars["to_account"] = "0";
			$deposit->vars["amount"] = $amount;
			$deposit->vars["tdate"] = date("Y-m-d H:i:s");
			$deposit->vars["note"] = $description;
			$deposit->vars["external_id"] = $external_id;
			$deposit->insert();			
			$agent->move_balance("-".$amount);
			
			$result["result"] = "900";
			$result["did"] = $deposit->vars["id"];
			
			
			//Revert Account
			$revert_account = get_pph_revert_account_by_name($agent->vars["name"]);
			if(!is_null($revert_account)){
				$rev_deposit = clone $deposit;
				$rev_deposit->vars["from_account"] = $revert_account->vars["id"];
				$rev_deposit->vars["amount"] *= -1;
				$rev_deposit->insert();
				$revert_account->move_balance($amount);
			}
			
			
			//Master Agents
			$master_agent = get_pph_account($agent->vars["master_agent"]);
			while(!is_null($master_agent)){
				$master_deposit = clone $deposit;
				$master_deposit->vars["from_account"] = $master_agent->vars["id"];
				$master_deposit->insert();
				$master_agent->move_balance("-".$amount);

				$master_agent = get_pph_account($master_agent->vars["master_agent"]);
			}
			
			

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