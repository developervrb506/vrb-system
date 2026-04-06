<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("clerks_deposit_report")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?
$account = clean_get("account");
$name_list = clean_get("list_list");
$name = search_signup_name($account, $name_list);
if(!is_null($name)){$clerks = get_clerks_that_called($name->vars["id"]);}

if(isset($_POST["save"])){	
	if($_POST["amount"] > 0){
		$name->vars["deposit_amount"] = $_POST["amount"];
		$name->vars["deposit_date"] = $_POST["date"];
		$name->vars["payment_method"] = $_POST["payment_method_list"];
		$name->vars["available"] = "0";
		$name->vars["deposit"] = "1";
		$name->update(array("deposit_amount","payment_method","available","deposit_date","deposit"));
		
		$method = get_payment_method($name->vars["payment_method"]);
		
		foreach($clerks as $clk){
			$clk_commission = $_POST["commission_" . $clk->vars["id"]];
			$clk_comment = $_POST["comment_" . $clk->vars["id"]];
			
			$transaction = get_transaction_by_clerk_and_name($clk->vars["id"],$name->vars["id"]);
			
			if(is_null($transaction)){
				if($clk_commission > 0){$name->insert_transaction($clk_commission,$method,$clk_comment,$clk);}
			}else{
				$transaction->vars["amount"] = $clk_commission;
				$transaction->vars["current_percentage"] = $method["percentage"];
				$transaction->vars["current_cap"] = $method["cap"];
				$transaction->vars["transaction_date"] = date("Y-m-d H:i:s");
				$transaction->vars["comment"] = $clk_comment;
				$transaction->update(array("amount","transaction_date","current_percentage","current_cap","comment"));
			}
			
			
				
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Deposits</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript">
var validations = new Array();
validations.push({id:"amount",type:"numeric", msg:"The Amount is required"});
validations.push({id:"date",type:"null", msg:"Deposit Date is required"});
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Deposits</span><br /><br />

<? include "includes/print_error.php" ?>

<form method="post" action="deposist_report_new.php">
    Account: 
    <input name="account" type="text" id="account" value="<? echo $account ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <? $all_option = true; $s_list = $name_list; include "includes/lists_list.php" ?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
</form>

<br />
<? if(!is_null($name)){ ?>
<form action="deposist_report_new.php?e=28" method="post" id="deposit_form" onsubmit="return validate(validations);">
<input name="save" type="hidden" id="save" value="1" />
<input name="account" type="hidden" id="account" value="<? echo $account ?>" />
<input name="list_list" type="hidden" id="list_list" value="<? echo $name_list ?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Account</td>
    <td class="table_header">Affiliate</td>
    <td class="table_header">Name</td>
    <td class="table_header">Clerk</td>
    <td class="table_header">Calls</td>
    <td class="table_header">View</td>
    <td class="table_header">Amount</td>
    <td class="table_header">Date</td>
    <td class="table_header">Method</td>
  </tr>	
    <tr>
        <td class="table_td1"><? echo $name->vars["acc_number"]; ?></td>
        <td class="table_td1"><? echo $name->vars["aff_id"]; ?></td>
        <td class="table_td1"><? echo $name->full_name(); ?></td>
        <td class="table_td1"><? echo $name->vars["clerk"]->vars["name"]; ?></td>
        <td class="table_td1">
          <a href="call_history.php?nid=<? echo $name->vars["id"] ?>" rel="shadowbox;height=230;width=570" title="<? echo $name->full_name() ?> Call History" class="normal_link">
          Calls
          </a>
        </td>
        <td class="table_td1">
          <a href="edit_name.php?nid=<? echo $name->vars["id"] ?>" target="_blank" class="normal_link">View</a>
        </td>
        <td class="table_td1">
            $<input name="amount" onblur="update_commissions()" onkeyup="update_commissions()" onchange="update_commissions()" type="text" id="amount" size="5" value="<? echo $name->vars["deposit_amount"]; ?>" autocomplete="off" />
        </td>
        <td class="table_td1">
            <input name="date" type="text" id="date" size="7" value="<? echo null_date($name->vars["deposit_date"]); ?>" />
        </td>
        <td class="table_td1">
              <?
               $s_method = $name->vars["payment_method"];
			   $pay_list_change = "update_commissions()";		   
               include "includes/payment_method_list.php" 
               ?>
        </td>
        
    </tr>	   
    
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>

</table>

<br /><br />

Clerks<br />

<table width="50%" border="0" cellpadding="0" cellspacing="0" id="clerks_table">
  <tr>
    <td class="table_header">Select</td>
    <td class="table_header">Name</td>
    <td class="table_header">Commission</td>
    <td class="table_header">Transaction Comment</td>
  </tr>

<?
$i=0;
$count_clerks = count($clerks);
foreach($clerks as $clerk){
	  if($i % 2){$style = "1";}else{$style = "2";}
	  $i++;
	  $commission = "0";
	  $comment = "";
	  $chk_status = '';
	  
	  if($name->vars["deposit_amount"] > 0){
		  $transaction = get_transaction_by_clerk_and_name($clerk->vars["id"], $name->vars["id"]);
		  $commission = $transaction->vars["amount"];
		  $comment = $transaction->vars["comment"];
		  if(!is_null($transaction)){
			  if($commission > 0){$chk_status = 'checked="checked"';}
		   }else{
			   $commission = "0";
			   $chk_status = '';
			   $comment = "";
		   }
	  }else{
		 $commission = "0";
		 $comment = "";
		 $chk_status = 'checked="checked"';
	  }
	  
	  ?>
	  <tr>
		  <td class="table_td<? echo $style ?>">
          	<input name="check_<? echo $clerk->vars["id"]; ?>" type="checkbox" id="check_<? echo $clerk->vars["id"]; ?>" onclick="update_commissions()" value="<? echo $clerk->vars["id"]; ?>" <? echo $chk_status ?> />
          </td>
		  <td class="table_td<? echo $style ?>"><? echo $clerk->vars["name"]; ?></td>
		  <td class="table_td<? echo $style ?>">
          	$<input name="commission_<? echo $clerk->vars["id"]; ?>" type="text" id="commission_<? echo $clerk->vars["id"]; ?>" value="<? echo $commission ?>" size="7" />
          </td>  
          <td class="table_td<? echo $style ?>">
          	<textarea name="comment_<? echo $clerk->vars["id"]; ?>" id="comment_<? echo $clerk->vars["id"]; ?>"><? echo $comment ?></textarea>
          </td>  
	  </tr>	
	  <?
}
?>
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>

</table>

<br /><br />

<div align="right"><input name="" type="submit" value="Submit" /></div>
</form>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date",
			dateFormat:"%Y-%m-%d"
		});
	};
	var methods = Array();
	<? $methods = get_payment_methods() ?>
	<? foreach($methods as $method){ ?>
		methods[<? echo $method["id"] ?>] = {percentage:"<? echo $method["percentage"] ?>",cap:"<? echo $method["cap"] ?>"};
	<? } ?>
	function update_commissions(){
		var amount = document.getElementById("amount").value;
		var complete_commission = calculate_commission(amount);
		var clerks = Array();
		//if(amount > 0){
			var elements = document.getElementById("deposit_form").elements;
			for(var i = 0; i < elements.length; i++){
				if(elements[i].type == "checkbox"){
					if(elements[i].checked){
						clerks.push(elements[i].value);
					}else{
						document.getElementById("commission_"+elements[i].value).value = "0";
						document.getElementById("comment_"+elements[i].value).value = "";
					}
				}
			}
			var clerk_count =  clerks.length;
			var commission = complete_commission / clerk_count;
			commission = Math.round(commission*100)/100;
			for(var i = 0; i < clerk_count; i++){
				document.getElementById("commission_"+clerks[i]).value = commission;
				if(clerk_count > 1){document.getElementById("comment_"+clerks[i]).value = "Splitted in " + clerk_count + " Clerks";}
				else{document.getElementById("comment_"+clerks[i]).value = "";}
				
			}
		//}
	}
	function calculate_commission(amount){
		var method = methods[document.getElementById("payment_method_list").value];
		var commission = amount * (method.percentage / 100);
		if(commission > method.cap){commission = method.cap}
		return commission;
	}
</script>
<? } ?> 
</div>
<? include "../includes/footer.php" ?>