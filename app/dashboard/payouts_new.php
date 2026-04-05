<? include(ROOT_PATH . "/includes/reset_affiliate.php") ?>
<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
if(isset($_POST["book"])){
	$brand = $_POST["book"];
	$method = $_POST["pay_meth"];
	$name = $_POST["name"];
	$last = $_POST["last_name"];
	$birth_date = $POST["birth_date"];
	$email = $_POST["email"];
	$ad1 = $_POST["add1"];
	$ad2 = $_POST["add2"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$zip = $_POST["zip"];
	$country = $_POST["country"];
	$phone = $_POST["phone"];
	$amount = $_POST["amount"];	
	
	$code = get_affiliate_code($current_affiliate->id,$brand);
	$book = get_sportsbook($brand);
	
	$content = $current_affiliate->get_fullname()." (". $code .") requested a Payout.<br /><br />";
	$content .= "Brand: ".$book->name."<br />";
	$content .= "Method: $method<br />";
	$content .= "First Name: $name<br />";
	$content .= "Last Name: $last<br />";
	$content .= "Birth Date: $birth_date<br />";
	$content .= "Email: $email<br />";
	$content .= "Address: $ad1<br />";
	$content .= "Address2: $ad2<br />";
	$content .= "City: $city<br />";
	$content .= "State: $state<br />";
	$content .= "Zip: $zip<br />";
	$content .= "Country: $country<br />";
	$content .= "Phone: $phone<br />";
	$content .= "Amount: $amount<br />";
	
	//send_email_partners("Katvrbmarketing@gmail.com,katchaves@vrbmarketing.com,Fredvrbmarketing@gmail.com,fred@vrbmarketing.com,vrbaffiliates@gmail.com,wendyvrbmarketing@gmail.com", "New Payment Request ($code)", $content, true);
	send_email_partners("Katvrbmarketing@gmail.com,katchaves@vrbmarketing.com,vrbaffiliates@gmail.com,wendyvrbmarketing@gmail.com,mfajardo@vrbmarketing.com,dzamzack@vrbmarketing.com,baileyvrbmarketing@gmail.com", "New Payment Request ($code)", $content, true);
	$message = true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />

<title>Payouts</title>
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"birth_date",
			dateFormat:"%Y-%m-%d"
		});
		
	};
</script>

<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations1 = new Array();
validations1.push({id:"book",type:"null", msg:"Select a Brand"});
validations1.push({id:"methods",type:"null", msg:"Select a method"});
validations1.push({id:"name",type:"null", msg:"Write your name"});
validations1.push({id:"last_name",type:"null", msg:"Write your last name"});
validations1.push({id:"email",type:"email", msg:"Write a valid email"});
validations1.push({id:"add1",type:"null", msg:"Write your address"});
validations1.push({id:"city",type:"null", msg:"Write your city"});
validations1.push({id:"state",type:"null", msg:"Write your state"});
validations1.push({id:"zip",type:"null", msg:"Write your Zip Code"});
validations1.push({id:"country",type:"null", msg:"Write your country"});
validations1.push({id:"phone",type:"null", msg:"Write your phone number"});
validations1.push({id:"amount",type:"numeric", msg:"Write the amount"});
var validations2 = new Array();
validations2.push({id:"book",type:"null", msg:"Select a Brand"});
validations2.push({id:"methods",type:"null", msg:"Select a method"});
validations2.push({id:"name",type:"null", msg:"Write your name"});
validations2.push({id:"last_name",type:"null", msg:"Write your last name"});
validations2.push({id:"email",type:"email", msg:"Write a valid email"});
validations2.push({id:"phone",type:"null", msg:"Write your phone number"});
validations2.push({id:"amount",type:"numeric", msg:"Write the amount"});

var validations = validations1;

var methods = Array();
<? foreach(get_sportsbooks_by_affiliate($current_affiliate->id) as $book){ ?>
	methods[<? echo $book->id ?>] = Array();
	<? foreach(get_sportsbook_paypot_methods($book->id) as $condition){ ?>
		methods[<? echo $book->id ?>].push({method:"<? echo $condition["method"] ?>",condition:"<? echo str_replace("\r\n","",nl2br($condition["condition"])) ?>"});
	<? } ?>
<? } ?>

function load_methods(brand){
	if(brand != ""){
		var chtml = '<select name="methods" id="methods" onchange="load_terms(this.value)">';
		chtml += '<option value="">Select</option>';
		for(var i = 0; i < methods[brand].length; i++){
			chtml += '<option value="'+ i +'">'+ methods[brand][i].method +'</option>';
		}
		chtml += '</select>';
	}else{chtml = '-<input name="methods" type="hidden" id="methods" />';}
	document.getElementById("method_list").innerHTML = chtml;
}
function load_terms(method){
	var brand = document.getElementById("book").value;
	if(method != ""){
		thtml = methods[brand][method].condition;
		var list = document.getElementById("methods");
		document.getElementById("pay_meth").value = list.options[list.selectedIndex].text;
	}
	else{thtml = "";}
	if(method == 3){
		//document.getElementById("address_table").style.display = "none";
		document.getElementById("paypal_msg").style.display = "table";
		document.getElementById("paypal_birthdate").style.display = "table-row";
		validations = validations1;
	}else{
		document.getElementById("address_table").style.display = "table";
		document.getElementById("paypal_msg").style.display = "none";
		document.getElementById("paypal_birthdate").style.display = "none";
		validations = validations1;
	}
	document.getElementById("terms").innerHTML = thtml;	
}

</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<? $way = $_GET["w"]; ?>
<? $balance = str_replace("$","",get_wagerweb_customer_balance(get_affiliate_code($current_affiliate->id,1))); ?>

<div class="page_content" style="padding-left:20px;">

<span class="page_title" style="font-size:16px;">Payout Request</span><br /><br />

<? if($message){ ?>
<div class="error" style="font-size:20px;">Your Payout request has been sent.</div>
<? } ?>

<form method="post" onsubmit="return validate(validations)">
<input name="pay_meth" type="hidden" id="pay_meth" />
<div class="form_box" style="padding:20px;">
	AFFILIATE PAYMENT METHODS<br /><br />	
    
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%">
        
        <strong>Step 1.</strong> Select the brand: <br />
		<? $books_on_change = "load_methods(this.value)"; ?>
        <? $select_option = true;		 
		//include(ROOT_PATH . "/includes/books.php");
		?>
		<select name="book" id="book" class="" onchange="load_methods(this.value)">
	        <option value="" >Select</option>
			<?php /*?><option value="1" >Wagerweb</option>
            <option value="3" >Sports Betting Online</option><?php */?>            
            <? foreach(get_sportsbooks_by_affiliate($current_affiliate->id) as $book){
			$book_result = get_sportsbook($book->id);	
			?>
            <option value="<? echo $book->id ?>"><? echo $book_result->name ?></option>
            <? } ?>
        </select>
		<br /><br />
        <strong>Step 2.</strong> Select preferred payment method:<br /><div id="method_list">-<input name="methods" type="hidden" id="methods" /></div> <br />   
        
        <strong>Step 3.</strong> Fill out form with payment details: <br /><br /> 
        
        Payout methods have varying limits and associated processing fees.<br /><br />
        <table width="300" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td colspan="2"><strong>Beneficiary name (as per valid ID)</strong></td>
          </tr>
          <tr>
            <td>First Name</td>
            <td><input name="name" type="text"  id="name" size="35" /></td>
          </tr>
          <tr>
            <td>Last Name</td>
            <td><input name="last_name" type="text" size="35" id="last_name" /></td>
          </tr>
           <tr id="paypal_birthdate" style="display:none">
            <td>Birth Date:</td>
            <td><input name="birth_date" type="text" size="35" id="birth_date" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><strong>Beneficiary email (associated to method)</strong></td>
          </tr>
          <tr>
            <td>Email Address</td>
            <td><input name="email" type="text" size="35" id="email" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="300" border="0" cellspacing="0" cellpadding="5" id="address_table">
          <tr>
            <td colspan="2"><strong>Beneficiary address<p id="paypal_msg" style="display:none">( Asociated with Paypal)</p></strong></td>
          </tr>
          <tr>
            <td>Address 1</td>
            <td><input name="add1" type="text" size="35" id="add1" /></td>
          </tr>
          <tr>
            <td>Address 2</td>
            <td><input name="add2" type="text" size="35" id="add2" /></td>
          </tr>
          <tr>
            <td>City</td>
            <td><input name="city" type="text" size="35" id="city" /></td>
          </tr>
          <tr>
            <td>State</td>
            <td><input name="state" type="text" size="35" id="state" /></td>
          </tr>
          <tr>
            <td>Zip</td>
            <td><input name="zip" type="text" size="35" id="zip" /></td>
          </tr>
          <tr>
            <td>Country</td>
            <td><input name="country" type="text" size="35" id="country" /></td>
          </tr>
          <tr>
            <td>Phone</td>
            <td><input name="phone" type="text" size="35" id="phone" /></td>
          </tr>
        </table>
        <table width="300" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td colspan="2"><strong>Payout Amount</strong></td>
          </tr>
          <tr>
            <td>Amount</td>
            <td><input name="amount" type="text" size="35" id="amount" /></td>
          </tr>
        </table>        
        <br />
        <div align="justify">Please review your payment details and the T&Cs prior to submitting. (top right corner). Incorrect information may result in declined transactions or mis-routed payouts.  For assistance please contact us at 1.800.986.1152 or <a href="mailto:vrbaffiliates@gmail.com" class="normal_link">vrbaffiliates@gmail.com</a>.</div><br />
        
        <input name="" type="reset" value="RESET" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input name="" type="submit" value="SUBMIT" />
        
        </td>
        <td width="50%" valign="top">
        
        	<strong>T&amp;Cs:</strong>  <br /><br /><div id="terms"></div>
        
        </td>
      </tr>
    </table> 

    
</div>
</form>
</div>

<? include "../includes/footer.php" ?>