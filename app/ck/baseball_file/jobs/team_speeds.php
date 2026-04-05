<? 
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');

set_time_limit(0);
echo "<pre>";
echo "---------------<BR>";
echo "TEAM SPEEDS <br>";
echo "---------------<BR><BR>";
$year = date("Y");	
$today = date("Y-m-d");

	 $velocity = array();
	 $velocity[0]["place"] = 2;
	 $velocity[0]["name"] = "wfb"; 
	 $velocity[1]["place"] = 3;
	 $velocity[1]["name"] = "wsl"; 
	 $velocity[2]["place"] = 4;
	 $velocity[2]["name"] = "wct"; 
	 $velocity[3]["place"] = 5;
	 $velocity[3]["name"] = "wcb"; 
	 $velocity[4]["place"] = 6;
	 $velocity[4]["name"] = "wch";
	 $velocity[5]["place"] = 7;
	 $velocity[5]["name"] = "wsf";
	 $velocity[6]["place"] = 8;
	 $velocity[6]["name"] = "wkn";
	 
	
	
	$all_teams = get_all_baseball_stadium_custom("espn_small_name");
	$team_speeds =  get_all_baseball_team_speed($today,'control');
	
	
	 
   $i=0;
   foreach($velocity as $v){ $i++;
       
	 
	  
	   $data = get_team_speed1($v["place"],$v["name"]);		
	   echo "-------S-------------<BR>";
	    print_r($data);
	    echo "--------------------<BR>";
        
	  if(!empty($data)){
		  echo "ENTRA DATA";
		foreach ($data as $dt){
			
		     print_r($dt);
			if(isset($all_teams[$dt["team"]]->vars["team_id"])){
				//echo "ADDDD";exit;
				if($i==1){	
				$team = new _baseball_team_speed();
				$team->vars["team"]	= $all_teams[$dt["team"]]->vars["team_id"];
				$team->vars["date"]	= date("Y-m-d");		
				$team->vars["rank_".$v["name"]]	= $dt["rank_".$v["name"]];		
				$team->vars[$v["name"]]	= str_replace("&nbsp;","",$dt[$v["name"]]);	
				$team->insert();
				echo "ENTRA";
			
				}
				if($i>1){
	
				 if(isset($team_speeds[$today."_".$all_teams[$dt["team"]]->vars["team_id"]])){	
					$team_speeds[$today."_".$all_teams[$dt["team"]]->vars["team_id"]]->vars["rank_".$v["name"]] = $dt["rank_".$v["name"]]; 
					$team_speeds[$today."_".$all_teams[$dt["team"]]->vars["team_id"]]->vars[$v["name"]] = str_replace("&nbsp;","",$dt[$v["name"]]);					
					$team_speeds[$today."_".$all_teams[$dt["team"]]->vars["team_id"]]->update(array("rank_".$v["name"],$v["name"]));
					
				 }
				}
			
			
			
			}else {
				echo $dt["team"];
			}
		
		} //$dt
		
		}//empty data
      //  break;
      } //velocity
	  
/// HERE GET THE INFO FOR THE LEFT HANDLED PITCHER

echo "---------------<BR>";
echo "TEAM LEFT NUMBERS <br>";
echo "---------------<BR><BR>";

 	$all_teams_2 = get_all_baseball_stadium_custom("espn_id_name");
     echo "-------$all_teams_2-------------<BR>";
	// print_r($all_teams_2);
	    echo "--------------------<BR>";
	 
   $i=0;
       
	$data = get_team_lefthy();	
   echo "-------L-------------<BR>";
	// print_r($data);
	    echo "--------------------<BR>";
	
	  if(!empty($data)){
		
		
		foreach ($data as $dt){
			
		  
			if(isset($all_teams_2[$dt["team"]]->vars["team_id"])){
				
				// echo "ENTRA ACA";
	
				 if(isset($team_speeds[$today."_".$all_teams_2[$dt["team"]]->vars["team_id"]])){	
					
					$team_speeds[$today."_".$all_teams_2[$dt["team"]]->vars["team_id"]]->vars["rank_ops"] = $dt["rank"]; 
					$team_speeds[$today."_".$all_teams_2[$dt["team"]]->vars["team_id"]]->vars["ops"] = str_replace("&nbsp;","",$dt["ops"]);					
					$team_speeds[$today."_".$all_teams_2[$dt["team"]]->vars["team_id"]]->update(array("rank_ops","ops"));
					 
				 }
			
			
			}else {
				echo $dt["team"];
			}
		 
		 
		   echo "<BR>";
		   
		
		} //$dt
				
		}//empty data
	    
	  




function get_team_speed1($place,$name){
	   
	   $link = "http://www.fangraphs.com/leaders.aspx?pos=all&stats=bat&lg=all&qual=0&type=7&season=".date("Y")."&month=0&season1=".date("Y")."&ind=0&team=0,ts&rost=0&age=0&filter=&players=0&sort=".$place.",d";
	   
	   $data = file_get_contents("http://www.oddessa.com/fansgraphs_bridge.php?action=team_speed&v1=".$name."&v2=".$place."&link=".$link);
    // print_r($data);
	 //exit;

 ///	 
/// ORIGINAL CODE COMMENTET, ITS USED IN BRIDGE, IT DOES NOT LOAD FULL 
	
  /*	
	//$html = file_get_html($link,true);
	$pos = $place+1;
	
	if (!empty($html)){	
	
	  echo $link." ---> ".$player_name."<BR><BR>";	  
	  ?>
	  <table width="25%" border="1" cellspacing="0" cellpadding="0">
			
	  <tr> 
	    <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	    <td class="table_header">Rank</td>
	    <td class="table_header">Team</td>
	    <td class="table_header"><? echo $name?></td>
	  </tr>
	  <tr> 
	   
	  </tr>
 	  
      
        <td class="table_header"><? echo $playerid ?></td> 
	  <?
		  
		  $data = array();
		   foreach($html->find('div') as $div) { 
		     echo $div->plaintext;
		   }
		 
		 
	     foreach($html->find('table[id="LeaderBoard1_dg1_ctl00"]') as $table) { 
		 
		   	$j=0;$d=0;
			foreach($table->find('tr') as $tr){ $i++;
			
			  if($i>3){
				$j=0;
				
				?> <tr><?
			  	foreach($tr->find('td') as $td){ $j++;
			
				 if ($j<3){ ?>
				   <td class="table_header"><? echo $td->plaintext; ?></td><? 
				 } 
				  
				 if($m == $pos){
				    ?> <td class="table_header"><? echo $td->plaintext; ?></td> <?
				 }
				 
				   $m++; 
                   if ($m==1){ $data[$d]["rank_".$name] = $td->plaintext; }
                   if ($m==2){ $data[$d]["team"] = $td->plaintext; }
                   if ($m==$pos){ $data[$d][$name] = $td->plaintext; }								 
                      
				   if($m==10){ 
				   ?></tr><?
				     $m=0;
					 $d++;
					 break; 
					}
                     
				  
			     } //td	
			   }//IF i
			} //tr
		 
		  } //table
		 
		  
		  ?>
         </table> <?  
		    $html->clear();
	 } else{ 
	    echo "Error: ".$link."<BR>";
	 }	*/  //END COMMENTED
	 ///echo "------<BR><BR>-----";
	// //print_r(json_decode($data,true)); exit;
	 
	  
  return json_decode($data, true);
}


function get_team_lefthy(){
	
	$link = "http://espn.go.com/mlb/stats/team/_/stat/batting/split/31/sort/OPS/order/true";
	
	$html = file_get_html($link,true);
	
	if (!empty($html)){	
	
	
	  ?>
	  <table width="25%" border="1" cellspacing="0" cellpadding="0">
			
	  <tr> 
	    <? echo $_team["team_name"];?>
	  </tr>
	  <tr>
	    <td class="table_header">Rank</td>
	    <td class="table_header">Team</td>
	    <td class="table_header">OPS</td>
	  </tr>
	  <tr> 
	   
	  </tr>
 	  
      
        <td class="table_header"><? echo $playerid ?></td> 
	  <?
		  
		  $data = array();
		 
		 
	     foreach($html->find('table[class="tablehead"]') as $table) { 
		 
		   	$j=0;$d=0;
			foreach($table->find('tr') as $tr){ $i++;
			
			 if ($i > 2){
				
				?> <tr><? $j=0;
			  	foreach($tr->find('td') as $td){ $j++;
			
					  if ($j==1){
						 ?> <td class="table_header"><? echo $td->plaintext; ?></td><? 
						 $rank =  $td->plaintext; 
					  }
				      
					  if ($j==2){
						 		foreach($td->find('a') as $a){ 
								 $name = $a->href;
								 break;
								}
						
					    $team = str_center("_/name/","/",$name);
						$team = "+++".$team;
						$team = str_replace("/","***",$team);
						$team = str_center("+++","***",$team);
	   				    $data[$team]["team"]= $team;					  
						$data[$team]["rank"]= $rank;					  
					     ?> <td class="table_header"><? echo $td->plaintext; ?></td><? 
					  
					  }
				 
					  if ($j==15){
						$data[$team]["ops"]= $td->plaintext;  
						  
					  ?> <td class="table_header"><? echo $td->plaintext; ?></td><? 
					  } 
			         
				  
			     } //td	
				 
			 }
			 if ($i==32){break;}
			   
		   } //tr
		 
		  break;
		  } //table
		 
		  
		  ?>
         </table> <?  
		    $html->clear();
	} else{ 
	    echo "Error: ".$link."<BR>";
	 }	 
  return $data;
}

echo  "</pre>";
?>