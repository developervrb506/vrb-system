<? 
/*include(ROOT_PATH . "/ck/process/functions.php"); //just for test 
$bot = new _dgs_robot();
$bot->vars["user"] = "test";
$bot->vars["pass"] = "test";
$bot->vars["sport"] = "NCAAB";
$bot->vars["period"] = "game";
$bot->vars["amount"] = "103";
$bot->vars["rotation"] = "520";
$bot->vars["type"] = "money";
$bot->vars["url"] = "yopig.ag/core/";	

$bot->login();
$line = $bot->create_bet(true);
//print_r($line);
echo $bot->place_bet();
//echo $bot->html;*/


class _dgs_robot{
	var $vars = array();//user, pass, sport, amount, rotation, type, url
	var $html = "";
	var $cookie_key = "";
	var $message = "";
	var $proxy = array();
	var $logged = false;
	function _dgs_robot($proxy = NULL){
		$this->cookie_key = date("YmdHis")."_".mt_rand(0,10000);
		if(is_object($proxy)){
			$this->proxy = $proxy;
		}
	}
	function login(){
		$data = array('Account'=>$this->vars["user"], 'Password'=>$this->vars["pass"]);
		$this->getUrl("http://".$this->vars["url"]."/".$this->vars["site_name"]."/Login.aspx", 'post', $data);
		$this->html = strip_tags($this->getUrl("http://".$this->vars["url"]."/".$this->vars["site_name"]."/wager/CreateSports.aspx?WT=0"), "<input>");
		if(contains_ck($this->html,"CreateSports.aspx")){$this->logged = true;}
		else{$this->message = "Login Failed";}
	}
	
	function get_my_ip(){
		return $this->getUrl("http://localhost:8080/ip.php");
	}
	
	function create_bet($pre_place = false){
		
		$this->message = "";
		
		$this->initiate_league();
		
		//step1
		$code = $this->get_value_by_id($this->html, "__VIEWSTATE");
		$data = array('__VIEWSTATE'=>$code,'ctl00$WagerContent$btn_Continue_top'=>'Continue','ctl00$WagerContent$btn_Continue1'=>'Continue','lg_'.$this->vars["league"]=>$this->vars["league"]);
		$this->html = $this->getUrl("http://".$this->vars["url"]."/".$this->vars["site_name"]."/wager/CreateSports.aspx?WT=0", 'post', $data);
		
		
		//step2
		$code = $this->get_value_by_id($this->html, "__VIEWSTATE");
		$line = $this->get_line_from_html($this->html, $this->vars["rotation"], $this->vars["type"]);	
		
		if($pre_place){
			
			$linecode = implode("_",$line); // example: 0_1466990_-6.5_-110
			$data = array('__VIEWSTATE'=>$code,'ctl00$WagerContent$btn_Continue1'=>'Continue','text_'=>$linecode);
			$this->html = $this->getUrl("http://".$this->vars["url"]."/".$this->vars["site_name"]."/wager/Schedule.aspx?WT=0&lg=".$this->vars["league"], 'post', $data);
		
		
			//step3
			$code = $this->get_value_by_id($this->html, "__VIEWSTATE");
			$gameid = $line[1]."_".$line[0];
			$data = array('__VIEWSTATE'=>$code,
						'WAMT_'=>$this->vars["amount"],'UseSameAmount'=>'0',
						'ctl00$WagerContent$btn_Continue1'=>'Continue');
			$this->html = $this->getUrl("http://".$this->vars["url"]."/".$this->vars["site_name"]."/wager/CreateWager.aspx?WT=0&lg=".$this->vars["league"]."&sel=".$linecode."_".$this->vars["amount"], 'post', $data);
			
			if(contains_ck($this->html, "ctl00_WagerContent_ctl00_lblFollError")){$this->message = $this->get_innerHTML_by_id($this->html, "ctl00_WagerContent_ctl00_lblError");}
			
		}
		
		if($this->vars["type"] == "money"){$result_line = array("line"=>$line[3],"juice"=>"");}else{$result_line = array("line"=>$line[2],"juice"=>$line[3]);}
		return $result_line;
	}
	
	function get_other_line($rotation){
		$line = $this->get_line_from_html($this->html, $rotation, $this->vars["type"]);
		if($this->vars["type"] == "money"){$result_line = array("line"=>$line[3],"juice"=>"");}else{$result_line = array("line"=>$line[2],"juice"=>$line[3]);}
		return $result_line;
	}
	
	function place_bet(){
		//step 4
		if($this->message == ""){
			$code = $this->get_value_by_id($this->html, "__VIEWSTATE");
			$data = array('__VIEWSTATE'=>$code,'password'=>$this->vars["pass"],'ctl00$WagerContent$btn_Continue1'=>'Continue');
			$this->html = $this->getUrl("http://".$this->vars["url"]."/".$this->vars["site_name"]."/wager/ConfirmWager.aspx?WT=0", 'post', $data);
			if(!contains_ck($this->html, "ctl00_WagerContent_ctl00_lblFollError")){$res = "ok";}
			else{$res = $this->get_innerHTML_by_id($this->html, "ctl00_WagerContent_ctl00_lblError");}
		}else{
			$res = $this->message;	
		}
		return $res;
	}
	
	function getUrl($url, $method='', $vars='') {
		$ch = curl_init();
		if ($method == 'post') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		
		if($this ->proxy->vars["ip"] != ""){
			curl_setopt($ch, CURLOPT_PROXY, $this ->proxy->vars["ip"]);
			if($this ->proxy->vars["port"] != ""){curl_setopt($ch, CURLOPT_PROXYPORT, $this ->proxy->vars["port"]);}
			if($this ->proxy->vars["user"] != ""){curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this ->proxy->vars["user"].':'.$this ->proxy->vars["password"]);}
		}
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies/'.$this->cookie_key.'.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies/'.$this->cookie_key.'.txt');
		$buffer = curl_exec($ch);
		curl_close($ch);
		return $buffer;
	}
	function get_value_by_id($html, $id){
		$DOM = new DOMDocument;
		@$DOM->loadHTML($html);
		$element = $DOM->getElementById($id);
		if(!is_null($element)){$res = $element->getAttribute("value");}else{$res = "";}
		return 	$res;
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
	
	
	function get_line_from_html($html, $rotation, $type){
		switch($type){
			case "money": $num1 = "4"; $num2 = "5"; break;
			case "over": $num1 = "2"; $num2 = "3"; break;
			case "under": $num1 = "2"; $num2 = "3"; $rotation++; break;
			case "spread": $num1 = "0"; $num2 = "1"; break;	
		}
		
		$DOM = new DOMDocument;
		@$DOM->loadHTML($html);
		$items = $DOM->getElementsByTagName('td');
		$line = array();
		for ($i = 0; $i < $items->length; $i++){
			$spans = $items->item($i)->getElementsByTagName("span");
			if(substr($items->item($i)->nodeValue,-3) == $rotation || substr($spans->item(0)->nodeValue,-3) == $rotation){
				for($e = 2; $e < 7; $e++){
					if(!is_null($items->item($i+$e))){		
						$inps = $items->item($i+$e)->getElementsByTagName("input");
						if(!is_null($inps->item(0))){
							$name = $inps->item(0)->getAttribute("value");
							if(substr($name,0,2) == $num1."_" || substr($name,0,2) == $num2."_"){
								$line  = explode("_",$name);
								break;
							}
						}
					}
				}			
				break;
			}
		}
		/*if($line[3] == "100"){$line[3] = "+100";}
		if(!contains_ck($line[3],"-") && !contains_ck($line[3],"+") && trim($line[3]) != ""){$line[3] = "+".$line[3];}*/
		return $line;
	}
	
	function initiate_league(){
		$sport = strtoupper($this->vars["sport"]);
		$period = strtoupper($this->vars["period"]);
		if($period==""){$period = "GAME";}
		
		if($this->vars["url"] == 'play3.2bet.ag'){
			
			
			switch($sport){
				case "NFL":
					switch($period){
						case "GAME":
							$this->vars["league"] = "xxxxx";
						break;
						case "1H":
							$this->vars["league"] = "xxxxx";
						break;
						case "2H":
							$this->vars["league"] = "xxxxx";
						break;
						case "1Q":
							$this->vars["league"] = "xxxxx";
						break;
						case "2Q":
							$this->vars["league"] = "xxxxx";
						break;
						case "3Q":
							$this->vars["league"] = "xxxxx";
						break;
						case "4Q":
							$this->vars["league"] = "xxxxx";
						break;
					}
				break;
				case "NCAAF":
					switch($period){
						case "GAME":
							$this->vars["league"] = "xxxxx";
						break;
						case "1H":
							$this->vars["league"] = "xxxxx";
						break;
						case "2H":
							$this->vars["league"] = "xxxxx";
						break;
					}
				break;
				case "NBA":
					switch($period){
						case "GAME":
							$this->vars["league"] = "3";
						break;
						case "1H":
							$this->vars["league"] = "326";
						break;
						case "2H":
							$this->vars["league"] = "xxxx";
						break;
						case "1Q":
							$this->vars["league"] = "xxxx";
						break;
						case "2Q":
							$this->vars["league"] = "xxxx";
						break;
						case "3Q":
							$this->vars["league"] = "xxxx";
						break;
						case "4Q":
							$this->vars["league"] = "xxxx";
						break;
					}
				break;
				case "NCAAB":
					switch($period){
						case "GAME":
							$this->vars["league"] = "xxxx";
						break;
						case "1H":
							$this->vars["league"] = "xxxx";
						break;
						case "2H":
							$this->vars["league"] = "xxxx";
						break;
					}
				break;
				case "MLB":
					switch($period){
						case "GAME":
							$this->vars["league"] = "5";
						break;
						case "1H":
							$this->vars["league"] = "404";
						break;
						case "2H":
							$this->vars["league"] = "405";
						break;
					}
				break;
				case "NHL":
					switch($period){
						case "GAME":
							$this->vars["league"] = "7";
						break;
					}
				break;
			}
			
			
		}else{
			
			switch($sport){
				case "NFL":
					switch($period){
						case "GAME":
							$this->vars["league"] = "779";
						break;
						case "1H":
							$this->vars["league"] = "68";
						break;
						case "2H":
							$this->vars["league"] = "69";
						break;
						case "1Q":
							$this->vars["league"] = "77";
						break;
						case "2Q":
							$this->vars["league"] = "78";
						break;
						case "3Q":
							$this->vars["league"] = "79";
						break;
						case "4Q":
							$this->vars["league"] = "80";
						break;
					}
				break;
				case "NCAAF":
					switch($period){
						case "GAME":
							$this->vars["league"] = "784";
						break;
						case "1H":
							$this->vars["league"] = "70";
						break;
						case "2H":
							$this->vars["league"] = "71";
						break;
						case "1Q":
							$this->vars["league"] = "81";
						break;
						case "2Q":
							$this->vars["league"] = "xxxxxxxxxx";
						break;
						case "3Q":
							$this->vars["league"] = "xxxxxxxxxx";
						break;
						case "4Q":
							$this->vars["league"] = "xxxxxxxxxx";
						break;
					}
				break;
				case "NBA":
					switch($period){
						case "GAME":
							$this->vars["league"] = "778";
						break;
						case "1H":
							$this->vars["league"] = "26";
						break;
						case "2H":
							$this->vars["league"] = "27";
						break;
						case "1Q":
							$this->vars["league"] = "43";
						break;
						case "2Q":
							$this->vars["league"] = "44";
						break;
						case "3Q":
							$this->vars["league"] = "45";
						break;
						case "4Q":
							$this->vars["league"] = "46";
						break;
					}
				break;
				case "NCAAB":
					switch($period){
						case "GAME":
							$this->vars["league"] = "781";
						break;
						case "1H":
							$this->vars["league"] = "24";
						break;
						case "2H":
							$this->vars["league"] = "25";
						break;
					}
				break;
				case "MLB":
					switch($period){
						case "GAME":
							$this->vars["league"] = "782";
						break;
						case "1H":
							$this->vars["league"] = "318";
						break;
						case "2H":
							$this->vars["league"] = "681";
						break;
					}
				break;
				case "NHL":
					switch($period){
						case "GAME":
							$this->vars["league"] = "783";
						break;
					}
				break;
			}
			
		}
		
		
	}
}




?>