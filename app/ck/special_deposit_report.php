<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<? if($current_clerk->im_allow("special_deposits")){ ?>
<?

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<title>Special Deposits Report</title>
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

    <span class="page_title">Special Deposits Report</span><br /><br />
    <? 
	//if($_POST["datef"]==""){$from = date('Y-m-d');}else{$from = $_POST["datef"];}
	$from = $_POST["datef"]; 
	if($_POST["datet"]==""){$to = date('Y-m-d');}else{$to = $_POST["datet"];} 
	$player = $_POST["player"];
	$method = $_POST["special_method"];
	$sstatus = $_POST["sstatus"];
	if(!isset($_POST["sstatus"])){$sstatus = "pe";}
	?>
    <form action="special_deposit_report.php" method="post">
    From: <input name="datef" type="text" id="datef" value="<? echo $from ?>" size="15" readonly="readonly" /> 
    
    To: <input name="datet" type="text" id="datet" value="<? echo $to ?>" size="15" readonly="readonly" /> 
    
    Player: <input name="player" type="text" id="player" size="15" value="<? echo $player ?>" /> 
    
    Method: 
    
    <? 
	$all_option = true;
	$current_method = $method;
	include "includes/special_methods_list.php" 
	?>
    
    Status: 
    <select name="sstatus" id="sstatus">
      <option value="">All</option>
      <option value="ac" <? if($sstatus == "ac"){echo 'selected="selected"';} ?>>Accepted</option>
      <option value="de" <? if($sstatus == "de"){echo 'selected="selected"';} ?>>Deniedd</option>
      <option value="pe" <? if($sstatus == "pe"){echo 'selected="selected"';} ?>>Pending</option>
    </select>
    
    <input type="submit" value="Search" />
    </form>
    <br /><br />
    
    
	<? include "includes/print_error.php" ?>    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="table_header" align="center">Id</td>
        <td class="table_header" align="center">Player</td>
        <td class="table_header" align="center">Amount</td>
        <td class="table_header" align="center">Method</td>
        <td class="table_header" align="center">Date</td>
        <td class="table_header" align="center">Comment</td>
        <td class="table_header" align="center">Insterted</td>
        <td class="table_header" align="center">Status</td>
        <td class="table_header" align="center"></td>
      </tr>
      <?
	  $i=0;
	   $methods = search_special_deposits($from, $to, $player, $method, $sstatus);
	   foreach($methods as $mt){
		   if($i % 2){$style = "1";}else{$style = "2";}
		   $i++;
	  ?>
      <tr>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->vars["id"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->vars["player"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center">$<? echo $mt->vars["amount"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->vars["method"]->vars["name"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->vars["ddate"]; ?></td>
        <td class="table_td<? echo $style ?>" align="center" title="<? echo $mt->vars["comment"]; ?>">
			<? echo small_text($mt->vars["comment"],40); ?>
        </td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->str_inserted(); ?></td>
        <td class="table_td<? echo $style ?>" align="center"><? echo $mt->str_status(); ?></td>
        <td class="table_td<? echo $style ?>" align="center">
        	<a href="special_deposit.php?detail&amp;dep=<? echo $mt->vars["id"]; ?>" class="normal_link">Edit</a>
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
        <td class="table_last"></td>
      </tr>
  
    </table>

</div>
<? include "../includes/footer.php" ?>
<? }else{echo "Access Denied";} ?>