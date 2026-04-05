<? include_once("./ck/db/handler.php"); ?>
<? 


	if($system==""){$system = $_GET["sys"];}
	if($account==""){$account = $_GET["acc"];}
	
	if($system != ""){
		switch($system){
			case "1":
				$accname = file_get_contents("https://www.ezpay.com/wu/balances_api/account.php?type=prs&id=$account");
			break;
			case "2":
				$accname = file_get_contents("https://www.ezpay.com/wu/balances_api/account.php?type=cus&id=$account");
			break;
			case "3":
				$credit = get_credit_account($account);
				$accname = $credit->vars["name"];
			break;
			case "4":
				$accname = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/banking/account_api.php?id=$account");
			break;
			case "5":
				$bettingac = get_betting_account($account);
				$accname = $bettingac->vars["name"];
			break;
			case "6":
				$pph = get_pph_account($account);
				$accname = $pph->vars["name"];
			break;
			case "7":
				if($account==36){
					$accname = "Intersystem Transfer";
				}				
			break;
		}
	}
	if($accname!=""){
		$saccount = array("id"=>$account,"name"=>$accname);
	}else{
		$saccount = NULL;	
	}
?>