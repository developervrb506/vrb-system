<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("intersystem_transactions")){ ?>
<?
$from = post_get("from",date("Y-m-d"));
$to = post_get("to",date("Y-m-d"));
$status = post_get("status_list","pe");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Balances Transactions</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
	function process_is_transaction(id, type){
		var params = "?id="+id+"&f=<? echo $from ?>&t=<? echo $to ?>&s=<? echo $status ?>";
		if(type == "c"){
			if(confirm("Are you sure you want to Cancel this Transaction?")){				
				location.href = "http://localhost:8080/ck/process/actions/cancel_intersystem_action.php"+params;
			}
		}else if(type == "a"){
			if(confirm("Are you sure you want to Accept this Transaction?")){				
				location.href = "http://localhost:8080/ck/process/actions/accept_intersystem_action.php"+params;
			}
		}
	}
	function dgs_reverse(tid, key){
		if(confirm("Are you sure you want to Reverse this transaction in DGS?")){
			var curl = "http://www.sportsbettingonline.ag/utilities/process/reports/cancel_dgs_affiliate_transaction.php";
			var params = "?cache="+key+"&dk=4S6X6e6S656c&od=1";
			document.getElementById("loaderi").src = curl+params;
			document.getElementById("cancel_link_"+tid).style.display = "none";
			alert("Transaction has been reversed");
		}
	}
</script>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Transactions</span> &nbsp;&nbsp;&nbsp;&nbsp;
<a href="intersystem_transaction.php" class="normal_link" rel="shadowbox;height=470;width=430">New Transaction</a>
<br /><br />
<form method="post" action="balances_transactions.php">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
Status: <? $current_status = $status; $all_option = true; include("includes/is_transaction_status_list.php") ?>
&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search" />
</form>

<? $trans = search_intersystem_transactions($from, $to, $status); ?>
<br /><br />
<? include "includes/print_error.php" ?>  
<iframe width="1"  height="1" frameborder="0" scrolling="no" id="loaderi" name="loaderi"></iframe>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">From</td>
    <td class="table_header" align="center">To</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
   $i=0; 
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
	   $accs = $tran->get_accounts();
  ?>
  <tr title="<? echo $tran->vars["note"]; ?>">    
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
		<? echo $accs["from_account"]["name"] . "<br />(". $accs["from_system"]["name"].")"; ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
		<? echo $accs["to_account"]["name"] . "<br />(". $accs["to_system"]["name"].")"; ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo basic_number_format($tran->vars["amount"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->str_status(); ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<? if($tran->vars["status"] == "pe"){ ?>
	        <a href="javascript:;" onclick="process_is_transaction('<? echo $tran->vars["id"]; ?>','a');" class="normal_link">Accept</a>
            &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="javascript:;" onclick="process_is_transaction('<? echo $tran->vars["id"]; ?>','c');" class="normal_link">Cancel</a>
        <? } ?>
    </td>
    <td class="table_td<? echo $style ?>" style="font-size:11px; color:#900">
		<? 
		if($tran->has_error()){
			echo $tran->get_error($accs);
		}
		if($tran->vars["afdraw"]){
			?>
            <div id="cancel_link_<? echo $tran->vars["id"]; ?>">
            	<a href="javascript:;" class="normal_link" onclick="dgs_reverse('<? echo $tran->vars["id"]; ?>', '<? echo two_way_enc($tran->vars["dgs_ID"]); ?>')">Reverse from DGS</a>
            </div>
            <?
		}
		?>
    </td>
  </td>
  <? } ?>
  <tr>
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



</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>