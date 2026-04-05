<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("process_payouts")){ ?>
<?
$from = post_get("from");
$to = post_get("to",date("Y-m-d"));
$status = "pe";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Prepaid Gift Card Payouts</title>
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

<span class="page_title">Paypal Payouts</span>

<? 
$trans = search_paypal_payouts($from, $to, $status, "ac");
$players = "";
foreach($trans as $ptr){
	$players .= ",'".$ptr->vars["player"]."'";
}
$players = substr($players,1);
$nets = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/players_net_winloss.php?accs=".str_replace("'","",$players)));
$balances = json_decode(@file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/players_balances.php?accs=".str_replace("'","",$players)));
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
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Fees</td>
    <td class="table_header" align="center">Address</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center" title="Comments">Com.</td>
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
   	   $total_fee += $tran->vars["fee"];
  ?>  

  <tr>
    <td class="table_td<? echo $style ?>" align="center">
    	<?
		$data["tid"] = "PPP" . $tran->vars["id"];
		$data["account"] = $tran->vars["player"];
		$data["method"] = "ppp";
		$data["amount"] = $tran->vars["amount"];
		$data["fees"] = $tran->vars["fee"];
		$key = two_way_enc(implode("_*_",$data));
		if(contains_ck(strtoupper($tran->vars["player"]),"AF")){
			$url = "dgs_payout_affiliate.php";
		}else{
			$url = "dgs_payout.php";
		}
		?>
		<a href="http://localhost:8080/ck/<? echo $url ?>?mts=<? echo $key ?>&free=<? if(contains_ck($tran->vars["aps_comment"],"(--FREE--)")){echo "1";}else{echo "0";}  ?>" class="normal_link" rel="shadowbox;height=370;width=600">
		<img id="umki_<? echo "PPP" . $tran->vars["id"] ?>" src="https://www.ezpay.com/images/icons/important_vrb.png" width="20" height="20" alt="/" title="Insert Payout">
		</a>
		<img id="mki_<? echo "PPP" . $tran->vars["id"] ?>" src="https://www.ezpay.com/images/icons/complete_vrb.png" width="20" height="20" alt="/" title="Paid" style="display:none;">
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["player"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? eval("echo \$nets->".$tran->vars["player"]."->net;"); ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? eval("echo \$balances->".$tran->vars["player"]."->amount;"); ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo $tran->vars["amount"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo $tran->vars["fee"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["address"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo nl2br($tran->vars["comments"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<form method="post" action="process/actions/deny_paypal_payout.php" onsubmit="return confirm('Are you sure you want to Deny this Payout?')">
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
  </tr>

</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>