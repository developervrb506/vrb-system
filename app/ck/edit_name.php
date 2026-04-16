<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin") && !$current_clerk->im_allow("marketing_names")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
if(is_numeric($_GET["nid"])){
	$name = get_ckname($_GET["nid"]);
}else{
	$name = get_ckname_by_account($_GET["nid"]);
}
$last_call = get_name_last_call($name->vars["id"]);

if (!is_null($name)){ 
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
			target:"next_date",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"deposit_date",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<title><? echo $name->full_name()?> Info</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"name",type:"null", msg:"Name is required"});
validations.push({id:"last_name",type:"null", msg:"Last Name is required"});
validations.push({id:"street",type:"null", msg:"Street Name is required"});
validations.push({id:"city",type:"null", msg:"City is required"});
validations.push({id:"state",type:"null", msg:"State is required"});
validations.push({id:"zip",type:"null", msg:"Zip is required"});
<? if($current_clerk->vars["level"]->vars["is_admin"]){ ?>
validations.push({id:"email",type:"email", msg:"Email is required"});
validations.push({id:"phone",type:"null", msg:"Phone is required"});
<? } ?>
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $name->full_name()?> Info</span><br /><br />

<? include "includes/print_error.php" ?>

<div class="form_box" style="width:650px;">
	<form method="post" action="process/actions/edit_name_action.php" onsubmit="return validate(validations)">
    <input name="update_id" type="hidden" id="update_id" value="<? echo $name->vars["id"] ?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>List</td>
        <td><? $s_list = $name->vars["list"]->vars["id"]; include "includes/lists_list.php" ?></td>
      </tr>
      <tr>
        <td>Name</td>
        <td><input name="name" type="text" id="name" value="<? echo $name->vars["name"] ?>" /></td>
      </tr> 
      <tr>
        <td>Last Name</td>
        <td><input name="last_name" type="text" id="last_name" value="<? echo $name->vars["last_name"] ?>" /></td>
      </tr>
      <tr>
        <td>Street Name</td>
        <td><input name="street" type="text" id="street" value="<? echo $name->vars["street"] ?>" /></td>
      </tr>
      <tr>
        <td>City</td>
        <td><input name="city" type="text" id="city" value="<? echo $name->vars["city"] ?>" /></td>
      </tr> 
      <tr>
        <td>State</td>
        <td><input name="state" type="text" id="state" value="<? echo $name->vars["state"] ?>" /></td>
      </tr> 
      <tr>
        <td>Zip</td>
        <td><input name="zip" type="text" id="zip" value="<? echo $name->vars["zip"] ?>" /></td>
      </tr>
      <? // if($current_clerk->vars["level"]->vars["is_admin"]){ ?>
      <tr>
        <td>Email</td>
        <td><input name="email" type="text" id="email" value="<? echo trim($name->vars["email"]) ?>" /></td>
      </tr> 
      <tr>
        <td>Phone</td>
        <td><input name="phone" type="text" id="phone" value="<? echo trim($name->vars["phone"]) ?>" /></td>
      </tr>      
      <tr>
        <td>Phone 2</td>
        <td><input name="phone2" type="text" id="phone2" value="<? echo trim($name->vars["phone2"]) ?>" /></td>
      </tr>
      <? //  } ?> 
      <tr>
        <td>Status</td>
        <td><? $s_status = $name->vars["status"]->vars["id"]; include "includes/status_list.php" ?></td>
      </tr>
      <tr>
        <td>Clerk</td>
        <td><?
			if($name->vars["on_the_phone"]){$clerks_disabled = true;}
			$free_option = true;
			$clerks_admin = "2,4,5";
			$s_clerk = $name->vars["clerk"]->vars["id"];
			include "includes/clerks_list.php";
			if($name->vars["on_the_phone"]){
				echo "<span class='error'> This Person is currently on the phone with <strong>" . $name->vars["clerk"]->vars["name"] . "</strong></span>";
			} 
		?></td>
      </tr>   
      <tr>
        <td>Call Back in</td>
        <td><input name="next_date" type="text" id="next_date" value="<? echo null_date($name->vars["next_date"]) ?>" /></td>
      </tr>
      <tr>
        <td>What does he wants<br />to receive by Email?</td>
        <td><textarea name="email_desc" cols="30" rows="5" id="email_desc"><? echo $name->vars["email_desc"] ?></textarea></td>
      </tr> 
      <tr>
        <td>Last Conv. Status</td>
        <td>
        	<? if(!is_null($last_call->vars["conversation_status"])){ ?>
				<? echo $last_call->vars["conversation_status"]->vars["name"] ?>
                <br />
                <? echo date("M jS, Y / g:i:s a",strtotime($last_call->vars["conversation_status_time"])); ?>
            <? }else{echo "N/A";} ?>
        </td>
      </tr>
      <tr>
        <td>Clerk's Notes</td>
        <td><textarea name="note" cols="30" rows="7" id="note"><? echo $name->vars["note"] ?></textarea></td>
      </tr> 
      <tr>
        <td>Book</td>
        <td><input name="book" type="text" id="book" value="<? echo $name->vars["book"] ?>" /></td>
      </tr> 
      <tr>
        <td>Account Number</td>
        <td><input name="acc_number" type="text" id="acc_number" value="<? echo $name->vars["acc_number"] ?>" /></td>
      </tr>
      <tr>
        <td>Free Play</td>
        <td><input name="free_play" type="checkbox" id="free_play" <? if($name->vars["free_play"]){echo 'checked="checked"';} ?> value="1" /></td>
      </tr>
      <tr>
        <td>Affiliate ID</td>
        <td><input name="aff_id" type="text" id="aff_id" value="<? echo $name->vars["aff_id"] ?>" /></td>
      </tr> 
      <tr>
      	<? $mnote = get_affiliate_description_by_af($name->vars["aff_id"]) ?>
        <td></td>
        <td><? echo nl2br($mnote->vars["description"]); ?></td>
      </tr> 
      
      <tr>
        <td>Deposit Amount</td>
        <td><input name="deposit_amount" type="text" id="deposit_amount" value="<? echo $name->vars["deposit_amount"] ?>" /></td>
      </tr>
      
      <tr>
        <td>Deposit Date</td>
        <td><input name="deposit_date" type="text" id="deposit_date" value="<? echo null_date($name->vars["deposit_date"]) ?>" /></td>
      </tr> 

      
      <tr>
        <td>Deposit Method</td>
        <td><? $s_method = $name->vars["payment_method"]; $none_option = true ;include "includes/payment_method_list.php" ?></td>
      </tr> 
      <tr>
      
      <tr>
        <td>Source</td>
        <td><input name="source" type="text" id="source" value="<? echo $name->vars["source"] ?>" /></td>
      </tr>
      
      <tr>
        <td>Source (By Clerk)</td>
        <td><input name="csource" type="text" id="csource" value="<? echo $name->vars["clerk_source"] ?>" /></td>
      </tr>
      
      <tr>
        <td>Why stopped playing?<br />(Reloads Lists)</td>
        <td><textarea name="whyno" cols="30" rows="5" id="whyno"><? echo $name->vars["why_stop"] ?></textarea></td>
      </tr> 
       
      <tr>      
        <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
</div>


</div>
<? include "../includes/footer.php";}
else{
echo "This Player is not in the CRM";	
}
?>