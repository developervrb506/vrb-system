<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if($current_clerk->im_allow("seo_system")) {

    $list = get_seo_ranking(clean_get("uid",true));
	$list->vars[clean_get("field",true)] = clean_get("value",true);
	$list->update(array(clean_get("field",true)));
	
}

?>