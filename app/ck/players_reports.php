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

 
  	<? if($current_clerk->im_allow("sbo_winners")){ ?>
        <a href="sbo_winners.php" class="normal_link">Daily/Weekly winners </a><br />
        Display players with certain win amount in a period of time.<br /><br />
        
        <a href="sbo_negative_players.php" class="normal_link">Negative Players </a><br />
        Display players with balance less than 0.<br /><br />
    <? } ?>

  	<? if($current_clerk->im_allow("sbo_changed")){ ?>
        <a href="sbo_deleted.php" class="normal_link">SBO Changed/Deleted Wagers</a><br />
        Display Changed and Deleted Wagers in a period of time.<br /><br />
    <? } ?>
    
    <? if($current_clerk->im_allow("sbo_loyalty")){ ?>
        <a href="sbo_rewards.php" class="normal_link">Daily Rewards Report</a><br />
        Display the players and amount for rewards.<br /><br />
    <? } ?>
    <? if($current_clerk->im_allow("player_notes")){ ?>
        <a href="sbo_player_notes.php" class="normal_link">Player Notes</a><br />
        Allow to Edit the Players Flag's Messages and Online Notes<br /><br />
    <? } ?>
      <? if($current_clerk->im_allow("player_notes")){ ?>
        <a href="sbo_player_marketing_notes.php" class="normal_link">Player Marketing / Customer Notes</a><br />
        Allow to Edit the Players Marketing and Customers Notes<br /><br />
    <? } ?>
	<? if($current_clerk->im_allow("sbo_changed")){ ?>
        <a href="sbo_bets_by_type.php" class="normal_link">Bets by Type</a><br />
         Display bets totals by bet type.<br /><br />
    <? } ?>
    <? if($current_clerk->im_allow("sbo_changed")){ ?>
        <a href="sbo_old_open_parlay_teaser.php" class="normal_link">Old Open Parlay/Teaser</a><br />
         Display Parlays and Teasers bets Pending<br /><br />
    <? } ?>
    
    	<a href="sbo_props_live_pending_wagers.php" class="normal_link">Pending Props+ and Live+</a><br />
         Display Props+ and Live+ pending wagers<br /><br />
         
         
         <a href="sbo_active_players.php" class="normal_link">Active Players</a><br />
         List of all players active in a range of dates, can be filtered by inactive tools<br /><br />
    


</div>
<? include "../includes/footer.php" ?>