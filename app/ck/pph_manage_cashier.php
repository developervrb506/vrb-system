<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<?

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">

<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"type",type:"null", msg:"Please select Player or Agent"});
validations.push({id:"account",type:"null", msg:"Please insert the account"});
validations.push({id:"action",type:"null", msg:"Please select an action"});
</script>
<span class="page_title">Manage Cashier</span><br /><br />
<div class="form_box">
	<? 
	if(param("type")!= ""){ 
	
		$ctype = param("type");
		$caccount = param("account");
		$caction = param("action");
		echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/manage_cashier_access.php?t=$ctype&a=$caccount&k=$caction"); 
	
	}else{ ?>
	<form method="post" onsubmit="return validate(validations)" >
	<table width="100%" border="0" cellspacing="0" cellpadding="10">   
      <tr>
		<td>Type:</td>
		<td>
			<select id="type" name="type">
			  <option value="">-- Select --</option>
              <option value="p">Specific Player</option>
			  <option value="a">Players under Agent</option>
			</select>
		</td>
	  </tr>
      <tr>
		<td>Account:</td>
		<td>
			<input name="account" type="text" id="account" value="" size="15" />
		</td>
	  </tr>
      <tr>
		<td>Action:</td>
		<td>
			<select id="action" name="action">
			  <option value="">-- Select --</option>
              <option value="1">Enable</option>
			  <option value="0">Disable</option>
			</select>
		</td>
	  </tr>
	  <tr>    
		<td align="center" colspan="2"><input type="image" src="../images/temp/submit.jpg" /></td>
	  </tr>
	</table>
  </form>
  <? } ?>
</div>

</body>
</html>
<? }else{echo "Access Denied";} ?>