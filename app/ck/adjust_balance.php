<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("balances") || $current_clerk->im_allow("processing_balances") || $current_clerk->im_allow("pph_balances")){ ?>
<?
$type = $_GET["t"];
$system = $_GET["s"];
$account = $_GET["a"];
$adj = get_adjusted_balance($type, $system, $account);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/balances/api/functions.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"amount",type:"numeric", msg:"Please insert an adjusted balance"});
</script>
</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">Adjust Balance</span><br /><br />
<div class="form_box">
	<form method="post" onsubmit="return validate(validations)" action="process/actions/adjust_balance_action.php" target="_parent" id="updater">
    <input name="delete" type="hidden" id="delete" value="0" />
    <input name="type" type="hidden" id="type" value="<? echo $type  ?>" />
    <input name="system" type="hidden" id="system" value="<? echo $system ?>" />
    <input name="account" type="hidden" id="account" value="<? echo $account ?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Amount:</td>
        <td><input name="amount" type="text" id="amount" size="10" value="<? echo $adj->vars["balance"] ?>" /></td>
      </tr>
      <tr>
        <td>Note:</td>
        <td><textarea name="note" rows="5" id="note"><? echo $adj->vars["note"] ?></textarea></td>
      </tr>
      <tr>
        <td><input name="" type="submit" value="Submit" /></td>
        <td align="right"><? if(!is_null($adj)){ ?><input type="button" value="Delete Adjustment" onclick="delete_adjustment()" /><? } ?></td>
      </tr>
    </table>
  </form>
</div>

</body>
</html>
<script type="text/javascript">
function delete_adjustment(){
	if(confirm("Are you sure you want to delete this adjustment?")){
		document.getElementById("delete").value = "1";
		document.getElementById("updater").submit();
	}
}
</script>
<? }else{echo "Access Denied";} ?>