<?

	function insert_is_transaction($tid){
		$IStrans = get_intersystem_transaction($tid);
		
		if(!is_null($IStrans)){	
				
			$accs = $IStrans->get_accounts();
			$comment = "Intersystem Transaction #".$IStrans->vars["id"];
			$comment .= " / From ".$accs["from_account"]["name"] . ", ". $accs["from_system"]["name"]."";
			$comment .= " To ".$accs["to_account"]["name"] . ", ". $accs["to_system"]["name"]."";
			$comment .= " - ".$IStrans->vars["note"];
			if(!$accs["from_system"]["is_liability"] && $accs["to_system"]["is_liability"]){
				$from_type = "wi";
				$to_type = "wi";
			}else if($accs["from_system"]["is_liability"] && !$accs["to_system"]["is_liability"]){
				$from_type = "de";
				$to_type = "de";
			}else{
				$from_type = "wi";
				$to_type = "de";
			}
			
			$IStrans->vars["from_transaction"] = inertsystem_insertion($IStrans->vars["from_system"], $IStrans->vars["from_account"], $IStrans->vars["amount"], $from_type, $comment);
			
			$IStrans->vars["to_transaction"] = inertsystem_insertion($IStrans->vars["to_system"], $IStrans->vars["to_account"], $IStrans->vars["amount"], $to_type, $comment);
			
			$IStrans->update(array("from_transaction","to_transaction"));		
		
		}
		
	}
	
	
	
	
	function inertsystem_insertion($system, $account, $amount, $type, $comment){
		
		switch($system){
			case "1":
			
				$res = file_get_contents("https://www.ezpay.com/wu/balances_api/processor_transaction.php?amount=$amount&com=".urlencode($comment)."&processor=$account&type=$type&pass=VRB@ApI2012");
				
			break;
			case "2":
			
				$res = file_get_contents("https://www.ezpay.com/wu/balances_api/customers_transaction.php?amount=$amount&com=".urlencode($comment)."&customer=$account&type=$type&pass=VRB@ApI2012");
				
			break;
			case "3":
			
				if($type == "de"){
					$str_acc = "to_account";
				}else if($type == "wi"){
					$str_acc = "from_account";
				}
				$trans = new _credit_transaction();
				$from = get_credit_account($account);
				if(!is_null($from)){
					$trans->vars["amount"] = $amount;
					$trans->vars["tdate"] = date("Y-m-d H:i:s");
					$trans->vars["note"] = $comment;
					$trans->vars[$str_acc] = $account;
					$trans->insert();
					if($type == "wi"){$amount *= -1;}
					$from->move_balance($amount);
					$res = $trans->vars["id"];
				}
				
			break;
			case "4":
			
				$res = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/banking/insert_transaction_api.php?amount=$amount&account=$account&com=".urlencode($comment)."&type=$type&pass=VRB@ApI2012");
				
			break;
			case "5":
			
				if($type == "de"){
					$acc1 = "0";
					$acc2 = get_betting_account($account);
				}else if($type == "wi"){
					$acc1 = get_betting_account($account);
					$acc2 = "0";
				}
			
				$trans_id = rand();
				$trans = new _account_transaction();
				$trans->vars["account"] = $acc1;
				$trans->vars["transaction_id"] = $trans_id;
				$trans->vars["amount"] = $amount;
				$trans->vars["substract"] = "1";
				$trans->vars["tdate"] = date("Y-m-d H:i:s");
				$trans->vars["description"] = $comment;
				$trans->insert();
				$res = $trans->vars["id"];
				$trans = new _account_transaction();
				$trans->vars["account"] = $acc2;
				$trans->vars["transaction_id"] = $trans_id;
				$trans->vars["amount"] = $amount;
				$trans->vars["tdate"] = date("Y-m-d H:i:s");
				$trans->vars["description"] = $comment;
				$trans->insert();
				$res .= $trans->vars["id"];
				
			break;
			case "6":			
				if($type == "de"){
					$str_acc = "to_account";
				}else if($type == "wi"){
					$str_acc = "from_account";
				}
				$trans = new _pph_transaction();
				$pphacc = get_pph_account($account);
				if(!is_null($pphacc)){
					$trans->vars["amount"] = $amount;
					$trans->vars["tdate"] = date("Y-m-d H:i:s");
					$trans->vars["note"] = $comment;
					$trans->vars[$str_acc] = $account;
					$trans->insert();
					if($type == "wi"){$amount *= -1;}
					$pphacc->move_balance($amount);
					$res = $trans->vars["id"];
				}
				
			break;
			case "7":
			
				if($type == "wi"){$amount *= -1;}
				$exp = new _expense();
				$exp->vars["amount"] = $amount;
				$exp->vars["category"] = $account;
				$exp->vars["note"] = $comment;
				$exp->vars["edate"] = date("Y-m-d H:i:s");
				$exp->insert();
				$res = $exp->vars["id"];
			break;
		}
		
		return $res;
		
	}
	
	
?>