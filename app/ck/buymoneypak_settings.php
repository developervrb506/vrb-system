<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/admin_security.php"); ?>
<? $bmsettings = _get_buy_moneypaks_settings(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Buymoneypaks.com System Settings</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Buymoneypaks.com System Settings</span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/update_buymoneypaks_settings_action.php" onsubmit="return validate(validations)">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
    <?
	foreach($bmsettings as $set){
	?>
      <tr>
        <td><? echo $set->vars["description"] ?></td>
        <td><input name="<? echo $set->vars["id"] ?>" type="text" id="<? echo $set->vars["id"] ?>" value="<? 
			echo $set->vars["value"]; 
		?>" size="50" /></td>
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