<? include(ROOT_PATH . "/ck/db/handler.php"); 
set_time_limit(0);
$acc = get_betting_account($_GET["aid"]);
$settings = get_betting_auto_settings($acc->vars["id"]);
$bet_line = $_GET["line"];
$bet_juice = $_GET["juice"];
$action = $_GET["action"];

$softwares = get_all_betting_softwares();
foreach($softwares as $soft){	
	include(ROOT_PATH . "/ck/autobet/".strtolower($soft->vars["name"]).".php");
}

eval("\$bot = new _".strtolower($softwares[$settings->vars["software"]]->vars["name"])."_robot();");	
$bot->vars["user"] = $acc->vars["name"];
$bot->vars["pass"] = $settings->vars["password"];
$bot->vars["sport"] = $_GET["sport"];
$bot->vars["period"] = $_GET["period"];
$bot->vars["amount"] = $_GET["amount"];
$bot->vars["rotation"] = $_GET["rotation"];
$type = $_GET["type"];
if($type == "over"){$sub_type = $type; $type = "total";}
if($type == "under"){$sub_type = $type; $type = "total"; $bot->vars["rotation"]++;}
$bot->vars["type"] = $type;
$bot->vars["url"] = $settings->vars["url"];	

if($action == "auto"){$preplace = true;}else{$preplace = false;}

$bot->login();
$line = $bot->create_bet($preplace);

echo ":::";

if(!is_null($line) && ($line["line"] != "" || $line["line"] != "")){
	switch($bot->vars["type"]){
		case "money":
		
			if(is_better_juice($bet_juice, $line["juice"])){$place = true;}
			else{$place = false;}
			
		break;
		case "spread":
			if($bet_line < 0){
			
				if(($line["line"]*-1) <= ($bet_line*-1)){
					if(is_better_juice($bet_juice, $line["juice"])){$place = true;}
					else{$place = false;}
				}else{$place = false;}
				
			}else if ($bet_line > 0){
				
				if($line["line"] >= $bet_line){
					if(is_better_juice($bet_juice, $line["juice"])){$place = true;}
					else{$place = false;}
				}else{$place = false;}
				
			}
			
		break;
		case "total":
		
			if($sub_type == "over"){
				
				if($line["line"] <= $bet_line){
					if(is_better_juice($bet_juice, $line["juice"])){$place = true;}
					else{$place = false;}
				}else{$place = false;}
				
			}else if($sub_type == "under"){
				
				if($line["line"] >= $bet_line){
					if(is_better_juice($bet_juice, $line["juice"])){$place = true;}
					else{$place = false;}
				}else{$place = false;}
				
			}
		
		break;	
	}
	
	echo $line["line"].$line["juice"];
	
	echo ": ";
	
	if($place){
		if($action == "auto"){
			//place bet
			$result = $bot->place_bet();
			if($result == 1){
				echo "Placed";
			}else{
				echo "Error!." . $result;
			}
			
		}else if($action == "manual"){
			//pint bet btn
			echo "Place this Bet";
			
		}
	}
	else{echo "Not applicable";}
	
	
	
}else{
	echo "The game was not found";	
}

echo ":::";

?>