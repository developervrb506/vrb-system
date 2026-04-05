<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("balance_adjustment")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Balance Adjustments</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Balance Adjustments</span>
<br /><br />
<div class="form_box" style="width:600px;">
Insert Balance Adjustment<br /><br />
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"account",type:"null", msg:"Please Insert the Account"});
validations.push({id:"amount",type:"numeric", msg:"Please Insert a Valid Amount"});
validations.push({id:"desc",type:"null", msg:"Please Insert a Description"});
<? if($_GET["sent"]){echo "alert('Adjustment has been Inserted');";} ?>
</script>
<form method="post" action="http://localhost:8080/ck/loader_sbo.php" onsubmit="return validate(validations)">
<input name="loader" type="hidden" value= "balance_adjustments" />
<input name="pass" type="hidden" id="pass" value="VrBAcc@ess" />
<input name="clerk" type="hidden" id="clerk" value="<? echo $current_clerk->vars["id"] ?>" />
Type: 
<select name="type" id="type">
  <option value="p">Player</option>
  <option value="a">Affiliate</option>
</select>
&nbsp;&nbsp;
Account:
<input name="account" type="text" id="account" />
&nbsp;&nbsp;
Amount:
<input name="amount" type=amount"text" id="amount" />

<br /><br />
Description:<br />
<textarea name="desc" cols="35" rows="6" id="desc"></textarea>

<br /><br />

<input name="" type="submit" value="Send" />
</form>
</div>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>