<? if($current_clerk->im_allow("intersystem_transactions")){ 

	function insert_is_transaction($tid){
		$IStrans = get_intersystem_transaction($tid);
		
		if(!is_null($IStrans)){			
			$accs = $IStrans->get_accounts();
			$comment = "From ".$accs["from_account"]["name"] . ", ". $accs["from_system"]["name"]."";
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
			
			switch($IStrans->vars["from_system"]){
				case "1":
					$res = file_get_contents("http://vrbmarketing.com/wu/balances_api/processor_transaction.php?amount=".$IStrans->vars["amount"]."&com=".str_replace(" ","%20",$comment)."&processor=".$IStrans->vars["from_account"]."&type=$from_type&pass=VRB@ApI2012");
				break;
				case "2":
					$res = file_get_contents("http://vrbmarketing.com/wu/balances_api/customers_transaction.php?amount=".$IStrans->vars["amount"]."&com=".str_replace(" ","%20",$comment)."&customer=".$IStrans->vars["from_account"]."&type=$from_type&pass=VRB@ApI2012");
				break;
				case "3":
					$trans = new _credit_transaction();
					$from = get_credit_account($IStrans->vars["from_account"]);
					if(!is_null($from)){
						$trans->vars["amount"] = $IStrans->vars["amount"];
						$trans->vars["tdate"] = date("Y-m-d H:i:s");
						$trans->vars["note"] = $comment;
						$trans->vars["from_account"] = $IStrans->vars["from_account"];
						$trans->insert();
						$from->move_balance($IStrans->vars["amount"]*-1);
					}
				break;
				case "4":
					$res = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/banking/insert_transaction_api.php?amount=".$IStrans->vars["amount"]."&account=".$IStrans->vars["from_account"]."&com=".str_replace(" ","%20",$comment)."&type=$from_type&pass=VRB@ApI2012");
				break;
				case "5":
					$trans_id = rand();
					$trans = new _account_transaction();
					$faccount = get_betting_account($IStrans->vars["from_account"]);
					$trans->vars["account"] = $faccount->vars["id"];
					$trans->vars["transaction_id"] = $trans_id;
					$trans->vars["amount"] = $IStrans->vars["amount"];
					$trans->vars["substract"] = "1";
					$trans->vars["tdate"] = date("Y-m-d H:i:s");
					$trans->vars["description"] = $comment;
					$trans->insert();
					$trans = new _account_transaction();
					$trans->vars["account"] = "0";
					$trans->vars["transaction_id"] = $trans_id;
					$trans->vars["amount"] = $IStrans->vars["amount"];
					$trans->vars["tdate"] = date("Y-m-d H:i:s");
					$trans->vars["description"] = $comment;
					$trans->insert();
				break;
				case "6":
					$trans = new _pph_transaction();
					$from = get_pph_account($IStrans->vars["from_account"]);
					if(!is_null($from)){
						$trans->vars["amount"] = $IStrans->vars["amount"];
						$trans->vars["tdate"] = date("Y-m-d H:i:s");
						$trans->vars["note"] = $comment;
						$trans->vars["from_account"] = $IStrans->vars["from_account"];
						$trans->insert();
						$from->move_balance($IStrans->vars["amount"]*-1);
					}
				break;
				case "7":
					$amount = $IStrans->vars["amount"];
					if($from_type == "wi"){$amount *= -1;}
					$exp = new _expense();
					$exp->vars["amount"] = $amount;
					$exp->vars["category"] = $IStrans->vars["from_account"];
					$exp->vars["note"] = $comment;
					$exp->vars["edate"] = date("Y-m-d H:i:s");
					$exp->insert();
				break;
			}
			
			
			switch($IStrans->vars["to_system"]){
				case "1":
					$res = file_get_contents("http://vrbmarketing.com/wu/balances_api/processor_transaction.php?amount=".$IStrans->vars["amount"]."&com=".str_replace(" ","%20",$comment)."&processor=".$IStrans->vars["to_account"]."&type=$to_type&pass=VRB@ApI2012");
				break;
				case "2":
					$res = file_get_contents("http://vrbmarketing.com/wu/balances_api/customers_transaction.php?amount=".$IStrans->vars["amount"]."&com=".str_replace(" ","%20",$comment)."&customer=".$IStrans->vars["to_account"]."&type=$to_type&pass=VRB@ApI2012");
				break;
				case "3":
					$trans = new _credit_transaction();
					$to = get_credit_account($IStrans->vars["to_account"]);
					if(!is_null($to)){
						$trans->vars["amount"] = $IStrans->vars["amount"];
						$trans->vars["tdate"] = date("Y-m-d H:i:s");
						$trans->vars["note"] = $comment;
						$trans->vars["to_account"] = $IStrans->vars["to_account"];
						$trans->insert();
						$to->move_balance($IStrans->vars["amount"]);
					}
				break;
				case "4":
					$res = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/banking/insert_transaction_api.php?amount=".$IStrans->vars["amount"]."&account=".$IStrans->vars["to_account"]."&com=".str_replace(" ","%20",$comment)."&type=$to_type&pass=VRB@ApI2012");
				break;
				case "5":
					$trans_id = rand();
					$trans = new _account_transaction();
					$trans->vars["account"] = "0";
					$trans->vars["transaction_id"] = $trans_id;
					$trans->vars["amount"] = $IStrans->vars["amount"];
					$trans->vars["substract"] = "1";
					$trans->vars["tdate"] = date("Y-m-d H:i:s");
					$trans->vars["description"] = $comment;
					$trans->insert();
					$trans = new _account_transaction();
					$taccount = get_betting_account($IStrans->vars["to_account"]);
					$trans->vars["account"] = $taccount->vars["id"];
					$trans->vars["transaction_id"] = $trans_id;
					$trans->vars["amount"] = $IStrans->vars["amount"];
					$trans->vars["tdate"] = date("Y-m-d H:i:s");
					$trans->vars["description"] = $comment;
					$trans->insert();
				break;
				case "6":
					$trans = new _pph_transaction();
					$to = get_pph_account($IStrans->vars["to_account"]);
					if(!is_null($to)){
						$trans->vars["amount"] = $IStrans->vars["amount"];
						$trans->vars["tdate"] = date("Y-m-d H:i:s");
						$trans->vars["note"] = $comment;
						$trans->vars["to_account"] = $IStrans->vars["to_account"];
						$trans->insert();
						$to->move_balance($IStrans->vars["amount"]);
					}
				break;
				case "7":
					$amount = $IStrans->vars["amount"];
					if($to_type == "wi"){$amount *= -1;}
					$exp = new _expense();
					$exp->vars["amount"] = $amount;
					$exp->vars["category"] = $IStrans->vars["to_account"];
					$exp->vars["note"] = $comment;
					$exp->vars["edate"] = date("Y-m-d H:i:s");
					$exp->insert();
				break;
			}
			
			
		
		}
		
	}
	
	
	
	
	function inertsystem_insertion($system, $account, $amount, $type, $comment){
		
		switch($system){
			case "1":
			
				$res = file_get_contents("http://vrbmarketing.com/wu/balances_api/processor_transaction.php?amount=$amount&com=".str_replace(" ","%20",$comment)."&processor=$account&type=$type&pass=VRB@ApI2012");
				
			break;
			case "2":
			
				$res = file_get_contents("http://vrbmarketing.com/wu/balances_api/customers_transaction.php?amount=$amount&com=".str_replace(" ","%20",$comment)."&customer=$account&type=$type&pass=VRB@ApI2012");
				
			break;
			case "3":
			
				if($type == "wi"){$amount *= -1;}
				$trans = new _credit_transaction();
				$from = get_credit_account($account);
				if(!is_null($from)){
					$trans->vars["amount"] = $amount;
					$trans->vars["tdate"] = date("Y-m-d H:i:s");
					$trans->vars["note"] = $comment;
					$trans->vars["from_account"] = $account;
					$trans->insert();
					$from->move_balance($amount);
				}
				
			break;
			case "4":
			
				$res = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/banking/insert_transaction_api.php?amount=$amount&account=$account&com=".str_replace(" ","%20",$comment)."&type=$type&pass=VRB@ApI2012");
				
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
				$trans = new _account_transaction();
				$trans->vars["account"] = $acc2;
				$trans->vars["transaction_id"] = $trans_id;
				$trans->vars["amount"] = $amount;
				$trans->vars["tdate"] = date("Y-m-d H:i:s");
				$trans->vars["description"] = $comment;
				$trans->insert();
				
			break;
			case "6":			
				
				$trans = new _pph_transaction();
				$pphacc = get_pph_account($account);
				if(!is_null($pphacc)){
					$trans->vars["amount"] = $amount;
					$trans->vars["tdate"] = date("Y-m-d H:i:s");
					$trans->vars["note"] = $comment;
					$trans->vars["from_account"] = $account;
					$trans->insert();
					if($type == "wi"){$amount *= -1;}
					$pphacc->move_balance($amount);
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
				
			break;
		}
		
		
	}
	
	

}
?>