<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Betting</title>
</head>
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Betting Menu</span><br /><br />

<? include "includes/print_error.php" ?>

<? if($current_clerk->im_allow("betting_basics")){ ?>

<table width="100%" border="0" cellpadding="10">
  <tr>
    <td width="50%">
        <a href="betting.php" class="normal_link">Insert Bets</a><br />
        Display all the Games for insert Bets.
    </td>
    <td width="50%">
    <a href="autobet/sum_mode.php" class="normal_link">
    	Auto Betting
    </a><br />
	Make automatic bets. 
    </td>
  </tr>
  <tr>
    <td>
      <a href="betting_grading.php" class="normal_link">Grade Games</a><br />
      Insert Games results.
    </td>
    <td width="50%"><a href="betting_bank.php" class="normal_link">Manage Bank Accounts</a><br />
      Add and Edit Bank Accounts. </td>
    </tr>
  <tr>
    <td>
      <a href="betting_manual.php" class="normal_link" >Manual Win/Loss</a><br />
      Insert manually a betting win or loss for an Account.
    </td>
    <td><a href="betting_agent.php" class="normal_link">Manage Agents</a><br />
      Add and Edit Betting Agents. </td>
    </tr>
  <tr>
    <td>
      <a href="betting_moves.php" class="normal_link" >Accounts Moves</a><br />
      Move money from one account to other.
    </td>
    <td><a href="betting_accounts.php" class="normal_link">Manage Accounts</a><br />
      Add and Edit Betting Accounts. </td>
    </tr>
  <tr>
    <td>
      <a href="betting_commisions.php" class="normal_link" >Commission Accounts</a><br />
      Manage Commission Accounts and Percentages.
    </td>
    <td><a href="betting_groups.php" class="normal_link">Manage Groups</a><br />
      Add and Edit Betting Groups. </td>
    </tr>
  <tr>
    <td>
      <a href="grade_manual_picks.php" class="normal_link" >Grade Manual Picks</a><br />
      Grade Picks inserted manually (Teasers and Parlays).
    </td>
    <td><a href="betting_identifier.php" class="normal_link">Manage Identifiers</a><br />
      Add and Edit Betting Identifiers. </td>
    </tr>
  <tr>
    <td><a href="betting_reports.php" class="normal_link" >Reports</a><br />
Display Betting Reports. </td>
    <td><a href="betting_proxys.php" class="normal_link">Manage Proxys</a><br />
      Add and Edit Betting Proxys.</td>
  </tr>
   <tr>
    <td><a href="gambling_checklist.php" class="normal_link" >Gambling Checklist</a><br />
Display teh Gambling Check List. </td>
    <td>
    <a href="graded_games.php" class="normal_link" >Check Graded Games</a><br />
Check the graded games
    </td>
  </tr>
  <tr>
    <td><a href="gambling_checklist_by_day.php" class="normal_link" >Gambling Checklist By Day</a><br />
	Display teh Gambling Check List with details by day. </td>
    <td><a href="sbo_over_favorite_report.php" class="normal_link" >Favorite and Over</a><br />
Access the favorite and over report</td>
  </tr>
</table>

<? } ?>


<? if($current_clerk->im_allow("graded_games_checker")){ ?>
<table width="100%" border="0" cellpadding="10">
  
   <tr>
   <td width="50%">
    <a href="graded_games.php" class="normal_link" >Check Graded Games</a><br />
Check the graded games
    </td>
    <td><a href="bet_changer.php" class="normal_link" >Bet Changer</a><br />
Allow to Edit or Delete a Pending Wager, also send a Message to a Player<td>
  </tr>

</table>

<? } ?>


</div>
<? include "../includes/footer.php" ?>