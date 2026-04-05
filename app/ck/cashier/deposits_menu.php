<? if($current_clerk->im_allow("cashier_deposits")){ ?>


<strong><a href="deposits.php" class="normal_link">Deposits</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;


<strong><a href="pre_deposits.php" class="normal_link">Pre Confirmed Deposits</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;

<? if($current_clerk->vars['id'] == 1  || $current_clerk->vars['id'] == 270 || $current_clerk->vars['id'] == 275  || $current_clerk->vars['id'] == 234){ ?>
<strong><a href="post_deposits.php" class="normal_link">Post Confirmed Deposits</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;
<? } ?>

<strong><a href="denied_deposits.php" class="normal_link">Denied Deposits</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;

<? } ?>

<? if($current_clerk->im_allow("cahier_pending_deposits")){ ?>

<strong><a href="pending_deposits.php" class="normal_link">Confirmed Deposits</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;

<? } ?>

<? if($current_clerk->im_allow("denied_deposit_report")){ ?>

<strong><a href="denied_report.php" class="normal_link">Unconfirmed Denied Deposits</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;

<? } ?>
<? if($current_clerk->im_allow("denied_deposit_report")){ ?>

<strong><a href="deposit_report_time.php" class="normal_link">Deposits Time Report</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;

<? } ?>

<? if($current_clerk->im_allow("cashier_texts")){ ?>
<strong><a href="rel_amount_sort.php" class="normal_link">Sort Deposit Amounts</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;
<strong><a href="pending_oneonone.php" class="normal_link">Deposits Attached to payouts </a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;
<? } ?>