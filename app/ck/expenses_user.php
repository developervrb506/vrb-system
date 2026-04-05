<? if($current_clerk->im_allow("expenses_user")){ ?>

<?
if(isset($_GET["p"])){
	$hideex = get_expense($_GET["p"]);
	$hideex->vars["status"] = "po";
	$hideex->update(array("status"));
}
?>

<span class="page_title">Expenses</span><br /><br />

<?
if(!isset($_GET["from"])){
   $to = date('Y-m-d');
   $from = date('Y-m-d', strtotime('-7 days'));
  } else {
    $to = $_GET["to"];
    $from = $_GET["from"];
  }
?>
<form method="get">
From: <input type="date" name="from" value="<? echo $from ?>">&nbsp;&nbsp;&nbsp; To: <input type="date" name="to" value="<? echo $to ?>">
&nbsp;&nbsp;&nbsp;
<input type="submit" value="Search"><br /><br />
</form>


<? $expenses = search_expenses($from, $to, "", "un", ""); ?>

<? if(count($expenses)>0){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="table_header" align="center">Id</td>
	<td class="table_header" align="center">Category</td>
	<td class="table_header" align="center">Amount</td>
	<td class="table_header" align="center">Date</td>
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
	<td class="table_td<? echo $style ?>" align="center"><? echo $ex->vars["id"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $ex->vars["category"]->vars["name"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo_report_number(number_format($ex->vars["amount"],2)); ?></td>
	<td class="table_td<? echo $style ?>" align="center"><? echo $ex->vars["edate"]; ?></td>
	<td class="table_td<? echo $style ?>" align="center">
	<span title="<? echo $ex->vars["note"]; ?>" style="cursor:pointer;">
			<? echo cut_text($ex->vars["note"],25); ?>
		</span>
	</td>
	<td class="table_td<? echo $style ?>" align="center">
		<a href="?p=<? echo $ex->vars["id"]; ?>" class="normal_link" ><strong>POST</strong></a>
	</td>
  </td>
  <? } ?>
  <tr>
	<td class="table_header" align="center"></td>
	<td class="table_header" align="center"></td>
	<td class="table_header" align="center"><? echo_report_number(number_format($total,2)) ?></td>
	<td class="table_header" align="center"></td>
	<td class="table_header" align="center"></td>
	<td class="table_header" align="center"></td>
  </tr>

</table>
<? }else{echo "No expenses in the System";} ?>

<? }else{echo "Access Denied";} ?>