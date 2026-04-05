<?
header("Access-Control-Allow-Origin: *");   

file_get_contents("http://www.sportsbettingonline.ag/utilities/jobs/games/finished_games.php");

file_get_contents("http://www.sportsbettingonline.ag/utilities/jobs/schedule/scores_special_leagues.php");


file_get_contents("http://vrbmarketing.com/ck/props/jobs/game_log.php");

file_get_contents("http://www.sportsbettingonline.ag/utilities/jobs/games/graded_games.php");


echo json_encode(array("result" => 1));	

?>