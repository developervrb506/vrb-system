<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<? $player = $_GET["player"]; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="page_content" style="padding:10px;">
<strong><? echo $player ?> commun IPs</strong>
<script type="text/javascript" src="../../process/js/functions.js?v=2"></script>

	<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/player_commun_ips.php?player=".$player); ?>

</div>