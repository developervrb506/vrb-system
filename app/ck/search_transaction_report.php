<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("search_transactions")){ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Search Transaction Report</title>
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
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Search Transaction Report</span><br /><br />

<? include "includes/print_error.php" ?>

<? 
$methods_array = array();
$array = array();
$methods_array = json_decode(file_get_contents("http://www.sportsbettingonline.ag/utilities/process/banking/sbo_banking_methods_array.php"));



$from = clean_get("from");
if($from == ""){$from = date("Y-m-d");}
$to = clean_get("to");
if($to == ""){$to = date("Y-m-d");}

$method = clean_get("method");
$type = clean_get("type");
$player = clean_get("player");
$idtrans = clean_get("idtrans");
$status = clean_get("status");
$cmarked = clean_get("dgs");


$all_methods = "90,91,92,93,94,95,98,99,100,101,102,103,106,111,114,126,127,128,129,130,131,134,140,141";
$payment_method = post_get("methods_list_search");
?>

<form method="post">
    &nbsp;&nbsp;&nbsp;&nbsp;
    From: &nbsp;
    <input style="width:100px" name="from" type="text" id="from" value="<? echo $from ?>" />
    &nbsp;&nbsp;
    To: 
    <input  style="width:100px" name="to" type="text" id="to" value="<? echo $to ?>" />
    &nbsp;&nbsp;
    Method: 
    <select name="method"> 
       <option <? if ($method == "" ) { echo 'selected="selected"'; }?> value = "" >All</option>
	<? foreach(ezpay_methods() as $_method){ ?>  
        <option <? if ($method == $_method) { echo 'selected="selected"'; }?> value="<? echo $_method ?>"><? echo $_method ?> </option>
    <? } ?>
    </select>
    &nbsp;&nbsp;
    Type: 
    <select name="type"> 
       <option <? if ($type == "" ) { echo 'selected="selected"'; }?> value = "" >All</option>
       <option <? if ($type == "de" ) { echo 'selected="selected"'; }?> value = "de" >Deposit</option>
       <option <? if ($type == "pa" ) { echo 'selected="selected"'; }?> value = "pa" >Payout</option>
    </select>  
   &nbsp;&nbsp;
  P Method: 
  <? 
	echo file_get_contents("http://www.sportsbettingonline.ag/utilities/process/reports/print_payment_methods.php?filter=$all_methods&en=_search&ao=1&cm=$payment_method"); 
	?>
    <BR/><BR/> &nbsp;&nbsp;&nbsp;&nbsp;
    Player: 
    <input name="player" type="text" id="player" value="<? echo $player ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    Id Trans: 
    <input  style="width:100px" name="idtrans" type="text" id="idtrans" value="<? echo $idtrans ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    Status: 
    <select name="status"> 
       <option <? if ($status == "" ) { echo 'selected="selected"'; }?> value = "" >All</option>
       <option <? if ($status == "ac" ) { echo 'selected="selected"'; }?> value = "ac" >Acepted</option>
       <option <? if ($status == "ape" ) { echo 'selected="selected"'; }?> value = "ape" >Pre-Pending</option>
       <option <? if ($status == "pe" ) { echo 'selected="selected"'; }?> value = "pe" >Pending</option>
       <option <? if ($status == "de" ) { echo 'selected="selected"'; }?> value = "de" >Denied</option>
    </select> 
     &nbsp;&nbsp;&nbsp;&nbsp;
    Dgs: 
    <select name="dgs"> 
       <option <? if ($cmarked == "" ) { echo 'selected="selected"'; }?> value = "" >All</option>
       <option <? if ($cmarked == "1" ) { echo 'selected="selected"'; }?> value = "1" >Exist</option>
       <option <? if ($cmarked == "0" ) { echo 'selected="selected"'; }?> value = "0" >Not</option>
    </select> 
    &nbsp;&nbsp;
    <input style="width:150px" type="submit" value="Search" />
</form>
<br />
<? 
if (isset($_POST["from"])) {
  $transactions = search_global_transactions($from,$to,$method,$type,$player,$idtrans,$status,$cmarked,$payment_method);
 } ?>


 <? if (!is_null($transactions)) { ?>
<BR/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Method</td>
    <td class="table_header" align="center">type</td>
    <td class="table_header" align="center">dgs deposit</td>
    <td class="table_header" align="center">dgs fees</td>
    <td class="table_header" align="center">dgs Bonus</td>
    <td class="table_header" align="center">player</td>
    <td class="table_header" align="center">amount</td>    
    <td class="table_header" align="center">fees</td>    
    <td class="table_header" align="center">Status</td>
    <td class="table_header" align="center">date</td> 
    <td class="table_header" align="center">P. Method</td>
    <td class="table_header" align="center">description</td>                   
    <td class="table_header" align="center">back message</td>    
  </tr>


 
 <? foreach($transactions as $trans ){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr >
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["id"]; ?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["method"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->str_type(); ?></td>   
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["dgs_dID"]; ?></td>    
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["dgs_fID"]; ?></td>    
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["dgs_bID"]; ?></td>         
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["player"]; ?></td>         
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["amount"]; ?></td>         
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["fees"]; ?></td>
      <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->color_status(); ?></td>         
      <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["tdate"]; ?></td>
       <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? 
	     
		 if ($trans->vars["payment_method"] > 0){
		     echo $methods_array->{$trans->vars["payment_method"]}->{'name'};
		 }
		  ?></td>
        <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["description"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["back_message"]; ?></td>        
          
     
  </tr>
  
  <? } ?>
  
  
  <tr>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td> 
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
    <td class="table_last"></td>
   </tr>

</table>  
 <? } ?>
 </div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>