<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("process_payouts")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Send Cash Transfer by Bitcoins</title>
<script type="text/javascript" src="includes/js/bets.js"></script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">

<? 
$transaction = get_cash_transfer_transaction($_GET["tid"]);
if(!is_null($transaction)){
?>
<span class="page_title">Send Cash Transfer by Bitcoins to <? echo $transaction->vars["sender_account"] ?></span><br /><br />
<? include "includes/print_error.php" ?>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"amount",type:"numeric", msg:"Please insert the Amount"});
validations.push({id:"sender",type:"null", msg:"Please insert the Sender Name"});
validations.push({id:"mtcn",type:"null", msg:"Please insert the MTCN"});
validations.push({id:"fees",type:"null", msg:"Please insert the fees"});
</script>
<div class="form_box" style="width:700px;">
	<form method="post" action="process/actions/send_cashtransfer_bitcoin.php" onsubmit="return validate(validations)">
	<input name="transaction" type="hidden" id="transaction" value="<? echo $transaction->vars["id"] ?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">        
	  
	  <tr>
		<td>Amount</td>
		<td><input name="amount" type="text" id="amount" value="<? echo $transaction->vars["amount"] ?>" /></td>
	  </tr>
      <tr>
		<td>Sender Name</td>
		<td><input name="sender" type="text" id="sender" /></td>
	  </tr>
      <tr>
		<td>MTCN</td>
		<td><input name="mtcn" type="text" id="mtcn" /></td>
	  </tr>
      <tr>
		<td>Fees</td>
		<td><input name="fees" type="text" id="fees" size="5" /></td>
	  </tr>
	  <tr>
		<td>Comments</td>
		<td><textarea name="comments" cols="30" rows="5" id="comments"></textarea></td>
	  </tr> 
	  <tr>    
		<td><input type="image" src="../images/temp/submit.jpg" /></td>
		<td>&nbsp;</td>
	  </tr>
	</table>
  </form>
</div>

<? }else{echo "Transaction not found";} ?>

</div>
<? include "../includes/footer.php" ?>

<? }else{echo "Access Denied";} ?>
