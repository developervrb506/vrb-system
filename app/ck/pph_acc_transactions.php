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

<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"pph_account_list_from",type:"null", msg:"Please select an Account"});
validations.push({id:"pph_account_list_to",type:"null", msg:"Please select an Account"});
validations.push({id:"amount",type:"numeric", msg:"Please insert an Amount"});
validations.push({id:"note",type:"null", msg:"Please insert a Note"});
</script>
<span class="page_title">Insert PPH Transaction</span><br /><br />
<div class="form_box">
	<form action="process/actions/insert_pph_action.php" method="post" target="_parent" onsubmit="return validate(validations)" >
	<table width="100%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
		<td>From:</td>
		<td>
			<?
			$select_option = true;
			$extra_name = "_from";
			include("includes/pph_account_list.php");
			?>
		</td>
	  </tr>
      <tr>
		<td>To:</td>
		<td>
			<?
			$select_option = true;
			$extra_name = "_to";
			include("includes/pph_account_list.php");
			?>
		</td>
	  </tr>
      <tr>
		<td>Amount:</td>
		<td>
			<input name="amount" type="text" id="amount" value="" />
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