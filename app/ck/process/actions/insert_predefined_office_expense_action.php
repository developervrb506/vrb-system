<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("office_expenses")){ ?>
<?

if($_POST["edit"]){
	$exp = get_predefined_office_expense(clean_get("ex"));
	$exp->vars["amount"] = clean_get("type").clean_get("amount");
	$exp->vars["category"] = clean_get("categories_list");
	$exp->vars["note"] = clean_get("note");
	$exp->update();
}else{
	$exp = new _predefined_office_expense();
	$exp->vars["amount"] = clean_get("type").clean_get("amount");
	$exp->vars["category"] = clean_get("categories_list");
	$exp->vars["note"] = clean_get("note");
	$exp->insert();
}
if($_POST["report"]){
	?>
	<script type="text/javascript">
    parent.document.getElementById("frm_search").submit();
    </script>
    <?	
}else if($_POST["reload"]){
	header("Location: " . BASE_URL . "/ck/insert_predefined_office_expense.php");
	
}else if(!$_POST["noredirect"]){
	//header("Location: " . BASE_URL . "/ck/expenses_index.php?e=47");
	?><script type="text/javascript">parent.location.href = BASE_URL . "/ck/predefined_office_expenses.php?e=47";</script><?
}else{
	?> <div style="padding:25px; text-align:center; color:#fff; font:Arial, Helvetica, sans-serif; font-size:24px;">Expense Inserted</div> <? 	
}
?>
<? }else{echo "Access Denied";} ?>