<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("intersystem_transactions")){ ?>
<? 
$ids = array();
$amounts = array();
$list = $_GET["l"];
$full_list = explode(",",$list);
$total_amount = 0;
foreach($full_list as $item){
	$parts = explode("/",$item);
	$ids[] = $parts[0];
	$amounts[] = $parts[1];
	$total_amount += $parts[1];
		
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://localhost:8080/ck/balances/api/functions.js"></script>
</head>
<body style="background:#fff; padding:20px;">
<span class="page_title">Intersystem Expense</span><br /><br />
<div class="form_box">
	<form method="post" onsubmit="return validate(validations)" action="process/actions/insert_intersystem_expense_list_action.php" target="_parent">
    <input name="mpks" type="hidden" id="mpk" value="<? echo implode(",",$ids); ?>" />
    <input name="system_list_from" type="hidden" id="system_list_from" value="4" />
    <input name="from_account" type="hidden" id="from_account" value="130" />
    <input name="amounts" type="hidden" id="amount" value="<? echo implode(",",$amounts); ?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="10">   
      <tr>
        <td>Total Amount:</td>
        <td><? echo $total_amount ?></td>
      </tr>
      <tr>
		<td>Category</td>
		<td>
			<? $s_cat = $expense->vars["category"]->vars["id"]; include("includes/expenses_categories_list.php"); ?>
		</td>
	  </tr> 
      <tr>
        <td>Note:</td>
        <td><textarea name="note" id="note"></textarea><input name="hidden_note" type="hidden" id="hidden_note" value="Moneypak Id:<? echo implode(",",$ids); ?>" /></td>
      </tr>
      <tr>
        <td>Send Email to:</td>
        <td>
        	<? $data = get_all_expense_emails(); ?>
        	<? create_objects_list("email", "email", $data, "id", "name", "-- None --") ?><br />
            <a href="http://localhost:8080/ck/expense_email_list.php" class="normal_link" target="_parent">
            	Manage emails list
            </a>
        </td>
      </tr>
      <tr>
        <td colspan="2"><input name="" type="submit" value="Submit" /></td>
      </tr>
    </table>
	</form>
</div>

</body>
</html>
<? }else{echo "Access Denied";} ?>