<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("pph_accounting")){ ?>
<?
$from = $_POST["from"];
if($from == ""){$from = date("Y-m-d");}
$to = $_POST["to"];
if($to == ""){$to = date("Y-m-d");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>PPH Reconciliation Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../includes/calendar/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"from",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"to",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">PPH Reconciliation</span><br /><br />
<form method="post">
From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
To:<input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />
&nbsp;&nbsp;&nbsp;
<input name="loader" type="submit" id="loader" value="Search" />
</form>

    
<br /><br />
<? include "includes/print_error.php" ?>   
<? if(isset($_POST["loader"])){ ?> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Account</td>
    <td class="table_header" align="center">Total</td>
  </tr>
  <?
   $i=0;
   $trans = get_reconciliation_pph_bills($from,$to);
   $total = 0;
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
  <tr title="<? echo $tran->vars["note"]; ?>">
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["account"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo basic_number_format($tran->vars["total"]); ?></td>
    <? $total += $tran->vars["total"] ?>
  </td>
  <? } ?>
  <tr>
    <td class="table_header" align="center">Sub Total</td>
    <td class="table_header" align="center">$<? echo basic_number_format($total); ?></td>
  </tr>
  <tr>
  	<? $expense = $trans[0]->vars["expenses"]; ?>
    <? if($expense == ""){$expense = 0;} ?>
    <td class="table_header" align="center">Expenses</td>
    <td class="table_header" align="center">$<? echo basic_number_format($expense); ?></td>
  </tr>
  <tr>
  	<? $stotal = $total - $expense; ?>
    <td class="table_header" align="center">Total</td>
    <td class="table_header" align="center">$<? echo basic_number_format($stotal); ?></td>
  </tr>
  <tr>
  	<? $gtotal = $stotal/2; ?>
    <td class="table_header" align="center">Grand Total</td>
    <td class="table_header" align="center">$<? echo basic_number_format($gtotal); ?></td>
  </tr>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>

</table>
<? } ?>
</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>