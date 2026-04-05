<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("dgs_money_transfers")){ ?>
<?
$vcc = get_vcc($_GET["vid"]);
if($vcc->vars["deposit_status"] == "pe"){
	$key = two_way_enc(mt_rand().".VCD".$vcc->vars["id"]."."."vcc");
	header("Location: https://www.ezpay.com/wu/process/actions/cash_redirect.php?k=".$key);
}else if($vcc->vars["deposit_cmarked"]){
	header("Location: dgs_cvv_payout.php?vid=".$vcc->vars["id"]);
}else{
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	<div class="page_content" style="padding-left:10px;">
	<span class="page_title">Paypal Deposit</span><br /><br />
	<script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
	var validations = new Array();
	validations.push({id:"player",type:"null", msg:"Please insert the Player Account"});
	validations.push({id:"fees",type:"numeric", msg:"Please insert the Fees"});
	</script>
	<? include "includes/print_error.php" ?>
	<form method="post" onsubmit="return validate(validations)" action="process/actions/vcc_predeposit_action.php">
	<input name="transaction" type="hidden" id="transaction" value="<? echo $vcc->vars["id"] ?>" />
	<div class="form_box">
		<table width="100%" border="0" cellspacing="0" cellpadding="10">
		  <tr>
			<td>
			  <strong>Player:</strong><br /><input name="player" type="text" id="player" />         
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Deposit Fee:</strong><br /><input name="fees" type="text" id="fees" size="3" />         
			</td>
		  </tr>
		  <tr>
			<td>
			  <strong>Comments:</strong><br />
			  <textarea name="comments" id="comments"></textarea>         
			</td>
		  </tr>
		   <tr>
			<td><input type="submit" value="CONTINUE" /></td>
		  </tr>
		</table>
	</div>
	</form>
	</div>
<? } ?>
<? }else{echo "Access Denied";} ?>