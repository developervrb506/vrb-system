<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<?
$from = $_POST["from"];
if($from == ""){$from = date("Y-m-d");}
$to = $_POST["to"];
if($to == ""){$to = date("Y-m-d");}
$acc = $_POST["acc"];
if($acc == ""){$acc = $_GET["acc"];}
$charlist = "\n\r\0\x0B";
$report_line = "Id \t Account \t Phone_Count \t Phone_Price \t Phone_Total \t Internet_Count \t Internet_Price \t Internet_Total \t Liveplus_Count \t Liveplus_Price \t Liveplus_Total \t Livecasino_Count \t Livecasino_Price \t Livecasino_Total \t Base_Count \t Max_Players \t Base_Price \t  Base_Total \t Total \t Date \t \n";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>PPH Billing Report</title>
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
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">PPH Billing</span><br /><br />
<? 
$accounts = get_all_pph_accounts(); 
/*$acc_list = array();

foreach($accounts as $accx){
	if(!contains_ck($accx->vars["name"],"COMMISSION2") && !contains_ck($accx->vars["name"],"COMMISSION") && !contains_ck($accx->vars["name"],"REVERT")){
		$acc_list[] = $accx->vars["name"];
	}
}

echo implode(",",$acc_list);*/

?>
<form method="post">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
Account: <? create_objects_list("acc", "acc", $accounts, "id", "name", "All", $acc); ?>
&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search" />
</form>
<div align="right">
	<a href="javascript:;" onclick="document.getElementById('xml_form').submit();" class="normal_link">
	Export
	</a>
  </div>
    
<br /><br />
<? include "includes/print_error.php" ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">id</td>
    <td class="table_header" align="center">account</td>
    <td class="table_header" align="center">phone<br />count</td>
    <td class="table_header" align="center">phone<br />price</td>
    <td class="table_header" align="center">phone<br />total</td>
    <td class="table_header" align="center">internet<br />count</td>
    <td class="table_header" align="center">internet<br />price</td>
    <td class="table_header" align="center">internet<br />total</td>
    
    <td class="table_header" align="center">Live+<br />count</td>
    <td class="table_header" align="center">Live+<br />price</td>
    <td class="table_header" align="center">Live+<br />total</td>
    
    <td class="table_header" align="center">Horses+<br />count</td>
    <td class="table_header" align="center">Horses+<br />price</td>
    <td class="table_header" align="center">Horses+<br />total</td>
    
    <td class="table_header" align="center">Props+<br />count</td>
    <td class="table_header" align="center">Props+<br />price</td>
    <td class="table_header" align="center">Props+<br />total</td>
    
    
    
    <td class="table_header" align="center">base<br />count</td>
    <td class="table_header" align="center">max<br />players</td>
    <td class="table_header" align="center">base<br />price</td>
    <td class="table_header" align="center">base<br />total</td>
    <td class="table_header" align="center">Total</td>
    <td class="table_header" align="center">Date</td>
  </tr>
  <?
  $i=0;
  $tt = 0;
   $trans = search_pph_bill_special($from,$to,$acc);
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  
    $phone_price = number_format($tran->vars["phone_price"],2);
     $phone_total =  number_format($tran->get_phone_total(),2);
	  $internet_price = number_format($tran->vars["internet_price"],2);
	  $internet_total = number_format($tran->get_internet_total(),2);
	  
	  $liveplus_price = number_format($tran->vars["liveplus_price"],2);
	  $liveplus_total = number_format($tran->get_liveplus_total(),2);
	  
	  $horsesplus_price = number_format($tran->vars["horsesplus_price"],2);
	  $horsesplus_total = number_format($tran->get_horsesplus_total(),2);
	  
	  $propsplus_price = number_format($tran->vars["propsplus_price"],2);
	  $propsplus_total = number_format($tran->get_propsplus_total(),2);
	  
	  $base_price = number_format($tran->vars["base_price"],2);
	  $base_total = number_format($tran->get_base_total(),2);
	  $total = number_format($tran->vars["total"],2);
  
  
  
  
  ?>
  <tr title="<? echo $tran->vars["note"]; ?>">
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["account"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["phone_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $phone_price; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $phone_total; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["internet_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $internet_price; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $internet_total; ?></td>
    
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["liveplus_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $liveplus_price; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $liveplus_total; ?></td>
    
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["horsesplus_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $horsesplus_price; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $horsesplus_total; ?></td>
    
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["propsplus_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $propsplus_price; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $propsplus_total; ?></td>
    
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["base_count"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["max_players"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $base_price; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $base_total; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $total; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["mdate"]; ?></td>
  </td>
  
  <? 
  $tt += $total;
  $line =  $tran->vars["id"]." \t ".$tran->vars["account"]->vars["name"]." \t ".$tran->vars["phone_count"]." \t  ".$phone_price." \t ".$phone_total." \t ".$tran->vars["internet_count"]." \t ".$internet_price." \t  ".$internet_total." \t ".$tran->vars["liveplus_count"]." \t ".$liveplus_price." \t  ".$liveplus_total." \t ".$tran->vars["livecasino_count"]." \t ".$livecasino_price." \t  ".$livecasino_total."  \t  ".$tran->vars["base_count"]."  \t  ".$tran->vars["max_players"]."  \t  ".$base_price."  \t  ".$base_total."  \t  ".$total."  \t  ".$tran->vars["mdate"]." \t   ";		
  
 $line = str_replace(str_split($charlist), ' ', $line);
 $report_line .= $line."\n ";
  
  ?>
  
  
  <? } ?>
  <tr>
    <td class="table_last" style="text-align-last: end;" colspan="100">TOTAL : $<?echo $tt?></td>
  </tr>

</table>



<form method="post" action="./process/actions/excel.php" id="xml_form">
<input name="name" type="hidden" id="name" value="PPH_Bill_Report">
<input name="content" type="hidden" id="content" value="<? echo $report_line ?>">
</form>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>