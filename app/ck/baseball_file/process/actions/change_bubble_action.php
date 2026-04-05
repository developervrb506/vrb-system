<? 
include(ROOT_PATH . "/ck/process/security.php");

$game = get_baseball_game($_GET["gid"]);

if(!is_null($game)){
	$game->vars["bubble"] = $_GET["status"];
	$game->update(array("bubble"));
}
echo "done";
?>