<?

$latitud = $_GET["latitude"];
$longitud = $_GET["longitude"];

$parse = new _weather_parse_bridge();
$daily = $parse->get_current_weather($latitud,$longitud);

echo json_encode($daily);

class _weather_parse_bridge{
	
	var $code = array();
	
	function _weather_parse_bridge(){
		$this->code["api"]= "bc0369f637e1059fece9f30f6b038c35";
	}

	
	function get_current_weather($latitud,$longitud){
		$current = array();
		
		//echo "https://api.darksky.net/forecast/".$this->code["api"]."/".$latitud.",".$longitud."<BR>";
		$json_string = file_get_contents("https://api.darksky.net/forecast/".$this->code["api"]."/".$latitud.",".$longitud."?exclude=currently,hourly,minutely,alerts,flags");
		$parsed_json = json_decode($json_string);
	    
        		  
		   $current["temp_min"] = $parsed_json->{'daily'}->{'data'}[0]->{'temperatureMin'};   
		   $current["temp_max"] = $parsed_json->{'daily'}->{'data'}[0]->{'temperatureMax'};   
		   $current["next_temp_min"] = $parsed_json->{'daily'}->{'data'}[1]->{'temperatureMin'};   
		   $current["next_temp_max"] = $parsed_json->{'daily'}->{'data'}[1]->{'temperatureMax'};  
		   $current["date"] =  date('Y-m-d', $parsed_json->{'daily'}->{'data'}[0]->{'time'});   
		   
		   
		return $current	;
	  }		

}


?>