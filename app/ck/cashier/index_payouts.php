<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_admin")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Payouts</title>
</head>
<body>
<? //$page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">Payouts</span>
<br /><br />


<? if($current_clerk->im_allow("cashier_search_payouts")){ ?>
<p>
<strong><a href="payout_report.php" class="normal_link">Payouts Search</a></strong><br />
List of all Payouts in system
</p>
<? } ?>

<? if($current_clerk->im_allow("cashier_payout_report")){ ?>
<p>
<strong><a href="pre_payouts.php" class="normal_link">Pre Confirmed Payouts</a></strong><br />
List of all Payouts that havent been arrpoved or denied
</p>
<? } ?>

<? if($current_clerk->im_allow("cashier_payout")){ ?>
<p>
<strong><a href="payouts.php" class="normal_link">Post Confirmed Payouts</a></strong><br />
List of all Payouts  ready to be processed
</p>

<p>
<strong><a href="approved_payouts.php" class="normal_link">Approved Payouts</a></strong><br />
List of all Payouts  ready to be processed
</p>

<p>
<strong><a href="show_emails.php" class="normal_link">Approved Payouts Emails</a></strong><br />
List of emails to send when a payout is approved.
</p>
<? } ?>

<? if($current_clerk->im_allow("cashier_payout_report")){ ?>
<p>
<strong><a href="denied_payouts.php" class="normal_link">Denied Payouts</a></strong><br />
List of all Payouts that have been denied
</p>

<p>
<strong><a href="completed_payouts.php" class="normal_link">Completed Payouts</a></strong><br />
List of all Payouts that have been completed
</p>
<? } ?>


</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>