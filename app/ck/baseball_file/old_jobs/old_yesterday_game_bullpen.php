<? require_once(ROOT_PATH . "/ck/db/handler.php"); 
    require_once('../../../includes/html_dom_parser.php');  
	require_once('../process/functions.php');
	ini_set('memory_limit', '-1');
    set_time_limit(0);
	



$file = fopen("./ck/baseball_file/old_jobs/date.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$date =  ltrim(fgets($file));
}
fclose($file);


//$date='2013-03-13';


if ($date >=  date( "Y-m-d", strtotime('2011-03-31'))){


for ($k=1;$k<3;$k++) {
	
	echo "---------------<BR>";
	echo "Stadistics for Yesterday Bullpen Game<BR>";
	echo "---------------<BR><BR>";	
	
	$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 
	
	
	echo "Fecha: ".$date."<BR>";
	
	$games = get_basic_baseball_games_by_date($date);
	$i=0;
	
	foreach ($games as $game ){
	
	
	if (!$game->vars["postponed"]){ 
	
	//Obtain Daily Bullpen for Team
  $days = 1;
  $ip_a=0;
  $pc_a=0;
  $pc_h=0;
  $ip_h=0;
	  
    //Away
    $data = array();
    $data = get_bullepin_away($game->vars["espn_game"]);
	    $ip_a = $ip_a + $data["IP"];
        $pc_a = $pc_a + $data["PC"]; 
		
	 $bullpen_a = get_team_bullpen($game->vars["team_away"],$date,$days);
	     
	  
	   if (is_null($bullpen_a)){
		  $bullpen_a = new _baseball_team_bullpen();
		  $bullpen_a->vars["team"]=$game->vars["team_away"]; 
		  $bullpen_a->vars["ip"]=$ip_a;
		  $bullpen_a->vars["pc"]=$pc_a;
		  $bullpen_a->vars["date"]= $date;
		  $bullpen_a->vars["days"]= $days;
		  $bullpen_a->insert();
		    
	   }
 	   else{   
		  $bullpen_a->vars["ip"]=$ip_a;
		  $bullpen_a->vars["pc"]=$pc_a;
		  $bullpen_a->vars["date"]= $date;
		  $bullpen_a->update(array("ip","pc","date"));
		   
	   }	
		
     //Home
    $data = array();
    $data= get_bullepin_home($game->vars["espn_game"]);
	    $ip_h = $ip_h + $data["IP"];
        $pc_h = $pc_h + $data["PC"]; 	
		
		
	   $bullpen_h = get_team_bullpen($game->vars["team_home"],$date,$days);
	  
	   	  if (is_null($bullpen_h)){
		     $bullpen_h = new _baseball_team_bullpen();
		     $bullpen_h->vars["team"]=$game->vars["team_home"]; 
		     $bullpen_h->vars["ip"]=$ip_h;
		     $bullpen_h->vars["pc"]=$pc_h;
		     $bullpen_h->vars["date"]= $date;
			 $bullpen_h->vars["days"]= $days;
		     $bullpen_h->insert();
		    
	      }
 	      else{   
		    $bullpen_h->vars["ip"]=$ip_h;
		    $bullpen_h->vars["pc"]=$pc_h;
		    $bullpen_h->vars["date"]= $date;
		    $bullpen_h->update(array("ip","pc","date"));
		   
	      }	 
	
	
	
	
	}
	
    }

} // end FOR



$fp = fopen('./ck/baseball_file/old_jobs/date.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);
		
		
}

?>