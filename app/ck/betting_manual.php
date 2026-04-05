<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ 
ini_set("memory_limit",-1);
  ?>
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
<title>Manual Win/Loss</title>

<?
if(isset($_GET["del"])){
	$del = new _bet();
	$del->vars["id"] = $_GET["del"];
	$del->delete();
	?><script type="text/javascript">alert("Bet has been Deleted");</script><?
}
?>

</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:50px;">
<span class="page_title">Manual Win/Loss</span><br /><br />

<a href="insert_manual_bet.php" class="normal_link"  rel="shadowbox;height=455;width=450" title="Manual Win/Loss">
	+ Add Manual Win/Loss
</a>

<? 
$from = param("from",false);
if($from == ""){$from = date("Y-m-d");}
$to = param("to", false);
if($to == ""){$to = date("Y-m-d");}
$search = param("search");
?>
<br /><br />
<form method="get">
    From: <input name="from" type="text" id="from" value="<? echo $from ?>" readonly="readonly" />&nbsp;&nbsp;
    To: <input name="to" type="text" id="to" value="<? echo $to ?>" readonly="readonly" />&nbsp;&nbsp;
    &nbsp;&nbsp;
    <input name="search" type="hidden" id="search" value="1">
    <input type="submit" value="Search">
</form>



<br /><br />
<? include "includes/print_error.php" ?>    
<? if($search){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="table_header" align="center">Id</td>
    <td class="table_header" align="center">Account</td>
    <td class="table_header" align="center">Type</td>
    <td class="table_header" align="center">Amount</td>
    <td class="table_header" align="center">Identifier</td>
    <td class="table_header" align="center">Date</td>
    <td class="table_header" align="center">Comment</td>
    <td class="table_header" align="center"></td>
  </tr>
  <?
  $i=0;
   $adjusts = get_betting_adjustments("",false,$from,$to);
   foreach($adjusts as $adj){
       if($i % 2){$style = "1";}else{$style = "2";}$i++;
  ?>
  <tr>
    <td class="table_td<? echo $style ?>" align="center"><? echo $adj->vars["id"] ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $adj->vars["account"]->vars["name"] ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $adj->str_status();  ?></td>
    <td class="table_td<? echo $style ?>" align="center">$<? echo $adj->vars["win"]  ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $adj->vars["identifier"]->vars["name"]  ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo date("Y-m-d",strtotime($adj->vars["bdate"]))  ?></td>
    <td class="table_td<? echo $style ?>" align="center"><? echo $adj->vars["comment"]  ?></td>
    <td class="table_td<? echo $style ?>" align="center">
    	<a href="javascript:;" onClick="if(confirm('Are you sure you want to delete Bet #<? echo $adj->vars["id"] ?>?')){location.href = 'betting_manual.php?del=<? echo $adj->vars["id"] ?>'}" class="normal_link">Delete</a>
    </td>
  </td>
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
  </tr>

</table>

<? }else{echo "Please choose date range";} ?>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>