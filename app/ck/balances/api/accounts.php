<? include_once(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("intersystem_transactions")){ 


	if($system==""){$system = $_GET["sys"];}
	if($name==""){$name = $_GET["nm"];}
	if($select_option==""){$select_option = $_GET["so"];}
	
	if($system != ""){
		switch($system){
			case "1":
				$accs = file_get_contents("https://www.ezpay.com/wu/balances_api/accounts.php?type=prs");
			break;
			case "2":
				$accs = file_get_contents("https://www.ezpay.com/wu/balances_api/accounts.php?type=cus");
			break;
			case "3":
				$credits = get_all_credit_accounts();
				$accs = "";
				foreach($credits as $credit){
					$accs .= ",".$credit->vars["id"] . "/".$credit->vars["name"];
				}
				$accs = substr($accs,1);
			break;
			case "4":
				$accs = file_get_contents("http://www.sportsbettingonline.ag/utilities/process/banking/accounts_api.php");
			break;
			case "5":
				$bettingacs = get_all_betting_accounts();
				$accs = "";
				foreach($bettingacs as $bacc){
					$accs .= ",".$bacc->vars["id"] . "/".$bacc->vars["name"];
				}
				$accs = substr($accs,1);
			break;
			case "6":
				$pphs = get_all_pph_accounts();
				$accs = "";
				foreach($pphs as $pph){
					$accs .= ",".$pph->vars["id"] . "/".$pph->vars["name"];
				}
				$accs = substr($accs,1);
			break;
			case "7":
				$accs = "36/Intersystem Transfer";
			break;
		}
		
		if($accs!=""){
			$accounts = explode(",",$accs);
			?> <select name="<? echo $name ?>" id="<? echo $name ?>"> <?
			if($select_option){ ?><option value="">Select</option><? }
			foreach($accounts as $acc){
				$data = explode("/",$acc);
				?>
				<option value="<? echo $data[0] ?>" ><? echo $data[1] ?></option>
				<?
			}
			?></select><?
		}else{
			?><input type="hidden" value="" name="<? echo $name ?>" id="<? echo $name ?>" /><?
		}
	}else{
		?><input type="hidden" value="" name="<? echo $name ?>" id="<? echo $name ?>" /><?
	}

}
?>