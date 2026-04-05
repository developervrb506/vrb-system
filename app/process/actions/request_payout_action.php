<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?

$method = clean_str($_POST["type"]);
$code = get_affiliate_code($current_affiliate->id,1);
$balance = str_replace("$","",get_wagerweb_customer_balance($code));


switch ($method) {
	case "neteller":
		$amount = clean_str($_POST["amount"]);
		$account = clean_str($_POST["account"]);
		$type = "NETeller";
		$content = "NETeller Account ID: $account<br />";
		break;
	case "moneybookers":
		$amount = clean_str($_POST["amount"]);
		$email = clean_str($_POST["email"]);
		$type = "Moneybookers";
		$content = "Email registered with MB: $email<br />";
		break;
	case "westernunion":
		$amount = clean_str($_POST["amount"]);
		$type = "Western Union";
		break;
	case "moneygram":
		$amount = clean_str($_POST["amount"]);
		$type = "MoneyGram";
		break;
	case "cashierscheck":
		$amount = clean_str($_POST["amount"]);
		$name = clean_str($_POST["name"]);
		$address = clean_str($_POST["address"]);
		$city = clean_str($_POST["city"]);
		$state = clean_str($_POST["state"]);
		$country = clean_str($_POST["country"]);
		$zip = clean_str($_POST["zip"]);
		$type = "Cashiers Check";
		$content = "Payee Name: $name<br />";
		$content .= "Address: $address<br />";
		$content .= "City: $city<br />";
		$content .= "State / Province: $state<br />";
		$content .= "Country: $country<br />";
		$content .= "Zip Code: $zip<br />";
		break;	
}
if($amount != "" && $amount <= $balance && $amount > 0){
	$subject = "VRB New Payout Request";
	$body = $current_affiliate->get_fullname()." (". $code .") requested a new Payout.";
	$body .= "<br /><br />Type: $type<br />Payout Amount: $".$amount."<br />";
	$body .= $content;
	
	email_to_clercks($subject, $body, true);
	
	header("Location: ../../dashboard/payouts.php?w=$method&e=14");	 
}else{
	header("Location: ../../dashboard/payouts.php?w=$method&e=15");
}
	

?>