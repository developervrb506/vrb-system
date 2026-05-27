<? 
include(ROOT_PATH . "/ck/process/security.php");
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once("../functions.php");
$game = get_baseball_game($_GET["gid"]);
$player = $_GET["pitcher"];
$year= date("Y");

if(!is_null($game)){


  if ($_GET["state"] == "away"){
 
	  $away_team = get_baseball_team($game->vars["team_away"]); 
  	  $player_a = get_baseball_player_by_team("fangraphs_player",$player,$away_team->vars["fangraphs_team"],$year); 
	 
	  if (!is_null($player_a)){ 
		
		//echo $game->vars["pitcher_away"]."- ".$player_a->vars["fangraphs_player"] ;
	 	 if ($game->vars["pitcher_away"] != $player_a->vars["fangraphs_player"] ){
 		   echo "-------------------------------<BR>";
		   echo "LOADING PITCHER STADISTICS---Please Wait<BR>";
   		   echo "-------------------------------<BR><BR>";
			 $game->vars["pitcher_away"] = $player_a->vars["fangraphs_player"];
   		     echo "<BR>Changed Away ".$game->vars["id"]."<BR>";
		     $game->update(array("pitcher_away")); 
		     include("../../jobs/pitchers_away_changes.php");  
         }	   
      }
  }
  else if ($_GET["state"] == "home"){	   
	    $home_team = get_baseball_team($game->vars["team_home"]); 
	    $player_h = get_baseball_player_by_team("fangraphs_player",$player,$home_team->vars["fangraphs_team"],$year);
		
	if(!is_null($player_h)){ 
			
	   if ($game->vars["pitcher_home"] != $player_h->vars["fangraphs_player"] ){
  		  $game->vars["pitcher_home"] = $player_h->vars["fangraphs_player"];
 		   echo "-------------------------------<BR>";
		   echo "LOADING PITCHER STADISTICS----Please Wait<BR>";
   		   echo "-------------------------------<BR><BR>";
		   echo "<BR>Changed home ".$game->vars["id"];
		   $game->update(array("pitcher_home"));          
		   include("../../jobs/pitchers_home_changes.php");
	   }
    }	 
 }
?> 
<script>
window.location = BASE_URL . "/ck/baseball_file/report.php";
</script>
<?


//header("Location: ../../report.php");     
	
}

?>