<? include(ROOT_PATH . "/ck/process/security.php"); ?>

<?
 $player = param('player');
 $pre = param('pre');

 fix_duplicate_player($player,$pre); 

 $player = get_baseball_player_by_id('fangraphs_player',$player);
 $pre =  get_baseball_player_by_id('fangraphs_player',$pre);

 
 $player->vars["espn_player"] = $pre->vars["espn_player"];
 $player->vars["image"] = $pre->vars["image"]; 
 $player->update(array("espn_player","image"));
 $pre->delete();
 

function fix_duplicate_player($player,$pre){
    baseball_db();
	$sql = "update player_stadistics_by_game set fangraphs_player = '".$player."' where fangraphs_player = '".$pre."'";
	execute($sql);
    baseball_db();
	$sql = "update player_teams set player = '".$player."' where player = '".$pre."'";
    execute($sql);
    baseball_db();
	$sql = "update game set pitcher_away = '".$player."' where pitcher_away =  '".$pre."'";
	execute($sql);
    baseball_db();
	$sql = "update game set pitcher_home = '".$player."' where pitcher_home =  '".$pre."'";
	return execute($sql);


}


?>