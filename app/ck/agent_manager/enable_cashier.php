<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>Enable Player Cashier</title>
<script type="text/javascript" src="http://localhost:8080/process/js/functions.js"> </script>
</head>
<body>

<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Enable Player Cashier <? echo $league ?></span><br /><br />

 
 <?
 $player= param('player');
 $op = param('option');
 $data = "?player=".$player."&op=".$op;
 echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/agent_manager/vrb_enable_cashier.php".$data); 
?>


</div>
<? include "../../includes/footer.php" ?>