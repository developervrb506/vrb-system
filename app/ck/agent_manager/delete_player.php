<? include(ROOT_PATH . "/ck/process/security.php"); ?>
 <?
 // this file manage the delete process for tables / player_enable_cashier and player_access_casino
 
 $player= param('player');


$casino = 0;

// to handle the delete process for Access Casino
if((param('casino') == 1)){
 $casino = 1;	
}

$data = "?player=".$player."&casino=".$casino;


file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/agent_manager/delete_player.php".$data); 

?>


</div>
<? include "../../includes/footer.php" ?>