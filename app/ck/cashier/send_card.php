<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_payout")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../process/js/functions.js"></script>
<title>Send Card</title>
</head>
<body>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">
	Send Card
</span>
<br /><br />


<script type="text/javascript">
var validations = new Array();
validations.push({id:"type",type:"null", msg:"Select a type"});
validations.push({id:"email",type:"email", msg:"Email is required"});
validations.push({id:"name",type:"null", msg:"Name is required"});
validations.push({id:"amount",type:"numeric", msg:"Amount is required"});
validations.push({id:"number",type:"null", msg:"Number is required"});
validations.push({id:"cvv",type:"numeric", msg:"CVV is required"});
validations.push({id:"expire_month",type:"numeric", msg:"Expire Month is required"});
validations.push({id:"expire_year",type:"numeric", msg:"Expire Year is required"});
</script>

<?
//ok,master,William%20daniells,350,09/21,0000%200000%200000%200000,125
if($_POST["action"] == "send"){
	
	$type = clean_get("type");
	$email = clean_get("email");
	$name = clean_get("name");
	$amount = clean_get("amount");
	$number = clean_get("number");
	$cvv = clean_get("cvv");
	$expire_month = clean_get("expire_month");
	$expire_year = clean_get("expire_year");
	$comment = clean_get("comment");
	
	$key = two_way_enc("ok,$type,$name,$cvv,$expire_month/$expire_year,$number,$amount");
	
	$content = "Here is your card:<br /><br />";
	$content .= "<div align='center'><img src='http://cashier.vrbmarketing.com/card.php?key=$key' width='398' height='250'></div><br /><br />";
	$content .= "Are you having problems viewing this card? <a href='http://cashier.vrbmarketing.com/card.php?key=$key'>View card in Browser</a>";
	$content .= "<br /><br />$comment";
	
	
	send_email_ck_auth($email, "Card test", $content, true);

	
	
	echo "Card was sent correctly.";
	
}else{
?>


<div class="form_box" style="width:500px;">
	<form method="post" onsubmit="return validate(validations);">
    <input name="action" type="hidden" id="action" value="send" />
		<table width="100%" border="0" cellspacing="0" cellpadding="10">        
	  <tr>
		<td>Type</td>
		<td>
        	<select name="type" id="type">
        	  <option value="">--Select--</option>
              <option value="visa">Vanilla Visa</option>
        	  <option value="master">Vanilla Master Card</option>
        	</select>
        </td>
	  </tr> 
      <tr>
		<td>Email</td>
		<td><input name="email" type="text" id="email" value="" /></td>
	  </tr> 
       <tr>
		<td>Name</td>
		<td><input name="name" type="text" id="name" value="" /></td>
	  </tr> 
	  <tr>
		<td>Amount</td>
		<td><input name="amount" type="text" id="amount" value="" /></td>
	  </tr> 
	  <tr>
		<td>Number</td>
		<td><input name="number" type="text" id="number" value="" /></td>
	  </tr>  
	  <tr>
		<td>CVV</td>
		<td><input name="cvv" type="text" id="cvv"  /></td>
	  </tr> 
      <tr>
		<td>Expiration</td>
		<td>
        
        	<select name="expire_month" id="expire_month">
            	<option value="">Month</option>
        	  <? for($i=1;$i<13;$i++){ ?>
				  <?
                  $number = $i;
				  if($number < 10){$number = "0".$number;}
				  ?>
                  <option value="<? echo $number ?>"><? echo $number ?></option>
              <? } ?>
        	</select>
            /
            <select name="expire_year" id="expire_year">
              <option value="">Year</option>
        	  <? for($i=16;$i<36;$i++){ ?>
                  <option value="<? echo $i ?>"><? echo $i ?></option>
              <? } ?>
        	</select>
        
        </td>
	  </tr> 
	  <tr>
		<td>Comment</td>
		<td><textarea name="comment" cols="35" rows="7" id="comment"></textarea></td>
	  </tr>
	  <tr>    
		<td><input type="image" src="<?= BASE_URL ?>/images/temp/submit.jpg" /></td>
		<td>&nbsp;</td>
	  </tr>
	</table>
  </form>
</div>
<? } ?>




</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>