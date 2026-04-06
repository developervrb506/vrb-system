<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("office_expenses")){ ?>
<?

 $expenses = get_current_predefined_office_expenses();
	

 foreach ($expenses as $ex){
	 
	 if (isset($_POST["sel_".$ex->vars["id"]])){
	  $exp = new _office_expense();
	  $exp->vars["amount"] = $ex->vars["amount"];
	  $exp->vars["category"] = $ex->vars["category"];
	  $exp->vars["month"] = clean_get("month".$ex->vars["id"]);
	  $exp->vars["year"] = clean_get("year".$ex->vars["id"]);
	  $exp->vars["note"] = $ex->vars["note"];
	  $exp->vars["edate"] = date("Y-m-d H:i:s");
	  $exp->vars["inserted_by"] = $current_clerk->vars["id"];
	  $exp->insert();

	 }
	 
	 	
 }
header("Location: " . BASE_URL . "/ck/office_expenses_index.php");	


?>
<? }else{echo "Access Denied";} ?>