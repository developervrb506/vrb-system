<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("tweets")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
} ?>
<?

$id_login = $_GET["id"];
$clerk = $_GET["clerk"];

$login =  get_login_by_phone($id_login);
$login->delete();


header("Location: http://localhost:8080/ck/create_user.php?uid=".$clerk."");

?>
