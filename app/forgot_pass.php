<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body {
	margin-left: 20px;
	margin-top: 20px;
	margin-right: 20px;
	margin-bottom: 20px;
	background:#000;
	color:#fff;
	font:Arial, Helvetica, sans-serif;
	font-family:Arial, Helvetica, sans-serif;
}
</style>
</head>

<body>

<?
if(isset($_POST["submit"])){
	
	$aff = get_affiliate_by_email(clean_str_ck($_POST["email"]));
	if(!is_null($aff)){
		if($aff->vars["nepass"] != ""){
			$pass = aff_two_way_encript($aff->vars["nepass"],true);
		}else{
			$pass = "1234567";
			$aff->vars["password"] = md5($pass);
			$aff->vars["nepass"] = aff_two_way_encript($pass);
			$aff->update(array("password","nepass"));
		}
		
		$msg = "Your VRB Marketing Password is: $pass";
		send_email_ck($aff->vars["email"], "VRB Marketing Password", $msg)
		
		?>We sent your password to your Email<?
	}else{
		?>Your Email is not in the System<?
	}
	
}else{
?>

    <form method="post">
    Insert your email: 
    <input name="email" type="text" id="email" /> 
    <input name="submit" type="submit" id="submit" value="Submit" />
    </form>
    
<? } ?>

</body>
</html>
