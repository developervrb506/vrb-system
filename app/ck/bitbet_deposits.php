<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("bitbet_deposits")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Bitbet Deposits</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
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
</head>
<body>
<? include "../includes/header.php"  ?>
<? include "../includes/menu_ck.php"  ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Bitbet Deposits</span><br /><br />

<? include "includes/print_error.php" ?>
<? 

$from = $_POST["from"];
$to = $_POST["to"];
if($from == ""){$from = date("Y-m-d");}
if($to == ""){$to = date("Y-m-d");}

$transactions = get_bitbetdeposits($from, $to);

?>
<div align="right">
<?
$pbj_wll = file_get_contents("http://www.playblackjack.com/utilities/ui/city/bitcoin/check.php");
$orig_wll = file_get_contents("http://jobs.inspin.com/btc_wll.php");
if($pbj_wll == $orig_wll){
	$text = "Cashier pointing to correct Wallet";
	$color = "#0C3";
}else{
	$text = "Cashier pointing to WRONG Wallet!!!!";
	$color = "#F00";
}
?>
<strong style="color:<? echo $color ?>">
<? echo $text ?><br />
<? echo $orig_wll; ?>
</strong>
</div>

<form method="post">
    &nbsp;&nbsp;&nbsp;&nbsp
    from: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    
    <input type="submit" value="Search" />

</form>

<br /><br />
<? if (count($transactions) > 0) { ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header">Player</td>
    <td class="table_header">Amount</td>  
    <td class="table_header" align="center">Date</td>
  </tr>  

<? foreach($transactions as $trans){
    if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
    ?>
    <tr>
        <td class="table_td<? echo $style ?>" align="center">
			<? echo $trans->vars["id"]; ?>
        </td>   
        <td class="table_td<? echo $style ?>">
			<? echo $trans->vars["player"]; ?>
        </td>   
        <td class="table_td<? echo $style ?>">
			<? echo $trans->vars["btc_amount"]; ?>
        </td>    
        <td class="table_td<? echo $style ?>" align="center">
			<? echo $trans->vars["tdate"]; ?>
        </td>        
        
   </tr>
  <? }?> 
    <tr>
      <td class="table_last" colspan="100"></td>
    </tr>
</table>

<? } else { echo "No deposits in this dates"; }  ?>
</div>
</body>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>