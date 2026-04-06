<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_deposits")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding:10px;">
<strong>Manual Prepaid Card</strong><br />
<br />
<script type="text/javascript" src="../../process/js/functions.js"></script> 
<script type="text/javascript">
var validations = new Array();
validations.push({id:"amount",type:"numeric", msg:"Amount is required"});
validations.push({id:"fee",type:"numeric", msg:"Fee is required"});
validations.push({id:"type",type:"null", msg:"Select a Card Type"});
validations.push({id:"num",type:"null", msg:"Card # is required"});
validations.push({id:"exp",type:"null", msg:"Expiration is required"});
validations.push({id:"cvv",type:"null", msg:"CVV is required"});
</script>
<div class="form_box" style="width:500px;">
  <form method="post" action="poster.php" id="fsender" name="fsender" target="_parent" onsubmit="return validate(validations);">
    <input name="way" type="hidden" id="way" value="manual_prepaid" />
    <table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Amount</td>
        <td><input name="amount" type="text" id="amount" /></td>
      </tr>
      <tr>
        <td>Fee</td>
        <td><input name="fee" type="text" id="fee"  /></td>
      </tr>
      <tr>
        <td>Type</td>
        <td>
          <select name="type" id="type" onchange="dd_change_field_31(this);">
            <option value="">--Select--</option>
            <option value="Visa Vanilla Gift Card">Visa Vanilla Gift Card</option>
            <option value="Mastercard Vanilla Gift Card">Mastercard Vanilla Gift Card</option>
            <option value="Visa Rushcard Reloadable Prepaid">Visa Rushcard Reloadable Prepaid</option>
            <option value="Green Dot Reloadable Prepaid">Green Dot Reloadable Prepaid</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Card Number</td>
        <td><input name="num" type="text" id="num"  /></td>
      </tr>
      <tr>
        <td>Expiration</td>
        <td><input name="exp" type="text" id="exp" /></td>
      </tr>
      <tr>
        <td>CVV</td>
        <td><input name="cvv" type="text" id="cvv" /></td>
      </tr>
      <tr>
        <td><input type="image" src="<?= BASE_URL ?>/images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
</div>
<? }else{echo "Access Denied";} ?>
