<?
class _line_sorter{
	function sort($accounts, $type){
		$values = array();
		$data = array();
		foreach($accounts as $acc){
			$values[0] = preg_replace("/[^0-9 -.]/", '',str_replace("+","",trim($acc["line"]["line"])));
			$values[1] = preg_replace("/[^0-9 -.]/", '',str_replace("+","",trim($acc["line"]["juice"])));
			if($type == "money"){$line = "0";$juice = $values[0];}
			else{$line = $values[0];$juice = $values[1];}
			$data[] = array("line"=>$line,"juice"=>$juice,"acc"=>$acc);
		}
		
		if($type == "over"){
			$data_sorted = $this->array_orderby($data, 'line', SORT_ASC, 'juice', SORT_DESC);
		}else{
			$data_sorted = $this->array_orderby($data, 'line', SORT_DESC, 'juice', SORT_DESC);	
		}
		
		$final = array();
		foreach($data_sorted as $item){
			$final[] = $item["acc"];
		}
		
		return $final;
		
	}
	function sort2($accounts, $type){
		$sorted = array();
		foreach($accounts as $acc){
			
			if($acc["line"] == "pk"){$acc["line"]["line"] = 0;}
			if(is_null($sorted[$acc["line"]["line"]])){$sorted[$acc["line"]["line"]] = array();}
			$sorted[$acc["line"]["line"]][] = $acc;
		}
		
		if($type == "over"){
			ksort($sorted,SORT_NUMERIC);
		}else{
			krsort($sorted,SORT_NUMERIC);
		}		
		
		$final = array();
		foreach($sorted as $saccs){
			foreach($saccs as $sacc){$final[] = $sacc;}	
		}
		
		return $final;
		
	}
	function sort_keys($keys, $type){
	
		$data = array();
		foreach($keys as $key){
			$values = explode(" ",preg_replace("/[^0-9 -.]/", '',str_replace("+","",trim($this->decode_line($key)))));
			if($type == "money"){$line = "0";$juice = $values[0];}
			else{$line = $values[0];$juice = $values[1];}
			$data[] = array("line"=>$line,"juice"=>$juice,"key"=>$key);
		}
		
		if($type == "over"){
			$data_sorted = $this->array_orderby($data, 'line', SORT_ASC, 'juice', SORT_DESC);
		}else{
			$data_sorted = $this->array_orderby($data, 'line', SORT_DESC, 'juice', SORT_DESC);	
		}
		
		$final = array();
		foreach($data_sorted as $item){
			$final[] = $item["key"];
		}
		
		return $final;
		
	}
	
	function sort_line($type, $line, $juice){
		$res = "";
		if((trim($line)*1) > 0 && $type != "under"  && $type != "over"){$res .= "+";} 
		if($type == "over"){$res .= "o"; $line = abs($line);}
		if($type == "under"){$res .= "u"; $line = abs($line);} 
		if($type == "money"){$juice = "";} 
		if((trim($juice)*1) > 0){$juice = "+".$juice;}
		$res .= $line ." ". $juice;
		return $res;
	}
	
	function encode_line($line){
		return  str_replace(" ","_",str_replace("+","pls",str_replace(".","dot",$line)));	
	}
	function decode_line($line){
		return str_replace("_"," ",str_replace("pls","+",str_replace("dot",".",$line)));	
	}
	function array_orderby(){
		$args = func_get_args();
		$data = array_shift($args);
		foreach ($args as $n => $field) {
			if (is_string($field)) {
				$tmp = array();
				foreach ($data as $key => $row)
					$tmp[$key] = $row[$field];
				$args[$n] = $tmp;
				}
		}
		$args[] = &$data;
		call_user_func_array('array_multisort', $args);
		return array_pop($args);
	}
	function get_bet_amounts($amount,$line){
		$bet_amunts = array();
		$line = trim($line);	
		$parts = explode(" ",$line);
		$juice = $parts[count($parts)-1];
		if($juice < 0){
			$bet_amunts["win"] = $amount;
			$bet_amunts["risk"] = round(($amount*abs($juice))/100);
		}else{
			$bet_amunts["win"] = round(($amount*abs($juice))/100);
			$bet_amunts["risk"] = $amount;
		}
		return $bet_amunts;
	}
}

?>