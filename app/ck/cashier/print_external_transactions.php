<?  include(ROOT_PATH . "/ck/db/handler.php"); ?>
<?

 $method =  $system = param('method');
 $system = param('system');
 $account = param('account');
 $str_account = $_GET['str_account'];
 $str_system = $_GET['str_system']; 
 $str_category = param('str_category');
 $category = param('category'); 
 $from = $_GET["from"];
 $to = $_GET["to"];
 
 $str_account = str_replace("_"," ",$str_account);
 $str_system = str_replace("_"," ",$str_system);


 if($method == 't'){
 
 $transactions = get_intersystem_moved_deposits($system,$account,$from,$to);
 $balance_transactions_to = get_intersystem_moved_deposits_balance($system,$account,$from,$to,true);
 $balance_transactions_from= get_intersystem_moved_deposits_balance($system,$account,$from,$to,false);
 
 
 if (!empty($balance_transactions_to)){ 
   
   $j=0;
      foreach ($balance_transactions_to as $bt){
	  $amount = intersystem_formula($bt['to'],$bt['from'],$bt['amount'],'to');
	  $balance_transactions_to[$j]['amount'] = $amount;
	  $balance_transactions_to[$j]['category'] = $str_account;
	  $balance_transactions_to[$j]['key'] = rand(0,1000)."b";
	  $j++;   
	   
	
	 }
	
 }
  
   if (!empty($balance_transactions_from)){ 
   
   $j=0;
    foreach ($balance_transactions_from as $bf){
	  $amount = intersystem_formula($bf['to'],$bf['from'],$bf['amount'],'from');
	  $balance_transactions_from[$j]['amount'] = $amount;
	  $balance_transactions_from[$j]['category'] = $str_account;
	  $balance_transactions_from[$j]['key'] = rand(0,1000)."b";
	  $j++;   
	   
	
	 }
   }

   $balance_transactions = array();

    if (!empty($balance_transactions_to)){    

	 $balance_transactions = array_merge($balance_transactions_to,$balance_transactions);
	}
	if (!empty($balance_transactions_from)){    
	 $balance_transactions = array_merge($balance_transactions_from,$balance_transactions);
	}
   
   


 $expenses = get_current_expenses_trasaction($str_system,$str_account,$from,$to);	  
 
 if (!empty($expenses)){
	 
	$transactions = array_merge($expenses,$transactions) ;
 }
  if (!empty($balance_transactions)){
	 
	$transactions = array_merge($balance_transactions,$transactions) ;
 }
 
 		
	    $i=0;
		$trans=array();
		foreach ($transactions as $tr){
			
			
			if (!isset($tr["key"])){
			$key = str_replace(". Moneypak Id:","",$tr["note"]);
			$key = preg_replace("/[^0-9,.]/", "", $key);
			$key = str_replace(".","0",$key);
			}
			else {
			 $key = $tr["key"];	
			}
			$trans[$key]["id"] = $key;
			$trans[$key]["system"] = str_replace("_","  ",$str_system);
			$trans[$key]["account"] = str_replace("_","  ",$str_account);	
			$trans[$key]["tdate"] = $tr["tdate"];
			$trans[$key]["amount"] = $tr["amount"];	
			$trans[$key]["note"] = $tr["note"];		
			$trans[$key]["category"] = $tr["category"];	
			
			
			
			
		$i++;
		}
		
		/*echo "<pre>";
     
	  print_r($trans);
	   echo "</pre>";
        */
    }else{
		
	 $transactions = get_expenses_moved_deposits($category,$from,$to);
	  
	    $i=0;
		$trans=array();
		foreach ($transactions as $tr){
			
			$key = "*".$tr["note"];
			$del = str_center("*","Id:",$key);
			$key = str_replace($del,"",$key);
			$key = str_replace("*Id:","",$key);
			$key = preg_replace("/[^0-9,.]/", "", $key);
			$trans[$key]["id"] = $key;
			$trans[$key]["category"] = str_replace("_","  ",$str_category);
			$trans[$key]["tdate"] = $tr["edate"];	
			
		$i++;
		}	
	 
	 
	}

 echo json_encode($trans);


 


  ?>
