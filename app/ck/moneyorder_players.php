<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("moneyorder_players")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Moneyorder Players</title>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<br /><br />
<? include "includes/print_error.php" ?>
<?
$params = "";
if(isset($_GET["detail"])){$params .= "?detail";}
if(isset($_GET["cat"])){$params .= "&cat=".$_GET["cat"];}
if(isset($_POST["process"])){$params .= "?process&account=".$_POST["account"]."&deposit=".$_POST["deposit"]."&payout=".$_POST["payout"];}
if(isset($_POST["update_id"])){$params .= "&update_id=".$_POST["update_id"];}
if(isset($_GET["del"])){$params .= "?process&del_id=".$_GET["del"];}

echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_moneyorder_players.php$params"); ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>