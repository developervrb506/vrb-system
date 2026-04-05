<?php
   require_once(ROOT_PATH . "/ck/db/handler.php"); 
   require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
   require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
    

 error_reporting(E_ALL);
ini_set('display_errors', 1);

$today = date("Y-m-d");
$games = get_baseball_games_by_date($today);
$control = false;

foreach($games as $game){

       $player_a = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_away"]);
       $info = getPlayerStatsFromESPN($player_a->vars['espn_player']);
       print_r($info);
       
        if(!empty($info)){
            if($player_a->vars['bats']==""){
            $player_a->vars['bats'] = $info['bats'];
            $player_a->vars['throws'] = $info['throws'];
            $player_a->update(array('bats','throws'));
            echo "Player : ".$player_a->vars['espn_player']." Updated<BR>";
            $control = true;
          }
           $game->vars['p_away_era_avg'] = $info['ERA'];
           $game->vars['p_away_whip_avg'] =$info['WHIP'];
           $game->update(array('p_away_era_avg','p_away_whip_avg'));

       }
       $player_h = get_baseball_player_by_id("fangraphs_player",$game->vars["pitcher_home"]);

        $info = getPlayerStatsFromESPN($player_h->vars['espn_player']);
        print_r($info);
       
        if(!empty($info)){

        if($player_h->vars['bats']==""){
            $player_h->vars['bats'] = $info['bats'];
            $player_h->vars['throws'] = $info['throws'];
            $player_h->update(array('bats','throws'));
            echo "Player : ".$player_h->vars['espn_player']." Updated<BR>";
            $control = true;
         }

            $game->vars['p_home_era_avg'] = $info['ERA'];
            $game->vars['p_home_whip_avg'] =$info['WHIP'];
            $game->update(array('p_home_era_avg','p_home_whip_avg'));


       }


}


if(!$control){
    echo "<BR><BR>ALL PITCHERS HAS HIS THROWS AND BAT POSITION UPDATED<BR>";
}

//$playerStats = getPlayerStatsFromESPN(3332018); // Tylor Megill



function getPlayerStatsFromESPN($playerId) {
    $url = "https://www.espn.com/mlb/player/splits/_/id/$playerId";
    $html = file_get_html($url);

    if (!$html) {
        return ['error' => 'No se pudo cargar la página'];
    }

    $stats = [
        'bats' => '?',
        'throws' => '?',
        'ERA' => '?',
        'WHIP' => '?'
    ];

    // Bats / Throws
    foreach ($html->find('div') as $div) {
        if (trim($div->plaintext) === 'BAT/THR') {
            $next = $div->next_sibling();
            if ($next) {
                $bt = trim($next->plaintext);
                [$bat, $throw] = explode('/', $bt);
                $stats['bats'] = strtoupper($bat[0]);
                $stats['throws'] = strtoupper($throw[0]);
                break;
            }
        }
    }

    // ERA y WHIP
    foreach ($html->find('.StatBlockInner') as $block) {
        $label = $block->find('.StatBlockInner__Label', 0);
        $value = $block->find('.StatBlockInner__Value', 0);

        if ($label && $value) {
            $text = trim($label->plaintext);
            if ($text === 'ERA') {
                $stats['ERA'] = trim($value->plaintext);
            } elseif ($text === 'WHIP') {
                $stats['WHIP'] = trim($value->plaintext);
            }
        }
    }

    return $stats;
}



?>