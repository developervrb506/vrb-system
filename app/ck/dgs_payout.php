<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("insert_dgs_payout")){ ?>
<?
$cash_url = "cash.ezpay.com";
if(@file_get_contents("http://cash.ezpay.com/checker.php") != 'OK'){$cash_url = "www.sportsbettingonline.ag";}
$data = explode("_*_",two_way_enc($_GET["mts"],true));
$tid = $data[0];
$account = $data[1];
$method = strtoupper($data[2]);
$amount = $data[3];
$fees = $data[4];

if($method == "WU"){
	$pm = 90;
	$mname = "Western Union";
}else if($method == "MG"){
	$pm = 100;
	$mname = "Moneygram";
}else if($method == "MO"){
	$pm = "98";
	$mname = "Money Order";	
}else if($method == "SP"){
	$sp = get_special_payout(str_replace("SP","",$tid));
	$pm = $sp->vars["method"]->vars["dgs_id"];
	$mname = "Special Payout";	
}else if($method == "MP"){
	$sp = get_moneypak_transaction(str_replace("MP","",$tid));
	if($sp->vars["method"] == 'k'){
		$pm = "103";
		$mfilter = "103,162";
		$mname = "Cashier Checks";		
	}else{
		$pm = "130";
		$mfilter = "130,162";
		$mname = "Moneypak";
	}
}else if($method == "RE"){
	$sp = get_reloadit_transaction(str_replace("RE","",$tid));
	$pm = "135";
	$mfilter = "135,162";
	$mname = "Reloadit";	
}else if($method == "CP"){
	$sp = get_check_transaction(str_replace("CP","",$tid));
	$pm = "103";
	$mfilter = "103,162";
	$mname = "Checks";	
}else if($method == "VCC"){
	//$sp = get_check_transaction(str_replace("CP","",$tid));
	$mname = "Virtual Credit Card";	
}else if($method == "BTP"){
	$pm = "134";
	$mfilter = "134,162";
	$mname = "Bitcoins";	
}else if($method == "PTP"){
	$mname = "Prepaid Gift Card";	
}else if($method == "PPP"){
	$mfilter = "95,93,91,99,92,94,134,162";
	$mname = "Paypal";	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">DGS Payout</span><br /><br />
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"methods_list",type:"null", msg:"Please Select the Payment Method"});
validations.push({id:"fees",type:"numeric", msg:"Please insert the Fees"});
function mark_free(def){
	box = document.getElementById("fees");
	cb = document.getElementById("free");
	if(!cb.checked){
		box.disabled = false;
		box.value = def;
	}else{
		box.disabled = true;
		box.value = "0";
	}
}
</script>
<? include "includes/print_error.php" ?>

<div class="form_box">
	<? echo file_get_contents("http://$cash_url/utilities/process/reports/print_player_note.php?player=$account&num=4"); ?>
</div>
<div class="form_box">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td><strong>Account:</strong> <? echo $account ?></td>
        <td><strong>Method:</strong> <? echo $mname ?></td>
        <td><strong>Amount:</strong> $<? echo $amount ?></td>
      </tr>
    </table>
</div>
<form method="post" onsubmit="return validate(validations)" action="process/actions/dgs_payout_action.php">
<input name="transaction" type="hidden" id="transaction" value="<? echo $tid ?>" />
<input name="account" type="hidden" id="account" value="<? echo $account ?>" />
<input name="method" type="hidden" id="method" value="<? echo $method ?>" />
<input name="amount" type="hidden" id="amount" value="<? echo $amount ?>" />
<div class="form_box">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td colspan="2">
        	<strong>Payment Method:</strong> 
            <? echo file_get_contents("http://$cash_url/utilities/process/reports/print_payment_methods.php?cm=$pm&so=1&filter=$mfilter"); ?>
        </td>
      </tr>
      <tr>
        <td>
       	  <strong>Fee:</strong> <input name="fees" type="text" id="fees" size="3" value="<? echo $fees ?>" />
       	  &nbsp;
       	  <input name="free" type="checkbox" id="free" onClick="mark_free('<? echo $fees ?>');" />
          <? if($_GET["free"]){ ?>
		  <script type="text/javascript">
		  document.getElementById("free").checked = true;
		  mark_free('<? echo $fees ?>');		  
          </script>
		  <? } ?>
       	  <label for="free">Free</label></td>
        <td align="right"><input type="submit" value="INSERT PAYOUT" /></td>
      </tr>
    </table>
    <br />
    <iframe src="http://localhost:8080/ck/loader_sbo.php?type=dgs_payouts&data=<? echo $account ?>&url=<? echo $cash_url ?>" frameborder="0" scrolling="auto" width="100%" height="50"></iframe>
</div>
</form>
</div>
<? }else{echo "Access Denied";} ?>