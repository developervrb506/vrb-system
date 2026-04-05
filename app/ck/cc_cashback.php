<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cc_cashback")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>DGS CC ChargeBack</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">DGS CC ChargeBack</span>&nbsp;&nbsp;&nbsp;&nbsp
<span ><a href="./cc_cashback_refund_report.php" class="normal_link">Report</a></span><BR/><BR/>


<? include "includes/print_error.php" ?>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
<script type="text/javascript">
    var validations = new Array();
    validations.push({id:"account",type:"null", msg:"Please Write the Player Account"});
	validations.push({id:"amount",type:"numeric", msg:"Please Write a valid Amount"});
	validations.push({id:"tid",type:"null", msg:"Please Write the Transaction Id"});
    validations.push({id:"descriptor",type:"null", msg:"Please Write the Descriptor"});
	validations.push({id:"method",type:"null", msg:"Please Select a Method"});	
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"datet",
			dateFormat:"%Y-%m-%d"
		});
	};

</script>

<?
if (isset($_GET["datet"])){
  $s_date = $_GET["datet"];	
}
else { $s_date = date("Y-m-d"); }

?>


<form method="post" action="http://www.sportsbettingonline.ag/utilities/process/reports/cc_cashback.php?pass=VrB123@www.com" onsubmit="return validate(validations);">
<div class="form_box" style="width:400px;">

	<table width="100%" border="0" cellspacing="0" cellpadding="5">
     
     <tr>
      <td>Date:</td>
        <td>
<input name="datet" type="text" id="datet" value="<? echo $s_date ?>" /></td>
      </tr>  
     <tr>
      <td>Type:</td>
        <td> <select id="type" name="type">
               <option selected="selected" value="c" >Cashback</option>
               <option value="r" >Refund</option>
               </select></td>
      </tr>
      <tr>
        <td>Account:</td>
        <td><input name="account" type="text" id="account" /></td>
      </tr>
      <tr>
        <td>Amount:</td>
        <td><input name="amount" type="text" id="amount" size="5" /></td>
      </tr>
      <tr>
        <td>Transaction Id:</td>
        <td><input name="tid" type="text" id="tid" /></td>
      </tr>
      <tr>
        <td>Method:</td>
        <td>
        	<select name="method" id="method">
        	  <option value="">--Select--</option>
              <option value="127">SBO DNP</option>
        	  <option value="128">SBO QP</option>
        	  <option value="129">SBO QP1</option>
        	  <option value="141">SBO QWIPIARS</option>
              <option value="145">SBO QWIPIARS2</option>
        	</select>
        </td>
      </tr>
      <tr>
        <td>Descriptor:</td>
        <td><input name="descriptor" type="text" id="descriptor" /></td>
      </tr>      
      <tr>
        <td>Notes:</td>
        <td><textarea name="notes" cols="" rows="" id="notes"></textarea></td>
      </tr>
      <tr>
        <td><input name="Enviar" type="submit" value="Insert" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
</div>

</form>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Acces Denied";} ?>