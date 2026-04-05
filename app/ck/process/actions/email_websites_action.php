<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<script type="text/javascript">
function redirect_page_email(message,website){
alert(message);
//alert("http://"+website);
location.href = "http://"+website;
}
</script>
<?
$message = "Wrong email, Please check your email";
$website = $_POST["website_vrb"];

$emails = count(check_email_website($_POST["email"],$website));

if ($emails == 0) {

	if (contains_ck($_POST["email"],"@")) {
		
		switch ($website){
			
			case "www.joeyoddessa.com":
				$message = 'Thank you for your interest in www.joeyoddessa.com!  \n \n Check your inbox weekly for the biggest MMA  Boxing moves of the week. \n \n And once again, welcome to Joeyoddessa.com !';
				break;
		
			case "www.sportshandicapper.com" :
				$message = 'Thank you for your interest in www.sportshandicapper.com! \n \n Check your inbox weekly for insider information newsletter or late breaking information of the week. \n \n And once again, welcome to sportshandicapper.com!';
				break;
				
			case "www.playonlinepoker.com" :
				$message = 'Thank you for your interest in www.playonlinepoker.com! \n \n Check your inbox weekly for insider information newsletter or late breaking information of the week. \n \n And once again, welcome to playonlinepoker.com!';
				break;
				
			case "www.inspin.com" :
				$message = 'Thank you for your interest in www.inspin.com! \n \n Check your inbox weekly for insider information newsletter or late breaking information of the week. \n \n And once again, welcome to inspin.com!';
				break;
				
			case "www.bettingoddsforfree.com" :
				$message = 'Thank you for your interest in www.bettingoddsforfree.com! \n \n Check your inbox weekly for insider information newsletter or late breaking information of the week. \n \n And once again, welcome to bettingoddsforfree.com!';
				break;
				
			case "www.sportsbettinghandicapper.com" :
				$message = 'Thank you for your interest in www.sportsbettinghandicapper.com! \n \n Check your inbox weekly for insider information newsletter or late breaking information of the week. \n \n And once again, welcome to sportsbettinghandicapper.com!';
				break;				
		
		}	
		
		$email = new _email_web_sites();
		$email->vars["email"] =  $_POST["email"];
		$email->vars["website"] =  $website;
		$email->vars["date"] =  date("Y-m-d");
		$email->vars["ip"] =  $_POST["ip_vrb"];
		$email->insert();	
	}
	
} else {
	$message = "This email already exist in our database for this website, Please try another one.";
}	
?>
<script type="text/javascript">
	redirect_page_email('<? echo $message?>','<? echo $website ?>');
</script>