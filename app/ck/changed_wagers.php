<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->admin()){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"pfrom",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"pto",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">
Changed Wagers
</span><br /><br />

<?
$from = $_POST["pfrom"] ? $_POST["pfrom"] : date("Y-m-d",strtotime(date("Y-m-d")." -1 day"));
$to = $_POST["pto"] ? $_POST["pto"] : date("Y-m-d");
?>

<form method="post">
From: <input name="pfrom" type="text" id="pfrom" value="<? echo $from ?>" size="7" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To: <input name="pto" type="text" id="pto" value="<? echo $to ?>" size="7" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
<input name="Enviar" type="submit" value="Search" />
</form>

<br /><br />


 <? 
     echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/changed_wagers.php?pass=VrBAcc@ess&from=$from&to=$to");
  /*
	 $content = @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/changed_wagers.php?pass=VrBAcc@ess&from=$from&to=$to");
	
	 if($content === FALSE) { ?>
	   <span> At this moment the Database is doing a Syncronization, Please check again this Page in 2 minutes</span>
	<? } else {
	 
	 echo $content; 
	 }
  */	 
	 ?>

</body>
</html>
<? }else{echo "Access Denied";} ?>