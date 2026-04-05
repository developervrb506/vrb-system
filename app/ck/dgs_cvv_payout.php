<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("dgs_money_transfers")){ ?>
<?
$vcc = get_vcc($_GET["vid"]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Credit Card Information</span><br /><br />
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"number",type:"null", msg:"Please insert the Credit Card Number"});
validations.push({id:"cvv",type:"null", msg:"Please insert the Credit Card CVV"});
validations.push({id:"expiration",type:"null", msg:"Please insert the Credit Card Expiration Date"});
</script>
<? include "includes/print_error.php" ?>
<form method="post" onsubmit="return validate(validations)" action="process/actions/vcc_prepayout_action.php">
<input name="transaction" type="hidden" id="transaction" value="<? echo $vcc->vars["id"] ?>" />
<div class="form_box">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
	  <tr>
		<td>
		  <strong>CC Number:</strong><br /><input name="number" type="text" id="number" value="<? echo $vcc->vars["cc_number"] ?>"  />         
		</td>
	  </tr>
	  <tr>
		<td>
		  <strong>CVV:</strong><br /><input name="cvv" type="text" id="cvv" size="5" value="<? echo $vcc->vars["cc_cvv"] ?>" />         
		</td>
	  </tr>
      <tr>
		<td>
		  <strong>Exp. Date:</strong><br /><input name="expiration" type="text" id="expiration" value="<? echo $vcc->vars["cc_exp"] ?>" />         
		</td>
	  </tr>
	  <tr>
		<td>
		  <strong>Feedback:</strong><br />
		  <textarea name="feedback" id="feedback"><? echo $vcc->vars["payout_back_message"] ?></textarea>         
		</td>
	  </tr>
	   <tr>
		<td><input type="submit" value="CONTINUE" /></td>
	  </tr>
	</table>
</div>
</form>
</div>
<? }else{echo "Access Denied";} ?>