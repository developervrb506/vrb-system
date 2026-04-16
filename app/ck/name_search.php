<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/process/sales_security.php"); ?>
<?

if(isset($_POST["search"])){
	//$s_last = clean_get("last");
	$s_str = clean_get("str");	
	$s_type = clean_get("type");
	$s_str_final = $s_str;
	if($s_type == "phone"){$s_str_final = clean_phone($s_str);}
	$names = search_cknames($s_last,$s_str_final,$s_type);
}else{
	$names = array();	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Search Client</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
//validations.push({id:"last",type:"null", msg:"Last Name is required"});
validations.push({id:"str",type:"smaller_length:5", msg:"This Field is incomplete"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Search Client</span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:450px;">
<form method="post" action="" onsubmit="return validate(validations)">
<input name="search" type="hidden" id="search" value="1"  />
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <!--<td valign="top">Last Name:</td>
    <td><input name="last" type="text" id="last" value="<? echo $s_last ?>" />
      <br />
      Examle: Smith</td>-->
    <td valign="top">
    	<select name="type" id="type">
    	  <option <? if($s_type == "email"){echo 'selected="selected"';} ?> value="email">Email</option>
    	  <option <? if($s_type == "phone"){echo 'selected="selected"';} ?> value="phone">Phone</option>
    	</select>:
    </td>
    <td><input name="str" type="text" id="str"  value="<? echo $s_str ?>" />
      <br />
      Example: 201-4654 or test@web.com </td>
    <td><input name="" type="submit" value="Search" /></td>
  </tr>
</table>
</form>
</div><br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="table_header" align="center">Name</td>
  <td class="table_header" align="center">Status</td>
  <td class="table_header" align="center">AF</td>
  <td class="table_header" align="center">Clerk</td>
  <td class="table_header" align="center">Join Date</td>
  <td class="table_header" align="center">Call</td>
</tr>
<?


?>
<? foreach($names as $name){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>

<tr>
  <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->full_name(); ?></td>
  <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars[status]->vars["name"]; ?></td>
  <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["aff_id"]; ?></td>
  <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["clerk"]->vars["name"]; ?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $name->vars["added_date"]->vars["name"]; ?></td>
  <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
  	<a href="call.php?vid=<? echo $name->vars["id"]; ?>" class="normal_link">Call</a>
  </td>
</tr>

<? } ?>
<tr>
  <td class="table_last"></td>
  <td class="table_last"></td>
  <td class="table_last"></td>
  <td class="table_last"></td>
  <td class="table_last"></td>
</tr>
</table>
<? if(count($names)<1){echo "No Clients Found";} ?>
</div>
<? include "../includes/footer.php" ?>