<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("clerks_transaction")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$current_date = date("Y-m-d");
if(isset($_GET["cid"])){
	$clerk = get_clerk($_GET["cid"]);
	$update = false;
	$clerks_disabled = true;
	$title = $clerk->vars["name"];
}else if(isset($_GET["pid"])){
	$transaction = get_clerk_transaction($_GET["pid"]);
	$current_date = $transaction->vars["transaction_date"];
	$clerk = $transaction->vars["clerk"];
	$update = true;
	$title = "Edit";
}else{
	$title = "New";
	$update = false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title><? echo $title ?> Transaction</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"trans_date",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"clerk_list",type:"null", msg:"Clerk is required"});
validations.push({id:"amount",type:"numeric", msg:"Amount is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?> Transaction</span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/create_transaction_action.php" onsubmit="return validate(validations)">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $transaction->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>Clerk</td>
        <td>
		<? 
		$clerks_admin = "2,4,5"; 
		$select_option = true;
		$s_clerk = $clerk->vars["id"]; 
		if($clerks_disabled){ ?><input name="clerk_list" type="hidden" id="clerk_list" value="<? echo $clerk->vars["id"] ?>" /><? }
		include "includes/clerks_list.php" 
		?>
        </td>
      </tr>
      <tr>
        <td>Payment Date</td>
        <td><input name="trans_date" type="text" id="trans_date" value="<? echo $current_date ?>" readonly="readonly" /></td>
      </tr>
      <tr>
        <td>Type</td>
        <td>
        	<? 
			$s_type = $transaction->vars["substract"]; 
			include "includes/trans_type_list.php" 
			?>
        </td>
      </tr>
      <tr>
        <td>Amount</td>
        <td><input name="amount" type="text" id="amount" value="<? echo $transaction->vars["amount"] ?>" /></td>
      </tr>
      <tr>
        <td>Comments</td>
        <td><textarea name="comment" cols="30" rows="5" id="comment"><? echo $transaction->vars["comment"] ?></textarea></td>
      </tr>
      <tr>
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
</div>


</div>
<? include "../includes/footer.php" ?>