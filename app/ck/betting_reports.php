<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Betting Reports</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Betting Reports</span><br /><br />

<? include "includes/print_error.php" ?>

<? if($current_clerk->im_allow("betting_basics")){ ?>

<table width="100%" border="0" cellpadding="10">
  <tr>
    <td width="50%">
        <a href="betting_report_dailyfigures.php" class="normal_link">Daily Figures</a><br />
        View Bets placed by week. Get detailed info.
    </td>
    <td width="50%">
    	<a href="betting_report_dailyidentifiers.php" class="normal_link">Daily Identifiers</a><br />
        View Identifiers Balance by date.
    </td>
  </tr>
    <tr>
    <td width="50%">
        <a href="betting_pendings.php" class="normal_link">Pending Bets</a><br />
        View Bets that haven't been graded.
    </td>
    <td width="50%">
    	 <a href="graded_games_pending.php" class="normal_link">Pending Graded Games</a><br />
         Games that haven't been graded.
    </td>
  </tr>
</table>

<? } ?>


</div>
<? include "../includes/footer.php" ?>