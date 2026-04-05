<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("agent_draw")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Affiliate Draw  Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="http://localhost:8080/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://localhost:8080/includes/shadowbox/shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
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
<script>

  function dgs_reverse(tid, key){
	
	if(confirm("Are you sure you want to Reverse this transaction in DGS?")){
			var curl = "http://www.sportsbettingonline.ag/utilities/process/reports/cancel_dgs_affiliate_transaction.php";
			var params = "?cache="+key+"&dk=4S6X6e6S656c&od=1";
			document.getElementById("loaderi").src = curl+params;
			document.getElementById("cancel_link_"+tid).style.display = "none";
			document.getElementById("loadrev").src = 
             	"http://localhost:8080/ck/process/actions/reverse_intersystem_affiliate_draw_action.php?id="+tid;
			
			alert("Transaction has been reversed");
		}
	}
</script>


</head>
<body>
<? include "../includes/header.php"  ?>
<? include "../includes/menu_ck.php"  ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Affiliate Draw  Report</span>
&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
<span ><a href="./affiliate_draw.php" class="normal_link">Add new</a></span><BR/><BR/>

<? include "includes/print_error.php" ?>
<? 
if (isset($_POST["from"])){
	$s_from =  $_POST["from"];
	$s_to = $_POST["to"];	
	$s_affiliate = $_POST["affiliate"];

}
else {
	$s_from = date("Y-m-d");
	$s_to = date("Y-m-d");
	$s_affiliate = "";
}

$transactions = search_intersystem_affliate_draw_transactions($s_from,$s_to,$s_affiliate);
//search_cashback_refund($s_from,$s_to,$s_account,$s_type);

?>

<form method="post">
    &nbsp;&nbsp;&nbsp;&nbsp
    From: 
    <input name="from" type="text" id="from" value="<? echo $s_from ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $s_to ?>" />
     <BR/> <BR/>
    &nbsp;&nbsp;&nbsp;&nbsp     
    Affiliate: 
    <input name="affiliate" type="text" id="affiliate" value="<? echo $s_affiliate ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <br /><br />

</form>


<? if (count($transactions) > 0) { ?>
<iframe width="1"  height="1" frameborder="0" scrolling="no" id="loaderi" name="loaderi"></iframe>
<iframe width="1"  height="1" frameborder="0" scrolling="no" id="loadrev" name="loadrev"></iframe>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Id</td>
    <td class="table_header">Affiliate</td>
    <td class="table_header">Note</td>
    <td class="table_header">Amount</td>
    <td class="table_header">Date</td>
    <td class="table_header">Inserted By</td>
    <td class="table_header"></td>
  </tr>


<? foreach($transactions as $trans){
    if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
	  $clerk = get_clerk($trans->vars["inserted_by"]);
	  $aff_note = explode("AF Draw:",$trans->vars["note"]);
    ?>
    <tr>
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["id"]; ?>
        </td> 
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $aff_note[1] ?>
        </td>         
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $aff_note[0] ?>
        </td>        
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["amount"]?>
        </td>     
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["tdate"]?>
        </td>       
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $clerk->vars["name"] ?>
        </td>
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
         <? if(!$trans->vars["reversed"]) { ?>
          <div id="cancel_link_<? echo $trans->vars["id"]; ?>">
           	<a href="javascript:;" class="normal_link" onclick="dgs_reverse('<? echo $trans->vars["id"]; ?>', '<? echo two_way_enc($trans->vars["dgs_ID"]); ?>')">Reverse from DGS</a>
            </div>
         <? } ?>  
        </td>
       
   </tr>
  <? }?> 
    <tr>
      <td class="table_last" colspan="100"></td>
    </tr>
</table>

<? } else { echo "There is not Information for the selected Dates"; }  ?>
</div>
</body>
<? include "../includes/footer.php" ?>
<? }else{echo "Acces Denied";} ?>