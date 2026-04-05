<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
//
$name = clean_get("firstname");
$lastname = clean_get("lastname");
$email = clean_get("email");
$phone = clean_get("phone");
$amount = clean_get("amount");
$cvv = clean_get("cvv");
$cardnumber = clean_get("cardnumber");
$birthdate = clean_get("birthdate");
$exp_month = clean_get("exp_month");
$exp_year = clean_get("exp_year");
$country = clean_get("country");
$adress= clean_get("address");
$city = clean_get("city");
$state = clean_get("state");
$zip = clean_get("zip");
$processor =  clean_get("processor");

 

//Processor 1 :  CCTransRequestB1, CCTransRequestB1Result
//Processor 2 : CCTransRequestB12, CCTransRequestB12Result



$client = new SoapClient("https://mg-cr.net/webservicecc/cctranssvc.asmx?wsdl", array('trace' => true));
$data = array(
		"Amount"=>$amount,
		"CardHolderName"=>$name,
		"CardHolderLastName"=>$lastname,
		"CardHolderAddress"=>$adress,
		"CardHolderBirthDate"=>date('YYYYMMDD',strtotime($birthdate)),  //YYYYMMDD
		"CardHolderZipCode"=>$zip,
		"CardHolderCity"=>$city,
		"CardHolderState"=>$state,
		"CardHolderCountryCode"=>$country,
		"CardHolderPhone"=>$phone,
		"CardHolderEmail"=>$email,
		"CardNumber"=>$cardnumber,
		"CardSecurityCode"=>$cvv,
		"ExpMonth"=>$exp_month,
		"ExpYear"=>$exp_year,
		
		"UserName"=>"kevmwws10",
		"Password"=>"kvmwws12551125"
);




if  ($processor == 1){
	$res = $client->CCTransRequestB1($data);
	$doc = new DOMDocument();
	$doc->loadXML($res->CCTransRequestB1Result);
}
else if ($processor == 2){
	$res = $client->CCTransRequestB12($data);
	$doc = new DOMDocument();
	$doc->loadXML($res->CCTransRequestB12Result);
	
}

$result = $doc->getElementsByTagName("Message")->item(0)->nodeValue;


	
header("Location: ../../prepaid_test.php?result=$result");

?>