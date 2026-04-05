<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if($current_clerk->im_allow("seo_system")) {

    $list = get_seo_ranking(clean_get("update_id"));
	$list->vars["google"] = clean_get("google");
	$list->vars["int_links"] = clean_get("int_links");
	$list->vars["per_start"] = clean_get("per_start");
	$list->vars["per_now"] = clean_get("per_now");
	$list->vars["searches"] = clean_get("searches");
	$list->vars["google_change"] = $list->vars["google_previous"] -  clean_get("google"); 
	$list->vars["yahoo"] = clean_get("yahoo");
	$list->vars["google_previous"] = clean_get("google"); // google previous is the new google
	$list->vars["yahoo_previous"] = clean_get("yahoo_previous");
	$list->vars["yahoo_change"] = clean_get("yahoo_change");
	$list->update();
    
}

if(!clean_get("internal")){
	header("Location: http://localhost:8080/ck/seo_rankings.php?e=72");
}

?>