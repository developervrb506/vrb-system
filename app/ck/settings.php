<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>System Settings</title>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
<? foreach($gsettings as $set){?>
validations.push({id:"<? echo $set->vars["id"] ?>",type:"null", msg:"<? echo $set->vars["name"] ?> is required"});
<? } ?>
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">System Settings</span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/update_settings_action.php" onsubmit="return validate(validations)">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
    <?
	foreach($gsettings as $set){
	?>
      <tr>
        <td><? echo $set->vars["description"] ?></td>
        <td><textarea name="<? echo $set->vars["id"] ?>" cols="50" rows="10" id="<? echo $set->vars["id"] ?>"><? 
			echo $set->vars["value"]; 
		?></textarea></td>
      </tr> 
     <? } ?>   
      <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
</div>


</div>
<? include "../includes/footer.php" ?>