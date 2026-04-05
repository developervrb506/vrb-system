<? 
include(ROOT_PATH . "/ck/process/security.php");

$game = get_baseball_game($_GET["gid"]);

if(!is_null($game)){
	$game->vars["manual_wind"] = $_GET["position"];
	$game->update(array("manual_wind")); 
    header("Location: ../../report.php");     

}
?>