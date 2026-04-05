<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 

set_time_limit(0);  
echo "-------------------------<BR>";
echo "      PITCHERS BY TEAM<br>";
echo "--------------------------";

error_reporting(E_ALL);
ini_set('display_errors', 1);


$team = get_all_baseball_team();
$players = get_all_baseball_players("fangraphs_player");
$year = date("Y");

// NOTA POR PROBLEMAS CON CLOUDFLARE SE TUVO Q HACER UN MICROSERVICIO CON NODEJS, PARA GENERAR EL ARCHIVO ,JSON
//D:\websites\www.vrbmarketing.com\ck\baseball_file\jobs\scripts>node scrapper.js

foreach ($team as $_team){

$team_id = $_team["fangraphs_team"];
$json_file = __DIR__ . "/scripts/$team_id.json"; // ajusta la ruta si es diferente

if (file_exists($json_file)) {
    $json_data = file_get_contents($json_file);
    $playeras = json_decode($json_data, true);
} else {
    $playeras = [];
    echo "<!-- ⚠️ Archivo no encontrado: $team_id.json -->";
}
?>
	<BR> <BR>
	<table width="25%" border="1" cellspacing="0" cellpadding="0">
		<tr><? echo $_team["team_name"];?></tr>
		<tr>
			<td class="table_header">ID </td>
			<td class="table_header">Pos</td>
			<td class="table_header">Player</td>
			<? foreach($playeras as $p) {    ?>
				<tr>
					<?
					$player_id = $p['Player_id']	;
					$player_pos = "P";
					$player_name = $p['Player']	;
					if ($player_id != $players[$player_id]->vars["fangraphs_player"]){
		 //echo "NEW: ".$player_id;
						$new_player =  new _baseball_player();
						$new_player->vars["fangraphs_player"] = $player_id;
						$new_player->vars["player"] = $player_name;
						$new_player->vars["espn_nick"] = $player_name;
						$new_player->vars["position"] = $player_pos;
						$new_player->vars["fangraphs_team"] = $_team["fangraphs_team"];
						$new_player->vars["type"] = "pitcher";
						$new_player->insert();   
						$player_name = $player_name." --> NEW PLAYER ";

						$team_player = new _baseball_player_teams();
						$team_player->vars["player"]=$player_id;
						$team_player->vars["team"]=$_team["fangraphs_team"];
						$team_player->vars["season"]=$year;
						$team_player->insert();


					}
					else{

						$team_player = get_baseball_player_by_team("pt.player",$player_id,$_team["fangraphs_team"],$year);

						if (is_null($team_player)) { echo $player_id." Team Updated".$_team["fangraphs_team"]."<BR>";

						$team_player = new _baseball_player_teams();
						$team_player->vars["player"]=$player_id;
						$team_player->vars["team"]=$_team["fangraphs_team"];
						$team_player->vars["season"]= $year;
						$team_player->insert();
						$player_name = $player_name." --> TEAM ADDED";
					}

					$players[$player_id]->vars["fangraphs_team"] = $_team["fangraphs_team"]; 
					$players[$player_id]->vars["position"] = $player_pos;
					$players[$player_id]->vars["type"] = "pitcher";
					$players[$player_id]->update(array("fangraphs_team","position","type"));				   


				}
				?>
				<td style="font-size:12px;"><? echo $player_id ?></td>
				<td style="font-size:12px;"><? echo $player_pos ?></td>
				<td style="font-size:12px;"><? echo $player_name ?></td>
			</tr>
			<?




		} ?>

	</table>

<?  } ?>