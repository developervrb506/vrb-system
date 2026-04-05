<?
//require_once("/home/inspinc/public_html/wp-includes/class-phpmailer.php");
include("classes.php");
require_once("includes/twitteroauth/twitteroauth/twitteroauth.php");

/*Important Functions*/
/*------------------------------------------------------------------------------------------------------------------------------------------------*/
function get_more_tweets_player($league, $team){
	$max = -1;
	$max_player = NULL;
	$list = get_list_by_name($league);
	$xml = $list->get_xml();
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT id, position, name, account FROM twitter_members WHERE teamid = '$team'";										 
	$res = mysqli_query($mysqli,$sql);						 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $id = $info['id'];
	  $sport = $info['sport'];
	  $position = $info['position'];
	  $name = $info['name'];
	  $account = $info['account'];
	  $teamid = $info['teamid'];
	  $count = substr_count($xml, $id);
	  if($count > $max){
		  $player =  new twitter_user($id, $name, $account, $teamid, $sport, $position);
		  $max = $count;
		  $max_player = $player;
	  }
	}
	return $max_player;
}
function get_members_lists_by_customer($cus_id){
	inspinc_tweetdb1();
	global $mysqli;
	$sql = "SELECT DISTINCT tl.id, tl.name, tl.description, tl.server FROM twitter_list as tl, tweets_per_customer as tc,twitter_members as tm 
				WHERE  customer_id = $cus_id AND type = 'player' AND type_id = tm.id AND tm.sport = tl.name";  
					  
	$sql_res = mysqli_query($mysqli,$sql);
	$lists = array();
	while ($info = mysqli_fetch_array($sql_res,MYSQLI_ASSOC)) {  
	  $id = $info['id'];
	  $desc = $info['description'];
	  $name = $info['name'];
	  $server = $info['server'];
	  $lists[] = new twitter_list($id, $name, $desc, "", $server);
	}
	return $lists;
}
function get_current_customer(){
	inspinc_insider();
	global $mysqli;
	$sql = "SELECT id, firstname, lastname, total_points, admin FROM customers
			WHERE username = '".$_COOKIE['myinspin-customer']."'";				  
					  
	$sql_res = mysqli_query($mysqli,$sql);
	$inspin_customer = NULL;
	if ($info = mysqli_fetch_array($sql_res,MYSQLI_ASSOC)) {  
	  $total_points =  $info['total_points'];
	  $id_customer = $info['id'];
	  $is_admin = $info['admin'];
	  $firstname = $info['firstname'];
	  $lastname = $info['lastname'];
	  $inspin_customer = new customer($id_customer, $firstname . " " . $lastname, $_COOKIE['myinspin-customer'], $total_points, $is_admin);
	}
	return $inspin_customer;
}
function get_customer_by_name($name){
	inspinc_insider();
	global $mysqli;
	$sql = "SELECT id, firstname, lastname, total_points, admin FROM customers
			WHERE username = '".$name."'";				  
					  
	$sql_res = mysqli_query($mysqli,$sql);
	$inspin_customer = NULL;
	if ($info = mysqli_fetch_array($sql_res,MYSQLI_ASSOC)) {  
	  $total_points =  $info['total_points'];
	  $id_customer = $info['id'];
	  $is_admin = $info['admin'];
	  $firstname = $info['firstname'];
	  $lastname = $info['lastname'];
	  $inspin_customer = new customer($id_customer, $firstname . " " . $lastname, $name, $total_points, $is_admin);
	}
	return $inspin_customer;
}
/*function send_email($email, $sub, $content){
	$mail = new PHPMailer();	
	$mail->From     = 'support@inspin.com';
	$mail->FromName = 'Inspin.com';
	$mail->AddAddress($email, $sub); 
	$mail->Username = 'andyh@inspin.com'; 
	$mail->Password = 'sbomike160412';
	$mail->Host     = '192.168.1.15';
	$mail->Mailer   = 'smtp';
	$mail->IsHTML(true);
		
	if($mail->Mailer == 'smtp') {
	   $mail->SMTPAuth = true;
	}
		
	$mail->Subject = $sub;  	
	
	$mail->Body = stripslashes($content);
	$mail->Send();
}
*/
function send_email($email, $sub, $content){
		$headers = 'From: Inspin <support@inspin.com>' . "\r\n" .
		'Reply-To: support@inspin.com' . "\r\n";		
		if (@mail($email, $sub, $content, $headers)) {} else {}		
}
function search_member($param){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT id, sport, teamid, position, name, account FROM twitter_members WHERE name LIKE '%$param%'";										 
	$members = array();
	$res = mysqli_query($mysqli,$sql);						 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $id = $info['id'];
	  $sport = $info['sport'];
	  $position = $info['position'];
	  $name = $info['name'];
	  $account = $info['account'];
	  $teamid = $info['teamid'];
	  $members[] = new twitter_user($id, $name, $account, $teamid, $sport, $position);
	}
	return $members;
}
function search_team($param){
	inspinc_statsdb1();
	global $mysqli;
	$sql =  "SELECT DISTINCT sporttype, sportsubtype, teamid, teamnamefirst, teamnamenick, teamnameshort, small_logo, big_logo
				FROM teams_feed WHERE small_logo != '' AND (teamnamefirst LIKE '%$param%' OR  teamnamenick LIKE '%$param%')";										 	$teams = array();
	$res = mysqli_query($mysqli,$sql);						 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $sport = $info['sporttype'];
	  $league = $info['sportsubtype'];
	  $id = $info['teamid'];
	  $nick = $info['teamnamenick'];
	  $name = $info['teamnamefirst'];
	  $short = $info['teamnameshort'];
	  $slogo = $info['small_logo'];
	  $blogo = $info['big_logo'];
	  $teams[] = new team($id, $name, $nick, $short, $sport, $league, $slogo, $blogo);
	}
	return $teams;
}
function get_team_by_id($id){
	inspinc_statsdb1();
	global $mysqli;
	$sql =  "SELECT sporttype, teamnamefirst, sportsubtype, teamnamenick, teamnameshort, small_logo, big_logo
				FROM teams_feed WHERE teamid = '$id'";										 
	$res = mysqli_query($mysqli,$sql);						 
	if($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $sport = $info['sporttype'];
	  $league = $info['sportsubtype'];
	  $nick = $info['teamnamenick'];
	  $name = $info['teamnamefirst'];
	  $short = $info['teamnameshort'];
	  $slogo = $info['small_logo'];
	  $blogo = $info['big_logo'];
	}
	$team = new team($id, $name, $nick, $short, $sport, $league, $slogo, $blogo);
	return $team;
}
function get_all_teams_twitter($league){
	inspinc_statsdb1();
	global $mysqli;
	$sql =  "SELECT sporttype, teamid, teamnamefirst, teamnamenick, teamnameshort, small_logo, big_logo
			 FROM teams_feed WHERE small_logo != '' AND sportsubtype = '" . strtolower($league) . "' ORDER BY teamnamenick ASC";										 
	$res = mysqli_query($mysqli,$sql);	
	$teams = array();					 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $sport = $info['sporttype'];
	  $id = $info['teamid'];
	  $nick = $info['teamnamenick'];
	  $name = $info['teamnamefirst'];
	  $short = $info['teamnameshort'];
	  $slogo = $info['small_logo'];
	  $blogo = $info['big_logo'];
	  $teams[] = new team($id, $name, $nick, $short, $sport, $league, $slogo, $blogo);
	}
	return $teams;
}
function get_all_teams_with_players($league){
	inspinc_statsdb1();
	global $mysqli;
	$sql =  "SELECT sporttype, teamid, teamnamefirst, teamnamenick, teamnameshort, small_logo, big_logo
			 FROM teams_feed WHERE small_logo != '' AND sportsubtype = '" . strtolower($league) . "' ORDER BY teamnamefirst ASC";										 
	$res = mysqli_query($mysqli,$sql);	
	$teams = array();					 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $sport = $info['sporttype'];
	  $id = $info['teamid'];
	  $nick = $info['teamnamenick'];
	  $name = $info['teamnamefirst'];
	  $short = $info['teamnameshort'];
	  $slogo = $info['small_logo'];
	  $blogo = $info['big_logo'];
	  $players_num = count(get_members_by_team($id));
	  if($players_num > 0){
	  	$teams[] = new team($id, $name, $nick, $short, $sport, $league, $slogo, $blogo);
	  }
	}
	return $teams;
}
function get_teamname($id){
	$result = $id;
	$pos = strpos($id, "/sport/");
	if(!($pos === false)){
		inspinc_statsdb1();
		global $mysqli;
		$sql =  "SELECT teamnamefirst, teamnamenick FROM teams_feed WHERE teamid = '$id';";										 
		$res = mysqli_query($mysqli,$sql);						 
		if ($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
		  $name = $info['teamnamefirst'];
		  $nick = $info['teamnamenick'];
		}
		$result = "$name $nick";
		if($name == "" && $nick == ""){$result = $id;}
	}
	return $result;
}
function get_list_by_name($name){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT * FROM twitter_list WHERE name = '$name';";										 
	$res = mysqli_query($mysqli,$sql);						 
	if ($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $id = $info['id'];
	  $desc = $info['description'];
	  $url = $info['url'];
	  $server = $info['server'];
	}
	$list = new twitter_list($id, $name, $desc, $url, $server);
	return $list;
}
function get_list_by_id($id){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT * FROM twitter_list WHERE id = $id;";										 
	$res = mysqli_query($mysqli,$sql);						 
	if ($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $name = $info['name'];
	  $desc = $info['description'];
	  $url = $info['url'];
	  $server = $info['server'];
	}
	$list = new twitter_list($id, $name, $desc, $url, $server);
	return $list;
}
function get_all_lists(){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT * FROM twitter_list";										 
	$res = mysqli_query($mysqli,$sql);	
	$lists = array();					 
	while ($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $id = $info['id'];
	  $desc = $info['description'];
	  $name = $info['name'];
	  $url = $info['url'];
	  $server = $info['server'];
	  $lists[] = new twitter_list($id, $name, $desc, $url, $server);
	} 
	return $lists;
}
function get_members_by_league($league){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT id, team, teamid, position, name, account FROM twitter_members WHERE sport= '$league' ORDER BY name ASC";										 
	$res = mysqli_query($mysqli,$sql);
	$members = array();						 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $id = $info['id'];
	  $position = $info['position'];
	  $name = $info['name'];
	  $account = $info['account'];
	  $teamid = $info['teamid'];
	  if($teamid == ""){$teamid = $info['team'];}
	  $members[] = new twitter_user($id, $name, $account, $teamid, $league, $position);
	}
	return $members;
}
function get_members_by_team($teamid){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT id, sport, position, name, account FROM twitter_members WHERE teamid = '$teamid' ORDER BY name ASC";										 
	$res = mysqli_query($mysqli,$sql);
	$members = array();						 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $sport = $info['sport'];
	  $id = $info['id'];
	  $position = $info['position'];
	  $name = $info['name'];
	  $account = $info['account'];
	  $members[] = new twitter_user($id, $name, $account, $teamid, $sport, $position);
	}
	return $members;
}
function get_members_ids_by_team($teamid){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT id FROM twitter_members WHERE teamid = '$teamid'";										 
	$res = mysqli_query($mysqli,$sql);
	$members = array();						 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $members[] = $info['id'];
	}
	return $members;
}
function get_members_ids_by_team_name($team){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT id FROM twitter_members WHERE team = '$team'";										 
	$res = mysqli_query($mysqli,$sql);
	$members = array();						 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $members[] = $info['id'];
	}
	return $members;
}
function get_members_by_customer($cus_id){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT tm.id, sport, team, teamid, position, name, account FROM twitter_members as tm, tweets_per_customer 
				WHERE customer_id = $cus_id AND type = 'player' AND type_id = tm.id";										 
	$res = mysqli_query($mysqli,$sql);
	$members = array();						 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $sport = $info['sport'];
	  $id = $info['id'];
	  $position = $info['position'];
	  $name = $info['name'];
	  $account = $info['account'];
	  $teamid = $info['teamid'];
	  if($teamid == ""){$teamid = $info['team'];}
	  $members[] = new twitter_user($id, $name, $account, $teamid, $sport, $position);
	}
	return $members;
}
function get_members_ids_by_customer($cus_id){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT tm.id FROM twitter_members as tm, tweets_per_customer 
			 WHERE customer_id = $cus_id AND type = 'player' AND type_id = tm.id";										 
	$res = mysqli_query($mysqli,$sql);
	$members = array();						 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $members[] = $info['id'];
	}
	return $members;
}
function get_lists_by_customer($cus_id){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT tl.id, name, description, url, server FROM twitter_list as tl, tweets_per_customer 
			 WHERE customer_id = $cus_id AND type = 'league' AND type_id = tl.id";										 
	$res = mysqli_query($mysqli,$sql);
	$lists = array();						 
	while($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $id = $info['id'];
	  $desc = $info['description'];
	  $name = $info['name'];
	  $url = $info['url'];
	  $server = $info['server'];
	  $lists[] = new twitter_list($id, $name, $desc, $url, $server);
	}
	return $lists;
}
function get_member_by_id($id){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT sport, team, teamid, position, name, account FROM twitter_members WHERE id = $id";										 
	$res = mysqli_query($mysqli,$sql);						 
	if ($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $sport = $info['sport'];
	  $position = $info['position'];
	  $name = $info['name'];
	  $account = $info['account'];
	  $teamid = $info['teamid'];
	  if($teamid == "" || $teamid == " "){$teamid = $info['team'];}
	}
	$member = new twitter_user($id, $name, $account, $teamid, $sport, $position);
	return $member;
}
function check_exist_member($id){
	inspinc_tweetdb1();
	global $mysqli;
	$sql =  "SELECT count(*) as cant FROM twitter_members WHERE id = $id";										 
	$res = mysqli_query($mysqli,$sql);
							 
	if ($info = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
	  $cant = $info['cant'];	  
	}
	
	return $cant;
}


function getConnectionWithAccessToken() {
$cons_key = "U2Y2eR7ptGuYeC5l5UprT6Ls0";
$cons_secret = "OoUPLZ72Si8CnM6RPvq5SLxNWjYmxp1gPjQfis8xJh7cTKELfC";
$oauth_token = "47371649-VidKi2Wt55GO1sG5wlEiI7L1FJ6tEBMKs0mBQD3EY";
$oauth_token_secret = "pxKhgdPOrSoaYSsc4P5L7BozEPr1rMoh6zA7dftWnUZ8l";
  
$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
return $connection;
}


function get_tweets($username, $list){
			
	$response = @file_get_contents("https://www.inspin.com/utilities/process/api/twitter?list_id=".$list);
	$tweets=array();
		
	if($response != ""){
			
		$parsed_json = json_decode($response,true);	
				
		//$tweets=array();
		
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
			
			return $tweets;
		}
		
	}else{
		return $tweets;
	}
}


/*
 function get_tweets_bkp($username, $list){
	$result = file_get_contents("http://api.twitter.com/1/". $username ."/lists/". $list ."/statuses.xml?per_page=50");
	$dom = new DomDocument();
	$dom->loadXML($result);
	$tweets=array();
	$items = $dom->getElementsByTagName('status'); 
	foreach( $items as $item ) {
		$t_date = $item->getElementsByTagName("created_at");
		$t_date = $t_date->item(0)->nodeValue;
		
		$id = $item->getElementsByTagName("id");
		$id = $id->item(0)->nodeValue;
		
		$text = $item->getElementsByTagName("text");
		$text = $text->item(0)->nodeValue;
		
		$source = $item->getElementsByTagName("source");
		$source = $source->item(0)->nodeValue;
		
		$user = $item->getElementsByTagName("user");
		$user = $user->item(0);
		
		$user_id = $user->getElementsByTagName("id");
		$user_id = $user_id->item(0)->nodeValue;
		
		$image_tweet = $user->getElementsByTagName("profile_image_url");
		$image_tweet = $image_tweet->item(0)->nodeValue;
		
		$tweets[] = new tweet($id, $text, $source, $t_date, $user_id, $image_tweet);
	}
	return $tweets;	
}
*/


function get_lists($user_name){
	$result = @file_get_contents("http://api.twitter.com/1/". $user_name ."/lists.xml");
	$dom = new DomDocument();
	$dom->loadXML($result);
	$found = false;
	$lists=array();
	$items = $dom->getElementsByTagName('list'); 
	foreach( $items as $item ) {
		$list_id = $item->getElementsByTagName("id");
		$list_id = $list_id->item(0)->nodeValue;
		
		$list_name = $item->getElementsByTagName("name");
		$list_name = $list_name->item(0)->nodeValue;
		
		$list_description = $item->getElementsByTagName("description");
		$list_description = $list_description->item(0)->nodeValue;
		
		$list_url = $item->getElementsByTagName("uri");
		$list_url = $list_url->item(0)->nodeValue;
		
		$lists[] = new twitter_list($list_id, $list_name, $list_description, $list_url);
	}
	return $lists;
}
function get_list_members($username, $list_id, $cursor = -1){
	$result = @file_get_contents("http://api.twitter.com/1/". $username ."/". $list_id ."/members.xml?cursor=" . $cursor);
	$dom = new DomDocument();
	@$dom->loadXML($result);
	$users=array();
	$items = $dom->getElementsByTagName('user'); 
	foreach( $items as $item ) {
		$id = $item->getElementsByTagName("id");
		$id = $id->item(0)->nodeValue;
		
		$name = $item->getElementsByTagName("name");
		$name = $name->item(0)->nodeValue;
		$name = str_replace("'","",$name);
		
		$screen = $item->getElementsByTagName("screen_name");
		$screen = $screen->item(0)->nodeValue;
		
		$users[] = new twitter_user($id, $name, $screen, "", $list_id, "");
	}
	$next_cursor = $dom->getElementsByTagName('next_cursor');
	$next_cursor = $next_cursor->item(0)->nodeValue;
	if($next_cursor != 0){
		$users = array_merge($users, get_list_members($username, $list_id, $next_cursor));
	}
	return $users;
}
function generate_xmls($list){
		
	$tweets_lists = get_tweets("inspin", $list);
	
	if(count($tweets_lists) > 0){
	
		for($i=count($tweets_lists)-1;$i > -1; $i--){
			if($tweets_lists[$i]->id != ""){
				$tweet_date = explode("T",$tweets_lists[$i]->t_date);
				$t_date = $tweet_date[0];
				$t_time = explode(".",$tweet_date[1]);
				
				$t_time = $t_time[0];	
									
				$tweet_date = $t_date." ".$t_time;						
				print_tweets_xml($list, $tweets_lists[$i]->id, $tweets_lists[$i]->text, $tweets_lists[$i]->source, $tweet_date, $tweets_lists[$i]->user_id, $tweets_lists[$i]->user_image);
			}
		}
	
	}
}
function print_tweets_xml($list_id, $id, $text, $source, $date, $user_id, $image){
	echo $list_id."<BR>";
    echo $id."<BR>";
	echo $text."<BR>";
	echo $source."<BR>";
	echo $date."<BR>";
	echo $user_id."<BR>";		
	echo $image."<BR>";	
	
	$node = "  <tweet>\n";
	$node .= "    <id>". $id ."</id>\n";
	$node .= "    <text>". $text ."</text>\n";
	$node .= "    <source>". /*$source*/ "</source>\n";	
	$node .= "    <date>". $date ."</date>\n";
	$node .= "    <user>". $user_id ."</user>\n";
	$node .= "    <image>". $image ."</image>\n";
	$node .= "  </tweet>\n";
	$node = str_replace("&","&#38;",$node);
	
	//NFL2 Patch
	/*if($list_id == 42747650){
		$list_id = 25928058;
		add_node($node, $list_id . "_full", 500);	
		add_node($node, $list_id . "_list", 100);			
	}else{		
		add_node($node, $list_id . "_list", 100);
		add_node($node, $list_id . "_full", 500);
	}*/
	
	add_node($node, $list_id . "_list", 100);
	add_node($node, $list_id . "_full", 500);	
	add_node($node, $user_id, 25);
}
function add_node($node, $file_name, $limit){
	$file_name = "xml/$file_name.xml";
	if(!file_exists($file_name)){
		$fh = fopen($file_name, "w+");
		fwrite($fh, "<tweets>\n</tweets>");
		fclose($fh);
	}
	$content = @file_get_contents($file_name);
	$pos = strpos($content, $node);
	if ($pos === false) {
		
		$number = substr_count($content,"</tweet>");
		
		if($number > $limit){
			$content = strstr($content, "</tweet>");
			$content = "<tweets>" . substr($content,8);
		}
		
		$content = str_replace("</tweets>","",$content);
		$fh = fopen($file_name, 'w+') or die("can't open file");
		
		/*if (flock($fh, LOCK_EX)) { // realiza un bloqueo exclusivo
			ftruncate($fh, 0); // truncar el archivo*/
			
			fwrite($fh, $content);
			fwrite($fh, $node);
			fwrite($fh, "</tweets>");
		
			/*flock($fh, LOCK_UN); // libera el bloqueo
		} else {
			echo "¡No se pudo obtener el bloqueo!";
		}
		*/
		fclose($fh);
	}
}
function get_remaining_hits(){
	$result = @file_get_contents("http://api.twitter.com/1/account/rate_limit_status.xml");
	$dom = new DomDocument();
	$dom->loadXML($result);
	$items = $dom->getElementsByTagName('hash'); 
	$hits = 0;
	foreach( $items as $item ) {
		$remaining_hits = $item->getElementsByTagName("remaining-hits");
		$remaining_hits = $remaining_hits->item(0)->nodeValue;
		$hits = $remaining_hits;
	}
	return $hits;
}
function print_limit(){
	$result = file_get_contents("http://api.twitter.com/1/account/rate_limit_status.xml");
	$dom = new DomDocument();
	$dom->loadXML($result);
	$items = $dom->getElementsByTagName('hash'); 
	foreach( $items as $item ) {
		$hourly_limit = $item->getElementsByTagName("hourly-limit");
		$hourly_limit = $hourly_limit->item(0)->nodeValue;
		
		$reset_time_sec = $item->getElementsByTagName("reset-time-in-seconds");
		$reset_time_sec = $reset_time_sec->item(0)->nodeValue;
		
		$reset_time = $item->getElementsByTagName("reset-time");
		$reset_time = $reset_time->item(0)->nodeValue;
		
		$remaining_hits = $item->getElementsByTagName("remaining-hits");
		$remaining_hits = $remaining_hits->item(0)->nodeValue;
	}
	echo "Hourly Limit: <strong>$hourly_limit</strong><br /><br />";
	echo "Reset Time: <strong>". date("D, M j / h:i:s A", $reset_time_sec) ."</strong><br /><br />";
	echo "Current Server Time: <strong>". date("D, M j / h:i:s A") ."</strong><br /><br />";
	echo "Remaining Hits: <strong style='color:#900; font-size:20px;'>$remaining_hits</strong><br /><br />";
	echo '<a href="javascript:location.reload(true)">Refresh Data</a>';
}



/*Construction Function*/
/*-------------------------------------------------------------------------------------------------*/
/*function print_tweets($list_id){
	$user_lists = get_tweets("inspin", $list_id);
	$count = 1;
	for($i=0;$i < count($user_lists); $i++){
		if($user_lists[$i]->id != ""){
			echo "$count - :" . $user_lists[$i]->id . " - " . $user_lists[$i]->text . " - " . $user_lists[$i]->source . " - " . $user_lists[$i]->t_date . " - " . $user_lists[$i]->user_id . "<br /><br />";
			$count++;
		}
	}
}
function print_list_members($list_id){
	$user_lists = get_list_members("inspin",$list_id);
	$count = 1;
	for($i=0;$i < count($user_lists); $i++){
		if($user_lists[$i]->id != ""){
			echo "$count - :" . $user_lists[$i]->id . " - " . $user_lists[$i]->name . " - " . $user_lists[$i]->screen_name . "<br /><br />";
			$count++;
		}
	}
}
function update_twitter_id_from_account($list_id){
	inspinc_tweetdb1();
	$user_lists = get_list_members("inspin",$list_id);
	for($i=0;$i < count($user_lists); $i++){
		if($user_lists[$i]->id != ""){
			$insert = "UPDATE twitter_news SET id_twitter = " . $user_lists[$i]->id . " WHERE account = '" . $user_lists[$i]->screen_name . "'";
			$res = mysql_query($insert)
								or die(mysql_error());
		}
	}
}
function update_twitter_if_from_name($list_id){
	inspinc_tweetdb1();
	$user_lists = get_list_members("inspin", $list_id);
	for($i=0;$i < count($user_lists); $i++){
		if($user_lists[$i]->id != ""){
			$insert = "UPDATE twitter_news SET id_twitter = " . $user_lists[$i]->id . ", account = '" . $user_lists[$i]->screen_name . "'
								WHERE player_name = '". $user_lists[$i]->name ."' AND id_twitter = 0";
				$res = mysql_query($insert)
								or die(mysql_error());
		}
	}
}
function insert_players_old($list_id){
	inspinc_tweetdb1();
	$user_lists = get_list_members("inspin", $list_id);
	for($i=0;$i < count($user_lists); $i++){
		if($user_lists[$i]->id != ""){
			
			$gameid_sql =  "SELECT COUNT(*) as cant FROM twitter_news 
									WHERE id_twitter = ". $user_lists[$i]->id ." AND account = '". $user_lists[$i]->screen_name ."'";				  
													 
			$gameid_sql_res = mysql_query($gameid_sql);
								   
			 while ($gameid_info = mysql_fetch_array($gameid_sql_res)) {
				$cant = $gameid_info['cant'];	
			 }
			 if($cant == 0){
				 $insert = "INSERT INTO twitter_news(id_twitter, sport, player_name, account, private)
							  VALUES (". $user_lists[$i]->id .", 'NBA', '". $user_lists[$i]->name ."', '". $user_lists[$i]->screen_name ."', 'NO')";
								  
			  $res = mysql_query($insert)
							  or die(mysql_error());
			 }
		}
	}
}
function transfer_data($sport){
	inspinc_tweetdb1();
			
	$gameid_sql =  "SELECT account, team, player_position FROM twitter_news 
							WHERE sport = '". $sport ."'";				  
											 
	$gameid_sql_res = mysql_query($gameid_sql);
						   
	 while ($gameid_info = mysql_fetch_array($gameid_sql_res)) {
		$account = $gameid_info['account'];
		$team = str_replace("'","",$gameid_info['team']);	
		$position = $gameid_info['player_position'];	
		
		$insert = "UPDATE twitter_members SET team = '$team', position = '$position' WHERE account = '$account'";
						  
	    $res = mysql_query($insert)
					  or die(mysql_error());
		
	 }
	 
}
function transfer_data_by_name(){
	inspinc_tweetdb1();
			
	$gameid_sql =  "SELECT player_name, team, player_position FROM twitter_news";				  
											 
	$gameid_sql_res = mysql_query($gameid_sql);
						   
	 while ($gameid_info = mysql_fetch_array($gameid_sql_res)) {
		$name = $gameid_info['player_name'];
		$team = str_replace("'","",$gameid_info['team']);	
		$position = $gameid_info['player_position'];	
		
		$insert = "UPDATE twitter_members SET team = '$team', position = '$position' WHERE name = '$name' AND (team = '' OR position = '')";
						  
	    $res = mysql_query($insert)
					  or die(mysql_error());
		
	 }
	 
}
function insert_players($list_id, $sport){
	inspinc_tweetdb1();
	$user_lists = get_list_members("inspin", $list_id);
	for($i=0;$i < count($user_lists); $i++){
		if($user_lists[$i]->id != ""){
			 $insert = "INSERT INTO twitter_members(id, sport, name, account)
						  VALUES (". $user_lists[$i]->id .", '". $sport ."', '". $user_lists[$i]->name ."', '". $user_lists[$i]->screen_name ."')";
							  
		     $res = mysql_query($insert)
						  or die(mysql_error());
		}
	}
}
function insert_lists(){
	inspinc_tweetdb1();
	$user_lists = get_lists("inspin");
	for($i=0;$i < count($user_lists); $i++){
		if($user_lists[$i]->id != ""){
			$insert = "INSERT INTO twitter_list(id, name, description, url)
							VALUES (" . $user_lists[$i]->id . ", '" . $user_lists[$i]->name . "', 
								'" . $user_lists[$i]->description . "', '" . $user_lists[$i]->url . "')";
			$res = mysql_query($insert)
							or die(mysql_error());
		}
	}
}*/
?>