<?
include("functions.php");

function get_tweets_test($username, $list){
	$connection = getConnectionWithAccessToken();
	
	/*echo "<pre>";
	print_r($connection);
	echo "</pre>";*/
		
    $response = $connection->get("https://api.twitter.com/1.1/lists/statuses.json?list_id=".$list."&owner_screen_name=".$username."&count=50");
	//$response = $connection->get("https://api.twitter.com/2/lists/:".$list."/tweets");
	$tweets = json_encode($response);
    $parsed_json = json_decode($tweets,true);
	
	print_r($response);
			
	$tweets=array();
	
	/*if( $parsed_json && $parsed_json != null ){
	
		foreach ($parsed_json as $item){
		   $t_date = $item['created_at'];
		   $id =  $item['id'];
		   $text = $item['text'];
		   $source = $item['source'];
		   $user_id = $item['user']['id'];
		   $image_tweet = $item['user']['profile_image_url'];
		   $followers = $item['user']['followers_count'];	   
		   
		   $new_t = new tweet($id, $text, $source, $t_date, $user_id, $image_tweet);
		   $new_t->followers = $followers;
		   $tweets[] = $new_t;
		}
		
		return $tweets;
	}*/
}


get_tweets_test("inspin", "25928127");

/*function get_list_members_test($username, $list_id, $sport, $team){
	
	$connection = getConnectionWithAccessToken();	
    $response = $connection->get("https://api.twitter.com/1.1/lists/members.json?list_id=".$list_id."&owner_screen_name=".$username."&count=5000");
	$players = json_encode($response);
    $parsed_json = json_decode($players,true);
	
	$players=array();	
	
	foreach ($parsed_json["users"] as $item ){  	   
	  	   
	   $id = $item['id_str'];
	   $account = $item['screen_name'];//Twitter Account
	   $name = $item['name'];
	   $followers = $item['followers_count'];
	   	   
	   $new_p = new twitter_user($id, $name, $account, $team, $sport);
	   
	   $players[] = $new_p;	    
	}
	
	return $players;
}

$players = get_list_members_test("99719608", "99719608", "NBA", "Toronto Raptors");

echo "<pre>";
print_r($players);
echo "</pre>";
*/


/*function remove_members_list($account,$list_id){
	
	$connection = getConnectionWithAccessToken();
			
    $response = $connection->post("https://api.twitter.com/1.1/lists/members/destroy.json?screen_name=".$account."&list_id=".$list_id);
	
	$result = json_encode($response);
    $parsed_json = json_decode($result,true);
			
	return $parsed_json;
}

print_r(remove_members_list("kobebryant","25928127"));


/*function get_inspin_list_members($username, $list_id){
	
	$connection = getConnectionWithAccessToken();	
    $response = $connection->get("https://api.twitter.com/1.1/lists/members.json?list_id=".$list_id."&owner_screen_name=".$username."&count=5000");
	$players = json_encode($response);
    $parsed_json = json_decode($players,true);
	
	foreach ($parsed_json["users"] as $item ){  	   
	   
	   $account = $item['screen_name'];//Twitter Account
	   
	   remove_members_list($account,$list_id);
	   	   	    
	}	
	
}*/

//get_inspin_list_members("inspin", "25928127");

/*function add_members_list($account){
	
	$connection = getConnectionWithAccessToken();	
    $response = $connection->post("https://api.twitter.com/1.1/lists/members/create.json?screen_name=".$account."&list_id=25928127");
	
	$result = json_encode($response);
    $parsed_json = json_decode($result,true);
			
	return $parsed_json;
}

print_r(add_members_list("kobebryant"));*/


/*function get_member_info($account){
	
	$connection = getConnectionWithAccessToken();
			
    $response = $connection->get("https://api.twitter.com/1.1/users/show.json?screen_name=".$account);
	
	$result = json_encode($response);
    $parsed_json = json_decode($result,true);
			
	return $parsed_json;
}

echo "<pre>";

print_r(get_member_info("kobebryant"));

echo "</pre>";*/
?>