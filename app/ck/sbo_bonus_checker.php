<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cashier_deposits")){ ?>
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
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
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
<title>Deposit Bonus Checker</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Deposit Bonus Checker</span><br /><br />

<? include "includes/print_error.php" ?> 


<? 
if($_GET["from"]==""){$from = date('Y-m-d'); $to = $from; }else{$from = $_GET["from"]; $to = $_GET["to"];} 
?>
<form method="get">
From: <input name="from" type="text" id="from" value="<? echo $from ?>"  /> &nbsp;&nbsp;&nbsp;
To: <input name="to" type="text" id="to" value="<? echo $to ?>"  /> &nbsp;&nbsp;&nbsp;

<input type="submit" value="Search" />
</form>
<br /><br />

 <? $data = "from=".$from."&to=".$to; ?>
<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_bonus_checker.php?".$data); ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>