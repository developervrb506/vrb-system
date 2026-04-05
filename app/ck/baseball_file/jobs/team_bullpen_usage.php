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

$fields = "id, team_id,mlb_team_cid,UPPER(mlb_team_cid) as 'team' ";
$index = "team_id";
$teams =  get_baseball_stadium_custom_fields($fields,$index);
  //int_r($teams);

 foreach ($teams as $team) { 
   
     $data = get_bullpen_usage_by_team($team['team']);
      //rint_r($data);
     if(!empty($data)){
       $teams[$team['team_id']]['last3_avg'] = $data[$team['team']]['last3_avg'];
       $teams[$team['team_id']]['last5_avg'] = $data[$team['team']]['last5_avg'];

     }
 }

}

 //print_r($teams);
function get_bullpen_usage_by_team($team) {

    $url = "https://www.rotowire.com/baseball/tables/bullpen-usage.php?team=$team";

// Simular navegador con cabeceras
$opts = [
    "http" => [
        "header" => "User-Agent: Mozilla/5.0\r\n"
    ]
];
$context = stream_context_create($opts);

// Obtener contenido
$response = file_get_contents($url, false, $context);

if ($response === false) {
    die("Error al obtener datos");
}

// Decodificar JSON
$data = json_decode($response, true);

// Acceder a los datos del equipo
$players = $data[$team] ?? [];

$sum_last3 = 0;
$sum_last5 = 0;
$count = count($players);

// Calcular sumatorias
foreach ($players as $p) {
    $sum_last3 += (int)($p['last3'] ?? 0);
    $sum_last5 += (int)($p['last5'] ?? 0);
}

// Calcular promedios
$avg_last3 = $count > 0 ? round($sum_last3 / $count, 2) : 0;
$avg_last5 = $count > 0 ? round($sum_last5 / $count, 2) : 0;

// Estructura esperada del array
$resultado = [
    $team => [
        'team' => $team,
        'last3_avg' => $avg_last3,
        'last5_avg' => $avg_last5
    ]
];

return $resultado;

}


/*
// Mostrar el resultado
if(!empty($data)){
    $new_array = array();
 foreach ($data as $entry) {
    //echo $entry['team'] . ' / ' . $entry['era'] . "<br>";
       $new_array[$teams[$entry['team']]["team_id"]]['team'] = $entry['team'];
       $new_array[$teams[$entry['team']]["team_id"]]['era'] = $entry['era'];


 }

*/

 if(!empty($games)){
    foreach ($games as $game) {
        $game->vars['away_last3_avg'] = $teams[$game->vars['team_away']]['last3_avg'];
        $game->vars['away_last5_avg'] = $teams[$game->vars['team_away']]['last5_avg'];
         $game->vars['home_last3_avg'] = $teams[$game->vars['team_home']]['last3_avg'];
        $game->vars['home_last5_avg'] = $teams[$game->vars['team_home']]['last5_avg'];
        $game->update(array('away_last3_avg','away_last5_avg','home_last3_avg','home_last5_avg'));
         echo "Updated ID: ".$game->vars['id']."<BR>";
      //   print_r($game) ;  
      //  break;
     }   

 
 }   

   //break;

//}

//print_r($new_array);

?>