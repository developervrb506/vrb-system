<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
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

<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"pph_account_list",type:"null", msg:"Please select an Account"});
validations.push({id:"phone_count",type:"numeric", msg:"Please insert the Phone Players Count"});
validations.push({id:"lpcount",type:"numeric", msg:"Please insert the Players Count"});
validations.push({id:"lccount",type:"numeric", msg:"Please insert the Players Count"});
validations.push({id:"amount",type:"numeric", msg:"Please insert the Amount"});
validations.push({id:"internet_count",type:"numeric", msg:"Please insert the Internet Players Count"});
</script>
<span class="page_title">Insert PPH Bill</span><br /><br />
<div class="form_box">
	<form action="process/actions/insert_pph_bill_action.php" method="post" target="_parent" onsubmit="return validate(validations)" >
	<table width="100%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
		<td>Account:</td>
		<td>
			<?
			$select_option = true;
			include("includes/pph_account_list.php");
			?>
		</td>
	  </tr>
      <tr>
		<td>Type:</td>
		<td>
			<select onchange="change_type(this.value);" id="type" name="type">
			  <option value="sr">Sports/Race</option>
			  <option value="lp">Live+</option>
			  <option value="lc">Live Casino</option>
			  <option value="ot">Other</option>
			</select>
		</td>
	  </tr>
      
      <script type="text/javascript">
      function change_type(type){
		  document.getElementById("amountdiv").style.display = "none";
		  document.getElementById("lpcountdiv").style.display = "none";
		  document.getElementById("lccountdiv").style.display = "none";
		  document.getElementById("phonediv").style.display = "none";
		  document.getElementById("internetdiv").style.display = "none";
		  switch(type){ 
			  case "sr":
				  document.getElementById("phonediv").style.display = "table-row";
				  document.getElementById("internetdiv").style.display = "table-row";
			  break;
			  case "lp":
				  document.getElementById("lpcountdiv").style.display = "table-row";
			  break;
			  case "lc":
				  document.getElementById("lccountdiv").style.display = "table-row";
			  break;
			  case "ot":
				  document.getElementById("amountdiv").style.display = "table-row";
			  break;
		  }  
	  }
      </script>
      
      <tr id="amountdiv" style="display:none;">
		<td>Amount:</td>
		<td>
			<input name="amount" type="text" id="amount" value="" size="5" />
		</td>
	  </tr>
      <tr id="lpcountdiv" style="display:none;">
		<td>Players Count:</td>
		<td>
			<input name="lpcount" type="text" id="lpcount" value="" size="5" />
		</td>
	  </tr>
      <tr id="lccountdiv" style="display:none;">
		<td>Players Count:</td>
		<td>
			<input name="lccount" type="text" id="lccount" value="" size="5" />
		</td>
	  </tr>
      <tr id="phonediv">
		<td>Phone Players Count:</td>
		<td>
			<input name="phone_count" type="text" id="phone_count" value="" size="5" />
		</td>
	  </tr>
      <tr id="internetdiv">
		<td>Internet Players Count:</td>
		<td>
			<input name="internet_count" type="text" id="internet_count" value="" size="5" />
		</td>
	  </tr>
      <tr>
		<td>Billing Date:</td>
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