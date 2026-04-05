<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("seo_system")){ ?>
<?
$entry = get_seo_entry(clean_get("link"));
if(!is_null($entry)){
	$pre_article = clean_get("pre_article");
	if($pre_article == ""){
		$path = "./ck/csv/";
		$file_name = upload_file("article", $path, "entry_article_".$entry->vars["id"]."_".mt_rand());
	}else{
		$file_name = $pre_article;
	}
	$entry->vars["article"] = $file_name;
	$entry->update(array("article"));
}


header("Location: http://localhost:8080/ck/seo_system.php");
?>
<? }else{echo "Access Denied";} ?>