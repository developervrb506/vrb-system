<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$item = get_menu_item(param("i"));

if(!is_null($item)){
	if($item ->vars["deleted"]){
		$item ->vars["deleted"]	= 0;
	}else{
		$item ->vars["deleted"]	= 1;	
	}
	$item ->update(array("deleted"));
}

header("Location: http://localhost:8080/ck/page_menu.php?c=".$item ->vars["parent"]);

?>