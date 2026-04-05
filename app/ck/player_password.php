<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>PPH Billing Report</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content">
<span class="page_title">Player Password</span><br /><br />

<div class="form_box" style="width:400px;">
	<? $player = param("player"); ?>
	<form method="get">
    	<input name="player" type="text" id="player" value="<? echo $player ?>" />
        &nbsp;&nbsp;
        <input name="" value="Search" type="submit" />
    </form>

</div>
<br /><br />

<? echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/player_password.php?player=$player"); ?>



</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>