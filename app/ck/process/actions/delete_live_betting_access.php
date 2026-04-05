<? include(ROOT_PATH . "/ck/process/security.php"); ?>
 <?
 // this file manage the delete process for tables / player_enable_cashier and player_access_casino
 
 $player= param('player');



$data = "?player=".$player;


file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/delete_player_access_live.php".$data); 

?>


</div>
<? include "../../includes/footer.php" ?>