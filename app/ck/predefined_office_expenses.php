<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("office_expenses")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<title>Predefined Office's Expenses</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Predefined Office's Expenses</span><br /><br />

<? include "includes/print_error.php" ?>



<a href="insert_predefined_office_expense.php" class="normal_link" rel="shadowbox;height=460;width=405">Insert Predefined Expense</a>
&nbsp;&nbsp;&nbsp;
<div align="right">
<a href="office_expenses_index.php" class="normal_link">Back to Office Expenses</a>
</div>

<br /><br />

<?
if(isset($_GET["p"])){
	$hideex = get_predefined_office_expense($_GET["p"]);
	
	if(!is_null($hideex)){
		$hideex->vars["paid"] = "1";
		$hideex->update(array("paid"));
	
	  	$exp = new _expense();
	    $exp->vars["edate"] = date("Y-m-d");
	    $exp->vars["amount"] = $hideex->vars["amount"];
	    $exp->vars["category"] = $hideex->vars["category"]->vars["id"];
	    $exp->vars["note"] = $hideex->vars["note"];
	    $exp->vars["inserted_date"] = $hideex->vars["edate"];
		$exp->vars["status"] = "po";
		$exp->insert();
	
	}
	
	
	
}
?>
<? $expenses =  get_current_predefined_office_expenses(); ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    
    <td class="table_header" align="center">Category</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Note</td>
    <td class="table_header" align="center"></td>
    </tr>
  <?
  $i=0;
  $total = 0;
   foreach($expenses as $ex){
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
	   $total += $ex->vars["amount"];
  ?>
  <tr>
     <td class="table_td<? echo $style ?>" align="center"><? echo $ex->vars["category"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo_report_number(number_format($ex->vars["amount"],2)); ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    <span title="<? echo $ex->vars["note"]; ?>" style="cursor:pointer;">
			<? echo cut_text($ex->vars["note"],25); ?>
        </span>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
        <a href="insert_predefined_office_expense.php?ex=<? echo $ex->vars["id"]; ?>" class="normal_link" rel="shadowbox;height=420;width=405">Edit</a>
    </td>
  </td>
  <? } ?>
  <tr>
    <td class="table_header" align="center">Total</td>
    <td class="table_header" align="center"><? echo_report_number(number_format($total,2)) ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
     </tr>

</table>





</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>