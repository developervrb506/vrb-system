<? session_start();
require_once(ROOT_PATH . "/db/handler.php");
$loged = false;
$is_admin = $_SESSION["is_admin"];

if ($_SESSION["ses_loged"] == "y" && $_SESSION['aff_ip'] == md5($_SERVER['HTTP_USER_AGENT'])){
	$loged = true;
	$current_affiliate = get_affiliate($_SESSION["aff_id"]);
}else{
	$url = "../index.php?e=-1&s=".$_SESSION["ses_loged"]."&ix=".$_SESSION['aff_ip'];
	session_destroy();
	header("Location: $url");
	exit();
}
?>