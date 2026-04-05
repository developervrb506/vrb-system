<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
 $ac = param('ac');
 $frot = param('frot');
 $trot = param('trot');
 $games = param('games',false);
 $desc = param('desc',false);
 
 $data = "?ac=".$ac."&frot=".$frot."&trot=".$trot."&games=".$games."&desc=".$desc;
 // echo 'http://www.sportsbettingonline.ag/utilities/process/reports/game_description_action.php'.$data;
 echo @file_get_contents('http://www.sportsbettingonline.ag/utilities/process/reports/game_description_action.php'.$data);
?>
