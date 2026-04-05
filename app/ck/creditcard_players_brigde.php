<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("creditcard_players")){ ?>
<?
$arrKeys = array_keys($_GET);

foreach ($arrKeys as $key){	
  $params .= $key."=".$_GET[$key]."&";	
}

file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_sbo_creditcard_players_type.php?".$params); 
?>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>