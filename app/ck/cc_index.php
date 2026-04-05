<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cc_system")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Credit Card</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? //$page_style = " width:100%;"; ?>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Credit Cards Reports</span>
<br /><br />

<? if($current_clerk->im_allow("creditcard_deny_report")){ ?>
<a href="cashier/cc_deny_report.php" class="normal_link">CreditCard Deny report</a><br />
Show all Credit Cards Denied and check deposits
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("first_creditcard_deposit")){ ?>
<a href="cashier/first_creditcard_deposit.php" class="normal_link">First Creditcard Deposit</a><br />
Displays the Player Fisrt Credicard Deposit 
<br /><br />
<? } ?>

 <? if($current_clerk->im_allow("creditcard_processor_balance")){ ?>
<a href="creditcard_procesor_balance.php" class="normal_link">Credit Card Levels Report</a><br />
Displays the balance for Creditcard's Processors.
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("creditcard_players")){ ?>
<a href="creditcard_players.php" class="normal_link">SBO Credit Card Players Information</a><br />
Manage the Credit Card information of players.
<br /><br />
<? } ?>

<a href="cashier/cc_processors.php" class="normal_link">Credit Card Processors</a><br />
Manage CC processors by brand.
<br /><br />

<a href="cashier/cc_descriptor.php" class="normal_link">Descriptor Report</a><br />
Show all Credit Cards Transactions by Date
<br /><br />

<a href="cashier/cc_chargeback.php" class="normal_link">Chargeback Report</a><br />
Show and Create Credit Card chargebacks
<br /><br />




</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>