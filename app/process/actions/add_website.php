<? include(ROOT_PATH . "/process/login/security.php"); ?>
<?
$parent = $_SESSION['parent_aff_id'];
if($parent == ""){$parent = $current_affiliate->id;}

$name   = $_POST["web_name"];
$url   = $_POST["web_url"];
$id   = $parent;

$new_aff = get_affiliate($id);
$new_aff->parent_account = $id;
$new_aff->web_name = $name;
$new_aff->web_url = $url;
insert_affiliate($new_aff);

session_start();
$_SESSION['parent_aff_id'] = $id;
	
header("Location: ../../dashboard/sub.php?add");	 

?>