<? include(ROOT_PATH . "/ck/process/security.php"); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"email",type:"email", msg:"Please insert the receiver Email"});
	validations.push({id:"sub",type:"null", msg:"Please insert a Subject"});
	validations.push({id:"msg",type:"null", msg:"Please insert a Message"});
</script>
</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">Send Email</span><br /><br />
<div class="form_box">
	<form method="post" onsubmit="validate(validations);">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Emails:</td>
        <td><input name="email" type="text" id="email" size="30" /></td>
      </tr>
      <tr>
        <td>Subject:</td>
        <td><input name="sub" type="text" id="sub" size="30" /></td>
      </tr>
      <tr>
        <td>Message</td>
        <td><textarea name="msg" cols="30" rows="10" id="msg"></textarea></td>
      </tr>
      <tr>
        <td><input name="sending" type="submit" id="sending" value="Submit" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form>  
    
</div>

</body>
</html>

<?
if(isset($_POST["sending"])){
	send_email_ck($_POST["email"], $_POST["sub"], $_POST["msg"]);
	?><script type="text/javascript">alert("Message has been Sent.");</script><?
}
?>