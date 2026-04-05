<? include(ROOT_PATH . "/ck/process/functions.php"); ?>
<?


$line = get_line_from_html(file_get_contents("test.html"), 951, "over");

print_r($line);

function get_line_from_html($html, $rotation, $type){
		switch($type){
			case "money": $num1 = "2"; break;
			case "over": $num1 = "3"; break;
			case "under": $num1 = "3"; $rotation++; break;
			case "spread": $num1 = "1"; break;	
		}
		
		$DOM = new DOMDocument;
		@$DOM->loadHTML($html);
		$items = $DOM->getElementsByTagName('td');
		$line = array();
		for ($i = 0; $i < $items->length; $i++){
			$spans = $items->item($i)->getElementsByTagName("strong");
			$value = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%+&-]/s', '', $spans->item(0)->nodeValue);
			echo $value."<br />";
			if(strval($value) == strval($rotation)){
				//echo $items->item($i+$num1)->nodeValue."<br />";
				$line["line"] = str_replace("½",".5",$items->item($i+$num1)->nodeValue);
				$line["line"] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%+&-]/s', '', $line["line"]);
				
				$inps = $items->item($i+$num1)->getElementsByTagName("input");
				if(!is_null($inps->item(0))){
					$line["input"] = $inps->item(1)->getAttribute("name");			
				}
				//break;
			}
		}
		return $line;
	}

?>