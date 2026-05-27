<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("programmers_book")){ ?>
<?
$title = $_POST["title"];
$desc = $_POST["description"];

if(isset($_POST["edit_id"])){
	$en = get_programmers_entry($_POST["edit_id"]);
	if(!is_null($en)){
		$en->vars["title"] = $title;
		$en->vars["description"] = $desc;
		//$en->vars["user"] = $current_clerk->vars["id"];
		//$en->vars["adate"] = date("Y-m-d");
		$en->update();
	}
}else{
	$en = new _programmer_entry();
	$en->vars["title"] = $title;
	$en->vars["description"] = $desc;
	$en->vars["user"] = $current_clerk->vars["id"];
	$en->vars["adate"] = date("Y-m-d H:i:s");
	$en->insert();
}

header("Location: " . BASE_URL . "/ck/programmers_book.php?e=82&en=".$en->vars["id"]);
?>
<? }else{echo "Access Denied";} ?>