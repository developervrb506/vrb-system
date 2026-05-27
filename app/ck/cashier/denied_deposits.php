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
<title>Denied Deposits</title>
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">
	Denied Deposits
</span>
<p><? include("deposits_menu.php"); ?></p>
<br /><br />


<? echo file_get_contents("http://cashier.vrbmarketing.com/admin/deposits.php?c=2002&p=PRXniq92iewoie2112ias&nosearch=1&from=".date("Y-m-d")."&to=".date("Y-m-d")."&status=fa&approved=NULL&confirmed=NULL&inserted=NULL&account=&send=Submit&denied_report=1&allow_blacks=".$current_clerk->im_allow("accept_blacklist_deposit")."&".$_SERVER['QUERY_STRING']); ?>



</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>