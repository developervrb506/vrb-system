<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if($current_clerk->im_allow("seo_system")) {
?>
	<?
    
    if(isset($_POST["update_id"])){
        $group = get_seo_entry(clean_get("update_id"));
        $group->vars["brand"] = clean_get("brand");
		$group->vars["url"] = clean_get("url");
		$group->vars["keywords"] = clean_get("keywords");
		$group->vars["rank"] = clean_get("rank");
		$group->vars["amount"] = clean_get("amount");
		$group->vars["email"] = clean_get("email");
		$group->vars["method"] = clean_get("method");
		$group->vars["paid_date"] = clean_get("paid_date");
		$group->vars["article_type"] = clean_get("article_type");
		$group->vars["article_url"] = clean_get("article_url");
		$group->vars["paid_comments"] = clean_str_ck($group->vars["paid_comments"]);
        $group->update();
        $url = "../../seo_system.php?e=21";
    }else{
        $group = new _seo_entry();
		$group->vars["brand"] = clean_get("brand");
		$group->vars["url"] = clean_get("url");
		$group->vars["keywords"] = clean_get("keywords");
		$group->vars["rank"] = clean_get("rank");
		$group->vars["amount"] = clean_get("amount");
		$group->vars["email"] = clean_get("email");
		$group->vars["method"] = clean_get("method");
		$group->vars["paid_date"] = clean_get("paid_date");
		$group->vars["article_type"] = clean_get("article_type");
		$group->vars["article_url"] = clean_get("article_url");
        $group->insert();
        $url = "../../seo_system.php?e=20";
    }
	
	$clerk = clean_get("clerk");
	$rel_web = get_seo_website($group->vars["website"]);
	if(is_null($rel_web) && $clerk != ""){
		$new_web = new _seo_website();
		$new_web->vars["website"] = "RELATION:".$group->vars["id"];
		$new_web->vars["status"] = "i";
		$new_web->vars["clerk"] = $clerk;
		$new_web->insert();
		
		$group->vars["website"] = $new_web->vars["id"];
		$group->update(array("website"));
	}
	
	header("Location: $url");

}
?>