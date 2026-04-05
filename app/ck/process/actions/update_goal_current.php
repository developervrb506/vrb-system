<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("goals_admin")){ ?>
<?
$goal = get_goal($_GET["gid"]);
if(!is_null($goal)){
	$goal->vars["current"] = $_GET["cr"];
	$goal->update(array("current"));
}
?>
<? }else{echo "Access Denied";} ?>