<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
 $sport = param("sport");
 $dgs = param("dgs");
 $team =  param("team");


 if($marketing != 1){

 $data = "?sport=".$sport."&dgs=".$dgs."&team=".$team;
 
 file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/vrb_team_system_action.php".$data);
 }
 
 ?>