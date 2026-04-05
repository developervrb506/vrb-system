<?
include("functions.php");
require_once(ROOT_PATH . '/ck/process/functions.php');
inspinc_tweetdb1();
global $mysqli;

function add_member_to_list($account,$list_inpin_id){
	
	$connection = getConnectionWithAccessToken();	
    $response = $connection->post("https://api.twitter.com/1.1/lists/members/create.json?screen_name=".$account."&list_id=".$list_inpin_id);
	
	$result = json_encode($response);
    $parsed_json = json_decode($result,true);
			
	return $parsed_json;
}

function get_players_by_team_sport($username, $list_team_id, $sport, $team, $teamid, $list_inpin_id){
	
	$connection = getConnectionWithAccessToken();	
    $response = $connection->get("https://api.twitter.com/1.1/lists/members.json?list_id=".$list_team_id."&owner_screen_name=".$username."&count=5000");
		
    $players = json_encode($response);
    $parsed_json = json_decode($players,true);
	
	foreach ($parsed_json["users"] as $item){  	   
	  	   
	   $id = $item['id_str'];
	   $account = $item['screen_name'];//Twitter Account
	   $name = mysqli_real_escape_string($mysqli,$item['name']);
	   $followers = $item['followers_count'];
	   
	   //Add player to inspin twitter list
	   
	   add_member_to_list($account,$list_inpin_id); 
	   
	   //Add player to twitter db
	   
	   $cant = check_exist_member($id);
	   
	   //echo $cant;
	      
	   if ($cant == 0){
	   
		   $insert = "INSERT INTO twitter_members(id, sport, name, account, team, teamid, followers)
					  VALUES (". $id .", '". $sport ."', '". $name ."', '". $account ."', '". $team ."', '". $teamid ."', '". $followers ."')";	   
							  
	       $res_insert = mysqli_query($mysqli,$insert) or die(mysqli_error($mysqli));	   
	   }	   	    
	}	
	
}

get_players_by_team_sport("MiamiDolphins", "72905405", "NFL", "Miami Dolphins", "/sport/football/team:9", "25928058");
?>