<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("cc_cashback")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>DGS CC ChargeBack Refund Report</title>
<link rel="stylesheet" type="text/css" media="all" href="../includes/calendar/jsDatePick_ltr.min.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/includes/shadowbox/shadowbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?= BASE_URL ?>/includes/shadowbox/shadowbox.js"></script>
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
</head>
<body>
<? include "../includes/header.php"  ?>
<? include "../includes/menu_ck.php"  ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">DGS CC ChargeBack Refund Report</span><br /><br />

<? include "includes/print_error.php" ?>
<? 
if (isset($_POST["from"])){
	$s_from =  get_Monday($_POST["from"]);
	$s_to = get_Monday($_POST["to"],"Y-m-d",true);	
	$s_account = $_POST["account"];
	$s_type = "";
	if ($_POST["type"] != ""){$s_type = $_POST["type"]; }
}
else {
	$s_from = get_Monday(date("Y-m-d"));
	$s_to = get_Monday(date("Y-m-d"),"Y-m-d",true);	
	$s_account = "";
	$s_type = "";
}

$transactions = search_cashback_refund($s_from,$s_to,$s_account,$s_type);

?>
<div align="right"><span ><a href="./cc_cashback.php" class="normal_link">Back to Cashback</a></span></div>

<form method="post">
    &nbsp;&nbsp;&nbsp;&nbsp
    Week: 
    <input name="from" type="text" id="from" value="<? echo $s_from ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $s_to ?>" />
     <BR/> <BR/>
    &nbsp;&nbsp;&nbsp;&nbsp     
    Type: 
     <select id="type" name="type">
          <option <? if ($s_type == ""){ echo 'selected="selected"'; } ?> value="" >All</option>
          <option <? if ($s_type == "c"){ echo 'selected="selected"'; } ?> value="c" >Cashback</option>
          <option <? if ($s_type == "r"){ echo 'selected="selected"'; } ?>value="r" >Refund</option>
    </select> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Account: 
    <input name="account" type="text" id="account" value="<? echo $account ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Search" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    <br /><br />

</form>


<? if (count($transactions) > 0) { ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header">Type</td>
    <td class="table_header">Account</td>
    <td class="table_header">Amount</td>
    <td class="table_header">Method</td>
    <td class="table_header">Descriptor</td>    
    <td class="table_header">Notes</td>
    <td class="table_header">Week</td>
    <td class="table_header">Added Date</td>
    <td class="table_header">AFF</td>
  </tr>
  <tr>
    <? echo "<strong>".$name_list."</strong><br>" ?>
  </tr>
  

<? foreach($transactions as $trans){
    if($i % 2){$style = "1";}else{$style = "2";} $i++;
	
	if($col->vars["deposit"]){$dep++;}
    ?>
    <tr>
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->str_type(); ?>
        </td>        
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["account"] ?>
        </td>        
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["amount"]?>
        </td>     
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["method"]?>
        </td>       
       <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["descriptor"]?>
        </td>       
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["notes"] ?>
        </td>
       
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["week"] ?>
        </td>
        <td class="table_td<? echo $style ?>" style="font-size:12px;">
			<? echo $trans->vars["added_date"]?>
        </td>
         <td class="table_td<? echo $style ?>" style="font-size:12px;">
            <? $data = "?player=".$trans->vars["account"]."";
			echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/cc_chargback_report.php".$data); ?>
        </td>
   </tr>
  <? }?> 
    <tr>
      <td class="table_last" colspan="100"></td>
    </tr>
</table>

<? } else { echo "There is not Information for the selected Week"; }  ?>
</div>
</body>
<? include "../includes/footer.php" ?>
<? }else{echo "Acces Denied";} ?>