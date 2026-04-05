<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$pak_list = clean_str_ck($_GET["l"]);


$transactions = get_intersystem_by_list_pak($pak_list);

        $trans=array();
		foreach ($transactions as $tr){
			
			$key = str_replace(". Moneypak Id:","",$tr->vars["note"]);
			$key = preg_replace("/[^0-9,.]/", "", $key);
			//$accs = $tr->get_accounts();
			//$tr->vars["destination"] = $accs["to_account"]["name"] . " (". $accs["to_system"]["name"].")";
			$trans[$key] = $tr;
			
		}

echo json_encode($trans);
?>
