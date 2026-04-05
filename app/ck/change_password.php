<? $no_change_pass = true; include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
if(isset($_POST["sent"])){
	$new = clean_str_ck($_POST["new"]);
	$old = clean_str_ck($_POST["old"]);
	if($current_clerk->vars["password"] == super_encript($old)){
		if(preg_match('/[A-Z]/', $new) && strcspn($new, '0123456789')){
			$current_clerk->vars["password"] = super_encript($new);
			$current_clerk->vars["new_pass"] = 1;
			$current_clerk->update(array("password","new_pass"));
			?> <script type="text/javascript">location.href = "index.php?e=91";</script> <?
		}else{
			$error = "2";	
		}
	}else{
		$error = "1";
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Change Password</title>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"old",type:"null", msg:"Please insert yout current password"});
validations.push({id:"new",type:"null", msg:"Please insert a new password"});
validations.push({id:"new2",type:"compare:new", msg:"Passwords doesn't match"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Your password has expired, please select a new password.</span><br /><br />

<? include "includes/print_error.php" ?>
<? 
switch($error){
	case "1":
		echo '<span class="error"><strong>Current Password is incorrect</strong></span>';
	break;	
	case "2":
		echo '<span class="error"><strong>New Password MUST contain at least 1 uppercase letter and 1 number</strong></span>';
	break;	
	default:
		echo "Must contain at least 1 uppercase letter and 1 number";
}
?>
<br /><br />
<form method="post" onSubmit="return validate(validations)">
Current Password:<br />
<input name="old" type="password" id="old" />
<br /><br />

New Password:<br />
<input name="new" type="password" id="new" />
<br /><br />

Confirm New Password:<br />
<input name="new2" type="password" id="new2" />
<br /><br />
<input name="sent" type="submit" id="sent" value="Submit" />

</form>
</div>
<? include "../includes/footer.php" ?>