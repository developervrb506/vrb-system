<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$pointer = get_list_pointer();

if($pointer->vars["list"]->vars["id"] != 20){

	$res_list = get_names_list($_GET["reset"]);
	if(!is_null($res_list)){	
		$pointer->vars["list"] = $res_list;
		$pointer->vars["remaining"] = $res_list->vars["allow"];
		$pointer->update();
		echo "Done";
	}else{echo "Error";}

}else{echo "No priority";}
?>
