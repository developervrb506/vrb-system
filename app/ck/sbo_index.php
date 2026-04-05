<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_main_page")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>SBO</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">SBO Menu</span><br /><br />

<? include "includes/print_error.php" ?>


<table width="100%" border="0" cellpadding="10">



  <tr>
    <? if($current_clerk->im_allow("sbo_accounting_trans_report")){ ?>
    <td width="50%">
        <a class="normal_link" href="sbo_accounting_transactions.php">Accounting Transactions  </a>
        <a class="normal_link" href="sbo_accounting_transactions_sort_by_method.php">(Sort by Method)</a>
        <br />
        Run SBO Player Accounting Transactions Report
    </td>
    <? } ?>
  </tr>
  <?php /*?><tr>
    <? if($current_clerk->im_allow("payout_questions")){ ?>
    <td width="50%">
        <a class="normal_link" href="payout_questions.php">Payouts Questions</a><br />
        Display the Playout Questions
    </td>
    <? } ?>
  </tr><?php */?>
  <? /*  This report is displayed in crm_reports.php
  
  <tr>
    <? if($current_clerk->im_allow("all_sbo_transactions")){ ?>
    <td width="50%">
        <a class="normal_link" href="ezpay_all_transactions.php">All SBO Transactions</a><br />
        Show all SBO transactions by method.
    </td>
    <? } ?>
  </tr>
   */ ?>
    

  <tr>
    <? if($current_clerk->im_allow("sbo_banking")){ ?>
    <td width="50%">
        <a href="sbo_banking.php" class="normal_link">SBO Banking</a><br />
        Infromation of money in SBO Payments Methods
    </td>
    <? } ?>
  </tr>
  <?php /*?><tr>
    <? if($current_clerk->im_allow("special_deposits")){ ?>
    <td width="50%">
        <a class="normal_link" href="special_deposit.php">Special Deposits</a><br />
        Manage SBO special Deposits
    </td>
    <? } ?>
  </tr>
  <tr>
    <? if($current_clerk->im_allow("special_deposits")){ ?>
    <td width="50%">
        <a class="normal_link" href="special_payout.php">Special Payouts</a><br />
        Manage SBO special Payouts
    </td>
    <? } ?>
  </tr><?php */?>
  <?php /*?><tr>
    <? if($current_clerk->im_allow("mo_amounts")){ ?>
    <td width="50%">
        <a class="normal_link" href="mo_amounts.php">Money Orders Amounts</a><br />
        Manage Money Orders Amounts for Payouts
    </td>
    <? } ?>
  </tr><?php */?>
 
    <tr>
  	<? if($current_clerk->im_allow("sbo_loyalty")){ ?>
    <td width="50%">
    	
        <a href="sbo_loyalty.php" class="normal_link">SBO Loyalty Program</a><br />
        Insert and Edit Loyal Players.
    </td>
    <? } ?>
  </tr>
  <?php /*?><tr>
   	<? if($current_clerk->im_allow("cashier_access")){ ?>
    <td width="50%">
        <a href="cashier_access.php" class="normal_link">Cashier Access</a><br />
        Manage players and agents access to the cashier methods.
     </td>
    <? } ?>    
 </tr>
  <tr>
   	<? if($current_clerk->im_allow("cashier_access")){ ?>
    <td width="50%">
        <a href="cashier_method_description.php" class="normal_link">Cashier Methods Data</a><br />
        Manage the information displayed for each method in cashier.
     </td>
    <? } ?>    
 </tr><?php */?>
 <tr>
   	<? if($current_clerk->im_allow("website_casino_access")){ ?>
    <td width="50%">
        <a href="casinos_access.php" class="normal_link">Casinos by Website</a><br />
        Manage casinos in all websites.
     </td>
    <? } ?>    
 </tr>
 <tr>
   	<? if($current_clerk->im_allow("website_casino_access")){ ?>
     <td width="50%">
        <a class="normal_link" href="agent_manager/player_casino_access.php">Manage Player Casino Access  </a><br />
        Manage the Player access to Casinos
    </td>
    <? } ?>    
 </tr>
    <?php /*?><tr>
  	<? if($current_clerk->im_allow("prepaid_players")){ ?>
    <td width="50%">
    	
        <a href="prepaid_players.php" class="normal_link">SBO Prepaid Exception Players</a><br />
        Manage the list of players that can use the same number more than 1 time.
    </td>
    <? } ?>
    </tr><?php */?>
    <?php /*?><tr>
  	<? if($current_clerk->im_allow("moneypack_players")){ ?>
    <td width="50%">
    	
        <a href="moneypack_players.php" class="normal_link">Moneypak VIP Players</a><br />
        Manage the list of VIP players for moneypaks.
    </td>
    <? } ?>
    </tr><?php */?>
    
     <!--<tr>
  	<? if($current_clerk->im_allow("cash_transfer_players")){ ?>
    <td width="50%">
    	
        <a href="moneygram_blacklist.php" class="normal_link">SBO MoneyGram BlackList Players</a><br />
        Manage the list of player that belong to MoneyGram BlackList Players.
    </td>
    <? } ?>
    </tr>-->
    
      <!-- <tr>
  	<? if($current_clerk->im_allow("cash_transfer_players")){ ?>
    <td width="50%">
    	
        <a href="westernunion_blacklist.php" class="normal_link">SBO Western Union BlackList Players</a><br />
        Manage the list of player that belong to Western Union BlackList Players.
    </td>
    <? } ?>
    </tr>-->
    
    
    <!--<tr>
  	<? if($current_clerk->im_allow("reloadit_players")){ ?>
    <td width="50%">
    	
        <a href="reloadit_players.php" class="normal_link">SBO Reloadit Players</a><br />
        Manage the list of player that have Reloadit on their cashier.
    </td>
    <? } ?>
    </tr>-->
   <!-- <tr>
  	<? if($current_clerk->im_allow("giftcard_players")){ ?>
    <td width="50%">
    	
        <a href="giftcard_players.php" class="normal_link">SBO Giftcard Players</a><br />
        Manage the list of player that have Giftcard on their cashier.
    </td>
    <? } ?>
    </tr>-->
     <!--<tr>
    <? if($current_clerk->im_allow("checks_payouts")){ ?>
    <td width="50%">    	
        <a href="checks_payouts.php" class="normal_link">SBO Agents Payouts</a><br />
        Manage the list of Agents that  use Checks Payouts.
    </td>
    <? } ?>    
  </tr>-->
    <tr>
    <? if($current_clerk->im_allow("creditcard_players")){ ?>
    <!--<td width="50%">    	
        <a href="credit_card_exceptions.php" class="normal_link">SBO Credit Card Exceptions</a><br />
        Manage the list of player that doesnt use regular credit card rule.
    </td>-->
    <td width="50%">    	
        <a href="creditcard_players.php" class="normal_link">SBO Credit Card Players Information</a><br />
        Manage the Credit Card information of players.
    </td>
    <? } ?>    
  </tr>  
  <!--<tr>
  <? if($current_clerk->im_allow("moneypack_players")){ ?>
    <td width="50%">
    	
        <a href="bitcoins_players.php" class="normal_link">SBO Bitcoins Players</a><br />
        Manage the list of player that have Bitcoins Deposits on their cashier.
    </td>
    <? } ?>
  </tr>-->    
  <!--<tr>
  	<? if($current_clerk->im_allow("moneyorder_players")){ ?>
    <td width="50%">    	
        <a href="moneyorder_players.php" class="normal_link">SBO Moneyorder Players</a><br />
        Manage the list of player that have Moneyorder on their cashier.
    </td>
    <? } ?>
  </tr>-->
  <!--<tr>
  	<? if($current_clerk->im_allow("localcash_players")){ ?>
    <td width="50%">    	
        <a href="localcash_players.php" class="normal_link">SBO Local Cash Players</a><br />
        Manage the list of player that have Local Cash on their cashier.
    </td>
    <? } ?>
  </tr>-->  
  <!--<tr>
    <? if($current_clerk->im_allow("paypal_affiliates")){ ?>
    <td width="50%">    	
        <a href="paypal_affiliates.php" class="normal_link">SBO Paypal Affiliates</a><br />
        Manage the list of affiliates that have Paypal on their cashier.
    </td>
    <? } ?>
  </tr>-->
  <tr>
    <? if($current_clerk->im_allow("hold_percentage")){ ?>
    <td width="50%">    	
        <a href="sbo_hold_percentage.php" class="normal_link">SBO Hold percentage by league</a><br />
        Access the hold percentage by league report.
    </td>
    <? } ?>
  </tr>
  <tr>
    <? if($current_clerk->im_allow("sbo_main_page")){ ?>
    <td width="50%">    	
        <a href="casino_winloss.php" class="normal_link">Casino Win/Loss</a><br />
        Access the casino win/loss report
    </td>
    <? } ?>
  </tr>
 
  <tr>
    <? if($current_clerk->im_allow("sbo_banking")){ ?>
    <td width="50%">    	
        <a href="sbo_gold_silver_pt.php" class="normal_link">SBO GOLD/SILVER amounts</a><br />
        Access to manage the current amouts in cards
    </td>
    <? } ?>
  </tr>
   <tr>
    <? if($current_clerk->im_allow("sbo_agent_report")){ ?>
    <td width="50%">    	
        <a href="sbo_weekly_agent_report.php" class="normal_link">SBO Weekly Agent Report </a><br />
        Run the Weekly Agent Report
    </td>
    <? } ?>
  </tr>
   <tr>
    <? if(($current_clerk->im_allow("balance_adjustment")) || ($current_clerk->im_allow("balance_disbursements")) || ($current_clerk->im_allow("balance_receipt"))  ){ ?>
	<td width="50%">    	
        <a href="balance_manager.php" class="normal_link">Balance Manager</a><br />
        Access the Balance Menu for Adjustmets, Receipts and Disbursements.
    </td>
    <? } ?>
  </tr>
   <tr>
    <? if($current_clerk->im_allow("manage_permission")){ ?>
    <td width="50%">    	
        <a href="manage_permission.php" class="normal_link">Manage  Access Permissions</a><br />
        Manage the User Access to some systems functions.
    </td>
    <? } ?>
  </tr>
     <tr>
    <? if($current_clerk->im_allow("new_features")){ ?>
    <td width="50%">    	
        <a href="new_feature.php" class="normal_link">New Features Notes</a><br />
        Manage the News features notes for Players and Agents.
    </td>
    <? } ?>
  </tr>
    <tr>
    <? if($current_clerk->im_allow("line_blocker")){ ?>
    <td width="50%">    	
        <a href="agent_money_line_blocker.php" class="normal_link">Agent Money Line Blocker</a><br />
        Manage limit for the Money line of Agents and subagents.
    </td>
    <? } ?>
  </tr>
  </tr>
   
   <?php /*?><tr>
    <? if($current_clerk->im_allow("reverse_transactions")){ ?>
    <td width="50%">    	
        <a href="reverse_transactions.php" class="normal_link">Reverse Transactions</a><br />
        Access the Transaction to be Reversed
    </td>
    <? } ?>
  </tr><?php */?>
 
</table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>