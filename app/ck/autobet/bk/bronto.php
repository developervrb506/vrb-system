<? include(ROOT_PATH . "/ck/process/functions.php"); ?>
<? include("Snoopy.class.php"); ?>
<?
$snoopy = new Snoopy;
$user = "vrbmarketing";
$pass = "scottvrb";

$snoopy->fetch("https://www.ezpay.com");
$html = $snoopy->results;
//$code = get_value_by_id($html, "_key");
////Login
//$data = array('username'=>$user, 'password'=>$pass, 'fn'=>'Login', '_key'=>$code);
//$snoopy->submit("https://app.bronto.com/login/index/login/",$data);
//
//$snoopy->fetch("http://app.bronto.com/agency/?q=morph&fn=View&id=23220");
//$html = $snoopy->results;

echo $html;


function get_value_by_id($html, $id){
	$DOM = new DOMDocument;
	@$DOM->loadHTML($html);
	$element = $DOM->getElementById($id);
	return $element->getAttribute("value");	
}

?>