<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("tweets")){ ?>
<?
$id         = param("id");
$name       = param("name");
$account    = param("account");
$sport      = $_POST['sport'];
$teamid     = $_POST['teamid'];
$team       = get_twitter_team($teamid);
$followers  = param("followers");
$delete     = param("delete");

if(isset($_POST["update_id"])){
	
	$member = get_twitter_member($id);
	
	$member->vars["name"] = $name;
	$member->vars["account"] = $account;
	$member->vars["sport"] = $sport;
	$member->vars["teamid"] = $teamid;
	$member->vars["team"] = $team["team"];
	$member->vars["followers"] = $followers;
	$member->update();
	
	header("Location: ../../twitter_members.php?e=104");
	
}else{
	
	$member = get_twitter_member($id);
	
	if (!empty($member)){//Member exist in the system
	
	   header("Location: ../../twitter_members.php?e=105");
	
	}else{
	
		$member = new _twitter_member();
		
		$member->vars["id"] = $id;
		$member->vars["name"] = $name;
		$member->vars["account"] = $account;
		$member->vars["sport"] = $sport;
		$member->vars["teamid"] = $teamid;
		$member->vars["team"] = $team["team"];
		$member->vars["followers"] = $followers;
		$member->insert();
		
		header("Location: ../../twitter_members.php?e=103");
	}
	
}

if($delete){
	$member = get_twitter_member($id);
	$member->delete();
}
?>
<? }else{echo "Access Denied";} ?>