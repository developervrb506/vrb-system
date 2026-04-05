<? session_start();
require_once(ROOT_PATH . "/db/handler.php");
$loged = false;
if ($_SESSION["ses_loged"] == "y" && $_SESSION["is_admin"]){
	$loged = true;
	$current_affiliate = get_affiliate($_SESSION["aff_id"]);
}else{
	header("Location: index.php");
}
?>