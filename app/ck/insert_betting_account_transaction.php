<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
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

<span class="page_title">Account Moves</span><br /><br />
<? if(!isset($_POST["store"])){ ?>
<script type="text/javascript" src="includes/js/bets.js"></script>
<? $accounts = get_all_betting_accounts(); ?>
<script type="text/javascript" src="../process/js/functions.js"></script>
	<script type="text/javascript">
    var validations = new Array();
    /*validations.push({id:"faccount",type:"null", msg:"Please Write a 'From' Account Number"});
	validations.push({id:"taccount",type:"null", msg:"Please Write a 'To' Account Number"});*/
	validations.push({id:"date",type:"null", msg:"Please insert a Date"});
	validations.push({id:"amount",type:"numeric", msg:"Please insert the Transaction Amount"});
	
	var accounts = new Array();
	<? foreach($accounts as $acc){ ?>
	accounts.push('<? echo $acc->vars["name"] ?>');
	<? } ?>
</script>
<div class="form_box">
<form action="?done" method="post" onsubmit="return prevalidate_transaction(validations);">
	<input name="store" type="hidden" id="store" value="1"  />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
		<td>Date</td>
		<td>
			<input name="date" type="text" id="date" readonly="readonly" value="<? echo date("Y-m-d") ?>" />
		</td>
	  </tr> 
      <tr>
        <td>From Account:</td>
        <td><input name="faccount" type="text" id="faccount" onkeyup="make_upper(this);" /> (Optional)</td>
      </tr>
      <tr>
        <td>To Account:</td>
        <td><input name="taccount" type="text" id="taccount" onkeyup="make_upper(this);" /> (Optional)</td>
      </tr>
      <tr>
        <td>Amount:</td>
        <td><input name="amount" type="text" id="amount" /></td>
      </tr>
      <tr>
        <td>Comments:</td>
        <td><textarea name="comment" id="comment"></textarea></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
      </tr>
    </table>
</form>
</div>
<? }else{?>
<?
$trans_id = rand();
$trans = new _account_transaction();
$faccount = get_betting_account_by_name(clean_get("faccount"));
$trans->vars["account"] = $faccount->vars["id"];
$trans->vars["transaction_id"] = $trans_id;
$trans->vars["amount"] = clean_get("amount");
$trans->vars["substract"] = "1";
$trans->vars["tdate"] = clean_get("date");
$trans->vars["description"] = clean_get("comment");
$trans->insert();
$trans = new _account_transaction();
$taccount = get_betting_account_by_name(clean_get("taccount"));
$trans->vars["account"] = $taccount->vars["id"];
$trans->vars["transaction_id"] = $trans_id;
$trans->vars["amount"] = clean_get("amount");
$trans->vars["tdate"] = clean_get("date");
$trans->vars["description"] = clean_get("comment");
$trans->insert();
?>
<script type="text/javascript">parent.location.href = 'betting_moves.php?e=43';</script>
<? } ?>


</body>
</html>
<? }else{echo "Access Denied";} ?>