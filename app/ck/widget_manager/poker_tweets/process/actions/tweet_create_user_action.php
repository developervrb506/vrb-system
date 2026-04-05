<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tweets")){ ?>
<?
require_once(ROOT_PATH . "/includes/twitteroauth/twitteroauth.php");
$user = new _wid_tweet_user();

$user->vars["name"] = clean_get("name");
$user->vars["user"] = str_replace("@","",clean_get("user"));
//$user->vars["user"] = clean_get("user");
$user->vars["added_date"] = date("Y-m-d");


if(isset($_POST["update_id"])){
	$user->vars["available"] = $_POST["available"];
	$user->vars["id"] = clean_get("update_id");
	$user->update();
	header("Location: ../../tweet_user.php?e=6");
}else{
	
	$user->vars["available"] = 1;
	$user->vars["type"] = clean_get("type");
	$user->insert();
	
	$tweets = $user->get_wid_tweets_user(0,true);
	
	/*echo "------<BR><BR><BR><BR>";
	echo "<pre>";
	print_r($tweets);
	echo "</pre>";*/
 	
	if (!is_null($tweets[0]->vars["tweet_id"])) {
	 
	   $user->vars["twitter_id"] = $tweets[0]->vars["twitter_user"];
	   $user->update(array("twitter_id"));
	   $tweets[0]->vars["user_id"] = $user->vars["id"];
	    unset($tweets[0]->vars["twitter_user"]);
	   $tweets[0]->insert();
	 }else{
	  header("Location: ../../tweet_user.php?e=89");	 
	 }
	
	 header("Location: ../../tweet_user.php?e=7");
}
?>
<? }else{echo "Access Denied";} ?>

