<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?

$game = new _inspin_game();
$game->vars["sport"] = clean_get("sport");
$game->vars["away_rotation"] = clean_get("away_rotation");
$game->vars["away_team"] = clean_get("away_team");
$game->vars["home_rotation"] = clean_get("home_rotation");
$game->vars["home_team"] = clean_get("home_team");
$game->vars["date"]  = date("Y-m-d");

$game->insert_other();
?>
<script type="text/javascript">
parent.document.getElementById("game_search").submit();
</script>
<? }else{echo "Access Denied";} ?>