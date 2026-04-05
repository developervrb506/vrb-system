<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if($current_clerk->im_allow("seo_system")) {
?>
	<?
	
	$path = "./ck/csv/";
	$file_name = upload_file("afile", $path, "seo_article_".mt_rand());
    
    if(isset($_POST["update_id"])){
        $list = get_seo_article(clean_get("update_id"));
        $list->vars["name"] = clean_get("name");
		$list->vars["brand"] = clean_get("brand");
		$list->vars["keyword"] = clean_get("keyword");
		if($file_name != ""){$list->vars["file"] = $file_name;}
        $list->update();
		
    }else{
        $list = new _seo_article();
        $list->vars["name"] = clean_get("name");
		$list->vars["brand"] = clean_get("brand");
		$list->vars["keyword"] = clean_get("keyword");
		$list->vars["file"] = $file_name;
        $list->insert();
    }
}
//header("Location: http://localhost:8080/ck/seo_articles.php?e=72");
?>
<script>location.href = "http://localhost:8080/ck/seo_articles.php?e=72";</script>