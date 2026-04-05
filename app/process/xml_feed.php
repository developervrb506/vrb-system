<?
header("Location: http://asiwebservices.wagerweb.ag:8080/BetService/SvcGJLineFeed.asmx?op=GetLines")  // This was changed on 2015-03-04, it looks like now use a Soap web service. it has to be parsed to get the lines.


/*
header('Content-type: text/xml');
include(ROOT_PATH . "/process/functions.php");
$league_p = $_GET["le"];

//patch
// replace strstr for myStrstrTrue

if($_GET["bk"]==1){

$url = "http://feeds.wagerweb.ag/";
$url_string = @file_get_contents($url);


	switch ($league_p) {
	
	
	
	
	
		
		case 'NFL':		
		   $sportType = 'Football';
		   $sportSubType = 'NFL';
		   $str = '<league name="NFL" ';
           $str.= str_center_string('name="NFL"',"<league",$url_string);
           $str =  myStrstrTrue($str,"</league>",true); 
           if ($str=="") {$str = '<league name="NFL" >';}
		   $str .= "</league>";
		   
		   break;
		
		case 'MLB':		
		   $sportType = 'Baseball';
		   $sportSubType = 'MLB';
		   $str = '<league name="MLB" ';
           $str.= str_center_string('name="MLB"',"<league",$url_string);
           $str =  myStrstrTrue($str,"</league>",true); 
           if ($str=="") {$str = '<league name="MLB" >';}
		   $str .= "</league>";
		  
		   
		   
		   break;
		
		case 'NCAAF':		
		   $sportType = 'Football';
		   $sportSubType = 'College';
		   $str = '<league name="NCAAF" ';
           $str.= str_center_string('name="NCAAF"',"<league",$url_string);
           $str =  myStrstrTrue($str,"</league>",true); 
           if ($str=="") {$str = '<league name="NCAAF" >';}
		   $str .= "</league>";
		   
		   break;   
		
		case 'NCAAB':		
		   $sportType = 'Basketball';
		   $sportSubType = 'ncaa';
		   $str = '<league name="NCAAB" ';
           $str.= str_center_string('name="NCAAB"',"<league",$url_string);
           $str =  myStrstrTrue($str,"</league>",true); 
           if ($str=="") {$str = '<league name="NCAAB" >';}
		   $str .= "</league>";
		   
		   break;   
		
		case 'NBA':		
		   $sportType = 'Basketball';
		   $sportSubType = 'NBA';
		   $str = '<league name="NBA" ';
           $str.= str_center_string('name="NBA"',"<league",$url_string);
           $str =  myStrstrTrue($str,"</league>",true); 
           if ($str=="") {$str = '<league name="NBA" >';}
		   $str .= "</league>";
		   
		   break;   
		
		case 'NHL':		
		   $sportType = 'Hockey';
		   $sportSubType = 'NHL';
		   $str = '<league name="NHL" ';
           $str.= str_center_string('name="NHL"',"<league",$url_string);
           $str =  myStrstrTrue($str,"</league>",true); 
           if ($str=="") {$str = '<league name="NHL" >';}
		   $str .= "</league>";  
		   break;
		   
		case 'MMA':		
		   $sportType = 'Boxing/mma';
		   $sportSubType = 'mma';
		   $str = '<league name="MMA" ';
           $str.= str_center_string('name="MMA"',"<league",$url_string);
           $str =  myStrstrTrue($str,"</league>",true); 
           if ($str=="") {$str = '<league name="MMA" >';}
		   $str .= "</league>";
		   break;
		   
		case 'BOXING':		
		   $sportType = 'Boxing/mma';
		   $sportSubType = 'boxing';
		   $str = '<league name="Boxing" ';
           $str.= str_center_string('name="Boxing"',"<league",$url_string);
           $str =  myStrstrTrue($str,"</league>",true); 
           if ($str=="") {$str = '<league name="BOXING" >';} 
		   $str .= "</league>";
		   break;
		   
		case 'TENNIS':		
		   $sportType = 'tennis';
		   $sportSubType = '';		   
		   $str = '<league name="ATP" ';
           $str.= str_center_string('name="ATP"',"<league",$url_string);
           $str =  myStrstrTrue($str,"</league>",true); 
           $str .= "</league>";
		   $str .= '<league name="WTA" ';
           $str.= str_center_string('name="WTA"',"<league",$url_string);
           $str =  myStrstrTrue($str,"</league>",true); 
           if ($str=="") {$str = '<league name="TENNIS" >';} 
		   $str .= "</league>";
		   break;
		   
		case 'SOCCER':		
		   $sportType = 'soccer';
		   $sportSubType = '';		   
		   $str = '<league name="Soccer" ';
           $str.= str_center_string('name="Soccer"',"<league",$url_string);
           $str =  myStrstrTrue($str,"</league>",true); 
           if ($str=="") {$str = '<league name="SOCCER" >';} 
		   $str .= "</league>";
		  
		  
		   break;   		
	}	
	
	$xml_str = $str;
	//$xml_str = file_get_contents('http://feed.wagerweb.com/xmlfeedinsNew.asp?sportType='.$sportType.'&sportSubType='.$sportSubType);		

}else if($_GET["bk"]==3){
	switch ($league_p) {
		
		case 'NFL':
			$id = "NFL";
		   break;
		   
		case 'SOC':
			$id = "SOC";
		   break;
		
		case 'MLB':		
		   $id = "MLB";
		   break;
		
		case 'NCAAF':		
		   $id = "CFB";
		   break;   
		
		case 'NCAAB':		
		   $id = "CBB";
		   break;   
		
		case 'NBA':		
		   $id = "NBA";
		   break;   
		
		case 'NHL':		
		   $id = "NHL";
		   break;
		   
		case 'MMA':		
		   $id = "MU";
		   break;
		   
		case 'BOXING':
		   $id = "MU";
		   break;
	}
	$xml_str = str_replace("Error","",file_get_contents("http://www.sportsbettingonline.ag/engine/xmlfeed/?IdSport=$id"));
	$xml_str = str_replace("NHLLine=","Line=",trim($xml_str));
}

echo $xml_str;
*/
?>