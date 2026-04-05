<? include(ROOT_PATH . "/process/login/security.php"); ?>
<? require_once(ROOT_PATH . "/process/functions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../process/js/functions.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Commissions Reports</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Commissions Reports</span><br /><br />
<a class="normal_link" href="http://localhost:8080/dashboard/asp_report_results.php?report=1">Commissions</a>
<br /><br />
<a class="normal_link" href="http://localhost:8080/dashboard/asp_report_results.php?report=2">Daily Figures</a>
<?php /*?><br /><br />
<a class="normal_link" href="http://localhost:8080/dashboard/asp_report_results.php?report=3">Position by Game</a><?php */?>
<br /><br />
<a class="normal_link" href="http://localhost:8080/dashboard/asp_report_results.php?report=4">Player Report</a>
<br /><br />
<a class="normal_link" href="http://localhost:8080/dashboard/asp_report_results.php?report=5">Payment Statement by Date</a>
<br /><br />
<a class="normal_link" href="http://localhost:8080/dashboard/asp_report_results.php?report=6">Conversion Report</a>
<br /><br />
<a class="normal_link" href="http://localhost:8080/dashboard/asp_report_results.php?report=7">Player Deposits by Date</a>
</div>
<? include "../includes/footer.php" ?>