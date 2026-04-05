<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? include(ROOT_PATH . "/includes/reset_affiliate.php") ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Reports</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Reports</span><br /><br />

<? if ( $_SESSION["aff_id"] == 1181) {
	?> <a href="../reports/index.php" target="_blank" class="normal_link">Sysop Reports</a><br /><br /><?
}
?>

Select a Brand: 
<? 
$books_on_change = "location.href = 'reports.php?bk='+this.value"; 
$selected_book = $_GET["bk"];
$select_option = true;
include(ROOT_PATH . "/includes/books.php"); 
?>
<br /><br />

<? if($_GET["bk"] == 1){ ?>
<?php /*?><p>WagerWeb reports are currently under maintenance and will be available within 48 hours.  If you need a report, please contact us at 1.800.986.1152 or vrbaffiliates@gmail.com.  We apologize for the inconvenience.<br /><br />
<strong>The VRB Affiliates Team</strong>
<br /><br />
</p><?php */?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="25%"><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/marketing-reports.php?bk=<? echo $_GET["bk"] ?>">Marketing Report</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view clicks and impressions by PID, Campaign, Banner size, website and brand.</div></td>
  </tr>
  <tr>
    <td><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/wagerweb_reports.php?report=1">Commissions</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view commissions earned by week. It includes Net Revenue, Win / Loss and Negative Carry-Over balances. </div></td>
  </tr>
  <tr>
    <td><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/wagerweb_reports.php?report=2">Daily Figures</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view wagers placed by your players during the current week or the previous week.  Get detailed info on wagers placed by clicking through on each figure.</div></td>
  </tr>
  <tr>
    <td><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/wagerweb_reports.php?report=3">Player Report</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view your players Net Revenue, Current Balance, Join Date and Status.</div></td>
  </tr>
  <tr>
    <td><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/wagerweb_reports.php?report=4">Payment Statement</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view details about your past commission payouts. It includes payment method, amount and date.</div></td>
  </tr>
  <tr>
    <td><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/wagerweb_reports.php?report=5">Conversion Report</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view the conversion percentage from new player sign up to deposit, on a weekly basis. </div></td>
  </tr>
  <tr>
    <td><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/wagerweb_reports.php?report=6">Player Deposits</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view when a player has made a deposit and the respective amount. Historical is based on last 90 days.</div></td>
  </tr>
</table>

<? }else if( $_GET["bk"] == 3 or $_GET["bk"] == 6 or $_GET["bk"] == 7  or $_GET["bk"] == 8  or $_GET["bk"] == 9 or $_GET["bk"] == 10){ ?>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="25%"><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/marketing-reports.php?bk=<? echo $_GET["bk"] ?>">Marketing Report</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view clicks and impressions by PID, Campaign, Banner size, website and brand.</div></td>
  </tr>
  <tr>
    <td width="25%"><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/revenue_report.php?bk=<? echo $_GET["bk"] ?>">Revenue Report</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view Net Revenue and commissions generated per product. Plus, any adjustments that have been calculated within the total. </div></td>
  </tr>
  <tr>
    <td width="25%"><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/daily_figures_report.php?bk=<? echo $_GET["bk"] ?>">Daily Figures</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view wagers placed by your players during the current week or the previous week. Get detailed info on wagers placed by clicking through on each figure.</div></td>
  </tr>
  <tr>
    <td width="25%"><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/players_report.php?bk=<? echo $_GET["bk"] ?>">Player Report</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view your players Net Revenue by product, Join Date and Status.</div></td>
  </tr>
  <tr>
    <td width="25%"><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/agent_accounting_report_new.php?bk=<? echo $_GET["bk"] ?>">Agent Accounting</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view a breakdown of commissions earned and adjustments calculated into the current balance.  </div></td>
  </tr>
  <tr>
    <td width="25%"><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/payment_statement_report.php?bk=<? echo $_GET["bk"] ?>">Payment Statement</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view details about your past commission payouts. It includes payment method, amount and date.</div></td>
  </tr>
  <tr>
    <td width="25%"><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/conversion_report.php?bk=<? echo $_GET["bk"] ?>">Conversion Report</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view the conversion percentage from new player sign up to deposit, on a weekly basis. </div></td>
  </tr>  
  <tr>
    <td width="25%"><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/open_bets_report.php?bk=<? echo $_GET["bk"] ?>">Open Bets</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view any open wagers.</div></td>
  </tr>    
</table>

<? }else if($_GET["bk"] == 5){ ?>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="25%"><div style="float:none;" class="gray_box"><a class="normal_link" href="http://localhost:8080/dashboard/marketing-reports.php?bk=<? echo $_GET["bk"] ?>">Marketing Report</a></div></td>
    <td><div style="float:none;" class="gray_box">Use this report to view clicks and impressions by PID, Campaign, Banner size, website and brand.</div></td>
  </tr>    
</table>

<? } ?>

</div>
<? include "../includes/footer.php" ?>