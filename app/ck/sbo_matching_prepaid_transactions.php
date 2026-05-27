<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("prepaid_transactions")){ ?>
<?
$cash_url = "cash.ezpay.com";
if(@file_get_contents("http://cash.ezpay.com/checker.php") != 'OK'){$cash_url = "www.sportsbettingonline.ag";}

$all_methods = "91,101,95,94,131,138,140,148,149,150,151";
$method = post_get("methods_list_search");
$from = post_get("from");
if ($from == ""){ $from = get_monday(date("Y-m-d")); }
$to = post_get("to",date("Y-m-d"));

$charlist = "\n\r\0\x0B";
$report_line = "";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Matching Prepaid Transactions</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
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
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<div align="right">
<a href="prepaid_transactions.php" class="normal_link" >Back to Prepaid</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<span class="page_title">Matching Prepaid Transactions</span><BR/>
<br />
<form method="post">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
<br /><br />
Method: 
<? 
echo file_get_contents("http://$cash_url/utilities/process/reports/print_payment_methods.php?filter=$all_methods&en=_search&ao=0&cm=$method"); 
?>

&nbsp;&nbsp;&nbsp;
<input name='search' type="submit" value="Search" />
</form>

<? 
if (isset($_POST["search"])){ ?>

<? 
$data = "?method=$method&from=$from&to=$to";
echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_matching_prepaid_transactions.php".$data); 
?>


<? } ?>
</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>