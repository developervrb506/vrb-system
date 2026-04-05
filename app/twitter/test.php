<?
//include("functions.php");

function get_tweets($username, $list){
		
	$response = file_get_contents("https://www.inspin.com/utilities/process/api/twitter?list_id=".$list);
		
	$parsed_json = json_decode($response,true);	
			
	$tweets=array();
	
	if( $parsed_json && $parsed_json != null ){
	
		foreach ($parsed_json as $item){
		   $t_date = $item['created_at'];
		   $id =  $item['id'];
		   $text = $item['text'];		   
		   $source = "";
		   $user_id = $item['author_id'];
		   $image_tweet = $item['profile_image_url'];
		   $followers = $item['followers_count'];	   
		   
		   $new_t = new tweet($id, $text, $source, $t_date, $user_id, $image_tweet);
		   $new_t->followers = $followers;
		   $tweets[] = $new_t;
		}
		
		//return $tweets;
	}
}

//$tweets_lists = get_tweets("inspin", "25928127");

//print_r($tweets_lists);

$response = @file_get_contents("https://www.inspin.com/utilities/process/api/twitter?list_id=25928127");

//$parsed_json = json_decode($response,true);	

echo $response;
?>