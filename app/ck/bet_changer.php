<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/ajax.js"></script>
<? if($current_clerk->im_allow("graded_games_checker")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="../process/js/functions.js"></script>
<script type="text/javascript" src="../process/js/jquery.js"></script>

<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>

<script type="text/javascript">
Shadowbox.init();
</script>
<script type="text/javascript" src="http://www.sportsbettingonline.ag/utilities/js/validate.js?exp_date=20190716"></script>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<title>Bet Changer</title>

</head>
<body>
	<? $page_style = " width:1450px;"; ?>

<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Bet Changer</span><br /><br />
<? include "includes/print_error.php" ?> 

<?
$rot  = param('rot');
$book  = param('book');
$desc = param('desc');
$odds = param('odds');



 echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/bet_changer.php?rot=$rot&desc=$desc&book=$book&odds=$odds&user=".urlencode($current_clerk ->vars["name"])); 
?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>