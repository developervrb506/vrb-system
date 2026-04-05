<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?

$bet = get_bet(clean_get("bid"));

$bet->insert_record("edit", $current_clerk->vars["id"]);

$pre_amount = $bet->get_money();

$account = get_betting_account_by_name(clean_get("account"));
$idf = get_betting_identifier_by_name(clean_get("identifier"));

$bet->vars["account"] = $account->vars["id"];
$bet->vars["line"] = clean_get("preline").clean_get("line");
$bet->vars["risk"] = clean_get("risk");
$bet->vars["win"] = clean_get("win");
$bet->vars["identifier"] = $idf->vars["id"];

//$bet->vars["bdate"] = date("Y-m-d H:i:s");
$bet->vars["user"] = $current_clerk->vars["id"];

$bet->vars["account_percentage"] = $account->vars["description"];

$bet->update();


if($_POST["turl"]!=""){
	?>
    <script type="text/javascript">parent.location.href = '<? echo clean_get("turl") ?>';</script>
    <?
}else{
	?>
    <script type="text/javascript">
	current_money = parent.document.getElementById("m_<? echo biencript($bet->vars["gameid"]."/".$bet->vars["team"]."/".$bet->vars["type"]) ?>").innerHTML;
	parent.document.getElementById("m_<? echo biencript($bet->vars["gameid"]."/".$bet->vars["team"]."/".$bet->vars["type"]) ?>").innerHTML = parseInt(current_money) + parseInt(<? echo $bet->get_money() - $pre_amount; ?>);
	
	location.href = '../../insert_bet.php?good';
	
	</script>
    <?
}

?>




<? }else{echo "Access Denied";} ?>