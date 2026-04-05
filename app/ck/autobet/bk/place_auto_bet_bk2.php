<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
$sport = $_POST["sport"];
$period = $_POST["period"];
$rotation = $_POST["rotation"];
$amount = $_POST["amount"];
$line = $_POST["line"];
$juice = $_POST["juice"];
$type = $_POST["type"];
$group = $_POST["betting_groups_list"];
$action = $_POST["action"];

if($amount == ""){$amount = 1000000000;}
switch($type){
	case "m": $big_type = "money"; break;	
	case "s": $big_type = "spread"; break;	
	case "t": $big_type = "total"; break;
	case "o": $big_type = "over"; $type = "t"; break;
	case "u": $big_type = "under"; $type = "t"; break;	
}

$accounts =  get_auto_betting_accounts($group);

$total_amount = 0;
$threads = array();

foreach($accounts as $acc){
	$settings = get_betting_auto_settings($acc->vars["id"]);
	$acc_amount = $settings->vars[$sport."_".$type] * ($acc->vars["description"] / 100);	
	if($acc_amount > 0){
		$params = "?sport=$sport";
		$params .= "&period=$period";
		$params .= "&amount=$amount";//pending
		$params .= "&rotation=$rotation";
		$params .= "&type=$big_type";
		$params .= "&line=$line";
		$params .= "&juice=$juice";
		$params .= "&action=$action";
		$params .= "&aid=".$acc->vars["id"];
		
		$threads[] = array("id"=>$acc->vars["name"],"process"=>open_thread('www.vrbmarketing.com','/ck/autobet/place_thread.php'.$params));
		//echo '/ck/autobet/place_thread.php'.$params;
		
	}else{
		//amount less than 0
	}
}

$results = array();
$tm = 0;
while (true) {
	sleep(1);	
	foreach($threads as $thread){
		if(is_null($results[$thread["id"]])){
			$parts = explode(":::",read_thread($thread["process"]));
			$res = $parts[1];
			if($res != ""){$results[$thread["id"]] = $res;}
		}
	}
	
	if(count($results) == count($threads)){break;}

	$tm++;
	if($tm>120){echo "timeout"; break;}
}


echo $line.$juice."<br /><br />";

$rkeys = array_keys($results);
foreach($rkeys as $rk){
	echo $rk . ": ". $results[$rk];
	echo "<br /><br />";
}

//header("Location: ../../betting_accounts_auto_settings.php?e=67&aid=".$account->vars["id"]);
?>
<? }else{echo "Access Denied";} ?>