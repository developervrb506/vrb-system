<?php //BORRAR ESTO




  $data = $_POST["action"]."/".$_POST["date"]."/";
  foreach($_POST['chk'] as $d){
	  $data .= $d."/";
  }
  
 $data = rtrim($data,"/");
  //echo "http://www.sportsbettingonline.ag/utilities/process/weather/action.php?data=".$data;
  file_get_contents("http://www.sportsbettingonline.ag/utilities/process/weather/action.php?data=".$data); 
  //exit;
  switch($_POST["action"]){
    case "games":
    	header("Location: " . BASE_URL . "/ck/weather_system/create_line.php?from=".$_POST["date"]);
	    break;	
	case "matchups":	
    	header("Location: " . BASE_URL . "/ck/weather_system/create_matchups.php?from=".$_POST["date"]);
	    break;	

  }
 

?>