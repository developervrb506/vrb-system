<?
include(ROOT_PATH . "/ck/db/handler.php");
?>

<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
.table_header{
	background:url(http://localhost:8080/images/temp/table_header_back.jpg) repeat-x bottom left #fff;
	border-top:1px solid #d5d5d5;
	border-left:1px solid #d5d5d5;
	border-right: 1px solid #d5d5d5;
	padding:5px;
	text-transform:uppercase;
	font-size:13px;
	/*font-weight:bold;*/
}
.table_td1{
	/*background:#f1f1f1;*/
	background:#D3D3D3;
	border-left:1px solid #C0C0C0;
	border-right: 1px solid #C0C0C0;
	padding:5px;
	font-size:13px;
	/*font-weight:bold;*/
}
.table_td2{
	background:#fff;
	border-left:1px solid #d5d5d5;
	border-right: 1px solid #d5d5d5;
	padding:5px;
	font-size:13px;
	/*font-weight:bold;*/
}
.table_last{
	border-top:1px solid #d5d5d5;
	height:1px;
}
</style>

<?
$from = date("Y-m-d",strtotime("-12 weeks"));
$to = date("Y-m-d");
$account = get_pph_account_by_name($_GET["acc"]);

if(!is_null($account)){

?>
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


<h3><? echo $account->vars["name"] ?> Billing | Balance: $<? echo number_format($account->vars["balance"]) ?></h3>

<BR>
<a target="_blank" href="pph_external_pph_report.php?acc=<? echo $account->vars["id"]; ?>&from=<? echo date("Y-m-d",strtotime(date("Y-m-d")." -6 months")) ?>&to=<? echo date("Y-m-d") ?>" class="normal_link">View Payments</a>
<BR><BR>


    
<? include "includes/print_error.php" ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Date</td>
	<td class="table_header">phone<br />count</td>
    <td class="table_header">phone<br />price</td>
    <td class="table_header">phone<br />total</td>
    <td class="table_header">internet<br />count</td>
    <td class="table_header">internet<br />price</td>
    <td class="table_header">internet<br />total</td>
	
	<td class="table_header">Live<br />count</td>
	<td class="table_header">Live<br />price</td>
    <td class="table_header">Live<br />total</td>
	
	<td class="table_header">Props<br />count</td>
	<td class="table_header">Props<br />price</td>
    <td class="table_header">Props<br />total</td>
	
    <td class="table_header">Total</td>
    
  </tr>
  <?
  $i=0;
   $trans = search_pph_bill($from,$to, $account->vars["id"]);
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
  <tr title="<? echo $tran->vars["note"]; ?>">
    <td class="table_td<? echo $style ?>"><? echo $tran->vars["mdate"]; ?></td>
	<td class="table_td<? echo $style ?>"><? echo $tran->vars["phone_count"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo basic_number_format($tran->vars["phone_price"]); ?></td>
    <td class="table_td<? echo $style ?>"><? echo basic_number_format($tran->get_phone_total()); ?></td>
    <td class="table_td<? echo $style ?>"><? echo $tran->vars["internet_count"]; ?></td>
    <td class="table_td<? echo $style ?>"><? echo basic_number_format($tran->vars["internet_price"]); ?></td>
    <td class="table_td<? echo $style ?>"><? echo basic_number_format($tran->get_internet_total()); ?></td>
	
	<td class="table_td<? echo $style ?>"><? echo $tran->vars["liveplus_count"]; ?></td>
	<td class="table_td<? echo $style ?>"><? echo basic_number_format($tran->vars["liveplus_price"]); ?></td>
    <td class="table_td<? echo $style ?>"><? echo basic_number_format($tran->get_liveplus_total()); ?></td>
	
	<td class="table_td<? echo $style ?>"><? echo $tran->vars["propsplus_count"]; ?></td>
	<td class="table_td<? echo $style ?>"><? echo basic_number_format($tran->vars["propsplus_price"]); ?></td>
    <td class="table_td<? echo $style ?>"><? echo basic_number_format($tran->get_propsplus_total()); ?></td>
	
    <td class="table_td<? echo $style ?>"><? echo basic_number_format($tran->vars["total"]); ?></td>    
  </td>
  <? } ?>
  <tr>
    <td class="table_last" colspan="100"></td>
  </tr>

</table>

<? }else{echo "No Billing found";} ?>