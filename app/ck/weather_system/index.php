<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("lines_system")){ 
ini_set('memory_limit','-1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="http://localhost:8080/ck/includes/js/sortables.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		
	};
</script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Weather System</title>
</head>
<body>
<?php header('Access-Control-Allow-Origin: *'); ?>
<? //$page_style = " width:100%;"; ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<?
 

  $from = param('from',false);
  if($from == ""){ $from = date('Y-m-d');}

?>

<span class="page_title"><? echo $tittle; ?> Weather System</span>
&nbsp;&nbsp;&nbsp;&nbsp;
<BR><BR>
<strong><a href="daily_report.php" class="normal_link">Daily Report</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;


<strong><a href="history_report.php" class="normal_link">History Report</a></strong>&nbsp;&nbsp;|&nbsp;&nbsp;

<BR><BR><BR>
<div>


<?  //echo "http://cashier.vrbmarketing.com/admin/prepaid_cards_balance.php?tp=".$tp."&new=".$new."&c=2002&p=PRXniq92iewoie2112ias&".$_SERVER['QUERY_STRING'];

  echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/weather/data.php?".$_SERVER['QUERY_STRING']); ?>



</div>
<? include "../../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>