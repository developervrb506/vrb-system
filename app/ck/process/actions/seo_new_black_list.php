<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if($current_clerk->im_allow("seo_system")) {

    $web = new _seo_website();
	$web->vars["website"] = clean_get("website");
	$web->vars["black_list"] = 1;
	$web->vars["status"] = 'i';
	$web->insert();

}

header("Location: " . BASE_URL . "/ck/seo_black_list.php?e=72");

?>