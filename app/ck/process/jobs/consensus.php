<?
//require_once(ROOT_PATH . '/ck/process/functions.php');
$date = date("Y-m-d");
//$date = "2020-01-19";
$name = $date;

//$json_string = json_encode($data);
//$file = $local_path.'/'.$name;
//file_put_contents($file, $json_string);
$local_path = "./consensus_files";

	$file   = @file_get_contents('/consensus_files/'.$date.'.txt');
	$file_data = json_decode($file,true);	
	
	
	
   $consesus =  file_get_contents("http://www.sportsbettingonline.ag/utilities/jobs/consensus/print_consensus.php");
  
  if (!empty($file_data)){
	  $consesus = array_merge($file_data,$consesus);  
	} 
	
	
	$name .= ".txt";
	$json_string = $consesus;
	$file = $local_path.'/'.$name;
	
	file_put_contents($file, $json_string);
	
	
	echo $file." DONE <BR>";

//Printing just for test
	 echo "<pre>";
	 print_r($consesus);
	 echo "</pre>";
	 
//send_email_ck_auth("andyh@inspin.com", "corrio job consensus", "corrio job consensus", false, $from = "support@vrbmarketing.com", $from_name = "VRB")
?>