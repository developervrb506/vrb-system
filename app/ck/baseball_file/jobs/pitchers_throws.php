<?php
   require_once(ROOT_PATH . "/ck/db/handler.php"); 
   require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
   require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
    

 error_reporting(E_ALL);
ini_set('display_errors', 1);
/*

$today = date("Y-m-d");
$games = get_baseball_games_by_date($today);
$control = false;

foreach($games as $game){

       $player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
       
       
       if($player_a->vars['bats']==""){
        $info = getBatThrowInfo($player_a->vars['espn_player']);
        if(!empty($info)){
            $player_a->vars['bats'] = $info['bats'];
            $player_a->vars['throws'] = $info['throws'];
            $player_a->update(array('bats','throws'));
            echo "Player : ".$player_a->vars['espn_player']." Updated<BR>";
            $control = true;
        }

       }


       $player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);

       if($player_h->vars['bats']==""){
        $info = getBatThrowInfo($player_h->vars['espn_player']);
        if(!empty($info)){
            $player_h->vars['bats'] = $info['bats'];
            $player_h->vars['throws'] = $info['throws'];
            $player_h->update(array('bats','throws'));
            echo "Player : ".$player_h->vars['espn_player']." Updated<BR>";
            $control = true;
        }

       }



}


if(!$control){
    echo "<BR><BR>ALL PITCHERS HAS HIS THROWS AND BAT POSITION UPDATED<BR>";
}



function getBatThrowInfo($playerId) {
    $url = "https://www.espn.com/mlb/player/_/id/$playerId";
    $html = file_get_html($url);

    if (!$html) {
        return ['error' => 'No se pudo cargar la página'];
    }

    // Buscar div que contiene BAT/THR
    foreach ($html->find('div') as $div) {
        if (trim($div->plaintext) === 'BAT/THR') {
            $next = $div->next_sibling();
            if ($next) {
                $text = trim($next->plaintext); // Ej: Right/Right, Left/Right
                [$bat, $throw] = explode('/', $text);
                return [
                    'bats' => strtoupper($bat[0]),   // R o L
                    'throws' => strtoupper($throw[0]) // R o L
                ];
            }
        }
    }

    return ['error' => 'No se encontró BAT/THR'];
}*/

$url = 'https://www.espn.com/mlb/boxscore?gameId=401695807';
$resultado = getPitchersFromBoxscore($url);
print_r($resultado);


function getPitchersFromBoxscore($url) {
    $html = file_get_html($url);
    if (!$html) return null;

    $pitchers = [];

    // Buscar todas las secciones de equipo
    $teams = $html->find('div.Boxscore__Team');

    foreach ($teams as $team) {
        $isAway = strpos($team->innertext, 'Astros Pitching') !== false;
        $isHome = strpos($team->innertext, 'Pirates Pitching') !== false;

        // Validar que contenga una tabla con cabecera 'pitchers'
        $tables = $team->find('table');
        foreach ($tables as $table) {
            $th = $table->find('thead tr th', 0);
            if ($th && strtolower(trim($th->plaintext)) === 'pitchers') {
                $row = $table->find('tbody tr', 0);
                if ($row) {
                    $a = $row->find('a', 0);
                    if ($a && preg_match('/\/id\/(\d+)/', $a->href, $matches)) {
                        $label = $isAway ? 'away' : ($isHome ? 'home' : null);
                        if ($label) {
                            $pitchers[$label] = $matches[1];
                            $pitchers["name_$label"] = trim($a->plaintext);
                        }
                    }
                }
            }
        }
    }

    return $pitchers;
}

?>