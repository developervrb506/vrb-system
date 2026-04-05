<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("prepaid_transactions")){ ?>
<?

$all_methods = "91,101,95,94,131,138,140,148,149,150,151";

if($current_clerk->vars["id"] == "54"){$current_clerk->vars["super_admin"] = 1;}
$from = post_get("from");
$to = post_get("to",date("Y-m-d"));
$status = post_get("status_list","pe");
if(!$current_clerk->vars["super_admin"]){
	$clerk = $current_clerk->vars["id"];
	$john_clerks = array(60,105);
	if(in_array($clerk,$john_clerks)){$clerk = 59;}
}else{
	$clerk = post_get("prs");
}
$method = post_get("methods_list_search");
$charlist = "\n\r\0\x0B";
$report_line = "";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Prepaid Transactions</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>

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
</script>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Transactions</span>
<br /><br />
<div align="right">
<a href="get_durango_name.php" class="normal_link" rel="shadowbox;height=480;width=405">Get Durango Name</a>

&nbsp;&nbsp;|&nbsp;&nbsp;

<a href="get_skincare_name.php" class="normal_link" rel="shadowbox;height=690;width=405">Get Skincare Name</a>
</div>
<br />
<form method="post">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
Status: <? $current_status = $status; $all_option = true; include("includes/pt_transaction_status_list.php") ?>

<? if($current_clerk->vars["super_admin"]){ ?>
&nbsp;&nbsp;&nbsp;
Processor: 
<select name="prs" id="prs">
  <option value="">All</option>
  <? foreach(get_all_prepaid_processors() as $prs){ ?>
  	<option value="<? echo $prs->vars["clerk"] ?>" <? if($prs->vars["clerk"] == $clerk){echo 'selected="selected"';} ?>><? echo $prs->vars["name"] ?></option>
  <? } ?>
</select>
<? } ?>
<br /><br />
Method: 
<? 
echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/print_payment_methods.php?filter=$all_methods&en=_search&ao=1&cm=$method"); 
?>

&nbsp;&nbsp;&nbsp;
<input name='search' type="submit" value="Search" />
</form>
<div align="right">
	<a href="javascript:;" onclick="document.getElementById('xml_form_1').submit();" class="normal_link">
	Export
	</a>
</div>

<? 
if (isset($_POST["search"])){

if($current_clerk->vars["super_admin"]){ 
    $columns = "Id \t Player \t PT \t Processor \t Amount \t Fees \t Card \t Number \t Exp \t Cvv \t Date \t Status \t  \n";
}
else {
    $columns = "Id \t Player \t PT \t Amount \t Fees \t Card \t Number \t Exp \t Cvv \t Date \t Status \t  \n";
}

$trans = search_my_prepaid_transfers($from, $to, $status, $clerk); ?>
<br /><br />
<? include "includes/print_error.php" ?>
<iframe src="" scrolling="no" frameborder="0" width="0" height="0" id="changer"></iframe>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Player</td>
    <td class="table_header" align="center" title="Total Prepaids of Player">PT</td>
    <? if($current_clerk->vars["super_admin"]){ ?>
    <td class="table_header" align="center">Processor</td>
    <? } ?>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Card</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Move</td>
  </tr>
  <?
   $i=0; 
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
	   if($method == "" || $method == $tran->vars["payment_method"]){
  ?>
  <tr title="<? echo $tran->vars["comments"]; ?>" style="color:<? echo $tran->get_color() ?>; <? if($tran->vars["processor_status"] != "pe"){echo 'font-weight:bold;';} ?>" id="tr_<? echo $tran->vars["id"]; ?>">
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["player"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["player_total"]; ?></td>
    <? if($current_clerk->vars["super_admin"]){ ?>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["processor"]->vars["name"]; ?></td>
    <? } ?>
    <td class="table_td<? echo $style ?>" align="center">
    	<div id="amount_div_<? echo $tran->vars["id"] ?>">
            <div id="amount_txt_<? echo $tran->vars["id"] ?>">
                $<? echo $tran->vars["amount"]; ?>
                <br />
                Fees: $<? echo $tran->vars["fees"]; ?>                       
            </div>
        <? if($tran->vars["processor_status"] != "de"){ ?> 
        <br />
        <a href="javascript:;" class="normal_link" onclick="open_amount_edit('<? echo $tran->vars["id"] ?>')">Edit</a>
        <? } ?>
        </div>
        
        <div id="edit_amount_div_<? echo $tran->vars["id"] ?>" style="display:none;">
        $<input type="text" id="new_amount_<? echo $tran->vars["id"] ?>" value="<? echo $tran->vars["amount"];?>" size="4" />
        <br />
        Fees: $<input type="text" id="new_fee_<? echo $tran->vars["id"] ?>" value="<? echo $tran->vars["fees"]; ?>" size="4" />
        <br />
        <input type="button" value="Cancel"onclick="close_amount_edit('<? echo $tran->vars["id"] ?>')" />  
        <input type="button" value="Submit" onclick="change_prepaid_amount('<? echo $tran->vars["id"] ?>')" />
        </div>
        
        
    </td>
    <td class="table_td<? echo $style ?>" align="center">
		<? echo $tran->vars["card_type"]; ?><br />
		Number: <? echo $tran->vars["card_number"]; ?><br />
		Exp: <? echo $tran->vars["expiration"]; ?><br />
        CVV: <? echo $tran->vars["cvv"]; ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
		<div id="status_div_<? echo $tran->vars["id"] ?>">
        <? if($tran->vars["processor_status"] != "de"){ ?>
        	<textarea name="back_msg_<? echo $tran->vars["id"] ?>" cols="10" rows="" id="back_msg_<? echo $tran->vars["id"] ?>"><? echo $tran->vars["processor_back_message"] ?></textarea><br />
			<? 
            $current_status = $tran->vars["processor_status"];
            $all_option = false; 
            $status_change_code = "change_prepaid_status('".$tran->vars["id"]."',this.value);";
            $status_extra = "_".$tran->vars["id"];
            include("includes/pt_transaction_status_list.php") 
            ?>
        <? }else{echo "DENIED"; echo "<br />"; echo $tran->vars["processor_back_message"];} ?>
        </div>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
    	<div id="move_div_<? echo $tran->vars["id"] ?>">
        <? if($tran->vars["processor_status"] != "de"){ ?>
			<? if(!is_null($tran->vars["payment_method"])){ ?>
            <? 
            $mfilter = str_replace($tran->vars["payment_method"],"",$all_methods);
            echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/print_payment_methods.php?filter=$mfilter&en=_".$tran->vars["id"]); 	
            ?>
            <br />
            <input name="" type="button" value="Move" onclick="move_prepaids('<? echo $tran->vars["id"] ?>');" />
            <? } ?>
        <? } ?>
        </div>
    </td>
  </td>
  	
	 <? 
   
    if($current_clerk->vars["super_admin"]){  
    $line = $tran->vars["id"]." \t ".$tran->vars["player"]." \t ".$tran->vars["player_total"]." \t  ".$tran->vars["processor"]->vars["name"]." \t ".$tran->vars["amount"]." \t ".$tran->vars["fees"]." \t ".$tran->vars["card_type"]." \t -".$tran->vars["card_number"]."- \t ".$tran->vars["expiration"]." \t ".$tran->vars["cvv"]." \t ".$tran->vars["tdate"]." \t  ".$tran->vars["processor_status"]." \t  ";		
	}
	else {
    $line = $tran->vars["id"]." \t ".$tran->vars["player"]." \t ".$tran->vars["player_total"]." \t ".$tran->vars["amount"]." \t ".$tran->vars["fees"]." \t ".$tran->vars["card_type"]." \t -".$tran->vars["card_number"]."- \t ".$tran->vars["expiration"]." \t ".$tran->vars["cvv"]." \t ".$tran->vars["tdate"]." \t  ".$tran->vars["processor_status"]." \t  ";		
		
	}
    $line = str_replace(str_split($charlist), ' ', $line);
    $report_line .= $line."\n ";
    ?>
	
	
	<? } ?>
   
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
<? } ?>


<script type="text/javascript">
function close_amount_edit(id){
	document.getElementById("edit_amount_div_"+id).style.display = "none";
	document.getElementById("amount_div_"+id).style.display = "block";	
}
function open_amount_edit(id){
	document.getElementById("edit_amount_div_"+id).style.display = "block";
	document.getElementById("amount_div_"+id).style.display = "none";	
}
function change_prepaid_amount(id){
	var namount = document.getElementById("new_amount_"+id).value;
	var nfees = document.getElementById("new_fee_"+id).value;
	document.getElementById('changer').src = 'process/actions/change_pt_amount.php?id='+id+'&amount='+namount+'&fees='+nfees;
	document.getElementById("amount_div_"+id).style.display = "block";	
	document.getElementById("amount_txt_"+id).innerHTML = "$"+namount+"<br />Fees: $"+nfees;
	document.getElementById("edit_amount_div_"+id).style.display = "none";
}
function change_prepaid_status(id, value){	
	var types = new Array();
	types['ac'] = "Accepted";
	types['de'] = "Denied";
	types['pe'] = "Pending";
	if(confirm("Are su sure you want to change the status to "+types[value]+"?")){
		var back_msg = document.getElementById("back_msg_"+id).value;
		document.getElementById('changer').src = 'process/actions/change_pt_status.php?id='+id+'&st='+value+'&bmsg='+back_msg;
		switch(value){
		case "de":
		  color = "#770808";
		  font = "bold";
		  document.getElementById("status_div_"+id).innerHTML = "DENIED<br />"+back_msg;
		  document.getElementById("move_div_"+id).style.display = 'none';
		  break;
		case "ac":
		  color = "#1c4f06";
		  font = "bold";
		  break;
		default:
		  color = "#000";
		  font = "normal";
		}
		document.getElementById("tr_"+id).style.fontWeight = font;
		document.getElementById("tr_"+id).style.color = color;
	}
}
function move_prepaids(id){
	var new_processor = document.getElementById("methods_list_"+id).value;
	if(confirm("Are you sure you want to move this Transaction to the Selected Processor?")){
		document.getElementById('changer').src = 'process/actions/cancel_pt.php?id='+id+"&nprs="+new_processor;
		document.getElementById("tr_"+id).style.display = "none";
	}
}
</script>

<form method="post" action="prepaid_transactions_export.php" id="xml_form_1">
<input name="columns" type="hidden" id="columns" value="<? echo $columns ?>">
<input name="lines" type="hidden" id="lines" value="<? echo $report_line ?>">
</form>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>