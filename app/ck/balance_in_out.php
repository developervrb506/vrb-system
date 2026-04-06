<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if($current_clerk->im_allow("balance_receipt") && isset($_GET["r"])){
	$access = true;
	$name = "Receipt";
	$type = "R";
}else if($current_clerk->im_allow("balance_disbursements") && isset($_GET["d"])){
	$access = true;
	$name = "Disbursement";
	$type = "D";
}
?>

<? if($access){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Balance <? echo $name ?></title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Balance <? echo $name ?></span>
<br /><br />
<div class="form_box" style="width:600px;">
Insert Balance <? echo $name ?><br /><br />
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"account",type:"null", msg:"Please Insert the Account"});
validations.push({id:"amount",type:"numeric", msg:"Please Insert a Valid Amount"});
validations.push({id:"amount",type:"smaller_than:0", msg:"Please insert only Positive Numbers"});
validations.push({id:"methods_list",type:"null", msg:"Please Select a Payment Method"});
validations.push({id:"desc",type:"null", msg:"Please Insert a Description"});
<? if($_GET["sent"]){echo "alert('$name has been Inserted');";} ?>
</script>
 

 <form method="post" action="<?= BASE_URL ?>/ck/loader_sbo.php" onsubmit="return validate(validations)"> 
<input name="loader" type="hidden" value= "balance_in_out" />
<input name="type" type="hidden" id="type" value="<? echo $type ?>" />
<input name="pass" type="hidden" id="pass" value="VrBAcc@ess" />
<input name="clerk" type="hidden" id="clerk" value="<? echo $current_clerk->vars["id"] ?>" />

<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td>Type:</td>
    <td>
        <select name="user_type" id="user_type">
          <option value="p">Player</option>
          <option value="a">Affiliate</option>
        </select>
	</td>
  </tr>
  <tr>
    <td>Account:</td>
    <td><input name="account" type="text" id="account" /></td>
  </tr>
  <tr>
    <td>Amount:</td>
    <td><input name="amount" type=amount"text" id="amount" /></td>
  </tr>
  <tr>
    <td>Method:</td>
    <td><? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/print_payment_methods.php?so=1"); ?></td>
  </tr>
  <tr>
    <td valign="top">Description:</td>
    <td><textarea name="desc" cols="35" rows="6" id="desc"></textarea></td>
  </tr>
</table>


<input name="" type="submit" value="Send" />
</form>
</div>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>