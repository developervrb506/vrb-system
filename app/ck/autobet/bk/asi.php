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
	function _asi_robot(){
		$this->snoopy = new Snoopy;
	}
	
	function login(){
		//Login
		$data = array('customerID'=>$this->vars["user"], 'Password'=>$this->vars["pass"], 'Site'=>$this->vars["site_name"], 'DomainURL'=>$this->vars["site_domain"]);
		$this->snoopy->submit("http://".$this->vars["url"]."/LoginVerify.asp",$data);
		
		$this->snoopy->fetch("http://".$this->vars["url"]."/SbSportSelection.asp");
		$this->html = $this->snoopy->results;
	}
	function create_bet($pre_place = false){
		
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
		//$code = $this->get_value_by_id($this->html, "inetWagerNumber");
		$line = $this->get_line($this->html, $this->vars["rotation"], $this->vars["type"]);
		
		$final_line = $this->prepare_line($line["line"]);
		
		if($pre_place){
		
			$data = array("inetWagerNumber"=>$code,"radiox"=>$line["input"]);
			if($this ->vars["type"] != "money"){$data[$line["input"]."buyToSelect"] = preg_replace("/[^0-9.]/", "",$final_line["line"]);}
			$this->snoopy->submit("http://".$this->vars["url"]."/SbWagerAmount.asp",$data);
			$this->html = $this->snoopy->results;
			
			$data = array('inetWagerNumber'=>$code,'radiox'=>'riskType',"wagerAmt"=>$this->vars["amount"],"submit1"=>"Continue");
			if($this ->vars["type"] != "money"){$data[$line["input"]."buyToSelect"] = preg_replace("/[^0-9.]/", "",$final_line["line"]);}
			$this->snoopy->submit("http://".$this->vars["url"]."/SbVerifyWager.asp",$data);
			$this->html = $this->snoopy->results;
		
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
		$code = $this->get_value_by_id($this->html, "inetWagerNumber");
		$data = array('inetWagerNumber'=>$code,'password'=>$this->vars["pass"],'submit1'=>"Submit+Password");
		$this->snoopy->submit("http://".$this->vars["url"]."/CheckAcceptancePassword.asp",$data);
		$this->html = $this->snoopy->results;
		if(!contains_ck(strtolower($this->html), "error")){$res = true;}
		else{$res = false;}
		return $res;
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
			
			if($value == $rotation){
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
			default :
				
			break;
		}
		return $type;
	}
	function get_asi_period(){
		$period = strtolower($this->vars["period"]);
		$asi_period = "";
		switch($period){ 
			case "game":
				$asi_period = "Game";
			break;
			default :
				
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
		$line = str_replace("+","",$line);
		$line = str_replace(" ","",$line);
		$line = trim($line);
		$parts = split_line($line);
		$line = $parts[0];
		$juice = $parts[1];
		if(count($parts)==1){$juice = $line; $line = "";}
		
		if($this->vars["type"] == "money"){$result = array("line"=>$juice,"juice"=>"");}else{$result = array("line"=>$line,"juice"=>$juice);}
		
		return $result;
	}
	/*function create_bet2($pre_place = false){
		
		$this->initiate_league();
		
		//step1
		$code = $this->get_value_by_id($this->html, "inetWagerNumber");
		$data = array('ScheduleText1'=>'','inetWagerNumber'=>$code,'inetSportSelection'=>'sport',$this->get_league_selection()=>'on');
		print_r($data);
		$this->snoopy->submit("http://".$this->vars["url"]."/BbGameSelection.asp",$data);
		$this->html = $this->snoopy->results;
		
		//step2
		$code = $this->get_value_by_id($this->html, "inetWagerNumber");
		$line = $this->get_line($this->html, $this->vars["rotation"], $this->vars["type"]);
		
		if($pre_place){
		
			$data = array('inetWagerNumber'=>$code,'radiox'=>'wageredType',$line["input"]=>$this->vars["amount"]);
			$this->snoopy->submit("http://".$this->vars["url"]."/BbVerifyWager.asp",$data);
			$this->html = $this->snoopy->results;
		
		}
		return prepare_line($line["line"]);
	}
	function get_league_selection(){
		
		//Set real period for asi
		$rperiod = ucwords($this ->vars["period"]);
		
		$league = "chk_".$this ->vars["sport"]."_".$rperiod;	
		
		return $league;
		
	}
	*/
}

?>