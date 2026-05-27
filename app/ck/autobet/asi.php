<? require_once("Snoopy.class.php"); ?>
<?
/*require_once(ROOT_PATH . "/ck/process/functions.php");
$bot = new _asi_robot();
$bot->vars["user"] = "test105";
$bot->vars["pass"] = "1234";
$bot->vars["sport"] = "NBA";
$bot->vars["period"] = "game";
$bot->vars["amount"] = "63";
$bot->vars["rotation"] = "710";
$bot->vars["type"] = "under";
$bot->vars["url"] = "engine.betosb.com";
$bot->vars["site_name"] = "betosb";
$bot->vars["site_domain"] = "betosb.com";

$bot->login();
$line = $bot->create_bet(true);
//$res = $bot->place_bet();
//if($res){echo "Bet Inserted";}else{echo "ERROR";}
print_r($line);
//echo $bot->html;
*/

class _asi_robot{
	var $vars = array();//user, pass, sport, amount, rotation, type, url
	var $html = "";
	var $snoopy;
	var $message = "";
	var $logged = false;
	function _asi_robot($proxy = NULL){
		$this->snoopy = new Snoopy;
		if(is_object($proxy)){
			$this->snoopy->proxy_host = $proxy->vars["ip"];
			$this->snoopy->proxy_port = $proxy->vars["port"];
			$this->snoopy->proxy_user = $proxy->vars["user"];
			$this->snoopy->proxy_pass = $proxy->vars["password"];
		}
	}
	
	function login(){
		//Login
		$data = array('customerID'=>$this->vars["user"], 'Password'=>$this->vars["pass"], 'Site'=>$this->vars["site_name"], 'DomainURL'=>$this->vars["site_domain"]);
		$this->snoopy->submit("http://".$this->vars["url"]."/LoginVerify.asp",$data);
		
		$this->snoopy->fetch("http://".$this->vars["url"]."/SbSportSelection.asp");
		$this->html = $this->snoopy->results;
		
		if(contains_ck($this->html,"inetWagerNumber ")){$this->logged = true;}
		else{$this->message = "Login Failed";}
	}
	function get_my_ip(){
		$this->snoopy->fetch(BASE_URL . "/ip.php");
		return 	$this->snoopy->results;
	}
	function create_bet($pre_place = false){
		
		$this->message = "";
		
		//step1
		$code = $this->get_original_code($this->html);
		
		$data = array('ScheduleText1'=>'',
					  'sportType'=>$this->get_sport_type(),
					  'sportSubType'=>$this->vars["sport"],
					  'sportPeriod'=>$this->get_asi_period(),
					  'inetWagerNumber'=>$code,
					  'inetSportSelection'=>'sport');
					  
		$this->snoopy->submit("http://".$this->vars["url"]."/SbGameSelection.asp",$data);
		$this->html = $this->snoopy->results;
		
		//step2
		$line = $this->get_line($this->html, $this->vars["rotation"], $this->vars["type"]);
		
		$final_line = $this->prepare_line($line["line"]);
		
		if($pre_place){
		
			$data = array("inetWagerNumber"=>$code,"radiox"=>$line["input"]);
			if($this ->vars["type"] != "money"){$data[$line["input"]."buyToSelect"] = preg_replace("/[^0-9.]/", "",$final_line["line"]);}
			$this->snoopy->submit("http://".$this->vars["url"]."/SbWagerAmount.asp",$data);
			$this->html = $this->snoopy->results;
			
			$data = array('inetWagerNumber'=>$code,'radiox'=>$final_line['amount_type'],"wagerAmt"=>$this->vars["amount"],"submit1"=>"Continue");
			if($this ->vars["type"] != "money"){$data[$line["input"]."buyToSelect"] = preg_replace("/[^0-9.]/", "",$final_line["line"]);}
			$this->snoopy->submit("http://".$this->vars["url"]."/SbVerifyWager.asp",$data);
			$this->html = $this->snoopy->results;
			
			if(contains_ck($this->html, "singleTxt large")){
				$this->html = str_replace('singleTxt large"','singleTxt large" id="VRBErrorMessage"',$this->html);
				$this->message = $this->get_innerHTML_by_id($this->html, "VRBErrorMessage");
			}else if(!contains_ck($this->html, "Password")){
				$this->message = "Website Error!";
			}
		
		}
		return $final_line;
	}
	
	function get_other_line($rotation){
		$line = $this->get_line($this->html, $rotation, $this->vars["type"]);		
		$final_line = $this->prepare_line($line["line"]);
		return $final_line;
	}
	
	
	function place_bet(){
		//step3
		if($this->message == ""){
			$code = $this->get_value_by_id($this->html, "inetWagerNumber");
			$data = array('inetWagerNumber'=>$code,'password'=>$this->vars["pass"],'submit1'=>"Submit+Password");
			$this->snoopy->submit("http://".$this->vars["url"]."/CheckAcceptancePassword.asp",$data);
			$this->html = $this->snoopy->results;
			if(!contains_ck(strtolower($this->html), "error")){$res = "ok";}
			else{$res = "There was an error placing the bet";}
		}else{
			$res = $this->message;	
		}
		return $res;
	}
	
	function get_innerHTML_by_id($html, $id){
		$DOM = new DOMDocument;
		@$DOM->loadHTML($html);
		$element = $DOM->getElementById($id);
		$innerHTML = ""; 
		$children = $element->childNodes; 
		foreach ($children as $child) 
		{ 
			$tmp_dom = new DOMDocument(); 
			$tmp_dom->appendChild($tmp_dom->importNode($child, true)); 
			$innerHTML.=trim($tmp_dom->saveHTML()); 
		} 
		return $innerHTML; 
	}
	
	function get_value_by_id($html, $id){
		$DOM = new DOMDocument;
		@$DOM->loadHTML($html);
		$element = $DOM->getElementById($id);
		if(!is_null($element)){$value = $element->getAttribute("value");}else{$value = NULL;}
		return $value;
	}
	
	function get_original_code($html){
		$parts = explode("options.inetWagerNumber = ",$html);
		$parts2 = explode(";",$parts[1]);
		$code = $parts2[0];
		return $code;
	}
	
	function get_line($html, $rotation, $type){
		switch($type){
			case "money": $num1 = "3"; break;
			case "over": $num1 = "4"; break;
			case "under": $num1 = "4"; $rotation++; break;
			case "spread": $num1 = "2"; break;	
		}
		
		$DOM = new DOMDocument;
		@$DOM->loadHTML($html);
		$items = $DOM->getElementsByTagName('td');
		$line = array();
		for ($i = 0; $i < $items->length; $i++){
			$value = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%+&-]/s', '', $items->item($i)->nodeValue);	
			if(strval($value) == strval($rotation)){
				$line["line"] = str_replace("½",".5",$items->item($i+$num1)->nodeValue);
				$line["line"] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%+&-]/s', '', $line["line"]);
				
				$inps = $items->item($i+$num1)->getElementsByTagName("input");
				if(!is_null($inps->item(0))){
					$line["input"] = $inps->item(0)->getAttribute("value");			
				}
				break;
			}
		}
		return $line;
	}
	function get_sport_type(){
		$sport = strtoupper($this->vars["sport"]);
		$type = "";
		switch($sport){ 
			case "NBA":
				$type = "Basketball";
			break;
			case "NFL":
				$type = "Football";
			break;
			case "MLB":
				$type = "Baseball";
			break;
			case "NHL":
				$type = "Hockey";
			break;
			case "NCAAF":
				$type = "Football";
			break;
			case "XFL":
				$type = "Football";
			break;
			case "NCAAB":
				$type = "Basketball";
			break;
			default :
				
			break;
		}
		return $type;
	}
	function get_asi_period(){
		$period = strtoupper($this->vars["period"]);
		$sport = strtoupper($this->vars["sport"]);
		$asi_period = "";
		switch($period){ 
			case "GAME":
				$asi_period = "Game";
			break;
			case "1H":
				if($sport == "MLB"){$asi_period = "1st 5 Innings";}
				else{$asi_period = "1st Half";}				
			break;
			case "2H":
				$asi_period = "2nd Half";
			break;
			case "1Q":
				$asi_period = "1st Quarter";
			break;
			case "2Q":
				$asi_period = "2nd Quarter";
			break;
			case "3Q":
				$asi_period = "3rd Quarter";
			break;
			case "4Q":
				$asi_period = "4th Quarter";
			break;
			case "1P":
				$asi_period = "1st Period";
			break;
			case "2P":
				$asi_period = "2nd Period";
			break;
			case "3P":
				$asi_period = "3rd Period";
			break;
			default :
				$asi_period = "xxxx";
			break;
		}
		return $asi_period;
	}
	function prepare_line($line){
		$line = strtolower($line);
		$line = str_replace("under","",$line);
		$line = str_replace("over","",$line);
		$line = str_replace("un","",$line);
		$line = str_replace("ov","",$line);
		$line = str_replace("u","",$line);
		$line = str_replace("o","",$line);
		$line = str_replace(" ","",$line);
		$line = trim($line);
		if(substr($line,0,1) == "+"){
			$line = substr($line,1);		
		}
		$parts = split_line($line);
		$line = $parts[0];
		$juice = $parts[1];
		if(count($parts)==1){$juice = $line; $line = "";}
		
		if($juice == "-100"){$juice = "100";}
		$juice = str_replace("+","",$juice);
		
		if($this->vars["type"] == "money"){
			$result = array("line"=>$juice,"juice"=>"");
		}else{
			$result = array("line"=>$line,"juice"=>$juice);
		}
		
		if(contains_ck($juice,"-")){
			$result["amount_type"] = "toWinType";
		}else{
			$result["amount_type"] = "riskType";
		}
		
		
		return $result;
	}
	
}

?>