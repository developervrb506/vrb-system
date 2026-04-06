<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/balances/api/functions.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"></script>
<script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"number",type:"null", msg:"Please Write the Moneypak Number"});
	validations.push({id:"amount",type:"numeric", msg:"Please Write a valid Amount"});
</script>
</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">Insert Manual Pak</span><br /><br />
<div class="form_box">
	<form method="post" onsubmit="return validate(validations)" action="process/actions/insert_manual_moneypak.php" target="_parent">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">    
      <tr>
        <td>Method:</td>
        <td><select name="method" id="method">
          <option value="m">Moneypak</option>
          <option value="r">Reloadit</option>
        </select></td>
      </tr>
      <tr>
        <td>Moneypak #:</td>
        <td><input name="number" type="text" id="number" /></td>
      </tr>
      <tr>
        <td>Amount:</td>
        <td><input name="amount" type="text" id="amount" size="5" /></td>
      </tr>
      <tr>
        <td>Player (Optional):</td>
        <td><input name="player" type="text" id="player" /></td>
      </tr>
      <tr>
        <td>Confirmed:</td>
        <td><input name="conf" type="checkbox" id="conf" value="1" /></td>
      </tr>
      <tr>
        <td colspan="2"><input name="" type="submit" value="Submit" /></td>
      </tr>
    </table>
	</form>
</div>

</body>
</html>
<? }else{echo "Access Denied";} ?>