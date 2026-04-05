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
<title>Bank Wire Payouts</title>
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

<span class="page_title">Bank Wire Payouts</span>

<? 
$trans = get_bankwire_payouts_for_process();
?>
<br /><br />
<? include "includes/print_error.php" ?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Account</td>
    <td class="table_header" align="center">Information</td>
    <td class="table_header" align="center">Amount</td>
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
   	   $total_fee += $tran->vars["fees"];
  ?>  

  <tr>
    <td class="table_td<? echo $style ?>" align="center">
    	<?
		$data["tid"] = "BW" . $tran->vars["id"];
		$data["account"] = $tran->vars["player"];
		$data["method"] = "WIRE";
		$data["amount"] = $tran->vars["amount"];
		$data["fees"] = $tran->vars["fees"];
		$key = two_way_enc(implode("_*_",$data));
		if(contains_ck(strtoupper($tran->vars["account"]),"AF") || true){
			$url = "dgs_payout_affiliate.php";
		}else{
			$url = "dgs_payout.php";
		}
		?>
		<a href="http://localhost:8080/ck/<? echo $url ?>?mts=<? echo $key ?>&free=<? if(contains_ck($tran->vars["aps_comment"],"(--FREE--)")){echo "1";}else{echo "0";}  ?>" class="normal_link" rel="shadowbox;height=370;width=600">
		<img id="umki_<? echo "BW" . $tran->vars["id"] ?>" src="https://www.ezpay.com/images/icons/important_vrb.png" width="20" height="20" alt="/" title="Insert Payout">
		</a>
		<img id="mki_<? echo "BW" . $tran->vars["id"] ?>" src="https://www.ezpay.com/images/icons/complete_vrb.png" width="20" height="20" alt="/" title="Paid" style="display:none;">
    </td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["player"]; ?></td>
    
    <td class="table_td<? echo $style ?>" align="center">
   		<strong>First Name:</strong> <? echo $tran->vars["name"] ?><br />
        <strong>Last Name:</strong> <? echo $tran->vars["last_name"] ?><br />
        <strong>Acc #:</strong> <? echo $tran->vars["account_number"] ?><br />
        <strong> Bank:</strong> <? echo $tran->vars["bank_name"] ?><br />
        <strong>Swift:</strong> <? echo $tran->vars["swift"] ?><br />
        <strong>Address1:</strong> <? echo $tran->vars["adress1"] ?><br />
        <strong>Address2:</strong> <? echo $tran->vars["adress2"] ?><br />
        <strong>City:</strong> <? echo $tran->vars["city"] ?><br />
        <strong>State:</strong> <? echo $tran->vars["state"] ?><br />
        <strong>Zip:</strong> <? echo $tran->vars["zip"] ?><br />
        <strong>Country:</strong ><? echo $tran->vars["country"] ?>
     </td>

    <td class="table_td<? echo $style ?>" align="center">$<? echo $tran->vars["amount"]; ?></td>

    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo nl2br($tran->vars["extra_info"]); ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<form method="post" action="process/actions/deny_bankwire.php" onsubmit="return confirm('Are you sure you want to Deny this Payout?')">
        <input name="id" type="hidden" value="<? echo $tran->vars["id"]; ?>" />
        <textarea name="bmsg" cols="10"></textarea><br />
    	<input name="Enviar" type="submit" value="Deny"  />
        </form>
    </td>
  </tr>
  <? } ?>
   <tr>
    <td class="table_header" align="center" colspan="100"></td>
  </tr>

</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>