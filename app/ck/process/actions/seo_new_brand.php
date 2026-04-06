<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if($current_clerk->im_allow("seo_system")) {
?>
	<?
    
    if(isset($_POST["update_id"])){
        $list = get_seo_brand(clean_get("update_id"));
        $list->vars["name"] = clean_get("name");
        $list->update();
		
    }else{
        $list = new _seo_brand();
        $list->vars["name"] = clean_get("name");
        $list->insert();
    }

}

//header("Location: " . BASE_URL . "/ck/seo_brands.php?e=72");
?>

<script>location.href = BASE_URL . "/ck/seo_brands.php?e=72";</script>