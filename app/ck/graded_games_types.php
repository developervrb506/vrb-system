<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$l = explode("_",$_GET["id"]);
$league = $l[0];
$from = $l[1];

//echo "http://www.sportsbettingonline.ag/utilities/process/reports/graded_games_types.php?from=$from&league=".$league;
echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/graded_games_types.php?from=$from&league=".$league); 

?>

