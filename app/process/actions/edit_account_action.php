<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
$firstname   = clean_str($_POST["firstname"]);
$lastname    = clean_str($_POST["lastname"]);
$address     = clean_str($_POST["address"]);
$city        = clean_str($_POST["city"]);
$state       = clean_str($_POST["state"]);
$country     = clean_str($_POST["country"]);
$zipcode     = clean_str($_POST["zipcode"]);
$email       = clean_str($_POST["email"]);
$phone       = clean_str($_POST["phone"]);
$websitename = clean_str($_POST["websitename"]);
$websiteurl  = clean_str($_POST["websiteurl"]);
$old_pass    = clean_str($_POST["old_pass"]);
$password    = clean_str($_POST["password"]);

if(check_login($current_affiliate->email, md5($old_pass)) != "/" || $old_pass == ""){

	if(!check_email($email,$current_affiliate->id) || $email == $current_affiliate->email){
		$current_affiliate->name = $firstname;
		$current_affiliate->last_name = $lastname;
		$current_affiliate->adress = $address;
		$current_affiliate->city = $city;
		$current_affiliate->state = $state;
		$current_affiliate->country = $country;
		$current_affiliate->zip = $zipcode;
		$current_affiliate->email = $email;
		$current_affiliate->phone = $phone;
		$current_affiliate->web_name = $websitename;
		$current_affiliate->web_url = $websiteurl;
		if($old_pass != "" && $password != ""){$current_affiliate->password = $password;}else{$current_affiliate->password = "";}
		$current_affiliate->nepass = num_two_way_encript($password);
		update_affiliate($current_affiliate);
		
		$current_affiliate->bronto_update();
		
		$subject = "VRB Account Change";
		$code = get_affiliate_code($current_affiliate->id,1);
		$body = $current_affiliate->get_fullname()." (". $code .") changed his account data .";
		email_to_clercks($subject, $body, true);
		
		header("Location: ../../dashboard/account.php?e=12");
	}else{
		header("Location: ../../dashboard/account.php?e=1");	
	}

}else{
	header("Location: ../../dashboard/account.php?e=13");	
}
?>