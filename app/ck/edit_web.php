<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$web = get_ckweb($_GET["wid"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<title>Edit Website</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"affiliate",type:"null", msg:"Affiliate is required"});
validations.push({id:"name",type:"null", msg:"Name is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Edit Website</span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/edit_web_action.php" onsubmit="return validate(validations)">
    <input name="update_id" type="hidden" id="update_id" value="<? echo $web->vars["id"] ?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Affiliate</td>
        <td><input name="affiliate" type="text" id="affiliate" value="<? echo $web->vars["affiliate"] ?>" /></td>
      </tr> 
      <tr>
        <td>Name</td>
        <td><input name="name" type="text" id="name" value="<? echo $web->vars["name"] ?>" /></td>
      </tr>
      <tr>    
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
</div>


</div>
<? include "../includes/footer.php" ?>