<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<?
if($current_clerk->im_allow("durango_create")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Create New Durango Name</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"firstname",type:"null", msg:"Name is required"});
validations.push({id:"lastname",type:"null", msg:"Last Name is required"});
validations.push({id:"address",type:"null", msg:"Address is required"});
validations.push({id:"city",type:"null", msg:"City is required"});
validations.push({id:"state",type:"null", msg:"State is required"});
validations.push({id:"zip",type:"null", msg:"Zip is required"});

</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/durango_create_name_action.php" onsubmit="return validate(validations)">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $durango->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td width="29%">First Name</td>
        <td width="71%"><input name="firstname" type="text" id="firstname" value="<? echo $durango->vars["firstname"] ?>" /></td>
      </tr>
      <tr>
        <td>Last Name</td>
        <td><input name="lastname" type="text" id="lastname" value="<? echo $durango->vars["lastname"] ?>" /></td>
      </tr>
      
      <tr>
        <td>Address</td>
        <td><input name="address" type="text" id="address" value="<? echo $durango->vars["address"] ?>" /></td>
      </tr>   
      <tr>
        <td>City</td>
        <td><input name="city" type="text" id="city" value="<? echo $durango->vars["city"] ?>" /></td>
      </tr>
      <tr>
      <tr>
        <td>State</td>
        <td><input name="state" type="text" id="state" value="<? echo $durango->vars["state"] ?>" /></td>
      </tr>
      <tr>
        <td>Zip</td>
        <td><input name="zip" type="text" id="zip" value="<? echo $durango->vars["zip"] ?>" /></td>
      </tr>
      
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
      
    </table>
	</form>
</div>


</div>
<? include "../includes/footer.php";?>
<? }else{echo "Access Denied";}  ?>