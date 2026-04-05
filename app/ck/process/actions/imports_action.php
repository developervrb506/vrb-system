<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
 $ac = param('ac');
 $sport = param('sport');
 
 $data = "?ac=".$ac."&sport=".$sport;
 // echo 'http://www.sportsbettingonline.ag/utilities/process/reports/create_periods_action.php'.$data;
 echo @file_get_contents('http://www.sportsbettingonline.ag/utilities/process/reports/import_action.php'.$data);
?>
