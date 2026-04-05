<? include(ROOT_PATH . "/ck/process/functions.php"); ?>
<? include("Snoopy.class.php"); ?>
<?
$snoopy = new Snoopy;
$user = "mv22110";
$pass = "marcos";
$rotation = "221";
$type = "total";
$league = "Football_NFL*0";
$url_league = "NFL%20Football";
$amount = "10000";

//Login
$data = array('customerID'=>$user, 'password'=>$pass);
$snoopy->submit("http://lb.wagerweb.com/LoginVerify.Asp",$data);

$snoopy->fetch("http://lb.wagerweb.com/BbSportSelection.asp?id=".$url_league);
$html = $snoopy->results;

//step1
$code = get_value_by_id($html, "inetWagerNumber");
$data = array('inetWagerNumber'=>$code,'inetSportSelection'=>'sport',$league=>'on');
$snoopy->submit("http://lb.wagerweb.com/BbGameSelection.asp",$data);
$html = $snoopy->results;

//step2
$code = get_value_by_id($html, "inetWagerNumber");
$line = get_line($html, $rotation, $type);
$data = array('inetWagerNumber'=>$code,'radiox'=>'wageredType',$line["input"]=>$amount);
$snoopy->submit("http://lb.wagerweb.com/BbVerifyWager.asp",$data);
$html = $snoopy->results;

//step3
//$code = get_value_by_id($html, "inetWagerNumber");
//$data = array('inetWagerNumber'=>$code,'password'=>$pass);
//$snoopy->submit("http://lb.wagerweb.com/CheckAcceptancePassword.asp",$data);
//$html = $snoopy->results;

echo $html;


function get_value_by_id($html, $id){
	$DOM = new DOMDocument;
	@$DOM->loadHTML($html);
	$element = $DOM->getElementById($id);
	return $element->getAttribute("value");	
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

?>