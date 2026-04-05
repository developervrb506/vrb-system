<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("dgs_money_transfers")){ ?>
<?
include("includes/dgs_deposit_process.php");
$cash_url = "cash.ezpay.com";
if(@file_get_contents("http://cash.ezpay.com/checker.php") != 'OK'){$cash_url = "www.sportsbettingonline.ag";}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">DGS Deposit</span><br /><br />
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"methods_list",type:"null", msg:"Please select a Payment Method"});
validations.push({id:"fees",type:"numeric", msg:"Please insert the Fees"});
validations.push({id:"fees_method",type:"null", msg:"Please select the Fees Method"});
validations.push({id:"bonus",type:"numeric", msg:"Please insert the Bonus"});
validations.push({id:"bonus_method",type:"null", msg:"Please select the Bonus Method"});
validations.push({id:"rollover",type:"numeric", msg:"Please insert the Roll Over"});
validations.push({id:"cbonus",type:"numeric", msg:"Please insert the Casino Bonus"});
</script>
<? include "includes/print_error.php" ?>

<div class="form_box">
	<p>
        <a href="javascript:;" onclick="display_div('plnotes')" class="normal_link">Player Notes +</a>
        <div id="plnotes" style="display:none;">
            <? echo $_GET["pnote"] ?>
        </div>
	</p>
    <? $msgaccount = str_replace(" ","",$account); ?>
	<? echo file_get_contents("http://$cash_url/utilities/process/reports/print_player_all_notes.php?player=$msgaccount&num=4"); ?>
</div>
<div class="form_box">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td><strong>Account:</strong> <? echo $account ?></td>
        <td><strong>Method:</strong> <? echo $mname ?></td>
        <td><strong><? echo $cname ?></strong> <? echo $mtcn ?></td>
        <td><strong>Amount:</strong> $<? echo $amount ?></td>
      </tr>
    </table>
</div>
<form method="post" onsubmit="return validate(validations)" action="process/actions/dgs_deposit_action.php">
<input name="transaction" type="hidden" id="transaction" value="<? echo $tid ?>" />
<input name="account" type="hidden" id="account" value="<? echo $account ?>" />
<input name="method" type="hidden" id="method" value="<? echo $method ?>" />
<input name="mtcn" type="hidden" id="mtcn" value="<? echo $mtcn ?>" />
<input name="amount" type="hidden" id="amount" value="<? echo $amount ?>" />
<input name="description" type="hidden" id="description" value="<? echo $description ?>" />
<div class="form_box">
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
      <tr>
        <td>
        	<strong>Payment Method:</strong>  
            <? echo @file_get_contents("http://$cash_url/utilities/process/reports/print_payment_methods.php?cm=$pm&so=1&filter=$mfilter"); ?>
        </td>
        <td><strong>Fee:</strong> <input name="fees" type="text" id="fees" size="3" value="<? echo $fees ?>" /> 
          <select name="fees_method" id="fees_method">
            <option value="">--Select--</option>
            <option value="P">Free Play</option>
            <option value="A">Cash</option>
          </select></td>
      </tr>
       <tr>
         <td><strong>Bonus: </strong>
           <input name="bonus" type="text" id="bonus" size="3" value="<? echo $bonus ?>" />
           %
           <select name="bonus_method" id="bonus_method" onchange="change_bonus_type(this.value)">
             <option value="">--Select--</option>
             <option value="P">Free Play</option>
             <option value="A">Cash</option>
             <option value="C">Casino</option>
           </select>
           X
  <input name="rollover" type="text" id="rollover" size="3" />
           Roll Over
           <script type="text/javascript">
		  function change_bonus_type(type){
			  var per_field = document.getElementById("bonus");
			  var roll_field = document.getElementById("rollover");
			  if(type == 'C'){
				  per_field.value = "<? echo $casino_bonus_percentage ?>";
				  roll_field.value = "<? echo $casino_bonus_rollover ?>";
				 // per_field.readOnly = true;
				 // roll_field.readOnly = true;
			  }else{
				  per_field.value = "0";
				  roll_field.value = "";
				  per_field.readOnly = false;
				  roll_field.readOnly = false;
			  }
		  }
		  </script>
	</td>
         <td align="right">
          <? echo @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_manage_bonus_players_selected.php?ps=VRB@conection&player=".$msgaccount);
         ?>
         </td>
       </tr>
       <tr>
         <td><strong>Casino Chips:</strong>
           $<input name="cbonus" type="text" id="cbonus" size="3" /> </td>
        <td align="right"><input type="submit" value="INSERT DEPOSIT" /></td>
      </tr>
    </table>
    <br />
    <iframe src="http://localhost:8080/ck/loader_sbo.php?type=dgs_deposit&data=<? echo $account ?>&url=<? echo $cash_url ?>"  frameborder="0" scrolling="auto" width="100%" height="250"></iframe>
</div>
</form>
</div>
<? }else{echo "Access Denied";} ?>