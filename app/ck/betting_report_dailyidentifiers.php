<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("betting_basics")){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Daily Identifiers</title>
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
			target:"datef",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"datet",
			dateFormat:"%Y-%m-%d"
		});
	};
</script>
</head>
<body>
<? include "../includes/header.php" ?>
<? include "../includes/menu_ck.php" ?>
<div class="page_content" style="padding-left:20px;">
<span class="page_title">Daily Identifiers</span><br /><br />

<? include "includes/print_error.php" ?>
<? 
if($_GET["datef"]==""){$from = date('Y-m-d');}else{$from = $_GET["datef"];} 
if($_GET["datet"]==""){$to = date('Y-m-d');}else{$to = $_GET["datet"];} 
?>
<form action="betting_report_dailyidentifiers.php" method="get">
From: <input name="datef" type="text" id="datef" value="<? echo $from ?>" readonly="readonly" /> 

To: <input name="datet" type="text" id="datet" value="<? echo $to ?>" readonly="readonly" /> 

<input type="submit" value="Search" />
</form>
<br /><br />

<table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="table_header" align="center">Number</td>
      <td class="table_header" align="center">Name</td>
      <td class="table_header" align="center">Amount</td>
    </tr>
    
    <?
	$i=0;
	$total = 0;
	 $identifiers = get_all_betting_identifiers();
	 foreach($identifiers as $id){
		 if($i % 2){$style = "1";}else{$style = "2";}
		 $i++;
		 $amount = 	round($id->get_bet_balance($from,$to));
		 $total += $amount;
	?>
    <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $id->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $id->vars["description"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">
			<? 
			if($amount != 0){
				$url = "betting_daily_identifier_detaill.php?idf=".$id->vars["id"]."&from=$from&to=$to";
				echo_report_number(round($amount),true,$url,650,400);
			}else{
				echo echo_report_number($amount); 
			}
			
			?>
        </td>
    </tr>
    <? }//identifiers?>
    <tr>
        <td  class="table_header" align="center">TOTAL</td>
        <td  class="table_header" align="center">-</td>
        <td  class="table_header" align="center"><? echo echo_report_number($total); ?></td>
    </tr>
    <tr>
      <td class="table_last"></td>
      <td class="table_last"></td>
      <td class="table_last"></td>
    </tr>
</table>


</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>