<? 
include(ROOT_PATH . "/ck/process/security.php");

$game = get_baseball_game($_GET["gid"]);

if(!is_null($game)){
	$game->vars["real_roof_open"] = $_GET["status"];
	$game->update(array("real_roof_open"));
}
echo "done";
?>