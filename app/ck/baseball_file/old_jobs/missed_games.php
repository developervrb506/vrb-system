<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
set_time_limit(0);


$start = "2011-06-28";
$end = "2011-06-26";


echo "Dates: ".$start. " - ".$end."<BR>"; 


//$sbo= get_sbo_games_test($start,$end);
echo "<pre>";
//print_r($sbo);
echo "</pre>";






$inspin_games = get_all_missed_inspin_games_1();
echo "<pre>";
//print_r($inspin_games);
echo "</pre>";



foreach($inspin_games as $igame){

	
	$vars["id"] = $igame->vars["id"];
	$vars["gameid"] = $igame->vars["gameid"];
	$vars["startdate"] = $igame->vars["startdate"];
	$vars["awayrotationnumber"] = $igame->vars["awayrotationnumber"];
	$vars["homerotationnumber"] = $igame->vars["homerotationnumber"];
	$vars["teamid_away"] = $igame->vars["teamid_away"];
	$vars["teamid_home"] = $igame->vars["teamid_home"];
	$vars["teamname_away"] = $igame->vars["teamname_away"];
	$vars["teamname_home"] = $igame->vars["teamname_home"];
	$parts = explode(":",$igame->vars["teamid_away"]);
	$igame->vars["teamid_away"];
	$vars["team_away"] = get_team_by_teamid($parts[1],$igame->vars["sportsubtype"]);
	$parts = explode(":",$igame->vars["teamid_home"]);
	$vars["team_home"] = get_team_by_teamid($parts[1],$igame->vars["sportsubtype"]);
	$vars["season"] = $igame->vars["season"];
	$new = new  _missed_games();
	$new->vars = $vars;
	$new->insert();
	
	
}


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


function get_all_missed_inspin_games(){
	
	inspinc_statsdb1();
	$sql = "SELECT DISTINCT * 
FROM schedule_feed
WHERE sporttype =  'Baseball'
AND sportsubtype =  'mlb'
AND startdate >  '2010-12-31 21:05:00'
AND (
teamname_away
IN ('Rick',  'Brian',  'Halladay',  'Matt',  'Johnny',  'Justin',  'Jhoulys',  'Jair',  'Livan',  'Bruce',  'Hiroki',  'Wade',  'Roy',  'Javier',  'Brett',  'Zachary'
) || teamname_away IS NULL
)
ORDER BY  `schedule_feed`.`startdate` DESC
";	

return get($sql, "_inspin_game");
}

function get_all_missed_inspin_games_1(){
	
	inspinc_statsdb1();
	$sql = "SELECT DISTINCT * 
FROM schedule_feed
WHERE sporttype =  'Baseball'
AND sportsubtype =  'mlb'
AND startdate >  '2012-12-31 21:05:00'
AND startdate <  '2013-07-14 00:05:00'
AND ( awayrotationnumber =  '' ||  homerotationnumber =  '' )
ORDER BY  `schedule_feed`.`startdate` DESC
";	

return get($sql, "_inspin_game");
}




class _missed_games{
	var $vars = array();
	
	function initial(){
	$this->vars["team_away"] = get_team($this->vars["team_away"]);	
	$this->vars["team_home"] = get_team($this->vars["team_home"]);		
	}	
	function insert(){

		baseball_db();
		return insert($this, "missed_games");
	}
	
}

class _team{
	var $vars = array();
	function initial(){}
}



?>