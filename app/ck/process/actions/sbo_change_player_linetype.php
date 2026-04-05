<? require_once(ROOT_PATH . "/ck/process/functions.php"); ?>
<?
$player = param("p");
$linetype = param("t");

echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/change_player_linetype.php?p=$player&t=$linetype"); 

?>