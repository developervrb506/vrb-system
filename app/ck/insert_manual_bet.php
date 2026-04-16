<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
$accounts = get_all_betting_accounts();
$identifiers = get_all_betting_identifiers();
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
			target:"date",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body style="background:#fff; padding:20px;">

<script type="text/javascript" src="includes/js/bets.js"></script>

<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"account",type:"null", msg:"Please insert an Account Number"});
validations.push({id:"date",type:"null", msg:"Please insert a Date"});
validations.push({id:"amount",type:"numeric", msg:"Please insert an Amount"});
validations.push({id:"identifier",type:"null", msg:"Please insert an Identifier"});
var accounts = new Array();
<? foreach($accounts as $acc){ ?>
accounts.push('<? echo $acc->vars["name"] ?>');
<? } ?>
var identifiers = new Array();
<? foreach($identifiers as $idf){ ?>
identifiers.push('<? echo $idf->vars["name"] ?>');
<? } ?>
</script>
<span class="page_title">Manual Bet</span><br /><br />
<div class="form_box">
	<form method="post" onsubmit="return prevalidate_manual_bet(validations)" action="process/actions/add_manualbet_action.php">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">          
	  <tr>
		<td>Account Number:</td>
		<td>
			<input name="account" type="text" id="account" onkeyup="make_upper(this);" />
		</td>
	  </tr>
      <tr>
		<td>Date</td>
		<td>
			<input name="date" type="text" id="date" readonly="readonly" value="<? echo date("Y-m-d") ?>" />
		</td>
	  </tr> 
	  <tr>
		<td>Type</td>
		<td>
        	<select name="type" id="type">
        	  <option value="w">Win</option>
        	  <option value="l">Loss</option>
        	</select>
        </td>
	  </tr> 
      <tr>
		<td>Amount</td>
		<td><input name="amount" type="text" id="amount" /></td>
	  </tr>
      
	  <tr>
		<td>Identifier</td>
		<td>
			<input name="identifier" type="text" id="identifier" />
		</td>
	  </tr>       
      <tr>
		<td>Comment</td>
		<td><textarea name="comment" id="comment"></textarea>
		</td>
	  </tr> 
	  <tr>    
		<td><input type="image" src="../images/temp/submit.jpg" /></td>
		<td>&nbsp;</td>
	  </tr>
	</table>
  </form>
</div>

</body>
</html>
<? }else{echo "Access Denied";} ?>