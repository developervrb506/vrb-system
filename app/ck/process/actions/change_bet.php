<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
 $ac = param('ac');
 $msj = param('msj',false);
 $wager_id = param('id');
 $wager_list = param('wlist');
 $rot = param('rot');
 $desc = utf8_decode($_GET['desc']);
 $points = param('point',false);
$odds = param('odds',false);

 $data = "?ac=".$ac."&msj=".$msj."&wid=".$wager_id."&wlist=".$wager_list."&desc=".$desc."&rot=".$rot."&points=".$points."&odds=".$odds."&user=".urlencode($current_clerk ->vars["name"]);

 //echo 'http://www.sportsbettingonline.ag/utilities/process/reports/bet_changer_action.php'.$data;
  echo @file_get_contents('http://www.sportsbettingonline.ag/utilities/process/reports/bet_changer_action.php'.$data);
?>
