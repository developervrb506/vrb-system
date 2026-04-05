<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->vars["level"]->vars["sale_manager"] && !$current_clerk->im_allow("phone_admin")){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Calls By Day</title>
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
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Calls By Day</span><br /><br />

<? include "includes/print_error.php" ?>

<?
$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$to = clean_get("to");
if($to == ""){$to = date("Y-m-d");}
?>

<form method="post" action="day_calls.php">
    From: 
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
</form>

<br />

<? include "includes/report_calls.php" ?>

</div>
<? include "../includes/footer.php" ?>