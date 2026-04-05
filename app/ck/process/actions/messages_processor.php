<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?
$action = $_GET["action"];

switch($action){
	case "delete":
		$message = get_ck_message($_GET["m"]);
		$message->delete();
		echo "Good";
	break;
	case "delete_group":
		$ids = explode(",",$_GET["ms"]);
		foreach($ids as $id){
			$message = get_ck_message($id);
			$message->delete();
		}		
		echo "Good";
	break;
	case "restore":
		$message = get_ck_message($_GET["m"]);
		$message->restore();
		header("Location: ../../messages.php?e=37");
	break;
	case "important":
		$message = get_ck_message($_GET["m"]);
		$message->change_important();
		echo "Good";
	break;
	case "complete":
		$message = get_ck_message($_GET["m"]);
		$message->change_complete();
		echo "Good";
	break;
	case "complete_group":
		$ids = explode(",",$_GET["ms"]);
		foreach($ids as $id){
			$message = get_ck_message($id);
			$message->change_complete();
		}		
		echo "Good";
	break;
}




?>