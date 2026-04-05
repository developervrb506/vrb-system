<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
if($_GET["manual"]){
	$pick = get_inspin_pick_by_id($_GET["pid"]);
	$pick->delete();
	header("Location: ../../insert_pick_manual.php?gid=".$pick->vars["gameid"]."&e=63");
}
else{
	$pick = get_inspin_pick($_GET["gid"], $_GET["p"]);
	if(!is_null($pick)){
		$pick->vars["2and3star"] = "N";
		$pick->vars["4and5star"] = "N";	
		$pick->vars["chosen_id"] = "";
		$pick->vars["line"] = "";
		$pick->vars["4and5star_comment"] = "";
		$pick->vars["chosen_id_2"] = "";
		$pick->vars["line2"] = "";
		$pick->vars["comment_2"] = "";
		$pick->vars["pick_date"] = "0000-00-00 00:00:00";
		$pick->update();
		header("Location: ../../insert_pick.php?gid=".$pick->vars["gameid"]."&period=".$pick->vars["period"]."&e=63");
	}
}
?>

<? }else{echo "Access Denied";} ?>