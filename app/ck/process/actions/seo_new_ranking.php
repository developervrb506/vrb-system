<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if($current_clerk->im_allow("seo_system")) {
?>
	<?
    
    if(isset($_POST["update_id"])){
        $list = get_seo_ranking(clean_get("update_id"));
        $list->vars["brand"] = clean_get("brand");
		$list->vars["url"] = clean_get("url");
		$list->vars["keyword"] = clean_get("keyword");
        $list->update();
		
    }else{
        $list = new _seo_ranking();
        $list->vars["brand"] = clean_get("brand");
		$list->vars["url"] = clean_get("url");
		$list->vars["keyword"] = clean_get("keyword");
        $list->insert();
    }

}
//header("Location: " . BASE_URL . "/ck/seo_rankings.php?e=72");
?>
<script>location.href = BASE_URL . "/ck/seo_rankings.php?e=72";</script>