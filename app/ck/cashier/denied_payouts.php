<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_deposits")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/sortables.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
	Shadowbox.init();
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
<script type="text/javascript" src="../../process/js/functions.js?v=2"></script>
<title>Denied Payouts</title>
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">
	Denied Payouts
</span>
<p><? include("payouts_menu.php"); ?></p>
<br /><br />

<?
if($_GET["l7"]){
	$from = date("Y-m-d",strtotime(date("Y-m-d")."-7 days"));
	$to = date("Y-m-d");
	?><p><a href="denied_payouts.php" class="normal_link">Today</a></p><?
}else{
	$from = date("Y-m-d");
	$to = date("Y-m-d");
	?><p><a href="denied_payouts.php?l7=1" class="normal_link">Last 7 days</a></p><?
}
?>

<? echo file_get_contents("http://cashier.vrbmarketing.com/admin/payout_report.php?c=2002&p=PRXniq92iewoie2112ias&nosearch=1&pfrom=$from&pto=$to&status=fa&approved=NULL&confirmed=NULL&inserted=NULL&account=&send=Submit&static=1&show_reasons=1&".$_SERVER['QUERY_STRING']); ?>



</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>