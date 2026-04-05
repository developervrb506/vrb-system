<? 
include(ROOT_PATH . "/ck/process/security.php");

$game = get_baseball_game($_GET["gid"]);

if(!is_null($game)){
	$game->vars["seal"] = $_GET["seal"];
	$game->update(array("seal")); 
    header("Location: ../../report.php");     

}
?>