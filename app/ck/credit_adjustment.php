<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("credit_accounting")){ ?>
<?

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"mdate",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body style="background:#fff; padding:20px;">

<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"credit_account_list",type:"null", msg:"Please select an Account"});
validations.push({id:"amount",type:"numeric", msg:"Please insert an Amount"});
</script>
<span class="page_title">Insert Credit Adjustment</span><br /><br />
<div class="form_box">
	<form action="process/actions/insert_credit_adjustment_action.php" method="post" target="_parent" onsubmit="return validate(validations)" >
	<table width="100%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
		<td>Account:</td>
		<td>
			<?
			$select_option = true;
			include("includes/credit_account_list.php");
			?>
		</td>
	  </tr>
      <tr>
		<td>Amount:</td>
		<td>
			<input name="amount" type="text" id="amount" />
		</td>
	  </tr>
      <tr>
		<td>Date:</td>
		<td>
			<input name="mdate" type="text" id="mdate" value="<? echo date("Y-m-d") ?>" readonly="readonly" />
		</td>
	  </tr>
	  <tr>
		<td>Note</td>
		<td><textarea name="note" cols="20" rows="5" id="note"></textarea></td>
	  </tr> 
	  <tr>    
		<td align="center" colspan="2"><input type="image" src="../images/temp/submit.jpg" /></td>
	  </tr>
	</table>
  </form>
</div>

</body>
</html>
<? }else{echo "Access Denied";} ?>