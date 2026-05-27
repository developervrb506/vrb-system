<?
include(ROOT_PATH . "/ck/db/handler.php");
?>

<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
.table_header{
	background:url(/images/temp/table_header_back.jpg) repeat-x bottom left #fff;
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

<?/*
$from = date("Y-m-d",strtotime("-12 weeks"));
$to = date("Y-m-d");
$account = get_pph_account_by_name($_GET["acc"]);

if(!is_null($account)){*/

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
<?
$from = $_POST["from"];
if($from == ""){$from = $_GET["from"];}
if($from == ""){$from = date("Y-m-d");}
$to = $_POST["to"];
$acc = $_POST["acc"];
if($to == ""){$to = $_GET["to"];}
if($to == ""){$to = date("Y-m-d");}
if($acc == ""){$acc = $_GET["acc"];}
?>

<h3>PAYMENTS</h3>


<? include "includes/print_error.php" ?>    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">From</td>
    <td class="table_header" align="center">To</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Note</td>
  </tr>
  <?
   $i=0;
   $trans = search_all_pph_transaction($from,$to,$acc);
   foreach($trans as $tran){	   
       if($i % 2){$style = "1";}else{$style = "2";}
       $i++;
  ?>
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["id"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["from_account"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["to_account"]->vars["name"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["amount"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $tran->vars["tdate"]; ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo nl2br($tran->vars["note"]); ?></td>
  </td>
  <? } ?>
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
  </tr>

</table>

<?// }else{echo "No Billing found";} ?>