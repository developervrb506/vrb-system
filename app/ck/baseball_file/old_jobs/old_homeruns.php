<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once('../../../includes/html_dom_parser.php'); 
require_once('../process/functions.php');

  
set_time_limit(0);


$file = fopen("./ck/baseball_file/old_jobs/date.txt", "r") or exit("Unable to open file!");
while(!feof($file))
{
$_date =  ltrim(fgets($file));
}
fclose($file);


// Find today games and Teams
echo "------------------<BR>";
echo "   OLD HOME RUNS      <br>" ;
echo "---".$_date." ----<BR><BR>" ; 


if ($_date > '2011-03-27') {

  
  for($j=0;$j<5;$j++){
  
  
	$games = get_without_homeruns($_date);
			
		  foreach ($games as $game){
			  $away = get_bullepin_away2($game->vars["espn_game"]);
			  $home = get_bullepin_home2($game->vars["espn_game"]);
			  $game->vars["homeruns_away"]= $away["HR"];
			  $game->vars["homeruns_home"]= $home["HR"];
			  $game->update(array("homeruns_away","homeruns_home")); 
  		
			}
  
	  $_date = date( "Y-m-d", strtotime( "-1 day", strtotime(date($_date)))); 
  
  
	  $fp = fopen('./ck/baseball_file/old_jobs/date.txt', 'w');
		  fwrite($fp, $_date);
		  fclose($fp);
  
  }

}


function get_bullepin_away2($gameid){


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
	   <td class="table_header">HR</td>
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
  $data["HR"] = 0;
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
		
		  if ($i==8){
		     ?> <td style="font-size:12px;"><? echo $td->plaintext; ?></td>
		     <?
			 
			  $data["HR"]= $data["HR"] + $td->plaintext;
		    
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



function get_bullepin_home2($gameid){


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
       <td class="table_header">HR</td>
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
   $data["HR"] = 0;
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
			
		  if ($i==8){
		     ?> <td style="font-size:12px;"><? echo $td->plaintext; ?></td>
		     <?
			 
			  $data["HR"]= $data["HR"] + $td->plaintext;
		    
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



function get_without_homeruns($date){
baseball_db();	
$sql = "SELECT * FROM `game` WHERE postponed = 0 and date(startdate) = '".$date."' order by id desc";
return get($sql, "_baseball_game");	
}



?>