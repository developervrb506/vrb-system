<? require_once(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$run_date = "2026-02-16";
echo "<pre>";
echo $run_date;
exit;
$accounts = get_all_pph_accounts_for_billing($run_date); 
$files = array("sport","phone","live","props","casino");

//print_r($accounts);
//exit;


$counts = array();

foreach($files as $file){
	$str_data = file_get_contents("files/".$file.".txt");
	$data_agents = explode("|",$str_data);
	foreach($data_agents as $da){
		/*echo $da;
		echo "<br />";*/
		
		$dparts = explode(",",$da);
		$agent_name = $dparts[0];
		$count = $dparts[1];
		
		$counts[$agent_name][$file] = $count;
		
	}
}


//print_r($counts);
//exit;

foreach($accounts as $agent){
		
		echo $agent ->vars["name"].":::<br />";
		
		$ag_account = str_replace("COMMISSION2","",$agent ->vars["name"]);
		$ag_account = str_replace("COMMISSION","",$ag_account);
		$ag_account = str_replace("REVERT","",$ag_account);
		$ag_account = trim($ag_account);
		
	
		$phone = $counts[$ag_account]["phone"];
		$casino = $counts[$ag_account]["casino"]*1;
		$sport = ($counts[$ag_account]["sport"] + $casino) - $phone;
		$live = $counts[$ag_account]["live"];
		$props = $counts[$ag_account]["props"];
		
		echo "Phone: $phone, Casino: $casino, Sport: $sport, Live: $live, Props: $props";
		echo "<br /><br />";
		
		if($sport > 0 || $phone > 0 || $live > 0 || $props > 0){
		
			if($agent ->vars["is_commission"]){
				$xnote = $agent ->vars["name"] . " .";
				$af_account = get_pph_account($agent ->vars["commission_owner"]);
				if(is_null($af_account)){
					$af_account = $agent;
					$xnote = "";
				}
			}else{
				$af_account = $agent;	
				$xnote = "";
			}
			
			$trans = new _pph_bill();
			$trans->vars["account"] = $af_account->vars["id"];
			
			$trans->vars["phone_count"] = $phone;
			$trans->vars["phone_price"] = $agent->vars["phone_price"];
			$trans->vars["internet_count"] = $sport;
			$trans->vars["internet_price"] = $agent->vars["internet_price"];
			$trans->vars["base_count"] = $trans->vars["internet_count"] + $trans->vars["phone_count"];
			$sports_custom_total = ($trans->vars["phone_count"]*$trans->vars["phone_price"])+($trans->vars["internet_count"]*$trans->vars["internet_price"]);
					
			$custom_total = 0;				
			$trans->vars["liveplus_count"] = $live;
			$trans->vars["liveplus_price"] = $agent->vars["liveplus_price"];
			//$trans->vars["base_count"] += $trans->vars["liveplus_count"];
			$custom_total += ($trans->vars["liveplus_count"]*$trans->vars["liveplus_price"]);
			
			$trans->vars["propsplus_count"] = $props;
			$trans->vars["propsplus_price"] = $agent->vars["propsplus_price"];
			//$trans->vars["base_count"] += $trans->vars["propsplus_count"];
			$custom_total += ($trans->vars["propsplus_count"]*$trans->vars["propsplus_price"]);
					
			$trans->vars["base_price"] = $agent->vars["base_price"];
			$trans->vars["max_players"] = $agent->vars["max_players"];
					
			$trans->vars["mdate"] = $run_date;
			$trans->vars["type"] = "sr";
					
			$total = $custom_total;
				
			if($trans->vars["base_count"] > $trans->vars["max_players"]){
				$total += $sports_custom_total;
			}else{
				$total += $trans->vars["base_price"];
			}
					
					
			$trans->vars["total"] = $total;
			$trans->vars["tdate"] = $run_date;
			$trans->vars["note"] = $xnote . $run_date . " WEEKLY BILLING. System";
			
			print_r($trans);
			echo "<br /><br />";
				
			$trans->insert(); 
				
			$af_account->move_balance($total);
			
			$agent->vars["last_billing"] = $run_date;
			$agent->update(array("last_billing"));
		
		}
		
	
}


?>