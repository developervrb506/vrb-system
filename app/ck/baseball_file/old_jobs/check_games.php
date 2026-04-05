<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
set_time_limit(0);

/*
$file = fopen("date_games_start.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$start =  ltrim(fgets($file));
}
fclose($file);

$file = fopen("date_games_end.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$end =  ltrim(fgets($file));
}
fclose($file);
*/


$start = "2011-06-28";
$end = "2011-06-26";


echo "Dates: ".$start. " - ".$end."<BR>"; 


$sbo= get_sbo_games_test($start,$end);
echo "<pre>";
//print_r($sbo);
echo "</pre>";






$inspin_games = get_all_inspin_games($start,$end);
echo "<pre>";
//print_r($inspin_games);
echo "</pre>";



foreach($inspin_games as $igame){

	
	$vars["id"] = $igame->vars["gameid"];
	$vars["league"] = $igame->vars["sportsubtype"];
	$vars["startdate"] = $igame->vars["startdate"];
	$vars["awayrotationnumber"] = $igame->vars["awayrotationnumber"];
	$vars["homerotationnumber"] = $igame->vars["homerotationnumber"];
	$parts = explode(":",$igame->vars["teamid_away"]);
	$igame->vars["teamid_away"];
	$vars["team_away"] = get_team_by_teamid($parts[1],$igame->vars["sportsubtype"]);
	$parts = explode(":",$igame->vars["teamid_home"]);
	$vars["team_home"] = get_team_by_teamid($parts[1],$igame->vars["sportsubtype"]);
	$vars["season"] = $igame->vars["season"];
	$vars["updated"] = $igame->vars["updated"];
	$vars["home_odds"] = $igame->vars["home_odds"];
	$new = new  _sbo_game();
	$new->vars = $vars;
	
	//$check = get_games_by_game($vars["id"]);
	
	if ($sbo[$vars["id"]]-> vars['id'] != $vars["id"]){ 
	  echo "-------------->inserted".$vars["id"]."<BR>";
		   
	if($vars["team_away"]->vars["id"] != "" && $vars["team_home"]->vars["id"] != ""){
	  $new->insert();
	   
	
	//baseball_file
	$basegame = new _sbo_game();
	$basegame->vars["id"] = $new->vars["id"];
	$basegame->vars["startdate"] = $new->vars["startdate"];
	$basegame->vars["away_rotation"] = $new->vars["awayrotationnumber"];
	$basegame->vars["home_rotation"] = $new->vars["homerotationnumber"];
	$basegame->vars["team_away"] = $new->vars["team_away"];
	$basegame->vars["team_home"] = $new->vars["team_home"];
	$basegame->insert_baseball();
	 }
	
	echo $vars["team_away"]->vars["id"]."<br />";
  }
  else{
	  echo "Ya existe".$vars["id"]."<BR>";  
  }
	
}

/*
$start = date ('Y-m-d',strtotime ( '-4 day' , strtotime ($start))) ;	
		$fp = fopen('date_games_start.txt', 'w');
		fwrite($fp, $start);
		fclose($fp);

$end = date ('Y-m-d',strtotime ( '-4 day' , strtotime ($end))) ;	
		$fp = fopen('date_games_end.txt', 'w');
		fwrite($fp, $end);
		fclose($fp);
		
*/

function get_team($id){
	 sbo_sports_db();
	$sql = "SELECT * FROM teams WHERE id = '$id'";
	return get($sql, "_team", true);
}


function get_team_by_teamid($teamid, $league){
	 sbo_sports_db();
	$sql = "SELECT * FROM teams WHERE teamid = '$teamid' AND league = '$league'";
	return get($sql, "_team", true);
}

function get_sbo_games_test($start,$end){
	baseball_db();
	$sql = "SELECT * FROM game where 
    startdate <=  '".$start." 00:00:00' AND
	startdate >=  '".$end." 23:00:00'
	";
	return get($sql,"_sbo_game",false,'id');
}


function get_all_inspin_games($start,$end){
	
	inspinc_statsdb1();
	$sql = "SELECT *
FROM schedule_feed
WHERE sporttype = 'Baseball'
AND sportsubtype = 'mlb'
AND awayrotationnumber !=  ''
AND homerotationnumber !=  ''
AND (startdate <=  '".$start." 00:00:00'
&& startdate >=  '".$end." 23:00:00')
AND teamname_away IS NOT NULL ORDER BY startdate ASC
";	
echo  $sql;  
return get($sql, "_inspin_game");
}

class _sbo_game{
	var $vars = array();
	
	function initial(){
		$this->vars["team_away"] = get_team($this->vars["team_away"]);	
		$this->vars["team_home"] = get_team($this->vars["team_home"]);	
	}	
	function insert(){
		 sbo_sports_db();
		return insert($this, "games");
	}
	function insert_baseball(){
		baseball_db();
		return insert($this, "game");
	}
	
}

class _team{
	var $vars = array();
	function initial(){}
}



?>