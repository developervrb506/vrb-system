<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("bitcoins_payouts")){ ?>
<?
$from = post_get("from");
$to = post_get("to",date("Y-m-d"));
$status = "pe";//post_get("status_list","pe");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Bitcoins Payouts</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Bitcoins Payouts</span>
<?php /*?><br /><br />
<form method="post">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
<? $data = array(array("id"=>"pe","label"=>"Pending"),array("id"=>"ac","label"=>"Accepted"),array("id"=>"de","label"=>"Denied")); ?>
Status: <?  create_list("status_list", "status_list", $data, $status, "", "", "All"); ?>
&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search" />
</form><?php */?>

<? 
$trans = search_bitcoins_payouts($from, $to, $status, "ac");

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
    <td class="table_header" align="center">BTCs</td>
    <td class="table_header" align="center">BTC Address</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center" title="Comments">Com.</td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
   $i=0; 
   $total = 0;
   $total_btcs = 0;
   foreach($trans as $tran){
	   $reg_address = get_security_players_answers($tran->vars["player"]."/bitaddress"); 
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
	   $total += $tran->vars["amount"];
   	   $total_btcs += $tran->vars["btc_amount"];
  ?>  

  <tr>
    <td class="table_td<? echo $style ?>" align="center">
    	<?
		$data["tid"] = "BTP" . $tran->vars["id"];
		$data["account"] = $tran->vars["player"];
		$data["method"] = "btp";
		$data["amount"] = $tran->vars["amount"];
		$data["fees"] = $tran->vars["fee"];
		$key = two_way_enc(implode("_*_",$data));
		if(contains_ck(strtoupper($tran->vars["player"]),"AF")){
			$url = "dgs_payout_affiliate.php";
		}else{
			$url = "dgs_payout.php";
		}
		?>
		<a href="<?= BASE_URL ?>/ck/<? echo $url ?>?mts=<? echo $key ?>&free=<? if(contains_ck($tran->vars["aps_comment"],"(--FREE--)")){echo "1";}else{echo "0";}  ?>" class="normal_link" rel="shadowbox;height=370;width=600">
		<img id="umki_<? echo "BTP" . $tran->vars["id"] ?>" src="https://www.ezpay.com/images/icons/important_vrb.png" width="20" height="20" alt="/" title="Insert Payout">
		</a>
		<img id="mki_<? echo "BTP" . $tran->vars["id"] ?>" src="https://www.ezpay.com/images/icons/complete_vrb.png" width="20" height="20" alt="/" title="Paid" style="display:none;">
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["player"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? @eval("echo \$nets->".$tran->vars["player"]."->net;"); ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? @eval("echo \$balances->".$tran->vars["player"]."->amount;"); ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo $tran->vars["amount"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["btc_amount"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
		<? echo $tran->vars["address"]; ?><br />
        <? if($reg_address->vars["answer"] != ""){ ?>
        <p style="font-size:10px;">
			Registed Addres:<br />
			<? echo $reg_address->vars["answer"] ?>
        </p>
        <? } ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo nl2br($tran->vars["comments"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<form method="post" action="process/actions/deny_bitcoin_payout.php" onsubmit="return confirm('Are you sure you want to Deny this Payout?')">
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
    <td class="table_header" align="center"><? echo  mround($total_btcs, 3); ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>

</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>
<?
function mround($number, $precision=0) {

$precision = ($precision == 0 ? 1 : $precision);   
$pow = pow(10, $precision);

$ceil = ceil($number * $pow)/$pow;
$floor = floor($number * $pow)/$pow;

$pow = pow(10, $precision+1);

$diffCeil     = $pow*($ceil-$number);
$diffFloor     = $pow*($number-$floor)+($number < 0 ? -1 : 1);

if($diffCeil >= $diffFloor) return $floor;
else return $ceil;
}
?>