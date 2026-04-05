<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Phone vs Web 2014</title>
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
<?
$from = $_POST["from"];
$to = $_POST["to"];
if($from == ""){$from = date("Y-m-d");}
if($to == ""){$to = date("Y-m-d");}
?>
<div class="page_content" style="padding-left:10px;">
    <span class="page_title">Phone vs Web 2014</span><br /><br />
    <form method="post">
    From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;
    To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
    </form>
    <br /><br />
    
    <? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/agent_phone_vrs_web_2014.php?from=$from&to=$to"); ?>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>