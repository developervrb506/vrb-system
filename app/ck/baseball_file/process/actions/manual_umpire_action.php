<? 
include(ROOT_PATH . "/ck/process/security.php");

$game = get_baseball_game($_GET["gid"]);

if(!is_null($game)){
	$game->vars["umpire"] = $_GET["umpire"];
	
	$umpire_stadistics = get_umpire_basic_stadistics($game->vars["umpire"],date('Y'));	
	 $game->vars["umpire_kbb"]= $umpire_stadistics->vars["k_bb"];
	 $game->vars["umpire_starts"]= ($umpire_stadistics->vars["hw"] + $umpire_stadistics->vars["rw"]);
     $game->update(array("umpire","umpire_kbb","umpire_starts")); 

     header("Location: ../../report2.php");     

	
}
?>