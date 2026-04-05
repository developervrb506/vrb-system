<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
 $ac = param('ac');
 $league = param('league');
 $gametype = param('gt');
 
 $data = "?ac=".$ac."&league=".$league."&gametype=".$gametype;
 //echo 'http://www.sportsbettingonline.ag/utilities/process/reports/import_odds_by_sport.php_action.php'.$data;
 echo @file_get_contents('http://www.sportsbettingonline.ag/utilities/process/reports/import_odds_by_sport.php_action.php'.$data);
?>
