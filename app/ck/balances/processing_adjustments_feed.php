<?
include(ROOT_PATH . "/ck/db/handler.php");  
$adjusted_balances = get_adjusted_balances("a","processing");
$processors = @split(",",file_get_contents("https://www.ezpay.com/wu/balances_api/processors_balances.php"));

$i=0;
$sub = 0;
$asub = 0;
$adjustments = array();
foreach($processors as $pr){
	$processor = @split("/",$pr);
	if($i % 2){$style = "1";}else{$style = "2";} $i++;
	$sub += $processor[1];
	$adj = $adjusted_balances[$processor[0]]->vars["balance"];
	if(is_null($adj)){$adj = $processor[1];}else{$adj = $processor[1] - $adj;}
	$asub += $adj;
	
	$adjustments[strtolower(preg_replace("/[^A-Za-z0-9]/", '', $processor[0]))] = $adj;
}

echo json_encode($adjustments);

?>