<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("reloadit_transactions")){ ?>
<?
$from = post_get("from");
$to = post_get("to",date("Y-m-d"));
$status = post_get("status_list","all");
$archived = post_get("archived","0");
if(!$current_clerk->vars["super_admin"]){
	$clerk = $current_clerk->vars["id"];
}else{
	$clerk = post_get("prs");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Reloadit Transactions</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="http://localhost:8080/ck/balances/api/functions.js"></script>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"></script>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
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

<span class="page_title">Reloadit Deposits</span>
<br /><br />
<form method="post">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
Status: <? $current_status = $status; $all_option = true; include("includes/pt_transaction_status_list.php") ?>
&nbsp;&nbsp;&nbsp;
Archved:
<select name="archived" id="archived">
  <option value="all" <? if($archived == "all"){echo 'selected="selected"';} ?>>All</option>
  <option value="1" <? if($archived == "1"){echo 'selected="selected"';} ?>>Yes</option>
  <option value="0" <? if($archived == "0"){echo 'selected="selected"';} ?>>No</option>
</select>
&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search" />
</form>

<? $trans = search_my_reloadit_transfers($from, $to, $status, $archived); ?>
<br /><br />
<? include "includes/print_error.php" ?>

<a href="manual_reloadit.php" class="normal_link" rel="shadowbox;height=300;width=405">Manual Reloadit</a>

&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;


<a href="intersystem_expenses.php" class="normal_link" rel="shadowbox;height=420;width=405">Insert Expense</a>

<br /><br />


<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="changer"></iframe>
<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="updater"></iframe>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Player</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Fees</td>
    <td class="table_header" align="center">re#</td>
    <td class="table_header" align="center">Date</td>
    <td width="150" align="center" class="table_header">Status</td>
        <td class="table_header" align="center">Confirmed</td>
    <td class="table_header" align="center" title="Comments">Com.</td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
   $i=0; 
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
  <tr style="color:<? echo $tran->get_color() ?>;" id="tr_<? echo $tran->vars["id"]; ?>">
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["player"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["amount"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["fees"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["number"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<div id="status_div_<? echo $tran->vars["id"] ?>">
		<? echo $tran->color_status(); ?><br /><? echo $tran->vars["back_message"]; ?>
		<? if($tran->vars["status"] != "de"){?>
            <br /><textarea name="back_msg_<? echo $tran->vars["id"] ?>" cols="10" rows="" id="back_msg_<? echo $tran->vars["id"] ?>"><? echo $tran->vars["processor_back_message"] ?></textarea><br /><input type="button" value="Deny" onclick="change_mp_status('<? echo $tran->vars["id"] ?>', 'de')" />
            
        <? } ?>
        </div>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo str_boolean($tran->vars["confirmed"] ) ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo nl2br($tran->vars["comments"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center" id="prs_td_<? echo $tran->vars["id"] ?>">
	<? if(!is_reloadit_reserved($tran->vars["id"])){ ?>
	<!--<a href="javascript:;" class="normal_link" onclick="archiveid('<? echo $tran->vars["id"] ?>')">Archive</a>
    
    &nbsp;&nbsp;|&nbsp;&nbsp;-->
    
    <a href="javascript:;" class="normal_link" onclick="display_div('pay_<? echo $tran->vars["id"] ?>')">Payout</a>
    <div style="display:none;" id="pay_<? echo $tran->vars["id"] ?>">
    	<form method="post" action="http://www.sportsbettingonline.ag/utilities/process/reports/create_reloadit_payout.php"  >
        <input name="deposit" type="hidden" id="deposit" value="<? echo $tran->vars["id"]; ?>" />
        Player:<input name="player" type="text" id="player<? echo $tran->vars["id"] ?>" />
        <input name="Submit" type="submit" value="Submit" />
        </form>
    </div>
    
    &nbsp;&nbsp;|&nbsp;&nbsp;
    
    <? if(!$tran->vars["archived"]){ ?>
    
    <a href="javascript:;" class="normal_link" onclick="display_div('trans_<? echo $tran->vars["id"] ?>')">Transfer</a>
    <div id="trans_<? echo $tran->vars["id"] ?>" style="margin-top:10px;display:none;">
    	<form method="post" action="process/actions/insert_intersystem_action.php" target="updater" id="frm_<? echo $tran->vars["id"] ?>" >
        	<input name="autoinsert" type="hidden" id="autoinsert" value="1" />
            <input name="system_list_from" type="hidden" id="system_list_from" value="4" />
            <input name="from_account" type="hidden" id="from_account" value="135" />
            <input name="amount" type="hidden" id="amount" value="<? echo $tran->vars["amount"]; ?>" />
            To:<br />
			<?
            $select_option = true;
            $extra_name = "_to";
            $system_change = "load_system_accounts('to_div_".$tran->vars["id"]."', this.value, 'to_account', 0);";
			$system_change .= "if(this.value != ''){document.getElementById('btn_".$tran->vars["id"]."').style.display = 'block';}else{document.getElementById('btn_".$tran->vars["id"]."').style.display = 'none';}";
            include("includes/systems_list.php");
            ?>
            <br /><div id="to_div_<? echo $tran->vars["id"] ?>"><input type="hidden" value="" name="to_account" id="to_account" /></div>
            <br />
            Note:
            <textarea name="note" cols="" rows="" id="note"></textarea>
            <input name="hidden_note" type="hidden" id="hidden_note" value="Moneypak Id:<? echo $tran->vars["id"] ?>" />
            <input type="button" value="Submit" id="btn_<? echo $tran->vars["id"] ?>" style="display:none;" onclick="send_intersystem('<? echo $tran->vars["id"] ?>')" />
        </form>
    </div>
    
    <? } ?>
    
    
    
    
    <?php /*?><a href="javascript:;" onclick="display_div('main_prs_<? echo $tran->vars["id"] ?>')" class="normal_link">Process</a>
    <div id="main_prs_<? echo $tran->vars["id"] ?>" style="display:none;">
    	Type:
        <select name="" onchange="show_type(this.value,'<? echo $tran->vars["id"] ?>')">
          <option value="">Select</option>
          <option value="e">Expense</option>
          <option value="t">Transfer</option>
        </select>
        <div id="e_<? echo $tran->vars["id"] ?>" style="display:none;">
        	<form method="post" action="process/actions/insert_expense_action.php" target="updater" onsubmit="archiveid('<? echo $tran->vars["id"] ?>');">
                Category: <? $all_option = false; include("includes/expenses_categories_list.php");  ?>
                <input name="date" type="hidden" id="date" value="<? echo $tran->vars["tdate"]; ?>" />
                <input name="type" type="hidden" id="type" value="-" />
                <input name="amount" type="hidden" id="amount" value="<? echo $tran->vars["amount"]; ?>" />
                <input name="note" type="hidden" id="note" value="" />
                <input name="noredirect" type="hidden" id="noredirect" value="1" />
                <input name="" type="submit" value="Submit" />
            </form>
        </div>
        <div id="t_<? echo $tran->vars["id"] ?>" style="display:none;">
        	....
            <input name="" type="submit" value="Submit" />
        </div>
    </div><?php */?>
    <? }else{echo "Reserved for a Payout";} ?>
    </td>
  </tr>
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>

</table>
<script type="text/javascript">
function change_mp_status(id, value){
	if(confirm("Are you sure you want to deny this transaction?")){
		var back_msg = document.getElementById("back_msg_"+id).value;
		document.getElementById('changer').src = 'process/actions/change_reloadit_status.php?id='+id+'&st='+value+'&bmsg='+back_msg;
		document.getElementById("status_div_"+id).innerHTML = '<span style="color:#C00">Rejected</span><br />'+back_msg;
		document.getElementById("tr_"+id).style.display = "none";	
	}
}
function show_type(type, id){
	document.getElementById("e_"+id).style.display = "none";
	document.getElementById("t_"+id).style.display = "none";
	if(type != ""){
		document.getElementById(type+"_"+id).style.display = "block";	
	}
}
function archiveid(id){
		document.getElementById('changer').src = 'process/actions/archive_reloadit.php?id='+id;
		document.getElementById("tr_"+id).style.display = "none";
		alert("Transaction has been processed");
}
function send_intersystem(id){
	document.getElementById("frm_"+id).submit();
	//document.getElementById("prs_td_"+id).innerHTML = "Transaction Inserted";
	archiveid(id);
}
</script>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>