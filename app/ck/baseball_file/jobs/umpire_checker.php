  
<?
  require_once(ROOT_PATH . "/ck/db/handler.php"); 
   require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
   require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
    

    error_reporting(E_ALL);
ini_set('display_errors', 1);


$today = date("Y-m-d");
$today_games =  get_baseball_games_by_date($today);
$umpires = get_all_baseball_umpires("espn_name");

echo "<pre>";


if(!empty($today_games)){

$fields = " team_id,espn_small_name";
$index = "espn_small_name";
$teams =  get_baseball_stadium_custom_fields($fields,$index);
//print_r($umpires); 

$url = 'https://swishanalytics.com/mlb/mlb-umpire-factors'; // Cambiar a la URL real

$html = file_get_html($url);

// Encontrar la tabla
$table = $html->find('table#ump-table', 0);

$data = [];

if ($table) {
    foreach ($table->find('tbody tr') as $row) {
        $cols = $row->find('td');

        if (count($cols) >= 7) {
            $umpireName = trim($cols[0]->plaintext);
            $todayLogos = $cols[1]->find('img');

            if (count($todayLogos) == 2) {
                $awayTeam = strtoupper(trim(pathinfo($todayLogos[0]->src, PATHINFO_FILENAME)));
                $homeTeam = strtoupper(trim(pathinfo($todayLogos[1]->src, PATHINFO_FILENAME)));

                // Extraer datos adicionales
                $games = trim($cols[2]->plaintext);
                $k_pct = trim($cols[3]->plaintext);
                $bb_pct = trim($cols[4]->plaintext);

                $data[] = [
                    'umpire' => $umpireName,
                    'away'   => $awayTeam,
                    'home'   => $homeTeam,
                    'games'  => $games,
                    'k_pct'  => $k_pct,
                    'bb_pct' => $bb_pct
                ];
            }
        }
    }
}

if(!empty($data)){


    
$normalized_array = [];

foreach ($teams as $key => $value) {
    $normalized_key = strtoupper(str_replace(' ', '', $key));
    $normalized_array[$normalized_key] = $value;
}

// Resultado

$teams = $normalized_array;


    $new_array = array();
 foreach ($data as $entry) {
    //echo $entry['team'] . ' / ' . $entry['era'] . "<br>";
       
       // check if the umpires exists and get his id
       if(isset($umpires[$entry['umpire']]->vars['id'])){
        $new_array[$teams[$entry['away']]["team_id"]]['umpire_id'] = $umpires[$entry['umpire']]->vars['id'];
       }
       else {
            $ump = new _baseball_umpire();
            $ump->vars['full_name'] = formatUmpireName($entry['umpire']);
            $ump->vars['espn_name'] = $entry['umpire'];
            $ump->vars['rating'] = "";
            $new_id = $ump->insert();
            $new_array[$teams[$entry['away']]["team_id"]]['umpire_id'] = $new_id;
       }



       $new_array[$teams[$entry['away']]["team_id"]]['away'] = strtoupper(str_replace(' ', '', $entry['away']));
       $new_array[$teams[$entry['away']]["team_id"]]['home'] = strtoupper(str_replace(' ', '', $entry['home']));
       $new_array[$teams[$entry['away']]["team_id"]]['umpire'] = $entry['umpire'];
       $new_array[$teams[$entry['away']]["team_id"]]['games'] = $entry['games'];
       $new_array[$teams[$entry['away']]["team_id"]]['k_pct'] = $entry['k_pct'];
       $new_array[$teams[$entry['away']]["team_id"]]['bb_pct'] = $entry['bb_pct'];
       
      
 }


  if(!empty($new_array)){
    
   foreach ($today_games as $game) {
    
       if(isset($new_array[$game->vars['team_away']]['umpire_id'])){
        $game->vars['umpire'] = $new_array[$game->vars['team_away']]['umpire_id'];
        $game->vars['games'] = $new_array[$game->vars['team_away']]['games'];
        $game->vars['k_pct'] = $new_array[$game->vars['team_away']]['k_pct'];
        $game->vars['bb_pct'] = $new_array[$game->vars['team_away']]['bb_pct'];
        $game->update(array('umpire','games','k_pct','bb_pct'));
         echo "Umpire ".$new_array[$game->vars['team_away']]['umpire']." Updated ID: ".$game->vars['id']." game:".$new_array[$game->vars['team_away']]['away']." VS ".$new_array[$game->vars['team_away']]['home']."<BR>";
       }

     }   

 }   
  

}


}



function formatUmpireName($fullName) {
    $parts = explode(' ', trim($fullName));
    $lastName = strtoupper(array_pop($parts));
    $firstInitial = strtoupper(substr($parts[0], 0, 1));
    return $lastName . ' ' . $firstInitial;
}



?>