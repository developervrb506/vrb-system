
<? if($current_clerk->im_allow("cashier_search_payouts")){ ?>

<strong><a href="payout_report.php" class="normal_link">Payouts Search</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;

<? } ?>

<? if($current_clerk->im_allow("cashier_payout_report")){ ?>

<strong><a href="pre_payouts.php" class="normal_link">Pre Confirmed Payouts</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;

<? } ?>  

<? if($current_clerk->im_allow("cashier_payout")){ ?>

<strong><a href="payouts.php" class="normal_link">Post Confirmed Payouts</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;



<strong><a href="approved_payouts.php" class="normal_link">Approved Payouts</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;

<strong><a href="show_emails.php" class="normal_link">Approved Payouts Emails</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;

<? } ?>

<? if($current_clerk->im_allow("cashier_payout_report")){ ?>

<strong><a href="denied_payouts.php" class="normal_link">Denied Payouts</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;



<strong><a href="completed_payouts.php" class="normal_link">Completed Payouts</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;

<? } ?>
<? if($current_clerk->im_allow("cashier_texts")){ ?>
<strong><a href="../payout_questions.php" class="normal_link">Payout Questions</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;
<strong><a href="reasons.php" class="normal_link">Commun denied reasons</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;
<strong><a href="emails.php" class="normal_link">Approved Payouts Emails</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;
<? } ?>
