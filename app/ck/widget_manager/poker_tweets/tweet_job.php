<? $no_log_page = true; ?>
<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? require_once(ROOT_PATH . "/includes/twitteroauth/twitteroauth.php");

echo "---------------<BR>";
echo "      TWEETS   <br>";
echo "---------------<BR><BR>";


$users = get_wid_all_tweet_user(1);



//$keywords = get_wid_all_tweet_keyword(1);

foreach ($users  as $user){
	
   $last_user_tweet = get_wid_last_uset_tweet($user->vars["id"]);	
   $tweets = $user->get_wid_tweets_user($last_user_tweet["tweet_id"]+1);
     
	/* echo "<pre>";
		print_r($tweets);
	 echo "</pre>";
	*/	

	 
   if (count($tweets) > 0){
     // echo "entra";
	  foreach ($tweets as $tweet) {
		//echo $tweet->vars["created_date"]."   != ".$last_user_tweet["created_date"]."----------------<BR>";
		if ($tweet->vars["created_date"] != $last_user_tweet["created_date"] ){
		// echo "-*-**-*-";
		/* echo "<pre>";
		print_r($tweet);
	    echo "</pre>";*/
		// Insert Tweet	
		$tweet->vars["user_id"] = $user->vars["id"];
	    unset($tweet->vars["twitter_user"]);
	    $tweet->insert();
		
		}

      /*  echo "<pre>";
		print_r($tweet);
	    echo "</pre>";
		*/
		
		// Search Keyword
		/*foreach ($keywords as $keyword){
		   
		   if (contains_ck(strtolower($tweet->vars["tweet"]),strtolower($keyword->vars["keyword"]))){
			 $alert = new _tweet_alert();
			 $alert->vars["tweet"] = $tweet->vars["id"];
	 		 $alert->vars["keyword"] = $keyword->vars["id"];
		     $alert->insert();
		   }
		
		}*/
	 }
   }
    
   else 
   {
	 echo "- User <strong>".$user->vars["name"]."</strong> does not have new Tweets.<BR>";  
   }
  // echo "User ".$user->vars["name"]." does not have new Tweets";  
   
}


