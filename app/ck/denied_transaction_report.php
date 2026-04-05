<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("denied_transaction_report")){ ?>
<?
if(isset($_GET["ed"])){
	$denied_trans = get_global_denied_transactions($_GET["ed"]);
	$denied_trans->vars["approved"] = 1;
    $denied_trans->update(array("approved"));
	header("Location: denied_transaction_report.php?e=3&from=".$_GET["from"]."");

}
if (isset($_GET["from"])){ $_POST["from"] = $_GET["from"]; }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Denied Transaction Report</title>
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
</head>
<body>

<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:10px;">
<span class="page_title">Denied Transaction Report</span><br /><br />

<? include "includes/print_error.php" ?>

<?



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
$_clerk = clean_get("clerk");
$clerk_list = get_all_clerks_index(1,"",false,true);


 
?>

<form method="post">
    &nbsp;&nbsp;&nbsp;&nbsp
    From: &nbsp;
    <input name="from" type="text" id="from" value="<? echo $from ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    To: 
    <input name="to" type="text" id="to" value="<? echo $to ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    Method: 
    <select name="method"> 
       <option <? if ($method == "" ) { echo 'selected="selected"'; }?> value = "" >All</option>
	<? foreach(ezpay_methods() as $_method){ ?>  
        <option <? if ($method == $_method) { echo 'selected="selected"'; }?> value="<? echo $_method ?>"><? echo $_method ?> </option>
    <? } ?>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;
    Type: 
    <select name="type"> 
       <option <? if ($type == "" ) { echo 'selected="selected"'; }?> value = "" >All</option>
       <option <? if ($type == "de" ) { echo 'selected="selected"'; }?> value = "de" >Deposit</option>
       <option <? if ($type == "pa" ) { echo 'selected="selected"'; }?> value = "pa" >Payout</option>
    </select>  <BR/><BR/> &nbsp;&nbsp;&nbsp;&nbsp;
    Player: 
    <input name="player" type="text" id="player" value="<? echo $player ?>" />
    &nbsp;&nbsp;&nbsp;&nbsp;
    Clerk: 
     <?
	create_objects_list("clerk", "clerk", $clerk_list, "id", "name", "All", $_clerk);  ?>
   	&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;
    
   
    <input style="width:150px" type="submit" value="Search" />
</form>
<br />
<? 
if (isset($_POST["from"])) {
  $transactions = search_global_denied_transactions($from,$to,$method,$type,$player,$_clerk,"de");
 } ?>


 <? //if (count($transactions)>0) { ?>
 <? if (!empty($transactions)) { ?>
<BR/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Method</td>
    <td class="table_header" align="center">type</td>
    <td class="table_header" align="center">player</td>
    <td class="table_header" align="center">amount</td>    
    <td class="table_header" align="center">date</td> 
    <td class="table_header" align="center">reason</td>                   
    <td class="table_header" align="center">Clerk</td>        
    <td class="table_header" align="center"></td>        
  </tr>


 
 <? foreach($transactions as $trans ){if($i % 2){$style = "1";}else{$style = "2";}$i++ ?>
  
  <tr >
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["trans_id"]; ?></td>
   <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["method"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->str_type(); ?></td>    
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["player"]; ?></td>         
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["amount"]; ?></td>         
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["pdate"]; ?></td>
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $trans->vars["reason"]; ?></td> 
    <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;"><? echo $clerk_list[$trans->vars["clerk"]]->vars["name"]; ?></td>  
     <td class="table_td<? echo $style ?>" style="text-align:center; font-weight:normal;">
     <? if (!$trans->vars["approved"])  { ?>
         <a href="?ed=<? echo $trans->vars["id"]; ?>&from=<? echo $from; ?>" class="normal_link">Approve</a>
     <? } 
        else { 
		 echo "<strong>Approved</strong>";	
		}?>
     </td>        
          
     
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
  
   </tr>

</table>  
 <? } ?>
 </div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>