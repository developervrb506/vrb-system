<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneypak_transactions")){ ?>
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

$intersystems = get_intersystem_mp_ids();
$cinters = get_intersystem_related_to_mps();
$systems = get_all_systems_list();
$sells = get_all_mp_sells_ids();
$credits = get_all_credit_accounts_list();

$zipas = get_all_zip_address("state, country_short");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Paks Transactions</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/balances/api/functions.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
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
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title"> <? if($_GET["safe"]){echo "Safe";} ?> Paks Deposits</span>
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

<? 
if($_GET["safe"]){$safe = "1";}
else{$safe = "0";}
$trans = search_my_moneypak_transfers($from, $to, $status, $archived, $safe);
$players = "";
foreach($trans as $ptr){
	$players .= ",'".$ptr->vars["player"]."'";
}
$players = substr($players,1);
$mp_counts = count_mps_by_player_list($players);
$obalances = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/players_balances.php?accs=".str_replace("'","",$players)));
$balances = (array) $obalances;

$nets = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/players_net_winloss.php?accs=".str_replace("'","",$players)));

?>
<br /><br />
<? include "includes/print_error.php" ?>

<a href="manual_moneypack.php" class="normal_link" rel="shadowbox;height=350;width=405">Manual Pak</a>

&nbsp;&nbsp;|&nbsp;&nbsp;


<a href="intersystem_expenses.php" class="normal_link" rel="shadowbox;height=420;width=405">Insert Expense</a>

&nbsp;&nbsp;|&nbsp;&nbsp;


<a href="moneypak_payouts.php" class="normal_link">Paks Payouts Details</a>


&nbsp;&nbsp;|&nbsp;&nbsp;


<a href="office_expenses_moneypaks.php" class="normal_link">Pending Moneypak Expenses</a>

&nbsp;&nbsp;|&nbsp;&nbsp;

<a href="moneypak_only_deposit_players.php" class="normal_link">Players Without Payouts</a>

&nbsp;&nbsp;|&nbsp;&nbsp;


<a href="moneypak_limbos.php" class="normal_link">Paks Waiting Payouts</a>

<? if($current_clerk->im_allow("moneypak_sell")){ ?>

&nbsp;&nbsp;|&nbsp;&nbsp;

<a href="moneypak_sell.php" class="normal_link">Moneypak Sell</a>

<? } ?>
<? if($current_clerk->im_allow("buy_moneypaks_promo")){ ?>

&nbsp;&nbsp;|&nbsp;&nbsp;

<a href="buy_moneypaks_promo.php" class="normal_link">Buy Moneypaks Promo</a>

<? } ?>


<br /><br />


<a href="mp_expences_list.php" class="normal_link" rel="shadowbox;height=420;width=405">Expences List</a>

&nbsp;&nbsp;|&nbsp;&nbsp;

<a href="moneypack_players.php" class="normal_link">Paks Black List</a>

<br /><br />


<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="changer"></iframe>
<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="updater"></iframe>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="sortable">
  <thead>
  <tr>
    <th class="table_header" align="center" style="cursor:pointer;">Id</th>
    <th class="table_header" align="center" style="cursor:pointer;">Method</th>
    <th class="table_header" align="center" style="cursor:pointer;">Player</th>
    <th class="table_header" align="center" style="cursor:pointer;">Win/Loss</th>
    <th class="table_header" align="center" style="cursor:pointer;">#s sent</th>
    <th class="table_header" align="center" style="cursor:pointer;">Balance</th>
    <th class="table_header" align="center" style="cursor:pointer;">Amount</th>
    <th class="table_header" align="center" style="cursor:pointer;">Fees</th>
    <th class="table_header" align="center" style="cursor:pointer;">#</th>
    <th class="table_header" align="center" style="cursor:pointer;">Zip</th>
    <th class="table_header" align="center" style="cursor:pointer;">State</th>
    <th class="table_header" align="center" style="cursor:pointer;">Date</th>
    <th width="150" align="center" class="table_header sorttable_nosort">Status</th>
    <th class="table_header sorttable_nosort" align="center">Confirmed</th>
    <th class="table_header sorttable_nosort" align="center" title="Comments">Com.</th>
    <th class="table_header sorttable_nosort" align="center"></th>
    <th class="table_header sorttable_nosort" align="center">Blocked</th>
    <th class="table_header sorttable_nosort" align="center">Safe</th>
    <? if($current_clerk->im_allow("view_mp_numbers")){ ?>
    <th class="table_header sorttable_nosort" align="center"></th>
    <? } ?>
  </tr>
  </thead>
  <tbody>
  <?
   $i=0; 
   $total = 0;
   $total_fees = 0;
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
	   
	   $mps_count = $mp_counts[strtoupper($tran->vars["player"])]["num"];
	   
	   if($tran->vars["confirmed"]){
		   $extra_stl = "_light_";
	   }else if(!$tran->vars["authorized"]){
		   $extra_stl = "_red_";
	   }else if($mps_count <= 5){
		   $extra_stl = "_yellow_";
	   }else{
		   $extra_stl = "";
	   }
       $i++;
	   $reserved_player = get_mp_reserved_player($tran->vars["id"]);
	   if(is_null($reserved_player)){$total += $tran->vars["amount"]; $total_fees += $tran->vars["fees"]; }
  ?>  
  <? if(is_null($reserved_player) || $archived){ ?>
  <tr style="color:<? echo $tran->get_color() ?>;" id="tr_<? echo $tran->vars["id"]; ?>">
    <td class="table_td<? echo $extra_stl.$style ?>" align="center">
		<? echo $tran->vars["id"]; ?>
        <? if(is_moneypack($tran->vars["player"],"deposit")){ ?>
        <img src="images/bl.gif" width="40" height="40" alt="BLack List" />
        <? } ?>
    </td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $tran->str_method(); ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $tran->vars["player"]; ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center">$<? //eval("echo \$nets->".$tran->vars["player"]."->net;"); ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $mps_count ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? // echo $balances[$tran->vars["player"]]->amount ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $tran->vars["amount"]; ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $tran->vars["fees"]; ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center">
		<? 
		if($current_clerk->im_allow("view_mp_numbers")){
			echo num_two_way($tran->vars["number"], true); 
		}else{
			echo $tran->vars["number"]; 
		}		
		?>
    </td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $tran->vars["zip"]; ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center">
		<? echo $zipas[$tran->vars["zip"]]->vars["state"] ?>
    </td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center">
    	<div id="status_div_<? echo $tran->vars["id"] ?>">
		<? echo $tran->color_status(); ?><br /><? echo $tran->vars["back_message"]; ?>
		<? if($tran->vars["status"] != "de"){?>
            <br /><textarea name="back_msg_<? echo $tran->vars["id"] ?>" cols="10" rows="" id="back_msg_<? echo $tran->vars["id"] ?>"><? echo $tran->vars["processor_back_message"] ?></textarea><br /><input type="button" value="Deny" onclick="change_mp_status('<? echo $tran->vars["id"] ?>', 'de')" />
            
        <? } ?>
        </div>
    </td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center" id="confirmed_<? echo $tran->vars["id"] ?>">
		<a href="javascript:;" onclick="chenge_confirmed(<? echo $tran->vars["id"] ?>,<? echo $tran->vars["confirmed"] ?>)" class="normal_link"><? echo str_boolean($tran->vars["confirmed"] ) ?></a>
    </td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center"><? echo nl2br($tran->vars["comments"]); ?></td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center" id="prs_td_<? echo $tran->vars["id"] ?>">
    <? 
	if(in_array(array("id"=>$tran->vars["id"]),$sells)){
		echo "Used for BuyMoneypaks.com<br /><br />";	
	}
	?>
	<? if(is_null($reserved_player)){ ?>
    
		<? if($tran->vars["status"] == "de"){ ?>
        
        	<? if(!$tran->vars["archived"]){ ?>
            <a href="javascript:;" class="normal_link" onclick="archiveid('<? echo $tran->vars["id"] ?>')">Archive</a>
            <? } ?>
        
        <? }else{ ?>
            
            
            <? if(!$tran->vars["archived"]){ ?>
            <a href="javascript:;" class="normal_link" onclick="display_div('pay_<? echo $tran->vars["id"] ?>')">Payout</a>
            <div style="display:none;" id="pay_<? echo $tran->vars["id"] ?>">
                <form method="post"  action="<?= BASE_URL ?>/ck/loader_sbo.php"   >
                <input name="loader" type="hidden" value= "moneypak_transactions" />
                <input name="deposit" type="hidden" id="deposit" value="<? echo $tran->vars["id"]; ?>" />
                Player:<input name="player" type="text" id="player<? echo $tran->vars["id"] ?>" />
                <input name="Submit" type="submit" value="Submit" />
                </form>
            </div>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="javascript:;" class="normal_link" onclick="display_div('trans_<? echo $tran->vars["id"] ?>')">Transfer</a>
            <div id="trans_<? echo $tran->vars["id"] ?>" style="margin-top:10px;display:none;">
                <form method="post" action="process/actions/insert_intersystem_action.php" target="updater" id="frm_<? echo $tran->vars["id"] ?>" >
                    <input name="autoinsert" type="hidden" id="autoinsert" value="1" />
                    <input name="system_list_from" type="hidden" id="system_list_from" value="4" />
                    <input name="from_account" type="hidden" id="from_account" value="130" />
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
            
            
            	<? if($tran->vars["status"] == "ac"){ ?>
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    
                    <a href="process/actions/change_mp_active.php?id=<? echo $tran->vars["id"] ?>" class="normal_link">
                        <? echo $tran->str_active() ?>
                    </a>
                    
                    <? if($tran->vars["active"]){ ?>
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="mp_intersystem_expenses.php?mp=<? echo $tran->vars["id"] ?>" class="normal_link" rel="shadowbox;height=400;width=405">
                        Expense
                    </a>
                    <? } ?>
                <? } ?>
            
            
            <? 
			}else if(in_array(array("mp"=>$tran->vars["id"]),$intersystems)){
				?> <div id="untr_<? echo $tran->vars["id"] ?>"> <?
					echo "Transfered to ";
					$inter_system = $systems[$cinters[$tran->vars["id"]]["to_system"]];
					$inter_trans = $cinters[$tran->vars["id"]];
					$cred_acc = $credits[$inter_trans["to_account"]];
					echo $inter_system["name"].", ".$cred_acc->vars["name"]; 
					?>
					<form method="post" action="process/actions/insert_intersystem_action.php" target="updater" id="unfrm_<? echo $tran->vars["id"] ?>">
						<input name="autoinsert" type="hidden" id="autoinsert" value="1" />
						<input name="system_list_from" type="hidden" id="system_list_from" value="<? echo $inter_trans["to_system"] ?>" />
						<input name="from_account" type="hidden" id="from_account" value="<? echo $inter_trans["to_account"] ?>" />
						<input name="amount" type="hidden" id="amount" value="<? echo $inter_trans["amount"] ?>" />
						<input name="system_list_to" type="hidden" id="system_list_to" value="<? echo $inter_trans["from_system"] ?>" />
						<input type="hidden" name="to_account" id="to_account" value="<? echo $inter_trans["from_account"] ?>" />
						<input name="hidden_note" type="hidden" id="hidden_note" value="<? echo $inter_trans["note"]. " Untransfer " . $inter_trans["id"] ?>" />
					</form>
					<br /><a href="javascript:;" class="normal_link" onclick="if(confirm('Are you sure you want to untransfer this Pak?')){untransfer('<? echo $tran->vars["id"] ?>');}">Untransfer</a>
                </div>
                <?
			}else if($tran->vars["expensed"]){
				echo "Expensed";
			} ?>
            
        	
        
        
        <? } ?>
        
        
        
        
        
    <? }else{echo "Payout to <strong>". $reserved_player["player"]."</strong>" ;}?>
    </td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center">
		<a href="process/actions/change_mp_authorized.php?id=<? echo $tran->vars["id"] ?>" class="normal_link">
			<? 
			if(!$tran->vars["authorized"]){
				echo "Blocked";
			}else{
				echo "Allowed";
			} 
			?>
        </a>
    </td>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center">
		<a href="process/actions/change_mp_safe.php?id=<? echo $tran->vars["id"] ?>&safe=<? echo $_GET["safe"] ?>" class="normal_link">
			<? 
			if($_GET["safe"]){
				echo "Set as No Safe";
			}else{
				echo "Set as Safe";
			} 
			?>
        </a>
    </td>
    <? if($current_clerk->im_allow("view_mp_numbers")){ ?>
    <td class="table_td<? echo $extra_stl.$style ?>" align="center">
     <? if ($tran->vars["image_receipt"] != "no_image" && $tran->vars["image_receipt"] != "pending" && $tran->vars["image_receipt"] != "" ){	 ?>
        <a href="moneypak_redir.php?id=<? echo $tran->vars["id"] ?>" class="normal_link" target="_blank">
			View Image
        </a>   
     <? } ?>
    </td>
    <? } ?>
  </tr>
  <? }//reserved ?>
  <? } ?>
   <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"><? echo $total ?></td>
    <td class="table_header" align="center"><? echo $total_fees ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td width="150" align="center" class="table_header"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center" title="Comments"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
     <? if($current_clerk->im_allow("view_mp_numbers")){ ?>
     <td class="table_header" align="center"></td>
     <? } ?> 
  </tr>
  </tbody>
</table>
<script type="text/javascript">
function untransfer(id){
	document.getElementById("unfrm_"+id).submit();
	unarchiveid(id);
	document.getElementById("untr_"+id).style.display = "none";
}
function change_mp_status(id, value){
	var back_msg = document.getElementById("back_msg_"+id).value;
	if(back_msg != ""){
		var conf = confirm("Are you sure you want to deny this transaction?");
		if(conf){
			var revpay = "";
			conf2 = confirm("Do you want to rever any Payout that use this MP?");
			if(conf2){revpay = "1";}else{revpay = "0";}
			
			
			document.getElementById('changer').src = 'process/actions/change_mp_status.php?id='+id+'&st='+value+'&bmsg='+back_msg+'&rp='+revpay;
			document.getElementById("status_div_"+id).innerHTML = '<span style="color:#C00">Rejected</span><br />'+back_msg;
			document.getElementById("tr_"+id).style.display = "none";	
		}
	}else{alert("You need to write a reason to deny");}
}
function show_type(type, id){
	document.getElementById("e_"+id).style.display = "none";
	document.getElementById("t_"+id).style.display = "none";
	if(type != ""){
		document.getElementById(type+"_"+id).style.display = "block";	
	}
}
function archiveid(id){
		document.getElementById('changer').src = 'process/actions/archive_mp.php?id='+id;
		document.getElementById("tr_"+id).style.display = "none";
		alert("Transaction has been processed");
}
function unarchiveid(id){
		document.getElementById('changer').src = 'process/actions/unarchive_mp.php?id='+id;
		alert("Transaction has been processed");
}

function send_intersystem(id){
	document.getElementById("frm_"+id).submit();
	//document.getElementById("prs_td_"+id).innerHTML = "Transaction Inserted";
	archiveid(id);
}
function chenge_confirmed(id, current){
	var box = document.getElementById("confirmed_"+id);
	if(current){
		box.innerHTML = '<a href="javascript:;" onclick="chenge_confirmed('+id+',0)" class="normal_link">False</a>';
		var con = "0";
	}else{
		box.innerHTML = '<a href="javascript:;" onclick="chenge_confirmed('+id+',1)" class="normal_link">True</a>';
		var con = "1";
	}
	document.getElementById("updater").src = "process/actions/change_mp_confirmed.php?id="+id+"&con="+con;
}
</script>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>