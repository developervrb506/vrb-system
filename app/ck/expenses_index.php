<? include(ROOT_PATH . "/ck/process/security.php"); ?>
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
<title>Expenses</title>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Expenses</span><br /><br />

<? include "includes/print_error.php" ?>

<? if($current_clerk->im_allow("expenses_admin")){ ?>

<a href="insert_expense.php" class="normal_link" rel="shadowbox;height=460;width=405">Insert Expense</a>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href="expense_categories.php" class="normal_link">Manage Categories</a>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href="expenses_report.php" class="normal_link">Report</a>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href="intersystem_expenses.php" class="normal_link" rel="shadowbox;height=420;width=405">Intersystem Expense</a>

<br /><br />
<strong>Current Expenses</strong>&nbsp;&nbsp;<a href="expenses_index.php" class="normal_link">Refresh</a>
<?
if(isset($_GET["h"])){
	$hideex = get_expense($_GET["h"]);
	$hideex->vars["hidden"] = "1";
	$hideex->update(array("hidden"));
}
?>
<?
if(isset($_GET["p"])){
	$hideex = get_expense($_GET["p"]);
	$hideex->vars["status"] = "po";
	$hideex->update(array("status"));
}
?>



<? 
$blocks = 50;
$index = $_GET["index"];
if(!is_numeric($index)){$index = 0;}
//$expenses = get_current_expenses(); 
$expenses = get_current_expenses_pagination($index * $blocks, $blocks); 
$count = count_current_expenses();
$pages = ceil($count["num"] / $blocks);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Category</td>
    <td class="table_header" align="center">System</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Note</td>
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
  $i=0;
  $total = 0;
   foreach($expenses as $ex){
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
	   if($ex->is_posted()){$style = "_important";}
	   $total += $ex->vars["amount"];
  ?>
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $ex->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $ex->vars["category"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $ex->vars["system"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo_report_number(number_format($ex->vars["amount"],2)); ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $ex->vars["edate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    <span title="<? echo $ex->vars["note"]; ?>" style="cursor:pointer;">
			<? echo cut_text($ex->vars["note"],25); ?>
        </span>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
		<? 
		echo $ex->str_status();
		if($ex->vars["status"] == "un"){
			?><br /><a href="?p=<? echo $ex->vars["id"]; ?>&index=<? echo $index ?>" class="normal_link" ><strong>POST</strong></a><?
		}		
		?>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
    	<? if(!$ex->vars["intersystem"]){ ?>
        <a href="insert_expense.php?ex=<? echo $ex->vars["id"]; ?>" class="normal_link" rel="shadowbox;height=460;width=405">Edit</a>
        <? } ?>
    </td>
    <td class="table_td<? echo $style ?>" align="center">
    	<a href="expenses_index.php?h=<? echo $ex->vars["id"]; ?>&index=<? echo $index ?>"  class="normal_link" title="Remove from this page">X</a>
    </td>
    <td class="table_td<? echo $style ?>" style="font-size:11px; color:#900;"><? echo $ex->get_error(); ?></td>
  </tr>
  <? } ?>
  <tr>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"><? echo_report_number(number_format($total,2)) ?></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
    <td class="table_header" align="center"></td>
  </tr>

</table>

<br /><br />

<div align="center">
	<? for($i = 0; $i < $pages; $i++){ ?>
    	<? if($i == $index){ ?><strong><? } ?>
    	<a href="expenses_index.php?index=<? echo $i; ?>" class="normal_link"><? echo $i +1; ?></a>&nbsp;&nbsp;&nbsp;
        <? if($i == $index){ ?></strong><? } ?>
    <? } ?>
</div>

<? } ?>


</div>
<? include "../includes/footer.php" ?>