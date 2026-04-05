<? include("dgs.php"); ?>
<?
//spread & moneyline & total(check final sort for total)
$accounts = array();
$accounts[] = array("url"=>"BOOK1","line"=>"-4");
$accounts[] = array("url"=>"BOOK2","line"=>"-7");
$accounts[] = array("url"=>"BOOK3","line"=>"-5");
$accounts[] = array("url"=>"BOOK4","line"=>"-4");
$accounts[] = array("url"=>"BOOK5","line"=>"-2");
$accounts[] = array("url"=>"BOOK6","line"=>"pk");
$accounts[] = array("url"=>"BOOK7","line"=>"1");
$accounts[] = array("url"=>"BOOK8","line"=>"-5");


$sorted = array();
foreach($accounts as $acc){
	
	if($acc["line"] == "pk"){$acc["line"] = 0;}
	if(is_null($sorted[$acc["line"]])){$sorted[$acc["line"]] = array();}
	$sorted[$acc["line"]][] = $acc;
}

krsort($sorted,SORT_NUMERIC);
//use this when bet is total over
//ksort($sorted,SORT_NUMERIC);


$final = array();
foreach($sorted as $saccs){
	foreach($saccs as $sacc){$final[] = $sacc;}	
}

print_r($final);



?>