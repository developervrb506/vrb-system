<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_admin")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Deposits</title>
</head>
<body>
<? //$page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Deposits</span>
<br /><br />


<? if($current_clerk->im_allow("cashier_deposits")){ ?>
<p>
<strong><a href="manual_pak.php" rel="shadowbox;height=320;width=600" class="normal_link">Manual Pak</a></strong><br />
Insert a manual pak
</p>
<p>
<strong><a href="manual_prepaid.php" rel="shadowbox;height=400;width=600" class="normal_link">Manual Prepaid Card</a></strong><br />
Insert a manual Prepaid Card
</p>
<p>
<strong><a href="search_pak.php" class="normal_link">Pak History</a></strong><br />
Search pak history
</p>
<p>
<strong><a href="processed_deposits.php" class="normal_link">Proccessed Deposits</a></strong><br />
View processed deposits destination.
</p>
<p>
<? } ?>
<? if($current_clerk->im_allow("cashier_deposits") || $current_clerk->im_allow("cashier_simple_deposit_report")){ ?>
<strong><a href="deposits.php" class="normal_link">Deposits</a></strong><br />
List of all Deposits
</p>
<? } ?>
<? if($current_clerk->im_allow("cashier_deposits")){ ?>
<p>
<strong><a href="pre_deposits.php" class="normal_link">Pre Confirmed Deposits</a></strong><br />
List of all Deposits ready to be processed
</p>
<? if($current_clerk->vars['id'] == 1 ){ // Mike request on 05-12-19 Only he can see this . AAP ?>
<p>
<strong><a href="post_deposits.php" class="normal_link">Post Confirmed Deposits</a></strong><br />
List of all Deposits that have been processed
</p>
<? } ?>
<p>
<strong><a href="denied_deposits.php" class="normal_link">Denied Deposits</a></strong><br />
List of all Deposits that have been denied
</p>



<? } ?>

<? if($current_clerk->im_allow("cahier_pending_deposits")){ ?>
<p>
<strong><a href="pending_deposits.php" class="normal_link">Confirmed Deposits</a></strong><br />
List of all confirmed Deposits ready to be inserted in DGS
</p>
<? } ?>

<? if($current_clerk->im_allow("denied_deposit_report")){ ?>
<p>
<strong><a href="denied_report.php" class="normal_link">Unconfirmed Denied Deposits</a></strong><br />
List of all unconfirmed deposits.
</p>
<? } ?>


</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>