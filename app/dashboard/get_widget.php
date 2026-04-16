<? include(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<script type="text/javascript" src="process/js/functions.js?v=2"></script>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Get Widget</title>
</head>
<body>
<? include "../includes/header.php" ?>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"The need to write your Name"});
validations.push({id:"email",type:"either:phone", msg:"You need to write your Email or Phone"});
</script>

<div class="page_content" style="padding-left:50px;">
<span class="page_title">Get Widget Form</span><br />
<span class="error"><? if (isset($_GET["e"])) { echo "<br />" . get_error($_GET["e"]) . "<br />"; }?></span><br />
<span class="little"><strong>Please enter your name and contact information above.</strong><br />
We will have a representative contact you to discuss the free sports odds ticker for your site.<br />
The ticker will be customized to match the color and size of your website.</span><br />
<br />

<form action="../process/actions/getwidget_action.php" method="POST" name="join" id="join" onsubmit="return validate(validations);">  
<div class="form_box" style="width:500px;">
    <table width="99%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>Name:</td>
        <td style="text-align:right;"><input type="text" name="name" id="name" size="50" maxlength="50"></td>
      </tr>
      <tr>
        <td>Email:</td>
        <td style="text-align:right;"><input type="text" name="email" id="email" size="50" maxlength="50"></td>
      </tr>
      <tr>
        <td>Phone:</td>
        <td style="text-align:right;"><input type="text" name="phone" id="phone" size="50" maxlength="50"></td>
      </tr>
    </table>
</div>
<br />

<input type="image" src="../images/temp/submit.jpg" />
</form>

</div>

<? include "../includes/footer.php" ?>