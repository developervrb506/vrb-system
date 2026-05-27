<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("prepaid_balance")){ 
ini_set('memory_limit','-1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
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
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Prepaid Cards Balance</title>
</head>
<body>
<?php header('Access-Control-Allow-Origin: *'); ?>
<? //$page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<?
 if(param("type") == "new"){
  $tittle = "Pending";	
  $new = 1; 
 }else{
   $tittle = "Update";	 
   $new = 0;
 }

  $tp = param('tp');
  if($tp == ""){ $tp = 'new';}

  $from = param('from',false);
  if($from == ""){ $from = '2019-01-01';}

  $to = param('to',false);
  if($to == ""){ $to = '2019-03-01';}

?>

<span class="page_title"><? echo $tittle; ?> Prepaid Cards Balance</span>
&nbsp;&nbsp;&nbsp;&nbsp;
<? if($new) { ?>
	<a href="prepaid_cards_balance2.php?u=<? echo $current_clerk->vars['id']?>&type=old" class="normal_link"><strong>View Cards with Balance</strong></a></strong><br />
<? } else {?>
	<a href="prepaid_cards_balance2.php?u=<? echo $current_clerk->vars['id']?>&type=new" class="normal_link"><strong>Pending Cards Balance</strong></a></strong><br />
<? } ?>
<BR><BR>
<form action="" method="get">
	<input type="hidden" name="type" value="<? echo param("type"); ?>">
	<strong> TYPE: &nbsp;&nbsp;</strong> 
	<select id="tp" name="tp">
		<option <? if ($tp == '3') { echo ' selected="selected" '; } ?>  value="3">ALL</option>
		<option <? if ($tp == '0') { echo ' selected="selected" '; } ?>value="0">Preconfirmed</option>
		<option <? if ($tp == '4') { echo ' selected="selected" '; } ?>value="4">PostConfirmed</option>
		<option <? if ($tp == '5') { echo ' selected="selected" '; } ?>value="5">Used</option>
		<option <? if ($tp == '1') { echo ' selected="selected" '; } ?>value="1">Moved</option>        
		<option <? if ($tp == '6') { echo ' selected="selected" '; } ?>value="6">No Account</option>
		<? /* <option <? if ($tp == 'pay') { echo ' selected="selected" '; } ?>value="pay">Payouts</option> */?>
	</select>
	&nbsp;&nbsp;

	From: <input name="from" type="text" id="from" value="<? echo $from ?>" />

	&nbsp;&nbsp;

	To: <input name="to" type="text" id="to" value="<? echo $to ?>" />


	<input type="submit" value="GO">
</form>




<br /><br />
<? /*
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="normal_link" href="https://www.vanillagift.com/es" target="_blank" >VISA #1</a>
&nbsp;&nbsp;&nbsp; <a class="normal_link" href="https://www.vanillavisa.com/home.html?product=giftcard&csrfToken=" target="_blank" >VISA #2</a>
&nbsp;&nbsp;&nbsp; <a class="normal_link" href="http://www.vanillamastercard.com/home.html?locale=en_US&product=giftcard&csrfToken=" target="_blank" >MASTERCARD</a> */ ?>
<?/*
&nbsp;&nbsp;&nbsp;<label style="background:red">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> = Cards used in Payouts.<BR>
<? if ($tp == 'new') { ?>

&nbsp;&nbsp;&nbsp;<label style="background:yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> = Cards used in Preconfirmed.<BR>
&nbsp;&nbsp;&nbsp;<label style="background:green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> = Cards used in Post Confirmed.<BR>
<? } ?>
*/
?>
<? if(!$new){ ?>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>Note:</strong><span style="color:red"> If a Card is used,Update the balance in $0  </span>
<? } ?>
<br /><br />
<script>
	function check_data(id,B,A,main){
       var A = (A-5);
       var B = (B-6);
       if(A < 10) { A = "0"+A;}
       if(B < 10) { B = "0"+B;}
       var value = main+A+B;
       document.getElementById("dt_"+id).value = value;
       document.getElementById("idel").src = BASE_URL . "/ck/process/actions/keeplog.php?ac=c&d="+value;
       document.getElementById("bt_"+id).style.display = 'none';
	}  

</script>

<div align="right">
	<iframe width="1" height="1" frameborder="0" scrolling="no" id="idel"></iframe>
</div>

<? if(isset($_GET['tp']) || !$new) {?>

<?  //echo "http://cashier.vrbmarketing.com/admin/prepaid_cards_balance.php?tp=".$tp."&new=".$new."&c=2002&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING'];

  echo file_get_contents("http://cashier.vrbmarketing.com/admin/prepaid_cards_balance.php?u=".$current_clerk->vars['id']."&tp=".$tp."&new=".$new."&c=2002&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING']); ?>
<? } ?>


</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>