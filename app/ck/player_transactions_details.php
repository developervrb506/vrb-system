<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_main_page")){ ?>
<?
$from = $_GET["from"];
$to =  $_GET["to"];
$pid =  $_GET["pid"];
$type =  $_GET["type"];
$player =  $_GET["player"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">
  <? $data = "?from=$from&to=$to&pid=$pid&type=$type&player=$player"; ?>
  <? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_player_transactions_details.php".$data); ?>

</body>
</html>
<? }else{echo "Access Denied";} ?>