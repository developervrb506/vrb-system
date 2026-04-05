<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("goals_admin")){ ?>
<?

if(clean_get("edit_id")!=""){
	$goal = get_goal(clean_get("edit_id"));
	if(!is_null($goal)){
		$goal->vars["name"] = clean_get("name");
		$goal->vars["start_date"] = clean_get("start");
		$goal->vars["end_date"] = clean_get("end");
		$goal->vars["goal"] = clean_get("goal");
		$goal->vars["type"] = clean_get("type");
		$goal->vars["description"] = clean_get("desc");
		$goal->vars["ugroup"] = clean_get("group_list");
		$goal->update();
	}
}else{
	$goal = new _goal();
	$goal->vars["name"] = clean_get("name");
	$goal->vars["start_date"] = clean_get("start");
	$goal->vars["end_date"] = clean_get("end");
	$goal->vars["goal"] = clean_get("goal");
	$goal->vars["type"] = clean_get("type");
	$goal->vars["description"] = clean_get("desc");
	$goal->vars["ugroup"] = clean_get("group_list");
	$goal->insert();	
}

header("Location: http://localhost:8080/ck/goals.php?e=58");

?>
<? }else{echo "Access Denied";} ?>