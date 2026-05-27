<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$item = get_menu_item(param("i"));
$name = param("name");
$desc = param("desc");

if(!is_null($item)){
	$item ->vars["name"] = $name;
	$item ->vars["description"] = $desc;
	$item ->update(array("name","description"));
}

header("Location: " . BASE_URL . "/ck/page_menu.php?c=".$item ->vars["parent"]);

?>