<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("prepaid_balance")){ 
ini_set('memory_limit','-1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>
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

?>

<span class="page_title"><? echo $tittle; ?> Prepaid Cards Balance</span>
&nbsp;&nbsp;&nbsp;&nbsp;
<? if($new) { ?>
<a href="prepaid_cards_balance.php?type=old" class="normal_link"><strong>View Cards with Balance</strong></a></strong><br />
<? } else {?>
<a href="prepaid_cards_balance.php?type=new" class="normal_link"><strong>Pending Cards Balance</strong></a></strong><br />
<? } ?>
<BR><BR>
<form action="" method="get">
<input type="hidden" name="type" value="<? echo param("type"); ?>">
<strong> TYPE: &nbsp;&nbsp;</strong> 
<select id="tp" name="tp">
<option <? if ($tp == 'new') { echo ' selected="selected" '; } ?>  value="new">ALL</option>
<option <? if ($tp == 'pre') { echo ' selected="selected" '; } ?>value="pre">Preconfirmed</option>
<option <? if ($tp == 'post') { echo ' selected="selected" '; } ?>value="post">PostConfirmed</option>
<option <? if ($tp == 'used') { echo ' selected="selected" '; } ?>value="used">Used</option>
<option <? if ($tp == 'noacc') { echo ' selected="selected" '; } ?>value="noacc">No Account</option>



<? /* <option <? if ($tp == 'pay') { echo ' selected="selected" '; } ?>value="pay">Payouts</option> */?>

</select>
<input type="submit" value="GO">
</form>




<br /><br />
<? /*
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="normal_link" href="https://www.vanillagift.com/es" target="_blank" >VISA #1</a>
&nbsp;&nbsp;&nbsp; <a class="normal_link" href="https://www.vanillavisa.com/home.html?product=giftcard&csrfToken=" target="_blank" >VISA #2</a>
&nbsp;&nbsp;&nbsp; <a class="normal_link" href="http://www.vanillamastercard.com/home.html?locale=en_US&product=giftcard&csrfToken=" target="_blank" >MASTERCARD</a> */ ?>

&nbsp;&nbsp;&nbsp;<label style="background:red">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> = Cards used in Payouts.<BR>
<? if ($tp == 'new') { ?>

&nbsp;&nbsp;&nbsp;<label style="background:yellow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> = Cards used in Preconfirmed.<BR>
&nbsp;&nbsp;&nbsp;<label style="background:green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> = Cards used in Post Confirmed.<BR>
<? } ?>

<? if(!$new){ ?>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>Note:</strong><span style="color:red"> If a Card is used,Update the balance in $0  </span>
<? } ?>
<br /><br />
<? if(isset($_GET['tp']) || !$new) {?>

<? // echo "http://cashier.vrbmarketing.com/admin/prepaid_cards_balance.php?tp=".$tp."&new=".$new."&c=2002&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING'];

 echo file_get_contents("http://cashier.vrbmarketing.com/admin/prepaid_cards_balance.php?tp=".$tp."&new=".$new."&c=2002&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING']); ?>
<? } ?>


</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>