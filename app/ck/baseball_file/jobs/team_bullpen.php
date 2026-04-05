<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

  
set_time_limit(0);

// Find today games and Teams
echo "------------------<BR>";
echo "BULLEPEN FOR TEAM<br>";
echo "------------------<BR><BR>";

$today = date('Y-m-d');
// This job is to get the bullpen for the last games for the last 3 days.
$days = 3;

$games = get_basic_baseball_games_by_date($today);

foreach ($games as $game){

      $ip_a=0;
	  $pc_a=0;
	  $pc_h=0;
	  $ip_h=0;

	  //Away      
	  $lastgames_a = get_team_lastgames($game->vars["team_away"],$today,"away",$days);  
	  
	  foreach ($lastgames_a as $lastgame){
		$data= get_bullepin_away($lastgame["espn_game"]);
	    $ip_a = $ip_a + $data["IP"];
        $pc_a = $pc_a + $data["PC"]; 
	  }
	  	  
	  $lastgames_h = get_team_lastgames($game->vars["team_away"],$today,"home",$days);  
	  
	  foreach ($lastgames_h as $lastgame){
		$data= get_bullepin_home($lastgame["espn_game"]);
	    $ip_a = $ip_a + $data["IP"];
        $pc_a = $pc_a + $data["PC"]; 
	  }
	    
	   echo "Bullepin IP ".$ip_a." Bullepin PC ".$pc_a."<BR>"; 
	
	   $bullpen_a = get_team_bullpen($game->vars["team_away"],$today,$days);
	     
	  
	   if (is_null($bullpen_a)){
		  $bullpen_a = new _baseball_team_bullpen();
		  $bullpen_a->vars["team"]=$game->vars["team_away"]; 
		  $bullpen_a->vars["ip"]=$ip_a;
		  $bullpen_a->vars["pc"]=$pc_a;
		  $bullpen_a->vars["date"]= $today;
		  $bullpen_a->vars["days"]= $days;
		  $bullpen_a->insert();
		    
	   }
 	   else{   
		  $bullpen_a->vars["ip"]=$ip_a;
		  $bullpen_a->vars["pc"]=$pc_a;
		  $bullpen_a->vars["date"]= $today;
		  $bullpen_a->update(array("ip","pc","date"));
		   
	   }
	   
	   
	  //Home

	  $lastgames_a = get_team_lastgames($game->vars["team_home"],date('Y-m-d'),"away",$days);  
	  
	  foreach ($lastgames_a as $lastgame){
		$data= get_bullepin_away($lastgame["espn_game"]);
	    $ip_h = $ip_h + $data["IP"];
        $pc_h = $pc_h + $data["PC"]; 
	  }
	  	  
	  $lastgames_h = get_team_lastgames($game->vars["team_home"],date('Y-m-d'),"home",$days);  
	  
	  foreach ($lastgames_h as $lastgame){
		$data= get_bullepin_home($lastgame["espn_game"]);
	    $ip_h = $ip_h + $data["IP"];
        $pc_h = $pc_h + $data["PC"]; 
	  }
	    
	   echo "Bullepin IP ".$ip_h." Bullepin PC ".$pc_h."<BR>";  
	
	   $bullpen_h = get_team_bullpen($game->vars["team_home"],$today,$days);
	  
	   	  if (is_null($bullpen_h)){
		     $bullpen_h = new _baseball_team_bullpen();
		     $bullpen_h->vars["team"]=$game->vars["team_home"]; 
		     $bullpen_h->vars["ip"]=$ip_h;
		     $bullpen_h->vars["pc"]=$pc_h;
		     $bullpen_h->vars["date"]= $today;
			  $bullpen_h->vars["days"]= $days;
		     $bullpen_h->insert();
		    
	      }
 	      else{   
		    $bullpen_h->vars["ip"]=$ip_h;
		    $bullpen_h->vars["pc"]=$pc_h;
		    $bullpen_h->vars["date"]= $today;
		    $bullpen_h->update(array("ip","pc","date"));
		   
	      }

}




?>