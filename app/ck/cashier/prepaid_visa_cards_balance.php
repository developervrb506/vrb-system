<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("prepaid_balance")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Prepaid  Visa Cards Balance</title>
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


?>
<span class="page_title"><? echo $tittle; ?> Prepaid  VISA Cards Balance</span>
&nbsp;&nbsp;&nbsp;&nbsp;
<? if($new) { ?>
<a href="prepaid_visa_cards_balance.php?type=old" class="normal_link"><strong>View Cards with Balance</strong></a></strong><br />
<? } else {?>
<a href="prepaid_visa_cards_balance.php?type=new" class="normal_link"><strong>Pending Cards Balance</strong></a></strong><br />
<? } ?>



<br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="normal_link" href="https://www.vanillagift.com/es" target="_blank" >VISA #1</a>
&nbsp;&nbsp;&nbsp; <a class="normal_link" href="https://www.vanillavisa.com/home.html?product=giftcard&csrfToken=" target="_blank" >VISA #2</a>

&nbsp;&nbsp;&nbsp;<label style="background:#906">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> = Cards used in Payouts.
<? if(!$new){ ?>
&nbsp;&nbsp;&nbsp;&nbsp;<strong>Note:</strong><span style="color:red"> If a Card is used,Update the balance in $0  </span>
<? } ?>
<br /><br />

<? echo file_get_contents("http://cashier.vrbmarketing.com/admin/prepaid_visa_cards_balance.php?new=".$new."&c=2002&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING']); ?>



</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>