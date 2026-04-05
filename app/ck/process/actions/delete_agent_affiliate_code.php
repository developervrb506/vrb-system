<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if(!$current_clerk->im_allow("tweets")) {
   	include(ROOT_PATH . "/ck/process/admin_security.php");
} ?>
<?

$id = $_GET["id"];
$clerk = $_GET["clerk"];


$aff_code = get_affiliates_by_clerk($id);
print_r($aff_code);
$aff_code->delete();


header("Location: http://localhost:8080/ck/create_user.php?uid=".$clerk."");

?>
