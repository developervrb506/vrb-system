<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Reports</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
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

 
<? if($current_clerk->im_allow("contest_winners_players")){ ?>
<a href="contest_winners.php" class="normal_link">Contests Winners</a><br />
Access list of Players that wins a Contest
<br /><br />
<? } ?>


<? if($current_clerk->im_allow("john_list_control")){ ?>
<a href="john_list_control.php" class="normal_link">Johns Lists</a><br />
Access Johns lists information
<br /><br />
<? } ?>

<?php /*?>
<? if($current_clerk->im_allow("cashier_access")){ ?>
<a href="cashier_access.php" class="normal_link">Cashier Access</a><br />
Manage players and agents access to the cashier methods.
<br /><br />
<? } ?><?php */?>

<? if($current_clerk->im_allow("help_calls")){ ?>
<a href="help_call_requesrts.php" class="normal_link">Help Call Requests</a><br />
Show all pending help calls requests
<br /><br />
<? } ?>


<? if($current_clerk->im_allow("last_deposit_report")){ ?>
<a href="deposit_report.php" class="normal_link">Last Deposit Report</a><br />
Show all information from last Deposit
<br /><br />
<? } ?>



  <? if($current_clerk->im_allow("sbo_agent_report")){ ?>
  
      <a href="sbo_weekly_agent_report.php" class="normal_link">SBO Weekly Agent Report </a><br />
      Run the Weekly Agent Report
	<br /><br />
  <? } ?>
  
   <? if($current_clerk->im_allow("sbo_agent_report")){ ?>
  
      <a href="agent_reports_access.php" class="normal_link">Agent Reports Access </a><br />
      Show the total of access for Report
	<br /><br />
  <? } ?>
  
     <? if($current_clerk->im_allow("sbo_agent_report")){ ?>
  
      <a href="agent_tools_access.php" class="normal_link">Agent Tools Access </a><br />
      Show the total of access for Tool
	<br /><br />
  <? } ?>

<? if($current_clerk->im_allow("creditcard_deny_report")){ ?>
<a href="sbo_cc_deny_report.php" class="normal_link">CreditCard Deny report</a><br />
Show all Credit Cards Denied and check deposits
<br /><br />
<? } ?>


<? if($current_clerk->im_allow("enable_users")){ ?>
<a href="disable_clerks.php" class="normal_link">Blocked Users</a><br />
Displays all Blocked users
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("enable_users")){ ?>
<a href="reset_clerks.php" class="normal_link">Reset Users</a><br />
Allow to Reset the User Password
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("phone_logins")){ ?>
<a href="phone_login_by_clerks.php" class="normal_link">User phone logins</a><br />
Displays the user's phone login
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("search_transactions")){ ?>
<a href="search_transaction_report.php" class="normal_link">Search Transactions</a><br />
Search all the Ezpay Transactions
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("denied_transaction_report")){ ?>
<a href="denied_transaction_report.php" class="normal_link">Denied Transactions Reports</a><br />
Display all the Denied Transactions
<br /><br />
<? } ?>


<? if($current_clerk->im_allow("first_creditcard_deposit")){ ?>
<a href="sbo_first_creditcard_deposit.php" class="normal_link">First Creditcard Deposit</a><br />
Displays the Player Fisrt Credicard Deposit 
<br /><br />
<? } ?>


<?php /*?><? if($current_clerk->im_allow("affiliates_commission")){ ?>
<a href="affiliates_comission_report.php" class="normal_link">Affiliates Commission Report</a><br />
Displays all commission information for all affiliates.
<br /><br />
<? } ?>
<?php */?>

<!--SBO-->
<? /* This report was added in crm_report.php

<? if($current_clerk->im_allow("sbo_daily_new_accounts")){ ?>
<a href="sbo_new_accounts.php" class="normal_link">SBO Daily New Accounts</a><br />
Displays all the signups on SBO in a period of time.
<br /><br />
<? } ?>
 */ ?>
 
 <? if($current_clerk->im_allow("creditcard_processor_balance")){ ?>
<a href="creditcard_procesor_balance.php" class="normal_link">Creditcards Processor Balance</a><br />
Displays the balance for Creditcard's Processors.
<br /><br />
<? } ?>


<? if($current_clerk->im_allow("deposit_players")){ ?>
<a href="sbo_deposits.php" class="normal_link">Deposit Players</a><br />
Displays all players that deposited on a range of time.
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("sbo_payouts_report")){ ?>
<a class="normal_link" href="sbo_payouts_report.php">Payouts Report</a><br />
Run SBO payouts report
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("my_sbo_payouts_report")){ ?>
<a class="normal_link" href="sbo_my_payouts_report.php">My Payouts Report</a><br />
Run my SBO payouts report
<br /><br />
<? } ?>

<? /* This report was added in crm_report.php

<? if($current_clerk->im_allow("first_deposit")){ ?>
<a href="sbo_first_deposit.php" class="normal_link">First Deposits</a><br />
Displays the first deposits on a period of time.
<br /><br />
<? } ?>
 */ ?>

<? if($current_clerk->im_allow("sbo_social_freeplays")){ ?>
<a href="sbo_freeplays.php" class="normal_link">SBO Social Media Free Plays</a><br />
Displays all the SBO social media free plays in a period of time.
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("marketing_names")){ ?>
<a href="names_marketing.php" class="normal_link">SBO Phone Players</a><br />
Displays all new SBO signups in Phone System
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("sbo_agent_info_access")){ ?>
<a href="sbo_search_agents.php" class="normal_link">Search SBO Agent</a><br />
Search SBO Agents Info by Name.
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("sbo_rollover")){ ?> 	
<a href="sbo_rollover.php" class="normal_link">SBO Rollover</a><br />
Access the SBO rollover Report
<br /><br />
<? } ?>

<? if($current_clerk->im_allow("sbo_reload")){ ?> 	
<a href="sbo_manual_assign_report.php" class="normal_link">Manual Assign Report</a><br />
Access the Manual Assing Report
<br /><br />
<? } ?>

<!--Admin and Sales Manager-->


<? if($current_clerk->vars["level"]->vars["sale_manager"] || $current_clerk->im_allow("phone_admin")){ ?>

<? /* This report was added in crm_report.php
<a href="day_calls.php" class="normal_link">Calls by Day</a><br />
Displays the average of calls per hour and the number fo calls for each clerk.
<br /><br />
*/ ?>

<a href="log_time.php" class="normal_link">Log Time by Sales Clerk</a><br />
Displays the number of logged hours for each Sales Clerk.
<br /><br />
<? if($current_clerk->admin()){ ?>
<a href="deposits_by_date.php" class="normal_link">Deposits</a><br />
Displays all the deposits in between dates.
<br /><br />
<? } ?>
<? } ?>


<!--Manual Sites Payments-->
<? if($current_clerk->im_allow("manual_sites_payments")){ ?>
<a href="manual_sites_payments.php" class="normal_link">SGI Payments</a><br />
Display the Players to add a Manual Payment
<br /><br />
<? } ?>



<!--Mexicans-->
<? if($current_clerk->im_allow("hold_percentage_mex")){ ?> 	
<a href="sbo_hold_percentage_mex.php" class="normal_link">Hold percentage by league</a><br />
Access the hold percentage by league report.
<br /><br />
<? } ?>

<!--newsletter-->
<? if($current_clerk->im_allow("newsletter_contacts")){ ?> 	
<a href="newsletter_contacts.php" class="normal_link">Newsletter Contacts</a><br />
Access the newsletter contacts information.
<br /><br />
<? } ?>

<!--betting info players-->

<? if($current_clerk->im_allow("betting_info_players")){ ?> 	
<a href="betting_info_players.php" class="normal_link">Players Betting Information</a><br />
Access the players betting information.
<br /><br />
<? } ?>



<?php /*?><? if($current_clerk->im_allow("inactive_affiliates_banners")){ ?> 	
<a href="inactive_affiliates_banners.php" class="normal_link">Affiliates Inactive Banners</a><br />
View all inactive banners in a period of time
<br /><br />
<? } ?>
<?php */?>

<!--Workinkg time-->
<? if($current_clerk->im_allow("working_time_report")){ ?>
<a href="log_time_new.php" class="normal_link">Working Time Report</a><br />
Displays the number of worked hours for each employee.
<br /><br />
<a href="clerks_on_break.php" class="normal_link" rel="shadowbox;height=500;width=300">Employees on Break</a><br />
Displays all employees that are in Break.
<br /><br />
<? } ?>


</div>
<? include "../includes/footer.php" ?>