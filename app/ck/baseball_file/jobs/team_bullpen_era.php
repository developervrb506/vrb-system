<?php
   require_once(ROOT_PATH . "/ck/db/handler.php"); 
   require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
   require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
    

 error_reporting(E_ALL);
ini_set('display_errors', 1);

$today = date("Y-m-d");
$games =  get_baseball_games_by_date($today);
echo "<pre>";

if(!empty($games)){

$fields = " team_id,covers_team ";
$index = "covers_team";
$teams =  get_baseball_stadium_custom_fields($fields,$index);


// URL a scrapear
$url = 'https://www.covers.com/sport/baseball/mlb/statistics/team-bullpenera/2025';

// Crear contexto con headers para simular navegador real
$options = [
    "http" => [
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n"
    ]
];
$context = stream_context_create($options);

// Obtener HTML con headers
$htmlContent = file_get_contents($url, false, $context);

if ($htmlContent === false) {
    die("Error al obtener el contenido del sitio.");
}

$html = str_get_html($htmlContent);

// Buscar la tabla
$table = $html->find('table#MLB_RegularSeason', 0);

$data = [];

if ($table) {
    foreach ($table->find('tbody tr') as $row) {
        $cols = $row->find('td');
        
        if (count($cols) >= 2) {
            $teamLink = $cols[0]->find('a', 0);
            $team = $teamLink ? trim($teamLink->plaintext) : 'N/A';
            $era = trim($cols[1]->plaintext);
            $data[] = ['team' => $team, 'era' => $era];
        }
    }
}

// Mostrar el resultado
if(!empty($data)){
    $new_array = array();
 foreach ($data as $entry) {
    //echo $entry['team'] . ' / ' . $entry['era'] . "<br>";
       $new_array[$teams[$entry['team']]["team_id"]]['team'] = $entry['team'];
       $new_array[$teams[$entry['team']]["team_id"]]['era'] = $entry['era'];


 }

}

 if(!empty($new_array)){
    foreach ($games as $game) {
        $game->vars['era_away'] = $new_array[$game->vars['team_away']]['era'];
        $game->vars['era_home'] = $new_array[$game->vars['team_home']]['era'];
        $game->update(array('era_away','era_home'));
         echo "Updated ID: ".$game->vars['id']."<BR>";
     }   

 }   
  

}

print_r($new_array);

?>