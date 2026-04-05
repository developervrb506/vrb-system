<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Add New Name</title>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"Name is required"});
validations.push({id:"last_name",type:"null", msg:"Last Name is required"});
validations.push({id:"email",type:"email", msg:"Email is incorrect"});
validations.push({id:"phone",type:"null", msg:"Phone is required"});
validations.push({id:"street",type:"null", msg:"Street Name is required"});
validations.push({id:"city",type:"null", msg:"City is required"});
validations.push({id:"state",type:"null", msg:"State is required"});
validations.push({id:"zip",type:"null", msg:"Zip is required"});
validations.push({id:"source",type:"null", msg:"Source is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Add New Name</span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/add_name_action.php" onsubmit="return validate(validations)">
    <input name="start_date" type="hidden" id="start_date" value="<? echo date("Y-m-d H:i:s"); ?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <!--<tr>
        <td>List</td>
        <td><? //$s_list = $name->vars["list"]->vars["id"]; include "includes/lists_list.php" ?></td>
      </tr>-->
      <tr>
        <td>Name</td>
        <td><input name="name" type="text" id="name" /></td>
      </tr> 
      <tr>
        <td>Last Name</td>
        <td><input name="last_name" type="text" id="last_name"  /></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><input name="email" type="text" id="email"  /></td>
      </tr> 
      <tr>
        <td>Phone</td>
        <td><input name="phone" type="text" id="phone"  /></td>
      </tr>
      <tr>
        <td>Phone 2</td>
        <td><input name="phone2" type="text" id="phone2"  /></td>
      </tr>
      <tr>
        <td>Street Name</td>
        <td><input name="street" type="text" id="street"  /></td>
      </tr>
      <tr>
        <td>City</td>
        <td><input name="city" type="text" id="city"  /></td>
      </tr> 
      <tr>
        <td>State</td>
        <td><input name="state" type="text" id="state"  /></td>
      </tr> 
      <tr>
        <td>Zip</td>
        <td><input name="zip" type="text" id="zip"  /></td>
      </tr>
      <tr>
        <td>Source</td>
        <td><input name="source" type="text" id="source"  /></td>
      </tr> 
      <tr>
        <td>Notes</td>
        <td><textarea name="note" cols="30" rows="7" id="note"></textarea></td>
      </tr>       
      <tr>      
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
</div>

<!--<div class="form_box" style="margin-top:20px; font-size:14px;">
    <?
	$iurl = "";
	$iurl .= "&cname=" . $current_clerk->vars["name"];
	$iurl .= "&cid=" . $current_clerk->vars["id"];
	?>
   <strong>Signup Form</strong><br /><br />
    <iframe id="iframepromo" width="400" height="900" scrolling="no" frameborder="0" src="http://www.sportsbettingonline.ag/utilities/ui/join/multi_join_form.php?www=de91ddd20396f9b88874f6daeb896ca8&promo=<? echo  $current_clerk->vars["af"].$iurl ?>"></iframe>
    
</div>-->


</div>
<? include "../includes/footer.php" ?>