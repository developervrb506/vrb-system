<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<?
if($current_clerk->im_allow("prepaid_test")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<title>Prepaid Test</title>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"birthdate",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"firstname",type:"null", msg:"Name is required"});
validations.push({id:"birthdate",type:"null", msg:"Date is required"});
validations.push({id:"phone",type:"null", msg:"Phone is required"});
validations.push({id:"email",type:"null", msg:"Email is required"});
validations.push({id:"amount",type:"numeric", msg:"Amount is required"});
validations.push({id:"cardnumber",type:"numeric", msg:"Card is required"});
validations.push({id:"cvv",type:"numeric", msg:"Cvv is required"});
validations.push({id:"exp_month",type:"numeric", msg:"Month number is required"});
validations.push({id:"exp_year",type:"numeric", msg:"Year is required"});
validations.push({id:"lastname",type:"null", msg:"Last Name is required"});
validations.push({id:"country",type:"null", msg:"Country Code is required"});
validations.push({id:"address",type:"null", msg:"Address is required"});
validations.push({id:"city",type:"null", msg:"City is required"});
validations.push({id:"state",type:"null", msg:"State is required"});
validations.push({id:"zip",type:"null", msg:"Zip is required"});

</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title"><? echo $title ?></span><br /><br />

<? include "includes/print_error.php" ?>

<? if  (isset($_GET["result"])) {
	$show_form = false;
	$result = $_GET["result"];
	$display = 'none';
	$display_e = 'block';
	}
	else {
	$show_form = true;
	$display = "block" ;	
   $display_e = 'none';
	} 
	
	?>
    
    


<div style="display:<? echo $display_e ?>" id="div_result" class="form_box" >

<span><? echo $result ?> </span>
<BR/><BR/>
<a href="javascript:display_div('form');display_div('div_result')" class="normal_link" title="Click to open new Form" > Open New Form </a> 

</div>

<div id="form" class="form_box" style="display:<? echo $display ?>"; width:650px;">


	<form method="post" action="process/actions/prepaid_test_action.php" onsubmit="return validate(validations)">
    <? if($update) { ?><input name="update_id" type="hidden" id="update_id" value="<? echo $durango->vars["id"] ?>" /><? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td >Card Holder Name</td>
        <td><input style="width:160px" name="firstname" type="text" id="firstname" value="" /></td>
        <td> Last Name</td>
        <td><input style="width:160px" name="lastname" type="text" id="lastname" value="" /></td>
      </tr>           
       <tr>
       <td>Birthdate</td>
        <td><input style="width:160px" name="birthdate" type="text" id="birthdate" value="" /></td>
        <td>Email</td>
        <td><input style="width:160px" name="email" type="text" id="email" value="" /></td>
      </tr>   
      <tr>
       <td>Phone</td>
        <td><input style="width:160px" name="phone" type="text" id="phone" value="" /></td>
      </tr> 
      <tr>
       <td>Amount</td>
        <td><input style="width:160px" name="amount" type="text" id="amount" value="" /></td>
      </tr>   
        
            <tr>
       <td>CardNumber</td>
        <td><input style="width:200px" name="cardnumber" type="text" id="cardnumber" value="" /></td>
      
       <td>Cvv</td>
        <td><input style="width:60px" name="cvv" type="text" id="cvv" value="" /></td>
      </tr>   
        <tr>
       <td>Exp Month</td>
        <td><input style="width:80px" name="exp_month" type="text" id="exp_month" value="" />
          Year
        <input style="width:80px" name="exp_year" type="text" id="exp_year" value="" />
        (Example: Month : 05  Year : 18)
        </td>
      </tr> 
      <tr>
        <td>Country Code </td>
        <td><input style="width:60px" name="country" type="text" id="country" value="" /></td>
      </tr>
      <tr>
      <tr>
        <td>Address</td>
        <td><input  style="width:200px" name="address" type="text" id="address" value="" /></td>
      </tr> 
      <tr>
        <td>City</td>
        <td><input style="width:160px" name="city" type="text" id="city" value="" /></td>
      </tr>
      <tr>
      <tr>
        <td>State</td>
        <td><input style="width:160px" name="state" type="text" id="state" value="" /></td>
      </tr>
      <tr>
        <td>Zip</td>
        <td><input style="width:80px" name="zip" type="text" id="zip" value="" /></td>
      </tr>
      <tr>
        <td>Procesor</td>
        <td><select id="processor" name="processor">
           <option value="1">1</option>
           <option value="2">2</option>
         </select></td>
      </tr>
      
         <td><input type="image" src="../images/temp/submit.jpg" /></td>
        <td>&nbsp;</td>
      </tr>
      
    </table>
	</form>
 
    
    
</div>


</div>
<? include "../includes/footer.php";?>
<? }else{echo "Access Denied";}  ?>