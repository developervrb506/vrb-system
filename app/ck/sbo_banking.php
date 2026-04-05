<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_banking")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
<title>SBO Banking</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">SBO Banking</span><br /><br />

<a href="sbo_banking_fees.php" class="normal_link">
	Manage Fees
</a>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href="sbo_banking_new_transaction.php" class="normal_link">
	New Transaction
</a>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href="sbo_banking_report.php" class="normal_link">
	Report
</a>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href="sbo_banking_daily.php" class="normal_link">
	Daily Report
</a>
<? if($current_clerk->im_allow("intersystem_transactions")){ ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href="intersystem_transaction.php" class="normal_link" rel="shadowbox;height=470;width=430">New Intersystem Transaction</a>
<? } ?>

<br /><br />
<? include "includes/print_error.php" ?> 


<?
$from = $_GET["from"];
$to = $_GET["to"];
if($to == ""){$to = date("Y-m-d");}
?>
<form method="get">
<input name="from" type="hidden" id="from" value="<? echo $from ?>" readonly="readonly" /> 
To: <input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" /> 
<input type="submit" value="Search" />
</form>
<br /><br />

 
<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_banking.php?from=$from&to=$to"); ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>