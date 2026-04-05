<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<? 
$account = clean_str_ck($_GET["a"]);
if($account != ""){
	$count = count_unread_tickets_by_player($account);
	$count_players = count_unread_tickets_by_player_to_agent($account);
	$count["num"] = $count["num"] + $count_players["num"];
}
echo round($count["num"]);
?>