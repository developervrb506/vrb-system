<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("dj_expenses")){ ?>
<?

if($_POST["edit"]){
	$exp = get_dj_expense(clean_get("ex"));
	$exp->vars["amount"] = clean_get("type").clean_get("amount");
	$exp->vars["category"] = clean_get("categories_list");
	$exp->vars["month"] = clean_get("month");
	$exp->vars["year"] = clean_get("year");
	$exp->vars["note"] = clean_get("note");
	$exp->update();
}else{
	$exp = new _dj_expense();
	$exp->vars["amount"] = clean_get("type").clean_get("amount");
	$exp->vars["category"] = clean_get("categories_list");
	$exp->vars["month"] = clean_get("month");
	$exp->vars["year"] = clean_get("year");
	$exp->vars["note"] = clean_get("note");
	$exp->vars["edate"] = date("Y-m-d H:i:s");
	$exp->vars["inserted_by"] = $current_clerk->vars["id"];
	$exp->insert();
}
if($_POST["report"]){
	?>
	<script type="text/javascript">
    parent.document.getElementById("frm_search").submit();
    </script>
    <?	
}
else{
	if($_POST["mobile"]){
		header("Location: http://localhost:8080/ck/mobile/dj_expense.php?e=47");
	}else{
		?><script type="text/javascript">parent.location.href = "http://localhost:8080/ck/dj_expenses_index.php?e=47";</script><?
	}
}
?>
<? }else{echo "Access Denied";} ?>