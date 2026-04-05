<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
 $ac = param('ac');
 $league = param('league');
 $gametype = param('gametype');
 $sport = param('sport');
 $desc = param('desc',false);
 $pos = param('pos');
 $rot = param('rot');
 $ext = param('ext',false);
 $flag = param('flag');
 $p = param('p');
 $games = param('games',false);
 $info = param('info',false);
 $main_league = param('main_league');
 
 $data = "?ac=".$ac."&league=".$league."&sport=".$sport."&desc=".$desc."&pos=".$pos."&rot=".$rot."&ext=".$ext."&flag=".$flag."&p=".$p."&games=".$games."&info=".$info."&gametype=".$gametype."&main_league=".$main_league;
 //echo 'http://www.sportsbettingonline.ag/utilities/process/reports/create_periods_action.php'.$data;
 echo @file_get_contents('http://www.sportsbettingonline.ag/utilities/process/reports/create_periods_action.php'.$data);
?>
