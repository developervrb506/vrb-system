<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Enable Live Betting Access</title>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js"> </script>
</head>
<body>

<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Live Betting Access</span><br /><br />

 
 <?

 $str_system = "";
 if (isset($_POST["systems"])){
 
   for ($i=0;$i<$_POST["systems"];$i++){
	   
      if (isset($_POST["system_".$i])){
		  $str_system .= $_POST["system_".$i].",";
	  }
   
   
   }
 	 $str_system = substr($str_system,0,-1);
	
 }
 
 $player= param('player');
 $op = param('option');
 $show_list = param('show_list');
 $data = "?player=".$player."&op=".$op."&str_system=".$str_system."&show_list=".$show_list;
 echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_live_betting_access.php".$data); 
?>


</div>
<? include "../includes/footer.php" ?>