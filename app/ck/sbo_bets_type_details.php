<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("sbo_main_page")){ ?>
<?
ini_set('memory_limit', '-1');
set_time_limit(1000);

$from = $_GET["from"];
$to =  $_GET["to"];
$wtype =  $_GET["wtype"];
$t =  $_GET["t"];
$agent =  $_GET["a"];
$sport =  $_GET["s"];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#fff; padding:20px;">
  <? $data = "?from=$from&to=$to&wtype=$wtype&t=$t&a=$agent&s=$sport"; ?>
  <? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_bets_type_details.php".$data); ?>

</body>
</html>
<? }else{echo "Access Denied";} ?>