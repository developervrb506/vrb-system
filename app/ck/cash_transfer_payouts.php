<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("process_payouts")){ ?>
<?
$from = post_get("from");
$to = post_get("to",date("Y-m-d"));
$status = "pe";
$fees["wu"] = get_sbo_payouts_fees_by_processor("wu");
$fees["mg"] = get_sbo_payouts_fees_by_processor("mg");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Cash Transfer Payouts</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="../process/js/functions.js?v=2"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Cash Transfer Payouts</span>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="cash_transfer_payouts.php" class="normal_link">Refresh</a>
<? 
$trans = search_cash_transfer_payouts_for_process($from, $to);
$players = "";
foreach($trans as $ptr){
	$players .= ",'".str_replace(" ","",$ptr->vars["sender_account"])."'";
}
$players = substr($players,1);
$nets = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/players_net_winloss.php?accs=".str_replace("'","",$players)));
$balances = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/players_balances.php?accs=".str_replace("'","",$players)));
$last_deps = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/players_last_deposits.php?accs=".str_replace("'","",$players)));

$types = array("1"=>"WU","2"=>"MG");
?>
<br /><br />
<? include "includes/print_error.php" ?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Player</td>
    <td class="table_header" align="center">Win/Loss</td>
    <td class="table_header" align="center">balance</td>
    <td class="table_header" align="center">Last Dep.</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Fees</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">Type</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center" title="Comments">Com.</td>
    <td class="table_header" align="center">Complete</td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
   $i=0; 
   $total = 0;
   $total_fee = 0;
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
	   $total += $tran->vars["amount"];
   	   $total_fee += $tran->vars["fees"];
  ?>  

  <tr>
    <td class="table_td<? echo $style ?>" align="center">
    	<?
		if($tran->vars["status"] == "ape"){
			$short = $types[$tran->vars["method"]];
		}else{
			$processor = get_cash_transfer_processor($tran->vars["method"]);
			$short = $types[$processor->vars["group"]];
		}
		?>
    	<?
		$data["tid"] = $tran->vars["id"];
		$data["account"] = $tran->vars["sender_account"];
		$data["method"] = $short;
		$data["amount"] = $tran->vars["amount"];
		$data["fees"] = $tran->get_fee($fees[strtolower($short)]);
		$key = two_way_enc(implode("_*_",$data));
		if(contains_ck(strtoupper($tran->vars["sender_account"]),"AF")){
			$url = "dgs_payout_affiliate.php";
		}else{
			$url = "dgs_payout.php";
		}
		?>
        
        <? if(!$tran->vars["cmarked"]){ ?>
            <a href="<?= BASE_URL ?>/ck/<? echo $url ?>?mts=<? echo $key ?>&free=<? if(contains_ck($tran->vars["aps_comment"],"(--FREE--)")){echo "1";}else{echo "0";}  ?>" class="normal_link" rel="shadowbox;height=370;width=600">
            <img id="umki_<?  $tran->vars["id"] ?>" src="https://www.ezpay.com/images/icons/important_vrb.png" width="20" height="20" alt="/" title="Insert Payout">
            </a>
            <img id="mki_<? echo $tran->vars["id"] ?>" src="https://www.ezpay.com/images/icons/complete_vrb.png" width="20" height="20" alt="/" title="Paid" style="display:none;">
        <? }else{ ?>
        	<img src="https://www.ezpay.com/images/icons/complete_vrb.png" width="20" height="20">
        <? } ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["sender_account"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$
		<? if($tran->vars["sender_account"] != ""){@eval("echo \$nets->".str_replace(" ","",$tran->vars["sender_account"])."->net;");} ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center">$
		<? if($tran->vars["sender_account"] != ""){@eval("echo \$balances->".str_replace(" ","",$tran->vars["sender_account"])."->amount;");} ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
		<? if($tran->vars["sender_account"] != ""){@eval("echo \$last_deps->".str_replace(" ","",$tran->vars["sender_account"])."->vars->Description;");} ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo $tran->vars["amount"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo $tran->vars["fees"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->str_status(); ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<? echo $short ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["date"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo nl2br($tran->vars["description"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">    	
       <?
	   if($tran->vars["status"] == "ape"){
		   ?> 
           <p>
           <a href="https://www.ezpay.com/wu/send_admin.php?t=<? echo $tran->vars["id"] ?>" target="_blank" class="normal_link">
           	EZPay
           </a>
           </p>
           <p>
           <a href="cash_transfer_payout_bitcoin.php?tid=<? echo $tran->vars["id"] ?>" class="normal_link">
           	Bitcoin
           </a>
           </p>
		   <?
	   }else{
		   echo $processor->vars["name"];
	   }
	   ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
    	<form method="post" action="process/actions/deny_cash_transfer_payout.php" onsubmit="return confirm('Are you sure you want to Deny this Payout?')">
        <input name="id" type="hidden" value="<? echo $tran->vars["id"]; ?>" />
        <textarea name="bmsg" cols="10"></textarea><br />
    	<input name="Enviar" type="submit" value="Deny"  />
        </form>
    </td>
  </tr>
  <? } ?>
   <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">$<? echo $total ?></td>
    <td class="table_header" align="center">$<? echo $total_fee ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
     <td class="table_header" align="center"></td>
  </tr>

</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>