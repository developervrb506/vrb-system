<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("manage_permission")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
   } ?>
<?

$permission = $_POST["permission"];
$clerk = $_POST["clerk"];

insert_permission_clerk($permission,$clerk);

header("Location: ../../manage_permission.php");


?>
