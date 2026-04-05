<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_deposits")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="../../process/js/functions.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
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
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Completed Payouts</title>
</head>
<body>
<? $page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">

<span class="page_title">
	Completed Payouts
</span>
<p><? include("payouts_menu.php"); ?></p>
<br /><br />
<?
/*if($_GET["l7"]){
	$from = date("Y-m-d",strtotime(date("Y-m-d")."-7 days"));
	$to = date("Y-m-d");
	?><p><a href="completed_payouts.php" class="normal_link">Today</a></p><?
}else{
	$from = date("Y-m-d");
	$to = date("Y-m-d");
	?><p><a href="completed_payouts.php?l7=1" class="normal_link">Last 7 days</a></p><?
}*/

/*$from = $_GET["from"];
if($from == ""){$from = date("Y-m-d");}
$to = $_GET["to"];
if($to == ""){$to = date("Y-m-d");}
*/
?>

<?php /*?><form method="get">
	From: <input name="from" type="text" id="from" value="<? echo $from ?>" />
        
    &nbsp;&nbsp;
    
    To: <input name="to" type="text" id="to" value="<? echo $to ?>" />
    
    &nbsp;&nbsp;
    
    <input name="send" type="submit" id="send" value="Submit" />
</form><?php */?>

<? echo file_get_contents("http://cashier.vrbmarketing.com/admin/payout_report.php?show_reviews=1&c=2002&p=PRXniq92iewoie2112ias&nosearch=1&pfrom=$from&pto=$to&status=go&approved=1&confirmed=1&inserted=NULL&account=&send=Submit=1&compreverse=1&".$_SERVER['QUERY_STRING']); ?>



</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>