<? include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?
$str_pak = clean_str_ck($_GET["l"]);
$transactions = get_expense_by_list_pak($str_pak);




       $trans=array();
		foreach ($transactions as $tr){
			
			print_r($tr);
			$key = "*".$tr->vars["note"];
			$del = str_center("*","Id:",$key);
			$key = str_replace($del,"",$key);
			$key = str_replace("*Id:","",$key);
			$key = preg_replace("/[^0-9,.]/", "", $key);
			$trans[$key] = $tr;
			
		}




echo json_encode($trans);
?>
