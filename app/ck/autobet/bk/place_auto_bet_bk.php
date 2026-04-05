<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? include(ROOT_PATH . "/ck/balances/api/insert_transaction.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<?
$softwares = get_all_betting_softwares();
foreach($softwares as $soft){	
	include(ROOT_PATH . "/ck/autobet/".strtolower($soft->vars["name"]).".php");
}
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
}

$accounts =  get_auto_betting_accounts($group);

$total_amount = 0;
foreach($accounts as $acc){
	$settings = get_betting_auto_settings($acc->vars["id"]);
	$acc_amount = $settings->vars[$sport."_".$type] * ($acc->vars["description"] / 100);	
	if($acc_amount > 0){
		eval("\$bot = new _".strtolower($softwares[$settings->vars["software"]]->vars["name"])."_robot();");	
		$bot->vars["user"] = $acc->vars["name"];
		$bot->vars["pass"] = $settings->vars["password"];
		$bot->vars["sport"] = $sport;
		$bot->vars["period"] = $period;
		$bot->vars["amount"] = "500"; //pending
		$bot->vars["rotation"] = $rotation;
		$bot->vars["type"] = $big_type;
		$bot->vars["url"] = $settings->vars["url"];	
		
		$bot->login();
		$line = $bot->create_bet();
		
		echo $acc->vars["name"] ." : ";
		
		
		if(!is_null($line) && ($line["line"] != "" || $line["line"] != "")){
			print_r($line);
		}else{
			echo "The game was not found";	
		}
		
		echo "<br /><br />";
	}else{
		//amount less than 0	
	}
}




//header("Location: ../../betting_accounts_auto_settings.php?e=67&aid=".$account->vars["id"]);
?>
<? }else{echo "Access Denied";} ?>