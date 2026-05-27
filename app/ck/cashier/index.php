<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_admin")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Cashier Admin</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? //$page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px; min-height:700px;">


<div style="float:left; width:45%; min-height:700px;">
	<span class="page_title"> Cashier Admin</span><br /><br />
    
    <? if($current_clerk->im_allow("cashier_deposits") || $current_clerk->im_allow("cahier_pending_deposits") || $current_clerk->im_allow("denied_deposit_report")){ ?>
    <p>
    <strong><a href="deposits.php" class="normal_link">Deposits</a></strong><br /> <? //index_deposits.php ?>
    Deposits reports and information
    </p>
    <? } ?>
    
    <? if($current_clerk->im_allow("cashier_payout_report") || $current_clerk->im_allow("cashier_payout") || $current_clerk->im_allow("cashier_search_payouts")){ ?>
    <p>
    <strong><a href="payout_report.php" class="normal_link">Payouts</a></strong><br /> <? //index_payouts.php ?>
    Payouts reports and information
    </p>
    <? } ?>
    
    <? if($current_clerk->im_allow("cashier_insert_special")){ ?>
    <p>
    <strong><a href="special_transaction.php" class="normal_link">Special Transactions</a></strong><br />
    Insert special deposits and payouts
    </p>
    <? } ?>
    
    <? if($current_clerk->im_allow("cashier_texts")){ ?>
    <p>
    <strong><a href="texts.php" class="normal_link">Cashier texts</a></strong><br />
    Manage promotions and sidebars text.
    </p>
    <? } ?>
    
    <? if($current_clerk->im_allow("cashier_lists")){ ?>
    <p>
    <strong><a href="lists.php" class="normal_link">Access Lists </a></strong><br />
    Black lists, Allow lists and Block lists for each method
    </p>
    <? } ?>
    
    <? if($current_clerk->im_allow("cashier_methods")){ ?>
    <p>
    <strong><a href="methods.php" class="normal_link">Manage Methods</a></strong><br />
    Manager all methods information and settings
    </p>
    <? } ?>
    
    <? if($current_clerk->im_allow("cashier_payout")){ ?>
    <p>
    <strong><a href="send_card.php" class="normal_link">Card Sender</a></strong><br />
    Send Cards by Email
    </p>
    <? } ?>
    
    <? if($current_clerk->im_allow("manual_cashier")){ ?>
    <p>
    <strong><a href="manual_cashier.php" class="normal_link">Manual Cashier</a></strong><br />
    Access Players/Agents Cashier manually
    </p>
	
	<p>
    <strong><a href="house_deposits.php" class="normal_link">House Deposit Targets</a></strong><br />
    Deposits targets for the house
    </p>
	<p>
	
    <strong><a href="https://kribatta.com/cashier/card2crypto.php?account=OFFICE&session_key=globalmaster&lang=eng&cid=50" class="normal_link" target="_blank">Credit Card by Kribatta</a></strong><br />
    Manually run a Credit Card in Kribatta
    </p>
    <? } ?>
    
</div>


<div style="float:right; width:45%;">
	<span class="page_title"> Cashier Reports</span><br /><br />
    
    <? if($current_clerk->im_allow("cashier_deposits") || $current_clerk->im_allow("cahier_pending_deposits") || $current_clerk->im_allow("denied_deposit_report")){ ?>
    <p>
    <strong><a href="search_moved_deposits.php" class="normal_link">Allocation Report </a></strong><br />
    Search all Moved Deposit 
    </p>
    <? } ?>
    
    <? if($current_clerk->im_allow("cashier_deposits")){ ?>
    <p>
    <strong><a href="<?= BASE_URL ?>/ck/sbo_bonus_checker.php" class="normal_link">Deposit Bonus Checker</a></strong><br />
    List of Deposits with Bonus, Adjustments Information
    </p>
    <? } ?>
    
    <? if($current_clerk->im_allow("method_regular_player")){ ?>
    <p>
    <strong><a href="<?= BASE_URL ?>/ck/sbo_method_regular_player.php" class="normal_link">Method's Regular Players</a></strong><br />
    List of Players that used a Method
    </p>
    <? } ?>

    
    <? if($current_clerk->im_allow("prepaid_balance")){ ?>
    <p>
    <strong><a href="prepaid_cards_balance2.php?type=new" class="normal_link">Prepaid Cards Balance</a></strong><br />
    Check the balance for the Prepaid Cards
    </p>
    <? } ?>
    
    <? if($current_clerk->im_allow("prepaid_balance")){ ?>
    <p>
    <strong><a href="prepaid_cards_search.php" class="normal_link">Prepaid Cards Search</a></strong><br />
    Allow user to search by cvv,number or exp in the system.
    </p>
    <? } ?>
    
    <p>
    <strong><a href="owed_report.php" class="normal_link">Owed Report</a></strong><br />
    Show owed amounts to agents, players and affiliates
    </p>
    
    
        
</div>





<? if($current_clerk->im_allow("cashier_deposits") || $current_clerk->im_allow("cahier_pending_deposits") || $current_clerk->im_allow("denied_deposit_report")){ ?>



<?php /*?><p>
<strong><a href="<?= BASE_URL ?>/ck/balances_transactions.php" class="normal_link">Balance Intersystem Transactions</a></strong><br />
 Balance Intersystem Transactions by status
</p>

<p>
<strong><a href="<?= BASE_URL ?>/ck/expenses_index.php" class="normal_link">Expense Intersystem Transactions </a></strong><br />
Search Expense Intersystem Transactions 
</p><?php */?>


<? } ?>
<?php /*?><? if($current_clerk->im_allow("cashier_deposits")){ ?>

<p>
<strong><a href="<?= BASE_URL ?>/ck/cashier/coins_report.php" class="normal_link">Cryptocoins Report</a></strong><br />
List of all Cryptocoins and current balances
</p>
<? } ?><?php */?>






<?php /*?><? if($current_clerk->im_allow("cashier_deposits") || $current_clerk->im_allow("cashier_payout")){ ?>
<p>
<strong><a href="feedbacks.php" class="normal_link">Customer Feedback</a></strong><br />
View customer feedbacks
</p>
<? } ?><?php */?>

<? if($current_clerk->im_allow("cashier_texts")){ ?>

<?php /*?><p>
<strong><a href="cc_processors.php" class="normal_link">Credit Card Processors</a></strong><br />
Manage CC processors by brand.
</p>
<p>
<strong><a href="http://cashier.vrbmarketing.com/admin/bitbet_processor.php"  rel="shadowbox;height=100;width=300" class="normal_link">Bitbet Bitcoin Processor</a></strong><br />
Select a bitcoin processor for bitbet.
</p><?php */?>


<?php /*?><p>
<strong><a href="deposit_transfer_list.php" class="normal_link">Deposits Transfer List</a></strong><br />
Manage list of deposit transfer.
</p><?php */?>

<? } ?>






<?php /*?><? if($current_clerk->im_allow("vrb_processing_admin")){ ?>
	<? $vrb_admin_on = true; ?>
    <p><strong><a class="normal_link" href="javascript:;" onclick="document.getElementById('f3').submit()">Processing Admin</a></strong><br />
    Access to manage processing system (names, processors, settings, etc)
    </p>
    <form id="f3" name="f3" method="post" action="https://www.ezpay.com/process/login/login-process.php" target="_blank">
    <input name="email" type="hidden" id="email_login" value="admin@vrbmarketing.com" />
    <input name="pass" type="hidden" id="pass" value="VRB7777" />
    <input name="no_fail" type="hidden" id="no_fail" value="1" />
    <input name="internal" type="hidden" id="internal" value="1" />
    <input name="clerk_id" type="hidden" id="clerk_id" value="<? echo $current_clerk->vars["id"] ?>" /> 
    </form>
 <? } ?><?php */?>
 
 


<?php /*?> <? if($current_clerk->im_allow("prepaid_visa_balance")){ ?>
<p>
<strong><a href="prepaid_visa_cards_balance.php?type=new" class="normal_link">Prepaid Visa Cards </a></strong><br />
Check the balance for the Visa Cards that are not Vanilla
</p>
<? } ?><?php */?>



</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>