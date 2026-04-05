<?
require_once(ROOT_PATH . "/ck/db/handler.php"); 
require_once(ROOT_PATH . '/includes/html_dom_parser.php'); 
//require_once(ROOT_PATH . '/ck/baseball_file/process/functions.php');
  set_time_limit(0);  
echo "-------------------------<BR>";
echo "      PITCHERS ESPN <br>";
echo "--------------------------<BR>";
 
 
 

$players = get_all_baseball_players_espn();

echo count($players);
foreach ($players as $player){
$name = str_replace(" ","+",$player->vars["espn_nick"]);
$html = @file_get_html("http://espn.go.com/mlb/players?search=".$name); 

  $link = "";
  if(!empty($html)){
	 // echo "IN";
	  foreach($html->find('meta') as $element) {    
		
		//echo $element->content."<BR>";
		if (contains_ck($element->content,"headshots/mlb/players/full")) { 
		  
		 $link = $element->content;
		 echo $link."<BR>";
		 break;     	 
		 }
	
	  }
	   if ($link != ""){
			
		$player_id = str_center("players/full/",".png",$link);	
		$link = "image".$link;
		$image = str_center("image","&",$link);	
		
		 $player->vars["espn_player"] = $player_id;      
		 $player->vars["image"] = $image;
		 echo "Player ".$name." Updated<BR>";
		 $player->update(array("espn_player","image"));	 
		 
		} else {
			
		echo "http://espn.go.com/mlb/players?search=".$name." Not Picture Yet<BR>";
		}

  } else {
	  
	  
	   echo "http://espn.go.com/mlb/players?search=".$name." Not Found<BR>";
     
  
  }


}



?>