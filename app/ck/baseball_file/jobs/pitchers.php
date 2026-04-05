<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
//require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
set_time_limit(0);  
echo "-------------------------<BR>";
echo "      PITCHERS BY TEAM<br>";
echo "--------------------------";




/////// JOB OBSOLETO AHORA ES PIRCHERS_NEW.PHP

$team = get_all_baseball_team();
$players = get_all_baseball_players("fangraphs_player");
$year = date("Y");


foreach ($team as $_team){
	echo        "https://www.fangraphs.com/api/leaders/major-league/data?pos=all&stats=pit&lg=all&qual=0&type=0&season=".$year."&month=0&season1=".$year."&ind=0&team=".$_team["fangraphs_team"]."&players=0&pagenum=1&pageitems=100<BR><BR>";
	$html = file_get_html( "https://www.fangraphs.com/leaders/major-league?pos=all&stats=pit&lg=all&qual=0&type=0&season=".$year."&month=0&season1=".$year."&ind=0&team=".$_team["fangraphs_team"]."&players=0&pagenum=1&pageitems=100"); 
    print_r($html);
	$scripts = $html->find('script');
	foreach($scripts as $s) {
		if (contains_ck($s->innertext,"appProps")){ 
			$json =  "[".$s->innertext;
		}
	}

	$expStr=explode('queries":[',$json);
	unset($expStr[0]);  // Free Memory

	$data = explode(',{"state":{"data":[{"season"',$expStr[1]);
	unset($expStr[1]);  // Free Memory

	$array = json_decode($data[0]);
	$i=0;
	foreach ($array->state->data->data as $player){
		$playeras[$i]['Teamid'] = $player->teamid;
		$playeras[$i]['Team'] = $player->TeamName;
		$playeras[$i]['Player'] = $player->PlayerName;
		$playeras[$i]['Player_id'] = $player->playerid;
		$i++;

	}

    unset($html); // Free Memory
	unset($data); // Free Memory
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

<? } ?>