<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
session_start();

$web = clean_str($_GET["ws"]);

delete_website($web, $current_affiliate->id);

/*if($current_affiliate->id == $web){
	$_SESSION['aff_id'] =$_SESSION['parent_aff_id'];
}*/
	
header("Location: ../../dashboard/sub.php?add");	

?>