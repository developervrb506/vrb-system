<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
$parent = $_SESSION['parent_aff_id'];
if($parent == ""){$parent = $current_affiliate->id;}
if(check_affiliate_website($parent, $_GET["sid"])){
	session_start();
	$_SESSION['aff_id'] = $_GET["sid"];
}
header("Location: ../../dashboard/index.php");
?>