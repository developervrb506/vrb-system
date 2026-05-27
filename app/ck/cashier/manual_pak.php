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
<strong>Manual Pak</strong><br /><br />
<script type="text/javascript" src="../../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"type",type:"null", msg:"Select a  Pak Type"});
validations.push({id:"amount",type:"numeric", msg:"Amount is required"});
validations.push({id:"num",type:"null", msg:"Pak # is required"});
</script>



<div class="form_box" style="width:500px;">
	<form method="post" action="poster.php" id="fsender" name="fsender" target="_parent" onsubmit="return validate(validations);">
    <input name="way" type="hidden" id="way" value="manual_pak" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">        
	  <tr>
		<td>Type</td>
		<td>
        	<select name="type" id="type">
        	  <option value="">--Select--</option>
              <option value="32">Amazon Gift Cards</option>
              <option value="3">Paypal Cash Card</option>
              <?php /*?><option value="2">Reloadit</option>
              <option value="4">Moneypak</option>
              <option value="5">Vanilla Reload</option><?php */?>
        	</select>
        </td>
	  </tr> 
	  <tr>
		<td>Amount</td>
		<td><input name="amount" type="text" id="amount" /></td>
	  </tr> 
	  <tr>
		<td>Pak #</td>
		<td><input name="num" type="text" id="num"  /></td>
	  </tr>  
	  <tr>
		<td>Zip</td>
		<td><input name="zip" type="text" id="zip" /></td>
	  </tr> 
	  <tr>    
		<td><input type="image" src="<?= BASE_URL ?>/images/temp/submit.jpg" /></td>
		<td>&nbsp;</td>
	  </tr>
	</table>
  </form>
</div>


<? }else{echo "Access Denied";} ?>