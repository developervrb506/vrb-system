<?php 
include(ROOT_PATH . "/db/handler.php");

$id = $_POST["id"];

if ( !isset($id) ) {
  $id = "";	
}

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
$password    = clean_str($_POST["password"]);
$newsletter  = clean_str($_POST["newsletter"]);

$one_book  = clean_str($_POST["one_book"]);
if($one_book != ""){$qs_ob = "&ob=$one_book";}

if($newsletter != 1) {
   $newsletter = 0;	
}

$books       = $_POST['chkboxes'];

setcookie("firstname", $firstname,0,"/",".vrbmarketing.com");
setcookie("lastname", $lastname,0,"/",".vrbmarketing.com");
setcookie("address", $address,0,"/",".vrbmarketing.com");
setcookie("city", $city,0,"/",".vrbmarketing.com");
setcookie("state", $state,0,"/",".vrbmarketing.com");
setcookie("country", $country,0,"/",".vrbmarketing.com");
setcookie("zipcode", $zipcode,0,"/",".vrbmarketing.com");
setcookie("email", $email,0,"/",".vrbmarketing.com");
setcookie("phone", $phone,0,"/",".vrbmarketing.com");
setcookie("websitename", $websitename,0,"/",".vrbmarketing.com");
setcookie("websiteurl", $websiteurl,0,"/",".vrbmarketing.com");

$emaile = check_email($email,$id);
if($emaile == 0) {
	
	$affiliate = new affiliate($id,$firstname,$lastname,$address,$city,$state,$country,$zipcode,$email,$phone,$websitename,$websiteurl,0,"",$password,$newsletter,array());

    if ( !isset($_GET["edit"]) ) {		
	  
	  	$user_captcha = md5(strtolower(clean_str($_POST["confirmation"])));
		
		session_start();
		$captcha = $_SESSION["vrb_form_code"];
		
		//no captcha = cb0590e48d0f61660bc00c355fdf0d60 = md5("nc@njk!");
		if($user_captcha == $captcha || $user_captcha == "cb0590e48d0f61660bc00c355fdf0d60"){
		
			$aff_id = insert_affiliate($affiliate);
			
			$affiliate->bronto_update();
			
			if (isset($books) ) {  	  
			   insert_books_affiliate($aff_id,$books);	
			}
			
			//kat requested this modification, so she can always see the not encripted password  
			$content  = "Affiliate's email address: ".$email."\n";
			$content .= "Affiliate's password: ".$password; 
						
			send_email_partners("vrbaffiliates@gmail.com,wendyvrbmarketing@gmail.com,mfajardo@vrbmarketing.com,dzamzack@vrbmarketing.com,baileyvrbmarketing@gmail.com", "Affiliate's Registration Credentials", $content, false, "support@vrbmarketing.com");
			
			clean_register_cookies();
			
			//Spam Tracking
			//send_email_partners("rarce@inspin.com", "VRB Good", "$firstname $lastname, $email, $country, " . getenv(REMOTE_ADDR), false, "support@vrbmarketing.com");
			//-------------
			
			//header("Location: ../../index.php?e=0");
			if(isset($_POST["external"])){
				header("Location: " . BASE_URL . "/thankyou_external.php");
			}else{
				header("Location: " . BASE_URL . "/thankyou.php");
			}
			
		
		}else{
			//Spam Tracking
			//send_email_partners("rarce@inspin.com", "VRB Fail", "$firstname $lastname, $email, $country, " . getenv(REMOTE_ADDR), false, "support@vrbmarketing.com");
			//-------------
			
			if(isset($_POST["external"])){
				header("Location: " . BASE_URL . "/dashboard/join_external.php?e=11&ob=$one_book");
			}else{
				header("Location: ../../dashboard/join.php?e=11");
			}
		}
		
	}
		
	else {
		
		$aff_id = update_affiliate($affiliate);
		
		$affiliate->bronto_update();
		
		if ( isset($books) ) {  	  
		   insert_books_affiliate($aff_id,$books);	
		}
		
		header("Location: http://jobs.inspin.com/wp-admin/partners_affiliates.php?e=3");		
	}	

} else {
	
	if ( $id != "" ) {	
	   header("Location: http://jobs.inspin.com/wp-admin/partners_affiliate_detail.php?affid=".$id."");
	} else {	  
	   if(isset($_POST["external"])){
		  header("Location: " . BASE_URL . "/dashboard/join_external.php?e=1&ob=$one_book");
	  }else{
		  header("Location: ../../dashboard/join.php?e=1");	
	  }
	}
}
?>