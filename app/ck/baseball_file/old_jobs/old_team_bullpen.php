<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once('../../../includes/html_dom_parser.php'); 
  
set_time_limit(0);




$file = fopen("./ck/baseball_file/old_jobs/date.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$date =  ltrim(fgets($file));
}
fclose($file);




// Find today games and Teams
echo "------------------<BR>";
echo "BULLEPEN FOR TEAM<br>";
echo "-------".$date."--------<BR><BR>";

//$today = date('Y-m-d');
$today = $date;


if ($date > '2011-02-11') {


$games = get_basic_baseball_games_by_date($today);

foreach ($games as $game){

     
 
	 
	  $ip_a=0;
	  $pc_a=0;
	  $pc_h=0;
	  $ip_h=0;

	  //Away      
	  $lastgames_a = get_team_lastgames($game->vars["team_away"],$today,"away");  
	  
	  foreach ($lastgames_a as $lastgame){
		$data= get_bullepin_away($lastgame["espn_game"]);
	    $ip_a = $ip_a + $data["IP"];
        $pc_a = $pc_a + $data["PC"]; 
	  }
	  	  
	  $lastgames_h = get_team_lastgames($game->vars["team_away"],$today,"home");  
	  
	  foreach ($lastgames_h as $lastgame){
		$data= get_bullepin_home($lastgame["espn_game"]);
	    $ip_a = $ip_a + $data["IP"];
        $pc_a = $pc_a + $data["PC"]; 
	  }
	    
	   echo "Bullepin IP ".$ip_a." Bullepin PC ".$pc_a."<BR><BR>"; 
	
	   $bullpen_a = get_team_bullpen($game->vars["team_away"],$today);
	     
	  
	   if (is_null($bullpen_a)){
		  $bullpen_a = new _baseball_team_bullpen();
		  $bullpen_a->vars["team"]=$game->vars["team_away"]; 
		  $bullpen_a->vars["ip"]=$ip_a;
		  $bullpen_a->vars["pc"]=$pc_a;
		  $bullpen_a->vars["date"]= $today;
		  $bullpen_a->insert();
		    
	   }
 	   else{   
		  $bullpen_a->vars["ip"]=$ip_a;
		  $bullpen_a->vars["pc"]=$pc_a;
		  $bullpen_a->vars["date"]= $today;
		  $bullpen_a->update(array("ip","pc","date"));
		   
	   }
	   
	   
	  //Home

	  $lastgames_a = get_team_lastgames($game->vars["team_home"],$today,"away");  
	  
	  foreach ($lastgames_a as $lastgame){
		$data= get_bullepin_away($lastgame["espn_game"]);
	    $ip_h = $ip_h + $data["IP"];
        $pc_h = $pc_h + $data["PC"]; 
	  }
	  	  
	  $lastgames_h = get_team_lastgames($game->vars["team_home"],$today,"home");  
	  
	  foreach ($lastgames_h as $lastgame){
		$data= get_bullepin_home($lastgame["espn_game"]);
	    $ip_h = $ip_h + $data["IP"];
        $pc_h = $pc_h + $data["PC"]; 
	  }
	    
	   echo "Bullepin IP ".$ip_h." Bullepin PC ".$pc_h."<BR><BR>";  
	
	   $bullpen_h = get_team_bullpen($game->vars["team_home"],$today);
	  
	   	  if (is_null($bullpen_h)){
		     $bullpen_h = new _baseball_team_bullpen();
		     $bullpen_h->vars["team"]=$game->vars["team_home"]; 
		     $bullpen_h->vars["ip"]=$ip_h;
		     $bullpen_h->vars["pc"]=$pc_h;
		     $bullpen_h->vars["date"]= $today;
		     $bullpen_h->insert();
		    
	      }
 	      else{   
		    $bullpen_h->vars["ip"]=$ip_h;
		    $bullpen_h->vars["pc"]=$pc_h;
		    $bullpen_h->vars["date"]= $today;
		    $bullpen_h->update(array("ip","pc","date"));
		   
	      }


//break;
}

$date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($date)))); 


$fp = fopen('./ck/baseball_file/old_jobs/date.txt', 'w');
		fwrite($fp, $date);
		fclose($fp);

}



function get_bullepin_away($gameid){


  $html = file_get_html_parts(0,3,"http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

  echo "http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."";
	  

	  
  ?>
   <table width="25%" border="1" cellspacing="0" cellpadding="0">
	
	  <tr> 
	   <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	   <td class="table_header">Pitchers</td>
	   <td class="table_header">IP</td>
	   <td class="table_header">PC</td>
	 </tr>
	  <tr> 
	   <? echo $player_name ?><BR>
	  </tr>
	 <tr>
  <?
	  
  //
  $data = array();
  $data["IP"] = 0;
  $data["PC"] = 0;
  $new_line = false;
  $team="";
  $j=0;
  $omit_pitcher=true;
  
  foreach($html->find("Table.mod-data tr") as $element) { 
	 	  
     if ((contains_ck($element->plaintext,'PITCHING')) && $new_line == true){
		break;
	 }
	  
	
	if ($j==0){
		$team = $element->plaintext;    
	    echo $element->plaintext."<br>";
	}
	if ($j>0 && $team == $element->plaintext){
	    $new_line = true;	   
	}
      
	if ($new_line){
		$i=1;
		
	    foreach ($element->find('td') as $td){
			   
		   if ($i==1){
               ?> 
               <tr>
               <td style="font-size:12px;"><? echo $td->plaintext ?></td><?   
		   }
		   if ($i==2){
		       ?> <td style="font-size:12px;"><? echo $td->plaintext ?></td><?
		    
			   if (!$omit_pitcher){
		           $data["IP"]= $data["IP"] + $td->plaintext;
		        }
		    }
		 if ($i==9){
		     ?> <td style="font-size:12px;"><? echo strstr($td->plaintext,"-",true) ?></td>
		     </tr><?
			 
			 if (!$omit_pitcher){
		         $data["PC"]= $data["PC"] + strstr($td->plaintext,"-",true);
		     }	
		     $omit_pitcher=false;	
		  }
	     $i++;
	   }
    }
    $j++;	 
   }  ?></tr></table><BR><?
     
	 echo "<pre>";
	 print_r($data);
 	 echo "</pre>";
	 $html->clear();

    return $data;	
}



function get_bullepin_home($gameid){


  $html = file_get_html("http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."");

  echo "http://scores.espn.go.com/mlb/boxscore?gameId=".$gameid."";
	  

	  
  ?>
   <table width="25%" border="1" cellspacing="0" cellpadding="0">
	
	  <tr> 
	   <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	   <td class="table_header">Pitchers</td>
	   <td class="table_header">IP</td>
	   <td class="table_header">PC</td>
	 </tr>
	  <tr> 
	   <? echo $player_name ?><BR>
	  </tr>
	 <tr>
  <?
	  
  //
  $data = array();
  $data["IP"] = 0;
  $data["PC"] = 0;
  $new_line = false;
  $team="";
  $j=0;
  $omit_pitcher=true;
  
  foreach($html->find("Table.mod-data tr") as $element) { 
	
	 if (contains_ck($element->plaintext,'PITCHING')){
	    $j=0;
		$home = true;
	    if ($new_line == true){
		 break;
	   }
	 }
	  
   if ($home){	  

	if ($j==1){
		$team = $element->plaintext;    
	    echo $element->plaintext."<br>";
	}
	if ($j>1 && $team == $element->plaintext){
	    $new_line = true;	   
	}
      
	if ($new_line){
		$i=1;
		
	    foreach ($element->find('td') as $td){
			   
		   if ($i==1){
               ?> 
               <tr>
               <td style="font-size:12px;"><? echo $td->plaintext ?></td><?   
		   }
		   if ($i==2){
		       ?> <td style="font-size:12px;"><? echo $td->plaintext ?></td><?
		    
			   if (!$omit_pitcher){
		           $data["IP"]= $data["IP"] + $td->plaintext;
		        }
		    }
		 if ($i==9){
		     ?> <td style="font-size:12px;"><? echo strstr($td->plaintext,"-",true) ?></td>
		     </tr><?
			 
			 if (!$omit_pitcher){
		         $data["PC"]= $data["PC"] + strstr($td->plaintext,"-",true);
		     }	
		     $omit_pitcher=false;	
		  }
	     $i++;
	   }
     }
   }
    $j++;	 
   }  ?></tr></table><BR><?
     
	 echo "<pre>";
	 print_r($data);
 	 echo "</pre>";
	 $html->clear();

    return $data;	
}


?>