<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if($current_clerk->im_allow("seo_system")) {

    $web = get_seo_website(clean_get("wid",true));
	$web->delete();

}

header("Location: http://localhost:8080/ck/seo_black_list.php?e=72");

?>