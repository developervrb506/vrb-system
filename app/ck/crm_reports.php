<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Reports</title>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Reports</span><br /><br />

<? include "includes/print_error.php" ?>


<!--SBO-->
<? if($current_clerk->im_allow("sbo_daily_new_accounts")){ ?>
<a href="sbo_new_accounts.php" class="normal_link">Daily New Accounts</a><br />
Displays all the signups in a period of time.
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("sbo_daily_new_accounts")){ ?>
<a href="sbo_new_accounts_by_clerk.php" class="normal_link">Daily New Accounts by Clerk</a><br />
Displays all the signups by clerk.
<br /><br />
<? } ?>

 <? if($current_clerk->im_allow("sbo_search_accounts")){ ?>
 <a class="normal_link" href="http://localhost:8080/ck/sbo_search_accounts.php">Search SBO Accounts</a><br />
 Display a Search of SBO Accounts
 <br /><br />
 <? } ?>

<? if($current_clerk->im_allow("first_deposit")){ ?>
<a href="sbo_first_deposit.php" class="normal_link">First Deposits</a><br />
Displays the first deposits on a period of time.
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("all_sbo_transactions")){ ?>
<a class="normal_link" href="ezpay_all_transactions.php">All SBO Transactions</a><br />
Show all SBO transactions by method.
<br /><br />
<? } ?>

<!--Admin and Sales Manager-->
<? if($current_clerk->vars["level"]->vars["sale_manager"] || $current_clerk->im_allow("phone_admin")){ ?>
<a href="day_calls.php" class="normal_link">Calls by Day</a><br />
Displays the average of calls per hour and the number fo calls for each clerk.
<br /><br />
<? } ?>

<? if($current_clerk->vars["level"]->vars["sale_manager"] || $current_clerk->im_allow("phone_admin")  || $current_clerk->im_allow("marketing_names")){?>
<a href="calls.php" class="normal_link">Calls</a><br />
Displays options to search calls.
<br /><br />
<? }?>

<? if($current_clerk->vars["level"]->vars["sale_manager"] || $current_clerk->im_allow("phone_admin")  || $current_clerk->im_allow("marketing_names")){?>
<a href="calls_queue.php" class="normal_link">Incoming Queue Calls</a><br />
<? /*------ Incoming Queue Calls------ Report on Maintanance---<br /> */ ?>
Displays the Incoming Calls by queue.
<br /><br />

<a href="list_calls.php" class="normal_link">Calls by List</a><br />
Displays the number of calls made in each list.
<br /><br />


<a href="clerks_lists.php" class="normal_link">Clerk Lists</a><br />
Displays all the lists available for each clerk
<br /><br />

<? } ?>

<? if($current_clerk->im_allow("sbo_reload")){ ?>
<a href="reactivation_report.php" class="normal_link">Reactivation Report</a><br />
Show a list for Players without activity for 15 days with almost 1 deposit.
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("sbo_reload")){ ?>
<a href="conversion_report.php" class="normal_link">Conversion Report</a><br />
Show a list for New PBJ Players without deposit in 36 hours / Free Play was deposited .
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("sbo_reload")){ ?>
<a href="sbo_reload.php" class="normal_link">SBO Reload Report</a><br />
Access the SBO reload report.
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("sbo_reload")){ ?>
<a href="reload_results.php" class="normal_link">SBO Reload Results</a><br />
Access the SBO reload results report.
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("sbo_reload")){ ?>
<a href="sbo_inactive_deposit_players.php" class="normal_link">SBO Seasonal Reactivation</a><br />
Show the players that made a deposit before the selected date and the last wager.
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("phone_admin")){ ?>
<a href="name_special_report.php?type=reload" class="normal_link">No Action Report</a><br />
Access Reasons why players stopped playing
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("phone_admin")){ ?>
<a href="name_special_report.php?type=source" class="normal_link">Different Source Report</a><br />
Show all Sources that doesnt match
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("phone_admin")){ ?>
<a href="name_special_report.php?type=email" class="normal_link">Email Requests Report</a><br />
Access all the "Email me" requests and status
<br /><br />
<? } ?>





</div>
<? include "../includes/footer.php" ?>