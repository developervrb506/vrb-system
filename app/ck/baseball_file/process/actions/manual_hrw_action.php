<? 
include(ROOT_PATH . "/ck/process/security.php");

$game = get_baseball_game($_GET["gid"]);

if(!is_null($game)){
	$game->vars["hrw"] = $_GET["hrw"];
	$game->update(array("hrw")); 
    header("Location: ../../report.php");     

}
?>