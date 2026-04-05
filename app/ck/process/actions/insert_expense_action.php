<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("expenses_admin")){ ?>
<?

if($_POST["edit"]){
	$exp = get_expense(clean_get("ex"));
	$exp->vars["edate"] = clean_get("date");
	$exp->vars["amount"] = clean_get("type").clean_get("amount");
	$exp->vars["category"] = clean_get("categories_list");
	$exp->vars["note"] = clean_get("note");
	$exp->update();
}else{
	$exp = new _expense();
	$exp->vars["edate"] = clean_get("date");
	$exp->vars["amount"] = clean_get("type").clean_get("amount");
	$exp->vars["category"] = clean_get("categories_list");
	$exp->vars["note"] = clean_get("note");
	$exp->vars["inserted_date"] = date("Y-m-d H:i:s");
	$exp->insert();
}
if($_POST["report"]){
	?>
	<script type="text/javascript">
    parent.document.getElementById("frm_search").submit();
    </script>
    <?	
}else if($_POST["reload"]){
	if($_POST["mobile"]){
		header("Location: http://localhost:8080/ck/mobile/expense.php?e=70");	
	}else{
		header("Location: http://localhost:8080/ck/insert_expense.php");
	}
}else if(!$_POST["noredirect"]){
	//header("Location: http://localhost:8080/ck/expenses_index.php?e=47");
	?><script type="text/javascript">parent.location.href = "http://localhost:8080/ck/expenses_index.php?e=47";</script><?
}else{
	?> <div style="padding:25px; text-align:center; color:#fff; font:Arial, Helvetica, sans-serif; font-size:24px;">Expense Inserted</div> <? 	
}
?>
<? }else{echo "Access Denied";} ?>