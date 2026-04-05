<? include(ROOT_PATH . "/ck/process/functions.php"); ?>
<?
$user = "betowitest";
$pass = "123";
$league = "779";
$amount = "30000";
$rotation = "101";
$type = "spread";


//Login
$data = array('Account'=>$user, 'Password'=>$pass);
getUrl("http://www.sportsbettingonline.ag/engine/", 'post', $data);

$html = strip_tags(getUrl("http://www.sportsbettingonline.ag/engine/wager/CreateSports.aspx?WT=11"), "<input>");

//step1
$code = get_value_by_id($html, "__VIEWSTATE");
$data = array('__VIEWSTATE'=>$code,'ctl00$WagerContent$btn_Continue_top'=>'Continue','lg_'.$league=>$league);
$html = getUrl("http://www.sportsbettingonline.ag/engine/wager/CreateSports.aspx?WT=11", 'post', $data);

//step2
$code = get_value_by_id($html, "__VIEWSTATE");
$line = get_line($html, $rotation, $type);
$linecode = implode("_",$line); // example: 0_1466990_-6.5_-110
$data = array('__VIEWSTATE'=>$code,'ctl00$WagerContent$btn_Continue0'=>'Continue','text_'.$linecode=>$amount);
$html = getUrl("http://www.sportsbettingonline.ag/engine/wager/Schedule.aspx?WT=11&lg=".$league, 'post', $data);

//step3
$code = get_value_by_id($html, "__VIEWSTATE");
$gameid = $line[1]."_".$line[0];
$data = array('__VIEWSTATE'=>$code/*,'BUY_1466990_0'=>'0'*/,'AMT_'.$gameid=>$amount,'UseSameAmount'=>'1','ctl00$WagerContent$btn_Continue1'=>'Continue');
$html = getUrl("http://www.sportsbettingonline.ag/engine/wager/CreateWager.aspx?WT=11&lg=".$league."&sel=".$linecode."_".$amount, 'post', $data);

echo $html;

//step 4
//$code = get_value_by_id($html, "__VIEWSTATE");
//$data = array('__VIEWSTATE'=>$code,'password'=>$pass,'ctl00$WagerContent$btn_Continue1'=>'Continue');
//echo getUrl("http://www.sportsbettingonline.ag/engine/wager/ConfirmWager.aspx?WT=11", 'post', $data);

function getUrl($url, $method='', $vars='') {
    $ch = curl_init();
    if ($method == 'post') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
    $buffer = curl_exec($ch);
    curl_close($ch);
    return $buffer;
}
function get_value_by_id($html, $id){
	$DOM = new DOMDocument;
	@$DOM->loadHTML($html);
	$element = $DOM->getElementById($id);
	return $element->getAttribute("value");	
}

function get_line($html, $rotation, $type){
	switch($type){
		case "money": $num1 = "4"; $num2 = "5"; break;
		case "total": $num1 = "2"; $num2 = "3"; break;
		case "spread": $num1 = "0"; $num2 = "1"; break;	
	}
	
	$DOM = new DOMDocument;
	@$DOM->loadHTML($html);
	$items = $DOM->getElementsByTagName('td');
	$line = array();
	for ($i = 0; $i < $items->length; $i++){
		if($items->item($i)->nodeValue == $rotation){
			for($e = 2; $e < 7; $e++){				
				$inps = $items->item($i+$e)->getElementsByTagName("input");
				if(!is_null($inps->item(0))){
					$name = $inps->item(0)->getAttribute("name");
					if(contains_ck($name,"text_".$num1) || contains_ck($name,"text_".$num2)){
						$line  = explode("_",str_replace("text_","",$name));
						break;
					}
				}
			}			
			break;
		}
	}
	return $line;
}

?>