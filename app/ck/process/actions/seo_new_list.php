<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
if($current_clerk->im_allow("seo_system")) { 
?>
	<?
    
    if(isset($_POST["update_id"])){
        $list = get_seo_list(clean_get("update_id"));
        $list->vars["name"] = clean_get("name");
        $list->update();
		
		seo_delete_list_clerks($list->vars["id"]);
		
    }else{
        $list = new _seo_list();
        $list->vars["name"] = clean_get("name");
        $list->insert();
    }
	
	$clerks = get_all_clerks();
	foreach($clerks as $clk){
		if($clk->im_allow("seo_system")){
			if($_POST["clk_".$clk->vars["id"]]){
				seo_insert_clerk_in_list($list->vars["id"], $clk->vars["id"]);
			}
		}
	}

}
//header("Location: http://localhost:8080/ck/seo_lists.php?e=72");
?>

<script>location.href = "http://localhost:8080/ck/seo_lists.php?e=72";</script>