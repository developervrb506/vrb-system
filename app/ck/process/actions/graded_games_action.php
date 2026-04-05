<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? 
$action = $_GET["action"];
$data = $_GET["data"];
$id = $_GET["id"];

// echo "http://www.sportsbettingonline.ag/utilities/process/reports/graded_games_action.php?action=$action&data=$data&id=$id";

 echo @file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/graded_games_action.php?action=$action&data=$data&id=$id"); 	
?>
