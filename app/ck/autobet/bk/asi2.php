<? include("Snoopy.class.php"); ?>
<?
include(ROOT_PATH . "/ck/process/functions.php");
$bot = new _asi_robot();
$bot->vars["user"] = "test105";
$bot->vars["pass"] = "1234";
$bot->vars["sport"] = "NBA";
$bot->vars["period"] = "game";
$bot->vars["amount"] = "50";
$bot->vars["rotation"] = "702";
$bot->vars["type"] = "spread";
$bot->vars["url"] = "engine.betosb.com";

$bot->login();
//$line = $bot->create_bet(false);
//print_r($line);
echo $bot->html;

class _asi_robot{
	var $vars = array();//user, pass, sport, amount, rotation, type, url
	var $html = "";
	var $snoopy;
	var $cookie_key = "";
	function _asi_robot(){
		$this->snoopy = new Snoopy;
		$this->cookie_key = date("YmdHis")."_".mt_rand(0,10000);
	}
	function get_league_selection(){
		
		//Set real period for asi
		$rperiod = ucwords($this ->vars["period"]);
		
		$league = "chk_".$this ->vars["sport"]."_".$rperiod;	
		
		return $league;
		
	}
	function login(){
		$data = array('customerID'=>$this->vars["user"], 'Password'=>$this->vars["pass"]);
		$this->getUrl("http://".$this->vars["url"]."/LoginVerify.asp", 'post', $data);
		$this->html = $this->getUrl("http://".$this->vars["url"]."/BbSportSelection.asp");
	}
	function create_bet($pre_place = false){
		
		$this->initiate_league();
		
		//step1
		$code = $this->get_value_by_id($this->html, "inetWagerNumber");
		$data = array('ScheduleText1'=>'','inetWagerNumber'=>$code,'inetSportSelection'=>'sport',$this->get_league_selection()=>'on');
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
	function place_bet(){
		//step3
		$code = $this->get_value_by_id($this->html, "inetWagerNumber");
		$data = array('inetWagerNumber'=>$code,'password'=>$this->vars["pass"]);
		$this->snoopy->submit("http://lb.wagerweb.com/CheckAcceptancePassword.asp",$data);
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
	
	function get_line($html, $rotation, $type){
		switch($type){
			case "money": $num1 = "3"; break;
			case "total": $num1 = "4"; break;
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
					$line["input"] = $inps->item(0)->getAttribute("name");			
				}
					
				break;
			}
		}
		return $line;
	}
	function getUrl($url, $method='', $vars='') {
		$ch = curl_init();
		if ($method == 'post') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies/'.$this->cookie_key.'.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies/'.$this->cookie_key.'.txt');
		$buffer = curl_exec($ch);
		curl_close($ch);
		return $buffer;
	}
	function initiate_league(){
		$sport = strtoupper($this->vars["sport"]);
		$period = strtoupper($this->vars["period"]);
		if($period==""){$period = "GAME";}
		switch($sport){
			case "NFL":
				$this->vars["leagueURL"] = "NFL%20Football";
				switch($period){
					case "GAME":
						$this->vars["league"] = "Football_NFL*0";
					break;
					case "1H":
						$this->vars["league"] = "Football_NFL*1";
					break;
					case "2H":
						$this->vars["league"] = "Football_NFL*2";
					break;
					case "1Q":
						$this->vars["league"] = "Football_NFL*3";
					break;
					case "2Q":
						$this->vars["league"] = "Football_NFL*4";
					break;
					case "3Q":
						$this->vars["league"] = "Football_NFL*5";
					break;
					case "4Q":
						$this->vars["league"] = "Football_NFL*6";
					break;
				}
			break;
			case "NCAAF":
				$this->vars["leagueURL"] = "NCAA%20Football";
				switch($period){
					case "GAME":
						$this->vars["league"] = "Football_College*0";
					break;
					case "1H":
						$this->vars["league"] = "Football_College*1";
					break;
					case "2H":
						$this->vars["league"] = "Football_College*2";
					break;
					case "1Q":
						$this->vars["league"] = "Football_College*3";
					break;
					case "2Q":
						$this->vars["league"] = "Football_College*4";
					break;
					case "3Q":
						$this->vars["league"] = "Football_College*5";
					break;
					case "4Q":
						$this->vars["league"] = "Football_College*6";
					break;
				}
			break;
			case "NBA":
				$this->vars["leagueURL"] = "NBA%20Basketball";
				switch($period){
					case "GAME":
						$this->vars["league"] = "Basketball_NBA*0";
					break;
					case "1H":
						$this->vars["league"] = "Basketball_NBA*1";
					break;
					case "2H":
						$this->vars["league"] = "Basketball_NBA*2";
					break;
					case "1Q":
						$this->vars["league"] = "Basketball_NBA*3";
					break;
					case "2Q":
						$this->vars["league"] = "Basketball_NBA*4";
					break;
					case "3Q":
						$this->vars["league"] = "Basketball_NBA*5";
					break;
					case "4Q":
						$this->vars["league"] = "Basketball_NBA*6";
					break;
				}
			break;
			case "NCAAB":
				$this->vars["leagueURL"] = "NCAA%20Basketball";
				switch($period){
					case "GAME":
						$this->vars["league"] = "Basketball_NCAA*0";
					break;
					case "1H":
						$this->vars["league"] = "NCAA%Basketball_NCAA*1";
					break;
					case "2H":
						$this->vars["league"] = "Basketball_NCAA*2";
					break;
				}
			break;
			case "MLB":
				//Pending
			break;
			case "NHL":
				//Pending
			break;
		}
	}
}

?>