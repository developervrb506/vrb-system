<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("graded_games_checker")){ ?>
<?
$check = new _grade_check();
$check ->vars["game"] = param("game");
$check ->vars["gdate"] = param("gdate");
$check ->vars["by"] = $current_clerk ->vars["id"];
$check ->vars["checked_date"] = date("Y-m-d H:i:s");
$check->insert();
?>
<? }else{echo "Access Denied";} ?>