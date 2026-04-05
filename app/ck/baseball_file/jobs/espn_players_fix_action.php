<? require_once(ROOT_PATH . "/ck/db/handler.php"); 

$id = $_GET['id'];
$team = $_GET['team_id'];
$espn = $_GET['espn_id'];
$image = $_GET['image'];


function get_baseball_player_test($id){
  baseball_db();
  $sql = "SELECT * FROM player p WHERE id = $id";
  return get($sql, "_baseball_player", true);
}

$player = get_baseball_player_test($id);

if ($player) {
    $player->vars['espn_player'] = $espn;
    $player->vars['espn_team'] = $team;
    $player->vars['image'] = $image;
    $player->update(['espn_player', 'espn_team', 'image']);
    //$player->update(array('espn_player','espn_team','image'));
    http_response_code(200);
} else {
    http_response_code(404);
}


?>
