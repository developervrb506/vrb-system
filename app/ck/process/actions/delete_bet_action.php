<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? //if(!$current_clerk->vars["level"]->vars["schedules_access"]){include(ROOT_PATH . "/ck/process/admin_security.php");} ?>
<?

$bet = get_bet(clean_get("delid"));
if(!is_null($bet)){
	$commissions = get_bet_comissions($bet->vars["id"]);
	foreach($commissions as $com){
		$com->insert_record("delete", $current_clerk->vars["id"]);
		$com->delete();
	}
	$bet->insert_record("delete", $current_clerk->vars["id"]);
	$bet->delete();
	
}

//header("Location: ".clean_get("curl")."&gdel");
?>
<script type="text/javascript">
current_money = parent.document.getElementById("m_<? echo biencript($bet->vars["gameid"]."/".$bet->vars["team"]."/".$bet->vars["type"]) ?>").innerHTML;
parent.document.getElementById("m_<? echo biencript($bet->vars["gameid"]."/".$bet->vars["team"]."/".$bet->vars["type"]) ?>").innerHTML = parseInt(current_money) - parseInt(<? echo $bet->get_money(); ?>);

location.href = "<? echo clean_get("curl")."&gdel" ?>";
</script>