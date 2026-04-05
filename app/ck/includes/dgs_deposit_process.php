<?
$data = explode("_*_",two_way_enc($_GET["mts"],true));
$tid = $data[0];
$account = $data[1];
$method = strtoupper($data[2]);
$mtcn = $data[3];
$amount = $data[4];
$fees = $data[5];
$bonus = $data[6];
$payment_method = $data[7];
$description = $data[8];

$casino_bonus_percentage = "200";
$casino_bonus_rollover = "75";

if($method == "WU"){
	$pm = 90;
	$mname = "Western Union";
	$cname = "MTCN:";
}else if($method == "MG"){
	$pm = 100;
	$mname = "Moneygram";
	$cname = "Ref:";
}else if($method == "PT"){
	$pm = "";
	//$mfilter = "91,101,95,94,131";
	$mfilter = "91,138,131,157,162";
	$mname = "Prepaid";
	$cname = "";
}else if($method == "MP"){
	$pm = "130";
	$mfilter = "130,162";
	$mname = "Moneypak";
	$cname = "#";
}else if($method == "RE"){
	$pm = "135";
	$mfilter = "135,162";
	$mname = "Reloadit";
	$cname = "#";
}else if($method == "SD"){
	$pm = $payment_method;
	$mfilter = $payment_method.",162";
	$mname = "Special Deposit";
	$cname = "";
}else if($method == "BTC"){
	$pm = "134";
	$mfilter = "134,162";
	$mname = "Bitcoin Deposit";
	$cname = "";
}else if($method == "GFT"){
	/*$pm = "134";
	$mfilter = "130";*/
	$mname = "GiftCard Deposit";
	$cname = "";
}else if($method == "CC"){
	$pm = "128";
	$mfilter = "128,162";
	$mname = "Credit Card";
	$cname = "CC Number";
}else if($method == "VCC"){
	$mname = "Paypal";
}else if($method == "BWD"){
	$mname = "Bank Wire";
}
?>