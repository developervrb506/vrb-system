<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cahier_pending_deposits")){ ?>
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
<title>Pending Deposits</title>
</head>
<body>
<? //$page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">
	Pending Deposits
    &nbsp;&nbsp;&nbsp;(
    <?
	if($_GET["l7"]){
		?> <a href="pending_deposits.php" class="normal_link">View today</a> <?
	}else{
		?> <a href="pending_deposits.php?l7=1" class="normal_link">View last 7 days</a> <?
	}
	?>
    )
</span>
<p><? include("deposits_menu.php"); ?></p>
<br /><br />

<? echo file_get_contents("http://cashier.vrbmarketing.com/admin/pending_deposits.php?c=2002&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING']); ?>



</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>