<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<title>TEAMS SYSTEM</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= BASE_URL ?>/process/js/functions.js?v=2"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/nba_file/js/functions.js"> </script>
<script type="text/javascript" src="<?= BASE_URL ?>/ck/includes/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
</head>
<body>
<? ini_set('memory_limit', '-1'); ?>
<? include "../../includes/header.php" ?>
<? include "../../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">TEAMS SYSTEM</span><br /><br />

<? $sport = param("sport"); ?>
    <form method="post">
    LEAGUE : <select name="sport">
             <option value="">Select One</option>
             <option <? if ($sport == "NHL") { echo ' selected="selected" ';}?> value="NHL">NHL</option>
             <option <? if ($sport == "NBA") { echo ' selected="selected" ';}?>value="NBA">NBA</option>
             <option <? if ($sport == "NFL") { echo ' selected="selected" ';}?>value="NFL">NFL</option>    
             <option <? if ($sport == "MLB") { echo ' selected="selected" ';}?>value="MLB">MLB</option>             
             <option <? if ($sport == "NCAAF") { echo ' selected="selected" ';}?>value="NCAAF">NCAAF</option>                          
             <option <? if ($sport == "NCAAB") { echo ' selected="selected" ';}?>value="NCAAB">NCAAB</option>                                       
             
             </select>
             &nbsp;&nbsp;
             <input type="submit" value="GO">
   </form>
<?
 if ($sport != ""){
   
   echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_team_system.php?sport=".$sport);  	 
	 
 }
?>


</div>
<? include "../../includes/footer.php" ?>
    
    