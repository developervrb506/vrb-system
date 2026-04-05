<?
require_once(ROOT_PATH . "/process/functions.php");
$affiliates = get_all_affiliates();

foreach($affiliates as $af){
	$books = get_sportsbooks_by_affiliate($af->id);
	
	foreach($books as $bk){
		$endo = get_endorsement($af->id,$bk->id);
		if(count($endo)<2 || $endo[0] == ""){
			echo $af->name . " ". $af->last_name . "," . $af->email . "<br />";
		}
	} 
}

?>