<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("dgs_money_transfers")){ ?>
<?
include("includes/dgs_deposit_process.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">PPH Deposit</span><br /><br />
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"methods_list",type:"null", msg:"Please select a Payment Method"});
/*validations.push({id:"fees",type:"numeric", msg:"Please insert the Fees"});
validations.push({id:"fees_method",type:"null", msg:"Please select the Fees Method"});
validations.push({id:"bonus",type:"numeric", msg:"Please insert the Bonus"});
validations.push({id:"bonus_method",type:"null", msg:"Please select the Bonus Method"});
validations.push({id:"rollover",type:"numeric", msg:"Please insert the Roll Over"});*/
</script>
<? include "includes/print_error.php" ?>
<form method="post" onsubmit="return validate(validations)" action="process/actions/pph_deposit_action.php">
<input name="transaction" type="hidden" id="transaction" value="<? echo $tid ?>" />
<input name="account" type="hidden" id="account" value="<? echo $account ?>" />
<input name="method" type="hidden" id="method" value="<? echo $method ?>" />
<input name="mtcn" type="hidden" id="mtcn" value="<? echo $mtcn ?>" />
<input name="amount" type="hidden" id="amount" value="<? echo $amount ?>" />
<input name="description" type="hidden" id="description" value="<? echo $description ?>" />
<div class="form_box">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td><strong>Account:</strong> <? echo $account ?></td>
        <td><strong>Method:</strong> <? echo $mname ?></td>
        <td><strong><? echo $cname ?></strong> <? echo $mtcn ?></td>
        <td><strong>Amount:</strong> $<? echo $amount ?></td>
      </tr>
      <tr>
        <td colspan="4"><input type="submit" value="INSERT DEPOSIT" /></td>
      </tr>
    </table>
</div>

<div class="form_box">
    <br />
    <iframe src="http://localhost:8080/ck/loader_sbo.php?type=agent&data=<? echo $account ?>" frameborder="0" scrolling="auto" width="100%" height="350"></iframe>
</div>
</form>
</div>
<? }else{echo "Access Denied";} ?>